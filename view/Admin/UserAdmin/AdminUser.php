<?php

include '../../../controller/UserAdminController/functionAdmin.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}

// Pemeriksaan peran (role)
// Pemeriksaan peran (role)
if ($_SESSION['role'] !== 'superadmin') {
    // Redirect non-superadmin users to a different page
    header("Location: ../../../components/ErorAkses");
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
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/images/logo_jateng.png">
    <!-- Custom Stylesheet -->
    <link href="../../../Assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../../../Assets/css/style-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../Assets/fontawesome/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
        <?php include '../../../components/navbarAdmin.php'; ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="text-align: center;">
                            <div class="card-body">
                                <h1>DAFTAR ADMIN</h1>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
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
                        <div class="card" style="text-align: center;">
                            <div class="card-body">
                                    <h5>Apakah Anda Ingin Membackup Database Dan Source Code</h5>
                                    <p>Backup ini akan menyimpan database dan file kode ke lokasi yang aman.</p>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#downloadModal">Backup Now</button>
                                    <div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="downloadModalLabel">Pilih Opsi Download</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="downloadForm" method="GET">
                                                    <button type="submit" class="btn btn-primary" formaction="../../../Backup/backupDatabase.php"><i class="fas fa-download"></i> Database</button>
                                                    <button type="submit" class="btn btn-primary" formaction="../../../Backup/backupSourceCode.php"><i class="fas fa-download"></i> Source Code</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../../../components/footer.html'; ?>
    </div>
    <script>
        function Edit(id) {
            // Use SweetAlert for a confirmation dialog before redirecting to edit
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mengedit admin ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, edit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the edit page with the selected ID
                    window.location.href = "../UserAdmin/EditAdmin?id=" + id;
                }
            })
        }

        function hapusAdmin(id) {
            // Use SweetAlert for a confirmation dialog before deleting
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the delete script with the selected ID
                    window.location.href = "../../../controller/Admin/Delete/deleteAdmin.php?id=" + id;
                }
            })
        }
    </script>
    <script>
        function Tambah() {
            // Redirect to the desired page (replace 'your_add_opd_page.php' with the actual page URL)
            window.location.href = '../UserAdmin/tambahAdmin';
        }
    </script>
    <script src="../../../Model/Auth/TimeOut.js"></script>
    <script src="../../../Assets/plugins/common/common.min.js"></script>
    <script src="../../../Assets/js/custom.min.js"></script>
    <script src="../../../Assets/js/settings.js"></script>
    <script src="../../../Assets/js/gleek.js"></script>
    <script src="../../../Assets/js/styleSwitcher.js"></script>
    <script src="../../../Assets/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../../../Assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../../../Assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
</body>

</html>