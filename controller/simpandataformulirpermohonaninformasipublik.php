<?php

require_once(__DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php');
require_once __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Asia/Jakarta');

session_start();

if ($_POST['user-input'] !== $_SESSION['captcha']) {
    $response = array("success" => false, "error" => "CAPTCHA tidak sesuai. Silakan coba lagi.");
    echo json_encode($response);
    exit();
}

include('../controller/koneksi/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $_SESSION['nik'];
    $nama_depan = $_SESSION['nama_depan'];
    $nama_belakang = $_SESSION['nama_belakang'];
    $opd = $_POST['opd'];
    $informasi = $_POST['informasiyangdibutuhkan'];
    $alasan = $_POST['alasanpengguna'];
    $caraMendapatkaninformasi = $_POST['caramendapatkaninformasi'];
    $caraMendapatkanSalinan = $_POST['caramendapatkansalinan'];

    $sql = "INSERT INTO permohonan_informasi (id_user, nama_pengguna, opd_yang_dituju, informasi_yang_dibutuhkan, alasan_pengguna_informasi, cara_mendapatkan_informasi, cara_mendapatkan_salinan) 
            VALUES ('$nik', '$nama_depan $nama_belakang', '$opd', '$informasi', '$alasan', '$caraMendapatkaninformasi', '$caraMendapatkanSalinan')";
    if ($conn->query($sql) === TRUE) {
        // Operasi INSERT INTO berhasil, sekarang ambil data dari tabel untuk membuat PDF

        // Query untuk mengambil data dari tabel permohonan_informasi dan registrasi
        $query = "SELECT p.id_user, r.nomer_registrasi, r.nik, r.no_hp, r.foto_ktp, r.alamat, r.email, r.nama_depan, r.nama_belakang, r.kota_kabupaten, r.provinsi, r.kode_pos, r.pekerjaan, p.opd_yang_dituju, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi, p.cara_mendapatkan_informasi, p.cara_mendapatkan_salinan, p.tanggal_permohonan
FROM permohonan_informasi p
JOIN registrasi r ON p.id_user = r.nik
WHERE p.id_user = $nik";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Data dari tabel registrasi
                $namaDepan = $row['nama_depan']; // Kolom ini mungkin harus disesuaikan dengan nama kolom yang sesuai di tabel registrasi
                $namaBelakang = $row['nama_belakang'];
                $email = $row['email'];
                $noHp = $row['no_hp'];
                $alamat = $row['alamat'];
                $kota = $row['kota_kabupaten'];
                $provinsi = $row['provinsi'];
                $kodepos = $row['kode_pos'];
                $pekerjaan = $row['pekerjaan'];
                $nik = $row['nik'];
                $identitas = $row['foto_ktp'];
                // Data dari tabel permohonan_informasi
                $opd = $row['opd_yang_dituju'];
                $informasi = $row['informasi_yang_dibutuhkan'];
                $alasan = $row['alasan_pengguna_informasi'];
                $caraMendapatkaninformasi = $row['cara_mendapatkan_informasi'];
                $caraMendapatkanSalinan = $row['cara_mendapatkan_salinan'];

            }
        }

        // Buat instance TCPDF
        $pdf = new TCPDF();
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        // Isi PDF dengan data
        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 10, 'Formulir Permohonan Informasi', 0, 1, 'C');
        $pdf->SetFont('times', '', 12);
        $pdf->MultiCell(0, 10, 'Nama Depan: ' . $namaDepan, 0, 'L');
        $pdf->MultiCell(0, 10, 'Nama Belakang: ' . $namaBelakang, 0, 'L');
        $pdf->MultiCell(0, 10, 'Email: ' . $email, 0, 'L');
        $pdf->MultiCell(0, 10, 'No. HP: ' . $noHp, 0, 'L');
        $pdf->MultiCell(0, 10, 'Alamat: ' . $alamat . ', ' . $kota . ', ' . $provinsi . ', ' . $kodepos, 0, 'L');
        $pdf->MultiCell(0, 10, 'Pekerjaan: ' . $pekerjaan, 0, 'L');
        $pdf->MultiCell(0, 10, 'NIK: ' . $nik, 0, 'L');
        $pdf->MultiCell(0, 10, 'OPD yang dituju: ' . $opd, 0, 'L');
        $pdf->MultiCell(0, 10, 'Informasi yang Dibutuhkan: ' . $informasi, 0, 'L');
        $pdf->MultiCell(0, 10, 'Alasan Pengguna Informasi: ' . $alasan, 0, 'L');
        $pdf->MultiCell(0, 10, 'Cara Mendapatkan Informasi: ' . $caraMendapatkaninformasi, 0, 'L');
        $pdf->MultiCell(0, 10, 'Cara Mendapatkan Salinan: ' . $caraMendapatkanSalinan, 0, 'L');

        
        $pdfFileName = 'form_Permohonan_Informasi_' . date('YmdHis') . '.pdf';
        $pdfFilePath = __DIR__ . '/../Assets/files/' . $pdfFileName;
        $pdf->Output($pdfFilePath, 'F');

        $response = array("success" => true, "pdfFileName" => $pdfFileName);
        echo json_encode($response);
    } else {
        $response = array("success" => false, "error" => "Data tidak ditemukan");
        echo json_encode($response);
    }
    $conn->close();
}
?>