<?php
date_default_timezone_set('Asia/Jakarta');

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}
$user_id = $_SESSION['id'];

include('../../../controller/koneksi/config.php');

if (isset($_GET['id'])) {
    $id_permohonan = $_GET['id'];
}
// Pemeriksaan peran (role)
if ($_SESSION['role'] !== 'superadmin' && $_SESSION['role'] !== 'admin') {
    // Redirect non-superadmin and non-admin users to a different page
    header("Location: ../../../components/ErorAkses");
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
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/images/logo_jateng.png">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../../../Assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="../../../Assets/css/style-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../Assets/fontawesome/css/all.min.css">
    <style>
        .highlight-green {
            background-color: #06ff06;
            /* Hijau */
        }
        .highlight-blue {
            background-color: #0000ff;
            /* Hijau */
        }

        .highlight-orange {
            background-color: #FFA500;
            /* Oranye */
        }

        .highlight-yellow {
            background-color: #FFFF00;
            /* Kuning */
        }

        .highlight-circle {
            text-align: center;
        }

        .highlight-circle div {
            display: inline-block;
            width: 20px;
            /* Sesuaikan ukuran bulatan sesuai kebutuhan */
            height: 20px;
            /* Sesuaikan ukuran bulatan sesuai kebutuhan */
            border-radius: 50%;
            /* Membuat bentuk bulat */
        }
    </style>
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
                                <h1>Daftar Keberatan Informasi</h1>
                                <h4>Yang Sudah Diverifikasi</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <button id="exportExcel" style="border : none;"
                                    onclick="window.open('../controller/Admin/ExportExcelKeberatan.php')">
                                    <i class="fa fa-file-excel-o" aria-hidden="true"
                                        style="color: #058a2d; font-size: 30px;">
                                    </i>
                                </button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="permohonanTable" class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No. Register Keberatan</th>
                                                <th>Nama Pemohon</th>
                                                <th>Alasan Keberatan</th>
                                                <th>OPD yang ditujui</th>
                                                <th>Tanggal Permohonan</th>
                                                <th>Tangal Verifikasi</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Aksi</th>
                                                <th>Status</th>
                                                <th>Highlight</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $query = "SELECT DISTINCT vk.nomer_registrasi_keberatan, vk.id_permohonan_keberatan, pk.tanggal_permohonan, vk.tanggal_verifikasi, sk.tanggal_survey,pk.id, pk.nama_pemohon, pk.alasan_keberatan, pk.opd_yang_dituju, tp.tanggal_penolakan, pk.tanggal_permohonan
                                            FROM verifikasi_keberatan vk
                                            LEFT JOIN survey_kepuasan_keberatan sk ON vk.id_permohonan_keberatan = sk.nomer_registrasi_keberatan
                                            LEFT JOIN pengajuan_keberatan pk ON vk.id_permohonan_keberatan = pk.id
                                            LEFT JOIN tbl_penolakan tp ON vk.id_permohonan_keberatan = tp.id_permohonan_keberatan";
                                         

                                            $result = $conn->query($query);
                                            if ($result->num_rows > 0) {
                                                $nomer = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $nomer++ . "</td>";
                                                    echo "<td>{$row['nomer_registrasi_keberatan']}</td>";
                                                    echo "<td>{$row['nama_pemohon']}</td>";
                                                    echo "<td>{$row['alasan_keberatan']}</td>";
                                                    echo "<td>{$row['opd_yang_dituju']}</td>";
                                                    echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_verifikasi']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi']))) : '') . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_survey']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_survey']))) : '') . "</td>";
                                                    echo "<td>";
                                                    echo "<div class='btn-group' role='group'>";
                                                    echo "<a href='../DetailPermohonan/detailNote?registrasi=" . $row["nomer_registrasi_keberatan"] . "' class='btn btn-info btn-sm fas fa-info-circle'></a>";
                                                    echo "<button class='btn btn-danger btn-sm fas fa-trash-alt onclick='HapusVerifikasi(\"{$row['nomer_registrasi_keberatan']}\")'></button>";
                                                    echo "<a href='../FormAnswer/formAnswerKeberatan?registrasi=" . $row["id_permohonan_keberatan"] . "' class='btn btn-success btn-sm fas fa-reply'></a>";
                                                    echo "<a href='../Form/Note?registrasi=" . $row["nomer_registrasi_keberatan"] . "' class='btn btn-primary btn-sm'><i class='fas fa-sticky-note'></i></a>";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    $status = '';
                                                    $note = '';
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
                                                            $note = !empty($row['note']) ? $row['note'] : '';
                                                        } else {
                                                            // Jika lebih dari 3 hari, dianggap 'Gugur'
                                                            $status = 'Gugur';
                                                        }

                                                    } else {
                                                        $status = 'Belum Verifikasi';
                                                    }
                                                    $statusDisplay = $status;
                                                    $highlightClass = '';
                                                    if ($status === 'Pending') {
                                                        $statusDisplay .= " ($note)";
                                                    }
                                                    $updateStatusQuery = "UPDATE verifikasi_keberatan SET status='$statusDisplay'
                                                        WHERE nomer_registrasi_keberatan='{$row['nomer_registrasi_keberatan']}'";
                                                    $conn->query($updateStatusQuery);

                                                    $sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                                                    $tanggalVerifikasi = new DateTime($row['tanggal_verifikasi'], new DateTimeZone('Asia/Jakarta'));
                                                    $selisihHari = $sekarang->diff($tanggalVerifikasi)->days;

                                                    // Cek apakah sudah ada jawaban di tabel answer_admin untuk id_permohonan ini
                                                    $queryAnswer = "SELECT * FROM keberatananswer_admin WHERE id_permohonan_keberatan = ?";
                                                    $stmtAnswer = $conn->prepare($queryAnswer);
                                                    $stmtAnswer->bind_param("i", $row['id_permohonan_keberatan']);
                                                    $stmtAnswer->execute();
                                                    $resultAnswer = $stmtAnswer->get_result();

                                                    // Tentukan kelas highlight berdasarkan selisih hari
                                                    if ($resultAnswer->num_rows > 0) {
                                                        $highlightClass = 'highlight-blue'; // Jika sudah ada jawaban
                                                    } elseif ($selisihHari <= 5) {
                                                        $highlightClass = 'highlight-green';
                                                    } elseif ($selisihHari == 6 || $selisihHari == 7) {
                                                        $highlightClass = 'highlight-orange';
                                                    } elseif ($selisihHari >= 8 && $selisihHari <= 10) {
                                                        $highlightClass = 'highlight-yellow';
                                                    }

                                                    echo "<td>" . htmlspecialchars($statusDisplay) . "</td>";
                                                    echo "<td class='highlight-circle'><div class='$highlightClass'></div></td>";
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
        <?php include '../../../components/footer.html'; ?>
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
                "ordering": false
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
    <!-- <script>
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
</script> -->
    <!-- Add this script inside the head tag or at the end of the body tag -->
    <script>
    function HapusVerifikasi(nomer_registrasi_keberatan) {
        // Tampilkan pesan konfirmasi dengan SweetAlert
        Swal.fire({
            title: 'Apakah Anda ingin menghapus verifikasi ini?',
            text: 'Tindakan ini tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '../../../controller/Admin/Delete/DeleteVerifikasi.php',
                    data: { nomer_registrasi_keberatan: nomer_registrasi_keberatan },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            // Tampilkan pesan berhasil dengan SweetAlert
                            Swal.fire(
                                'Terhapus!',
                                'Verifikasi telah dihapus.',
                                'success'
                            ).then((result) => {
                                // Reload halaman setelah penghapusan berhasil
                                location.reload();
                            });
                        } else {
                            // Tampilkan pesan kesalahan dengan SweetAlert jika ada kesalahan
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus verifikasi.',
                                'error'
                            );
                        }
                    },
                    error: function (xhr, status, error) {
                        // Tampilkan pesan kesalahan dengan SweetAlert jika terjadi kesalahan Ajax
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghubungi server.',
                            'error'
                        );
                        console.error("AJAX Error: " + error);
                    }
                });
            }
        });
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