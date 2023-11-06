<?php
session_start();
require '../controller/koneksi/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Memeriksa apakah email dan password cocok dengan data di database
    $sql = $conn->prepare("SELECT id, username, password, nama_pengguna FROM admin WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0 && password_verify($password, $row['password'])) {
        // Jika cocok, set session dan arahkan ke halaman selamat datang
        $_SESSION['id'] = $row['id'];
        $_SESSION['nama_pengguna'] = $row['nama_pengguna'];
        header("Location: ../view/dashboard.php"); // Ganti formulir_permohonan.php dengan halaman yang sesuai
    } else {
        // Jika tidak cocok, arahkan kembali ke halaman login dengan pesan error
        $_SESSION['login_error'] = "Username atau password salah. Silakan coba lagi.";
        echo "<script>window.location.href='../view/login_admin.php'; alert('" . $_SESSION['login_error'] . "');</script>";
    }
}

// Menutup koneksi ke database
$conn->close();
?>