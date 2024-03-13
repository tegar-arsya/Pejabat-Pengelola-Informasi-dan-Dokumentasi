<?php


date_default_timezone_set('Asia/Jakarta');

session_start();

if ($_POST['user-input'] !== $_SESSION['captcha']) {
    $response = array("success" => false, "error" => "CAPTCHA tidak sesuai. Silakan coba lagi.");
    echo json_encode($response);
    exit();
}

include('../controller/koneksi/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $_SESSION['nik'];
    $nama_depan = $_SESSION['nama_depan'];
    $nama_belakang = $_SESSION['nama_belakang'];
    $opd = $_POST['opd'];
    $informasi = $_POST['informasiyangdibutuhkan'];
    $alasan = $_POST['alasanpengguna'];
    $caraMendapatkaninformasi = $_POST['caramendapatkaninformasi'];
    $caraMendapatkanSalinan = $_POST['caramendapatkansalinan'];

    $sql = "INSERT INTO permohonan_informasi (id_user, nama_pengguna, opd_yang_dituju, informasi_yang_dibutuhkan, alasan_pengguna_informasi, cara_mendapatkan_informasi, cara_mendapatkan_salinan) 
            VALUES ('$nik', '$nama_depan $nama_belakang', '$opd', '$informasi', '$alasan', '$caraMendapatkaninformasi', '$caraMendapatkanSalinan')";
    if ($conn->query($sql) === TRUE) {
        $response = array("success" => true);
        echo json_encode($response);
    } else {
        $response = array("success" => false, "error" => "Data tidak ditemukan");
        echo json_encode($response);
    }
    $conn->close();
}
?>