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
    $sql = "SELECT * FROM user_admin WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // Return null if no admin is found with the provided ID
    }
}

function tambahAdmin($nama, $username, $password)
{
    global $conn;
    $sql = "INSERT INTO user_admin (nama_pengguna, username, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nama, $username, $password);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function editAdmin($id, $nama, $username, $password)
{
    global $conn;
    $sql = "UPDATE user_admin SET nama_pengguna=?, username=?, password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nama, $username, $password, $id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function hapusAdmin($id)
{
    global $conn;
    $sql = "DELETE FROM user_admin WHERE id=?";
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
