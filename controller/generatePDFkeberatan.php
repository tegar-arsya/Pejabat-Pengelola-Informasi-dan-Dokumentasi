<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include the necessary files
require_once(__DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php');
require_once __DIR__ . '/../vendor/autoload.php';
require './smtpmail/library/PHPMailer.php';
require './smtpmail/library/SMTP.php';
require './smtpmail/library/Exception.php';
require './koneksi/config.php';
// Include the database configuration file
include('../controller/koneksi/config.php');

// Retrieve the ID parameter from the POST request
if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    // Query to fetch data for PDF generation
    $query = "SELECT  nomer_registrasi_keberatan, informasi_yang_diminta, kuasa_permohonan, nama_pemohon, nama,
    email, nik, no_hp, foto_ktp, alamat, kota_kabupaten, negara, kode_pos, provinsi, opd_yang_dituju, pekerjaan,
    unggah_surat_kuasa, alasan_keberatan, tanggal_pengajuan, tanggal_permohonan, nik_pemohon
    FROM pengajuan_keberatan WHERE id = $idPermohonan";

    $result = $conn->query($query);

    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nomer_registrasi_keberatan = $row['nomer_registrasi_keberatan'];
            $nikpemohon = $row['nik_pemohon'];
            $namapemohon = $row['nama_pemohon'];
            $informasi = $row['informasi_yang_diminta'];
            $tanggalpermohonan = $row['tanggal_permohonan'];
            $kuasapermohon = $row['kuasa_permohonan'];
            $nama = $row['nama'];
            $email = $row['email'];
            $noHp = $row['no_hp'];
            $fotoktp = $row['foto_ktp'];
            $alamat = $row['alamat'];
            $kota = $row['kota_kabupaten'];
            $provinsi = $row['provinsi'];
            $kodepos = $row['kode_pos'];
            $negara = $row['negara'];
            $pekerjaan = $row['pekerjaan'];
            $nik = $row['nik'];
            $opd = $row['opd_yang_dituju'];
            $pekerjaan = $row['pekerjaan'];
            $unggah = $row['unggah_surat_kuasa'];
            $alasan = $row['alasan_keberatan'];
            $tanggalpengajuan = $row['tanggal_pengajuan'];
            $pdf = new TCPDF();
            // ... Your existing code for PDF generation
            $pdf = new TCPDF();
            $pdf->SetMargins(10, 10, 10);
            $pdf->AddPage();

            // Menghitung lebar halaman PDF
            $lebarHalaman = $pdf->getPageWidth();

            // Menghitung lebar sel (setengah dari lebar halaman)
            $lebarSel = $lebarHalaman / 2.2;

            // Menggunakan nilai lebar sel dalam metode MultiCell

            // Isi PDF dengan data
            $pdf->SetFont('times', 'B', 16);
            // Set ketebalan garis menjadi 0
            $pdf->SetLineWidth(0);

            $pdf->Cell(0, 10, 'Formulir Keberatan Informasi', 0, 1, 'C');
            $pdf->SetFont('times', '', 12);
            $text = 'Isi Form berikut merupakan Hak anda memperoleh Informasi Publik sesuai UU No 14 Tahun 2008 Tentang Keterbukaan Informasi Publik';
            $pdf->MultiCell(0, 10, $text, 0, 'L');


            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Nomer Registrasi Keberatan', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            $pdf->MultiCell($lebarSel, 10, $nomer_registrasi_keberatan, 1, 'L');

            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Nik Pemohon', 0, 0, 'L');
            $pdf->SetFont('times', '', 12);

            // Label Nama Belakang
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Nama Pemohon', 0, 1, 'R');
            $pdf->SetFont('times', '', 12);

            $xnikPemohon = 10; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xnikPemohon, $pdf->GetY());
            $pdf->Cell(0, 10, $nikpemohon, 1, 'L');

            // Mengatur posisi x untuk nama belakang
            $xnamaPemohon = 105; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xnamaPemohon, $pdf->GetY() - 10); // Mengatur posisi Y sedikit ke atas agar sejajar dengan nama depan
            $pdf->Cell(0, 10, $namapemohon, 1, 'R');
            $pdf->SetFont('times', 'B', 1);
            $pdf->Cell(0, 0, '', 0, 0, 'L');
            $pdf->SetFont('times', '', 1);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 0, 0, 'L');
            // informasi dan kuasa permohon
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Informasi Yang Diminta', 0, 0, 'L');
            $pdf->SetFont('times', '', 12);

            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Permohonan Dikuasakan', 0, 1, 'R');
            $pdf->SetFont('times', '', 12);

            $xinformasi = 10;
            $pdf->SetXY($xinformasi, $pdf->GetY());
            $pdf->Cell(0, 10, $informasi, 1, 'L');
            $xkuasa = 105; 
            $pdf->SetXY($xkuasa, $pdf->GetY() - 10);
            $pdf->Cell(0, 10, $kuasapermohon, 1, 'R');
            $pdf->SetFont('times', 'B', 1);
            $pdf->Cell(0, 0, '', 0, 0, 'L');
            $pdf->SetFont('times', '', 1);
            // Isi Email dengan border di sekelilingnya
            $pdf->Cell(0, 10, '', 0, 1, 'L');
            $pdf->MultiCell($lebarSel, 0, 0, 'L');
            $pdf->SetFont('times', 'B', 12);
            $text = 'Permohonan Dikuasakan Kepada';
            $pdf->MultiCell(0, 10, $text, 0, 'L');
            // bagian kuasa permohonan
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Nama', 0, 0, 'L');
            $pdf->SetFont('times', '', 12);
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Email', 0, 1, 'R');
            $pdf->SetFont('times', '', 12);

            $xnamakuasa = 10; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xnamakuasa, $pdf->GetY());
            $pdf->Cell(0, 10, $nama, 1, 'L');

            // Mengatur posisi x untuk nama belakang
            $xemail = 105; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xemail, $pdf->GetY() - 10); // Mengatur posisi Y sedikit ke atas agar sejajar dengan nama depan
            $pdf->Cell(0, 10, $email, 1, 'R');
            $pdf->SetFont('times', 'B', 1);
            $pdf->Cell(0, 0, '', 0, 0, 'L');
            $pdf->SetFont('times', '', 1);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 0, 0, 'L');
            // nik dan no hp
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Nik', 0, 0, 'L');
            $pdf->SetFont('times', '', 12);
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'No Hp', 0, 1, 'R');
            $pdf->SetFont('times', '', 12);

            $xnik = 10; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xnik, $pdf->GetY());
            $pdf->Cell(0, 10, $nik, 1, 'L');

            // Mengatur posisi x untuk nama belakang
            $xnohp = 105; // Sesuaikan posisi x sesuai kebutuhan
            $pdf->SetXY($xnohp, $pdf->GetY() - 10); // Mengatur posisi Y sedikit ke atas agar sejajar dengan nama depan
            $pdf->Cell(0, 10, $noHp, 1, 'R');
            $pdf->SetFont('times', 'B', 1);
            $pdf->Cell(0, 0, '', 0, 0, 'L');
            $pdf->SetFont('times', '', 1);
            // Isi Email dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 0, 0, 'L');
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Indentitas ', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            $pdf->MultiCell($lebarSel, 10, $fotoktp, 1, 'L');
            // Label Alamat
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Alamat', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Alamat dengan border di sekelilingnya
            $pdf->MultiCell(0, 10, $alamat, 1, 'L');

            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Kota / Kabupaten', 0, 0, 'L');
            $pdf->SetFont('times', '', 12);
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Provinsi', 0, 1, 'R');
            $pdf->SetFont('times', '', 12);
            $xkota = 10;
            $pdf->SetXY($xkota, $pdf->GetY());
            $pdf->Cell(0, 10, $kota, 1, 'L');
            $xprovinsi = 105;
            $pdf->SetXY($xprovinsi, $pdf->GetY() - 10);
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

            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Surat Kuasa', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Pekerjaan dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $unggah, 1, 'L');

            // Label OPD yang dituju
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'OPD yang dituju', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi OPD yang dituju dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $opd, 1, 'L');

            // Label Informasi yang Dibutuhkan
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 10, 'Alasan Keberatan', 0, 1, 'L');
            $pdf->SetFont('times', '', 12);
            // Isi Informasi yang Dibutuhkan dengan border di sekelilingnya
            $pdf->MultiCell($lebarSel, 10, $alasan, 1, 'L');

           
            // Save the PDF to a file
            $pdfFileName = 'formulir Keberatan-' . $namapemohon .'_' . date('YmdHis') . '.pdf';
            $pdfFilePath = __DIR__ . '/../Assets/files/keberatan/' . $pdfFileName;
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

            $mail->addAddress($row['email'], $row['nama']); // Email penerima.

            $mail->isHTML(true);

            $mail->Subject = "Permohonan Keberatan Anda Telah Diverifikasi"; // Subject notifikasi.
            $mail->Body = "Permohonan Keberatan Anda dengan nomor registras keberatan " . $row['nomer_registrasi_keberatan'] . " telah diverifikasi. Terlampir bukti formulir keberatan informasi."; // Isi notifikasi.
            $mail->AltBody = "Permohonan keberatan Anda telah diverifikasi. Terlampir bukti formulir keberatan informasi."; // Body email (optional).

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
            
                        $mailOPD->Subject = "Permohonan Keberatan Informasi"; // Subject notifikasi.
                        $mailOPD->Body = "Ada permohonan Keberatan Informasi dari " . $row['nama_pemohon'] . ' ' . ". Nomor Registrasi Keberatan: " . $row['nomer_registrasi_keberatan']. ' ' . ". Yang Dikuasakan Oleh: " . $row['nama']; // Isi notifikasi.
                        $mailOPD->AltBody = "Ada permohonan Keberatan Informasi dari " . $row['nama_pemohon'] . ' ' . ". Nomor Registrasi Keberatan: " . $row['nomer_registrasi_keberatan']. ' ' . ". Yang Dikuasakan Oleh: " . $row['nama'];
            
                        // Attach PDF file
                        $mailOPD->addAttachment($pdfFilePath, $pdfFileName);
            
                        // After sending the email successfully
                        if ($mailOPD->send()) {
                            // Email kepada OPD berhasil dikirim
                            
                            $insertNotifikasi = "INSERT INTO notifikasi_pengiriman_keberatan (nomer_registrasi_keberatan, nik_pemohon, nama_pemohon, opd_yang_dituju, status)
                            VALUES ('{$row['nomer_registrasi_keberatan']}', '{$row['nik_pemohon']}', '{$row['nama_pemohon']}','{$row['opd_yang_dituju']}', 'Permohonan Keberatan Informasi telah dikirim ke {$row['opd_yang_dituju']}')";



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