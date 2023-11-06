<?php
include('../controller/koneksi/config.php');

if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    // Query to get registration number from the registration table based on id_user and nik
    $query = "SELECT r.nomer_registrasi, p.nama_pengguna, p.opd_yang_dituju, p.tanggal_permohonan, r.nik, r.foto_ktp, r.no_hp, r.alamat, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi
              FROM registrasi r
              JOIN permohonan_informasi p ON p.id_user = r.nik
              WHERE p.id = $idPermohonan";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomorRegistrasi = $row['nomer_registrasi'];

        // Output the registration number as response
        echo $nomorRegistrasi;
    } else {
        // If no registration number is found, send an error message
        echo "Error: Nomor registrasi tidak ditemukan.";
    }
} else {
    // If no valid ID permohonan is sent, send an error message
    echo "Error: ID permohonan tidak valid.";
}

// Close the database connection
$conn->close();
?>
