<?php
require '../controller/koneksi/config.php';

// Menerima data dari formulir
$namapengguna = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menyimpan nama pengguna, email, dan password ke database
$sql = $conn->prepare("INSERT INTO admin (nama_pengguna, username, password) VALUES (?, ?, ?)");
$sql->bind_param("sss", $namapengguna, $username, $hashed_password);

if ($sql->execute()) {
    header("Location: ../view/login_admin.php");
    exit();
} else {
    echo "Error: " . $sql->error;
}

$conn->close();
?>
