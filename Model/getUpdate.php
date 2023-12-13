<?php
// Include your database connection and other necessary files
session_start();

// Add your database connection logic here
include('../controller/koneksi/config.php');

// Perform any necessary logic to get the updated data from the server
// For example, you might perform a new database query here

// Assume $updatedData is an array containing the updated timeline data
$updatedData = [];

// Example query (adjust according to your database structure)
$nomer_registrasi = $_SESSION['nomer_registrasi'];
$query = "SELECT * FROM verifikasi_permohonan WHERE nomer_registrasi = '$nomer_registrasi'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        $tanggal = $row['tanggal_verifikasi'];

        // Add data to the updatedData array
        $updatedData[] = array("date" => $tanggal, "status" => $status);
    }
}

// Output the updated data as JSON
header('Content-Type: application/json');
echo json_encode($updatedData);
?>
