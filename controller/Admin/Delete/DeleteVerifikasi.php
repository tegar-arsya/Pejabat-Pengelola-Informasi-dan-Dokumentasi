<?php
// delete_verifikasi.php

include('../../../controller/koneksi/config.php');

// Check if the script is called through an AJAX request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_POST['nomer_registrasi_keberatan'])) {
        $nomer_registrasi_keberatan = $_POST['nomer_registrasi_keberatan'];

        // Validate input (optional but recommended)
        // Example: Check if the input is a non-empty string
        if (!is_string($nomer_registrasi_keberatan) || empty($nomer_registrasi_keberatan)) {
            echo json_encode(array("status" => "error", "message" => "Invalid input"));
            exit();
        }

        // Perform the delete operation using a prepared statement
        $deleteQuery = "DELETE FROM verifikasi_keberatan WHERE nomer_registrasi_keberatan = ?";
        $stmt = $conn->prepare($deleteQuery);
        
        if (!$stmt) {
            echo json_encode(array("status" => "error", "message" => "Prepare failed: " . $conn->error));
            exit();
        }
        
        $stmt->bind_param("s", $nomer_registrasi_keberatan);

        if ($stmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "Data deleted successfully"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error deleting data: " . $stmt->error));
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }
} else {
    // If not an AJAX request, respond with an error
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}

// Close the database connection
$conn->close();
?>
