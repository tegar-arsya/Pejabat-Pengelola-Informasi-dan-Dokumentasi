<?php
include('../../../controller/koneksi/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Prepared statement untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM pengajuan_keberatan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Mengikat parameter ID sebagai integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Data berhasil dihapus";
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
