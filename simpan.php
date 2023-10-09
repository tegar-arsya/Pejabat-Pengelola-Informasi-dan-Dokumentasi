<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "permohonan_informasi";

// Membuat koneksi ke database
$conn = new mysqli($server, $user, $pass, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Menerima data dari formulir
$namadepan = $_POST['namadepan'];
$namabelakang = $_POST['namabelakang'];
$jenisnik = $_POST['jns_nik'];
$jenispemohon = $_POST['jns_pemohon'];
$nik = $_POST['nik'];
$fotoktp = $_FILES['fotoktp']['name'];
$npwp = $_POST['npwp'];
$pekerjaan = $_POST['pekerjaan'];
$alamat = $_POST['alamat'];
$kotakabupaten = $_POST['kota_kabupaten'];
$provinsi = $_POST['provinsi'];
$kodepos = $_POST['kode_pos'];
$email = $_POST['email'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Mengelola unggahan file
$targetDirectory = "uploads/";
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
        $sql = $conn->prepare("INSERT INTO registrasi (nama_depan, nama_belakang, jenis_nik, jenis_pemohon, nik, foto_ktp, npwp, pekerjaan, alamat, kota_kabupaten, provinsi, kode_pos, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("ssssssssssssss", $namadepan, $namabelakang, $jenisnik, $jenispemohon, $nik, $fotoktp, $npwp, $pekerjaan, $alamat, $kotakabupaten, $provinsi, $kodepos, $email, $hashed_password);

        if ($sql->execute()) {
            header("Location: index.php"); 
            exit();
        } else {
            echo "Error: " . $sql->error;
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah file.";
    }
}
$conn->close();
?>
