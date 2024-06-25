<?php
session_start();

require_once('../../controller/koneksi/config.php');
require_once(__DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php'); // Misal, ini PDF generator
require_once __DIR__ . '/../../vendor/autoload.php'; // Misal, ini Monolog

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class PermohonanVerifikasi {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function verifikasiPermohonan($idPermohonan) {
        if (!isset($idPermohonan) || empty($idPermohonan) || !is_numeric($idPermohonan)) {
            echo "Error: ID permohonan tidak valid.";
            return;
        }

        // Query untuk mendapatkan data permohonan keberatan
        $query = "SELECT nama_pemohon, nomer_registrasi_keberatan, tanggal_permohonan, nik_pemohon, foto_ktp, 
                          informasi_yang_diminta, alasan_keberatan, nama, pekerjaan, unggah_surat_kuasa, 
                          opd_yang_dituju, email_pemohon, foto_ktp_pemohon, kode_permohonan_informasi
                  FROM pengajuan_keberatan WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idPermohonan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomorRegistrasiKeberatan = $row['nomer_registrasi_keberatan'];

            // Query untuk memeriksa apakah sudah terverifikasi sebelumnya
            $cekVerifikasiQuery = "SELECT * FROM verifikasi_keberatan WHERE nomer_registrasi_keberatan = ?";
            $stmtCek = $this->conn->prepare($cekVerifikasiQuery);
            $stmtCek->bind_param("s", $nomorRegistrasiKeberatan);
            $stmtCek->execute();
            $resultCek = $stmtCek->get_result();

            if ($resultCek->num_rows > 0) {
                echo "Error: Data dengan nomor registrasi keberatan $nomorRegistrasiKeberatan sudah terverifikasi sebelumnya.";
            } else {
                // Query untuk menyimpan data verifikasi keberatan
                $user_id = $_SESSION['id'];
                $insertQuery = "INSERT INTO verifikasi_keberatan (id_permohonan_keberatan, id_admin, nomer_registrasi_keberatan)
                                VALUES (?, ?,?)";
                
                $stmtInsert = $this->conn->prepare($insertQuery);
                $stmtInsert->bind_param("iis", $idPermohonan,$user_id, $nomorRegistrasiKeberatan);

                if ($stmtInsert->execute()) {
                    echo $nomorRegistrasiKeberatan;
                    
                    // Contoh: Memanggil PDF generator
                    include('../../controller/PDFController/GeneratePDFkeberatan.php');

                    // Log aktivitas verifikasi
                    $adminUsername = $_SESSION['nama_pengguna'];
                    logActivity($adminUsername, 'verifikasi', "Meverifikasi Keberatan Permohonan Informasi dengan nomor registrasi keberatan $nomorRegistrasiKeberatan");
                } else {
                    echo "Error: Gagal menyimpan verifikasi keberatan.";
                    // Tambahkan penanganan kesalahan jika perlu
                }
            }
        } else {
            echo "Error: Nomor registrasi keberatan tidak ditemukan.";
        }
    }
}

// Memproses verifikasi jika ada ID permohonan yang diberikan
if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    $permohonanVerifikasi = new PermohonanVerifikasi($conn);
    $permohonanVerifikasi->verifikasiPermohonan($idPermohonan);
} else {
    echo "Error: ID permohonan tidak valid.";
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
