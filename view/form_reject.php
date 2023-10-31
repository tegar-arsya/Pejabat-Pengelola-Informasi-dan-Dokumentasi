<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login_admin.php");
    exit();
}
$user_id = $_SESSION['id'];

include('../koneksi/config.php');

if (isset($_GET['nomer_registrasi'])) {
    $nomer_registrasi = $_GET['nomer_registrasi'];

    // Query untuk mengambil detail permohonan dan data registrasi berdasarkan nomor registrasi
    $query = "SELECT p.id, r.nomer_registrasi,r.nik, r.no_hp, r.foto_ktp,  r.alamat, p.nama_pengguna, p.opd_yang_dituju, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi, p.cara_mendapatkan_informasi, p.cara_mendapatkan_salinan, p.tanggal_permohonan
              FROM permohonan_informasi p
              JOIN registrasi r ON p.id_user = r.nik
              WHERE r.nomer_registrasi = '$nomer_registrasi'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $nomorRegistrasi = $row['nomer_registrasi'];
    } else {
        // Redirect atau tampilkan pesan kesalahan jika permohonan tidak ditemukan
        header("Location: halaman_error.php");
        exit();
    }
} else {
    // Redirect atau tampilkan pesan kesalahan jika parameter nomor registrasi tidak ada dalam URL
    header("Location: halaman_error.php");
    exit();
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
                                <h4>Permohonan Informasi</h4>
                                <!-- Tampilkan detail permohonan di sini -->
                                <form action="../controller/reject.php" method="post">
                                    <div class="form-group">
                                        <label for="alasan">Alasan Penolakan:</label>
                                        <textarea id="alasan" name="alasan" class="form-control" required></textarea>
                                    </div>
                                    <input type="hidden" name="id_permohonan" value="<?php echo $id_permohonan; ?>">
y
                                    <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                                </form>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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