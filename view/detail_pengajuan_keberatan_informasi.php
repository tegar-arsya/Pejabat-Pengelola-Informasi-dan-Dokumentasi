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
                            <h1>Permohonan Informasi</h1>
                            <div class="card-body">
                                <h4>Detail Pengajuan Keberatan Informasi</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Nama Pemohon:</strong></td>
                                        <td>Tegar Arsyadani</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Permohonan:</strong></td>
                                        <td>16 Oktober 2023</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor Register:</strong></td>
                                        <td>123456</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIK:</strong></td>
                                        <td>1234567890</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Foto KTP:</strong></td>
                                        <td>[Link ke gambar Foto KTP]</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Informasi yang Dibutuhkan:</strong></td>
                                        <td>Informasi contoh yang dibutuhkan</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alasan Pengguna Informasi:</strong></td>
                                        <td>Alasan penggunaan informasi contoh</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>Dikuasakan Kepada</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Nama :</strong></td>
                                        <td>Rahmatika Kusuma Wardhani</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pekerjaan:</strong></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Surat Kuasa:</strong></td>
                                        <td>123456</td>
                                    </tr>
                                </table>
                                
                                <button class="btn btn-primary" onclick="goBack()">Back</button>
                                <button class="btn btn-success" onclick="verifikasi()">Verifikasi</button>
                                <button class="btn btn-danger" onclick="belumValid()">Belum Valid</button>
                            </div>
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
    <script>function editData() {
            // Tambahkan logika untuk menangani aksi edit di sini
            alert('Tombol Edit Ditekan!');
        }
        function goBack() {
            alert('Tombol Back Ditekan!');
        }

        function verifikasi() {
            alert('Tombol Verifikasi Ditekan!');
        }

        function belumValid() {
            alert('Tombol Belum Valid Ditekan!');
        }
        function simpan() {
            alert('Tombol siimpan Ditekan!');
        }
        function batal() {
            alert('Tombol batal Ditekan!');
        }
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