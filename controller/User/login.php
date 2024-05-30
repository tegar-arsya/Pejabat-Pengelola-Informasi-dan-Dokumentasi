<?php
session_start();
require '../../controller/koneksi/config.php';

class AuthMiddleware {
    public function handle() {
        // Memverifikasi apakah pengguna sudah masuk atau belum
        if(isset($_SESSION['id'])) {
            // Jika sudah masuk, arahkan pengguna ke halaman formulir
            header("Location: ../../view/formulir");
            exit();
        }
    }
}

// Fungsi untuk memverifikasi token CSRF
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

//fungsi validasi password
function validate_password($password) {
    return !empty($password) && strlen($password) >=8;
}

// Fungsi untuk membersihkan input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && verify_csrf_token($_POST['csrf_token'])) {
    // Membuat objek middleware
    $authMiddleware = new AuthMiddleware();
    // Menjalankan middleware untuk memeriksa otentikasi pengguna
    $authMiddleware->handle();

    // Proses login seperti sebelumnya
    $email =sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);


    //validasi email
    if (!validate_email($email)) {
        $_SESSION['login_error'] = "Format email tidak valid.";
        echo "<script>window.location.href='../../home'; alert('" . htmlspecialchars($_SESSION['login_error']) . "');</script>";
        exit();
    }


    //validasi password
    if (!validate_password($password)) {
        $_SESSION['login_error'] = "Format password tidak valid.";
        echo "<script>window.location.href='../../home'; alert('" . htmlspecialchars($_SESSION['login_error']) . "');</script>";
        exit();
    }

    //proses login
    $sql = $conn->prepare("SELECT r.id,  r.email, r.password, r.nama_depan, r.nama_belakang, r.nik
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
        
        $_SESSION['nama_depan'] = $row['nama_depan'];
        $_SESSION['nama_belakang'] = $row['nama_belakang'];
        $_SESSION['nik'] = $row['nik'];
        header("Location: ../../view/formulir");
    } else {
        $_SESSION['login_error'] = "Email atau password salah. Silakan coba lagi.";
        echo "<script>window.location.href='../../home'; alert('" . htmlspecialchars($_SESSION['login_error']) . "');</script>";
        exit();
    }
    $sql->close();
    $conn->close();
} else {
    // Token CSRF tidak valid, tanggapi sesuai kebijakan keamanan Anda
    $_SESSION['login_error'] = "Token CSRF tidak valid.";
    echo "<script>window.location.href='../../'; alert('" . htmlspecialchars($_SESSION['login_error']) . "');</script>";
    exit();
}
?>
