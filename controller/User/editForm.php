<?php
session_start();
include('../../controller/koneksi/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $nomer_registrasi = $_POST['nomer_registrasi'];
    $informasiyangdibutuhkan = $_POST['informasiyangdibutuhkan'];
    $alasanpengguna = $_POST['alasanpengguna'];
    $caramendapatkaninformasi = $_POST['caramendapatkaninformasi'];
    $caramendapatkansalinan = $_POST['caramendapatkansalinan'];

    // Perbarui data di dalam database
    $query = "UPDATE permohonan_informasi SET 
              informasi_yang_dibutuhkan = '$informasiyangdibutuhkan',
              alasan_pengguna_informasi = '$alasanpengguna',
              cara_mendapatkan_informasi = '$caramendapatkaninformasi',
              cara_mendapatkan_salinan = '$caramendapatkansalinan',
              status = 'update'
              WHERE nomer_registrasi = '$nomer_registrasi'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika perbaruan berhasil
        header("Location: ../../view/daftarRiwayat");
        exit();
    } else {
        // Jika perbaruan gagal
        header("Location: ../error.php");
        exit();
    }
} else {
    // Jika formulir tidak disubmit melalui metode POST, redirect ke halaman error
    header("Location: ../error.php");
    exit();
}
?>
