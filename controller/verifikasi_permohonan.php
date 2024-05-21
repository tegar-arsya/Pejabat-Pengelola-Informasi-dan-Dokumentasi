<?php
require_once('../controller/koneksi/config.php');

class NomorRegistrasiRetriever {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getNomorRegistrasi($idPermohonan) {
        if (isset($idPermohonan)) {
            $query = "SELECT p.nomer_registrasi, p.nama_pengguna, p.opd_yang_dituju, p.tanggal_permohonan, r.nik, r.foto_ktp, r.no_hp, r.alamat, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi
                      FROM registrasi r
                      JOIN permohonan_informasi p ON p.id_user = r.nik
                      WHERE p.id = $idPermohonan";
            $result = $this->conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['nomer_registrasi'];
            } else {
                return "Error: Nomor registrasi tidak ditemukan.";
            }
        } else {
            return "Error: ID permohonan tidak valid.";
        }
    }
}

// Membuat objek NomorRegistrasiRetriever
$nomorRegistrasiRetriever = new NomorRegistrasiRetriever($conn);

// Mengambil nomor registrasi berdasarkan ID permohonan
if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];
    $nomorRegistrasi = $nomorRegistrasiRetriever->getNomorRegistrasi($idPermohonan);
    echo $nomorRegistrasi;
}

// Menutup koneksi basis data
$conn->close();
?>
