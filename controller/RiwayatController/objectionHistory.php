<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../");
    exit();
}
$user_id = $_SESSION['id'];
include('../../../controller/koneksi/config.php');
if (!isset($_GET['PermohonanKeberatan'])) {
    header("Location: ../../../components/ErorAkses");
    exit();
}
$id_permohonan_keberatan = $_GET['PermohonanKeberatan'];
// $nik = $_SESSION['nik'];

$timelineData = [];

// Prepared statement untuk kueri notifikasi
$queryNotifikasi = "SELECT * FROM notifikasi_pengiriman_keberatan WHERE id_permohonan_keberatan = ?";
$stmtNotifikasi = $conn->prepare($queryNotifikasi);
$stmtNotifikasi->bind_param("s", $id_permohonan_keberatan);
$stmtNotifikasi->execute();
$resultNotifikasi = $stmtNotifikasi->get_result();

if ($resultNotifikasi->num_rows > 0) {
    while ($rowNotifikasi = $resultNotifikasi->fetch_assoc()) {
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($rowNotifikasi['tanggal'])), "status" => $rowNotifikasi['status']);
    }
}
$stmtNotifikasi->close();

// Prepared statement untuk kueri jawaban
$queryJawaban = "SELECT * FROM keberatananswer_admin WHERE id_permohonan_keberatan = ?";
$stmtJawaban = $conn->prepare($queryJawaban);
$stmtJawaban->bind_param("s", $id_permohonan_keberatan);
$stmtJawaban->execute();
$resultJawaban = $stmtJawaban->get_result();

if ($resultJawaban->num_rows > 0) {
    while ($rowJawaban = $resultJawaban->fetch_assoc()) {
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($rowJawaban['tanggal'])), "status" => $rowJawaban['status_balasan']);
    }
}
$stmtJawaban->close();

// Prepared statement untuk kueri penolakan
$query_check_rejected = "SELECT * FROM tbl_penolakan WHERE id_permohonan_keberatan = ?";
$stmt_check_rejected = $conn->prepare($query_check_rejected);
$stmt_check_rejected->bind_param("s", $id_permohonan_keberatan);
$stmt_check_rejected->execute();
$result_check_rejected = $stmt_check_rejected->get_result();

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
$stmt_check_rejected->close();

// Prepared statement untuk kueri verifikasi
if (!$penolakan_ditemukan) {
    $query = "SELECT v.*, s.tanggal_survey 
              FROM verifikasi_keberatan v
              LEFT JOIN survey_kepuasan_keberatan s ON v.id_permohonan_keberatan = s.id_permohonan_keberatan
              WHERE v.id_permohonan_keberatan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id_permohonan_keberatan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi'])), "status" => 'Permohonan informasi Sudah Diverifikasi Oleh Admin.');

            if ($row['status'] === 'Permohonan Selesai') {
                $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($row['tanggal_survey'])), "status" => 'Permohonan Selesai');
            }
        }
    }
    $stmt->close();
}

// Urutkan array berdasarkan tanggal
usort($timelineData, function ($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});
?>

