<?php
include('../controller/koneksi/config.php');

if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    // Query untuk mendapatkan nomor registrasi dari tabel registrasi berdasarkan id_user dan nik
    $query = "SELECT r.nomer_registrasi, p.nama_pengguna, p.opd_yang_dituju, p.tanggal_permohonan, r.nik, r.foto_ktp, r.no_hp, r.alamat, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi
              FROM registrasi r
              JOIN permohonan_informasi p ON p.id_user = r.nik
              WHERE p.id = $idPermohonan";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomorRegistrasi = $row['nomer_registrasi'];

        // Simpan data ke tabel verifikasi_permohon
        $insertQuery = "INSERT INTO verifikasi_permohonan (nomer_registrasi, nama_pengguna, tanggal_permohonan, nik, foto_ktp, no_hp, alamat, informasi_yang_dibutuhkan, alasan_pengguna_informasi, id_permohonan, opd_yang_dituju)
                        VALUES ('$nomorRegistrasi', '{$row['nama_pengguna']}', '{$row['tanggal_permohonan']}', '{$row['nik']}', '{$row['foto_ktp']}', '{$row['no_hp']}', '{$row['alamat']}', '{$row['informasi_yang_dibutuhkan']}', '{$row['alasan_pengguna_informasi']}', $idPermohonan, '{$row['opd_yang_dituju']}')";

        if ($conn->query($insertQuery) === TRUE) {
            // Data berhasil disimpan ke tabel verifikasi_permohon
            echo $nomorRegistrasi;
        } else {
            // Jika terjadi kesalahan saat menyimpan data, tampilkan pesan error
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } else {
        // Jika tidak ditemukan nomor registrasi, kirim pesan error
        echo "Error: Nomor registrasi tidak ditemukan.";
    }
} else {
    // Jika tidak ada ID permohonan yang dikirim, kirim pesan error
    echo "Error: ID permohonan tidak valid.";
}

// Tutup koneksi database
$conn->close();
?>
