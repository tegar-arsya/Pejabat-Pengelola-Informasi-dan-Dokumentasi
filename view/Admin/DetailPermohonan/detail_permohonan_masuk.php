<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}
$user_id = $_SESSION['id'];

include('../../../controller/koneksi/config.php');

if (isset($_GET['id'])) {
    $id_permohonan = $_GET['id'];

    // Query untuk mengambil detail permohonan dan data registrasi berdasarkan ID permohonan
    $query = "SELECT p.id, p.id_registrasi, p.nomer_registrasi,r.id, r.nik, r.no_hp, r.foto_ktp,  r.alamat, r.email,p.nama_pengguna, p.opd_yang_dituju, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi, p.cara_mendapatkan_informasi, p.cara_mendapatkan_salinan, p.tanggal_permohonan
              FROM permohonan_informasi p
              JOIN registrasi r ON p.id_registrasi = r.id
              WHERE p.id = $id_permohonan";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $nomorRegistrasi = $row['nomer_registrasi'];
    } else {
        // Redirect atau tampilkan pesan kesalahan jika permohonan tidak ditemukan
        header("Location: ../../../components/ErorAkses");
        exit();
    }
} else {
    // Redirect atau tampilkan pesan kesalahan jika parameter ID permohonan tidak ada dalam URL
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
    <link href="../../../Assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                <h2 style="text-align: center;">Permohonan Informasi</h2>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Nama Pemohon:</strong></td>
                                        <td>
                                            <?php echo $row['nama_pengguna']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Permohonan:</strong></td>
                                        <td>
                                            <?php echo !empty($row['tanggal_permohonan']) ? date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan'])) : ''; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor Register:</strong></td>
                                        <td id="nomorRegistrasiCell"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIK:</strong></td>
                                        <td>
                                            <?php echo $row['nik']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Foto KTP:</strong></td>
                                        <td><a href="../../../Assets/uploads/<?php echo $row['foto_ktp']; ?>" target="_blank">
                                                <?php echo $row['foto_ktp']; ?>
                                            </a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>
                                            <?php echo $row['email']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>No Hp:</strong></td>
                                        <td>
                                            <?php echo $row['no_hp']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat:</strong></td>
                                        <td>
                                            <?php echo $row['alamat']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Informasi yang Dibutuhkan:</strong></td>
                                        <td>
                                            <?php echo $row['informasi_yang_dibutuhkan']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alasan Pengguna Informasi:</strong></td>
                                        <td>
                                            <?php echo $row['alasan_pengguna_informasi']; ?>
                                        </td>
                                    </tr>
                                </table>
                                <button class="btn btn-primary" onclick="goBack()">Back</button>
                                <button class="btn btn-success" id="verifikasiBtn">Verifikasi</button>
                                <button class="btn btn-danger" id="blmVld" onclick="belumValid()">Belum Valid</button>


                                <div id="alasanPenolakanForm" class="hidden">
                                    <form action="../../../controller/smtpmail/sendmail.php" method="POST"
                                        enctype="multipart/form-data">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Nomer registrasi :</td>
                                                <td>
                                                    <?php echo $row['nomer_registrasi']; ?>
                                                </td>
                                                <td><input type="hidden" name="nomer_registrasi"
                                                        value="<?php echo $row['nomer_registrasi']; ?>"></td>
                                                        <input type="hidden" name="id_permohonan"
                                                        value="<?php echo $id_permohonan; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Nama :</td>
                                                <td>
                                                    <?php echo $row['nama_pengguna']; ?>
                                                </td>
                                                <td><input type="hidden" name="nama"
                                                        value="<?php echo $row['nama_pengguna']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Email :</td>
                                                <td>
                                                    <?php echo $row['email']; ?>
                                                </td>
                                                <td><input type="hidden" name="email"
                                                        value="<?php echo $row['email']; ?>"></td>
                                                        <input type="hidden" name="id_registrasi"
                                                        value="<?php echo $row['id_registrasi']; ?>"></td>
                                            </tr>
                                            <td>Subjek :</td>
                                            <td><input type="text" name="subjek" size="30" style="width: 100%;"></td>
                                            </tr>
                                            <tr>
                                                <td>alasan :</td>
                                                <td><textarea name="alasan" cols="32" rows="5" style="width: 100%;">
                                            </textarea></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><input type="submit" class="btn btn-success" name="kirim"
                                                        id="kirimBtn" value="Kirim"></td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card" id="dataTableCard">
                            <div class="card-body">
                                <div class="table-responsive hidden" id="dataTable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Informasi yang Dibutuhkan</th>
                                                <th>OPD yang Ditujukan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php echo $row['informasi_yang_dibutuhkan']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['opd_yang_dituju']; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-success" id="simpanVerif">Simpan</button>
                                    <button class="btn btn-danger" onclick="batal()">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../../components/footer.html'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var isButtonClicked = false;
        document.getElementById('verifikasiBtn').addEventListener('click', function () {
            var idPermohonan = <?php echo $id_permohonan; ?>;
            // Kirim permintaan verifikasi ke server melalui Ajax
            $.ajax({
                url: '../../../controller/VerifikasiPermohonanController/verifikasi_permohonan.php',
                type: 'POST',
                data: { id: idPermohonan },
                success: function (response) {
                    var nomorRegistrasi = response;
                    document.getElementById('nomorRegistrasiCell').textContent = nomorRegistrasi;

                    // Mengganti pemanggilan alert dengan SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Verifikasi berhasil',
                        text: 'Nomor registrasi: ' + nomorRegistrasi,
                    });

                    var table = document.getElementById('dataTable');
                    table.classList.remove('hidden');
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });


        document.getElementById('simpanVerif').addEventListener('click', function () {
            if (isButtonClicked) {
                return;
            }

            var idPermohonan = <?php echo $id_permohonan; ?>;
            isButtonClicked = true;

            // Kirim permintaan verifikasi ke server melalui Ajax
            $.ajax({
                url: '../../../controller/VerifikasiPermohonanController/simpan_verifikasi.php',
                type: 'POST',
                data: { id: idPermohonan },
                success: function (response) {
                    var nomorRegistrasi = response;
                    $('#nomorRegistrasiCell').text(nomorRegistrasi);

                    // Mengganti pemanggilan alert dengan SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Verifikasi berhasil',
                        text: 'Permohonan Anda Sudah Terkirim Ke OPD',
                        showConfirmButton: false, // Tidak menampilkan tombol OK
                        timer: 1500, // Durasi SweetAlert ditampilkan (ms)
                        timerProgressBar: true // Menampilkan progress bar timer
                    }).then(function () {
                        // Redirect ke halaman listPI setelah SweetAlert ditampilkan
                        window.location.href = '../../../view/Admin/DaftarPermohonan/listPI';
                    });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });


        function belumValid() {
            $('#alasanPenolakanForm').removeClass('hidden');
        }

        document.getElementById('kirimBtn').addEventListener('click', function () {
            if (isButtonClicked) {
                return;
            }

            var idPermohonan = <?php echo $id_permohonan; ?>;
            isButtonClicked = true;

            // Kirim permintaan verifikasi ke server melalui Ajax
            $.ajax({
                url: '../../../controller/FormPenolakanController/save_Rejected.php',
                type: 'POST',
                data: { id: idPermohonan },
                success: function (response) {
                    var nomorRegistrasi = response;
                    $('#nomorRegistrasiCell').text(nomorRegistrasi);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
    <script>
        function goBack() {
            window.history.back();
        }
        function batal() {
            document.getElementById('dataTableCard').style.display = 'none';
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