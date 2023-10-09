<?php
session_start();

// Pastikan pengguna telah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Jika pengguna telah login, Anda dapat menggunakan $_SESSION['user_id'] untuk mengidentifikasi pengguna
$user_id = $_SESSION['id'];

// Lanjutkan dengan menampilkan formulir permohonan di sini
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
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- Jarallax CSS -->
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="/fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css" />
    <title>-</title>
</head>

<body onload="generate()">
    <!-- navbar -->
    <header>
        <div class="container-fluid">
            <div class="navb-logo">
                <img src="img/logo_jateng.png" alt="Logo" />
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
        <h1 class="form-title">Registration</h1>
        <form action="#" method="post">
            <h3>Personal Information</h3>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="opd">OPD yang di tuju</label>
                    <select id="opd" name="opd">
                        <option>Perorangan</option>
                        <option>Kelompok Orang</option>
                        <option>Badan Hukum</option>
                    </select>
                </div>
            </div>
            <div class="user-input-box1">
                <label for="neededInfo">Informasi yang Dibutuhkan</label>
                <input type="text" id="neededInfo" name="neededInfo" />
            </div>
            <div class="user-input-box1">
                <label for="neededInfo">Alasan Pengguna Informasi</label>
                <input type="text" id="neededInfo" name="neededInfo" />
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="occupation">Cara Mendapatkan Informasi</label>
                    <select id="occupation" name="occupation">
                        <option>ASN/PNS/POLRI</option>
                        <option>Mahasiswa/Pelajar</option>
                        <option>Wiraswasta</option>
                        <option>Karyawan BUMN/BUMD</option>
                        <option>Karyawan Swasta</option>
                        <option>Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="city">Cara Mendapatkan Salinan</label>
                    <select id="city" name="city">
                        <option>Semarang</option>
                        <option>Kelompok Orang</option>
                        <option>Badan Hukum</option>
                    </select>
                </div>
                <div class="container1">
                    <div class="wrapper">
                        <canvas id="canvas" width="200" height="70"></canvas>
                        <button id="reload-button">
                            <i class="fa-solid fa-arrow-rotate-right"></i>
                        </button>
                    </div>
                    <div class="user-input-box">
                        <input type="text" id="user-input" placeholder="Enter the text in the image" />
                    </div>
                    <button id="kirim-button">Kirim</button>
                    <button id="cancel-button">Batal</button>
                </div>
            </div>
        </form>
    </div>

    <footer class="footer">
        <div class="left-section">
            <img src="img/logo_jateng.png" alt="Logo" />
            <h4 style="font-size: 15px; margin-left: 70px; margin-top: -40px">
                LAYANAN PERMOHONAN INFORMASI
            </h4>
            <h5 style="font-size: 15px; margin-left: 70px">PROVINSI JAWA TENGAH</h5>
            <p style="margin-left: 70px; margin-top: 30px">Alamat</p>
            <p style="margin-left: 70px">Alamat Surel: example@example.com</p>
        </div>
        <div class="right-section">
            <div class="social-media">
                <p>Ikuti Kami</p>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>
    </footer>
    <footer class="footer1">
        <div class="content">
            <p>FAQ | Hubungi Kami</p>
        </div>
    </footer>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>