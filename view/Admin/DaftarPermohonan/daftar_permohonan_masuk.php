<?php
session_start();
// Cek apakah pengguna telah login
if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}

$user_id = $_SESSION['id'];

include('../../../controller/koneksi/config.php');

// Cek apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    // Ambil parameter 'id' dari URL dan sanitasi input
    $id_permohonan = intval($_GET['id']); // Pastikan input adalah integer
}

// Pemeriksaan peran (role)
if ($_SESSION['role'] !== 'superadmin' && $_SESSION['role'] !== 'admin') {
    // Redirect pengguna non-superadmin dan non-admin ke halaman lain
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
    <link rel="stylesheet" href="../../../Assets/fontawesome/css/all.min.css">
    <link href="../../../Assets/css/style-admin.css" rel="stylesheet">

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
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">

                               
                                <div class="filter-container">
                                    <h4 class="card-title">Filter</h4>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                                            id="flexRadioDefault1" value="verified">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Verifikasi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                                            id="flexRadioDefault2" value="unverified">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Unverifikasi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                                            id="flexRadioDefault3" value="reset">
                                        <label class="form-check-label" for="flexRadioDefault3">
                                            Reset
                                        </label>
                                    </div>
                                    <button class="btn btn-success" onclick="cetakPDF()">Cetak PDF</button>
                                </div>
                                <h4 class="card-title">Data Daftar Permohonan Informasi</h4>
                                <!-- <button class="btn btn-success" onclick="cetakPDF()">Cetak PDF</button> -->
                                <div class="table-responsive">

                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama</th>
                                                <th>Informasi yang Dibutuhkan</th>
                                                <th>Alasan Pengguna Informasi</th>
                                                <th>OPD yang ditujui</th>
                                                <th style="width: 80px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $sql = "SELECT pi.*, vp.tanggal_verifikasi
                                                    FROM permohonan_informasi pi
                                                    LEFT JOIN verifikasi_permohonan vp ON pi.id = vp.id_permohonan
                                                    WHERE 1";
                                            if (isset($_GET['status']) && $_GET['status'] !== 'reset') {
                                                $status = $_GET['status'];
                                                if ($status === 'verified') {
                                                    $sql .= " AND vp.id_permohonan IS NOT NULL";
                                                } elseif ($status === 'unverified') {
                                                    $sql .= " AND vp.id_permohonan IS NULL";
                                                }
                                            }
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $formattedDate = date('d-m-Y H:i:s', strtotime($row["tanggal_permohonan"]));
                                                    echo "<tr>
                                                            <td>" . $formattedDate . "</td>
                                                            <td>" . $row["nama_pengguna"] . "</td>
                                                            <td>" . $row["informasi_yang_dibutuhkan"] . "</td>
                                                            <td>" . $row["alasan_pengguna_informasi"] . "</td>
                                                            <td>" . $row["opd_yang_dituju"] . "</td>
                                                            <td>
                                                                <a href='../DetailPermohonan/detail-PM?id=" . $row["id"] . "' class='btn btn-info btn-sm'> <i class='fas fa-info-circle'></i></a>
                                                                <button type='button' data-id='" . $row["nomer_registrasi"] . "' class='btn btn-danger btn-sm delete-btn'> <i class='fas fa-trash-alt'></i></button>
                                                                
                                                            </td>
                                                        </tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                                            }
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
        $(document).ready(function () {
            // Tangani klik tombol Hapus
            $('.delete-btn').click(function () {
                var id = $(this).data('id');

                // Tampilkan pesan konfirmasi dengan SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menghapus data ini?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan penghapusan ke server melalui Ajax
                        $.ajax({
                            url: '../../../controller/Admin/Delete/hapusdata_permohonan.php',
                            type: 'POST',
                            data: { id: id },
                            success: function (response) {
                                // Tampilkan pesan berhasil dengan SweetAlert
                                Swal.fire(
                                    'Berhasil!',
                                    'Data telah dihapus.',
                                    'success'
                                ).then((result) => {
                                    // Perbarui tabel atau lakukan aksi lain yang diperlukan setelah penghapusan berhasil
                                    // Contoh: reload halaman
                                    location.reload();
                                });
                            },
                            error: function (xhr, status, error) {
                                // Tampilkan pesan kesalahan dengan SweetAlert jika diperlukan
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('input[name="flexRadioDefault"]').change(function () {
                var status = $(this).val();
                filterData(status);
            });
        });

        function filterData(status) {
            var url = window.location.href.split('?')[0];
            if (status === 'reset') {
                window.location.href = url;
            } else {
                window.location.href = url + '?status=' + status;
            }
        }
    </script>
<script>
function cetakPDF() {
  // Get the status parameter from the URL
  var urlParams = new URLSearchParams(window.location.search);
  var status = urlParams.get('status');

  // If no status is found, default to 'reset'
  if (status === null) {
    status = 'reset';
  }

  // Use the status to construct the URL for PDF generation
  window.location.href = '../../../controller/PDFController/cetak_pdf.php?status=' + status;
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