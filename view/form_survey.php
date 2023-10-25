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
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <!-- Jarallax CSS -->
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo_jateng.png">
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
    <title>Survey Kepuasan</title>
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
                            <img src="/img/logo_jateng.png" alt="Logo" />
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
        <h1 class="form-title">Survey Kepuasan Masyarakat</h1>
        <h3 class="h3-title-survey">Bapak/Ibu yang Terhormat,</h3>
        <p class="p-survey">Kami mohon Anda berkenan mengisi kuesioner berikut ini sebagai upaya kami terus-menerus
            memperbaiki dan memberikan pelayanan yang terbaik kepada masyarakat. Partisipasi Anda akan sangat berguna
            untuk menyusun indeks kepuasan masyarakat atas layanan Pemerintah Provinsi Jawa Tengah. Atas perhatian dan
            partisipasinya, disampaikan. Terima kasih.</p>
        <form id="mySurvey" action="../controller/data_survey.php" method="post">

            <div class="user-input-box">
                <label for="usia">Usia</label>
                <input type="text" id="usia" name="usia" required />
            </div>

            <div class="user-input-box">
                <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                <select id="pendidikan_terakhir" name="pendidikanterakhir" required>
                    <option>SD</option>
                    <option>SMP</option>
                    <option>SMA/SMK</option>
                    <option>Diploma (D1 - D4)</option>
                    <option>S1</option>
                    <option>S2</option>
                    <option>S3</option>
                </select>
            </div>
            <div class="user-input-box">
                <label for="pekerjaan">Pekerjaan</label>
                <select id="pekerjaan" name="pekerjaan" required>
                    <option>ASN/PNS/POLRI</option>
                    <option>Mahasiswa/Pelajar</option>
                    <option>Wiraswasta</option>
                    <option>Karyawan BUMN/BUMD</option>
                    <option>Karyawan Swasta</option>
                    <option>Lainnya</option>
                </select>
            </div>
            <h6>Jenis Layanan Publik yang Pernah Diakses</h6>
            <div class="form-check">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="layananinformasippidutama"
                        id="layananinformasippidutama" name="jenis_layanan[]">
                    <label class="form-check-label" for="layananinformasippidutama">Layanan Informasi PPID Utama</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="layananinformasippidpelakasana"
                        id="layananinformasippidpelaksana" name="jenis_layanan[]">
                    <label class="form-check-label" for="layananinformasippidpelaksana">Layanan Informasi PPID
                        Pelaksana</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="layananinformasippidsatu"
                        id="layananinformasippidsatu" name="jenis_layanan[]">
                    <label class="form-check-label" for="layananinformasippidsatu">Layanan Informasi PPID satu</label>
                </div>
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
    <script src="../js/survey.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>