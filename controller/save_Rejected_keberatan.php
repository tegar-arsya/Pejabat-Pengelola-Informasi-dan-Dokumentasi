<?php
include('../controller/koneksi/config.php');
require_once(__DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php');
require_once __DIR__ . '/../vendor/autoload.php';

class PermohonanVerifier {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function verifyPermohonan($idPermohonan) {
        $query = "SELECT nama_pemohon, nomer_registrasi_keberatan, 
        tanggal_permohonan, nik_pemohon, foto_ktp, informasi_yang_diminta, alasan_keberatan, nama,
        pekerjaan, unggah_surat_kuasa, opd_yang_dituju
        FROM pengajuan_keberatan WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idPermohonan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomorRegistrasiKeberatan = $row['nomer_registrasi_keberatan'];

            $insertQuery = "INSERT INTO verifikasi_keberatan (nomer_registrasi_keberatan, nama_pemohon, tanggal_permohonan, nik_pemohon, foto_ktp, opd_yang_dituju, informasi_yang_diminta, alasan_keberatan, nama_kuasa, pekerjaan, surat_kuasa, id_permohonan)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = $this->conn->prepare($insertQuery);
            $stmtInsert->bind_param("sssssssssssi", $nomorRegistrasiKeberatan, $row['nama_pemohon'], $row['tanggal_permohonan'], $row['nik_pemohon'], $row['foto_ktp'], $row['opd_yang_dituju'], $row['informasi_yang_diminta'], $row['alasan_keberatan'], $row['nama'], $row['pekerjaan'], $row['unggah_surat_kuasa'], $idPermohonan);

            if ($stmtInsert->execute()) {
                echo $nomorRegistrasiKeberatan;
            } else {
                echo "Error: " . $stmtInsert->error;
            }
        } else {
            echo "Error: Nomor registrasi tidak ditemukan.";
        }

        $stmt->close();
        $stmtInsert->close();
    }
}

if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    $permohonanVerifier = new PermohonanVerifier($conn);
    $permohonanVerifier->verifyPermohonan($idPermohonan);
} else {
    echo "Error: ID permohonan tidak valid.";
}

$conn->close();
?>
