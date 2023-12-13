<?php
// Retrieve the file path from the query parameter
$file_path = urldecode($_GET['file_path']);

// Check if the file exists
if (file_exists($file_path)) {
    // Read the file content
    $file_content = file_get_contents($file_path);

    // Output the file content
    header('Content-Type: application/pdf'); // You may need to adjust the content type based on your file type
    echo $file_content;
} else {
    // Output an error message if the file doesn't exist
    echo 'File not found.';
}
?>
