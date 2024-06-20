import sys
import pandas as pd
import joblib
from sklearn.preprocessing import StandardScaler
from sklearn.metrics import accuracy_score, classification_report

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

# Feature scaling
features = df[df.columns[0:12]]
scaled_features = scaler.transform(features)

# Prediction
result = model.predict(scaled_features)

# Save result to CSV
hasil = pd.DataFrame(result, columns=['Prediction'])
hasil.to_csv('../hasil/hasil.csv', index=False)

try:
    df = pd.read_csv('../hasil/hasil.csv')
    print(df.to_html(classes='table table-striped table-bordered', index=False))
except Exception as e:
    print(f"Error reading result CSV: {e}")
    sys.exit(1)