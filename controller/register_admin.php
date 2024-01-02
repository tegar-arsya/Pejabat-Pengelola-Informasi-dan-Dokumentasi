<?php
require '../controller/koneksi/config.php';

// Menerima data dari formulir
$namapengguna = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menyimpan nama pengguna, email, dan password ke database
$sql = $conn->prepare("INSERT INTO user_admin (nama_pengguna, username, password, role) VALUES (?, ?, ?,?)");
$sql->bind_param("ssss", $namapengguna, $username, $hashed_password,$role);

if ($sql->execute()) {
    header("Location: ../view/login_admin.php");
    exit();
} else {
    echo "Error: " . $sql->error;
}

$conn->close();
?>
