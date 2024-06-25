<?php
include('../../controller/koneksi/config.php');
include('../../controller/OPDController/functionOpd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan ada pengecekan CSRF token jika diperlukan untuk keamanan tambahan

    if (isset($_POST['id'])) {
        // Edit operation
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];

        // Validasi input jika diperlukan
        // Contoh validasi sederhana:
        if (empty($id) || empty($nama) || empty($alamat) || empty($email)) {
            echo "All fields are required.";
            exit();
        }

        // Prepared statement untuk edit OPD
        $sql = "UPDATE tbl_daftar_opd SET nama=?, alamat_opd=?, email_opd=? WHERE id_opd=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nama, $alamat, $email, $id);

        if ($stmt->execute()) {
            // Redirect to daftar_opd.php or show a success message
            header("Location: ../../view/Admin/OPD/listopd");
            exit();
        } else {
            // Handle the case where editing fails
            echo "Failed to edit OPD.";
        }

    } else {
        // Add operation
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];

        // Validasi input jika diperlukan
        // Contoh validasi sederhana:
        if (empty($nama) || empty($alamat) || empty($email)) {
            echo "All fields are required.";
            exit();
        }

        // Prepared statement untuk tambah OPD
        $sql = "INSERT INTO tbl_daftar_opd (nama, alamat_opd, email_opd) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nama, $alamat, $email);

        if ($stmt->execute()) {
            // Redirect to daftar_opd.php or show a success message
            header("Location: ../../view/Admin/OPD/listopd");
            exit();
        } else {
            // Handle the case where adding fails
            echo "Failed to add OPD.";
        }
    }

    // Tutup statement
    $stmt->close();
}
?>
