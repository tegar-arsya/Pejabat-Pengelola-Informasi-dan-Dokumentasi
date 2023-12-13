<?php
session_start();

include '../controller/functionAdmin.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../view/admin");
    exit();
}

// Pemeriksaan peran (role)
// Pemeriksaan peran (role)
if ($_SESSION['role'] !== 'superadmin') {
    // Redirect non-superadmin users to a different page
    header("Location: ../components/ErorAkses");
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
    <?php include '../components/navbar.html'; ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h1>DAFTAR ADMIN</h1>
                            <h4 class="card-title">Daftar ADMIN</h4>
                            <button class="btn btn-primary" onclick="Tambah()">Tambah</button>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Usernama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $daftarAdmin = getDaftarAdmin();
                                        if (!empty($daftarAdmin)) {
                                            foreach ($daftarAdmin as $row) {
                                                echo "<tr>
                                                <td>" . $row["nama_pengguna"] . "</td>
                                                <td>" . $row["username"] . "</td>
                                                <td>
                                                    <button class='btn btn-info' onclick='Edit(" . $row["id"] . ")'>Edit</button>
                                                    <button class='btn btn-danger' onclick='hapusAdmin(" . $row["id"] . ")'>Hapus</button>
                                                </td>
                                            </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                                        }
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
    <script>
        function Edit(id) {
            // Implement the edit functionality here
            // You may redirect to the edit_opd.php page with the selected ID
            window.location.href = "EditAdmin?id=" + id;
        }

        function hapusAdmin(id) {
            // Implement the delete functionality here
            // You may want to show a confirmation dialog before deleting
            // Use AJAX or redirect to handle the delete operation
            var confirmation = confirm("Apakah Anda yakin ingin menghapus ADMIN ini?");
            if (confirmation) {
                // Call a function or make an AJAX request to delete the record
                window.location.href = "../controller/deleteAdmin.php?id=" + id;
            }
        }
    </script>
    <script>
    function Tambah() {
        // Redirect to the desired page (replace 'your_add_opd_page.php' with the actual page URL)
        window.location.href = 'tambahAdmin';
    }
</script>
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