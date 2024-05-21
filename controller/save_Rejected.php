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
        $query = "SELECT p.nomer_registrasi, p.nama_pengguna, p.opd_yang_dituju, p.tanggal_permohonan, r.nik, r.foto_ktp, r.email, r.no_hp, r.alamat, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi
                  FROM registrasi r
                  JOIN permohonan_informasi p ON p.id_user = r.nik
                  WHERE p.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idPermohonan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomorRegistrasi = $row['nomer_registrasi'];

            $insertQuery = "INSERT INTO verifikasi_permohonan (nomer_registrasi, nama_pengguna, tanggal_permohonan, nik, foto_ktp, email, no_hp, alamat, informasi_yang_dibutuhkan, alasan_pengguna_informasi, id_permohonan, opd_yang_dituju)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = $this->conn->prepare($insertQuery);
            $stmtInsert->bind_param("ssssssssssis", $nomorRegistrasi, $row['nama_pengguna'], $row['tanggal_permohonan'], $row['nik'], $row['foto_ktp'], $row['email'], $row['no_hp'], $row['alamat'], $row['informasi_yang_dibutuhkan'], $row['alasan_pengguna_informasi'], $idPermohonan, $row['opd_yang_dituju']);

            if ($stmtInsert->execute()) {
                echo $nomorRegistrasi;
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
