<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login_admin.php");
    exit();
}
$user_id = $_SESSION['id'];

include('../controller/koneksi/config.php');

if (isset($_GET['id'])) {
    $id_permohonan = $_GET['id'];


}


?>

<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap data.xls");

?>
<h1 style="text-align: center;margin-top: 100px;">REKAP DATA PERMOHONAN INFORMASI </h1>
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
            // Query untuk mendapatkan data permohonan dari database
            $query = "SELECT vp.*, sk.tanggal_survey FROM verifikasi_permohonan vp 
                                            LEFT JOIN survey_kepuasan sk ON vp.nomer_registrasi = sk.nomer_registrasi";
            $result = $conn->query($query);

            // Periksa apakah ada hasil dari query
            if ($result->num_rows > 0) {
                // Loop melalui hasil query dan tampilkan data dalam baris tabel
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['nomer_registrasi']}</td>";
                    echo "<td>{$row['nama_pengguna']}</td>";
                    echo "<td>{$row['no_hp']}</td>";
                    echo "<td>{$row['informasi_yang_dibutuhkan']}</td>";
                    echo "<td>{$row['opd_yang_dituju']}</td>";
                    echo "<td>{$row['tanggal_permohonan']}</td>";
                    echo "<td>{$row['tanggal_verifikasi']}</td>";
                    echo "<td>{$row['tanggal_survey']}</td>";
                    if (!empty($row['tanggal_survey'])) {
                        echo "<td>Permohonan Selesai</td>";
                    } elseif (!empty($row['tanggal_verifikasi'])) {
                        echo "<td>Sudah Verifikasi</td>";
                    } else {
                        echo "<td>Belum Verifikasi</td>";
                    }


                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>Tidak ada data permohonan yang ditemukan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>