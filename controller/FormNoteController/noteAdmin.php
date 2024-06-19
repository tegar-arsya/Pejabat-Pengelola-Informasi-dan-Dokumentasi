<?php
// Include konfigurasi koneksi database

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
include('../../../controller/koneksi/config.php');
require_once __DIR__ . '/../../vendor/autoload.php';
// Fungsi logActivity
function logActivity($adminUsername, $action, $description) {
    $logger = getLogger();
    $logger->info($action, ['admin' => $adminUsername, 'description' => $description]);
}

// Fungsi getLogger
function getLogger() {
    $log = new Logger('activity_log');
    $log->pushHandler(new StreamHandler(__DIR__ . '/../../Model/Logs/activity.log', Logger::INFO));
    return $log;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'];
    $namaPemohon = $_POST['nama'];
    $nomerRegistrasiKeberatan = $_POST['norek'];
    $id_permohonan = $_POST['id_permohonan'];
    // Siapkan query untuk menyimpan data ke database
    $insertQuery = "INSERT INTO note_admin (id_permohonan_keberatan, nomer_registrasi_keberatan, keterangan, status ) VALUES (?, ?,  ?, ?, ?)";
    
    // Persiapkan statement
    $stmt = $conn->prepare($insertQuery);

    // Bind parameter ke statement
    $stmt->bind_param("sssss",$id_permohonan, $nomerRegistrasiKeberatan, $keterangan, $status );

    // Eksekusi statement untuk menyimpan data
    if ($stmt->execute()) {
        // Tutup statement
        $stmt->close();

        // Arahkan kembali ke halaman ../view/detailK
        header("Location: ../../../view/Admin/DaftarPermohonan/daftarK");
        $adminUsername = $_SESSION['nama_pengguna'];
                logActivity($adminUsername,'Note', "telah memberikan note Keberatan informasi pemohon dengan nama $namaPemohon dengan nomer registrasi $nomerRegistrasiKeberatan pada tanggal $keterangan dengan status $status ");
        exit(); // Pastikan untuk keluar dari skrip setelah mengarahkan header
    } else {
        echo "Gagal menyimpan data: " . $stmt->error;
    }
}

// Tutup koneksi database
$conn->close();
?>
