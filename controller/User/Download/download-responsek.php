<?php
// Ensure the registrasi parameter is set
include('../../../controller/koneksi/config.php');
if (isset($_GET['registrasi'])) {
    $nomer_registrasi = $_GET['registrasi'];

    // Retrieve the file path based on the registration number
    $query = "SELECT lampiran FROM keberatananswer_admin WHERE nomer_registrasi_keberatan = '$nomer_registrasi'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = "../../../Assets/uploads/keberatan/jawabanKeberatan/" . $row['lampiran'];

        // Check if the file exists
        if (file_exists($file_path)) {
            // Set headers for file download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        } else {
            // Handle the case when the file doesn't exist
            echo "File not found.";
        }
    } else {
        // Handle the case when the record doesn't exist
        echo "Record not found.";
    }
} else {
    // Handle the case when registrasi parameter is not set
    echo "Registrasi parameter is missing.";
}
?>
