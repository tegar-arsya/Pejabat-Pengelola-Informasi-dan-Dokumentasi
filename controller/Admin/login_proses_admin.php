<?php
session_start();

// Fungsi untuk memverifikasi token CSRF
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Fungsi untuk menghasilkan token CSRF
function generate_csrf_token() {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
}

// Fungsi untuk menangani kesalahan eksekusi prepared statement
function handle_statement_error($stmt) {
    die("Error executing prepared statement: " . $stmt->error);
}

// Fungsi untuk membersihkan input
function clean_input($data) {
    // Lakukan pembersihan input sesuai kebutuhan, contoh:
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && verify_csrf_token($_POST['csrf_token'])) {
    // Ambil data dari formulir dan bersihkan input
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);

    // Buat koneksi ke database (sesuaikan dengan konfigurasi Anda)
    require '../../controller/koneksi/config.php';

    // Persiapkan dan eksekusi statement SQL
    $sql = $conn->prepare("SELECT id, username, password, nama_pengguna, role FROM user_admin WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();

    // Tangani kesalahan eksekusi prepared statement
    if (!$result = $sql->get_result()) {
        handle_statement_error($sql);
    }

    // Ambil data pengguna dari hasil query
    $row = $result->fetch_assoc();

    // Verifikasi kata sandi
    if ($result->num_rows > 0 && password_verify($password, $row['password'])) {
        // Pengguna berhasil login
        $_SESSION['id'] = $row['id'];
        $_SESSION['nama_pengguna'] = $row['nama_pengguna'];

        // Daftar nama OPD yang valid
        $daftar_opd = array("TESTING DEV", "BADAN KEPEGAWAIAN DAERAH", "Nama OPD 3");

        // Periksa apakah nama pengguna adalah salah satu dari nama OPD yang valid
        if (in_array($row['nama_pengguna'], $daftar_opd)) {
            // Jika nama pengguna adalah salah satu nama OPD, set role mereka sebagai nama OPD tersebut
            $_SESSION['role'] = $row['nama_pengguna'];
            // Kemudian arahkan ke halaman khusus OPD
            header("Location: ../../view/listPI");
        } else {
            // Jika bukan OPD, set role sebagai admin atau superadmin sesuai kebutuhan
            $_SESSION['role'] = ($row['role'] == 'superadmin') ? 'superadmin' : 'admin';
            // Kemudian arahkan ke halaman dashboard admin
            header("Location: ../../view/dashboard");
        }
    } else {
        // Kesalahan login, arahkan kembali ke halaman login
        $_SESSION['login_error'] = "Username atau password salah. Silakan coba lagi.";
        echo "<script>window.location.href='../../view/loginAdmin.php'; alert('" . $_SESSION['login_error'] . "');</script>";
    }

    // Tutup koneksi ke database
    $conn->close();

    // Hapus token CSRF setelah digunakan (opsional)
    unset($_SESSION['csrf_token']);
} else {
    // Token CSRF tidak valid, tanggapi sesuai kebijakan keamanan Anda
    // ...
}
?>
