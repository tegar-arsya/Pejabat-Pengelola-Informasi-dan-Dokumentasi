<?php
// Koneksi ke database
require '../../controller/koneksi/config.php';

// Periksa apakah permintaan adalah metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan dari klien
    $nomer_registrasi_keberatan = $_POST['nomer_registrasi'];
    $nama_pemohon = $_POST['nama'];
    $alasan = $_POST['alasan'];

    // Buat dan jalankan query untuk menyimpan data ke dalam database
    $sql = "INSERT INTO pesan_tidak_puas (nomer_registrasi_keberatan, nama_pemohon, alasan) VALUES ('$nomer_registrasi_keberatan', '$nama_pemohon', '$alasan')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan"; // Tanggapan untuk klien
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Tanggapan jika terjadi kesalahan
    }

    // Tutup koneksi ke database
    $conn->close();
}
?>
