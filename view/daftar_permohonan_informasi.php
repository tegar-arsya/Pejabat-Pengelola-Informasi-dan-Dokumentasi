<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/admin");
    exit();
}
$user_id = $_SESSION['id'];

include('../controller/koneksi/config.php');

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
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/images/logo_jateng.png">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
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
                                            <input type="text" class="form-control" id="registrasi" name="registrasi"  placeholder="Nomor Registrasi">
                                        </div>
                                    </div>
                                    <div class="col-md-2 daftar-permohonan">
                                        <button type="button" class="btn btn-primary btn-block" onclick="cariData()"
                                            style="background-color: #F19C12;margin-left: 70px;">Cari</button>
                                    </div>
                                </div>
                                <h4 class="card-title">Daftar Permohonan Informasi</h4>
                                <input type="button" class="btn btn-success" value="export Excel"
                                    onclick="window.open('../controller/export_excel.php')">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="select-all"></th>
                                                <th>No. Register</th>
                                                <th>Nama</th>
                                                <th>No.HP</th>
                                                <th>Informasi yang Dibutuhkan</th>
                                                <th>OPD yang ditujui</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Tangal Verifikasi</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Aksi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT vp.*, sk.tanggal_survey, pi.nama_pengguna FROM verifikasi_permohonan vp 
                                            LEFT JOIN survey_kepuasan sk ON vp.nomer_registrasi = sk.nomer_registrasi
                                            LEFT JOIN permohonan_informasi pi ON vp.nama_pengguna = pi.nama_pengguna";
                                            $result = $conn->query($query);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td><input type='checkbox' class='select-row'></td>";
                                                    echo "<td>{$row['nomer_registrasi']}</td>";
                                                    echo "<td>{$row['nama_pengguna']}</td>";
                                                    echo "<td>{$row['no_hp']}</td>";
                                                    echo "<td>{$row['informasi_yang_dibutuhkan']}</td>";
                                                    echo "<td>{$row['opd_yang_dituju']}</td>";
                                                    echo "<td>{$row['tanggal_permohonan']}</td>";
                                                    echo "<td>{$row['tanggal_verifikasi']}</td>";
                                                    echo "<td>{$row['tanggal_survey']}</td>";
                                                    echo "<td><button class='btn btn-info btn-sm' onclick='showDetail()'>Detail</button>";
                                                    echo "<button class='btn btn-success btn-sm' onclick='status()'>Status</button></td>";
                                                    $status = '';
                                                    if (!empty($row['tanggal_survey'])) {
                                                        $status = 'Permohonan Selesai';
                                                    } elseif (!empty($row['tanggal_verifikasi'])) {
                                                        $status = 'Sudah Verifikasi';
                                                    } else {
                                                        $status = 'Belum Verifikasi';
                                                    }
                                                    $updateStatusQuery = "UPDATE verifikasi_permohonan SET status='$status' WHERE nomer_registrasi='{$row['nomer_registrasi']}'";
                                                    $conn->query($updateStatusQuery);

                                                    echo "<td>{$status}</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='11'>Tidak ada data permohonan yang ditemukan.</td></tr>";
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select-all').click(function () {
                $('.select-row').prop('checked', this.checked);
            });
            $('.select-row').click(function () {
                if ($('.select-row:checked').length == $('.select-row').length) {
                    $('.select-all').prop('checked', true);
                } else {
                    $('.select-all').prop('checked', false);
                }
            });
        });
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#permohonanTable').DataTable();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#exportExcel').click(function () {
                var data = [];
                $('#permohonanTable tbody tr').each(function () {
                    var rowData = [];
                    $(this).find('td').each(function () {
                        rowData.push($(this).text());
                    });
                    data.push(rowData);
                });
                $.ajax({
                    url: '../controller/export_spreadsheet.php',
                    method: 'POST',
                    data: { data: data },
                    dataType: 'json',
                    success: function (response) {
                        if (response && response.fileUrl) {
                            window.location.href = response.fileUrl;
                        } else {
                            console.error('Invalid response from server.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
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