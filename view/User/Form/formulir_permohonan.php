<?php
session_start();
include ('../../../controller/koneksi/config.php');

if (!isset($_SESSION['id'])) {
    header("Location: ../../../");
    exit();
}

$user_id = $_SESSION['id'];

function getOPDData() {
    global $conn;

    $query = "SELECT id_opd, nama FROM tbl_daftar_opd";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $opdData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $opdData[] = array('id' => $row['id_opd'], 'nama' => $row['nama']);
    }

    return $opdData;
}

$opdOptions = getOPDData();
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Jarallax CSS -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/img/logo_jateng.png">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../Assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (popper.js and bootstrap.js are required for dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../../../Assets/css/style.css" />
    <title>Form Permohonan</title>
</head>

<body>
    <!-- navbar -->
    <?php include '../../../components/navbar.php'; ?>
    <div class="custom-line"></div>
    <div class="container">
        <h1 class="form-title">Formulir Permohonan Informasi Publik</h1>
        <form class="myForm" id="myForm" action="../controller/simpandataformulirpermohonaninformasipublik.php"
            method="post">
            <h3>Personal Information</h3>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="opd">OPD yang di tuju</label>
                    <select id="opd" name="opd" class="js-example-basic-single" required>
                        <option disabled>Pilih OPD</option>
                        <option value="kosong"></option>
                        <?php
                        foreach ($opdOptions as $opd) {
                            echo "<option value=\"{$opd['id']}\">{$opd['nama']}</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" id="opd_id" name="opd_id">
                </div>
            </div>

            <div class="user-input-box1">
                <label for="informasiyangdibutuhkan">Informasi yang Dibutuhkan</label>
                <textarea id="informasiyangdibutuhkan" name="informasiyangdibutuhkan" required></textarea>
            </div>
            <div class="user-input-box1">
                <label for="alasanpengguna">Alasan Pengguna Informasi</label>
                <textarea id="alasanpengguna" name="alasanpengguna" required></textarea>
            </div>
            <div class="user-input-box1">
                <label for="caramendapatkaninformasi">Cara Mendapatkan Informasi</label>
                <select id="caramendapatkaninformasi" name="caramendapatkaninformasi" required>
                    <option>Melihat/Membaca/Mendengarkan/Mencatat</option>
                    <option>Mendapatkan Salinan Informasi Hardcopy</option>
                    <option>Mendapatkan Salinan Informasi Softcopy</option>
                </select>
            </div>
            <div class="user-input-box1">
                <label for="caramendapatkansalinan">Cara Mendapatkan Salinan</label>
                <select id="caramendapatkansalinan" name="caramendapatkansalinan" required>
                    <option>Mengambil Langsung</option>
                    <option>Email</option>
                    <option>Kurir / Pos</option>
                    <option>Faximile</option>
                </select>
            </div>
            <div class="user-input-box1">
                <div id="captcha-container">
                    <div id="captcha"></div>
                    <button type="button" id="reload-button"> <i class="fas fa-sync-alt"></i></button>
                </div>
            </div>
            <div class="user-input-box1">
                <input type="text1" id="user-input" name="user-input" placeholder="Enter the text in the CAPTCHA" />
                <div><button type="submit" id="kirim-button">Kirim</button>
                </div>
            </div>
        </form>
    </div>
    <?php include '../../../components/footer.php'; ?>
    <script> 
     document.getElementById('opd').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('opd_id').value = selectedOption.value;
        });
    function generateCaptcha() {
            fetch('../../../Model/Captcha/generate_captcha.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('captcha').textContent = data;
                });
        }

        document.getElementById('reload-button').addEventListener('click', generateCaptcha);

        document.getElementById('myForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Mencegah tindakan bawaan formulir

            var userInput = document.getElementById('user-input').value;
            var captchaValue = document.getElementById('captcha').textContent.trim();

            if (userInput === captchaValue) {
                // CAPTCHA benar, kirim data ke server menggunakan fetch API
                fetch('../../../controller/FormController/simpandataformulirpermohonaninformasipublik.php', {
                    method: 'POST',
                    body: new URLSearchParams(new FormData(document.getElementById('myForm')))
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Jika penyimpanan data di server berhasil, tampilkan popup SweetAlert2
                            Swal.fire({
                                title: 'Berhasil Terkirim',
                                html: 'Permohonan informasi publik anda telah berhasil terkirim, untuk detail lebih lanjut mohon untuk dicek di bagian <a href="../../../view/User/Daftar/daftarRiwayat" style="color: red; text-decoration: underline;">riwayat permohonan</a>',
                                icon: 'success',
                            });

                            // Clear input CAPTCHA dan isi ulang CAPTCHA
                            document.getElementById('user-input').value = '';
                            generateCaptcha();
                        } else {
                            // Jika penyimpanan data di server gagal, tampilkan pesan kesalahan
                            Swal.fire(
                                'Error',
                                'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                                'error'
                            );
                            // Regenerate CAPTCHA
                            generateCaptcha();
                        }
                    });
            } else {
                // CAPTCHA salah, tampilkan pesan kesalahan
                Swal.fire(
                    'Error',
                    'CAPTCHA tidak sesuai. Silakan coba lagi.',
                    'error'
                );
                // Regenerate CAPTCHA
                generateCaptcha();
            }
        });


        // Generate CAPTCHA saat halaman dimuat
        window.addEventListener('load', generateCaptcha);</script>
    <script>
        // In your Javascript
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
    <script src="../../../Model/Auth/TimeOutUser.js"></script>
</body>

</html>