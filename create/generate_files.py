import sys
import os
import pandas as pd
import joblib
import matplotlib.pyplot as plt
from sklearn.preprocessing import StandardScaler
from sklearn.model_selection import train_test_split, GridSearchCV
from sklearn.tree import DecisionTreeClassifier
from sklearn.neighbors import KNeighborsClassifier
from sklearn.svm import SVC
from sklearn.neural_network import MLPClassifier
from sklearn.metrics import classification_report, confusion_matrix, ConfusionMatrixDisplay
from imblearn.over_sampling import SMOTE
from sklearn.experimental import enable_halving_search_cv # noqa
from sklearn.model_selection import HalvingGridSearchCV
import seaborn as sns

if len(sys.argv) < 4:
    print("Usage: generate_files.py <csv_file> <features> <label>")
    sys.exit(1)

csv_file = sys.argv[1]
features = sys.argv[2].split(',')
label = sys.argv[3]

# Load dataset
df = pd.read_csv(csv_file)

# Select features and label
X = df[features]
y = df[label]

# Handle class imbalance using SMOTE
oversample = SMOTE(k_neighbors=5)
X_smote, y_smote = oversample.fit_resample(X, y)

# Split dataset into training and testing sets
X_train_smote, X_test_smote, y_train_smote, y_test_smote = train_test_split(X_smote, y_smote, test_size=0.3, random_state=0)


# Standardize features
scaler = StandardScaler()
X_train_scaled = scaler.fit_transform(X_train_smote)
X_test_scaled = scaler.transform(X_test_smote)

# Save scaler
scaler_dir = '../model'
os.makedirs(scaler_dir, exist_ok=True)
joblib.dump(scaler, os.path.join(scaler_dir, 'scaler.sav'))

# Function to train model, save model, confusion matrix, and classification report
def train_and_save_model(classifier, param_grid, model_name):
    model = HalvingGridSearchCV(classifier, param_grid, scoring='recall_micro', cv=5, refit=True, verbose=3)
    model.fit(X_train_scaled, y_train_smote)
    
    # Save the model
    model_path = os.path.join(scaler_dir, f'{model_name}.sav')
    joblib.dump(model.best_estimator_, model_path)
    
    # Predict and generate confusion matrix
    predictions = model.predict(X_test_scaled)
    cm = confusion_matrix(y_test_smote, predictions, labels=model.classes_)
    disp = ConfusionMatrixDisplay(confusion_matrix=cm, display_labels=model.classes_)
    disp.plot()
    
    # Save confusion matrix plot
    cm_path = f'../hasil/confusion_matrix_{model_name}.png'
    os.makedirs('hasil', exist_ok=True)
    plt.savefig(cm_path)
    plt.clf()
    
    # Save classification report
    report = classification_report(y_test_smote, predictions, output_dict=True)
    report_df = pd.DataFrame(report).transpose()
    report_path = f'../hasil/classification_report_{model_name}.csv'
    report_df.to_csv(report_path)
    
    # Save predictions
    predictions_df = pd.DataFrame(predictions, columns=['Prediction'])
    predictions_path = f'../hasil/hasil_{model_name}.csv'
    predictions_df.to_csv(predictions_path, index=False)
    
    print(f"Files generated for {model_name}: {model_path}, {cm_path}, {report_path}, {predictions_path}")

# Train Decision Tree
dt_param_grid = {
    'criterion': ['gini', 'entropy'],
    'max_depth': [5, 10, 15, None],
    'min_samples_split': [0.1, 1.0, 10],
    'min_samples_leaf': [0.1, 0.5, 5]
}
train_and_save_model(DecisionTreeClassifier(), dt_param_grid, 'modeldecisiontree')

# Train KNN
knn_param_grid = {
    'n_neighbors': [3, 5, 7, 9, 11, 13, 15],
    'metric': ['euclidean', 'manhattan', 'chebyshev', 'minkowski', 'wminkowski', 'seuclidean']
}
train_and_save_model(KNeighborsClassifier(), knn_param_grid, 'modelknn')

# Train SVM
svm_param_grid = {
    'C': [1, 10, 100, 1000],
    'gamma': [0.01, 0.001, 0.0001],
    'kernel': ['rbf']
}
train_and_save_model(SVC(), svm_param_grid, 'modelsvm')

# Train Neural Network
nn_param_grid = {
    'hidden_layer_sizes': [(10,), (15, 10)],
    'max_iter': [200],
    'activation': ['relu', 'tanh', 'logistic'],
    'solver': ['adam']
}
train_and_save_model(MLPClassifier(), nn_param_grid, 'modelnn')

# Save test dataset without labels
test_df = pd.DataFrame(X_test_scaled, columns=features)
test_df.to_csv('dataset/test_dataset.csv', index=False)

# Model comparison
models = {
    'Decision Tree': DecisionTreeClassifier(),
    'SVM': SVC(),
    'K-NN': KNeighborsClassifier(),
    'Neural Network': MLPClassifier(max_iter=200)
}

param_grid = {
    'K-NN': {'n_neighbors': [3, 5, 7, 9, 11, 13, 15], 'metric': ['euclidean', 'manhattan', 'chebyshev', 'minkowski', 'wminkowski', 'seuclidean']},
    'SVM': {'C': [1, 10, 100, 1000], 'gamma': [0.01, 0.001, 0.0001], 'kernel': ['rbf']},
    'Decision Tree': {'criterion': ['gini', 'entropy'], 'max_depth': [5, 10, 15, None], 'min_samples_split': [0.1, 1.0, 10], 'min_samples_leaf': [0.1, 0.5, 5]},
    'Neural Network': {'hidden_layer_sizes': [(10,), (25, 15)], 'activation': ['relu', 'tanh', 'logistic'], 'solver': ['adam']}
}

best_estimators = {}
for model_name in models:
    print(f'Training {model_name}...')
    grid_search = GridSearchCV(models[model_name], param_grid[model_name], scoring='recall', cv=5, refit=True, verbose=3)
    grid_search.fit(X_train_scaled, y_train_smote)
    best_estimators[model_name] = grid_search.best_estimator_
    print(f'Best parameters for {model_name}: {grid_search.best_params_}')

# Evaluate models
def evaluate_model(model, X_test, y_test):
    y_pred = model.predict(X_test)
    return {
        'accuracy': accuracy_score(y_test, y_pred),
        'precision': precision_score(y_test, y_pred),
        'recall': recall_score(y_test, y_pred),
        'f1_score': f1_score(y_test, y_pred)
    }

evaluation_results = {}
for model_name, model in best_estimators.items():
    evaluation_results[model_name] = evaluate_model(model, X_test_scaled, y_test_smote)

# Save evaluation results
with open('hasil/evaluation_results.txt', 'w') as file:
    for model_name, metrics in evaluation_results.items():
        file.write(f"Evaluation results for {model_name}:\n")
        for metric_name, value in metrics.items():
            file.write(f"  {metric_name}: {value:.4f}\n")

# Plot model comparison
plot_data = []
for model_name, metrics in evaluation_results.items():
    for metric_name, value in metrics.items():
        plot_data.append({'Model': model_name, 'Metric': metric_name, 'Score': value})

plot_df = pd.DataFrame(plot_data)

plt.figure(figsize=(10, 6))
sns.barplot(data=plot_df, x='Model', y='Score', hue='Metric')
plt.title('Model Comparison')
plt.ylabel('Score')
plt.ylim(0, 1)
plt.legend(loc='best')
plt.savefig('../hasil/model_comparison.png')

print("Files generated successfully: scaler.sav, modeldecisiontree.sav, modelknn.sav, modelsvm.sav, modelnn.sav, test_dataset.csv, confusion_matrix_*.png, classification_report_*.csv, evaluation_results.txt, model_comparison.png")










# Load dataset
df = pd.read_csv(csv_file)

# Select features and label
X = df[features]
y = df[label]

# Handle class imbalance using SMOTE
oversample = SMOTE(k_neighbors=5)
X_smote, y_smote = oversample.fit_resample(X, y)

# Split dataset into training and testing sets
X_train_smote, X_test_smote, y_train_smote, y_test_smote = train_test_split(X_smote, y_smote, test_size=0.3, random_state=0)

# Standardize features
scaler = StandardScaler()
X_train_scaled = scaler.fit_transform(X_train_smote)
X_test_scaled = scaler.transform(X_test_smote)

# Save scaler
scaler_dir = '../model'
os.makedirs(scaler_dir, exist_ok=True)
joblib.dump(scaler, os.path.join(scaler_dir, 'scaler.sav'))

# Function to train model, save model, confusion matrix, and classification report
def train_and_save_model(classifier, param_grid, model_name):
    model = HalvingGridSearchCV(classifier, param_grid, scoring='recall_micro', cv=5, refit=True, verbose=3)
    model.fit(X_train_scaled, y_train_smote)
    
    # Save the model
    model_path = os.path.join(scaler_dir, f'{model_name}.sav')
    joblib.dump(model.best_estimator_, model_path)
    
    # Predict and generate confusion matrix
    predictions = model.predict(X_test_scaled)
    cm = confusion_matrix(y_test_smote, predictions, labels=model.classes_)
    disp = ConfusionMatrixDisplay(confusion_matrix=cm, display_labels=model.classes_)
    disp.plot()
    
    # Save confusion matrix plot
    cm_path = f'../hasil/confusion_matrix_{model_name}.png'
    os.makedirs('hasil', exist_ok=True)
    plt.savefig(cm_path)
    plt.clf()
    
    # Save classification report
    report = classification_report(y_test_smote, predictions, output_dict=True)
    report_df = pd.DataFrame(report).transpose()
    report_path = f'../hasil/classification_report_{model_name}.csv'
    report_df.to_csv(report_path)
    
    print(f"Files generated for {model_name}: {model_path}, {cm_path}, {report_path}")

# Train Decision Tree
dt_param_grid = {
    'criterion': ['gini', 'entropy'],
    'max_depth': [5, 10, 15, None],
    'min_samples_split': [0.1, 1.0, 10],
    'min_samples_leaf': [0.1, 0.5, 5]
}
train_and_save_model(DecisionTreeClassifier(), dt_param_grid, 'modeldecisiontree')

# Train KNN
knn_param_grid = {
    'n_neighbors': [3, 5, 7, 9, 11, 13, 15],
    'metric': ['euclidean', 'manhattan', 'chebyshev', 'minkowski', 'wminkowski', 'seuclidean']
}
train_and_save_model(KNeighborsClassifier(), knn_param_grid, 'modelknn')

# Train SVM
svm_param_grid = {
    'C': [1, 10, 100, 1000],
    'gamma': [0.01, 0.001, 0.0001],
    'kernel': ['rbf']
}
train_and_save_model(SVC(), svm_param_grid, 'modelsvm')

# Train Neural Network
nn_param_grid = {
    'hidden_layer_sizes': [(10,), (15, 10)],
    'max_iter': [200],
    'activation': ['relu', 'tanh', 'logistic'],
    'solver': ['adam']
}
train_and_save_model(MLPClassifier(), nn_param_grid, 'modelnn')

# Save test dataset without labels
test_df = pd.DataFrame(X_test_scaled, columns=features)
test_df.to_csv('../dataset/test_dataset.csv', index=False)

print("Files generated successfully: scaler.sav, modeldecisiontree.sav, modelknn.sav, modelsvm.sav, modelnn.sav, test_dataset.csv, confusion_matrix_*.png, classification_report_*.csv")
