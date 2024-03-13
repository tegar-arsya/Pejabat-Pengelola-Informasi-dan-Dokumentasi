<?php
include('../controller/koneksi/config.php');
include('../controller/functionOpd.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapusOPD($id)) {
        header("Location: ../view/listopd");
        exit();
    } else {
        echo "Failed to delete OPD.";
    }
}
?>
