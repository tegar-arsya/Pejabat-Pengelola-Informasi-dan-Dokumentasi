<?php
date_default_timezone_set('Asia/Jakarta');

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
                                <h1>Keberatan Informasi</h1>
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
                                <h4 class="card-title">Daftar Keberatan Informasi</h4>
                                
                                <button id="exportExcel" style="border : none;" onclick="window.open('../controller/exportExcelKeberatan.php')">
                                <i class="fa fa-file-excel-o" aria-hidden="true" style="color: #058a2d; font-size: 30px;">
                            </i>
                        </button>
                                <div class="table-responsive">
                                    <table id="permohonanTable" class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="select-all"></th>
                                                <th>No. Register Keberatan</th>
                                                <th>Nama Pemohon</th>
                                                <th>Alasan Keberatan</th>
                                                <th>OPD yang ditujui</th>
                                                <th>Tanggal Permohonan</th>
                                                <th>Tangal Verifikasi</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Aksi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // $query = "SELECT vk.*, sk.tanggal_survey, pk.nama_pemohon, tp.tanggal_penolakan
                                            // FROM verifikasi_keberatan vk
                                            // LEFT JOIN survey_kepuasan sk ON vk.nama_pemohon = sk.nama_pengguna
                                            // LEFT JOIN pengajuan_keberatan pk ON vk.nomer_registrasi_keberatan = pk.nomer_registrasi_keberatan
                                            // LEFT JOIN tbl_penolakan tp ON vk.nomer_registrasi_keberatan = tp.nomer_registrasi_keberatan";

                                            $query = "SELECT DISTINCT vk.nomer_registrasi_keberatan, vk.*, vk.tanggal_permohonan, vk.tanggal_verifikasi, sk.tanggal_survey, pk.nama_pemohon, vk.alasan_keberatan, vk.opd_yang_dituju, tp.tanggal_penolakan
                                            FROM verifikasi_keberatan vk
                                            LEFT JOIN survey_kepuasan_keberatan sk ON vk.nama_pemohon = sk.nama_pengguna
                                            LEFT JOIN pengajuan_keberatan pk ON vk.nomer_registrasi_keberatan = pk.nomer_registrasi_keberatan
                                            LEFT JOIN tbl_penolakan tp ON vk.nomer_registrasi_keberatan = tp.nomer_registrasi_keberatan";

                                            $result = $conn->query($query);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td><input type='checkbox' class='select-row'></td>";
                                                    echo "<td>{$row['nomer_registrasi_keberatan']}</td>";
                                                    echo "<td>{$row['nama_pemohon']}</td>";
                                                    echo "<td>{$row['alasan_keberatan']}</td>";
                                                    echo "<td>{$row['opd_yang_dituju']}</td>";
                                                    echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_verifikasi']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi']))) : '') . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_survey']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_survey']))) : '') . "</td>";
                                                    echo "<td>";
                                                    echo "<a href='detailNote?registrasi=" . $row["nomer_registrasi_keberatan"] . "' class='btn btn-success btn-sm'>Detail</a>";
                                                    echo "<button class='btn btn-danger btn-sm' onclick='HapusVerifikasi(\"{$row['nomer_registrasi_keberatan']}\")'>Hapus</button>";
                                                    echo "<a href='formAnswerKeberatan?registrasi=" . $row["nomer_registrasi_keberatan"] . "' class='btn btn-success btn-sm'>Jawab</a>";
                                                    echo "<a href='Note?registrasi=" . $row["nomer_registrasi_keberatan"] . "' class='btn btn-primary btn-sm'><i class='fas fa-sticky-note'></i> Note</a>";
                                                    $status = '';
                                                    $sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                                                    if (!empty($row['tanggal_survey'])) {
                                                        $status = 'Permohonan Selesai';
                                                    } elseif (!empty($row['tanggal_verifikasi']) && empty($row['tanggal_penolakan'])) {
                                                        $status = 'Pengajuan keberatan informasi telah diverifikasi oleh admin';
                                                    } elseif (!empty($row['tanggal_penolakan'])) {
                                                        // Cek apakah sudah 3 hari setelah tanggal penolakan
                                                        $tanggalPenolakan = (new DateTime())->setTimestamp(strtotime($row['tanggal_penolakan']));
                                                        $tanggalPenolakan->add(new DateInterval('P3D')); // Tambah 3 hari
                                                        // echo 'Tanggal Penolakan: ' . $tanggalPenolakan->format('Y-m-d H:i:s') . '<br>';
                                                        // echo 'Sekarang: ' . $sekarang->format('Y-m-d H:i:s') . '<br>';

                                                        if ($sekarang <= $tanggalPenolakan) {
                                                            $status = 'Pending';
                                                        } else {
                                                            // Jika lebih dari 3 hari, dianggap 'Gugur'
                                                            $status = 'Gugur';
                                                        }

                                                    }else {
                                                        $status = 'Belum Verifikasi';
                                                    }
                                                    $updateStatusQuery = "UPDATE verifikasi_keberatan SET status='$status' 
                                                    WHERE nomer_registrasi_keberatan='{$row['nomer_registrasi_keberatan']}'";
                                                    $conn->query($updateStatusQuery);

                                                    echo "<td>{$status}</td>";
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
    <script>
    $(document).ready(function () {
        function reloadDataK() {
            $.ajax({
                url: '../Model/Admin/refreshTabelKeberatan.php',
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
            reloadDataK();
        }, 5000); // Setiap 5 detik
    });
</script>
<!-- Add this script inside the head tag or at the end of the body tag -->
<script>
    function HapusVerifikasi(nomer_registrasi) {
        if (confirm("Apakah Anda Ingin Menghapusnya?")) {
            $.ajax({
                type: "POST",
                url: '../controller/hapus_verifikasi.php',
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