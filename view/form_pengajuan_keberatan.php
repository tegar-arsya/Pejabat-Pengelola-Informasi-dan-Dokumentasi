<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['id'];
include('../controller/koneksi/config.php');
function getOPDData() {
    global $conn; // $conn adalah objek koneksi dari file config.php

    // Gantilah "nama_tabel" dengan nama tabel yang sesuai di database Anda
    $query = "SELECT nama FROM tbl_daftar_opd";
    $result = mysqli_query($conn, $query);

    $opdData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $opdData[] = $row['nama'];
    }

    return $opdData;
}

// Mendapatkan data OPD dari fungsi
$opdOptions = getOPDData();
if (!isset($_GET['registrasi'])) {
    header("Location: ../components/eror.html");
    exit();
}
$nomer_registrasi = $_GET['registrasi'];
$nik = $_SESSION['nik'];
$sql = "SELECT pi.nomer_registrasi, pi.nama_pengguna, pi.informasi_yang_dibutuhkan, pi.tanggal_permohonan, pi.id_user, r.email, r.foto_ktp
FROM permohonan_informasi pi
JOIN registrasi r ON pi.id_user = r.nik
WHERE pi.nomer_registrasi = '$nomer_registrasi'";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $emailpemohon = $row['email'];
        $nik_pemohon = $row['id_user'];
        $informasi_yang_diminta = $row['informasi_yang_dibutuhkan'];
        $nama_pemohon = $row['nama_pengguna'];
        $tanggal_permohonan = $row['tanggal_permohonan'];
        $foto_ktp_pemohon = $row['foto_ktp'];
      
    }
} else {
    echo "Informasi yang diminta tidak ditemukan.";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/e601bb8c4c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Jarallax CSS -->
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/img/logo_jateng.png">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="../Assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="../Assets/css/style.css" />
    <title>Pengajuan Keberatan</title>
</head>

<body onload="generate()">
    <!-- navbar -->
    <?php include '../components/navbar.php'; ?>
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
                            <?php echo $nomer_registrasi; ?>
                        </div>
                        <input type="hidden" name="emailpemohon" value="<?php echo $emailpemohon; ?>" />
                        <input type="hidden" name="nomer_registrasi" value="<?php echo $nomer_registrasi; ?>" />
                        <input type="hidden" name="tanggal_permohonan" value="<?php echo $tanggal_permohonan; ?>"/>
                        <input type="hidden" name="nik_pemohon" value="<?php echo $nik_pemohon; ?>"/>
                        <input type="hidden" name="foto_ktp_pemohon" value="<?php echo $foto_ktp_pemohon; ?>"/>
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
                    <input type="text" id="email" name="email" required />
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
                    <label for="fotoktp">foto ktp</label>
                    <input type="file" id="fotoktp" name="fotoktp" accept="image/*"
                        placeholder="Drag file Or klik tO upload" required />
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
                    <select id="negara" name="negara" required>
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
                            echo "<option value=\"$opd\">$opd</option>";
                        }
                        ?>
        </select>
    </div>
            </div>
            <div class="user-input-box">
                <label for="pekerjaan">PEKERJAAN</label>
                <input type="text" id="pekerjaan" name="pekerjaan" required>
            </div>
            <div class="grid" style="--bs-columns: 18; --bs-gap: .5rem;">
                <div style="grid-column: span 10;">
                    <div class="user-input-box1">
                        <label for="suratkuasa">Unggah Surat Kuasa</label>
                        <input type="file" id="suratkuasa" name="suratkuasa" accept=".pdf, .doc, .docx" required />
                    </div>

                </div>
                <div class="g-col-8">
                    <div id="captcha-container">
                        <div id="captcha"></div>
                        <button type="button" id="reload-button">Reload<br>CAPTCHA</button>
                    </div>
                </div>
            </div>
            <div class="grid" style="--bs-columns: 18; --bs-gap: .5rem;">
                <div style="grid-column: span 10;">

                    <div class="user-input-box1">
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
                </div>
                <div class="g-col-8">
                    <input type="text1" id="user-input" name="user-input" placeholder="Enter the text in the CAPTCHA" />
                    <div><button type="submit" id="kirim-button">Kirim</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php include '../components/footer.php'; ?>
    <script src="../Model/User/aduan.js"></script>
    <script src="../Model/User/data.js"></script>
    <script src="../Model/User/api.js"></script>
    <script>
        // In your Javascript
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>