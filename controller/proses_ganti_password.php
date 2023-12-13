<?php
// ganti_password.php
session_start();
require '../controller/koneksi/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    // Lakukan validasi password (misalnya: minimal panjang password)
    if (strlen($password) < 8) {
        echo "<script>alert('Password harus memiliki minimal 8 karakter. Silakan coba lagi.');</script>";
        // Redirect ke halaman ganti password
        echo "<script>window.location.href = '../view/gantiPassword';</script>";
        exit;
    }

    // Lakukan verifikasi token reset password
    $email = $_SESSION['reset_email'];
    $token = $_SESSION['reset_token'];

    // Ambil token dari database (sesuaikan dengan struktur tabel Anda)
    $cek_token = $conn->prepare("SELECT * FROM registrasi WHERE email = ? AND token_reset_password = ?");
    $cek_token->bind_param("ss", $email, $token);
    $cek_token->execute();
    $result_token = $cek_token->get_result();

    if ($result_token->num_rows > 0) {
        // Token valid, lanjutkan dengan proses ganti password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update password di database
        $update_query = $conn->prepare("UPDATE registrasi SET password = ?, token_reset_password = NULL WHERE email = ?");
        $update_query->bind_param("ss", $hashed_password, $email);

        if ($update_query->execute()) {
            echo "<script>alert('Password berhasil diubah.');</script>";
            // Redirect ke halaman login atau halaman lain yang sesuai
            echo "<script>window.location.href = ' ../home';</script>";
        } else {
            echo "<script>alert('Gagal mengubah password. Silakan coba lagi.');</script>";
            // Redirect ke halaman ganti password
            echo "<script>window.location.href = '../view/ganti_password.php';</script>";
        }
    } else {
        echo "<script>alert('Token reset password tidak valid. Silakan coba lagi.');</script>";
        // Redirect ke halaman lupa password
        echo "<script>window.location.href = '../view/lupa_password.php';</script>";
    }

    // Tutup koneksi database
    $cek_token->close();
    $conn->close();
}

?>
