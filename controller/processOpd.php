<?php
include('../controller/koneksi/config.php');
include('../controller/functionOpd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        // Edit operation
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];

        if (editOPD($id, $nama, $alamat, $email)) {
            // Redirect to daftar_opd.php or show a success message
            header("Location: ../view/listopd");
            exit();
        } else {
            // Handle the case where editing fails
            echo "Failed to edit OPD.";
        }
    } else {
        // Add operation
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];

        if (tambahOPD($nama, $alamat, $email)) {
            // Redirect to daftar_opd.php or show a success message
            header("Location: ../view/listopd");
            exit();
        } else {
            // Handle the case where adding fails
            echo "Failed to add OPD.";
        }
    }
}
?>
