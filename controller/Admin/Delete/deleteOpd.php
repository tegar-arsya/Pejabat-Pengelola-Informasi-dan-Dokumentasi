<?php
include('../../../controller/koneksi/config.php');
include('../../../controller/OPDController/functionOpd.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Validasi bahwa $id adalah integer
    if (!is_numeric($id)) {
        echo "Invalid ID.";
        exit();
    }

    // Prepared statement untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM nama_tabel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Mengikat parameter ID sebagai integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../../../view/Admin/OPD/listopd");
        exit();
    } else {
        echo "Failed to delete OPD.";
    }

    $stmt->close();
    $conn->close();
}
?>
