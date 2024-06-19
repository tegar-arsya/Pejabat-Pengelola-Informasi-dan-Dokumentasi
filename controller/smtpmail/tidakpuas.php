<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../smtpmail/library/PHPMailer.php';
require '../smtpmail/library/SMTP.php';
require '../smtpmail/library/Exception.php';
require '../koneksi/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomer_registrasi_keberatan = $_POST['nomer_registrasi_keberatan'];
    $nama_pemohon = $_POST['nama_pemohon'];

    $mail = new PHPMailer;

    // Enable SMTP debugging.
    $mail->SMTPDebug = 0;
    // Set PHPMailer to use SMTP.
    $mail->isSMTP();
    // Set SMTP host name
    $mail->Host = "tls://smtp.gmail.com"; //host mail server
    // Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;
    // Provide username and password
    $mail->Username = "ppid.diskominfo.jtg3@gmail.com"; //nama-email smtp
    $mail->Password = "ymgj whgy zdps duic"; //password email smtp
    // If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "tls";
    // Set TCP port to connect to
    $mail->Port = 587;

    $mail->From = "ppid.diskominfo.jtg3@gmail.com"; //email pengirim
    $mail->FromName = "Admin PPID DISKOMINFO Jawa Tengah"; //nama pengirim

    // Email penerima adalah email admin
    $mail->addAddress("ppid.diskominfo.jtg3@gmail.com", "Admin PPID DISKOMINFO Jawa Tengah");

    $mail->isHTML(true);

    $mail->Subject = "Notifikasi Keberatan Informasi Tidak Puas";
    $mail->Body = "Yth. Admin PPID DISKOMINFO Jawa Tengah,<br><br>Kami menerima keberatan dari pemohon terkait informasi yang diberikan.<br>Nomor Registrasi: $nomer_registrasi_keberatan<br>Nama Pemohon: $nama_pemohon<br><br>Admin PPID DISKOMINFO Jawa Tengah";
    $mail->AltBody = "Yth. Admin PPID DISKOMINFO Jawa Tengah, Kami menerima keberatan dari pemohon terkait informasi yang diberikan. Nomor Registrasi: $nomer_registrasi_keberatan. Nama Pemohon: $nama_pemohon. Admin PPID DISKOMINFO Jawa Tengah";

    if ($mail->send()) {
        echo json_encode(['status' => 'success', 'message' => 'Email berhasil terkirim.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim email.']);
    }
}
?>
