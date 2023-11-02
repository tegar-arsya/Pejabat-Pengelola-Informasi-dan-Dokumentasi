<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['id'];
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
    <title>Form Permohonan</title>
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
                    <a href="../view/formulir">Permohonan Informasi</a>
                </div>

                <div class="item">
                    <a href="../view/aduan">Pengajuan Keberatan</a>
                </div>

                <div class="item">
                    <a href="../components/panduan.html">Paduan</a>
                </div>

                <div class="item">
                    <a href="../controller/logout.php">Logout</a>
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
                            <img src="/img/logo_jateng.png" alt="Logo" />
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="modal-line">
                                <i class="fa-solid fa-circle-info"></i><a href="../view/formulir">Permohonan Informasi</a>
                            </div>

                            <div class="modal-line">
                                <i class="fa-solid fa-file-invoice"></i><a href="../view/aduan">Pengajuan Keberatan</a>
                            </div>

                            <div class="modal-line">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <a href="../components/panduan.html">Paduan</a>
                            </div>

                            <div class="modal-line">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i><a href="../controller/logout.php">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="custom-line"></div>
    <div class="container">
        <h1 class="form-title">Formulir Permohonan Informasi Publik</h1>
        <form id="myForm" action="../controller/simpandataformulirpermohonaninformasipublik.php" method="post">
            <h3>Personal Information</h3>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="opd">OPD yang di tuju</label>
                    <select id="opd" name="opd" required>
                        <option>Sekretaris Daerah Provinsi Jawa Tengah</option>
                        <option>Sekretaris DPRD Provinsi Jawa Tengah</option>
                        <option>Insprektur Provinsi Jawa Tengah</option>
                        <option>Kepala Pelaksana Harian Badan Penanggulangan Bencana Daerah Provinsi Jawa Tengah</option>
                        <option>Kepala Badan Kesatuan Bangsa, Politik Dan Perlindungan Masyarakat Provinsi Jawa Tengah</option>
                        <option>Kepala Badan Perencanaan Pembangunan, Penelitian Dan Pengembangan Daerah Provinsi Jawa Tengah</option>
                        <option>Kepala Badan Kepegawaian Daerah Provinsi Jawa Tengah</option>
                        <option>Kepala Badan Pengembangan Sumber Daya Manusia Provinsi Jawa Tengah</option>
                        <option>Kepala Badan Pengelola Pendapatan Daerah Provinsi Jawa Tengah</option>
                        <option>Kepala Badan Penghubung Provinsi Jawa Tengah</option>
                        <option>Kepala Badan Pengelola Keuangan dan Aset Daerah Provinsi Jawa Tengah</option>
                        <option>Kepala Satuan Polisi Pamong Praja Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Pendidikan Dan Kebudayaan Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Kesehatan Jawa Tengah</option>
                        <option>Kepala Dinas Pekerjaan Umum Bina Marga Dan Cipta Karya Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Pekerjaan Umum Sumber Daya Air Dan Penataan Ruang Provinsi Jawa Tengah</option>
                        <option>Kepala Diqnas Perumahan Rakyat Dan Kawasan Permukiman Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Sosial Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Tenaga Kerja Dan Transmigrasi Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Energi Dan Sumber Daya Mineral Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Kepemudaan, Olahraga Dan Pariwisata Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Perhubungan Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Komunikasi Dan Informatika Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Perindustrian Dan Perdagangan Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Koperasi, Usaha Kecil Dan Menengah Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Pertanian Dan Perkebunan Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Ketahanan Pangan Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Peternakan Dan Kesehatan Hewan Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Kelautan Dan Perikanan Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Lingkungan Hidup dan Kehutanan Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Pemberdayaan Masyarakat, Desa, Kependudukan Dan Catatan Sipil Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Pemberdayaan Perempuan, Perlindungan Anak, Pengendalian Penduduk Dan Keluarga Berencana Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Penanaman Modal Dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Tengah</option>
                        <option>Kepala Dinas Kearsipan Dan Perpustakaan Provinsi Jawa Tengah</option>
                        <option>Kepala RSUD Dr. Moewardi Provinsi Jawa Tengah</option>
                        <option>Kepala RSUD Prof. Dr. Margono Soekardjo Provinsi Jawa Tengah</option>
                        <option>Kepala RSUD Tugurejo Provinsi Jawa Tengah</option>
                        <option>Kepala RSUD Kelet Provinsi Jawa Tengah</option>
                        <option>Kepala RSJD Dr. Amino Gondohutomo Provinsi Jawa Tengah</option>
                        <option>Kepala RSJD Surakarta Provinsi Jawa Tengah</option>
                        <option>Kepala RSJD Dr. RM Soedjarwadi Provinsi Jawa Tengah</option>
                        <option>Direktur PT. Bank Jateng</option>
                        <option>Direktur PT.Trans Marga Jateng</option>
                        <option>Direktur PT> Asuransi Bangun Askrida</option>
                        <option>Direktur PT. Sarana Patra Jateng/ Direktur PT. Sarana Patra Hulu Cepu</option>
                        <option>Direktur PD. Air Bersih Jawa Tengah</option>
                        <option>Direktur PD. Citra Mandiri Jawa Tengah</option>
                        <option>Direktur PD. BPR/BKK Jawa Tengah</option>
                        <option>Direktur PT. PRPP Jawa Tengah</option>
                        <option>Direktur PT. Sarana Pembangunan Jawa Tengah</option>
                        <option>Direktur PT. Kawan Indutri Wijayakusuma</option>
                    </select>
                </div>
            </div>
            <div class="user-input-box1">
                <label for="informasiyangdibutuhkan">Informasi yang Dibutuhkan</label>
                <input type="text" id="informasiyangdibutuhkan" name="informasiyangdibutuhkan" required />
            </div>
            <div class="user-input-box1">
                <label for="alasanpengguna">Alasan Pengguna Informasi</label>
                <input type="text" id="alasanpengguna" name="alasanpengguna" required />
            </div>
            <div class="grid" style="--bs-columns: 18; --bs-gap: .5rem;">
                <div style="grid-column: span 10;">

                    <div class="user-input-box1">
                        <label for="caramendapatkaninformasi">Cara Mendapatkan Informasi</label>
                        <select id="caramendapatkaninformasi" name="caramendapatkaninformasi" required>
                            <option>Melihat/Membaca/Mendengarkan/Mencatat</option>
                            <option>Mendapatkan Salinan Informasi Hardcopy</option>
                            <option>Mendapatkan Salinan Informasi Softcopy</option>
                        </select>
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
                        <label for="caramendapatkansalinan">Cara Mendapatkan Salinan</label>
                        <select id="caramendapatkansalinan" name="caramendapatkansalinan" required>
                            <option>Mengambil Langsung</option>
                            <option>Email</option>
                            <option>Kurir / Pos</option>
                            <option>Faximile</option>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>