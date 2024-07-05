<?php
// Mengatur error reporting untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "db_ppid");

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mendapatkan semua tabel dari database
$tables = array();
$result = mysqli_query($koneksi, "SHOW TABLES");

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

// Membuat skrip SQL
$sqlScript = "";
foreach ($tables as $table) {    
    $result = mysqli_query($koneksi, "SHOW CREATE TABLE $table");
    $row = mysqli_fetch_row($result);
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";
    
    $result = mysqli_query($koneksi, "SELECT * FROM $table");
    $columnCount = mysqli_num_fields($result);
    
    for ($i = 0; $i < $columnCount; $i++) {
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j++) {
                $row[$j] = $row[$j];
                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
    $sqlScript .= "\n"; 
}

// Jika skrip SQL tidak kosong, buat file backup
if (!empty($sqlScript)) {    
    $backup_file_name = 'db_ppid_backup_' . time() . '.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler);

    // Menyiapkan header untuk mengunduh file
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file_name));
    
    // Membersihkan dan mem-flush buffer output
    ob_clean();
    flush();
    
    // Membaca file dan mengirimnya ke browser
    readfile($backup_file_name);
    
    // Menghapus file sementara setelah diunduh
    unlink($backup_file_name); 
    header('Location: ../view/Admin/UserAdmin/User?success=1');
    // Keluar dari skrip
    exit;
}
?>
