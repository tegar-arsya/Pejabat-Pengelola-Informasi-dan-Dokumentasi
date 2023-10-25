<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['id'];

// Ambil nilai ID pengguna dari parameter URL
if (isset($_GET['id'])) {
    $id_pengguna = $_GET['id'];
} else {
    // Handle jika parameter id tidak ada dalam URL
    echo "ID Pengguna tidak ditemukan.";
    exit();
}
// Lakukan koneksi ke database (sesuaikan dengan konfigurasi database Anda)
include('../koneksi/config.php');

// Lakukan kueri SQL untuk mengambil informasi yang diminta berdasarkan ID pengguna
$sql = "SELECT nama_pengguna, informasi_yang_dibutuhkan FROM permohonan_informasi WHERE id = $id_pengguna";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data dari setiap baris hasil kueri
    while ($row = $result->fetch_assoc()) {
        $informasi_yang_diminta = $row['informasi_yang_dibutuhkan'];
        $nama_pemohon = $row['nama_pengguna'];
    }
} else {
    echo "Informasi yang diminta tidak ditemukan.";
}

// Tutup koneksi ke database
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
    <!-- Jarallax CSS -->
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo_jateng.png">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="../fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Pengajuan Keberatan</title>
</head>

<body onload="generate()">
    <!-- navbar -->
    <header>
        <div class="container-fluid">
            <div class="navb-logo">
                <img src="../img/logo_jateng.png" alt="Logo" />
            </div>
            <div class="info">
                <h4>LAYANAN PERMOHONAN INFORMASI</h4>
                <h5>PROVINSI JAWA TENGAH</h5>
            </div>
            <div class="navb-items d-none d-xl-flex">
                <div class="item">
                    <a href="">Permohonan Informasi</a>
                </div>

                <div class="item">
                    <a href="">Pengajuan Keberatan</a>
                </div>

                <div class="item">
                    <a href="">Paduan</a>
                </div>

                <div class="item">
                    <a href="">Login</a>
                </div>
            </div>

            <!-- Button trigger modal -->
            <div class="mobile-toggler d-lg-none">
                <a href="#" data-bs-toggle="modal" data-bs-target="#navbModal">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="navbModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <img src="../img/logo_jateng.png" alt="Logo" />
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="modal-line">
                                <i class="fa-solid fa-circle-info"></i><a href="">Permohonan Informasi</a>
                            </div>

                            <div class="modal-line">
                                <i class="fa-solid fa-file-invoice"></i><a href="">Pengajuan Keberatan</a>
                            </div>

                            <div class="modal-line">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <a href="">Panduan</a>
                            </div>

                            <div class="modal-line">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i><a href="">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="custom-line"></div>
    <div class="container">
        <h1 class="form-title">Pengajuan Keberatan Informasi</h1>
        <form id="myForm" action="../controller/simpan_data_pengajuan_keberatan.php" method="post" enctype="multipart/form-data">
            <h3>Pengajuan Keberatan</h3>
            <div class="main-user-info">
                <div class="user-input-box">
                    <label for="code">Kode Permohonan Informasi*</label>
                    <div class="card" style="background-color: white;">
                        <div class="card-body"><?php echo $id_pengguna; ?></div>
                        <input type="hidden" name="id_pengguna" value="<?php echo $id_pengguna; ?>" />
                    </div>
                </div>
                <div class="user-input-box">
                    <label for="informasiyangdiminta">Informasi yang diminta</label>
                    <div class="card">
                        <div class="card-body">
                        <?php echo $informasi_yang_diminta; ?>
                        </div>
                    </div>
                </div>
                <div class="user-input-box">
                    <label for="kuasapermohonan">Permohonan ini dikuasakan</label>
                    <select type="text" id="kuasapermohonan" name="kuasapermohonan" required>
                        <option>Perorangan</option>
                        <option>Kelompok Orang</option>
                        <option>Badan Hukum</option>
                    </select>
                    <h3>Dikuasakan Kepada</h3>
                </div>
                <div class="user-input-box">
                    <label for="namapemohon">Nama Pemohon</label>
                    <div class="card">
                        <div class="card-body"><?php echo $nama_pemohon; ?></div>
                    </div>
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
                    <label for="odpyangdituju">ODP yang dituju</label>
                    <input type="text" id="odpyangdituju" name="odpyangdituju" required />
                </div>
            </div>
            <div class="user-input-box">
                    <label for="pekerjaan">PEKERJAAN</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" required>
                </div>
            <div class="grid" style="--bs-columns: 18; --bs-gap: .5rem;">
                <div style="grid-column: span 10;">
                <div class="user-input-box1">
                    <label for="surat">Unggah Surat Kuasa</label>
                    <input type="file" id="surat" name="surat" accept=".pdf, .doc, .docx" required />
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
    <script src="../js/script.js"></script>
    <script src="../js/data.js"></script>
    <script src="../js/kota.js"></script>
    <script src="../js/provinsi.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>