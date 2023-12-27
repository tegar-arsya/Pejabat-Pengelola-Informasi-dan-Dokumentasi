<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login_admin.php");
    exit();
}
$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PERMOHONAN INFORMASI PROVINSI JAWA TENGAH</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/images/logo_jateng.png">
    <!-- Custom Stylesheet -->
    <link href="../Assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../Assets/css/style-admin.css" rel="stylesheet">

</head>

<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <div id="main-wrapper">
    <?php include '../components/navbarAdmin.php'; ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h1>Survey Kepuasan Masyarakat</h1>
                                <h4 class="card-title">Data Survey Kepuasan Masyarakat</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Alamat</th>
                                                <th>No Hp</th>
                                                <th>Jenis Layanan Yang Diminta</th>
                                                <th>Pelayanan Publik Yang Kami Berikan</th>
                                                <th>Saran Atau Keluhan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include('../controller/koneksi/config.php');

                                            $sql = "SELECT * FROM survey_kepuasan_keberatan";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                echo "<td>" . $row["nama_pengguna"] . "</td>";
                                                echo "<td>" . $row["email"] . "</td>";
                                                echo "<td>" . $row["alamat"] . "</td>";
                                                echo "<td>" . $row["no_hp"] . "</td>";
                                                echo "<td>" . $row["jenis_layanan"] . "</td>";
                                                echo "<td>" . $row["feedback"] . "</td>";
                                                echo "<td>" . $row["saran"] . "</td>";
                                                echo "<td><a href='../controller/HapusSKMK?id=" . $row["id"] . "'>Hapus</a></td>";
                                                echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                                            }
                                            $conn->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../components/footer.html'; ?>
    </div>
    <script src="../Model/Auth/TimeOut.js"></script>
    <script src="../Assets/plugins/common/common.min.js"></script>
    <script src="../Assets/js/custom.min.js"></script>
    <script src="../Assets/js/settings.js"></script>
    <script src="../Assets/js/gleek.js"></script>
    <script src="../Assets/js/styleSwitcher.js"></script>

    <script src="../Assets/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../Assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../Assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

</body>

</html>