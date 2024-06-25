<?php
session_start();

require_once('../../controller/koneksi/config.php');
require_once(__DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php'); // Contoh, asumsikan ini adalah PDF generator
require_once __DIR__ . '/../../vendor/autoload.php'; // Contoh, asumsikan ini adalah autoload dari Monolog

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class VerifikasiPermohonan {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function prosesVerifikasi($idPermohonan) {
        if (!isset($idPermohonan) || empty($idPermohonan) || !is_numeric($idPermohonan)) {
            echo "Error: ID permohonan tidak valid.";
            return;
        }

        // Query untuk mendapatkan data permohonan
        $query = "SELECT p.id_registrasi, p.nomer_registrasi, p.nama_pengguna, p.opd_yang_dituju, p.tanggal_permohonan,
                          r.id, r.nik, r.foto_ktp, r.email, r.no_hp, r.alamat, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi
                  FROM registrasi r
                  JOIN permohonan_informasi p ON p.id_registrasi = r.id
                  WHERE p.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idPermohonan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomorRegistrasi = $row['nomer_registrasi'];

            // Query untuk memeriksa apakah sudah terverifikasi sebelumnya
            $cekVerifikasiQuery = "SELECT * FROM verifikasi_permohonan WHERE nomer_registrasi = ?";
            $stmtCek = $this->conn->prepare($cekVerifikasiQuery);
            $stmtCek->bind_param("s", $nomorRegistrasi);
            $stmtCek->execute();
            $resultCek = $stmtCek->get_result();

            if ($resultCek->num_rows > 0) {
                echo "Error: Data dengan nomor registrasi $nomorRegistrasi sudah terverifikasi sebelumnya.";
                return;
            }
            $user_id = $_SESSION['id'];
            // Query untuk menyimpan data verifikasi
            $insertQuery = "INSERT INTO verifikasi_permohonan (id_permohonan,id_admin, nomer_registrasi) VALUES (?, ?,?)";
            $stmtInsert = $this->conn->prepare($insertQuery);
            $stmtInsert->bind_param("iis", $idPermohonan, $user_id, $nomorRegistrasi);

            if ($stmtInsert->execute()) {
                echo $nomorRegistrasi;
                
                // Contoh: Memanggil PDF generator
                include('../../controller/PDFController/pdfGenerate.php');

                // Log aktivitas verifikasi
                $adminUsername = $_SESSION['nama_pengguna'];
                logActivity($adminUsername, 'verifikasi', "Meverifikasi Permohonan Informasi dengan nomor registrasi $nomorRegistrasi");
            } else {
                echo "Error: Gagal menyimpan verifikasi.";
                // Tambahan: Tampilkan error spesifik dari statement jika perlu
            }
        } else {
            echo "Error: Nomor registrasi tidak ditemukan.";
        }
    }
}

// Membuat objek VerifikasiPermohonan
$verifikasi = new VerifikasiPermohonan($conn);

// Memproses verifikasi jika ada ID permohonan yang diberikan
if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];
    $verifikasi->prosesVerifikasi($idPermohonan);
}

// Fungsi logActivity untuk mencatat aktivitas
function logActivity($adminUsername, $action, $description) {
    $logger = getLogger();
    $logger->info($action, ['admin' => $adminUsername, 'description' => $description]);
}

// Fungsi untuk mendapatkan logger Monolog
function getLogger() {
    $log = new Logger('activity_log');
    $log->pushHandler(new StreamHandler(__DIR__ . '/../../Model/Logs/activity.log', Logger::INFO));
    return $log;
}
?>
