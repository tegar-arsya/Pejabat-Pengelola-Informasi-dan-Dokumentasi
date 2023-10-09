<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "";
$database = "permohonan_informasi";

// Membuat koneksi ke database
$conn = new mysqli($server, $user, $pass, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Memeriksa apakah email dan password cocok dengan data di database
    $sql = $conn->prepare("SELECT id, email, password FROM registrasi WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0 && password_verify($password, $row['password'])) {
        // Jika cocok, set session dan arahkan ke halaman selamat datang
        $_SESSION['id'] = $row['id'];
        header("Location: formulir_permohonan.php"); // Ganti formulir_permohonan.php dengan halaman yang sesuai
    } else {
        // Jika tidak cocok, arahkan kembali ke halaman login dengan pesan error
        $_SESSION['login_error'] = "Email atau password salah. Silakan coba lagi.";
        header("Location: login-form.php"); // Ganti login-form.php dengan halaman login yang sesuai
    }
}

// Menutup koneksi ke database
$conn->close();
?>
