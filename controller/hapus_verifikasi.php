<?php
// delete_verifikasi.php

include('../controller/koneksi/config.php');

// Check if the script is called through an AJAX request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_POST['nomer_registrasi'])) {
        $nomer_registrasi = $_POST['nomer_registrasi'];

        // Perform the delete operation using a prepared statement
        $deleteQuery = "DELETE FROM verifikasi_permohonan WHERE nomer_registrasi = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("s", $nomer_registrasi);

        if ($stmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "Data deleted successfully"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error deleting data: " . $stmt->error));
        }

        // Close the prepared statement and the database connection
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }
} else {
    // If not an AJAX request, respond with an error
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
