<?php
include('../controller/koneksi/config.php');
require_once(__DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php');
require_once __DIR__ . '/../vendor/autoload.php';

if (isset($_POST['id'])) {
    $idPermohonan = $_POST['id'];

    // Query untuk mendapatkan nomor registrasi dari tabel registrasi berdasarkan id_user dan nik
    $query = "SELECT nama_pemohon, nomer_registrasi_keberatan, 
    tanggal_permohonan, nik_pemohon, foto_ktp, informasi_yang_diminta, alasan_keberatan, nama,
    pekerjaan, unggah_surat_kuasa, opd_yang_dituju
    FROM pengajuan_keberatan WHERE id = $idPermohonan";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomorRegistrasiKeberatan = $row['nomer_registrasi_keberatan'];

        // Simpan data ke tabel verifikasi_permohon
        $insertQuery = "INSERT INTO verifikasi_keberatan (nomer_registrasi_keberatan, nama_pemohon, tanggal_permohonan, nik_pemohon, foto_ktp, opd_yang_dituju, informasi_yang_diminta,alasan_keberatan, nama_kuasa, pekerjaan, surat_kuasa, id_permohonan)
                        VALUES ('$nomorRegistrasiKeberatan', '{$row['nama_pemohon']}', '{$row['tanggal_permohonan']}', '{$row['nik_pemohon']}', '{$row['foto_ktp']}', '{$row['opd_yang_dituju']}', '{$row['informasi_yang_diminta']}','{$row['alasan_keberatan']}','{$row['nama']}', '{$row['pekerjaan']}', '{$row['unggah_surat_kuasa']}', $idPermohonan)";

        if ($conn->query($insertQuery) === TRUE) {
            // Data berhasil disimpan ke tabel verifikasi_permohon
            // include('../controller/pdfGenerate.php');
            echo $nomorRegistrasiKeberatan;
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


?>
