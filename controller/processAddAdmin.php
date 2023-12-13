<?php
include('../controller/koneksi/config.php');
include('../controller/functionAdmin.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        // Edit operation
        $id = $_POST['id'];
        $nama = htmlspecialchars($_POST['nama']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        // Validate and hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (editAdmin($id, $nama, $username, $hashedPassword)) {
            // Redirect to daftar_opd.php or show a success message
            header("Location: ../view/User");
            exit();
        } else {
            // Handle the case where editing fails
            echo "Failed to edit Admin.";
        }
    } else {
        // Add operation
        $nama = htmlspecialchars($_POST['nama']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        // Validate and hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (tambahAdmin($nama, $username, $hashedPassword)) {
            // Redirect to daftar_opd.php or show a success message
            header("Location: ../view/User");
            exit();
        } else {
            // Handle the case where adding fails
            echo "Failed to add Admin.";
        }
    }
}
?>
