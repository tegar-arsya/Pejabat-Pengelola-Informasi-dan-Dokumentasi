<?php
include('../controller/koneksi/config.php');
include('../controller/functionAdmin.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapusAdmin($id)) {
        header("Location: ../view/User");
        exit();
    } else {
        echo "Failed to delete Admin.";
    }
}
?>
