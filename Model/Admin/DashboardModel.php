<?php
include '../../../controller/koneksi/config.php';
$sqlSurvey = "SELECT COUNT(*) as total_survey, MONTH(tanggal_survey) as month FROM (SELECT tanggal_survey FROM survey_kepuasan UNION ALL SELECT tanggal_survey FROM survey_kepuasan_keberatan) AS combined_survey GROUP BY MONTH(tanggal_survey)";
$resultSurvey = $conn->query($sqlSurvey);

$dataSurvey = array_fill(0, 12, 0); 
while ($rowSurvey = $resultSurvey->fetch_assoc()) {
    $dataSurvey[$rowSurvey['month'] - 1] = $rowSurvey['total_survey'];
}
$sqlPermohonan = "SELECT COUNT(*) as total_permohonan, MONTH(tanggal_permohonan) as month FROM permohonan_informasi GROUP BY MONTH(tanggal_permohonan)";
$resultPermohonan = $conn->query($sqlPermohonan);

$dataPermohonan = array_fill(0, 12, 0); 

while ($rowPermohonan = $resultPermohonan->fetch_assoc()) {
    $dataPermohonan[$rowPermohonan['month'] - 1] = $rowPermohonan['total_permohonan'];
}
$sqlKeberatan = "SELECT COUNT(*) as total_keberatan, MONTH(tanggal_pengajuan) as month FROM pengajuan_keberatan GROUP BY MONTH(tanggal_pengajuan)";
$resultKeberatan = $conn->query($sqlKeberatan);

$dataKeberatan = array_fill(0, 12, 0); 
while ($rowKeberatan = $resultKeberatan->fetch_assoc()) {
    $dataKeberatan[$rowKeberatan['month'] - 1] = $rowKeberatan['total_keberatan'];
}

$sqlVerifikasiPermohonan = "SELECT COUNT(*) as total_Verifikasipermohonan, MONTH(tanggal_verifikasi) as month FROM verifikasi_permohonan GROUP BY MONTH(tanggal_verifikasi)";
$resultVerifikasiPermohonan = $conn->query($sqlVerifikasiPermohonan);

$dataVerifikasiPermohonan = array_fill(0, 12, 0); 

while ($rowVerifikasiPermohonan = $resultVerifikasiPermohonan->fetch_assoc()) {
    $dataVerifikasiPermohonan[$rowVerifikasiPermohonan['month'] - 1] = $rowVerifikasiPermohonan['total_Verifikasipermohonan'];
}

$sqlVerifikasiPermohonanKeberatan = "SELECT COUNT(*) as total_VerifikasipermohonanKeberatan, MONTH(tanggal_verifikasi) as month FROM verifikasi_keberatan GROUP BY MONTH(tanggal_verifikasi)";
$resultVerifikasiPermohonanKeberatan = $conn->query($sqlVerifikasiPermohonanKeberatan);

$dataVerifikasiPermohonanKeberatan = array_fill(0, 12, 0); 

while ($rowVerifikasiPermohonanKeberatan = $resultVerifikasiPermohonanKeberatan->fetch_assoc()) {
    $dataVerifikasiPermohonanKeberatan[$rowVerifikasiPermohonanKeberatan['month'] - 1] = $rowVerifikasiPermohonanKeberatan['total_VerifikasipermohonanKeberatan'];
}

?>