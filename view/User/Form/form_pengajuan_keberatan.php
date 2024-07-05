<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../");
    exit();
}
$user_id = $_SESSION['id'];
include '../../../controller/koneksi/config.php';

function getOPDData()
{
    global $conn; // $conn adalah objek koneksi dari file config.php

    $query = "SELECT id_opd, nama FROM tbl_daftar_opd";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $opdData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $opdData[] = array('id' => $row['id_opd'], 'nama' => $row['nama']);
    }

    return $opdData;
}

// Mendapatkan data OPD dari fungsi
$opdOptions = getOPDData();

if (!isset($_GET['registrasi'])) {
    header("Location: ../../../components/ErorAkses");
    exit();
}
$nomer_registrasi = preg_replace('/[^A-Za-z0-9\/\-]/', '', $_GET['registrasi']);
$nomer_registrasi = mysqli_real_escape_string($conn, $nomer_registrasi);

// Prepared statement untuk mendapatkan data permohonan informasi
$sql = "SELECT pi.nomer_registrasi, pi.nama_pengguna, pi.informasi_yang_dibutuhkan, pi.tanggal_permohonan, pi.id_registrasi, pi.id, r.nik, r.email, r.foto_ktp
        FROM permohonan_informasi pi
        JOIN registrasi r ON pi.id_registrasi = r.id
        WHERE pi.nomer_registrasi = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nomer_registrasi);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_permohonan_informasi = $row['id'];
        $emailpemohon = $row['email'];
        $nik_pemohon = $row['nik'];
        $informasi_yang_diminta = $row['informasi_yang_dibutuhkan'];
        $nama_pemohon = $row['nama_pengguna'];
        $tanggal_permohonan = $row['tanggal_permohonan'];
        $foto_ktp_pemohon = $row['foto_ktp'];
        $id_registrasi = $row['id_registrasi'];
    }
} else {
    echo "Informasi yang diminta tidak ditemukan.";
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/e601bb8c4c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Jarallax CSS -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/img/logo_jateng.png">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../Assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="../../../Assets/css/style.css" />
    <title>Pengajuan Keberatan</title>
</head>

<body onload="generate()">
    <!-- navbar -->
    <?php include '../../../components/navbar.php'; ?>
    <div class="custom-line"></div>
    <div class="container">
        <h1 class="form-title">Pengajuan Keberatan Informasi</h1>
        <form id="myForm" action="../controller/simpan_data_pengajuan_keberatan.php" method="post" enctype="multipart/form-data">
            <h3>Pengajuan Keberatan</h3>
            <div class="main-user-info">
                <div class="user-input-box">
                    <label for="code">Kode Permohonan Informasi*</label>
                    <div class="card" style="background-color: white;">
                        <div class="card-body">
                            <?php echo htmlspecialchars($nomer_registrasi, ENT_QUOTES, 'UTF-8'); ?> <?php echo $nomer_registrasi; ?>
                        </div>
                        <input type="hidden" name="id_registrasi" value="<?php echo htmlspecialchars($id_registrasi, ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="id_permohonan_informasi" value="<?php echo htmlspecialchars($id_permohonan_informasi, ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="emailpemohon" value="<?php echo htmlspecialchars($emailpemohon, ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="nomer_registrasi" value="<?php echo htmlspecialchars($nomer_registrasi, ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="tanggal_permohonan" value="<?php echo htmlspecialchars($tanggal_permohonan, ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="nik_pemohon" value="<?php echo htmlspecialchars($nik_pemohon, ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="foto_ktp_pemohon" value="<?php echo htmlspecialchars($foto_ktp_pemohon, ENT_QUOTES, 'UTF-8'); ?>" />
                    </div>
                </div>
                <div class="user-input-box">
                    <label for="informasiyangdiminta">Informasi yang diminta</label>
                    <div class="card">
                        <div class="card-body">
                            <?php echo $informasi_yang_diminta; ?>
                        </div>
                        <input type="hidden" name="informasiyangdiminta" value="<?php echo $informasi_yang_diminta; ?>" />
                    </div>
                </div>
                <div class="user-input-box">
                    <label for="kuasapermohonan">Permohonan ini dikuasakan</label>
                    <select type="text" id="kuasapermohonan" name="kuasapermohonan" required>
                        <option>Perorangan</option>
                        <option>Kelompok Orang</option>
                        <option>Badan Hukum</option>
                    </select>
                    <!-- <h3>Dikuasakan Kepada</h3> -->
                </div>
                <div class="user-input-box">
                    <label for="namapemohon">Nama Pemohon</label>
                    <div class="card">
                        <div class="card-body">
                            <?php echo $nama_pemohon; ?>
                        </div>
                        <input type="hidden" name="namapemohon" value="<?php echo $nama_pemohon; ?>" />
                    </div>
                </div>
                <div class="user-input-box1">
                    <h3>Dikuasakan Kepada</h3>
                </div>
                <div class="user-input-box">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required />
                </div>
                <div class="user-input-box">
                    <label for="email">EMAIL</label>
                    <input type="email" id="email" name="email" required />
                </div>
                <div class="user-input-box">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" required />
                </div>
                <div class="user-input-box">
                    <label for="nohp">No. HP</label>
                    <input type="text" id="nohp" name="nohp" required />
                </div>
                <div class="user-input-box">
                    <label for="fotoktp">Foto KTP</label>
                    <input type="file" id="fotoktp" name="fotoktp" accept="image/*,application/pdf" placeholder="Drag file or click to upload" required />
                </div>

                <div class="user-input-box">
                    <label for=""></label>

                </div>
                <div class="user-input-box">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required />
                </div>

                <div class="user-input-box">
                    <label for="kota_kabupaten">Kota/Kabupaten</label>
                    <select id="kota_kabupaten" name="kota_kabupaten" required>
                    </select>
                </div>
                <div class="user-input-box">
                    <label for="negara">Negara</label>
                    <select id="negara" name="negara" class="js-example-basic-single" required>
                        <option disabled>Pilih Negara</option>
                        <option value="kosong"></option>
                    </select>
                </div>
                <div class="user-input-box">
                    <label for="kode_pos">KODE POS</label>
                    <input type="text" id="kode_pos" name="kode_pos" required />
                </div>
                <div class="user-input-box">
                    <label for="provinsi">PROVINSI</label>
                    <select id="provinsi" name="provinsi" required>
                    </select>
                </div>

                <div class="user-input-box">
                    <label for="opd">OPD yang di tuju</label>
                    <select id="opd" name="opd" class="js-example-basic-single" required>
                        <option disabled>Pilih OPD</option>
                        <option value="kosong"></option>
                        <?php
                        foreach ($opdOptions as $opd) {
                            echo "<option value=\"{$opd['id']}\">{$opd['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="user-input-box">
                <label for="pekerjaan">PEKERJAAN</label>
                <input type="text" id="pekerjaan" name="pekerjaan" required>
            </div>
            <!-- <div class="grid" style="--bs-columns: 18; --bs-gap: .5rem;">
                <div style="grid-column: span 10;"> -->
            <div class="user-input-box">
                <label for="suratkuasa">Unggah Surat Kuasa</label>
                <input type="file" id="suratkuasa" name="suratkuasa" accept=".pdf, .doc, .docx" required />
            </div>

            <!-- </div>
                <div class="g-col-8">
                    <div id="captcha-container">
                        <div id="captcha"></div>
                        <button type="button" id="reload-button">Reload<br>CAPTCHA</button>
                    </div>
                </div>
            </div> -->
            <!-- <div class="grid" style="--bs-columns: 18; --bs-gap: .5rem;">
                <div style="grid-column: span 10;"> -->

            <div class="user-input-box">
                <label for="alasankeberatan">Alasan Keberatan</label>
                <select id="alasankeberatan" name="alasankeberatan" required>
                    <option>Permohonan Informasi ditolak</option>
                    <option>Informasi berkala tidak disediakan</option>
                    <option>Permintaan informasi tidak ditanggapi</option>
                    <option>Permintaan informasi ditanggapi tidak sebagaimana yang diminta</option>
                    <option>Permintaan informasi tidak dipenuhi</option>
                    <option>Biaya yang dikenakan tidak wajar</option>
                    <option>Informasi disampaikan melebihi jangka waktu yang ditentukan</option>
                </select>
            </div>
            <!-- </div> -->
            <!-- <div class="g-col-8"> -->
            <div class="user-input-box1">
                <div id="captcha-container">
                    <div id="captcha"></div>
                    <button type="button" id="reload-button"><i class="fas fa-sync-alt"></i></button>
                </div>
            </div>
            <div class="user-input-box1">
                <input type="text1" id="user-input" name="user-input" placeholder="Enter the text in the CAPTCHA" />
                <div><button type="submit" id="kirim-button">Kirim</button>
                </div>
            </div>
    </div>
    </form>
    </div>
    <?php include '../../../components/footer.php'; ?>
    <script>
        function generateCaptcha() {
            // Mengambil nilai CAPTCHA dari server
            fetch('../../../Model/Captcha/generate_captcha.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('captcha').textContent = data;
                });
        }

        document.getElementById('reload-button').addEventListener('click', generateCaptcha);

        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah tindakan bawaan formulir

            var userInput = document.getElementById('user-input').value;
            var captchaValue = document.getElementById('captcha').textContent.trim();

            if (userInput === captchaValue) {
                // CAPTCHA benar, kirim data ke server menggunakan fetch API
                fetch('../../../controller/FormController/simpan_data_pengajuan_keberatan.php', {
                        method: 'POST',
                        body: new FormData(document.getElementById('myForm'))
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Jika penyimpanan data di server berhasil, tampilkan popup SweetAlert2
                            Swal.fire({
                                title: 'Berhasil Terkirim',
                                html: 'Permohonan informasi publik anda telah berhasil terkirim, untuk detail lebih lanjut mohon untuk dicek di bagian <a href="../../../view/User/Daftar/daftarkeberatanPengguna" style="color: red; text-decoration: underline;">riwayat Keberatan</a>',
                                icon: 'success',
                            });

                            // Clear input CAPTCHA dan isi ulang CAPTCHA
                            document.getElementById('user-input').value = '';
                            generateCaptcha();
                        } else {
                            // Jika penyimpanan data di server gagal, tampilkan pesan kesalahan
                            Swal.fire(
                                'Error',
                                'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                                'error'
                            );
                            // Regenerate CAPTCHA
                            generateCaptcha();
                        }
                    });
            } else {
                // CAPTCHA salah, tampilkan pesan kesalahan
                Swal.fire(
                    'Error',
                    'CAPTCHA tidak sesuai. Silakan coba lagi.',
                    'error'
                );
                // Regenerate CAPTCHA
                generateCaptcha();
            }
        });

        // Generate CAPTCHA saat halaman dimuat
        window.addEventListener('load', generateCaptcha);
    </script>
    <script src="../../../Model/User/data.js"></script>
    <script src="../../../Model/User/api.js"></script>
    <script src="../../../Model/Auth/TimeOutUser.js"></script>
    <script>
        // In your Javascript
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>