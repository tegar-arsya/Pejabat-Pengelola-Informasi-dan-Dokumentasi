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
header("Content-Disposition: attachment; filename=rekap_data_keberatan.xls");
?>

<h1 style="text-align: center; margin-top: 100px;">REKAP DATA KEKEBRATAN INFORMASI</h1>
<div class="table-responsive">
    <table border="10" align="center">
        <thead>
            <tr>
            <th>No. Register Keberatan</th>
            <th>Nama Pemohon</th><th>Alasan Keberatan</th>
            <th>OPD yang ditujui</th>
            <th>Tanggal Permohonan</th>
            <th>Tangal Verifikasi</th>
            <th>Tanggal Selesai</th>
            <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT DISTINCT vk.nomer_registrasi_keberatan, vk.*, vk.tanggal_permohonan, vk.tanggal_verifikasi, sk.tanggal_survey, pk.nama_pemohon, vk.alasan_keberatan, vk.opd_yang_dituju, tp.tanggal_penolakan
            FROM verifikasi_keberatan vk
            LEFT JOIN survey_kepuasan_keberatan sk ON vk.nomer_registrasi_keberatan = sk.nomer_registrasi_keberatan
            LEFT JOIN pengajuan_keberatan pk ON vk.nomer_registrasi_keberatan = pk.nomer_registrasi_keberatan
            LEFT JOIN tbl_penolakan tp ON vk.nomer_registrasi_keberatan = tp.nomer_registrasi_keberatan
            ORDER BY vk.nomer_registrasi_keberatan ASC";

$stmt = $conn->prepare($query);
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

                                                    }else {
                                                        $status = 'Belum Verifikasi';
                                                    }
                                                    $updateStatusQuery = "UPDATE verifikasi_keberatan SET status='$status' 
                                                    WHERE nomer_registrasi_keberatan='{$row['nomer_registrasi_keberatan']}'";
                                                    $conn->query($updateStatusQuery);

                                                    echo "<td>{$status}</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                            }
                                            ?>
        </tbody>
    </table>
</div>
