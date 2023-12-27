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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e601bb8c4c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    <!-- Jarallax CSS -->
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/img/logo_jateng.png">
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheaet" href="../Assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../Assets/css/style.css">
    <title>Pengajuan Keberatan</title>
</head>

<body id="page-top">

    <!-- navbar -->
    <?php include '../components/navbar.php'; ?>
    <div class="custom-line"></div>
    <div class="container">
        <h1 class="form-title">Pengajuan Keberatan Informasi</h1>
        <form action="../controller/User/cari_code.php" method="POST" enctype="multipart/form-data">
            <h3>Pengajuan Keberatan</h3>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="nik">Masukkan Nomor Registrasi *</label>
                    <input type="text" id="nomer_registrasi" name="nomer_registrasi" required />
                </div>

            </div>
            <div class="form-submit-btn" style="text-align: end;">
                <input type="submit" value="Cari">
            </div>
        </form>
    </div>
    <?php include '../components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    ">
</script>
<script src="../Model/Auth/TimeOutUser.js"></script>
</body>

</html>