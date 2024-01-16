<?php
// Include your database configuration file
include('../../controller/koneksi/config.php');

// Fetch data
$data = reloadDataK();

// Check if data is not empty
if (!empty($data)) {
    foreach ($data as $row) {
        // Display table row
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
        
        // Update status in the database
        $status = '';
        $sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        if (!empty($row['tanggal_survey'])) {
            $status = 'Permohonan Selesai';
        } elseif (!empty($row['tanggal_verifikasi']) && empty($row['tanggal_penolakan'])) {
            $status = 'Pengajuan keberatan informasi telah diverifikasi oleh admin';
        } elseif (!empty($row['tanggal_penolakan'])) {
            $tanggalPenolakan = (new DateTime())->setTimestamp(strtotime($row['tanggal_penolakan']));
            $tanggalPenolakan->add(new DateInterval('P3D'));
            if ($sekarang <= $tanggalPenolakan) {
                $status = 'Pending';
                $note = !empty($row['note']) ? $row['note'] : '';
            } else {
                $status = 'Gugur';
            }
        } else {
            $status = 'Belum Verifikasi';
        }

        // Execute the update status query
        $updateStatusQuery = "UPDATE verifikasi_keberatan SET status=? WHERE nomer_registrasi_keberatan=?";
        $stmt = $conn->prepare($updateStatusQuery);
        $stmt->bind_param("ss", $status, $row['nomer_registrasi_keberatan']);
        $stmt->execute();
        $stmt->close();

        // Display the status column
        $statusDisplay = $status;
        if ($status === 'Pending') {
            $statusDisplay .= " ($note)";
        }
        echo "<td>" . htmlspecialchars($statusDisplay) . "</td>";

        // Close the table row
        echo "</tr>";
    }
} else {
    // If no data found, display a single row with a message
    echo '<tr><td colspan="11">No data found</td></tr>';
}

// Close your database connection if needed
// $conn->close();

// Function to fetch data
function reloadDataK() {
    include('../../controller/koneksi/config.php');
    $query = "SELECT DISTINCT vk.nomer_registrasi_keberatan, vk.*, vk.tanggal_permohonan, vk.tanggal_verifikasi, sk.tanggal_survey, pk.nama_pemohon, vk.alasan_keberatan, vk.opd_yang_dituju, tp.tanggal_penolakan
              FROM verifikasi_keberatan vk
              LEFT JOIN survey_kepuasan_keberatan sk ON vk.nomer_registrasi_keberatan = sk.nomer_registrasi_keberatan
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
