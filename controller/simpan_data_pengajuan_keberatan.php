<?php
date_default_timezone_set('Asia/Jakarta');

session_start();

if ($_POST['user-input'] !== $_SESSION['captcha']) {
    $response = array("success" => false, "error" => "CAPTCHA tidak sesuai. Silakan coba lagi.");
    echo json_encode($response);
    exit();
}

include('../koneksi/config.php');

if(isset($_GET['id'])){
    $id_pengguna = $_GET['id'];
    // Lakukan sesuatu dengan $id_pengguna
    echo "ID Pengguna: " . $id_pengguna;
} else {
    // Handle jika parameter id tidak ada dalam URL
    echo "ID Pengguna tidak ditemukan.";
}
?>
