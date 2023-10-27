<?php
date_default_timezone_set('Asia/Jakarta');
session_start();

if ($_POST['user-input'] !== $_SESSION['captcha']) {
    $response = array("success" => false, "error" => "CAPTCHA tidak sesuai. Silakan coba lagi.");
    echo json_encode($response);
    exit();
}

include('../koneksi/config.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomer_registrasi = $_SESSION['nomer_registrasi'];
    $nama_depan = $_SESSION['nama_depan'];
    $nama_belakang = $_SESSION['nama_belakang'];
    $usia = $_POST['usia'];
    $pendidikan_terakhir = $_POST['pendidikanterakhir'];
    $pekerjaan = $_POST['pekerjaan'];
    $jenis_layanan = implode(", ", $_POST['jenis_layanan']);
    $cara_mendapatkan_informasi = $_POST['caramendapatkaninformasi'];
    $cara_mendapatkan_salinan = $_POST['caramendapatkansalinan'];

    $sql = "INSERT INTO survey_kepuasan (nomer_registrasi, nama_pengguna, usia, pendidikan_terakhir, pekerjaan, jenis_layanan, mendapatkan_informasi, mendapatkan_salinan)
    VALUES ('$nomer_registrasi','$nama_depan $nama_belakang', '$usia', '$pendidikan_terakhir', '$pekerjaan', '$jenis_layanan', '$cara_mendapatkan_informasi', '$cara_mendapatkan_salinan')";

    if ($conn->query($sql) === TRUE) {
        $response = array("success" => true);
        echo json_encode($response);
    } else {
        $response = array("success" => false, "error" => $conn->error);
        echo json_encode($response);
    }
    $conn->close();
}
?>