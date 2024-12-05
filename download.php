<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filepath = __DIR__ . "/" . $file;

    if (file_exists($filepath)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        echo "File not found!";
    }
} else {
    echo "No file specified!";
}
?>
