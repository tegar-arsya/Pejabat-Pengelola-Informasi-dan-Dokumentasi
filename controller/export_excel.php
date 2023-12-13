<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login_admin.php");
    exit();
}
$user_id = $_SESSION['id'];

include '../controller/koneksi/config.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap_data.xls");
?>

<h1 style="text-align: center; margin-top: 100px;">REKAP DATA PERMOHONAN INFORMASI</h1>
<div class="table-responsive">
    <table border="10" align="center">
        <thead>
            <tr>
                <th>No. Register</th>
                <th>Nama</th>
                <th>No.HP</th>
                <th>Informasi yang Dibutuhkan</th>
                <th>OPD yang ditujui</th>
                <th>Tanggal Masuk</th>
                <th>Tangal Verifikasi</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php

$query = "SELECT DISTINCT vp.nomer_registrasi, vp.*, sk.tanggal_survey, pi.nama_pengguna, tr.tanggal_penolakan, pk.kode_permohonan_informasi
                                            FROM verifikasi_permohonan vp
                                            LEFT JOIN survey_kepuasan sk ON vp.nomer_registrasi = sk.nomer_registrasi
                                            LEFT JOIN permohonan_informasi pi ON vp.nama_pengguna = pi.nama_pengguna
                                            LEFT JOIN tbl_rejected tr ON vp.nomer_registrasi = tr.nomer_registrasi
                                            LEFT JOIN pengajuan_keberatan pk ON vp.nomer_registrasi = pk.kode_permohonan_informasi";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nomer_registrasi']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_pengguna']) . "</td>";
        echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
        echo "<td>" . htmlspecialchars($row['informasi_yang_dibutuhkan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['opd_yang_dituju']) . "</td>";
        echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
        echo "<td>" . (!empty($row['tanggal_verifikasi']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi']))) : '') . "</td>";
        echo "<td>" . (!empty($row['tanggal_survey']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_survey']))) : '') . "</td>";

        // Menentukan status
        $status = '';
        if (!empty($row['kode_permohonan_informasi'])) {
            // Jika ada pengajuan keberatan, atur status ke 'Pengajuan Keberatan'
            $status = 'Pengajuan Keberatan';
        } else {
        $sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));

        if (!empty($row['tanggal_survey'])) {
            $status = 'Permohonan Selesai';
        } elseif (!empty($row['tanggal_verifikasi']) && empty($row['tanggal_penolakan'])) {
            $status = 'Permohonan informasi Sudah Diverifikasi Oleh Admin.';
        } elseif (!empty($row['tanggal_penolakan'])) {
            $tanggalPenolakan = (new DateTime())->setTimestamp(strtotime($row['tanggal_penolakan']));
            $tanggalPenolakan->add(new DateInterval('P3D'));

            if ($sekarang <= $tanggalPenolakan) {
                $status = 'Pending';
            } else {
                $status = 'Gugur';
            }
        } else {
            $status = 'Belum Verifikasi';
        }
    }
        $updateStatusQuery = "UPDATE verifikasi_permohonan SET status='$status'
                    WHERE nomer_registrasi='{$row['nomer_registrasi']}'";
        $conn->query($updateStatusQuery);

        echo "<td>" . htmlspecialchars($status) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='11'>Tidak ada data permohonan yang ditemukan.</td></tr>";
}
?>
        </tbody>
    </table>
</div>
