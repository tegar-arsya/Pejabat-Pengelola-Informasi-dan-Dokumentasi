<?php
session_start();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../smtpmail/library/PHPMailer.php';
require '../smtpmail/library/SMTP.php';
require '../smtpmail/library/Exception.php';
require '../koneksi/config.php';
require_once __DIR__ . '/../../vendor/autoload.php';


// Fungsi logActivity
function logActivity($adminUsername, $action, $description)
{
	$logger = getLogger();
	$logger->info($action, ['admin' => $adminUsername, 'description' => $description]);
}

// Fungsi getLogger
function getLogger()
{
	$log = new Logger('activity_log');
	$log->pushHandler(new StreamHandler(__DIR__ . '/../../Model/Logs/activity.log', Logger::INFO));
	return $log;
}

$mail = new PHPMailer;

//Enable SMTP debugging.
$mail->SMTPDebug = 0;
//Set PHPMailer to use SMTP.
$mail->isSMTP();
//Set SMTP host name
$mail->Host = "tls://smtp.gmail.com"; //host mail server
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;
//Provide username and password
$mail->Username = "ppid.diskominfo.jtg3@gmail.com";   //nama-email smtp
$mail->Password = "ymgj whgy zdps duic";           //password email smtp
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";
//Set TCP port to connect to
$mail->Port = 587;

$mail->From = "ppid.diskominfo.jtg3@gmail.com"; //email pengirim
$mail->FromName = "PPID Provinsi Jawa Tengah"; //nama pengirim

$mail->addAddress($_POST['email'], $_POST['nama']); //email penerima

$mail->isHTML(true);

$mail->Subject = $_POST['subjek']; //subject
$mail->Body    = $_POST['alasan']; //isi email
$mail->AltBody = "PHP mailer"; //body email (optional)

// setelah pengaturan email
$user_id = $_SESSION['id'];
$nomerRegistrasi = $_POST['nomer_registrasi'];
$id_registrasi = $_POST['id_registrasi'];
$id_permohonan = $_POST['id_permohonan'];
$name = $_POST['nama'];
$alasan = $_POST['alasan'];
$query = $conn->prepare("INSERT INTO tbl_rejected (id_admin, id_permohonan, nomer_registrasi, note) VALUES ( ?,?, ?,?)");
$query->bind_param("isss", $user_id, $id_permohonan, $nomerRegistrasi, $alasan);

// Eksekusi query
if ($query->execute()) {
	// Jika berhasil dimasukkan ke dalam database tbl_rejected
	echo "<script>alert('Sukses.');</script>";
	$adminUsername = $_SESSION['nama_pengguna'];
	logActivity($adminUsername, 'verifikasi', "Verifikasi Penolakan Permohonan Informasi dengan alasan ($alasan) dengan nomer registrasi pemohon $nomerRegistrasi");
} else {
	// Jika gagal dimasukkan ke dalam database tbl_rejected
	echo "<script>alert('Gagal memasukkan nomor registrasi ke dalam database tbl_rejected: " . $query->error . "');</script>";
}

// Setelah Anda mengirim email dengan sukses
if ($mail->send()) {
	echo "<script>alert('Email berhasil terkirim.');";
	echo "window.location.href = '../../view/Admin/DaftarPermohonan/listPI';</script>";
} else {
	echo "<script>alert('Gagal mengirim email. Silakan coba lagi.');</script>";
}
