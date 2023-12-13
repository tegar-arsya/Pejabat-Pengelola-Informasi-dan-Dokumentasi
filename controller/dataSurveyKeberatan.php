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
    $nomer_registrasi_keberatan = $_POST['nomer_registrasi_keberatan'];
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $notel = $_POST['notel'];
    $jenis_layanan = implode(", ", $_POST['jenis_layanan']);
    $feedback = implode(", ", $_POST['feedback']);
    $saran = $_POST['saran'];
    $sql = "INSERT INTO survey_kepuasan_keberatan (nomer_registrasi_keberatan, email, nama_pengguna, alamat, no_hp, jenis_layanan, feedback, saran)
    VALUES ('$nomer_registrasi_keberatan','$email', '$nama', '$alamat', '$notel', '$jenis_layanan', '$feedback', '$saran')";
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