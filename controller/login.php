<?php
session_start();
require '../controller/koneksi/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = $conn->prepare("SELECT r.id, r.nomer_registrasi, r.email, r.password, r.nama_depan, r.nama_belakang, r.nik, p.nomer_registrasi AS nomer_registrasi_permohonan
    FROM registrasi r
    LEFT JOIN permohonan_informasi p ON r.nik = p.id_user
    WHERE r.email = ?
    ORDER BY p.tanggal_permohonan DESC LIMIT 1");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0 && password_verify($password, $row['password'])) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['nomer_registrasi'] = $row['nomer_registrasi_permohonan'] ?? $row['nomer_registrasi']; // Gunakan nomer_registrasi_permohonan jika ada, jika tidak, gunakan nomer_registrasi dari tabel registrasi
        $_SESSION['nama_depan'] = $row['nama_depan'];
        $_SESSION['nama_belakang'] = $row['nama_belakang'];
        $_SESSION['nik'] = $row['nik'];
        header("Location: ../view/formulir");
    } else {
        $_SESSION['login_error'] = "Email atau password salah. Silakan coba lagi.";
        echo "<script>window.location.href='../home'; alert('" . $_SESSION['login_error'] . "');</script>";
    }
}
$conn->close();
?>
