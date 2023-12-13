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
$nomer_registrasi_keberatan = $_GET['registrasi'];
// $nik = $_SESSION['nik'];
$query = "SELECT * FROM verifikasi_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$result = $conn->query($query);


$timelineData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        $tanggal = $row['tanggal_verifikasi'];
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggal)), "status" => $status);
    }
}
$queryNotifikasi = "SELECT * FROM notifikasi_pengiriman_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$resultNotifikasi = $conn->query($queryNotifikasi);
if ($resultNotifikasi->num_rows > 0) {
    while ($rowNotifikasi = $resultNotifikasi->fetch_assoc()) {
        $statusNotifikasi = $rowNotifikasi['status'];
        $tanggalMasukNotifikasi = $rowNotifikasi['tanggal'];
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggalMasukNotifikasi)), "status" => $statusNotifikasi);
    }
}
$queryJawaban = "SELECT * FROM keberatananswer_admin WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$resultJawaban = $conn->query($queryJawaban);
if ($resultJawaban->num_rows > 0) {
    while ($rowJawaban = $resultJawaban->fetch_assoc()) {
        $statusJawaban = $rowJawaban['status_balasan'];
        $tanggalMasukJawaban = $rowJawaban['tanggal'];
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggalMasukJawaban)), "status" => $statusJawaban);
    }
}
?>