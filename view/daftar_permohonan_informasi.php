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
                                <h1>Permohonan Informasi</h1>
                                <div class="row" style="background-color: #9F0000;">
                                    <div class="col-md-3 daftar-permohonan">
                                        <div class="form-group">
                                            
                                            <input type="text" class="form-control" id="nik" name="nik" placeholder="Nomor NIK">
                                        </div>
                                    </div>
                                    <div class="col-md-3 daftar-permohonan">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Pemohon">
                                        </div>
                                    </div>
                                    <div class="col-md-3 daftar-permohonan">
                                        <div class="form-group">
                                
                                            <input type="text" class="form-control" id="registrasi" name="registrasi" placeholder="Nomor Registrasi">
                                        </div>
                                    </div>
                                    <div class="col-md-2 daftar-permohonan">
                                        <button type="button" class="btn btn-primary btn-block" onclick="cariData()"
                                        style="background-color: #F19C12;margin-left: 70px;">Cari</button>
                                    </div>
                                </div>
                                <h4 class="card-title">Daftar Permohonan Informasi</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="select-all"></th>
                                                <th>No. Register</th>
                                                <th>Nama</th>
                                                <th>No.HP</th>
                                                <th>Informasi yang Dibutuhkan</th>
                                                <th>OPD yang ditujui</th>
                                                <th>Tanggal MAsuk</th>
                                                <th>Tangal Verifikasi</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Aksi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="select-row"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td id="tanggal-verifikasi"></td>
                                                <td></td>
                                                <td></td>
                                                <td><button class="btn btn-info btn-sm"
                                                        onclick="showDetail()">Detail</button>
                                                    <button class="btn btn-success btn-sm"
                                                        onclick="status()">Status</button>
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
    <!-- jQuery library (pastikan jQuery telah dimuat sebelum ini) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script untuk menangani pemilihan baris -->
<script>
    $(document).ready(function () {
        // Mengatur event handler untuk checkbox "Select All"
        $('.select-all').click(function () {
            $('.select-row').prop('checked', this.checked);
        });

        // Mengatur event handler untuk checkbox setiap baris
        $('.select-row').click(function () {
            if ($('.select-row:checked').length == $('.select-row').length) {
                $('.select-all').prop('checked', true);
            } else {
                $('.select-all').prop('checked', false);
            }
        });
    });
</script>

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