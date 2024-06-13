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
    $query = "SELECT nama_pemohon, nomer_registrasi_keberatan,kode_permohonan_informasi,
    tanggal_permohonan, nik_pemohon, foto_ktp, informasi_yang_diminta, alasan_keberatan, nama,
    pekerjaan, unggah_surat_kuasa, opd_yang_dituju, email,email_pemohon, foto_ktp_pemohon
    FROM pengajuan_keberatan WHERE id = $id_permohonan";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $nomorRegistrasi = $row['nomer_registrasi_keberatan'];
    } else {
        // Redirect atau tampilkan pesan kesalahan jika permohonan tidak ditemukan
        header("Location: ../components/eror.html");
        exit();
    }
} else {
    // Redirect atau tampilkan pesan kesalahan jika parameter ID permohonan tidak ada dalam URL
    header("Location: ../components/eror.html");
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
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/images/logo_jateng.png">
    <!-- Custom Stylesheet -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
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
                            <h2 style="text-align: center;">Detail Pengajuan Keberatan Informasi</h2>
                            <div class="card-body">
                                <h4>Identitas Pemohon</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Nama Pemohon</strong></td>
                                        <td>
                                            <?php echo $row['nama_pemohon']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Permohonan</strong></td>
                                        <td>
                                        <?php echo !empty($row['tanggal_permohonan']) ? date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan'])) : ''; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor Registasi Permohonan</strong></td>
                                        <td>
                                            <?php echo $row['kode_permohonan_informasi']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor Register Keberatan</strong></td>
                                        <td id="nomorRegistrasiCell">
                                            <?php echo $row['nomer_registrasi_keberatan']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIK</strong></td>
                                        <td>
                                            <?php echo $row['nik_pemohon']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email Pemohon</strong></td>
                                        <td>
                                            <?php echo $row['email_pemohon']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Foto KTP</strong></td>
                                        <td><a href="../Assets/uploads/<?php echo $row['foto_ktp_pemohon']; ?>"
                                                target="_blank">
                                                <?php echo $row['foto_ktp_pemohon']; ?>
                                            </a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Opd Yang Di Tuju</strong></td>
                                        <td>
                                            <?php echo $row['opd_yang_dituju']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Informasi yang Dibutuhkan</strong></td>
                                        <td>
                                            <?php echo $row['informasi_yang_diminta']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alasan Keberatan</strong></td>
                                        <td>
                                            <?php echo $row['alasan_keberatan']; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>Dikuasakan Kepada</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Nama :</strong></td>
                                        <td>
                                            <?php echo $row['nama']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Foto KTP</strong></td>
                                        <td><a href="../Assets/uploads/keberatan/gambar/<?php echo $row['foto_ktp']; ?>"
                                                target="_blank">
                                                <?php echo $row['foto_ktp']; ?>
                                            </a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pekerjaan:</strong></td>
                                        <td>
                                            <?php echo $row['pekerjaan']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Surat Kuasa:</strong></td>
                                        <td><a href="../Assets/uploads/keberatan/dokumen/<?php echo $row['unggah_surat_kuasa']; ?>"
                                                target="_blank">
                                                <?php echo $row['unggah_surat_kuasa']; ?>
                                            </a></td>
                                    </tr>
                                </table>

                                <button class="btn btn-primary" onclick="goBack()">Back</button>
                                <button class="btn btn-success" id="buttonVerifikasi">Verifikasi</button>
                                <button class="btn btn-danger" id="blmVld" onclick="belumValid()">Belum Valid</button>
                               
                            <div id="alasanPenolakanForm" class="hidden">
                        <form action="../controller/smtpmail/sendmailPenolakan.php" method="POST"
                            enctype="multipart/form-data">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Nomer registrasi Keberatan :</td>
                                    <td>
                                        <?php echo $row['nomer_registrasi_keberatan']; ?>
                                    </td>
                                    <td><input type="hidden" name="nomer_registrasi_keberatan"
                                            value="<?php echo $row['nomer_registrasi_keberatan']; ?>">
                                            <input type="hidden" name="id_permohonan"
                                            value="<?php echo $id_permohonan; ?>">
                                        </td>
                                </tr>
                                <tr>
                                    <td>Nama Pemohon:</td>
                                    <td>
                                        <?php echo $row['nama_pemohon']; ?>
                                    </td>
                                    <td><input type="hidden" name="namapemohon"
                                            value="<?php echo $row['nama_pemohon']; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Email :</td>
                                    <td>
                                        <?php echo $row['email']; ?>
                                    </td>
                                    <td><input type="hidden" name="email" value="<?php echo $row['email']; ?>"></td>
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
                                    <td><input type="submit" class="btn btn-success" name="kirim" id="kirimBtn"
                                            value="Kirim"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php include '../components/footer.html'; ?>
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var isButtonClicked = false;
document.getElementById('buttonVerifikasi').addEventListener('click', function () {
    var idPermohonan = <?php echo $id_permohonan; ?>;

    // Kirim permintaan verifikasi ke server melalui Ajax
    $.ajax({
        url: '../controller/verifikasi_keberatan.php', // Combined URL for verification
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

    // Jika perlu tambahan logika setelah verifikasi, tambahkan di sini
    if (!isButtonClicked) {
        var idPermohonan = <?php echo $id_permohonan; ?>;
        isButtonClicked = true;

        // Kirim permintaan verifikasi tambahan ke server melalui Ajax
        $.ajax({
            url: '../controller/simpan_verifikasi_keberatan.php', // Combined URL for additional verification logic
            type: 'POST',
            data: { id: idPermohonan },
            success: function (response) {
                var nomorRegistrasi = response;
                $('#nomorRegistrasiCell').text(nomorRegistrasi);
                
                // Mengganti pemanggilan alert dengan SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Verifikasi Telah berhasil',
                    text: 'Permohonan Keberatan Anda Sudah Diverifikasi Oleh Admin ',
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
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
                url: '../controller/save_Rejected_keberatan.php',
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
        document.getElementById('answerFormContent').addEventListener('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);
                    closeForm();
                } else {
                    alert('Terjadi kesalahan: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    function answer() {
        var modal = document.getElementById('answerForm');
        modal.style.display = 'block';
    }

    function closeForm() {
        var modal = document.getElementById('answerForm');
        modal.style.display = 'none';
    }
    window.onclick = function (event) {
        var modal = document.getElementById('answerForm');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
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