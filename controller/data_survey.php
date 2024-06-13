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
    $id_permohonan = $_POST['id_permohonan'];
    $nomer_registrasi = $_POST['nomer_registrasi'];
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $pendidikan = implode(", ", $_POST['pendidikan']);
    $pekerjaan = implode(", ", $_POST['pekerjaan']);
    $jenis_layanan = implode(", ", $_POST['jenis_layanan']);
    $persyaratan = implode(", ", $_POST['persyaratan']);
    $SaranPersyaratanPermohonanInformasi = $_POST['SaranPersyaratanPermohonanInformasi'];
    $prosedur = implode(", ", $_POST['prosedur']);
    $waktu = implode(", ", $_POST['waktu']);
    $saranwaktu = $_POST['SaranWaktuPermohonanInformasi'];
    $biaya = implode(", ", $_POST['biaya']);
    $saranbiaya = $_POST['SaranBiayaPermohonanInformasi'];
    $hasil = implode(", ", $_POST['hasil']);
    $saranhasil = $_POST['SaranProdukPermohonanInformasi'];
    $kompetensi = implode(", ", $_POST['kompetensi']);
    $sarankompetensi = $_POST['SaranKompetensiPelaksanaPermohonanInformasi'];
    $perilaku = implode(", ", $_POST['perilaku']);
    $saranperilaku = $_POST['SaranPerilakuPelaksanaPermohonanInformasi'];
    $sarana = implode(", ", $_POST['sarana']);
    $saransarana = $_POST['SaranSaranadanPrasaranaPermohonanInformasi'];
    $pelayanan = implode(", ", $_POST['pelayanan_pengaduan']);
    $saranpelayanan = $_POST['SaranPelayananPengaduanPermohonanInformasi'];
    $petugas = implode(", ", $_POST['petugas']);
    $saranpetugas = $_POST['SaranPetugasPermohonanInformasi'];

    $sql = "INSERT INTO survey_kepuasan (id_permohonan, nomer_registrasi, nama_pengguna, usia, pendidikan, pekerjaan, jenis_layanan, persyaratan, 
    SaranPersyaratanPermohonanInformasi, prosedur, waktu, saran_waktu, biaya, saran_biaya, hasil, saran_hasil, kompetensi, saran_kompetensi, perilaku, saran_perilaku,
    sarana, saran_sarana, pelayanan, saran_pelayanan, petugas, saran_petugas)
    VALUES ('$id_permohonan', '$nomer_registrasi', '$nama', '$usia', '$pendidikan', '$pekerjaan', '$jenis_layanan', '$persyaratan', '$SaranPersyaratanPermohonanInformasi', '$prosedur', '$waktu',
    '$saranwaktu', '$biaya', '$saranbiaya', '$hasil',  '$saranhasil', '$kompetensi', '$sarankompetensi', '$perilaku', '$saranperilaku', '$sarana', '$saransarana', '$pelayanan', '$saranpelayanan', '$petugas', '$saranpetugas')";
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