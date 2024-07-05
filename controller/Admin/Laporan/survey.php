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
    header("Content-Disposition: attachment; filename=rekap_data_survey-{$start_date}_to_{$end_date}.xls");
    ?>

    <h1 style="text-align: center; margin-top: 100px;">REKAP Survey Kepuasan Pemohon</h1>
    <div class="table-responsive">
        <table border="10" align="center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Register</th>
                    <th>Nama</th>
                    <th>Usia</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    <th>Jenis Layanan</th>
                    <th>Persyaratan</th>
                    <th>Prosedur</th>
                    <th>Waktu</th>
                    <th>Biaya</th>
                    <th>Hasil</th>
                    <th>Kompetensi</th>
                    <th>Perilaku</th>
                    <th>Pelayanan</th>
                    <th>Petugas</th>
                    <th>Tanggal Survey</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT nomer_registrasi, nama_pengguna, usia, pendidikan, pekerjaan, jenis_layanan, persyaratan, prosedur, waktu, biaya, hasil, kompetensi, perilaku, pelayanan, petugas, tanggal_survey
                          FROM survey_kepuasan
                          WHERE tanggal_survey BETWEEN ? AND ?
                          UNION ALL
                          SELECT nomer_registrasi_keberatan, nama_pengguna, usia, pendidikan, pekerjaan, jenis_layanan, persyaratan, prosedur, waktu, biaya, hasil, kompetensi, perilaku, pelayanan, petugas, tanggal_survey
                          FROM survey_kepuasan_keberatan
                          WHERE tanggal_survey BETWEEN ? AND ?";

                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    echo "Error preparing statement: " . $conn->error;
                } else {
                    $stmt->bind_param("ssss", $start_date, $end_date, $start_date, $end_date);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $nomer = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $nomer++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['nomer_registrasi'] ? $row['nomer_registrasi'] : $row['nomer_registrasi_keberatan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_pengguna']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['usia']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['pendidikan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['pekerjaan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['jenis_layanan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['persyaratan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['prosedur']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['waktu']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['biaya']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['hasil']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['kompetensi']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['perilaku']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['pelayanan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['petugas']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tanggal_survey']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='17'>Tidak ada data permohonan yang ditemukan.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        Note: Urutan point adalah Sangat Sulit 1 2 3 4 Sangat Mudah
    </div>
    <?php
} else {
    echo "Tanggal mulai dan tanggal akhir diperlukan.";
}
?>
