<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/admin");
    exit();
}
$user_id = $_SESSION['id'];

include('../koneksi/config.php');

if (isset($_GET['id'])) {
    $id_permohonan = $_GET['id'];


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
                                <h4 class="card-title">Data Daftar Permohonan</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama</th>
                                                <th>Informasi yang Dibutuhkan</th>
                                                <th>Alasan Pengguna Informasi</th>
                                                <th>OPD yang ditujui</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            include('../koneksi/config.php');

                                            $sql = "SELECT * FROM permohonan_informasi";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>
                                                            <td>" . $row["tanggal_permohonan"] . "</td>
                                                            <td>" . $row["nama_pengguna"] . "</td>
                                                            <td>" . $row["informasi_yang_dibutuhkan"] . "</td>
                                                            <td>" . $row["alasan_pengguna_informasi"] . "</td>
                                                            <td>" . $row["opd_yang_dituju"] . "</td>
                                                            <td>
                                                                <a href='detail-PM?id=" . $row["id"] . "' class='btn btn-info btn-sm'>Detail</a>
                                                                <button type='button' data-id='" . $row["id"] . "' class='btn btn-danger btn-sm delete-btn'>Hapus</button>
                                                                <a href='detail-PM?id=" . $row["id"] . "' class='btn btn-success btn-sm verify-btn'>Verifikasi</a>
                                                            </td>
                                                        </tr>";
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
<script>
    $(document).ready(function() {
        // Tangani klik tombol Hapus
        $('.delete-btn').click(function() {
            var id = $(this).data('id');

            // Kirim permintaan penghapusan ke server melalui Ajax
            $.ajax({
                url: '../controller/hapusdata_permohonan.php', // Gantilah dengan nama file PHP yang menangani penghapusan data
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    // Perbarui tabel atau lakukan aksi lain yang diperlukan setelah penghapusan berhasil
                    // Contoh: reload halaman
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan jika diperlukan
                }
            });
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