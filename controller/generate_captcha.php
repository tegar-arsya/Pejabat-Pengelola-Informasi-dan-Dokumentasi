<?php
session_start();

// Fungsi untuk menghasilkan CAPTCHA secara acak
function generateCaptcha($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $captcha = '';
    for ($i = 0; $i < $length; $i++) {
        $captcha .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $captcha;
}

$captcha = generateCaptcha(); // Generate CAPTCHA
$_SESSION['captcha'] = $captcha; // Simpan CAPTCHA di sesi

echo $captcha; // Keluarkan nilai CAPTCHA sebagai teks
?>