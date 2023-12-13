<?php
date_default_timezone_set('Asia/Jakarta');

session_start();

if (!isset($_POST['user-input']) || $_POST['user-input'] !== $_SESSION['captcha']) {
    $response = array("success" => false, "error" => "CAPTCHA tidak sesuai. Silakan coba lagi.");
    echo json_encode($response);
    exit();
}

include('../controller/koneksi/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['nomer_registrasi'];
    $informasiyangdiminta = $_POST['informasiyangdiminta'];
    $kuasapermohon = $_POST['kuasapermohonan'];
    $namapemohon = $_POST['namapemohon'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nik = $_POST['nik'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];
    $kotakabupaten = $_POST['kota_kabupaten'];
    $negara = $_POST['negara'];
    $kodepos = $_POST['kode_pos'];
    $provinsi = $_POST['provinsi'];
    $opd = $_POST['opd'];
    $pekerjaan = $_POST['pekerjaan'];
    $alasanK = $_POST['alasankeberatan'];
    $tanggal_permohonan = $_POST['tanggal_permohonan'];
    $nik_pemohon = $_POST['nik_pemohon'];
    $emailpemohon = $_POST['emailpemohon'];
    $foto_ktp_pemohon = $_POST['foto_ktp_pemohon'];
    $namaProvinsi = getNamaProvinsiById($provinsi);
    $namaKotaKabupaten = getNamaKotaKabupatenById($provinsi, $kotakabupaten);

    // Fungsi untuk upload file fotoktp
    $uploadDir = "../Assets/uploads/keberatan/gambar/";
    $fotoktp = uploadFile('fotoktp', $uploadDir);

    // Fungsi untuk upload file surat kuasa
    $uploadDirSuratKuasa = "../Assets/uploads/keberatan/dokumen/";
    $suratkuaasa = uploadFile('suratkuasa', $uploadDirSuratKuasa);

   

    $sql = "INSERT INTO pengajuan_keberatan (kode_permohonan_informasi, informasi_yang_diminta, kuasa_permohonan, nama_pemohon, nama, email, nik, no_hp, foto_ktp, alamat, kota_kabupaten, negara, kode_pos, provinsi, opd_yang_dituju, pekerjaan, unggah_surat_kuasa, alasan_keberatan, tanggal_permohonan, nik_pemohon, email_pemohon, foto_ktp_pemohon) 
            VALUES ('$code', '$informasiyangdiminta', '$kuasapermohon', '$namapemohon', '$nama', '$email', '$nik', '$nohp', '$fotoktp', '$alamat', '$namaKotaKabupaten', '$negara', '$kodepos', '$namaProvinsi', '$opd', '$pekerjaan', '$suratkuaasa', '$alasanK', '$tanggal_permohonan', '$nik_pemohon', '$emailpemohon', '$foto_ktp_pemohon')";

    if ($conn->query($sql) === TRUE) {
        $response = array("success" => true);
        echo json_encode($response);
    } else {
        $response = array("success" => false, "error" => $conn->error);
        echo json_encode($response);
    }

    $conn->close();
}

// Fungsi untuk mengupload file
function uploadFile($inputName, $uploadDir) {
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
}
// Fungsi untuk mendapatkan nama provinsi berdasarkan ID
function getNamaProvinsiById($id) {
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
// Fungsi untuk mendapatkan nama kota/kabupaten berdasarkan ID
function getNamaKotaKabupatenById($provinceId, $regencyId) {
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

?>
