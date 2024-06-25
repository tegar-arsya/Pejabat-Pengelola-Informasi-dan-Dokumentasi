<?php
include('../../../controller/koneksi/config.php');

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
    $sql = "SELECT * FROM tbl_daftar_opd WHERE id_opd = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // Return null if no OPD is found with the provided ID
    }
}

function tambahOPD($nama, $alamat, $email)
{
    global $conn;
    $sql = "INSERT INTO tbl_daftar_opd (nama, alamat_opd, email_opd) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nama, $alamat, $email);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function editOPD($id, $nama, $alamat, $email)
{
    global $conn;
    $sql = "UPDATE tbl_daftar_opd SET nama=?, alamat_opd=?, email_opd=? WHERE id_opd=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nama, $alamat, $email, $id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function hapusOPD($id)
{
    global $conn;
    $sql = "DELETE FROM tbl_daftar_opd WHERE id_opd=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// $conn->close();
?>
