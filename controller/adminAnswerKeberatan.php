<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './smtpmail/library/PHPMailer.php';
require './smtpmail/library/SMTP.php';
require './smtpmail/library/Exception.php';
require './koneksi/config.php';
include('../controller/koneksi/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaPIC = $_POST['namaPIC'];
    $jawabankeberatan = $_POST['jawabanPermohonan'];
    
    $nikPemohon = $_POST['nikPemohon'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $norek = $_POST['norek'];
    // Mengelola pengunggahan file
    $targetDir = "../Assets/uploads/keberatan/jawabanKeberatan/";
    $lampiranName = basename($_FILES["lampiran"]["name"]);
    $targetFilePath = $targetDir . $lampiranName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Memeriksa apakah file sudah ada
    // if (file_exists($targetFilePath)) {
    //     echo json_encode(['status' => 'error', 'message' => 'File sudah ada.']);
    //     exit();
    // }

    // Mengecek tipe file yang diizinkan
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan.']);
        exit();
    }

    // Mengunggah file ke server
    if (move_uploaded_file($_FILES["lampiran"]["tmp_name"], $targetFilePath)) {
        // Simpan data ke dalam tabel answer_admin
        $insertQuery = "INSERT INTO keberatananswer_admin (nama_pic, jawaban_keberatan, lampiran, nik_pemohon, nomer_registrasi_keberatan, status_balasan) 
                        VALUES ('$namaPIC', '$jawabankeberatan', '$lampiranName','$nikPemohon','$norek','Jawaban permohonan informasi telah dikirimkan melalui email. Silakan cek email yang digunakan saat mengajukan permohonan informasi')";
        
        $insertResult = $conn->query($insertQuery);

        if ($insertResult) {
            $mail = new PHPMailer;
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = "tls://smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "tegararsyadani0117@gmail.com";
            $mail->Password = "npou byeu poie uadd";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->From = "tegararyadani0117@gmail.com";
            $mail->FromName = "Admin PPID Jawa Tengah";

            $mail->addAddress($_POST['email'], $_POST['nama']);

            $mail->isHTML(true);
            $mail->Subject = "Jawaban Keberatan Informasi";
            $mail->Body = "Berikut jawaban Keberatan Informasi Kami lampirkan dibawah ini <br><br>";

            // $mail->addAttachment($targetFilePath);
            if ($mail->send()) {
                // Jika email berhasil terkirim
                echo json_encode(['status' => 'success', 'message' => 'Jawaban Permohonan Sukses. Email berhasil terkirim.']);
                header("Location: ../view/daftarK");
            } else {
                // Jika email gagal terkirim
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