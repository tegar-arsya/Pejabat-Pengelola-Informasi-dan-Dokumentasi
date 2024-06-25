<?php
include('../../controller/koneksi/config.php');
require_once(__DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php');
require_once __DIR__ . '/../../vendor/autoload.php';

class PermohonanVerifier {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function verifyPermohonan($idPermohonan, $idAdmin) {
        // Query untuk memilih nomor registrasi keberatan berdasarkan ID permohonan
        $query = "SELECT nomer_registrasi_keberatan FROM pengajuan_keberatan WHERE id = ?";
        
        // Persiapkan statement
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            echo "Error preparing statement: " . $this->conn->error;
            return;
        }

        // Bind parameter ke statement
        $stmt->bind_param("i", $idPermohonan);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Dapatkan hasil
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nomorRegistrasiKeberatan = $row['nomer_registrasi_keberatan'];

                // Query untuk menyimpan verifikasi keberatan
                $insertQuery = "INSERT INTO verifikasi_keberatan (nomer_registrasi_keberatan, id_permohonan_keberatan, id_admin) VALUES (?, ?, ?)";
                $stmtInsert = $this->conn->prepare($insertQuery);

                if (!$stmtInsert) {
                    echo "Error preparing insert statement: " . $this->conn->error;
                    $stmt->close();
                    return;
                }

                // Bind parameter ke statement insert
                $stmtInsert->bind_param("sii", $nomorRegistrasiKeberatan, $idPermohonan, $idAdmin);

                // Eksekusi statement insert
                if ($stmtInsert->execute()) {
                    echo $nomorRegistrasiKeberatan; // Outputkan nomor registrasi keberatan jika berhasil
                } else {
                    echo "Error executing insert statement: " . $stmtInsert->error;
                }

                $stmtInsert->close();
            } else {
                echo "Error: Nomor registrasi tidak ditemukan.";
            }
        } else {
            echo "Error executing select statement: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    }
}
session_start();
if (isset($_POST['id']) && isset($_SESSION['id'])) {
    $idPermohonan = $_POST['id'];
    $idAdmin = $_SESSION['id'];
    $permohonanVerifier = new PermohonanVerifier($conn);
    $permohonanVerifier->verifyPermohonan($idPermohonan, $idAdmin);
} else {
    echo "Error: ID permohonan tidak valid.";
}
?>
