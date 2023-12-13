<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../smtpmail/library/PHPMailer.php';
require '../smtpmail/library/SMTP.php';
require '../smtpmail/library/Exception.php';
require '../koneksi/config.php';

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
	$mail->FromName = "Admin PPID DISKOMINFO Jawa Tengah"; //nama pengirim

	 $mail->addAddress($_POST['email'], $_POST['nama']); //email penerima

	$mail->isHTML(true);

	$mail->Subject = $_POST['subjek']; //subject
    $mail->Body    = $_POST['alasan']; //isi email
    $mail->AltBody = "PHP mailer"; //body email (optional)

	// setelah pengaturan email
	$nomerRegistrasi = $_POST['nomer_registrasi'];
	$name = $_POST['nama'];
	$query = $conn->prepare("INSERT INTO tbl_rejected (nomer_registrasi, nama_pengguna) VALUES (?, ?)");
	$query->bind_param("ss", $nomerRegistrasi, $name);
	
// Eksekusi query
if ($query->execute()) {
    // Jika berhasil dimasukkan ke dalam database tbl_rejected
    echo "<script>alert('Sukses.');</script>";
	
} else {
    // Jika gagal dimasukkan ke dalam database tbl_rejected
    echo "<script>alert('Gagal memasukkan nomor registrasi ke dalam database tbl_rejected: " . $query->error . "');</script>";
}

	// Setelah Anda mengirim email dengan sukses
if ($mail->send()) {
    echo "<script>alert('Email berhasil terkirim.');";
    echo "window.location.href = document.referrer;</script>";
} else {
    echo "<script>alert('Gagal mengirim email. Silakan coba lagi.');</script>";
}


?>
