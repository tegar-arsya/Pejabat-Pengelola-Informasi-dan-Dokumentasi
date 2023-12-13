<?php
session_start();
include('../controller/koneksi/config.php');
if(isset($_SESSION['nik'])) {
    $nik_session = $_SESSION['nik'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nomer_registrasi_input = $_POST['nomer_registrasi'];
        $sql = "SELECT id FROM permohonan_informasi WHERE nomer_registrasi = ? AND id_user = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $nomer_registrasi_input, $nik_session);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                header("Location: ../view/form-keberatan?registrasi=$nomer_registrasi_input");
                exit();
            } else {
                echo "<script>alert('Nomer registrasi tidak ditemukan dalam database atau tidak sesuai dengan pengguna.'); window.location.href = document.referrer;</script>";
                exit();
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: ../home");
    exit();
}
?>
