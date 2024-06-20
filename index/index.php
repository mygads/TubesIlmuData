<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Prediction</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }
        .container {
            background-color: #1f1f1f;
            padding: 20px;
            border-radius: 8px;
        }
        .form-control-file,
        .form-control,
        .btn {
            background-color: #2c2c2c;
            color: #ffffff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-block {
            width: 100%;
        }
        label {
            color: #cccccc;
        }
        pre {
            color: #ffffff;
            background-color: #2c2c2c;
            padding: 10px;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            padding: 10px;
            border-bottom: 1px solid #444;
            margin-bottom: 20px;
        }
        .result-block {
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .btn-download {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .navbar {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include '../navbar.html'; ?>
    <div class="container mt-5">
        <div class="header">
            <h1>Upload File dan Pilih Model</h1>
        </div>
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <form id="uploadForm" action="process_prediction.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fileUpload">Upload Dataset (.csv)</label>
                        <input type="file" class="form-control-file" id="fileUpload" name="file" required>
                    </div>
                    <div class="form-group">
                        <label for="modelSelect">Pilih Model</label>
                        <select class="form-control" id="modelSelect" name="model" required>
                            <option value="modeldecisiontree">Decision Tree</option>
                            <option value="modelknn">KNN</option>
                            <option value="modelsvm">SVM</option>
                            <option value="modelnn">Neural Network</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Prediksi</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <?php
                if (isset($_POST['file']) && isset($_POST['model'])) {
                    $file = $_POST['file'];
                    $model = $_POST['model'];
                    $hasil = shell_exec("python resulthasil.py " . escapeshellarg("uploads/" . $file) . " " . escapeshellarg("model/" . $model . ".sav") . " " . escapeshellarg("model/scaler.sav") . " 2>&1");
                    echo "<div class='result-block'><pre>$hasil</pre></div>";
                    echo "<div class='btn-download'><a href='hasil/hasil.csv' class='btn btn-success btn-block' download>Download Result</a></div>";
                } else {
                    echo "<div class='result-block'>Upload file dan pilih model untuk melihat hasil.</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
