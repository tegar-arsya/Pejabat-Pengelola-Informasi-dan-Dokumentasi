<?php
include('./Model/CSRF/csrf.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/png" sizes="16x16" href="./Assets/img/logo_jateng.png">
    <script src="https://kit.fontawesome.com/e601bb8c4c.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
    <title>LAYANAN PERMOHONAN INFORMASI PROVINSI JAWA TENGAH</title>
</head>

<body id="page-top">
    <header>
        <div class="container-fluid">
            <div class="navb-logo">
                <a href="./view/Admin/Form/admin"><img src="Assets/img/logo_jateng.png" alt="Logo"></a>
            </div>
            <div class="info">
                <h4>LAYANAN PERMOHONAN INFORMASI</h4>
                <H5>PROVINSI JAWA TENGAH</H5>
            </div>
            <div class="navb-items d-none d-xl-flex">
                <div class="item">
                    <a href="">Permohonan Informasi</a>
                </div>
                <div class="item">
                    <a href="">Pengajuan Keberatan</a>
                </div>
                <div class="item">
                    <a href="components/panduan.html">Paduan</a>
                </div>
                <div class="item">
                    <a href="">Login</a>
                </div>
            </div>
            <div class="mobile-toggler d-lg-none">
                <a href="#" data-bs-toggle="modal" data-bs-target="#navbModal">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </div>
            <div class="modal fade" id="navbModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <img src="Assets/img/logo_jateng.png" alt="Logo">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="fa-solid fa-xmark"></i></button>
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
                                <a href="components/panduan.html">Panduan</a>
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
    <section>
        <div class="py-5">
            <div class="container-index">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-12">
                        <div class="px-3 py-4 p-md-5 mx-md-4">
                            <h4 class="mb-4">Silahkan Login untuk mengajukan permintaan dan keberatan serta untuk
                                mengetahui
                                status permintaan informasi dan keberatan lebih yang sudah diajukan</h4>
                            <div class="horizontal-line"></div>
                            <div class="vertical-line"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card-body p-md-5 mx-md-4">
                            <form action="./controller/User/Auth/login.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                <p style="font-weight: bold;text-align: center;">Sign In</p>

                                <div class="form-outline mb-4">
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="E-mail" required />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Password" required />
                                </div>
                                <div class="text-">
                                    <a href="./view/User/GantiPassword/resetPassword">Lupa Password?</a>
                                </div>
                                <div class="text-center pt-1 mb-5 pb-1">
                                    <button class="btn btn-block btn-lg btn-mrh mb-3" type="submit">Login</button>
                                </div>
                                <div class="d-flex float-end">
                                    <p class="mb-0 me-2">Belum Terdaftar ?</p>
                                    <a class="text-" href="./view/User/Register/registrasi">Register</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
    <div class="left-section">
        <img src="Assets/img/logo_jateng.png" alt="Logo">
    </div>
    <div class="center-section">
        <h4 style="font-size: 15px;">LAYANAN PERMOHONAN INFORMASI</h4>
        <h4 style="font-size: 15px;">PROVINSI JAWA TENGAH</h5>
        <h5 style="font-size: 15px;">Alamat : Jl. Menteri Supeno I / 2, Kode POS 50243 Semarang, Jawa Tengah</p>
        <h5 style="font-size: 15px;">ppidutama.jateng@gmail.com</p>
    </div>
    <div class="right-section">
        <div class="social-media">
            <p>Ikuti Kami</p>
            <a href="https://www.instagram.com/ppid_jateng"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://twitter.com/ppid_jateng"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
    </div>
</footer>
<footer class="footer1">
    <div class="content">
        <p>FAQ | Hubungi Kami</p>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>