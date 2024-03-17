<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $number = $data['number'];
    $name = $data['name'];
    $question = $data['question'];
    
    // Kirim email
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = "tls://smtp.gmail.com"; // Host mail server.
        $mail->SMTPAuth = true;
        $mail->Username = "ppid.diskominfo.jtg3@gmail.com";
        $mail->Password = "ymgj whgy zdps duic";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        // Set pengirim dan penerima
        $mail->setFrom('ppid.diskominfo.jtg3@gmail.com', 'Your Name'); // Ganti dengan alamat email Anda dan nama Anda
        $mail->addAddress('ppid.diskominfo.jtg3@gmail.com', 'Admin PPID DISKOMINFO Jawa Tengahe'); // Ganti dengan alamat email penerima dan nama penerima

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = 'Form Submission';
        $mail->Body = "Nomor: $number<br>Nama: $name<br>Pertanyaan: $question";

        $mail->send();
        
        // Berhasil mengirim email, kembalikan respons
        echo json_encode(array("status" => "success"));
    } catch (Exception $e) {
        // Gagal mengirim email, kembalikan pesan kesalahan
        echo json_encode(array("status" => "error", "message" => $mail->ErrorInfo));
    }
}
?>
