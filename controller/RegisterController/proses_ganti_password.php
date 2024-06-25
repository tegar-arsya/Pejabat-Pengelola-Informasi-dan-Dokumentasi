<?php
// ganti_password.php
session_start();
require '../../controller/koneksi/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi dan sanitasi input password
    $password = $_POST['password'];
    if (strlen($password) < 8) {
        echo "<script>alert('Password harus memiliki minimal 8 karakter. Silakan coba lagi.');</script>";
        echo "<script>window.location.href = '../../../view/User/GantiPassword/gantiPassword';</script>";
        exit;
    }

    // Ambil dan sanitasi email serta token dari form
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING);

    // Prepare statement untuk memeriksa token reset password
    $cek_token = $conn->prepare("SELECT * FROM registrasi WHERE email = ? AND token_reset_password = ?");
    $cek_token->bind_param("ss", $email, $token);
    $cek_token->execute();
    $result_token = $cek_token->get_result();

    if ($result_token->num_rows > 0) {
        // Token valid, lanjutkan dengan proses ganti password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare statement untuk update password di database
        $update_query = $conn->prepare("UPDATE registrasi SET password = ?, token_reset_password = NULL WHERE email = ?");
        $update_query->bind_param("ss", $hashed_password, $email);

        if ($update_query->execute()) {
            echo "<script>alert('Password berhasil diubah.');</script>";
            echo "<script>window.location.href = '../../';</script>";
        } else {
            echo "<script>alert('Gagal mengubah password. Silakan coba lagi.');</script>";
            echo "<script>window.location.href = '../../../view/User/GantiPassword/gantiPassword';</script>";
        }
    } else {
        echo "<script>alert('Token reset password tidak valid. Silakan coba lagi.');</script>";
        echo "<script>window.location.href = '../../../view/User/GantiPassword/resetPassword';</script>";
    }

    // Tutup statement dan koneksi database
    $cek_token->close();
    $conn->close();
}

?>
