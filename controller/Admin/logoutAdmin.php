<?php
// Mulai sesi jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Menghapus semua data sesi
session_unset();

// Menghancurkan sesi
session_destroy();

// Mengarahkan pengguna ke halaman login
header("Location: ../../view/loginadmin");
exit();
?>
