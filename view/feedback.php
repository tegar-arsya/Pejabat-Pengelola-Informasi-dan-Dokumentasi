<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/admin");
    exit();
}
$user_id = $_SESSION['id'];

include('../../controller/koneksi/config.php');

if (isset($_GET['id'])) {
    $id_permohonan = $_GET['id'];


}

// Pemeriksaan peran (role)
if ($_SESSION['role'] !== 'superadmin' && $_SESSION['role'] !== 'admin') {
    // Redirect non-superadmin and non-admin users to a different page
    header("Location: ../../components/ErorAkses");
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
    <link rel="icon" type="image/png" sizes="16x16" href="../../Assets/images/logo_jateng.png">
    <!-- Custom Stylesheet -->
    <link href="../../Assets//plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/fontawesome/css/all.min.css">
    <link href="../../Assets/css/style-admin.css" rel="stylesheet">

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
        <?php include '../../components/navbarAdmin.php'; ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="text-align: center;">
                            <div class="card-body">
                                <h1>Permohonan Informasi</h1>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Daftar Permohonan Informasi</h4>
                                <div class="table-responsive">

                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Name</th>
                                                <th>Question</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
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
    <script>
    $(document).ready(function() {
        // Ambil data dari server PHP menggunakan AJAX
        $.ajax({
            url: '../Controller/User/Api.php', // Ganti dengan URL endpoint Anda
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    console.error('Error:', response.error);
                } else {
                    // Tambahkan data ke dalam tabel
                    response.forEach(function(data) {
                        $('tbody').append('<tr><td>' + data.number + '</td><td>' + data.name + '</td><td>' + data.question + '</td></tr>');
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../Model/Auth/TimeOut.js"></script>
    <script src="../../Assets/plugins/common/common.min.js"></script>
    <script src="../../Assets/js/custom.min.js"></script>
    <script src="../../Assets/js/settings.js"></script>
    <script src="../../Assets/js/gleek.js"></script>
    <script src="../../Assets/js/styleSwitcher.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../../Assets/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../../Assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../../Assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

</body>

</html>