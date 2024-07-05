<?php
date_default_timezone_set('Asia/Jakarta');

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}
$user_id = $_SESSION['id'];
$session_nama = $_SESSION['nama_pengguna'];
include('../../../controller/koneksi/config.php');

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
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/images/logo_jateng.png">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../../../Assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                                <h1>Permohonan Informasi</h1>
                                <h4>Yang Sudah Diverifikasi</h4>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <!-- <button id="exportExcel" style="border : none;" onclick="window.open('../../../controller/ExcelController/export_excel.php')">
                                    <i class="fa fa-file-excel-o" aria-hidden="true" style="color: #058a2d; font-size: 30px;">
                                    </i>
                                </button> -->
                                <button id="exportExcel" style="border : none;"  data-toggle="modal" data-target="#downloadModal">
                                    <i class="fa fa-file-excel-o" aria-hidden="true" style="color: #058a2d; font-size: 30px;">
                                    </i>
                                </button>
                                <!-- Dropdown menu for download options -->
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
                                                    <div class="form-group">
                                                        <label for="startDate">Dari Tanggal:</label>
                                                        <input type="date" id="startDate" name="start_date" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="endDate">Sampai Tanggal:</label>
                                                        <input type="date" id="endDate" name="end_date" class="form-control" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary"formaction="../../../controller/ExcelController/export_excel.php">Download Laporan Verifikasi Permohonan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="permohonanTable" class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>No</th>
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
                                                <th>Highlight</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT DISTINCT pi.*, pk.*, tr.*, sk.*, vp.*, sk.tanggal_survey, pi.nama_pengguna, pi.id, pi.tanggal_permohonan, pi.informasi_yang_dibutuhkan,pi.opd_yang_dituju, tr.note, tr.tanggal_penolakan, pk.kode_permohonan_informasi, r.no_hp
                                            FROM verifikasi_permohonan vp
                                            LEFT JOIN survey_kepuasan sk ON vp.id_permohonan = sk.id_permohonan
                                            LEFT JOIN permohonan_informasi pi ON vp.id_permohonan = pi.id
                                            LEFT JOIN tbl_rejected tr ON vp.id_permohonan = tr.id_permohonan
                                            LEFT JOIN pengajuan_keberatan pk ON vp.id_permohonan = pk.id_permohonan_informasi
                                            LEFT JOIN registrasi r ON pi.id_registrasi = r.id";

                                            if ($_SESSION['role'] !== 'superadmin' && $_SESSION['role'] !== 'admin') {
                                                $query .= " WHERE pi.opd_yang_dituju = ?";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bind_param("s", $session_nama);
                                            } else {
                                                $stmt = $conn->prepare($query);
                                            }
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            if ($result->num_rows > 0) {
                                                $nomer = 1;
                                                $highlightClass = '';
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $nomer++ . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nomer_registrasi']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nama_pengguna']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['informasi_yang_dibutuhkan']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['opd_yang_dituju']) . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_verifikasi']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_verifikasi']))) : '') . "</td>";
                                                    echo "<td>" . (!empty($row['tanggal_survey']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_survey']))) : '') . "</td>";
                                                    echo "<td>";
                                                    echo "<div class='btn-group' role='group'>";
                                                    echo "<button class='btn btn-danger btn-sm fas fa-trash-alt' onclick='HapusVerifikasi(\"" . htmlspecialchars($row['nomer_registrasi']) . "\")'></button>";
                                                    echo "<a href='../FormAnswer/formAnswer?permohonan=" . htmlspecialchars($row["id_permohonan"]) . "' class='btn btn-success btn-sm fas fa-reply'></a>";
                                                    echo "</div>";
                                                    echo "</td>";

                                                    $status = '';
                                                    $note = '';
                                                    if (!empty($row['id_permohonan_informasi'])) {
                                                        $status = 'Pengajuan Keberatan';
                                                    } else {
                                                        $sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                                                        if (!empty($row['tanggal_survey'])) {
                                                            $status = 'Permohonan Selesai';
                                                        } elseif (!empty($row['tanggal_verifikasi']) && empty($row['tanggal_penolakan'])) {
                                                            $status = 'Permohonan informasi Sudah Diverifikasi Oleh Admin.';
                                                        } elseif (!empty($row['tanggal_penolakan'])) {
                                                            $tanggalPenolakan = (new DateTime())->setTimestamp(strtotime($row['tanggal_penolakan']));
                                                            $tanggalPenolakan->add(new DateInterval('P3D')); // Tambah 3 hari
                                                            if ($sekarang <= $tanggalPenolakan) {
                                                                $status = 'Pending';
                                                                $note = !empty($row['note']) ? $row['note'] : '';
                                                            } else {
                                                                $status = 'Gugur';
                                                            }
                                                        } else {
                                                            $status = 'Belum Verifikasi';
                                                        }
                                                    }
                                                    $statusDisplay = $status;
                                                    $highlightClass = '';
                                                    if ($status === 'Pending') {
                                                        $statusDisplay .= " ($note)";
                                                    }

                                                    $updateStatusQuery = "UPDATE verifikasi_permohonan SET status=? WHERE id_permohonan=?";
                                                    $stmtUpdate = $conn->prepare($updateStatusQuery);
                                                    $stmtUpdate->bind_param("si", $statusDisplay, $row['id_permohonan']);
                                                    $stmtUpdate->execute();

                                                    $sekarang = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                                                    $tanggalVerifikasi = new DateTime($row['tanggal_verifikasi'], new DateTimeZone('Asia/Jakarta'));
                                                    $selisihHari = $sekarang->diff($tanggalVerifikasi)->days;

                                                    $queryAnswer = "SELECT * FROM answer_admin WHERE id_permohonan = ?";
                                                    $stmtAnswer = $conn->prepare($queryAnswer);
                                                    $stmtAnswer->bind_param("i", $row['id_permohonan']);
                                                    $stmtAnswer->execute();
                                                    $resultAnswer = $stmtAnswer->get_result();

                                                    if ($resultAnswer->num_rows > 0) {
                                                        $highlightClass = 'highlight-blue';
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
                                                echo "<tr><td colspan='12'>Tidak ada data ditemukan</td></tr>";
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
        $(document).ready(function() {
            $('.select-all').click(function() {
                $('.select-row').prop('checked', this.checked);
            });
            $('.select-row').click(function() {
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
        $(document).ready(function() {
            $('#permohonanTable').DataTable({
                "ordering": false
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#exportExcel').click(function() {
                var data = [];
                $('#permohonanTable tbody tr').each(function() {
                    var rowData = [];
                    $(this).find('td').each(function() {
                        rowData.push($(this).text());
                    });
                    data.push(rowData);
                });
            });
        });
    </script>
    <script>
        function HapusVerifikasi(nomer_registrasi) {
            // Pastikan hanya pengguna dengan peran admin atau superadmin yang bisa menghapus
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'superadmin') : ?>
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
                        // Kirim permintaan penghapusan ke server melalui Ajax
                        $.ajax({
                            type: "POST",
                            url: '../../../controller/Admin/Delete/hapus_verifikasi.php',
                            data: {
                                nomer_registrasi: nomer_registrasi
                            },
                            dataType: "json",
                            success: function(response) {
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
                            error: function(xhr, status, error) {
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
            <?php else : ?>
                // Tampilkan pesan bahwa pengguna tidak memiliki izin
                Swal.fire(
                    'Tidak Diizinkan!',
                    'Anda tidak memiliki izin untuk menghapus data.',
                    'error'
                );
            <?php endif; ?>
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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