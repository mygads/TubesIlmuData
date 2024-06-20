import sys
import pandas as pd
import joblib
from sklearn.preprocessing import StandardScaler
from sklearn.metrics import classification_report

if len(sys.argv) < 4:
    print("Usage: resulthasil.py <filename> <model_file> <scaler_file>")
    sys.exit(1)

# Ambil nama file dari argumen command line
filename = sys.argv[1]
model_file = sys.argv[2]
scaler_file = sys.argv[3]

# Load dataset
df = pd.read_csv(filename)

# Load model and scaler
model = joblib.load(model_file)
scaler = joblib.load(scaler_file)

# Ensure the feature names match
model_features = scaler.feature_names_in_
features = df.columns.intersection(model_features)

if len(features) != len(model_features):
    print("Error: The feature names do not match those that were passed during fit.")
    sys.exit(1)

# Feature scaling
scaled_features = scaler.transform(df[features])

# Prediction
result = model.predict(scaled_features)

# Save result to CSV
hasil = pd.DataFrame(result, columns=['Prediction'])
hasil.to_csv('../hasil/hasil.csv', index=False)

try:
    # Tampilkan hasil dalam format HTML
    df_result = pd.read_csv('../hasil/hasil.csv')
    print(df_result.to_html(classes='table table-striped table-bordered', index=False))
except Exception as e:
    print(f"Error reading result CSV: {e}")
    sys.exit(1)
