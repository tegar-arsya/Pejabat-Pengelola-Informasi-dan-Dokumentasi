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
        // Query untuk mendapatkan nomor registrasi dari tabel permohonan informasi
        $query = "SELECT p.id_registrasi, p.nomer_registrasi, p.nama_pengguna, r.id, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi
                  FROM registrasi r
                  JOIN permohonan_informasi p ON p.id_registrasi = r.id
                  WHERE p.id = ?";
        
        // Persiapkan statement
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            echo "Error: " . $this->conn->error;
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
                $nomorRegistrasi = $row['nomer_registrasi'];

                // Query untuk menyimpan verifikasi permohonan
                $insertQuery = "INSERT INTO verifikasi_permohonan (id_permohonan, id_admin, nomer_registrasi) VALUES (?, ?, ?)";
                $stmtInsert = $this->conn->prepare($insertQuery);

                if (!$stmtInsert) {
                    echo "Error: " . $this->conn->error;
                    $stmt->close();
                    return;
                }

                // Bind parameter ke statement insert
                $stmtInsert->bind_param("iis", $idPermohonan, $idAdmin, $nomorRegistrasi);

                // Eksekusi statement insert
                if ($stmtInsert->execute()) {
                    echo $nomorRegistrasi; // Outputkan nomor registrasi jika berhasil
                } else {
                    echo "Error: " . $stmtInsert->error;
                }

                $stmtInsert->close();
            } else {
                echo "Error: Nomor registrasi tidak ditemukan.";
            }
        } else {
            echo "Error: " . $stmt->error;
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
    echo "Error: ID permohonan atau ID admin tidak valid.";
}
?>
