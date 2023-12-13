<?php
// reset_password.php
session_start();
require '../controller/smtpmail/library/PHPMailer.php';
require '../controller/smtpmail/library/SMTP.php';
require '../controller/smtpmail/library/Exception.php';
require '../controller/koneksi/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Lakukan validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid. Silakan masukkan email yang valid.');</script>";
        // Redirect ke halaman lupa password
        echo "<script>window.location.href = '../view/lupa_password.php';</script>";
        exit;
    }

    // Cek apakah email ada di dalam database
    $cek_email = $conn->prepare("SELECT * FROM registrasi WHERE email = ?");
    $cek_email->bind_param("s", $email);
    $cek_email->execute();
    $result = $cek_email->get_result();

    if ($result->num_rows > 0) {
        // Generate token reset password
        $token = bin2hex(random_bytes(32)); // Misalnya, menghasilkan token acak

        // Simpan token di sesi untuk digunakan di halaman ganti_password.php
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_token'] = $token;

        // Simpan token di database (sesuaikan dengan struktur tabel Anda)
        $simpan_token = $conn->prepare("UPDATE registrasi SET token_reset_password = ? WHERE email = ?");
        $simpan_token->bind_param("ss", $token, $email);
        $simpan_token->execute();

        // Kirim email instruksi reset password menggunakan PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
        $mail->Host = "tls://smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "ppid.diskominfo.jtg3@gmail.com";
        $mail->Password = "ymgj whgy zdps duic";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

            $mail->setFrom("ppid.diskominfo.jtg3@gmail.com", "Admin PPID DISKOMINFO Jawa Tengah");
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Reset Password";
            $mail->Body = "Klik link berikut untuk mereset password Anda: http://localhost/PERMOHONANINFORMASI/view/gantiPassword";

            $mail->send();

            echo "<script>alert('Email instruksi reset password telah dikirimkan.');</script>";
            echo "<script>window.location.href = '../home';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gagal mengirim email. Silakan coba lagi.');</script>";
            echo "Pesan Kesalahan PHPMailer: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Email tidak terdaftar. Silakan coba lagi.');</script>";
    }

    // Tutup koneksi database
    $cek_email->close();
    $conn->close();
}

?>
