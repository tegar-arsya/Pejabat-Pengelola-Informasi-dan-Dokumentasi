<?php
include('../../../controller/koneksi/config.php');
include('../../../controller/UserAdminController/functionAdmin.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Menggunakan prepared statement untuk menghapus admin
    $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
    $stmt->bind_param("i", $id); // Mengikat parameter $id sebagai integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect ke halaman admin setelah berhasil menghapus
        header("Location: ../../../view/Admin/UserAdmin/User");
        exit();
    } else {
        echo "Failed to delete Admin.";
    }

    $stmt->close();
    $conn->close();
}
?>
