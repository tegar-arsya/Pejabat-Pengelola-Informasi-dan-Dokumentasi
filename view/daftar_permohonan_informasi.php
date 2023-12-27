<?php
date_default_timezone_set('Asia/Jakarta');

session_start();
session_regenerate_id(true);

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
    <?php include '../components/navbarAdmin.php'; ?>
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
                                            style="background-color: #F19C12;margin-left: 70px;">Cari</button>
                                    </div>
                                </div>
                                <h4 class="card-title">Daftar Permohonan Informasi</h4>
                                
                                <button id="exportExcel" style="border : none;" onclick="window.open('../controller/Admin/export_excel.php')">
                                <i class="fa fa-file-excel-o" aria-hidden="true" style="color: #058a2d; font-size: 30px;">
                            </i>
                        </button>
                                <div class="table-responsive">
                                    <table id="permohonanTable" class="table table-striped table-bordered ">
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
                                            $query = "SELECT DISTINCT vp.nomer_registrasi, vp.*, sk.tanggal_survey, pi.nama_pengguna, tr.note, tr.tanggal_penolakan, pk.kode_permohonan_informasi
                                            FROM verifikasi_permohonan vp
                                            LEFT JOIN survey_kepuasan sk ON vp.nomer_registrasi = sk.nomer_registrasi
                                            LEFT JOIN permohonan_informasi pi ON vp.nama_pengguna = pi.nama_pengguna
                                            LEFT JOIN tbl_rejected tr ON vp.nomer_registrasi = tr.nomer_registrasi
                                            LEFT JOIN pengajuan_keberatan pk ON vp.nomer_registrasi = pk.kode_permohonan_informasi";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td><input type='checkbox' class='select-row'></td>";
                                                    echo "<td>" . htmlspecialchars($row['nomer_registrasi']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nama_pengguna']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['informasi_yang_dibutuhkan']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['opd_yang_dituju']) . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_verifikasi']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi']))) : '') . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_survey']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_survey']))) : '') . "</td>";
                                                    echo "<td> <button class='btn btn-info btn-sm' onclick='showDetail()'>Detail</button>";
                                                    echo "<button class='btn btn-danger btn-sm' onclick='HapusVerifikasi(\"{$row['nomer_registrasi']}\")'>Hapus</button>";
                                                    echo "<a href='formAnswer?registrasi=" . $row["nomer_registrasi"] . "' class='btn btn-success btn-sm'>Jawab</a>";
                                                    
                                                    $status = '';
                                                    $note = '';
                                                    if (!empty($row['kode_permohonan_informasi'])) {
                                                        // Jika ada pengajuan keberatan, atur status ke 'Pengajuan Keberatan'
                                                        $status = 'Pengajuan Keberatan';
                                                    } else {
                                                        $sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                                                        if (!empty($row['tanggal_survey'])) {
                                                        $status = 'Permohonan Selesai';
                                                    } elseif (!empty($row['tanggal_verifikasi']) && empty($row['tanggal_penolakan'])) {
                                                        $status = 'Permohonan informasi Sudah Diverifikasi Oleh Admin.';
                                                    } elseif (!empty($row['tanggal_penolakan'])) {
                                                        // Cek apakah sudah 3 hari setelah tanggal penolakan
                                                        $tanggalPenolakan = (new DateTime())->setTimestamp(strtotime($row['tanggal_penolakan']));
                                                        $tanggalPenolakan->add(new DateInterval('P3D')); // Tambah 3 hari
                                                        // echo 'Tanggal Penolakan: ' . $tanggalPenolakan->format('Y-m-d H:i:s') . '<br>';
                                                        // echo 'Sekarang: ' . $sekarang->format('Y-m-d H:i:s') . '<br>';

                                                        if ($sekarang <= $tanggalPenolakan) {
                                                            $status = 'Pending';
                                                            $note = !empty($row['note']) ? $row['note'] : '';
                                                        } else {
                                                            // Jika lebih dari 3 hari, dianggap 'Gugur'
                                                            $status = 'Gugur';
                                                        }

                                                    }else {
                                                        $status = 'Belum Verifikasi';
                                                    }
                                                }
                                                $statusDisplay = $status;
                                                if ($status === 'Pending') {
                                                    $statusDisplay .= " ($note)";
                                                }
                                                    $updateStatusQuery = "UPDATE verifikasi_permohonan SET status='$statusDisplay'
                                                    WHERE nomer_registrasi='{$row['nomer_registrasi']}'";
                                                    $conn->query($updateStatusQuery);

                                                    echo "<td>" . htmlspecialchars($statusDisplay) . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
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
    $('#permohonanTable').DataTable({
        "order": [[1, 'asc']]
    });
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
            });
        });
    </script>
    <script>
    $(document).ready(function () {
        function reloadData() {
            $.ajax({
                url: '../Model/Admin/refreshTabel.php',
                method: 'GET',
                success: function (data) {
                    $('#permohonanTable tbody').html(data);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data: ' + error);
                }
            });
        }

        setInterval(function () {
            reloadData();
        }, 5000); // Setiap 5 detik
    });
</script>
<!-- Add this script inside the head tag or at the end of the body tag -->
<script>
    function HapusVerifikasi(nomer_registrasi) {
        if (confirm("Apakah Anda Ingin Menghapusnya?")) {
            $.ajax({
                type: "POST",
                url: '../controller/Admin/hapus_verifikasi.php',
                data: { nomer_registrasi: nomer_registrasi },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        // Reload the page or update the table after successful deletion
                        location.reload();
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + error);
                }
            });
        }
    }
</script>
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