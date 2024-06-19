<?php
session_start();
require_once('../../controller/koneksi/config.php');
require_once(__DIR__ . '../../../vendor/tecnickcom/tcpdf/tcpdf.php');

// Ensure no output is sent before PDF generation
ob_clean();

$status = $_GET['status'];

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

$sql = "SELECT * FROM permohonan_informasi WHERE 1";

if ($status === 'verified') {
    $sql .= " AND nomer_registrasi IS NOT NULL";
} elseif ($status === 'unverified') {
    $sql .= " AND nomer_registrasi IS NULL";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $formattedDate = date('d-m-Y H:i:s', strtotime($row["tanggal_permohonan"]));
        $html .= "<tr>
            <td>" . $formattedDate . "</td>
            <td>" . $row["nama_pengguna"] . "</td>
            <td>" . $row["informasi_yang_dibutuhkan"] . "</td>
            <td>" . $row["alasan_pengguna_informasi"] . "</td>
            <td>" . $row["opd_yang_dituju"] . "</td>
        </tr>";
    }
} else {
    $html .= "<tr><td colspan='5'>Tidak ada data</td></tr>";
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('daftar_permohonan.pdf', 'I');
