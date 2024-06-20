<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Comparison Results</title>
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
        pre {
            color: #ffffff;
            background-color: #2c2c2c;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include '../navbar.html'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Model Comparison Results</h1>
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Comparison Histogram</h2>
                <br>
                
                <img src="../hasil/model_comparison.png" class="img-fluid" alt="Confusion">
                    
                    

                
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core/2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.amazonaws.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
