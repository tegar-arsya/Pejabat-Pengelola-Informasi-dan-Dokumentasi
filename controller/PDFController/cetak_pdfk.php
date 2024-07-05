<?php
session_start();
require_once('../../controller/koneksi/config.php');
require_once(__DIR__ . '../../../vendor/tecnickcom/tcpdf/tcpdf.php');

// Ensure no output is sent before PDF generation
ob_start();

$status = isset($_GET['status']) ? $_GET['status'] : 'reset';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Daftar Keberatan Permohonan - PDF');
$pdf->SetSubject('Daftar Keberatan Permohonan');
$pdf->SetKeywords('PDF, Permohonan, Jawa Tengah');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$html = '<h1>Daftar Permohonan Keberatan Informasi</h1>';

$html .= '<table border="1">
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama</th>
        <th>Nomer Registrasi Keberatan</th>
        <th>Informasi yang Dibutuhkan</th>
        <th>Alasan Pengguna Informasi</th>
        <th>OPD yang ditujui</th>
    </tr>';

    $sql = "SELECT pi.tanggal_pengajuan,pi.nomer_registrasi_keberatan, pi.nama_pemohon, pi.informasi_yang_diminta, pi.alasan_keberatan, pi.opd_yang_dituju,
    vp.nomer_registrasi_keberatan IS NOT NULL AS verified
    FROM pengajuan_keberatan pi
    LEFT JOIN verifikasi_keberatan vp ON pi.id = vp.id_permohonan_keberatan";

$whereClauses = [];
switch ($status) {
    case 'verified':
        $whereClauses[] = "vp.nomer_registrasi_keberatan IS NOT NULL";
        break;
    case 'unverified':
        $whereClauses[] = "vp.nomer_registrasi_keberatan IS NULL";
        break;
    case 'reset': // No filtering for 'reset'
        break;
    default: // Invalid status
        $whereClauses[] = "1"; // Fallback to displaying all records
}

if (!empty($start_date) && !empty($end_date)) {
    $whereClauses[] = "pi.tanggal_pengajuan BETWEEN '$start_date' AND '$end_date'";
}

if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(' AND ', $whereClauses);
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        $formattedDate = date('d-m-Y H:i:s', strtotime($row["tanggal_pengajuan"]));
        $html .= "<tr>
            <td>" . $counter++ . "</td>
            <td>" . $formattedDate . "</td>
            <td>" . $row["nama_pemohon"] . "</td>
            <td>" . $row["nomer_registrasi_keberatan"] . "</td>
            <td>" . $row["informasi_yang_diminta"] . "</td>
            <td>" . $row["alasan_keberatan"] . "</td>
            <td>" . $row["opd_yang_dituju"] . "</td>
        </tr>";
    }
} else {
    $html .= "<tr><td colspan='5'>Tidak ada data</td></tr>";
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('daftar_permohonan-kwbweatN.pdf', 'I');
?>