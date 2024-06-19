<?php

session_start();
include('../../controller/koneksi/config.php');
require_once(__DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php');
require_once __DIR__ . '/../../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class PermohonanVerifikasi {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function verifikasiPermohonan($idPermohonan) {
        $query = "SELECT nama_pemohon, nomer_registrasi_keberatan,
        tanggal_permohonan, nik_pemohon, foto_ktp, informasi_yang_diminta, alasan_keberatan, nama,
        pekerjaan, unggah_surat_kuasa, opd_yang_dituju, email_pemohon, foto_ktp_pemohon,kode_permohonan_informasi
        FROM pengajuan_keberatan WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idPermohonan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomorRegistrasiKeberatan = $row['nomer_registrasi_keberatan'];

            $cekVerifikasiQuery = "SELECT * FROM verifikasi_keberatan WHERE nomer_registrasi_keberatan = ?";
            $stmtCek = $this->conn->prepare($cekVerifikasiQuery);
            $stmtCek->bind_param("s", $nomorRegistrasiKeberatan);
            $stmtCek->execute();
            $resultCek = $stmtCek->get_result();

            if ($resultCek->num_rows > 0) {
                echo "Error: Data dengan nomor registrasi keberatan $nomorRegistrasiKeberatan sudah terverifikasi sebelumnya.";
            } else {
                $insertQuery = "INSERT INTO verifikasi_keberatan (id_permohonan_keberatan, nomer_registrasi_keberatan)
                                VALUES (?, ?)";
                
                $stmtInsert = $this->conn->prepare($insertQuery);
                $stmtInsert->bind_param("is",$idPermohonan, $nomorRegistrasiKeberatan);


                if ($stmtInsert->execute()) {
                    echo $nomorRegistrasiKeberatan;
                    include('../../controller/PDFController/GeneratePDFkeberatan.php');

                    //log aktivitas verifikasi
                $adminUsername = $_SESSION['nama_pengguna'];
                logActivity($adminUsername,'verifikasi', "SUdah Memverifikasi Keberatan Permohonan Informasi dengan nomer registrasi keberatan $nomorRegistrasiKeberatan");
                } else {
                    echo "Error: " . $stmtInsert->error;
                }
            }
        } else {
            echo "Error: Nomor registrasi keberatan tidak ditemukan.";
        }
    }
}

if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    $permohonanVerifikasi = new PermohonanVerifikasi($conn);
    $permohonanVerifikasi->verifikasiPermohonan($idPermohonan);
} else {
    echo "Error: ID permohonan tidak valid.";
}

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
?>
