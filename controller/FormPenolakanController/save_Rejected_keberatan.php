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
        $query = "SELECT nomer_registrasi_keberatan,id_permohonan_informasi FROM pengajuan_keberatan WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idPermohonan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomorRegistrasiKeberatan = $row['nomer_registrasi_keberatan'];

            $insertQuery = "INSERT INTO verifikasi_keberatan (id_permohonan_keberatan,nomer_registrasi_keberatan)
                            VALUES ( ?, ?)";
            $stmtInsert = $this->conn->prepare($insertQuery);
            $stmtInsert->bind_param("is",$idPermohonan, $nomorRegistrasiKeberatan);

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
