<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['id'];
$nik = $_SESSION['nik'];
include('../controller/koneksi/config.php');

if (isset($_GET['id'])) {
    $id_permohonan = $_GET['id'];


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e601bb8c4c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    <!-- Jarallax CSS -->
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/img/logo_jateng.png">
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheaet" href="../Assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../Assets/css/style.css">
    <title>Daftar Riwayat Permohonan Informasi</title>
</head>

<body id="page-top">

    <!-- navbar -->
    <?php include '../components/navbar.php'; ?>
    <div class="custom-line"></div>
    <div class="container">
        <h1 class="form-title">Pengajuan Permohonan Informasi</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Permohonan</th>
                        <th>Nomer Register</th>
                        <th>Nama</th>
                        <th>Alasan Pengguna Informasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../controller/koneksi/config.php');

                    $sql = "SELECT * FROM permohonan_informasi WHERE id_user = $nik";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $counter = 1;
                        while ($row = $result->fetch_assoc()) {
                            $formattedDate = date('d-m-Y H:i:s', strtotime($row["tanggal_permohonan"]));
                            echo "<tr>
                            <td>" . $counter . "</td>
                            <td>" . $formattedDate . "</td>
                            <td>" . $row["nomer_registrasi"] . "</td>
                            <td>" . $row["nama_pengguna"] . "</td>
                            <td>" . $row["alasan_pengguna_informasi"] . "</td>
                            <td>
                            <a href='riwayat?registrasi=" . $row["nomer_registrasi"] . "' class='btn btn-danger btn-sm'>Detail</a>
                            </td>
                            </tr>";
                            $counter++;
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include '../components/footer.php'; ?>
    <script src="../Model/Auth/TimeOutUser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>