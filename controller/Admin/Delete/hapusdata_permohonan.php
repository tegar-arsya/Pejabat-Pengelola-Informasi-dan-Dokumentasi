<?php
include('../../../controller/koneksi/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];

        // Lakukan penghapusan data dari database berdasarkan ID menggunakan prepared statement
        $deleteQuery = "DELETE FROM permohonan_informasi WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);

        if (!$stmt) {
            echo "Error: " . $conn->error;
            exit();
        }

        $stmt->bind_param("i", $id); // Mengikat parameter dengan tipe integer (i untuk integer)

        if ($stmt->execute()) {
            echo "Data berhasil dihapus";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Tutup prepared statement dan koneksi database
        $stmt->close();
        $conn->close();
    } else {
        echo "Error: Invalid or empty 'id' parameter";
    }
}
?>
