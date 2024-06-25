<?php
require_once('../../controller/koneksi/config.php');

class NomorRegistrasiRetriever {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getNomorRegistrasi($idPermohonan) {
        // Prepare statement
        $query = "SELECT p.nomer_registrasi
                  FROM permohonan_informasi p
                  JOIN registrasi r ON p.id_registrasi = r.id
                  WHERE p.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idPermohonan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['nomer_registrasi'];
        } else {
            return "Error: Nomor registrasi tidak ditemukan.";
        }
    }
}

// Membuat objek NomorRegistrasiRetriever
$nomorRegistrasiRetriever = new NomorRegistrasiRetriever($conn);

// Mengambil nomor registrasi berdasarkan ID permohonan yang dikirimkan melalui POST
if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];
    $nomorRegistrasi = $nomorRegistrasiRetriever->getNomorRegistrasi($idPermohonan);
    echo $nomorRegistrasi;
} else {
    echo "Error: ID permohonan tidak ditemukan.";
}

// Menutup koneksi basis data
$conn->close();
?>
