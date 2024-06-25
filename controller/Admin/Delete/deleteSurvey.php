<?php
include('../../../controller/koneksi/config.php');

// Pastikan ID tersedia dalam request GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Validasi bahwa $id adalah integer
    if (!is_numeric($id)) {
        echo "Invalid ID.";
        exit();
    }

    // Prepared statement untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM survey_kepuasan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Mengikat parameter ID sebagai integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Data berhasil dihapus";
    } else {
        echo "Gagal menghapus data atau data tidak ditemukan.";
    }

    $stmt->close();
} else {
    echo "ID tidak tersedia.";
}

$conn->close();
header("Location: ../../../view/Admin/SurveyKepuasan/SKM");
exit();
?>
