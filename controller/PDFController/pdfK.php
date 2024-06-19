<?php
require_once(__DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php');
require_once __DIR__ . '/../../vendor/autoload.php';

// Include the database configuration file
include('../../controller/koneksi/config.php');

// Create instance of TCPDF class
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nama Anda');
$pdf->SetTitle('DAFTAR KEBERATAN PERMOHONAN INFORMASI');
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->SetFont('times', '', 12);

// Add a page
$pdf->AddPage();

// Set content
$html = '<h1 style="text-align:center; color:#ff0019;">Data Daftar Keberatan Permohonan Informasi</h1>';
$html .= '<table border="1" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background-color: #ffee00;">
                    <th style="padding: 10px; text-align: left;">No</th>
                    <th style="padding: 10px; text-align: left;">Nama</th>
                    <th style="padding: 10px; text-align: left;">No.Register</th>
                    <th style="padding: 10px; text-align: left;">NIK</th>
                    <th style="padding: 10px; text-align: left;">OPD yang ditujui</th>
                    <th style="padding: 10px; text-align: left;">Informasi yang Dibutuhkan</th>
                    <th style="padding: 10px; text-align: left;">Alasan Keberatan</th>
                    
                </tr>
            </thead>
            <tbody>';

try {
    $sql = "SELECT * FROM pengajuan_keberatan";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $counter = 1;
        while ($row = $result->fetch_assoc()) {
            $html .= "<tr>
                        <td style='padding: 10px;'>" . $counter . "</td>
                        <td style='padding: 10px;'>" . $row["nama_pemohon"] . "</td>
                        <td style='padding: 10px;'>" . $row["nomer_registrasi_keberatan"] . "</td>
                        <td style='padding: 10px;'>" . $row["nik_pemohon"] . "</td>
                        <td style='padding: 10px;'>" . $row["opd_yang_dituju"] . "</td>
                        <td style='padding: 10px;'>" . $row["informasi_yang_diminta"] . "</td>
                        <td style='padding: 10px;'>" . $row["alasan_keberatan"] . "</td>
                        
                    </tr>";
        }
    } else {
        $html .= "<tr><td colspan='5' style='padding: 10px; text-align: center;'>Tidak ada data</td></tr>";
    }
} catch (Exception $e) {
    // Handle the exception, log, or display an error message
    $html .= "<tr><td colspan='5' style='padding: 10px; text-align: center; color: #e74c3c;'>Error retrieving data: " . $e->getMessage() . "</td></tr>";
}

$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close the database connection
$conn->close();

// Output PDF to browser
$pdf->Output('Data_Daftar_Keberatan.pdf', 'I');
exit();
?>
