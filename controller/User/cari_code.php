<?php
session_start();
include('../../controller/koneksi/config.php');

class RegistrasiHandler {
    private $conn;
    private $id;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->id = $_SESSION['id'] ?? null;
    }

    public function handleRequest() {
        if ($this->id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->processPostRequest();
            }
        } else {
            $this->redirect('../home');
        }
    }

    private function processPostRequest() {
        $nomer_registrasi_input = $_POST['nomer_registrasi'] ?? '';
        if ($this->isValidRegistration($nomer_registrasi_input)) {
            $this->redirect("../../view/form-keberatan?registrasi=$nomer_registrasi_input");
        } else {
            $this->alertAndRedirect('Nomer registrasi tidak ditemukan dalam database atau tidak sesuai dengan pengguna.');
        }
    }

    private function isValidRegistration($nomer_registrasi_input) {
        $sql = "SELECT id FROM permohonan_informasi WHERE nomer_registrasi = ? AND id_registrasi = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $nomer_registrasi_input, $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result && $result->num_rows > 0;
    }

    private function alertAndRedirect($message) {
        echo "<script>alert('$message'); window.location.href = document.referrer;</script>";
        exit();
    }

    private function redirect($url) {
        header("Location: $url");
        exit();
    }
}

$registrasiHandler = new RegistrasiHandler($conn);
$registrasiHandler->handleRequest();
?>
