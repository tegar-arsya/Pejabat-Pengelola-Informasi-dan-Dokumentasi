<?php
// Include konfigurasi koneksi database
session_start();
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
include('../../controller/koneksi/config.php');
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
    $admin = mysqli_real_escape_string($conn, $_SESSION['id']);
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    $nomerRegistrasiKeberatan = isset($_POST['norek']) ? $_POST['norek'] : '';
    $id_permohonan = isset($_POST['id_permohonan']) ? $_POST['id_permohonan'] : '';

    // Validasi data yang diperlukan
    if (empty($status) || empty($keterangan) || empty($nomerRegistrasiKeberatan) || empty($id_permohonan)) {
        echo "Data tidak lengkap.";
        exit();
    }

    // Siapkan query untuk menyimpan data ke database
    $insertQuery = "INSERT INTO note_admin (id_permohonan_keberatan,id_admin, nomer_registrasi_keberatan, keterangan, status) VALUES (?, ?,?, ?, ?)";
    
    // Persiapkan statement
    $stmt = $conn->prepare($insertQuery);

    if (!$stmt) {
        echo "Gagal mempersiapkan statement: " . $conn->error;
        exit();
    }

    // Bind parameter ke statement
    $stmt->bind_param("iisss", $id_permohonan,$admin, $nomerRegistrasiKeberatan, $keterangan, $status);

    // Eksekusi statement untuk menyimpan data
    if ($stmt->execute()) {
        // Tutup statement
        $stmt->close();

        // Arahkan kembali ke halaman ../view/detailK
        header("Location: ../../view/Admin/DaftarPermohonan/daftarK");
        exit(); // Pastikan untuk keluar dari skrip setelah mengarahkan header
    } else {
        echo "Gagal menyimpan data: " . $stmt->error;
    }
}

// Tutup koneksi database
$conn->close();
?>
