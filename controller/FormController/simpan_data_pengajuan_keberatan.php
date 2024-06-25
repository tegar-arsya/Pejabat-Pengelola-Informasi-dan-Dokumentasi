<?php
date_default_timezone_set('Asia/Jakarta');

session_start();

class FormHandler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function processForm() {
        if (!isset($_POST['user-input']) || $_POST['user-input'] !== $_SESSION['captcha']) {
            $response = array("success" => false, "error" => "CAPTCHA tidak sesuai. Silakan coba lagi.");
            echo json_encode($response);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi dan konversi nilai-nilai yang diperlukan
            $id_permohonan_informasi = isset($_POST['id_permohonan_informasi']) ? intval($_POST['id_permohonan_informasi']) : null;
            $code = isset($_POST['nomer_registrasi']) ? $_POST['nomer_registrasi'] : null;
            $informasiyangdiminta = isset($_POST['informasiyangdiminta']) ? $_POST['informasiyangdiminta'] : null;
            $kuasapermohon = isset($_POST['kuasapermohonan']) ? $_POST['kuasapermohonan'] : null;
            $namapemohon = isset($_POST['namapemohon']) ? $_POST['namapemohon'] : null;
            $nama = isset($_POST['nama']) ? $_POST['nama'] : null;
            $email = isset($_POST['email']) ? $_POST['email'] : null;
            $nik = isset($_POST['nik']) ? $_POST['nik'] : null;
            $nohp = isset($_POST['nohp']) ? $_POST['nohp'] : null;
            $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;
            $kotakabupaten = isset($_POST['kota_kabupaten']) ? intval($_POST['kota_kabupaten']) : null;
            $negara = isset($_POST['negara']) ? $_POST['negara'] : null;
            $kodepos = isset($_POST['kode_pos']) ? $_POST['kode_pos'] : null;
            $provinsi = isset($_POST['provinsi']) ? intval($_POST['provinsi']) : null;
            
            $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : null;
            $alasanK = isset($_POST['alasankeberatan']) ? $_POST['alasankeberatan'] : null;
            $tanggal_permohonan = isset($_POST['tanggal_permohonan']) ? $_POST['tanggal_permohonan'] : null;
            $nik_pemohon = isset($_POST['nik_pemohon']) ? $_POST['nik_pemohon'] : null;
            $emailpemohon = isset($_POST['emailpemohon']) ? $_POST['emailpemohon'] : null;
            $foto_ktp_pemohon = isset($_POST['foto_ktp_pemohon']) ? $_POST['foto_ktp_pemohon'] : null;
            $id_opd = htmlspecialchars($_POST['opd']);
            $query = "SELECT nama FROM tbl_daftar_opd WHERE id_opd = ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id_opd);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $opd = mysqli_fetch_assoc($result)['nama'];
            // Validasi input yang lebih ketat misalnya untuk ID provinsi dan kota/kabupaten
            if ($id_permohonan_informasi === null || $code === null || $informasiyangdiminta === null || $kuasapermohon === null || $namapemohon === null || $nama === null || $email === null || $nik === null || $nohp === null || $alamat === null || $kotakabupaten === null || $negara === null || $kodepos === null || $provinsi === null || $opd === null || $pekerjaan === null || $alasanK === null || $tanggal_permohonan === null || $nik_pemohon === null || $emailpemohon === null || $foto_ktp_pemohon === null) {
                $response = array("success" => false, "error" => "Data tidak lengkap atau tidak valid.");
                echo json_encode($response);
                exit();
            }

            $namaProvinsi = $this->getNamaProvinsiById($provinsi);
            $namaKotaKabupaten = $this->getNamaKotaKabupatenById($provinsi, $kotakabupaten);

            // Fungsi untuk upload file fotoktp
            $uploadDir = "../../Assets/uploads/keberatan/gambar/";
            $fotoktp = $this->uploadFile('fotoktp', $uploadDir);

            // Fungsi untuk upload file surat kuasa
            $uploadDirSuratKuasa = "../../Assets/uploads/keberatan/dokumen/";
            $suratkuaasa = $this->uploadFile('suratkuasa', $uploadDirSuratKuasa);

            if ($fotoktp === null || $suratkuaasa === null) {
                $response = array("success" => false, "error" => "File upload gagal.");
                echo json_encode($response);
                exit();
            }

            // Prepared statement untuk insert data
            $sql = "INSERT INTO pengajuan_keberatan (id_permohonan_informasi, kode_permohonan_informasi, informasi_yang_diminta, kuasa_permohonan, nama_pemohon, nama, email, nik, no_hp, foto_ktp, alamat, kota_kabupaten, negara, kode_pos, provinsi, id_opd, opd_yang_dituju, pekerjaan, unggah_surat_kuasa, alasan_keberatan, tanggal_permohonan, nik_pemohon, email_pemohon, foto_ktp_pemohon) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssssssssssssssssssssss", $id_permohonan_informasi, $code, $informasiyangdiminta, $kuasapermohon, $namapemohon, $nama, $email, $nik, $nohp, $fotoktp, $alamat, $namaKotaKabupaten, $negara, $kodepos, $namaProvinsi,$id_opd, $opd, $pekerjaan, $suratkuaasa, $alasanK, $tanggal_permohonan, $nik_pemohon, $emailpemohon, $foto_ktp_pemohon);

            if ($stmt->execute()) {
                $response = array("success" => true);
                echo json_encode($response);
            } else {
                $response = array("success" => false, "error" => $stmt->error);
                echo json_encode($response);
            }

            $stmt->close();
        }
    }

    // Fungsi untuk mengupload file
    private function uploadFile($inputName, $uploadDir) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {
            $file = $_FILES[$inputName];
            $fileName = basename($file['name']);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Check if file is a valid image
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
            if (in_array($fileType, $allowTypes)) {
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Buat direktori jika belum ada
                }

                if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    return $fileName;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    // Fungsi untuk mendapatkan nama provinsi berdasarkan ID
    private function getNamaProvinsiById($id) {
        $apiUrl = "https://tegar-arsya.github.io/api-indonesia/api/provinces.json";
        $response = file_get_contents($apiUrl);
        if ($response === false) {
            return "Provinsi Tidak Ditemukan";
        }

        $provinces = json_decode($response, true);
        if ($provinces === null) {
            return "Provinsi Tidak Ditemukan";
        }

        foreach ($provinces as $province) {
            if ($province['id'] == $id) {
                return $province['name'];
            }
        }

        return "Provinsi Tidak Ditemukan";
    }

    // Fungsi untuk mendapatkan nama kota/kabupaten berdasarkan ID
    private function getNamaKotaKabupatenById($provinceId, $regencyId) {
        $apiUrl = "https://tegar-arsya.github.io/api-indonesia/api/regencies/{$provinceId}.json";
        $response = file_get_contents($apiUrl);
        if ($response === false) {
            return "Kota/Kabupaten Tidak Ditemukan";
        }

        $regencies = json_decode($response, true);
        if ($regencies === null) {
            return "Kota/Kabupaten Tidak Ditemukan";
        }

        foreach ($regencies as $regency) {
            if ($regency['id'] == $regencyId) {
                return $regency['name'];
            }
        }

        return "Kota/Kabupaten Tidak Ditemukan";
    }
}

include('../../controller/koneksi/config.php');

$formHandler = new FormHandler($conn);
$formHandler->processForm();

$conn->close();
?>
