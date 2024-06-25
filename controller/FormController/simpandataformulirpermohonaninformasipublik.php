<?php
// simpandataformulirpermohonaninformasipublik.php

date_default_timezone_set('Asia/Jakarta');

session_start();

class FormSubmissionHandler
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function handleFormSubmission()
    {
        // Validate CAPTCHA
        if ($_POST['user-input'] !== $_SESSION['captcha']) {
            $response = array("success" => false, "error" => "CAPTCHA tidak sesuai. Silakan coba lagi.");
            echo json_encode($response);
            exit();
        }

        // Validate request method
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate inputs
            $id_registrasi = $_SESSION['id'];
            $nama_depan = $_SESSION['nama_depan'];
            $nama_belakang = $_SESSION['nama_belakang'];
            $id_opd = htmlspecialchars($_POST['opd']);
            // Get the name of the OPD from the database based on the selected ID
            $query = "SELECT nama FROM tbl_daftar_opd WHERE id_opd = ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id_opd);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $opd = mysqli_fetch_assoc($result)['nama'];

            $informasi = htmlspecialchars($_POST['informasiyangdibutuhkan']);
            $alasan = htmlspecialchars($_POST['alasanpengguna']);
            $caraMendapatkaninformasi = htmlspecialchars($_POST['caramendapatkaninformasi']);
            $caraMendapatkanSalinan = htmlspecialchars($_POST['caramendapatkansalinan']);
            $nama_pengguna = $nama_depan . " " . $nama_belakang;
            // Use prepared statement to insert data
            $stmt = $this->conn->prepare("INSERT INTO permohonan_informasi (id_registrasi,nama_pengguna, id_opd,opd_yang_dituju, informasi_yang_dibutuhkan, alasan_pengguna_informasi, cara_mendapatkan_informasi, cara_mendapatkan_salinan) 
                                         VALUES (?, ?,?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isisssss", $id_registrasi,$nama_pengguna, $id_opd,$opd, $informasi, $alasan, $caraMendapatkaninformasi, $caraMendapatkanSalinan);

            if ($stmt->execute()) {
                $response = array("success" => true);
                echo json_encode($response);
            } else {
                $response = array("success" => false, "error" => "Gagal menyimpan data.");
                echo json_encode($response);
            }
            $stmt->close();
            $this->conn->close();
        }
    }
}

include('../../controller/koneksi/config.php');

// Initialize FormSubmissionHandler object with database connection
$formHandler = new FormSubmissionHandler($conn);

// Process form submission
$formHandler->handleFormSubmission();
