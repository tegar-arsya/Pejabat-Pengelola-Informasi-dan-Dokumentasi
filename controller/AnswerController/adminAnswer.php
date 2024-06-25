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
    // Validasi dan sanitasi input
    $user_id = mysqli_real_escape_string($conn, $_SESSION['id']);
    $namaPIC = mysqli_real_escape_string($conn, $_POST['namaPIC']);
    $jawabanPermohonan = mysqli_real_escape_string($conn, $_POST['jawabanPermohonan']);
    $id_permohonan = mysqli_real_escape_string($conn, $_POST['id_permohonan']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $norek = mysqli_real_escape_string($conn, $_POST['norek']);
    
    $targetDir = "../../Assets/JawabanPI/";
    $lampiranName = basename($_FILES["lampiran"]["name"]);
    $targetFilePath = $targetDir . $lampiranName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
    
    // Validasi tipe file lampiran
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan.']);
        exit();
    }
    
    // Pindahkan file lampiran yang diunggah
    if (move_uploaded_file($_FILES["lampiran"]["tmp_name"], $targetFilePath)) {
        // Query menggunakan prepared statement untuk menghindari SQL Injection
        $insertQuery = "INSERT INTO answer_admin (id_permohonan,id_admin, nama_pic, jawaban_permohonan, lampiran, nomer_registrasi_pemohon, status_balasan) 
                        VALUES (?,?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $status_balasan = "Jawaban permohonan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat permohonan sesuai dengan nomer registrasi permohonan anda untuk mengunduh jawaban permohonan.";
        $stmt->bind_param("iisssss", $id_permohonan, $user_id, $namaPIC, $jawabanPermohonan, $lampiranName, $norek, $status_balasan);
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
            $mail->addAddress($email, $norek);
            $mail->isHTML(true);
            $mail->Subject = "Jawaban Permohonan Informasi";
            $mail->Body = "Jawaban permohonan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat permohonan sesuai dengan nomer registrasi permohonan anda untuk mengunduh jawaban permohonan.<br><br>";

            if ($mail->send()) {
                echo json_encode(['status' => 'success', 'message' => 'Jawaban Permohonan Sukses. Email berhasil terkirim.']);
                header("Location: ../../view/Admin/DaftarPermohonan/listPI");
                $adminUsername = $_SESSION['nama_pengguna'];
                logActivity($adminUsername, 'Jawaban', "telah menjawab permohonan informasi dengan $lampiranName nomer registrasi $norek");
                exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim email.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan jawaban ke dalam tabel answer_admin.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengunggah file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}
?>
