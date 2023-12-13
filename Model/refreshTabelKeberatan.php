<?php
include('../controller/koneksi/config.php');
$data = reloadDataK();

if (!empty($data)) {
    foreach ($data as $row) {
        echo "<tr>";
        echo "<td><input type='checkbox' class='select-row'></td>";
        echo "<td>{$row['nomer_registrasi_keberatan']}</td>";
        echo "<td>{$row['nama_pemohon']}</td>";
        echo "<td>{$row['alasan_keberatan']}</td>";
        echo "<td>{$row['opd_yang_dituju']}</td>";
        echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
        echo "<td>" . (!empty($row['tanggal_verifikasi']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi']))) : '') . "</td>";
        echo "<td>" . (!empty($row['tanggal_survey']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_survey']))) : '') . "</td>";
        echo "<td>";
        echo "<a href='detailNote?registrasi=" . $row["nomer_registrasi_keberatan"] . "' class='btn btn-success btn-sm'>Detail</a>";
        echo "<button class='btn btn-danger btn-sm' onclick='HapusVerifikasi(\"{$row['nomer_registrasi_keberatan']}\")'>Hapus</button>";
        echo "<a href='formAnswerKeberatan?registrasi=" . $row["nomer_registrasi_keberatan"] . "' class='btn btn-success btn-sm'>Jawab</a>";
        echo "<a href='Note?registrasi=" . $row["nomer_registrasi_keberatan"] . "' class='btn btn-primary btn-sm'><i class='fas fa-sticky-note'></i> Note</a>";
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

<?php
function reloadDataK() {
    include('../controller/koneksi/config.php');
    $query = "SELECT DISTINCT vk.nomer_registrasi_keberatan, vk.*, vk.tanggal_permohonan, vk.tanggal_verifikasi, sk.tanggal_survey, pk.nama_pemohon, vk.alasan_keberatan, vk.opd_yang_dituju, tp.tanggal_penolakan
                                            FROM verifikasi_keberatan vk
                                            LEFT JOIN survey_kepuasan_keberatan sk ON vk.nama_pemohon = sk.nama_pengguna
                                            LEFT JOIN pengajuan_keberatan pk ON vk.nomer_registrasi_keberatan = pk.nomer_registrasi_keberatan
                                            LEFT JOIN tbl_penolakan tp ON vk.nomer_registrasi_keberatan = tp.nomer_registrasi_keberatan";
    $result = $conn->query($query);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}
?>
