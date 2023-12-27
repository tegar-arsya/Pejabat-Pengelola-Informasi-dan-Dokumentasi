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
                                <h1>Tambah OPD</h1>
                                <h4 class="card-title">Daftar OPD</h4>                                
                                <form method="post" action="../controller/processOpd.php">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama OPD</label>
                                    <input type="text" class="form-control" id="nama" name="nama">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
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