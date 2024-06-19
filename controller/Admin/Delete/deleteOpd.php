<?php
include('../../../controller/koneksi/config.php');
include('../../../controller/OPDController/functionOpd.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapusOPD($id)) {
        header("Location: ../../../view/Admin/OPD/listopd");
        exit();
    } else {
        echo "Failed to delete OPD.";
    }
}
?>
