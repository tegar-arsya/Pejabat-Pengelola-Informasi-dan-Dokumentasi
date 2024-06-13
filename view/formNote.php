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

$query = "SELECT * FROM verifikasi_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$result = $conn->query($query);

if ($result -> num_rows > 0) {
    while ($row = $result -> fetch_assoc()) {
        $idPermohonan = $row['id_permohonan'];
        $nik = $row['nik_pemohon'];
        $namapemohon = $row['nama_pemohon'];
        $email = $row ['email_pemohon'];
        $nomer_registrasi = $row['nomer_registrasi_keberatan'];
    }
}
else {
    echo "data tidak ada";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Formulir Answer Keberatan</title>
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
                                <form method="post" action="../controller/noteAdmin.php">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <textarea class="form-control" id="status" name="status" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <input type="date" class="form-control" id="keterangan" name="keterangan" required />
                                    </div>
                                    <input type="hidden" name="nama" value="<?php echo $namapemohon; ?>">
                                    <input type="hidden" name="norek" value="<?php echo $nomer_registrasi_keberatan; ?>">
                                    <input type="hidden" name="id_permohonan" value="<?php echo $idPermohonan; ?>">
                                    <button type="submit" class="btn btn-primary">submit</button>
                                </form>
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