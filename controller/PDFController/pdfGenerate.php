<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include the necessary files
require_once(__DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php');
require_once __DIR__ . '/../../vendor/autoload.php';
require '../smtpmail/library/PHPMailer.php';
require '../smtpmail/library/SMTP.php';
require '../smtpmail/library/Exception.php';
// Include the database configuration file
include('../../controller/koneksi/config.php');

// Retrieve the ID parameter from the POST request
if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    // Query to fetch data for PDF generation
    $query = "SELECT p.id_registrasi, p.nomer_registrasi, r.id, r.nik, r.no_hp, r.foto_ktp, r.alamat, r.email, r.nama_depan, r.nama_belakang, r.kota_kabupaten, r.provinsi, r.negara, r.kode_pos, r.pekerjaan, p.opd_yang_dituju, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi, p.cara_mendapatkan_informasi, p.cara_mendapatkan_salinan, p.tanggal_permohonan
        FROM permohonan_informasi p
        JOIN registrasi r ON p.id_registrasi = r.id
        WHERE p.id_registrasi = r.id AND p.id = $idPermohonan";

    $result = $conn->query($query);

    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nomer_registrasi = $row['nomer_registrasi'];
            $namaDepan = $row['nama_depan']; // Kolom ini mungkin harus disesuaikan dengan nama kolom yang sesuai di tabel registrasi
            $namaBelakang = $row['nama_belakang'];
            $email = $row['email'];
            $noHp = $row['no_hp'];
            $alamat = $row['alamat'];
            $kota = $row['kota_kabupaten'];
            $provinsi = $row['provinsi'];
            $kodepos = $row['kode_pos'];
            $negara = $row['negara'];
            $pekerjaan = $row['pekerjaan'];
            $nik = $row['nik'];
            $identitas = $row['foto_ktp'];
            // Data dari tabel permohonan_informasi
            $opd = $row['opd_yang_dituju'];
            $informasi = $row['informasi_yang_dibutuhkan'];
            $alasan = $row['alasan_pengguna_informasi'];
            $caraMendapatkaninformasi = $row['cara_mendapatkan_informasi'];
            $caraMendapatkanSalinan = $row['cara_mendapatkan_salinan'];


            // Mendapatkan path file foto KTP dari direktori yang ditentukan
        $photoFilePath = __DIR__ . '/../../Assets/uploads/' . $row['foto_ktp'];
            $pdf = new TCPDF();
            // ... Your existing code for PDF generation
            $pdf = new TCPDF();
            $pdf->SetMargins(10, 10, 10);
            $pdf->AddPage();

            // Menghitung lebar halaman PDF
            $lebarHalaman = $pdf->getPageWidth();

            // Menghitung lebar sel (setengah dari lebar halaman)
            $lebarSel = $lebarHalaman / 2.2;

            

            // Isi PDF dengan data
            $pdf->SetFont('times', 'B', 16);
            // Set ketebalan garis menjadi 0
            $pdf->SetLineWidth(0);

            $pdf->Cell(0, 10, 'Formulir Permohonan Informasi', 0, 1, 'C');
            $pdf->SetFont('times', '', 12);
            $text = 'Isi Form berikut merupakan Hak anda memperoleh Informasi Publik sesuai UU No 14 Tahun 2008 Tentang Keterbukaan Informasi Publik';
            $pdf->MultiCell(0, 10, $text, 0, 'L');


            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Nomer Registrasi', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $nomer_registrasi, 1, 'L');
            // Set font untuk label
            $pdf->SetFont('times', 'B', 12);

            // Label Nama Depan
            $pdf->Cell(0, 10, 'Nama Depan', 0, 0, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Nama Depan dengan border di sekelilingnya
            // $pdf->MultiCell(0, 10, $namaDepan, 1, 'L');

            // Label Nama Belakang
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Nama Belakang', 0, 1, 'R');
            $pdf->SetFont('times', '', 12);
            // Isi Nama Belakang dengan border di sekelilingnya
            // $pdf->MultiCell(0, 10, $namaBelakang, 1, 'R');
            //
            //
            // Mengatur posisi x untuk nama depan
            $xNamaDepan = 10; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xNamaDepan, $pdf->GetY());
            $pdf->Cell(0, 10, $namaDepan, 1, 'L');

            // Mengatur posisi x untuk nama belakang
            $xNamaBelakang = 105; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xNamaBelakang, $pdf->GetY() - 10); // Mengatur posisi Y sedikit ke atas agar sejajar dengan nama depan
            $pdf->Cell(0, 10, $namaBelakang, 1, 'R');

            $pdf->SetFont('times', 'B', 1);
            $pdf->Cell(0, 0, '', 0, 0, 'L');
            $pdf->SetFont('times', '', 1);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 0, 0, 'L');

            // Label Email
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Email', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $email, 1, 'L');

            // Label No. HP
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'No. HP', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi No. HP dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $noHp, 1, 'L');

            // Label Alamat
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Alamat', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Alamat dengan border di sekelilingnya
            $pdf->MultiCell(0, 10, $alamat, 1, 'L');

            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Kota', 0, 0, 'L');
            $pdf->SetFont('times', '', 12);

            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Provinsi', 0, 1, 'R');
            $pdf->SetFont('times', '', 12);


            // Isi Nama Belakang dengan border di sekelilingnya
            // $pdf->MultiCell(0, 10, $namaBelakang, 1, 'R');
            //
            //
            // Mengatur posisi x untuk nama depan
            $xkota = 10; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xkota, $pdf->GetY());
            $pdf->Cell(0, 10, $kota, 1, 'L');

            // Mengatur posisi x untuk nama belakang
            $xprovinsi = 105; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xprovinsi, $pdf->GetY() - 10); // Mengatur posisi Y sedikit ke atas agar sejajar dengan nama depan
            $pdf->Cell(0, 10, $provinsi, 1, 'R');


            $pdf->SetFont('times', 'B', 1);
            $pdf->Cell(0, 0, '', 0, 0, 'L');
            $pdf->SetFont('times', '', 1);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 0, 0, 'L');




            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Kode Pos', 0, 0, 'L');
            $pdf->SetFont('times', '', 12);
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Negara', 0, 1, 'R');
            $pdf->SetFont('times', '', 12);
            $xpos = 10; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xpos, $pdf->GetY());
            $pdf->Cell(0, 10, $kodepos, 1, 'L');
            $xprovinsii = 105; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xprovinsii, $pdf->GetY() - 10); // Mengatur posisi Y sedikit ke atas agar sejajar dengan nama depan
            $pdf->Cell(0, 10, $negara, 1, 'R');


            $pdf->SetFont('times', 'B', 1);
            $pdf->Cell(0, 0, '', 0, 0, 'L');
            $pdf->SetFont('times', '', 1);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 0, 0, 'L');



            // Label Pekerjaan
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Pekerjaan', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Pekerjaan dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $pekerjaan, 1, 'L');

            //NIK
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Nik', 0, 0, 'L');
            $pdf->SetFont('times', '', 12);

            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Upload Indentitas Anda', 0, 1, 'R');
            $pdf->SetFont('times', '', 12);

            //
            // Mengatur posisi x untuk nama depan
            $xnoidentitas = 10; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xnoidentitas, $pdf->GetY());
            $pdf->Cell(0, 10, $nik, 1, 'L');
            $xupload = 105;
            $pdf->SetXY($xupload, $pdf->GetY() - 10);
            $pdf->Cell(0, 10, $identitas, 1, 'R');

            $pdf->SetFont('times', 'B', 1);
            $pdf->Cell(0, 0, '', 0, 0, 'L');
            $pdf->SetFont('times', '', 1);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 0, 0, 'L');

            // Label OPD yang dituju
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'OPD yang dituju', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi OPD yang dituju dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $opd, 1, 'L');

            // Label Informasi yang Dibutuhkan
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Informasi yang Dibutuhkan', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Informasi yang Dibutuhkan dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $informasi, 1, 'L');

            // Label Alasan Pengguna Informasi
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Alasan Pengguna Informasi', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Alasan Pengguna Informasi dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $alasan, 1, 'L');

            // Label Cara Mendapatkan Informasi
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Cara Mendapatkan Informasi', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Cara Mendapatkan Informasi dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $caraMendapatkaninformasi, 1, 'L');
            $pdf->SetFont('times', 'B', 1);
            $pdf->Cell(0, 0, '', 0, 0, 'L');
            $pdf->SetFont('times', '', 1);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 0, 0, 'L');
            // Label Cara Mendapatkan Salinan
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Cara Mendapatkan Salinan', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Cara Mendapatkan Salinan dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $caraMendapatkanSalinan, 1, 'L');
            // Save the PDF to a file
            $pdfFileName = 'formulir Permohonan-' . $namaDepan . ' ' . $namaBelakang . '_' . date('YmdHis') . '.pdf';
            $pdfFilePath = __DIR__ . '/../../Assets/files/' . $pdfFileName;
            $pdf->Output($pdfFilePath, 'F');


            // Sending email
            $mail = new PHPMailer;

            // Enable SMTP debugging.
            $mail->SMTPDebug = 0;
            // Set PHPMailer to use SMTP.
            $mail->isSMTP();
            $mail->Host = "tls://smtp.gmail.com"; // Host mail server.
            $mail->SMTPAuth = true;
            $mail->Username = "ppid.diskominfo.jtg3@gmail.com";
            $mail->Password = "ymgj whgy zdps duic";
            $mail->SMTPSecure = "tls";
            // Set TCP port to connect to.
            $mail->Port = 587;

            $mail->From = "ppid.diskominfo.jtg3@gmail.com"; // Email pengirim.
            $mail->FromName = "Admin PPID DISKOMINFO Jawa Tengah"; // Nama pengirim.

            $mail->addAddress($row['email'], $row['nama_depan'] . ' ' . $row['nama_belakang']); // Email penerima.

            $mail->isHTML(true);

            $mail->Subject = "Permohonan Anda Telah Diverifikasi"; // Subject notifikasi.
            $mail->Body = "Permohonan informasi Anda dengan nomor registrasi " . $row['nomer_registrasi'] . " telah diverifikasi. Terlampir bukti formulir permohonan informasi."; // Isi notifikasi.
            $mail->AltBody = "Permohonan informasi Anda telah diverifikasi. Terlampir bukti formulir permohonan informasi."; // Body email (optional).

            // Attach PDF file
            $mail->addAttachment($pdfFilePath, $pdfFileName);
            // After sending the email successfully
            if ($mail->send()) {
                
            } else {
                echo "<script>alert('Gagal mengirim email. Silakan coba lagi.');</script>";
            }
            if (!empty($row['opd_yang_dituju'])) {
                // Query untuk mendapatkan alamat email OPD dari tabel daftar_opd
                $opdQuery = "SELECT email_opd FROM tbl_daftar_opd WHERE nama = '" . $row['opd_yang_dituju'] . "'";
                $opdResult = $conn->query($opdQuery);
            
                if ($opdResult !== false && $opdResult->num_rows > 0) {
                    while ($opdRow = $opdResult->fetch_assoc()) {
                        $opdEmail = $opdRow['email_opd'];
            
                        // Sending email to OPD
                        $mailOPD = new PHPMailer;
            
                        // Enable SMTP debugging.
                        $mailOPD->SMTPDebug = 0;
                        // Set PHPMailer to use SMTP.
                        $mailOPD->isSMTP();
                        $mailOPD->Host = "tls://smtp.gmail.com"; // Host mail server.
                        $mailOPD->SMTPAuth = true;
                        $mailOPD->Username = "ppid.diskominfo.jtg3@gmail.com";
                        $mailOPD->Password = "ymgj whgy zdps duic";
                        $mailOPD->SMTPSecure = "tls";
                        // Set TCP port to connect to.
                        $mailOPD->Port = 587;
            
                        $mailOPD->From = "ppid.diskominfo.jtg3@gmail.com"; // Email pengirim.
                        $mailOPD->FromName = "Admin PPID DISKOMINFO Jawa Tengah"; // Nama pengirim.
            
                        // Menambahkan alamat email OPD sebagai penerima
                        $mailOPD->addAddress($opdEmail, $row['opd_yang_dituju']);
            
                        $mailOPD->isHTML(true);
            
                        $mailOPD->Subject = "Permohonan Informasi"; // Subject notifikasi.
                        $mailOPD->Body = "Assalamualaikum kepada PLID " . $row['opd_yang_dituju'] . ", mohon bantuan melayani pemohon An. " . $row['nama_depan'] . ' ' . $row['nama_belakang'] . " atas informasi mengenai " . $row['informasi_yang_dibutuhkan'] . " untuk " . $row['alasan_pengguna_informasi'];
                        
            
                        // Attach PDF file
                        $mailOPD->addAttachment($pdfFilePath, $pdfFileName);
                        $photoFilePath = __DIR__ . '/../../Assets/uploads/' . $row['foto_ktp'];
                        $mailOPD->addAttachment($photoFilePath, 'Foto KTP');
                        
                        // After sending the email successfully
                        if ($mailOPD->send()) {
                            // Email kepada OPD berhasil dikirim
                            
                            $insertNotifikasi = "INSERT INTO notifikasi_pengiriman (id_permohonan, nomer_registrasi, status)
                            VALUES ($idPermohonan, '{$row['nomer_registrasi']}', 'Permohonan diposisikan ke {$row['opd_yang_dituju']}')";



                         if ($conn->query($insertNotifikasi) === TRUE) {
                            // Notifikasi berhasil disimpan ke database
                        } else {
                            echo "<script>alert('Gagal menyimpan notifikasi ke database.');</script>";
                        }
                        } else {
                            echo "<script>alert('Gagal mengirim email kepada OPD. Silakan coba lagi.');</script>";
                        }
                    }
                } else {
                    echo "<script>alert('Gagal mendapatkan alamat email OPD. Silakan coba lagi.');</script>";
                }
            }
        }
    } else {
        $response = array("success" => false, "error" => "Data tidak ditemukan");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "error" => "ID permohonan tidak valid");
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>