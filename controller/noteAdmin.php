<?php
// Include konfigurasi koneksi database
include('../controller/koneksi/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'];
    $namaPemohon = $_POST['nama'];
    $nomerRegistrasiKeberatan = $_POST['norek'];

    // Siapkan query untuk menyimpan data ke database
    $insertQuery = "INSERT INTO note_admin (nomer_registrasi_keberatan, nama_pemohon, keterangan, status ) VALUES (?, ?, ?, ?)";
    
    // Persiapkan statement
    $stmt = $conn->prepare($insertQuery);

    // Bind parameter ke statement
    $stmt->bind_param("ssss", $nomerRegistrasiKeberatan, $namaPemohon, $keterangan, $status );

    // Eksekusi statement untuk menyimpan data
    if ($stmt->execute()) {
        // Tutup statement
        $stmt->close();

        // Arahkan kembali ke halaman ../view/detailK
        header("Location: ../view/daftarK");
        exit(); // Pastikan untuk keluar dari skrip setelah mengarahkan header
    } else {
        echo "Gagal menyimpan data: " . $stmt->error;
    }
}

// Tutup koneksi database
$conn->close();
?>
