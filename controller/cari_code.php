<?php
session_start();
include('../koneksi/config.php');

// Periksa apakah pengguna telah login
if(isset($_SESSION['nik'])) {
    // Nama pengguna yang login
    $nik_session = $_SESSION['nik'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nik_input = $_POST['nik'];

        // Bandingkan nama pengguna yang dimasukkan dengan nama pengguna dari session
        if($nik_input == $nik_session) {
            // Cari ID permohonan informasi berdasarkan nama pengguna
            $sql = "SELECT id FROM permohonan_informasi WHERE id_user = '$nik_input'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Periksa apakah ada baris data yang cocok
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $id_pengguna = $row['id'];

                    // Redirect ke halaman selanjutnya dengan membawa ID pengguna
                    header("Location: ../view/form_pengajuan_keberatan.php?id=$id_pengguna");
                    exit();
                } else {
                    // Jika tidak ada baris data yang cocok, tampilkan pesan kesalahan menggunakan alert
                    echo "<script>alert('Nama pengguna tidak ditemukan dalam database.'); window.location.href = document.referrer;</script>";
                    exit();
                }
            } else {
                // Handle kesalahan jika query tidak berhasil
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            // Jika nama pengguna tidak sesuai dengan session, tampilkan pesan kesalahan menggunakan alert
            echo "<script>alert('Anda hanya bisa mencari informasi diri sendiri.'); window.location.href = document.referrer;</script>";
            exit();
        }
    }
} else {
    // Jika pengguna belum login, arahkan ke halaman login
    header("Location: ../path/to/login.php");
    exit();
}
?>
