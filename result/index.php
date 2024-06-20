<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
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
    <?php include '../navbar.html'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Machine Learning Results</h1>
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <form id="mlForm" action="run_model.php" method="get">
                    <div class="form-group">
                        <label for="mlAlgorithm">Choose Machine Learning Algorithm</label>
                        <select class="form-control" id="mlAlgorithm" name="algorithm">
                            <option value="decision_tree">Decision Tree</option>
                            <option value="knn">KNN</option>
                            <option value="svm">SVM</option>
                            <option value="neural_network">Neural Network</option>
                            <option value="model_comparison">Model Comparison</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Run</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
