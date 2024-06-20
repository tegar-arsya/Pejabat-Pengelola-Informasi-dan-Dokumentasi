<?php
include('../../../controller/koneksi/config.php');
include('../../../controller/UserAdminController/functionAdmin.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapusAdmin($id)) {
        header("Location: ../../../view/Admin/UserAdmin/User");
        exit();
    } else {
        echo "Failed to delete Admin.";
    }
}
?>
