<?php
// Buatlah file .htaccess di direktori tempat skrip ini berada dengan konten:
// Order deny,allow
// Deny from all

include('../controller/koneksi/config.php');

class PermohonanHandler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getNomorRegistrasiKeberatan($idPermohonan) {
        $stmt = $this->conn->prepare("SELECT nomer_registrasi_keberatan FROM pengajuan_keberatan WHERE id = ?");
        $stmt->bind_param("i", $idPermohonan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomorRegistrasiKeberatan = $row['nomer_registrasi_keberatan'];
            return $nomorRegistrasiKeberatan;
        } else {
            return false;
        }
    }
}

if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    // Lakukan koneksi database
    $permohonanHandler = new PermohonanHandler($conn);
    $nomorRegistrasiKeberatan = $permohonanHandler->getNomorRegistrasiKeberatan($idPermohonan);

    if ($nomorRegistrasiKeberatan !== false) {
        echo $nomorRegistrasiKeberatan;
    } else {
        echo "Error: Nomor registrasi tidak ditemukan.";
    }
} else {
    echo "Error: ID permohonan tidak valid.";
}

// Tutup koneksi database
$conn->close();
?>
