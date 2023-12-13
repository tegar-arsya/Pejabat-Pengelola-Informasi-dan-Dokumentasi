<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['id'];
include('../controller/koneksi/config.php');
if (!isset($_GET['registrasi'])) {
    header("Location: ../components/eror.html");
    exit();
}

$nomer_registrasi = $_GET['registrasi'];
// $nik = $_SESSION['nik'];
$query = "SELECT * FROM verifikasi_permohonan WHERE nomer_registrasi = '$nomer_registrasi'";
$result = $conn->query($query);

// Array untuk menyimpan data timeline
$timelineData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        $tanggal = $row['tanggal_verifikasi']; // Sesuaikan dengan nama kolom di tabel Anda

        // Tambahkan data ke dalam objek timelineData
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggal)), "status" => $status);
    }
}

// Menambahkan data dari notifikasi_pengiriman ke timelineData
$queryNotifikasi = "SELECT * FROM notifikasi_pengiriman WHERE nomer_registrasi = '$nomer_registrasi'";
$resultNotifikasi = $conn->query($queryNotifikasi);

if ($resultNotifikasi->num_rows > 0) {
    while ($rowNotifikasi = $resultNotifikasi->fetch_assoc()) {
        $statusNotifikasi = $rowNotifikasi['status'];
        $tanggalMasukNotifikasi = $rowNotifikasi['tanggal_masuk'];

        // Tambahkan data ke dalam objek timelineData
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggalMasukNotifikasi)), "status" => $statusNotifikasi);
    }
}

$queryJawaban = "SELECT * FROM answer_admin WHERE nomer_registrasi_pemohon = '$nomer_registrasi'";
$resultJawaban = $conn->query($queryJawaban);

if ($resultJawaban->num_rows > 0) {
    while ($rowJawaban = $resultJawaban->fetch_assoc()) {
        $statusJawaban = $rowJawaban['status_balasan'];
        $tanggalMasukJawaban = $rowJawaban['tanggal_jawaban'];

        // Tambahkan data ke dalam objek timelineData
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggalMasukJawaban)), "status" => $statusJawaban);
    }
}
?>