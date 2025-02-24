<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}
$user_id = $_SESSION['id'];

include '../../../controller/koneksi/config.php';

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
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/images/logo_jateng.png">
    <!-- Custom Stylesheet -->
    <link href="../../../Assets//plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                        <div class="card">
                            <div class="card-body">
                                <h1>Pengajuan Keberatan</h1>
                                <h4 class="card-title">Data Daftar Pengajuan Keberatan</h4>
                                <div class="table-responsive">
                                    <div class="filter-container">
                                        <h4 class="card-title" style="margin-top: 20px;">Filter</h4>
                                        <div style="display: flex; flex-wrap: wrap; align-items: center; margin-bottom: 10px;">
                                            <div style="flex: 1;">
                                                <label for="start_date" style="margin-right: 10px;">Dari</label>
                                                <input type="date" id="start_date" name="start_date" style="width: 100%; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                                            </div>
                                            <div style="flex: 1;">
                                                <label for="end_date" style="margin-left: 10px; margin-right: 10px;">Sampai</label>
                                                <input type="date" id="end_date" name="end_date" style="width: 100%; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="verified">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Verifikasi
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="unverified">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Unverifikasi
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="reset">
                                            <label class="form-check-label" for="flexRadioDefault3">
                                                Reset
                                            </label>
                                        </div>
                                        <button class="btn btn-success" onclick="cetakPDF()">Cetak PDF</button>
                                    </div>
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama</th>
                                                <th>No.Register</th>
                                                <th>NIK</th>
                                                <th>OPD yang ditujui</th>
                                                <th>Informasi yang Dibutuhkan</th>
                                                <th>Alasan Keberatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include '../../../controller/koneksi/config.php';

                                            $sql = "SELECT pk.*, vk.tanggal_verifikasi
                                            FROM pengajuan_keberatan pk
                                            LEFT JOIN verifikasi_keberatan vk ON pk.nomer_registrasi_keberatan = vk.nomer_registrasi_keberatan WHERE 1";

                                            $params = [];
                                            $types = '';


                                            if (isset($_GET['status']) && $_GET['status'] !== 'reset') {
                                                $status = $_GET['status'];
                                                if ($status === 'verified') {
                                                    $sql .= " AND vk.nomer_registrasi_keberatan IS NOT NULL";
                                                } elseif ($status === 'unverified') {
                                                    $sql .= " AND vk.nomer_registrasi_keberatan IS NULL";
                                                }
                                            }

                                            // Mempersiapkan statement
                                            $stmt = $conn->prepare($sql);

                                            // Menjalankan statement
                                            $stmt->execute();

                                            // Mendapatkan hasil
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $counter = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $formattedDate = date('d-m-Y H:i:s', strtotime($row["tanggal_pengajuan"]));
                                                    echo "<tr>
                                                            <td>" . $formattedDate . "</td>
                                                            <td>" . htmlspecialchars($row["nama_pemohon"]) . "</td>
                                                            <td>" . htmlspecialchars($row["nomer_registrasi_keberatan"]) . "</td>
                                                            <td>" . htmlspecialchars($row["nik_pemohon"]) . "</td>
                                                            <td>" . htmlspecialchars($row["opd_yang_dituju"]) . "</td>
                                                            <td>" . htmlspecialchars($row["informasi_yang_diminta"]) . "</td>
                                                            <td>" . htmlspecialchars($row["alasan_keberatan"]) . "</td>
                                                            <td>
                                                                <a href='../DetailPermohonan/detail-K?id=" . urlencode($row["id"]) . "' class='btn btn-info btn-sm'><i class='fas fa-info-circle'></i></a>
                                                                <button type='button' data-id='" . htmlspecialchars($row["id"]) . "' class='btn btn-danger btn-sm delete-btn'><i class='fas fa-trash-alt'></i></button>
                                                            </td>
                                                        </tr>";
                                                    $counter++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
                                            }

                                            $stmt->close();
                                            $conn->close();
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
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tangani klik tombol Hapus
            $('.delete-btn').click(function() {
                var id = $(this).data('id');

                // Tampilkan pesan konfirmasi dengan SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus data ini?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
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
                            url: '../../../controller/Admin/Delete/DeleteKeberatan.php', // Gantilah dengan nama file PHP yang menangani penghapusan data
                            type: 'POST',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                // Perbarui tabel atau lakukan aksi lain yang diperlukan setelah penghapusan berhasil
                                // Contoh: reload halaman
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                // Tampilkan pesan kesalahan dengan SweetAlert jika diperlukan
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                                console.error("AJAX Error: " + error);
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function cetakPDF() {
            var urlParams = new URLSearchParams(window.location.search);
            var status = urlParams.get('status') || 'reset';
            var startDate = urlParams.get('start_date');
            var endDate = urlParams.get('end_date');

            var url = '../../../controller/PDFController/cetak_pdfk.php?status=' + status;
            if (startDate && endDate) {
                url += '&start_date=' + startDate + '&end_date=' + endDate;
            }
            window.location.href = url;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('input[name="flexRadioDefault"]').change(function() {
                var status = $(this).val();
                filterData(status);
            });
        });

        function filterData(status) {
            var url = window.location.href.split('?')[0];
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var params = [];
            if (status !== 'reset') {
                params.push('status=' + status);
            }
            if (startDate && endDate) {
                params.push('start_date=' + startDate);
                params.push('end_date=' + endDate);
            }
            window.location.href = url + '?' + params.join('&');
        }
    </script>
    <script src="../../../Model/Auth/TimeOut.js"></script>
    <script src="../../../Assets/plugins/common/common.min.js"></script>
    <script src="../../../Assets/js/custom.min.js"></script>
    <script src="../../../Assets/js/settings.js"></script>
    <script src="../../../Assets/js/gleek.js"></script>
    <script src="../../../Assets/js/styleSwitcher.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../../../Assets/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../../../Assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../../../Assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

</body>

</html>