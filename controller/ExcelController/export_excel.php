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
    header("Content-Disposition: attachment; filename=rekap_data-{$start_date}-{$end_date}.xls");
?>

<h1 style="text-align: center; margin-top: 100px;">REKAP DATA PERMOHONAN INFORMASI</h1>
<div class="table-responsive">
    <table border="10" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Register</th>
                <th>Nama</th>
                <th>No.HP</th>
                <th>Informasi yang Dibutuhkan</th>
                <th>OPD yang ditujui</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Verifikasi</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query yang telah diperbaiki dengan WHERE clause sebelum ORDER BY
            $query = "SELECT DISTINCT vp.id_permohonan, vp.*, sk.tanggal_survey, pi.id, pi.tanggal_permohonan, pi.informasi_yang_dibutuhkan, pi.opd_yang_dituju, tr.note, tr.tanggal_penolakan, pk.kode_permohonan_informasi, r.*
                      FROM verifikasi_permohonan vp
                      LEFT JOIN survey_kepuasan sk ON vp.id_permohonan = sk.id_permohonan
                      LEFT JOIN permohonan_informasi pi ON vp.id_permohonan = pi.id
                      LEFT JOIN tbl_rejected tr ON vp.id_permohonan = tr.id_permohonan
                      LEFT JOIN pengajuan_keberatan pk ON vp.id_permohonan = pk.id_permohonan_informasi
                      LEFT JOIN registrasi r ON pi.id_registrasi = r.id
                      WHERE vp.tanggal_verifikasi BETWEEN ? AND ?
                      ORDER BY vp.id_permohonan ASC";
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
                        echo "<td>" . htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']) . "</td>";
                        echo "<td>'" . htmlspecialchars($row['no_hp']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['informasi_yang_dibutuhkan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['opd_yang_dituju']) . "</td>";
                        echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
                        echo "<td>" . (!empty($row['tanggal_verifikasi']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi']))) : '') . "</td>";
                        echo "<td>" . (!empty($row['tanggal_survey']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_survey']))) : '') . "</td>";

                        // Menentukan status
                        $status = '';
                        if (!empty($row['kode_permohonan_informasi'])) {
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

                        echo "<td>" . htmlspecialchars($status) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>Tidak ada data permohonan yang ditemukan.</td></tr>";
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
