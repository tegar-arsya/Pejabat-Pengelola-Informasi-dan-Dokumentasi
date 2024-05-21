<?php
session_start();
include('../controller/koneksi/config.php');
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['id'];

function getOPDData() {
    global $conn; // $conn adalah objek koneksi dari file config.php

    // Gantilah "nama_tabel" dengan nama tabel yang sesuai di database Anda
    $query = "SELECT nama FROM tbl_daftar_opd";
    $result = mysqli_query($conn, $query);

    $opdData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $opdData[] = $row['nama'];
    }

    return $opdData;
}

// Mendapatkan data OPD dari fungsi
$opdOptions = getOPDData();
?>