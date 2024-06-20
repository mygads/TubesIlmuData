<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Features and Label</title>
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
    <div class="container mt-5">
        <h1 class="text-center">Select Features and Label</h1>
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <?php
                if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
                    $upload_dir = '../dataset/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    $uploaded_file = $upload_dir . basename($_FILES['file']['name']);
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaded_file)) {
                        $csv_file = $uploaded_file;
                        $columns = array_map('str_getcsv', file($csv_file))[0];
                    } else {
                        echo 'File upload error.';
                        exit();
                    }
                } else {
                    echo 'No file uploaded or upload error.';
                    exit();
                }
                ?>
                <form id="featureForm" action="process_file.php" method="post">
                    <div class="form-group">
                        <label for="features">Select Features:</label>
                        <select multiple class="form-control" id="features" name="features[]" required>
                            <?php
                            foreach ($columns as $column) {
                                echo "<option value=\"$column\">$column</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="label">Select Label:</label>
                        <select class="form-control" id="label" name="label" required>
                            <?php
                            foreach ($columns as $column) {
                                echo "<option value=\"$column\">$column</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="csv_file" value="<?php echo $csv_file; ?>">
                    <button type="submit" class="btn btn-success btn-block">Process</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
