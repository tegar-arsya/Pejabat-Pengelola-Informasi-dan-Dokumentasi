<?php
// simpandataformulirpermohonaninformasipublik.php

date_default_timezone_set('Asia/Jakarta');

session_start();

class FormSubmissionHandler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function handleFormSubmission() {
        if ($_POST['user-input'] !== $_SESSION['captcha']) {
            $response = array("success" => false, "error" => "CAPTCHA tidak sesuai. Silakan coba lagi.");
            echo json_encode($response);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nik = $_SESSION['nik'];
            $id_registrasi = $_SESSION['id'];
            $nama_depan = $_SESSION['nama_depan'];
            $nama_belakang = $_SESSION['nama_belakang'];
            $opd = $_POST['opd'];
            $informasi = $_POST['informasiyangdibutuhkan'];
            $alasan = $_POST['alasanpengguna'];
            $caraMendapatkaninformasi = $_POST['caramendapatkaninformasi'];
            $caraMendapatkanSalinan = $_POST['caramendapatkansalinan'];

            $sql = "INSERT INTO permohonan_informasi (id_registrasi, id_user, nama_pengguna, opd_yang_dituju, informasi_yang_dibutuhkan, alasan_pengguna_informasi, cara_mendapatkan_informasi, cara_mendapatkan_salinan) 
                    VALUES ('$id_registrasi','$nik', '$nama_depan $nama_belakang', '$opd', '$informasi', '$alasan', '$caraMendapatkaninformasi', '$caraMendapatkanSalinan')";
            if ($this->conn->query($sql) === TRUE) {
                $response = array("success" => true);
                echo json_encode($response);
            } else {
                $response = array("success" => false, "error" => "Data tidak ditemukan");
                echo json_encode($response);
            }
            $this->conn->close();
        }
    }
}

include('../controller/koneksi/config.php');

// Inisialisasi objek FormSubmissionHandler dengan koneksi
$formHandler = new FormSubmissionHandler($conn);

// Memproses penyerahan formulir
$formHandler->handleFormSubmission();
?>
