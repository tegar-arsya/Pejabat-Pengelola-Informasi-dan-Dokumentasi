<?php
session_start();

// Include file yang dibutuhkan (pastikan path sudah benar)
include '../../../controller/OPDController/functionOpd.php';

// Cek apakah sesi sudah dimulai dan pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}

// Cek peran pengguna
if ($_SESSION['role'] !== 'superadmin' && $_SESSION['role'] !== 'admin') {
    // Redirect pengguna yang bukan superadmin atau admin ke halaman error akses
    header("Location: ../../../components/ErorAkses");
    exit();
}

// Simpan ID pengguna ke dalam variabel lokal jika diperlukan
$user_id = $_SESSION['id'];

// Lanjutkan dengan logika bisnis atau operasi lain yang memerlukan izin superadmin atau admin
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
                                <h1>DAFTAR OPD</h1>
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
                                                <th>Alamat</th>
                                                <th>Email</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $daftarOPD = getDaftarOPD();
                                            if (!empty($daftarOPD)) {
                                                foreach ($daftarOPD as $row) {
                                                    echo "<tr>
                                                <td>" . $row["nama"] . "</td>
                                                <td>" . $row["alamat_opd"] . "</td>
                                                <td>" . $row["email_opd"] . "</td>
                                                <td>
                                                <div class='btn-group' role='group'>
                                                    <button class='btn btn-info' onclick='Edit(" . $row["id_opd"] . ")'>Edit</button>
                                                    <button class='btn btn-danger' onclick='hapusOPD(" . $row["id_opd"] . ")'>Hapus</button>
                                                    </div>
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
        <?php include '../../../components/footer.html'; ?>
    </div>
    <script>
        function Edit(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mengedit OPD ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, edit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the edit page with the selected ID
                    window.location.href = "../../../view/Admin/OPD/editOpd.php?id=" + id;
                }
            })
            
        }

        function hapusOPD(id) {
    Swal.fire({
        title: 'Apakah Anda yakin ingin menghapus OPD ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../../../controller/Admin/Delete/deleteOpd.php?id=" + id;
        }
    });
}

    </script>
    <script>
        function Tambah() {
            // Redirect to the desired page (replace 'your_add_opd_page.php' with the actual page URL)
            window.location.href = 'tambahOPD';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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