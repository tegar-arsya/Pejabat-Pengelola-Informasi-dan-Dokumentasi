<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/login_admin.php");
    exit();
}
$user_id = $_SESSION['id'];

include '../../controller/koneksi/config.php';
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap_data_keberatan-{$start_date}-{$end_date}.xls");
?>

<h1 style="text-align: center; margin-top: 100px;">REKAP DATA KEKEBRATAN INFORMASI</h1>
<div class="table-responsive">
    <table border="10" align="center">
        <thead>
            <tr>
                <th>No. Register Keberatan</th>
                <th>Nama Pemohon</th>
                <th>Alasan Keberatan</th>
                <th>OPD yang ditujui</th>
                <th>Tanggal Permohonan</th>
                <th>Tangal Verifikasi</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT DISTINCT vk.id_permohonan_keberatan, vk.*, pk.tanggal_permohonan, vk.tanggal_verifikasi,sk.id_permohonan_keberatan, sk.tanggal_survey, pk.id, pk.nama_pemohon, pk.alasan_keberatan, pk.opd_yang_dituju, tp.id_permohonan_keberatan, tp.tanggal_penolakan
            FROM verifikasi_keberatan vk
            LEFT JOIN survey_kepuasan_keberatan sk ON vk.id_permohonan_keberatan = sk.id_permohonan_keberatan
            LEFT JOIN pengajuan_keberatan pk ON vk.id_permohonan_keberatan = pk.id
            LEFT JOIN tbl_penolakan tp ON vk.id_permohonan_keberatan = tp.id_permohonan_keberatan
            WHERE vk.tanggal_verifikasi BETWEEN ? AND ?
            ORDER BY vk.id_permohonan_keberatan ASC";

            $stmt = $conn->prepare($query);
            if (!$stmt) {
                echo "Error preparing statement: " . $conn->error;
            } else {
                $stmt->bind_param("ss", $start_date, $end_date);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['nomer_registrasi_keberatan']}</td>";
                    echo "<td>{$row['nama_pemohon']}</td>";
                    echo "<td>{$row['alasan_keberatan']}</td>";
                    echo "<td>{$row['opd_yang_dituju']}</td>";
                    echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
                    echo "<td>" . (!empty($row['tanggal_verifikasi']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi']))) : '') . "</td>";
                    echo "<td>" . (!empty($row['tanggal_survey']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_survey']))) : '') . "</td>";

                    $status = '';
                    $sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                    if (!empty($row['tanggal_survey'])) {
                        $status = 'Permohonan Selesai';
                    } elseif (!empty($row['tanggal_verifikasi']) && empty($row['tanggal_penolakan'])) {
                        $status = 'Pengajuan keberatan informasi telah diverifikasi oleh admin';
                    } elseif (!empty($row['tanggal_penolakan'])) {
                        // Cek apakah sudah 3 hari setelah tanggal penolakan
                        $tanggalPenolakan = (new DateTime())->setTimestamp(strtotime($row['tanggal_penolakan']));
                        $tanggalPenolakan->add(new DateInterval('P3D')); // Tambah 3 hari
                        // echo 'Tanggal Penolakan: ' . $tanggalPenolakan->format('Y-m-d H:i:s') . '<br>';
                        // echo 'Sekarang: ' . $sekarang->format('Y-m-d H:i:s') . '<br>';

                        if ($sekarang <= $tanggalPenolakan) {
                            $status = 'Pending';
                        } else {
                            // Jika lebih dari 3 hari, dianggap 'Gugur'
                            $status = 'Gugur';
                        }
                    } else {
                        $status = 'Belum Verifikasi';
                    }
                    $updateStatusQuery = "UPDATE verifikasi_keberatan SET status='$status' 
                                                    WHERE id_permohonan_keberatan='{$row['id_permohonan_keberatan']}'";
                    $conn->query($updateStatusQuery);

                    echo "<td>{$status}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Data tidak ditemukan.</td></tr>";
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
