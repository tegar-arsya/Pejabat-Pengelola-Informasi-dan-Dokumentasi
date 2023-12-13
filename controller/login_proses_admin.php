<?php
session_start();
require '../controller/koneksi/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = $conn->prepare("SELECT id, username, password, nama_pengguna,role FROM user_admin WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0 && password_verify($password, $row['password'])) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['nama_pengguna'] = $row['nama_pengguna'];
        $_SESSION['role'] = $row['role']; // Set role langsung sebagai superadmin
        header("Location: ../view/dashboard"); // Ganti dashboard dengan halaman yang sesuai
    } else {
        $_SESSION['login_error'] = "Username atau password salah. Silakan coba lagi.";
        echo "<script>window.location.href='../view/loginAdmin.php'; alert('" . $_SESSION['login_error'] . "');</script>";
    }
}
$conn->close();
?>
