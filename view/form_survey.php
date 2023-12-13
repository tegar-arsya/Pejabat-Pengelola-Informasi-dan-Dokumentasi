<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['id'];
$nomer_registrasi = isset($_GET['registrasi']) ? $_GET['registrasi'] : '';
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
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/img/logo_jateng.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="../Assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../Assets/css/style.css" />
    <title>Survey Kepuasan</title>
</head>

<body onload="generate()">
    <!-- navbar -->
    <?php include '../components/navbar.php';?>
    <div class="custom-line"></div>
    <div class="container">
        <h1 class="form-title">Kuesioner Indeks Kepuasan Masyarakat</h1>
        <div class="container-riwayat">
        <div class="left-container-survey">
        <div class="box-left">
        <img src="../Assets/img/logo_jateng.png" alt=""style="width: 70%; margin-top: 60px;">
        </div>
        </div>
        <div class="right-container-survey">
        <h3 class="h3-title-survey">Bapak/Ibu yang Terhormat,</h3>
        <p class="p-survey">Kami mohon Anda berkenan mengisi kuesioner berikut ini sebagai upaya kami terus-menerus
            memperbaiki dan memberikan pelayanan yang terbaik kepada masyarakat. Partisipasi Anda akan sangat berguna
            untuk menyusun indeks kepuasan masyarakat atas layanan Pemerintah Provinsi Jawa Tengah. Atas perhatian dan
            partisipasinya, disampaikan. Terima kasih.</p>
            </div>
            </div>
        <form id="mySurvey" action="../controller/data_survey.php" method="post">
        <input type="hidden" name="nomer_registrasi" value="<?php echo htmlspecialchars($nomer_registrasi); ?>" />
            <div class="user-input-box">
                <label for="email">Email Anda</label>
                <input type="text" id="email" name="email" required />
            </div>
            <div class="user-input-box">
                <label for="nama">Nama Anda</label>
                <input type="text" id="nama" name="nama" required />
            </div>
            <div class="user-input-box">
                <label for="alamat">Alamat Anda</label>
                <input type="text" id="alamat" name="alamat" required />
            </div>
            <div class="user-input-box">
                <label for="notel">No Telepon Anda</label>
                <input type="text" id="notel" name="notel" required />
            </div>

            <h6 style="font-weight: bold;">Jenis Layanan Yang Diminta</h6>
            <div class="form-check">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="PENGADUAN MASYARAKAT"
                        id="pengaduanmasyarakat" name="jenis_layanan[]">
                    <label class="form-check-label" for="pengaduanmasyarakat">PENGADUAN MASYARAKAT</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="PENYIARAN"
                        id="penyiaran" name="jenis_layanan[]">
                    <label class="form-check-label" for="penyiaran">PENYIARAN</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="PENGADAAN BARANG DAN JASA"
                        id="pengadaanbarangdanjasa" name="jenis_layanan[]">
                    <label class="form-check-label" for="pengadaanbarangdanjasa">PENGADAAN BARANG DAN JASA</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="KONSULTASI Atau BIMBINGAN"
                        id="konsultasi" name="jenis_layanan[]">
                    <label class="form-check-label" for="konsultasi">KONSULTASI Atau BIMBINGAN</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="DATA Atau INFORMASI"
                        id="dataatauinformasi" name="jenis_layanan[]">
                    <label class="form-check-label" for="dataatauinformasi">DATA Atau INFORMASI</label>
                </div>
            </div>
            <div class="grid" style="--bs-columns: 18; --bs-gap: .5rem;">
            <div style="grid-column: span 10;">
            <h6 style="font-weight: bold;">Pelayanan Publik Yang Kami Berikan</h6>
            <div class="form-check">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="TIDAK PUAS"id="tidakpuas" name="feedback[]">
                    <label class="form-check-label" for="tidakpuas">TIDAK PUAS</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="KURANG PUAS" id="kurangpuas" name="feedback[]">
                    <label class="form-check-label" for="kurangpuas">KURANG PUAS</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="PUAS" id="puas" name="feedback[]">
                    <label class="form-check-label" for="puas">PUAS</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="SANGAT PUAS" id="sangatpuas" name="feedback[]">
                    <label class="form-check-label" for="sangatpuas">SANGAT PUAS</label>
                </div>
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
                        <label for="saran">Saran Atau Keluhan Anda</label>
                        <textarea id="saran" name="saran" required>
                        </textarea>
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
    <?php include '../components/footer.php';?>
    <script src="../model/survey.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>