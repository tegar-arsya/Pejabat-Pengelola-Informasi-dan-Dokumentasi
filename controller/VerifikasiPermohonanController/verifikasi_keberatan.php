<?php
include('../../controller/koneksi/config.php');

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

// Memastikan hanya menjalankan proses jika ada ID permohonan yang diberikan
if (isset($_POST['id'])) {
    // Validasi bahwa ID permohonan adalah integer positif
    $idPermohonan = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    if ($idPermohonan === false || $idPermohonan <= 0) {
        http_response_code(400); // Bad Request
        echo "Error: ID permohonan tidak valid.";
        exit();
    }

    // Lakukan koneksi database
    $permohonanHandler = new PermohonanHandler($conn);
    $nomorRegistrasiKeberatan = $permohonanHandler->getNomorRegistrasiKeberatan($idPermohonan);

    if ($nomorRegistrasiKeberatan !== false) {
        echo $nomorRegistrasiKeberatan;
    } else {
        http_response_code(404); // Not Found
        echo "Error: Nomor registrasi tidak ditemukan.";
    }
} else {
    http_response_code(400); // Bad Request
    echo "Error: ID permohonan tidak diberikan.";
}

// Tutup koneksi database
$conn->close();
?>
