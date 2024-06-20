<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediction Results</title>
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
        table {
            color: #ffffff;
        }
        table th, table td {
            color: #ffffff;
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
            <h1>Prediction Results</h1>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <?php
                if (isset($_GET['filename']) && isset($_GET['model'])) {
                    $filename = $_GET['filename'];
                    $model = $_GET['model'];
                    $hasil = shell_exec("python C:\\xampp\\htdocs\\tubesilmudata\\index\\resulthasil.py " . escapeshellarg("../dataset/" . $filename) . " " . escapeshellarg("../model/" . $model . ".sav") . " " . escapeshellarg("../model/scaler.sav") . " 2>&1");
                    echo "<div class='btn-download'><a href='../hasil/hasil.csv' class='btn btn-success btn-block' download>Download Result</a></div>";
                    echo "<div class='result-block'><pre>$hasil</pre></div>";
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
