<?php
session_start();
require '../koneksi/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Memeriksa apakah email dan password cocok dengan data di database
    $sql = $conn->prepare("SELECT id, email, password, nama_depan, nama_belakang, nik FROM registrasi WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0 && password_verify($password, $row['password'])) {
        // Menggabungkan nama depan dan nama belakang
        

        // Jika cocok, set session dengan nama pengguna yang sudah digabungkan
        $_SESSION['id'] = $row['id'];
        
        $_SESSION['nama_depan'] = $row['nama_depan'];
        $_SESSION['nama_belakang'] = $row['nama_belakang'];
        $_SESSION['nik'] = $row['nik'];
        // Arahkan ke halaman formulir_permohonan.php atau halaman lain yang sesuai
        header("Location: ../view/formulir_permohonan.php");
    } else {
        // Jika tidak cocok, arahkan kembali ke halaman login dengan pesan error
        $_SESSION['login_error'] = "Email atau password salah. Silakan coba lagi.";
        echo "<script>window.location.href='../index.php'; alert('" . $_SESSION['login_error'] . "');</script>";
    }
}

// Menutup koneksi ke database
$conn->close();
?>
