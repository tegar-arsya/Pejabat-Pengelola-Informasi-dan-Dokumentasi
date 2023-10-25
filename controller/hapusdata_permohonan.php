<?php
include('../koneksi/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Lakukan penghapusan data dari database berdasarkan ID
    $sql = "DELETE FROM permohonan_informasi WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
