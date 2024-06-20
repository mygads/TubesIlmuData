<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create File</title>
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
    </style>
</head>
<body>
    <?php include '../navbar.html'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Create File</h1>
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <form id="uploadForm" action="select_features.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fileUpload">Upload Dataset (.csv)</label>
                        <input type="file" class="form-control-file" id="fileUpload" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Upload</button>
                </form>
            </div>
        </div>

        <!-- Download Buttons -->
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Download Files</h2>
                <a href="../model/modeldecisiontree.sav" class="btn btn-secondary btn-block" download>Download Decision Tree Model</a>
                <a href="../model/modelknn.sav" class="btn btn-secondary btn-block" download>Download KNN Model</a>
                <a href="../model/modelsvm.sav" class="btn btn-secondary btn-block" download>Download SVM Model</a>
                <a href="../model/modelnn.sav" class="btn btn-secondary btn-block" download>Download Neural Network Model</a>
                <a href="../dataset/test_dataset.csv" class="btn btn-secondary btn-block" download>Download Test Dataset</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
