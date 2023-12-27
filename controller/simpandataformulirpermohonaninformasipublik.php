<?php

// require_once(__DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php');
// require_once __DIR__ . '/../vendor/autoload.php';

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
        // $query = "SELECT p.id_user, r.nomer_registrasi, r.nik, r.no_hp, r.foto_ktp, r.alamat, r.email, r.nama_depan, r.nama_belakang, r.kota_kabupaten, r.provinsi, r.kode_pos, r.pekerjaan, p.opd_yang_dituju, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi, p.cara_mendapatkan_informasi, p.cara_mendapatkan_salinan, p.tanggal_permohonan
        // FROM permohonan_informasi p
        // JOIN registrasi r ON p.id_user = r.nik
        // WHERE p.id_user = $nik";
        // $result = $conn->query($query);

        // if ($result->num_rows > 0) {
        //     while ($row = $result->fetch_assoc()) {
        //         // Data dari tabel registrasi
        //         $namaDepan = $row['nama_depan']; // Kolom ini mungkin harus disesuaikan dengan nama kolom yang sesuai di tabel registrasi
        //         $namaBelakang = $row['nama_belakang'];
        //         $email = $row['email'];
        //         $noHp = $row['no_hp'];
        //         $alamat = $row['alamat'];
        //         $kota = $row['kota_kabupaten'];
        //         $provinsi = $row['provinsi'];
        //         $kodepos = $row['kode_pos'];
        //         $pekerjaan = $row['pekerjaan'];
        //         $nik = $row['nik'];
        //         $identitas = $row['foto_ktp'];
        //         // Data dari tabel permohonan_informasi
        //         $opd = $row['opd_yang_dituju'];
        //         $informasi = $row['informasi_yang_dibutuhkan'];
        //         $alasan = $row['alasan_pengguna_informasi'];
        //         $caraMendapatkaninformasi = $row['cara_mendapatkan_informasi'];
        //         $caraMendapatkanSalinan = $row['cara_mendapatkan_salinan'];

        //     }
        // }

        // // Buat instance TCPDF
        // // Buat instance TCPDF
        // $pdf = new TCPDF();
        // $pdf->SetMargins(10, 10, 10);
        // $pdf->AddPage();

        // // Menghitung lebar halaman PDF
        // $lebarHalaman = $pdf->getPageWidth();

        // // Menghitung lebar sel (setengah dari lebar halaman)
        // $lebarSel = $lebarHalaman / 2.2;

        // // Menggunakan nilai lebar sel dalam metode MultiCell

        // // Isi PDF dengan data
        // $pdf->SetFont('times', 'B', 16);
        // // Set ketebalan garis menjadi 0
        // $pdf->SetLineWidth(0);

        // $pdf->Cell(0, 10, 'Formulir Permohonan Informasi', 0, 1, 'C');
        // $pdf->SetFont('times', '', 12);
        // $text = 'Isi Form berikut merupakan Hak anda memperoleh Informasi Publik sesuai UU No 14 Tahun 2008 Tentang Keterbukaan Informasi Publik';
        // $pdf->MultiCell(0, 10, $text, 0, 'L');

        // // Set font untuk label
        // $pdf->SetFont('times', 'B', 12);

        // // Label Nama Depan
        // $pdf->Cell(0, 10, 'Nama Depan', 0, 0, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi Nama Depan dengan border di sekelilingnya
        // // $pdf->MultiCell(0, 10, $namaDepan, 1, 'L');

        // // Label Nama Belakang
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Nama Belakang', 0, 1, 'R');
        // $pdf->SetFont('times', '', 12);
        // // Isi Nama Belakang dengan border di sekelilingnya
        // // $pdf->MultiCell(0, 10, $namaBelakang, 1, 'R');
        // //
        // //
        // // Mengatur posisi x untuk nama depan
        // $xNamaDepan = 10; // Sesuaikan posisi x sesuai kebutuhan
        // $pdf->SetXY($xNamaDepan, $pdf->GetY());
        // $pdf->Cell(0, 10, $namaDepan, 1, 'L');

        // // Mengatur posisi x untuk nama belakang
        // $xNamaBelakang = 105; // Sesuaikan posisi x sesuai kebutuhan
        // $pdf->SetXY($xNamaBelakang, $pdf->GetY() - 10); // Mengatur posisi Y sedikit ke atas agar sejajar dengan nama depan
        // $pdf->Cell(0, 10, $namaBelakang, 1, 'R');

        // $pdf->SetFont('times', 'B', 1);
        // $pdf->Cell(0, 0, '', 0, 0, 'L');
        // $pdf->SetFont('times', '', 1);
        // // Isi Email dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 0, 0, 'L');

        // // Label Email
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Email', 0, 1, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi Email dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 10, $email, 1, 'L');

        // // Label No. HP
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'No. HP', 0, 1, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi No. HP dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 10, $noHp, 1, 'L');

        // // Label Alamat
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Alamat', 0, 1, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi Alamat dengan border di sekelilingnya
        // $pdf->MultiCell(0, 10, $alamat, 1, 'L');

        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Kota', 0, 0, 'L');
        // $pdf->SetFont('times', '', 12);

        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Provinsi', 0, 1, 'R');
        // $pdf->SetFont('times', '', 12);


        // // Isi Nama Belakang dengan border di sekelilingnya
        // // $pdf->MultiCell(0, 10, $namaBelakang, 1, 'R');
        // //
        // //
        // // Mengatur posisi x untuk nama depan
        // $xkota = 10; // Sesuaikan posisi x sesuai kebutuhan
        // $pdf->SetXY($xkota, $pdf->GetY());
        // $pdf->Cell(0, 10, $kota, 1, 'L');

        // // Mengatur posisi x untuk nama belakang
        // $xprovinsi = 105; // Sesuaikan posisi x sesuai kebutuhan
        // $pdf->SetXY($xprovinsi, $pdf->GetY() - 10); // Mengatur posisi Y sedikit ke atas agar sejajar dengan nama depan
        // $pdf->Cell(0, 10, $provinsi, 1, 'R');


        // $pdf->SetFont('times', 'B', 1);
        // $pdf->Cell(0, 0, '', 0, 0, 'L');
        // $pdf->SetFont('times', '', 1);
        // // Isi Email dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 0, 0, 'L');




        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Kode Pos', 0, 0, 'L');
        // $pdf->SetFont('times', '', 12);
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'PNegara', 0, 1, 'R');
        // $pdf->SetFont('times', '', 12);
        // $xpos = 10; // Sesuaikan posisi x sesuai kebutuhan
        // $pdf->SetXY($xpos, $pdf->GetY());
        // $pdf->Cell(0, 10, $kodepos, 1, 'L');
        // $xprovinsii = 105; // Sesuaikan posisi x sesuai kebutuhan
        // $pdf->SetXY($xprovinsii, $pdf->GetY() - 10); // Mengatur posisi Y sedikit ke atas agar sejajar dengan nama depan
        // $pdf->Cell(0, 10, $provinsi, 1, 'R');


        // $pdf->SetFont('times', 'B', 1);
        // $pdf->Cell(0, 0, '', 0, 0, 'L');
        // $pdf->SetFont('times', '', 1);
        // // Isi Email dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 0, 0, 'L');



        // // Label Pekerjaan
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Pekerjaan', 0, 1, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi Pekerjaan dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 10, $pekerjaan, 1, 'L');

        // //NIK
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Nik', 0, 0, 'L');
        // $pdf->SetFont('times', '', 12);

        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Upload Indentitas Anda', 0, 1, 'R');
        // $pdf->SetFont('times', '', 12);

        // //
        // // Mengatur posisi x untuk nama depan
        // $xnoidentitas = 10; // Sesuaikan posisi x sesuai kebutuhan
        // $pdf->SetXY($xnoidentitas, $pdf->GetY());
        // $pdf->Cell(0, 10, $nik, 1, 'L');
        // $xupload = 105;
        // $pdf->SetXY($xupload, $pdf->GetY() - 10);
        // $pdf->Cell(0, 10, $identitas, 1, 'R');

        // $pdf->SetFont('times', 'B', 1);
        // $pdf->Cell(0, 0, '', 0, 0, 'L');
        // $pdf->SetFont('times', '', 1);
        // // Isi Email dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 0, 0, 'L');

        // // Label OPD yang dituju
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'OPD yang dituju', 0, 1, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi OPD yang dituju dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 10, $opd, 1, 'L');

        // // Label Informasi yang Dibutuhkan
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Informasi yang Dibutuhkan', 0, 1, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi Informasi yang Dibutuhkan dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 10, $informasi, 1, 'L');

        // // Label Alasan Pengguna Informasi
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Alasan Pengguna Informasi', 0, 1, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi Alasan Pengguna Informasi dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 10, $alasan, 1, 'L');

        // // Label Cara Mendapatkan Informasi
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Cara Mendapatkan Informasi', 0, 1, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi Cara Mendapatkan Informasi dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 10, $caraMendapatkaninformasi, 1, 'L');
        // $pdf->SetFont('times', 'B', 1);
        // $pdf->Cell(0, 0, '', 0, 0, 'L');
        // $pdf->SetFont('times', '', 1);
        // // Isi Email dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 0, 0, 'L');
        // // Label Cara Mendapatkan Salinan
        // $pdf->SetFont('times', 'B', 12);
        // $pdf->Cell(0, 10, 'Cara Mendapatkan Salinan', 0, 1, 'L');
        // $pdf->SetFont('times', '', 12);
        // // Isi Cara Mendapatkan Salinan dengan border di sekelilingnya
        // $pdf->MultiCell($lebarSel, 10, $caraMendapatkanSalinan, 1, 'L');


        // $pdfFileName = 'form_Permohonan_Informasi_' . date('YmdHis') . '.pdf';
        // $pdfFilePath = __DIR__ . '/../Assets/files/' . $pdfFileName;
        // $pdf->Output($pdfFilePath, 'F');

        $response = array("success" => true);
        echo json_encode($response);
    } else {
        $response = array("success" => false, "error" => "Data tidak ditemukan");
        echo json_encode($response);
    }
    $conn->close();
}
?>