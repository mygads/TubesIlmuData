<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machine Learning App</title>
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
        .form-control[readonly] {
            color: #000000; /* Warna hitam untuk teks nilai file yang diunggah */
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
        <h1 class="text-center">Machine Learning App</h1>
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fileUpload">Upload Dataset (.csv)</label>
                        <input type="file" class="form-control-file" id="fileUpload" name="file">
                    </div>
                    <div class="form-group">
                        <label for="modelUpload">Upload Model (.sav)</label>
                        <input type="file" class="form-control-file" id="modelUpload" name="model">
                    </div>
                    <div class="form-group">
                        <label for="scalerUpload">Upload Scaler (.sav)</label>
                        <input type="file" class="form-control-file" id="scalerUpload" name="scaler">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Upload</button>
                </form>
            </div>
        </div>
        <!-- <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <form id="mlForm" action="result.php" method="get">
                    <div class="form-group">
                        <label for="filename">Uploaded File Name</label>
                        <input type="text" class="form-control" id="filename" name="filename" readonly>
                    </div>
                    <div class="form-group">
                        <label for="modelfile">Uploaded Model File</label>
                        <input type="text" class="form-control" id="modelfile" name="modelfile" readonly>
                    </div>
                    <div class="form-group">
                        <label for="scalerfile">Uploaded Scaler File</label>
                        <input type="text" class="form-control" id="scalerfile" name="scalerfile" readonly>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Run Machine Learning</button>
                </form>
            </div>
        </div> -->
    </div>

    <script>
        // Set the filename field from URL parameter if available
        function setFilenameFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            const filename = urlParams.get('filename');
            const modelfile = urlParams.get('modelfile');
            const scalerfile = urlParams.get('scalerfile');
            if (filename) {
                document.getElementById('filename').value = filename;
            }
            if (modelfile) {
                document.getElementById('modelfile').value = modelfile;
            }
            if (scalerfile) {
                document.getElementById('scalerfile').value = scalerfile;
            }
        }

        window.onload = setFilenameFromUrl;
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
