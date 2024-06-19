<?php
session_start();
include('../../../controller/koneksi/config.php');

function getDaftarAdmin()
{
    global $conn;
    $sql = "SELECT * FROM user_admin";
    $result = $conn->query($sql);

    $daftarAdmin = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $daftarAdmin[] = $row;
        }
    }

    return $daftarAdmin;
}

function getAdminById($id)
{
    global $conn;
    $sql = "SELECT * FROM user_admin WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // Return null if no OPD is found with the provided ID
    }
}

function tambahAdmin($nama, $username, $password)
{
    global $conn;
    // Fix the missing single quote in the VALUES section
    $sql = "INSERT INTO user_admin (nama_pengguna, username, password) VALUES ('$nama', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function editAdmin($id, $nama, $username, $password)
{
    global $conn;
    $sql = "UPDATE user_admin SET nama_pengguna='$nama', username='$username', password='$password' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function hapusAdmin($id)
{
    global $conn;
    $sql = "DELETE FROM user_admin WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// $conn->close();
?>
