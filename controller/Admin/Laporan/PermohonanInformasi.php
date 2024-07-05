<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/login_admin.php");
    exit();
}
$user_id = $_SESSION['id'];

include '../../../controller/koneksi/config.php';

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=rekap data pengajuan permohonan-{$start_date} to {$end_date}.xls");
    ?>

    <h1 style="text-align: center; margin-top: 100px;">REKAP Permohonan Informasi Pemohon</h1>
    <div class="table-responsive">
        <table border="10" align="center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Register</th>
                    <th>Nama</th>
                    <th>OPD Yang Di Tuju</th>
                    <th>Informasi Yang Dibutuhkan</th>
                    <th>Alasan Penggunaan Permohonan Informasi</th>
                    <th>Cara Mendapatkan Permohonan Informasi</th>
                    <th>Cara Mendapatkan Salinan Permohonan</th>
                    <th>Tanggal Pengajuan Permohonan</th>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM permohonan_informasi WHERE tanggal_permohonan BETWEEN ? AND ?";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    echo "Error preparing statement: " . $conn->error;
                } else {
                    $stmt->bind_param("ss", $start_date, $end_date);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $nomer = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $nomer++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['nomer_registrasi']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_pengguna']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['opd_yang_dituju']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['informasi_yang_dibutuhkan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['alasan_pengguna_informasi']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['cara_mendapatkan_informasi']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['cara_mendapatkan_salinan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tanggal_permohonan']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>Tidak ada data permohonan yang ditemukan.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
} else {
    echo "Tanggal mulai dan tanggal akhir diperlukan.";
}
?>
