<?php
if (!class_exists('ZipArchive')) {
    echo 'Class ZipArchive not found';
    exit;
}

$source = 'C:/xampp/htdocs/ppid/';
$destination = 'C:/xampp/htdocs/backup/code_backup_' . date('Y-m-d-H-i-s') . '.zip';

$zip = new ZipArchive();
if ($zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    echo 'Failed to create zip file';
    exit;
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($source),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($source));
        $zip->addFile($filePath, $relativePath);
    }
}

$zip->close();

