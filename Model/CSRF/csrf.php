<?php
session_start();

// Fungsi untuk memverifikasi token CSRF
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Fungsi untuk menghasilkan token CSRF
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        // Generate token hanya jika belum ada di sesi
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
    }

    return $_SESSION['csrf_token'];
}
?>
