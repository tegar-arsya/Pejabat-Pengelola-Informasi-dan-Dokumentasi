<?php
$source = 'C:/xampp/htdocs/ppid/';
$zip = new ZipArchive();
$file_name = 'backup_'.date('Ymd').'.zip';
if ($zip->open($file_name, ZipArchive::CREATE) === TRUE) {
    $source = str_replace('\\', '/', realpath($source));
    if (is_dir($source)) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);
            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;
            $file = realpath($file);
            if (is_dir($file) === true) {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            } else if (is_file($file) === true) {
                $zip->addFile($file, str_replace($source . '/', '', $file));
            }
        }
    } else if (is_file($source) === true) {
        $zip->addFile($source, basename($source));
    }
}
$zip->close();
if (file_exists($file_name)) {
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$file_name);
    header('Content-Length: ' . filesize($file_name));
    readfile($file_name);
    unlink($file_name);
}
header('Location: ../view/Admin/UserAdmin/User?success=1');
?>

