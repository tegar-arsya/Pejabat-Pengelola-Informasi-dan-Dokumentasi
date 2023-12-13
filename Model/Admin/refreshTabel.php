<?php
include('../controller/koneksi/config.php');
$data = reloadData();

if (!empty($data)) {
    foreach ($data as $row) {
        echo "<tr>";
        echo "<td><input type='checkbox' class='select-row'></td>";
        echo "<td>" . htmlspecialchars($row['nomer_registrasi']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_pengguna']) . "</td>";
        echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
        echo "<td>" . htmlspecialchars($row['informasi_yang_dibutuhkan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['opd_yang_dituju']) . "</td>";
        echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
        echo "<td>" . (!empty($row['tanggal_verifikasi']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi']))) : '') . "</td>";
        echo "<td>" . (!empty($row['tanggal_survey']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_survey']))) : '') . "</td>";
        echo "<td><button class='btn btn-info btn-sm' onclick='showDetail()'>Detail</button>";
        echo "<button class='btn btn-danger btn-sm' onclick='HapusVerifikasi(\"{$row['nomer_registrasi']}\")'>Hapus</button>";
        echo "<a href='formAnswer?registrasi=" . $row["nomer_registrasi"] . "' class='btn btn-success btn-sm'>Jawaban Permohonan</a>";

        // Pastikan bahwa nilai status adalah valid
        $status = htmlspecialchars($row['status']);
        if (!empty($row['kode_permohonan_informasi'])) {
            // Jika ada pengajuan keberatan, atur status ke 'Pengajuan Keberatan'
            $status = 'Pengajuan Keberatan';
        } else {
            // Jika status masih kosong, hitung ulang berdasarkan logika yang diberikan
            if (empty($status)) {
                $sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                if (!empty($row['tanggal_survey'])) {
                    $status = 'Permohonan Selesai';
                } elseif (!empty($row['tanggal_verifikasi']) && empty($row['tanggal_penolakan'])) {
                    $status = 'Permohonan informasi Sudah Diverifikasi Oleh Admin.';
                } elseif (!empty($row['tanggal_penolakan'])) {
                    // Cek apakah sudah 3 hari setelah tanggal penolakan
                    $tanggalPenolakan = (new DateTime())->setTimestamp(strtotime($row['tanggal_penolakan']));
                    $tanggalPenolakan->add(new DateInterval('P3D')); // Tambah 3 hari

                    if ($sekarang <= $tanggalPenolakan) {
                        $status = 'Pending';
                    } else {
                        // Jika lebih dari 3 hari, dianggap 'Gugur'
                        $status = 'Gugur';
                    }
                } else {
                    $status = 'Belum Verifikasi';
                }

                // Update status ke database
                $updateStatusQuery = "UPDATE verifikasi_permohonan SET status=? WHERE nomer_registrasi=?";
                $stmt = $conn->prepare($updateStatusQuery);
                $stmt->bind_param("ss", $status, $row['nomer_registrasi']);
                $stmt->execute();
                $stmt->close();
            }
        }

        echo "<td>" . htmlspecialchars($status) . "</td>";
        echo "</tr>";
    }
} else {
    echo '<tr><td colspan="11">No data found</td></tr>';
}

function reloadData() {
    include('../controller/koneksi/config.php');
    $query = "SELECT DISTINCT vp.nomer_registrasi, vp.*, sk.tanggal_survey, pi.nama_pengguna, tr.tanggal_penolakan, pk.kode_permohonan_informasi
    FROM verifikasi_permohonan vp
    LEFT JOIN survey_kepuasan sk ON vp.nomer_registrasi = sk.nomer_registrasi
    LEFT JOIN permohonan_informasi pi ON vp.nama_pengguna = pi.nama_pengguna
    LEFT JOIN tbl_rejected tr ON vp.nomer_registrasi = tr.nomer_registrasi
    LEFT JOIN pengajuan_keberatan pk ON vp.nomer_registrasi = pk.kode_permohonan_informasi";

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
