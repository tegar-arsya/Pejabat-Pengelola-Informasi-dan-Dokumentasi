<?php
class FileDownloader {
    private $file_path;

    public function __construct($file_path) {
        $this->file_path = $file_path;
    }

    public function download() {
        if (file_exists($this->file_path)) {
            $file_extension = pathinfo($this->file_path, PATHINFO_EXTENSION);
            $content_type = $this->getContentType($file_extension);

            $file_content = file_get_contents($this->file_path);

            $this->outputFileContent($content_type, $file_content);
        } else {
            echo 'File not found.';
        }
    }

    private function getContentType($file_extension) {
        switch ($file_extension) {
            case 'pdf':
                return 'application/pdf';
            case 'txt':
                return 'text/plain';
            case 'doc':
            case 'docx':
                return 'application/msword';
            case 'xls':
            case 'xlsx':
                return 'application/vnd.ms-excel';
            default:
                return 'application/octet-stream';
        }
    }

    private function outputFileContent($content_type, $file_content) {
        header('Content-Type: ' . $content_type);
        echo $file_content;
    }
}

// Usage example:
$file_path = urldecode($_GET['file_path'] ?? ''); // Be sure to validate and sanitize user input.
$fileDownloader = new FileDownloader($file_path);
$fileDownloader->download();
?>
