<?php
require_once('../../controller/koneksi/config.php');

class NomorRegistrasiRetriever {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getNomorRegistrasi($idPermohonan) {
        if (isset($idPermohonan)) {
            $query = "SELECT p.id, p.nomer_registrasi,r.id, r.nik, r.no_hp, r.foto_ktp,  r.alamat, r.email,p.nama_pengguna, p.opd_yang_dituju, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi, p.cara_mendapatkan_informasi, p.cara_mendapatkan_salinan, p.tanggal_permohonan
            FROM permohonan_informasi p
            JOIN registrasi r ON p.id_registrasi = r.id
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
