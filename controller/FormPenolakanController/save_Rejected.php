<?php
include('../../controller/koneksi/config.php');
require_once(__DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php');
require_once __DIR__ . '/../../vendor/autoload.php';

class PermohonanVerifier {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function verifyPermohonan($idPermohonan) {
        $query = "SELECT p.id_registrasi,p.nomer_registrasi, p.nama_pengguna,r.id, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi
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
            $insertQuery = "INSERT INTO verifikasi_permohonan (id_permohonan, nomer_registrasi)
                            VALUES (?, ?)";
            $stmtInsert = $this->conn->prepare($insertQuery);
            $stmtInsert->bind_param("is",$idPermohonan, $nomorRegistrasi);

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
