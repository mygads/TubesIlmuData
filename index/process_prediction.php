<?php
$upload_dir = '../dataset/';
$model_dir = '../model/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}
if (!is_dir($model_dir)) {
    mkdir($model_dir, 0777, true);
}

$file_success = false;
$uploaded_file = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $uploaded_file = $upload_dir . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaded_file)) {
            $file_success = true;
        } else {
            $file_success = false;
        }
    }

    if ($file_success && isset($_POST['model'])) {
        $model = $_POST['model'];
        header("Location: result.php?filename=" . urlencode(basename($_FILES['file']['name'])) . "&model=" . urlencode($model));
        exit();
    } else {
        echo 'File upload error or model not selected.';
    }
} else {
    echo 'Invalid request method.';
}
?>
