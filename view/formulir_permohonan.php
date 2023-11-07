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
    <link rel="stylesheet" href="../Assets/css/style.css" />
    <title>Form Permohonan</title>
</head>

<body onload="generate()">
    <!-- navbar -->
    <?php include '../components/navbar.php'; ?>
    <div class="custom-line"></div>
    <div class="container">
        <h1 class="form-title">Formulir Permohonan Informasi Publik</h1>
        <form id="myForm" action="../controller/simpandataformulirpermohonaninformasipublik.php" method="post">
            <h3>Personal Information</h3>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="opd">OPD yang di tuju</label>
                    <select id="opd" name="opd" required>
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
    <script src="../Model/script.js"></script>
    <script src="../Model/opd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>