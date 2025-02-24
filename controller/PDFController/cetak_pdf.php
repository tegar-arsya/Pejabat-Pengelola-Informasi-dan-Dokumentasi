<?php
session_start();
require_once('../../controller/koneksi/config.php');
require_once(__DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php');

// Start output buffering
ob_start();

$status = isset($_GET['status']) ? $_GET['status'] : 'reset';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Daftar Permohonan - PDF');
$pdf->SetSubject('Daftar Permohonan');
$pdf->SetKeywords('PDF, Permohonan, Jawa Tengah');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$html = '<h1>Daftar Permohonan Informasi</h1>';

$html .= '<table border="1">
    <tr>
        <th>Tanggal</th>
        <th>Nama</th>
        <th>Informasi yang Dibutuhkan</th>
        <th>Alasan Pengguna Informasi</th>
        <th>OPD yang ditujui</th>
    </tr>';

$sql = "SELECT pi.tanggal_permohonan, pi.nama_pengguna, pi.informasi_yang_dibutuhkan, pi.alasan_pengguna_informasi, pi.opd_yang_dituju,
        vp.nomer_registrasi IS NOT NULL AS verified
        FROM permohonan_informasi pi
        LEFT JOIN verifikasi_permohonan vp ON pi.id = vp.id_permohonan";

$whereClauses = [];
switch ($status) {
    case 'verified':
        $whereClauses[] = "vp.nomer_registrasi IS NOT NULL";
        break;
    case 'unverified':
        $whereClauses[] = "vp.nomer_registrasi IS NULL";
        break;
    case 'reset': // No filtering for 'reset'
        break;
    default: // Invalid status
        $whereClauses[] = "1"; // Fallback to displaying all records
}

if (!empty($start_date) && !empty($end_date)) {
    $whereClauses[] = "pi.tanggal_permohonan BETWEEN '$start_date' AND '$end_date'";
}

if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(' AND ', $whereClauses);
}

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $formattedDate = date('d-m-Y H:i:s', strtotime($row["tanggal_permohonan"]));
        $html .= "<tr>
            <td>" . $formattedDate . "</td>
            <td>" . htmlspecialchars($row["nama_pengguna"]) . "</td>
            <td>" . htmlspecialchars($row["informasi_yang_dibutuhkan"]) . "</td>
            <td>" . htmlspecialchars($row["alasan_pengguna_informasi"]) . "</td>
            <td>" . htmlspecialchars($row["opd_yang_dituju"]) . "</td>
        </tr>";
    }
} else {
    $html .= "<tr><td colspan='5'>Tidak ada data</td></tr>";
}

$html .= '</table>';

$stmt->close();

$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('daftar_permohonan.pdf', 'I');


?>
