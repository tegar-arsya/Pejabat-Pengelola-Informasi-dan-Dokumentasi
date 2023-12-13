<?php
include('../controller/koneksi/config.php');

function getDaftarOPD()
{
    global $conn;
    $sql = "SELECT * FROM tbl_daftar_opd";
    $result = $conn->query($sql);

    $daftarOPD = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $daftarOPD[] = $row;
        }
    }

    return $daftarOPD;
}

function getOPDById($id)
{
    global $conn;
    $sql = "SELECT * FROM tbl_daftar_opd WHERE id_opd = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // Return null if no OPD is found with the provided ID
    }
}

function tambahOPD($nama, $alamat, $email)
{
    global $conn;
    $sql = "INSERT INTO tbl_daftar_opd (nama, alamat_opd, email_opd) VALUES ('$nama', '$alamat', '$email')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function editOPD($id, $nama, $alamat, $email)
{
    global $conn;
    $sql = "UPDATE tbl_daftar_opd SET nama='$nama', alamat_opd='$alamat', email_opd='$email' WHERE id_opd=$id";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function hapusOPD($id)
{
    global $conn;
    $sql = "DELETE FROM tbl_daftar_opd WHERE id_opd=$id";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// $conn->close();
?>
