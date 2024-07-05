<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './smtpmail/library/PHPMailer.php';
require './smtpmail/library/SMTP.php';
require './smtpmail/library/Exception.php';
require './koneksi/config.php';

$mail = new PHPMailer;

// Enable SMTP debugging.
$mail->SMTPDebug = 0;
// Set PHPMailer to use SMTP.
$mail->isSMTP();
// Set SMTP host name.
$mail->Host = "tls://smtp.gmail.com"; // Host mail server.
// Set this to true if SMTP host requires authentication to send email.
$mail->SMTPAuth = true;
// Provide username and password.
$mail->Username = "ppid.diskominfo.jtg3@gmail.com"; // Nama-email SMTP.
$mail->Password = "ymgj whgy zdps duic"; // Password email SMTP.
// If SMTP requires TLS encryption then set it.
$mail->SMTPSecure = "tls";
// Set TCP port to connect to.
$mail->Port = 587;

$mail->From = "ppid.diskominfo.jtg3@gmail.com"; // Email pengirim.
$mail->FromName = "PPID Provinsi Jawa Tengah"; // Nama pengirim.

$mail->addAddress($_POST['email'], $_POST['nama']); // Email penerima.

$mail->isHTML(true);

$mail->Subject = "Permohonan Anda Telah Diverifikasi"; // Subject notifikasi.
$mail->Body = "Permohonan informasi Anda dengan nomor registrasi " . $nomorRegistrasi . " telah diverifikasi. Terlampir bukti formulir permohonan informasi."; // Isi notifikasi.
$mail->AltBody = "Permohonan informasi Anda telah diverifikasi. Terlampir bukti formulir permohonan informasi."; // Body email (optional).

// Attach PDF file
$pdfFilePath = __DIR__ . '/../Assets/files/' . $pdfFileName;
$mail->addAttachment($pdfFilePath, 'Formulir Permohonan.pdf');

// Setelah Anda mengirim email dengan sukses
if ($mail->send()) {
    // echo "<script>alert('Email berhasil terkirim.');";
    // echo "window.location.href = document.referrer;</script>";
} else {
    echo "<script>alert('Gagal mengirim email. Silakan coba lagi.');</script>";
}
?>
