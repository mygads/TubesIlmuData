<?php
if (isset($_GET['algorithm'])) {
    $algorithm = $_GET['algorithm'];
    switch ($algorithm) {
        case 'decision_tree':
            header("Location: result_decision_tree.php");
            break;
        case 'knn':
            header("Location: result_knn.php");
            break;
        case 'svm':
            header("Location: result_svm.php");
            break;
        case 'neural_network':
            header("Location: result_neural_network.php");
            break;
        case 'model_comparison':
            header("Location: result_comparison.php");
            break;
        default:
            echo "Invalid algorithm selected.";
    }
    exit();
} else {
    echo "No algorithm selected.";
}
?>
