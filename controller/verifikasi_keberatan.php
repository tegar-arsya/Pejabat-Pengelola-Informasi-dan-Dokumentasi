<?php
include('../controller/koneksi/config.php');

if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    // Query to get registration number from the registration table based on id_user and nik
    $query = "SELECT nama_pemohon, nomer_registrasi_keberatan, kode_permohonan_informasi,
    tanggal_permohonan, nik_pemohon, foto_ktp, informasi_yang_diminta, alasan_keberatan, nama,
    pekerjaan, unggah_surat_kuasa
    FROM pengajuan_keberatan WHERE id = $idPermohonan";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomorRegistrasiKeberatan = $row['nomer_registrasi_keberatan'];

        // Output the registration number as response
        echo $nomorRegistrasiKeberatan;
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
