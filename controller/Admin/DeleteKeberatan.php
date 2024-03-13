<?php
include('../../controller/koneksi/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Lakukan penghapusan data dari database berdasarkan ID
    $sql = "DELETE FROM pengajuan_keberatan WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
