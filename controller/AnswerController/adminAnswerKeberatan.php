<?php
session_start();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../smtpmail/library/PHPMailer.php';
require '../smtpmail/library/SMTP.php';
require '../smtpmail/library/Exception.php';

include('../../controller/koneksi/config.php');
require_once __DIR__ . '/../../vendor/autoload.php';

// Fungsi logActivity
function logActivity($adminUsername, $action, $description) {
    $logger = getLogger();
    $logger->info($action, ['admin' => $adminUsername, 'description' => $description]);
}

// Fungsi getLogger
function getLogger() {
    $log = new Logger('activity_log');
    $log->pushHandler(new StreamHandler(__DIR__ . '/../../Model/Logs/activity.log', Logger::INFO));
    return $log;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitasi input
    $user_id = mysqli_real_escape_string($conn, $_SESSION['id']);
    $namaPIC = mysqli_real_escape_string($conn, $_POST['namaPIC']);
    $jawabankeberatan = mysqli_real_escape_string($conn, $_POST['jawabanPermohonan']);
    $id_permohonan_keberatan = mysqli_real_escape_string($conn, $_POST['id_permohonan_keberatan']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $norek = mysqli_real_escape_string($conn, $_POST['norek']);

    // Mengelola pengunggahan file
    $targetDir = "../../Assets/uploads/keberatan/jawabanKeberatan/";
    $lampiranName = basename($_FILES["lampiran"]["name"]);
    $targetFilePath = $targetDir . $lampiranName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Memeriksa tipe file yang diizinkan
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan.']);
        exit();
    }

    // Mengunggah file ke server
    if (move_uploaded_file($_FILES["lampiran"]["tmp_name"], $targetFilePath)) {
        // Query menggunakan prepared statement untuk menghindari SQL Injection
        $insertQuery = "INSERT INTO keberatananswer_admin (id_permohonan_keberatan,id_admin, nama_pic, jawaban_keberatan, lampiran, nomer_registrasi_keberatan, status_balasan) 
                        VALUES (?, ?, ?,?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $status_balasan = "Jawaban keberatan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat keberatan sesuai dengan nomer registrasi keberatan anda untuk mengunduh jawaban keberatan anda.";
        $stmt->bind_param("iisssss", $id_permohonan_keberatan,$user_id, $namaPIC, $jawabankeberatan, $lampiranName, $norek, $status_balasan);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Kirim email notifikasi menggunakan PHPMailer
            $mail = new PHPMailer;
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "ppid.diskominfo.jtg3@gmail.com";
            $mail->Password = "ymgj whgy zdps duic";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->setFrom("ppid.diskominfo.jtg3@gmail.com", "Admin PPID DISKOMINFO Jawa Tengah");
            $mail->addAddress($email, $namaPIC);
            $mail->isHTML(true);
            $mail->Subject = "Jawaban Keberatan Informasi";
            $mail->Body = "Jawaban keberatan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat keberatan sesuai dengan nomer registrasi keberatan anda untuk mengunduh jawaban keberatan anda.<br><br>";

            if ($mail->send()) {
                // Jika email berhasil terkirim
                echo json_encode(['status' => 'success', 'message' => 'Jawaban Keberatan Sukses. Email berhasil terkirim.']);
                header("Location: ../../view/Admin/DaftarPermohonan/daftarK");
                $adminUsername = $_SESSION['nama_pengguna'];
                logActivity($adminUsername, 'Jawaban', "telah menjawab keberatan permohonan informasi dengan $lampiranName nomer registrasi $norek");
                exit();
            } else {
                // Jika email gagal terkirim
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim email.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan jawaban ke dalam tabel keberatananswer_admin.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengunggah file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}
?>
