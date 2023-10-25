<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e601bb8c4c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="/fontawesome/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
    <title>-</title>
</head>

<body id="page-top">
    <header>
        <div class="container-fluid">
            <div class="navb-logo">
                <img src="img/logo_jateng.png" alt="Logo">
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
                    <a href="">Paduan</a>
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
                            <img src="img/logo_jateng.png" alt="Logo">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-line">
                                <i class="fa-solid fa-circle-info"></i><a href="">Permohonan Informasi</a>
                            </div>
                            <div class="modal-line">
                                <i class="fa-solid fa-file-invoice"></i><a href="">Pengajuan Keberatan</a>
                            </div>
                            <div class="modal-line">
                                <i class="fa-solid fa-chalkboard-user"></i> <a href="">Panduan</a>
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
    <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/bg.png" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="img/bg.png" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="img/bg.png" class="d-block w-100" alt="Slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <img src="img/book.png" class="card-img-top" alt="Image 1">
                <div class="card-body">
                    <h5 class="card-title">Permohonan Informasi</h5>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <img src="img/book.png" class="card-img-top" alt="Image 1">
                <div class="card-body">
                    <h5 class="card-title">Pengajuan Keberatan</h5>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <img src="img/book.png" class="card-img-top" alt="Image 1">
                <div class="card-body">
                    <h5 class="card-title">Panduan</h5>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h1>Data Permohonan Informasi</h1>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
        </div>
    </div>
    <?php include 'component/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var myCarousel = new bootstrap.Carousel(document.getElementById('imageCarousel'), {
            interval: 2000,
            keyboard: true,
            pause: 'hover'
        });
    </script>
</body>

</html>