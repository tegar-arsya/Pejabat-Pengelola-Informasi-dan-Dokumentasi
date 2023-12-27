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

$timelineData = [];

$queryNotifikasi = "SELECT * FROM notifikasi_pengiriman_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$resultNotifikasi = $conn->query($queryNotifikasi);

if ($resultNotifikasi->num_rows > 0) {
    while ($rowNotifikasi = $resultNotifikasi->fetch_assoc()) {
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($rowNotifikasi['tanggal'])), "status" => $rowNotifikasi['status']);
    }
}

$queryJawaban = "SELECT * FROM keberatananswer_admin WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$resultJawaban = $conn->query($queryJawaban);

if ($resultJawaban->num_rows > 0) {
    while ($rowJawaban = $resultJawaban->fetch_assoc()) {
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($rowJawaban['tanggal'])), "status" => $rowJawaban['status_balasan']);
    }
}

$query_check_rejected = "SELECT * FROM tbl_penolakan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$result_check_rejected = $conn->query($query_check_rejected);

$penolakan_ditemukan = false;
if ($result_check_rejected->num_rows > 0) {
    while ($row_check_rejected = $result_check_rejected->fetch_assoc()) {
        $alasan_tolak = $row_check_rejected['note'];
        
        // Tambahkan logika untuk menentukan status "gugur" atau "pending"
        $tanggal_rejected = strtotime($row_check_rejected['tanggal_penolakan']);
        $tiga_hari_sebelumnya = strtotime("-3 days");
        if ($tanggal_rejected < $tiga_hari_sebelumnya) {
            $timelineData[] = array("date" => date('d-m-Y H:i:s', $tanggal_rejected), "status" => 'Permohonan Gugur');
        } else {
            $timelineData[] = array("date" => date('d-m-Y H:i:s', $tanggal_rejected), "status" => 'Pending ' . $alasan_tolak);
        }

        $penolakan_ditemukan = true;
    }
}

if (!$penolakan_ditemukan) {
    $query = "SELECT v.*, s.tanggal_survey 
              FROM verifikasi_keberatan v
              LEFT JOIN survey_kepuasan_keberatan s ON v.nomer_registrasi_keberatan = s.nomer_registrasi_keberatan
              WHERE v.nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi'])), "status" => 'Permohonan informasi Sudah Diverifikasi Oleh Admin.');

            if ($row['status'] === 'Permohonan Selesai') {
                $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($row['tanggal_survey'])), "status" => 'Permohonan Selesai');
            }
        }
    }
}
// Urutkan array berdasarkan tanggal
usort($timelineData, function ($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});
?>