<?php
include('../../../controller/koneksi/config.php');

if (isset($_GET['id'])) {
    // Validasi bahwa ID adalah integer
    $id = $_GET['id'];
    if (!is_numeric($id)) {
        echo "Invalid ID.";
        exit();
    }

    // Prepared statement untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM survey_kepuasan_keberatan WHERE id = ?";
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
header("Location: ../../../view/Admin/SurveyKepuasan/SKMKeberatan");
exit();
?>
