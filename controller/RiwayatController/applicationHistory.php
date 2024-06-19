<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../");
    exit();
}
$user_id = $_SESSION['id'];

include('../../../controller/koneksi/config.php');
if (!isset($_GET['Permohonan'])) {
    header("Location: ../../../components/ErorAkses");
    exit();
}

$id_permohonan = $_GET['Permohonan'];

// Array untuk menyimpan data timeline
$timelineData = [];

// Menambahkan data dari notifikasi_pengiriman ke timelineData
$queryNotifikasi = "SELECT * FROM notifikasi_pengiriman WHERE id_permohonan = '$id_permohonan'";
$resultNotifikasi = $conn->query($queryNotifikasi);

if ($resultNotifikasi->num_rows > 0) {
    while ($rowNotifikasi = $resultNotifikasi->fetch_assoc()) {
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($rowNotifikasi['tanggal_masuk'])), "status" => $rowNotifikasi['status']);
    }
}

$queryJawaban = "SELECT * FROM answer_admin WHERE id_permohonan = '$id_permohonan'";
$resultJawaban = $conn->query($queryJawaban);

if ($resultJawaban->num_rows > 0) {
    while ($rowJawaban = $resultJawaban->fetch_assoc()) {
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($rowJawaban['tanggal_jawaban'])), "status" => $rowJawaban['status_balasan']);
    }
}

$query_check_rejected = "SELECT * FROM tbl_rejected WHERE id_permohonan = '$id_permohonan'";
$result_check_rejected = $conn->query($query_check_rejected);

// Jika ada penolakan, tandai sebagai "Pending" atau "Permohonan Gugur"
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
            $timelineData[] = array("date" => date('d-m-Y H:i:s', $tanggal_rejected), "status" => 'Pending ' . "($alasan_tolak)");
        }

        $penolakan_ditemukan = true;
    }
}

// Tambahkan status "Permohonan informasi Sudah Diverifikasi Oleh Admin." jika tidak ditolak
if (!$penolakan_ditemukan) {
    $query = "SELECT v.*, s.tanggal_survey 
              FROM verifikasi_permohonan v
              LEFT JOIN survey_kepuasan s ON v.id_permohonan = s.id_permohonan
              WHERE v.id_permohonan = '$id_permohonan'";
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