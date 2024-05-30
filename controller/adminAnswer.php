<?php

session_start();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './smtpmail/library/PHPMailer.php';
require './smtpmail/library/SMTP.php';
require './smtpmail/library/Exception.php';
require './koneksi/config.php';
include('../controller/koneksi/config.php');
require_once __DIR__ . '/../vendor/autoload.php';
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
    $namaPIC = $_POST['namaPIC'];
    $jawabanPermohonan = $_POST['jawabanPermohonan'];
    
    $nikPemohon = $_POST['nikPemohon'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $norek = $_POST['norek'];
    $targetDir = "../Assets/JawabanPI/";
    $lampiranName = basename($_FILES["lampiran"]["name"]);
    $targetFilePath = $targetDir . $lampiranName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan.']);
        exit();
    }
    if (move_uploaded_file($_FILES["lampiran"]["tmp_name"], $targetFilePath)) {
        $insertQuery = "INSERT INTO answer_admin (nama_pic, jawaban_permohonan, lampiran, nik_pemohon, nomer_registrasi_pemohon, status_balasan) 
                        VALUES ('$namaPIC', '$jawabanPermohonan', '$lampiranName','$nikPemohon','$norek','Jawaban permohonan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat permohonan sesuai dengan nomer registrasi permohonan anda untuk mengunduh jawaban permohonan.')";
        $insertResult = $conn->query($insertQuery);

        if ($insertResult) {
            $mail = new PHPMailer;
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = "tls://smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "ppid.diskominfo.jtg3@gmail.com";
            $mail->Password = "ymgj whgy zdps duic";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->From = "ppid.diskominfo.jtg3@gmail.com";
            $mail->FromName = "Admin PPID DISKOMINFO Jawa Tengah";

            $mail->addAddress($_POST['email'], $_POST['nama']);

            $mail->isHTML(true);
            $mail->Subject = "Jawaban Permohonan Informasi";
            $mail->Body = "Jawaban permohonan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat permohonan sesuai dengan nomer registrasi permohonan anda untuk mengunduh jawaban permohonan.<br><br>";
            if ($mail->send()) {
                echo json_encode(['status' => 'success', 'message' => 'Jawaban Permohonan Sukses. Email berhasil terkirim.']);
                header("Location: ../view/listPI");
                $adminUsername = $_SESSION['nama_pengguna'];
                logActivity($adminUsername,'Jawaban', "telah menjawab permohonan informasi dengan $lampiranName nomer registrasi $norek");
                
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim email.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan jawaban ke dalam tabel answer_admin.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengunggah file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}
?>
