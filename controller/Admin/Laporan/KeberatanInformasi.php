<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/login_admin.php");
    exit();
}
$user_id = $_SESSION['id'];

include '../../../controller/koneksi/config.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap data pengajuan keberatan permohonan.xls");
?>

<h1 style="text-align: center; margin-top: 100px;">REKAP Permohonan  Keberatan Informasi Pemohon</h1>
<div class="table-responsive">
    <table border="10" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Register</th>
                <th>Nama</th>
                <th>Informasi Yang Diminta</th>
                <th>Dikuasakan Kepada</th>
                <th>OPD Yang Di Tuju</th>
                <th>Alasan Keberatan Permohonan Informasi</th>
                <th>Tanggal Pengajuan Keberatan Permohonan Informasi</th>
        </thead>
        <tbody>
            <?php
            $query = "SELECT  * FROM pengajuan_keberatan";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $nomer = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $nomer++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nomer_registrasi_keberatan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_pemohon']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['informasi_yang_diminta']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['opd_yang_dituju']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alasan_keberatan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggal_pengajuan']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='17'>Tidak ada data permohonan yang ditemukan.</td></tr>";
            }
            ?>
            
        </tbody>
        
    </table>
</div>