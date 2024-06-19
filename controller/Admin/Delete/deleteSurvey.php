<?php
include('../../../controller/koneksi/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM survey_kepuasan WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
header("Location: ../../../view/Admin/SurveyKepuasan/SKM");
exit();
?>
