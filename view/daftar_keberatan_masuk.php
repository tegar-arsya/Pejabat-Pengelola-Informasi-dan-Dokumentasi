<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/admin");
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
    <link rel="icon" type="image/png" sizes="16x16" href="../images/logo_jateng.png">
    <!-- Custom Stylesheet -->
    <link href="../plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../css/style-admin.css" rel="stylesheet">

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
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>No.Register</th>
                                                <th>NIK</th>
                                                <th>OPD yang ditujui</th>
                                                <th>Informasi yang Dibutuhkan</th>
                                                <th>Alasan Keberatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td>1</td>
                                                <td>Tegar Arsyadani</td>
                                                <td>System Architect</td>
                                                <td>Edinburgh</td>
                                                <td>61</td>
                                                <td> 1</td>
                                                <td>2011/04/25</td>
                                                <td>
                                                <a href="detail_keberatan_masuk.php" class="btn btn-info btn-sm" style="font-size: 8px;">Detail</a>
                                                    <button type="submit" name="hapus"
                                                        class="btn btn-danger btn-sm" style="font-size: 8px;">Hapus</button>
                                                    <button type="submit" name="verifikasi"
                                                        class="btn btn-success btn-sm" style="font-size: 8px;">Verifikasi</button>
                                                </td>
                                            </tr>
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
    <script src="../plugins/common/common.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/gleek.js"></script>
    <script src="../js/styleSwitcher.js"></script>

    <script src="../plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

</body>

</html>