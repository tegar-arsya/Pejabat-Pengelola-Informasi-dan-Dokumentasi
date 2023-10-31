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
	$mail->Username = "tegararsyadani0117@gmail.com";   //nama-email smtp          
	$mail->Password = "npou byeu poie uadd";           //password email smtp
	//If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "tls";                           
	//Set TCP port to connect to 
	$mail->Port = 587;                                   
 
	$mail->From = "tegararyadani0117@gmail.com"; //email pengirim
	$mail->FromName = "Admin PPID jawa Tengah"; //nama pengirim
 
	 $mail->addAddress($_POST['email'], $_POST['nama']); //email penerima
 
	$mail->isHTML(true);
 
	$mail->Subject = $_POST['subjek']; //subject
    $mail->Body    = $_POST['alasan']; //isi email
        $mail->AltBody = "PHP mailer"; //body email (optional)
 
	// Setelah Anda mengirim email dengan sukses
if ($mail->send()) {
    echo "<script>alert('Email berhasil terkirim.');</script>";
} else {
    echo "<script>alert('Gagal mengirim email. Silakan coba lagi.');</script>";
}


?>
