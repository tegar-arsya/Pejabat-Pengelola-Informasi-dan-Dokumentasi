<?php
session_start();
include('../controller/koneksi/config.php');
if (!isset($_SESSION['id'])) {
    header("Location: ../view/admin");
    exit();
}
$user_id = $_SESSION['id'];
if (!isset($_GET['registrasi'])) {
    header("Location: ../components/eror.html");
    exit();
}
$nomer_registrasi_keberatan = $_GET['registrasi'];

$query = "SELECT * FROM note_admin WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$result = $conn->query($query);

if ($result -> num_rows > 0) {
    while ($row = $result -> fetch_assoc()) {
        $keterangan = $row['keterangan'];
        $namapemohon = $row['nama_pemohon'];
        $status = $row ['status'];
        $nomer_registrasi = $row['nomer_registrasi_keberatan'];
    }
}
else {
    
}
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
    <link href="../Assets//plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
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
        <?php include '../components/navbar.html'; ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h1>Pengajuan Keberatan</h1>
                                <div class="row" style="background-color: #9F0000;">
                                    <div class="col-md-3 daftar-permohonan">
                                        <div class="form-group">

                                            <input type="text" class="form-control" id="nik" name="nik"
                                                placeholder="Nomor NIK">
                                        </div>
                                    </div>
                                    <div class="col-md-3 daftar-permohonan">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                placeholder="Nama Pemohon">
                                        </div>
                                    </div>
                                    <div class="col-md-3 daftar-permohonan">
                                        <div class="form-group">

                                            <input type="text" class="form-control" id="registrasi" name="registrasi"
                                                placeholder="Nomor Registrasi">
                                        </div>
                                    </div>
                                    <div class="col-md-2 daftar-permohonan">
                                        <button type="button" class="btn btn-primary btn-block" onclick="cariData()"
                                            style="background-color: #F19C12;">Cari</button>
                                    </div>
                                </div>
                                <h4 class="card-title">Data Daftar Pengajuan Keberatan</h4>
                                <button class="btn btn-success" onclick="cetakPDF()">Cetak PDF</button>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>No.Register Keberatan</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            include('../controller/koneksi/config.php');

                                            
                                            $sql = "SELECT * FROM note_admin WHERE nomer_registrasi_keberatan =  '$nomer_registrasi_keberatan'";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                $counter = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $formattedDate = date('d-m-Y', strtotime($row["keterangan"]));
                                                    echo "<tr>
                                                            <td>" . $counter . "</td>
                                                            <td>" . $row["nama_pemohon"] . "</td>
                                                            <td>" . $row["nomer_registrasi_keberatan"] . "</td>
                                                            <td>" . $formattedDate . "</td>
                                                            <td>" . $row["status"] . "</td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../components/footer.html'; ?>
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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