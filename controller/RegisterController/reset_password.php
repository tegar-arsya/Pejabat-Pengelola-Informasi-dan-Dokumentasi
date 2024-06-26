<?php
session_start();
require '../../controller/smtpmail/library/PHPMailer.php';
require '../../controller/smtpmail/library/SMTP.php';
require '../../controller/smtpmail/library/Exception.php';
require '../../controller/koneksi/config.php';

// $BASE_URL = 'http://localhost';
$BASE_URL = 'https://20d9-118-96-186-14.ngrok-free.app/';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Fungsi untuk memverifikasi token CSRF
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Fungsi untuk menghasilkan token CSRF
function generate_csrf_token() {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
}

// Pastikan menggunakan metode POST dan token CSRF valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token']) && verify_csrf_token($_POST['csrf_token'])) {
    // Ambil dan sanitasi email dari form
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    // Validasi email
    if (!$email) {
        echo "<script>alert('Email tidak valid. Silakan masukkan email yang valid.');</script>";
        echo "<script>window.location.href = '../../../view/User/GantiPassword/resetPassword';</script>";
        exit;
    }

    // Prepare statement untuk mencari email di database
    $cek_email = $conn->prepare("SELECT * FROM registrasi WHERE email = ?");
    $cek_email->bind_param("s", $email);
    $cek_email->execute();
    $result = $cek_email->get_result();

    if ($result->num_rows > 0) {
        // Generate token reset password baru
        $token_baru = bin2hex(random_bytes(32));

        // Simpan token di sesi untuk digunakan di halaman ganti_password.php
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_token'] = $token_baru;

        // Update token di database
        $simpan_token = $conn->prepare("UPDATE registrasi SET token_reset_password = ? WHERE email = ?");
        $simpan_token->bind_param("ss", $token_baru, $email);
        $simpan_token->execute();

        // Kirim email instruksi reset password menggunakan PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "ppid.diskominfo.jtg3@gmail.com";
            $mail->Password = "ymgj whgy zdps duic";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;

            $mail->setFrom("ppid.diskominfo.jtg3@gmail.com", "Admin PPID DISKOMINFO Jawa Tengah");
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Reset Password";
            $mail->Body = "Klik link berikut untuk mereset password Anda: $BASE_URL/ppid/view/User/GantiPassword/gantiPassword?token=$token_baru";

            $mail->send();

            echo "<script>alert('Email instruksi reset password telah dikirimkan.');</script>";
            echo "<script>window.location.href = '../../';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gagal mengirim email. Silakan coba lagi.');</script>";
            echo "Pesan Kesalahan PHPMailer: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Email tidak terdaftar. Silakan coba lagi.');</script>";
    }

    // Tutup statement dan koneksi database
    $cek_email->close();
    $conn->close();
} else {
    echo "<script>alert('Token CSRF tidak valid.');</script>";
}
?>
