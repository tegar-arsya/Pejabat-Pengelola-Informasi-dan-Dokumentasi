<?php
// register.php

require '../../controller/koneksi/config.php';

class RegistrationManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registerUser() {
        // Menerima data dari formulir
        $namadepan = $_POST['namadepan'];
        $namabelakang = $_POST['namabelakang'];
        $jenisnik = $_POST['jns_nik'];
        $jenispemohon = $_POST['jns_pemohon'];
        $nik = $_POST['nik'];
        $nohp = $_POST['nohp'];
        $fotoktp = $_FILES['fotoktp']['name'];
        $npwp = $_POST['npwp'];
        $pekerjaan = $_POST['pekerjaan'];
        $alamat = $_POST['alamat'];
        $kotakabupaten = $_POST['kota_kabupaten'];
        $provinsi = $_POST['provinsi'];
        $negara = $_POST['negara'];
        $kodepos = $_POST['kode_pos'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $namaProvinsi = $this->getNamaProvinsiById($provinsi);
        $namaKotaKabupaten = $this->getNamaKotaKabupatenById($provinsi, $kotakabupaten);

        // Mengelola unggahan file
        $targetDirectory = "../../Assets/uploads/";
        $targetFile = $targetDirectory . basename($_FILES["fotoktp"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Memeriksa ukuran file
        if ($_FILES["fotoktp"]["size"] > 40000000) {
            echo "Maaf, ukuran file terlalu besar. (Maksimum 500 KB)";
            $uploadOk = 0;
        }

        // Memeriksa tipe file
        $allowedFileType = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedFileType)) {
            echo "Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            $uploadOk = 0;
        }

        // Memeriksa apakah $uploadOk bernilai 0 oleh kesalahan
        if ($uploadOk == 0) {
            echo "Maaf, file tidak diunggah.";
        } else {
            // Mencoba mengunggah file
            if (move_uploaded_file($_FILES["fotoktp"]["tmp_name"], $targetFile)) {
                // Menyimpan nama file, email, dan password ke database
                $sql = $this->conn->prepare("INSERT INTO registrasi (nama_depan, nama_belakang, jenis_nik, jenis_pemohon, nik, no_hp, foto_ktp, npwp, pekerjaan, alamat, kota_kabupaten, provinsi, negara, kode_pos, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
                $sql->bind_param("ssssssssssssssss", $namadepan, $namabelakang, $jenisnik, $jenispemohon, $nik, $nohp, $fotoktp, $npwp, $pekerjaan, $alamat, $namaKotaKabupaten, $namaProvinsi, $negara, $kodepos, $email, $hashed_password);

                if ($sql->execute()) {
                    header("Location: ../../");
                    exit();
                } else {
                    echo "Error: " . $sql->error;
                }
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        }
        $this->conn->close();
    }

    // Fungsi untuk mendapatkan nama provinsi berdasarkan ID
    public function getNamaProvinsiById($id) {
        $apiUrl = "https://tegar-arsya.github.io/api-indonesia/api/provinces.json";
        $response = file_get_contents($apiUrl);
        $provinces = json_decode($response, true);

        foreach ($provinces as $province) {
            if ($province['id'] == $id) {
                return $province['name'];
            }
        }

        return "Provinsi Tidak Ditemukan";
    }

    // Fungsi untuk mendapatkan nama kota/kabupaten berdasarkan ID
    public function getNamaKotaKabupatenById($provinceId, $regencyId) {
        $apiUrl = "https://tegar-arsya.github.io/api-indonesia/api/regencies/{$provinceId}.json";
        $response = file_get_contents($apiUrl);
        $regencies = json_decode($response, true);

        foreach ($regencies as $regency) {
            if ($regency['id'] == $regencyId) {
                return $regency['name'];
            }
        }

        return "Kota/Kabupaten Tidak Ditemukan";
    }
}

// Inisialisasi objek RegistrationManager dengan koneksi
$registrationManager = new RegistrationManager($conn);

// Memproses registrasi pengguna
$registrationManager->registerUser();
?>
