<?php
// Retrieve the file path from the query parameter
$file_path = urldecode($_GET['file_path']);

// Check if the file exists
if (file_exists($file_path)) {
    // Determine the file's content type based on its extension
    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

    switch ($file_extension) {
        case 'pdf':
            $content_type = 'application/pdf';
            break;
        case 'txt':
            $content_type = 'text/plain';
            break;
        case 'doc':
        case 'docx':
            $content_type = 'application/msword';
            break;
        case 'xls':
        case 'xlsx':
            $content_type = 'application/vnd.ms-excel';
            break;
        // Add more cases for other file types as needed
        default:
            $content_type = 'application/octet-stream';
    }

    // Read the file content
    $file_content = file_get_contents($file_path);

    // Output the file content with the appropriate content type
    header('Content-Type: ' . $content_type);
    echo $file_content;
} else {
    // Output an error message if the file doesn't exist
    echo 'File not found.';
}
?>
