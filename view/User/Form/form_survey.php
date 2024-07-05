<?php
session_start();
require_once ('../../../controller/koneksi/config.php');

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../../../");
    exit();
}

$user_id = $_SESSION['id'];
$id_permohonan = isset($_GET['Permohonan']) ? $_GET['Permohonan'] : '';


$nomer_registrasi = '';
// Prepare and execute the query using the existing database connection
$sql = "SELECT nomer_registrasi FROM verifikasi_permohonan WHERE id_permohonan = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $id_permohonan);
    $stmt->execute();
    $stmt->bind_result( $nomer_registrasi);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}
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
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/img/logo_jateng.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../Assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../../../Assets/css/style.css" />
    <title>Survey Kepuasan</title>
</head>

<body onload="generate()">
    <!-- navbar -->
    <?php include '../../../components/navbar.php'; ?>
    <div class="custom-line"></div>
    <div class="container">
        <h1 class="form-title">Kuesioner Indeks Kepuasan Masyarakat</h1>
        <div class="container-riwayat">
            <div class="left-container-survey">
                <div class="box-left">
                    <img src="../../../Assets/img/logo_jateng.png" alt="" style="width: 70%; margin-top: 60px;">
                </div>
            </div>
            <div class="right-container-survey">
                <h3 class="h3-title-survey">Bapak/Ibu yang Terhormat,</h3>
                <p class="p-survey">Kami mohon Anda berkenan mengisi kuesioner berikut ini sebagai upaya kami
                    terus-menerus
                    memperbaiki dan memberikan pelayanan yang terbaik kepada masyarakat. Partisipasi Anda akan sangat
                    berguna
                    untuk menyusun indeks kepuasan masyarakat atas layanan Pemerintah Provinsi Jawa Tengah. Atas
                    perhatian dan
                    partisipasinya, disampaikan. Terima kasih.</p>
            </div>
        </div>
        <form id="mySurvey" action="../../../controller/SurveyController/data_survey.php" method="post">
            <input type="hidden" name="nomer_registrasi" value="<?php echo htmlspecialchars($nomer_registrasi); ?>" />
            <input type="hidden" name="id_permohonan" value="<?php echo htmlspecialchars($id_permohonan); ?>" />
            <div class="user-input-box">
                <label for="nama">Nama Anda</label>
                <input type="text" id="nama" name="nama" required />
            </div>
            <div class="user-input-box">
                <label for="usia">Usia</label>
                <input type="text" id="usia" name="usia" required />
            </div>
            <h6 style="font-weight: bold;">Pendidikan Terakhir</h6>
            <div class="form-check">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="SD" id="sd" name="pendidikan[]">
                    <label class="form-check-label" for="sd">SD</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="SMP" id="smp" name="pendidikan[]">
                    <label class="form-check-label" for="smp">SMP</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="SLTA" id="slta" name="pendidikan[]">
                    <label class="form-check-label" for="slta">SLTA</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="D1 - D2 - D3" id="d1" name="pendidikan[]">
                    <label class="form-check-label" for="d1">D1 - D2 - D3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="S1" id="s1" name="pendidikan[]">
                    <label class="form-check-label" for="s1">S1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="S2 Keatas" id="s2" name="pendidikan[]">
                    <label class="form-check-label" for="s1">S2 Keatas</label>
                </div>
            </div>
            <h6 style="font-weight: bold;">Pekerjaan</h6>
            <div class="form-check">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="PNS / TNI / POLRI" id="pnstnipolri"
                        name="pekerjaan[]">
                    <label class="form-check-label" for="pnstnipolri">PNS / TNI / POLRI</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Pegawai Swasta" id="pegawaiswasta"
                        name="pekerjaan[]">
                    <label class="form-check-label" for="pegawaiswasta">Pegawai Swasta</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Wiraswasta / Usahawan" id="WiraswastaUsahawan"
                        name="pekerjaan[]">
                    <label class="form-check-label" for="WiraswastaUsahawan">Wiraswasta / Usahawan</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Pelajar / Mahasiswa" id="PelajarMahasiswa"
                        name="pekerjaan[]">
                    <label class="form-check-label" for="PelajarMahasiswa">Pelajar / Mahasiswa</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Lainnya" id="Lainnya" name="pekerjaan[]">
                    <label class="form-check-label" for="Lainnya">Lainnya</label>
                </div>
            </div>
            <h6 style="font-weight: bold;">Jenis Layanan Publik yang pernah diakses</h6>
            <div class="form-check">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Layanan Informasi melalui PPID Provinsi"
                        id="LayananInformasimelaluiPPIDProvinsi" name="jenis_layanan[]">
                    <label class="form-check-label" for="LayananInformasimelaluiPPIDProvinsi">Layanan Informasi melalui
                        PPID Provinsi</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Layanan Informasi melalui PPID Pelaksana"
                        id="LayananInformasimelaluiPPIDPelaksana" name="jenis_layanan[]">
                    <label class="form-check-label" for="LayananInformasimelaluiPPIDPelaksana">Layanan Informasi melalui
                        PPID Pelaksana</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Aduan LaporGub" id="AduanLaporGub"
                        name="jenis_layanan[]">
                    <label class="form-check-label" for="AduanLaporGub">Aduan LaporGub</label>
                </div>
            </div>

            <div class="main-user-info">
                <div class="user-input-box1">
                    <h1> Survey Kepuasan Masyarakat</h1>
                </div>
            </div>
            <h6 style="font-weight: bold;">1. Persyaratan</h6>
            <h6>Persyaratan untuk memperoleh layanan publik di Pemerintah Provinsi Jawa Tengah mudah untuk dipenuhi.
            </h6>
            <div class="form-check">
                <h6>Sangat Sulit</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="persyaratan[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="persyaratan[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="persyaratan[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="persyaratan[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat Mudah</h6>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="SaranPersyaratanPermohonanInformasi">Saran Persyaratan Permohonan Informasi</label>
                    <textarea id="SaranPersyaratanPermohonanInformasi"
                        name="SaranPersyaratanPermohonanInformasi"></textarea>
                </div>
            </div>
            <h6 style="font-weight: bold;">2. Prosedur</h6>
            <h6>Prosedur/alur pelayanan publik di Pemerintah Provinsi Jawa Tengah dapat dipahami dengan jelas dan mudah
                dijalankan.</h6>
            <div class="form-check">
                <h6>Sangat Tidak Setuju</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="prosedur[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="prosedur[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="prosedur[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="prosedur[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat setuju</h6>
            </div>
            <h6 style="font-weight: bold;">3. Waktu</h6>
            <h6>Pelayanan publik yang Anda terima dilaksanakan cepat dan tepat waktu sesuai dengan standar waktu
                pelayanan pelayanan publik di Pemerintah Provinsi Jawa Tengah.</h6>
            <div class="form-check">
                <h6>Sangat Sulit</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="waktu[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="waktu[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="waktu[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="waktu[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat Mudah</h6>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="SaranWaktuPermohonanInformasi">Saran Waktu Permohonan Informasi</label>
                    <textarea id="SaranWaktuPermohonanInformasi" name="SaranWaktuPermohonanInformasi"></textarea>
                </div>
            </div>
            <h6 style="font-weight: bold;">4. Biaya</h6>
            <h6>Petugas tidak menerima imbalan uang dalam rangka pelayanan publik di Pemerintah Provinsi Jawa Tengah.
            </h6>
            <div class="form-check">
                <h6>Sangat Tidak Setuju</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="biaya[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="biaya[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="biaya[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="biaya[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat Setuju</h6>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="SaranBiayaPermohonanInformasi">Saran Biaya Permohonan Informasi</label>
                    <textarea id="SaranBiayaPermohonanInformasi" name="SaranBiayaPermohonanInformasi"></textarea>
                </div>
            </div>
            <h6 style="font-weight: bold;">5. Produk / Hasi</h6>
            <h6>Produk/hasil layanan publik Pemerintah Provinsi Jawa Tengah memiliki kualitas yang baik dan sesuai
                harapan Saudara.</h6>
            <div class="form-check">
                <h6>Sangat Tidak Setuju</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="hasil[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="hasil[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="hasil[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="hasil[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat Setuju</h6>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="SaranProdukPermohonanInformasi">Saran Produk/ Hasil Permohonan Informasi</label>
                    <textarea id="SaranProdukPermohonanInformasi" name="SaranProdukPermohonanInformasi"></textarea>
                </div>
            </div>
            <h6 style="font-weight: bold;">6. Kompetensi Pelaksana</h6>
            <h6>Petugas pelaksana layanan melaksanakan tugasnya dengan cakap, terampil, dan berintegritas.</h6>
            <div class="form-check">
                <h6>Sangat Rendah</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="kompetensi[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="kompetensi[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="kompetensi[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="kompetensi[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat Tinggi</h6>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="SaranKompetensiPelaksanaPermohonanInformasi">Saran Kompetensi Pelaksana Permohonan
                        Informasi</label>
                    <textarea id="SaranKompetensiPelaksanaPermohonanInformasi"
                        name="SaranKompetensiPelaksanaPermohonanInformasi"></textarea>
                </div>
            </div>
            <h6 style="font-weight: bold;">7. Perilaku Pelaksana</h6>
            <h6> Petugas pelaksana memberikan pelayanan dengan ramah dan sopan.</h6>
            <div class="form-check">
                <h6>Sangat Tidak Setuju</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="perilaku[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="perilaku[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="perilaku[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="perilaku[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat Setuju</h6>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="SaranPerilakuPelaksanaPermohonanInformasi">Saran Perilaku Pelaksana Permohonan
                        Informasi</label>
                    <textarea id="SaranPerilakuPelaksanaPermohonanInformasi"
                        name="SaranPerilakuPelaksanaPermohonanInformasi"></textarea>
                </div>
            </div>
            <h6 style="font-weight: bold;">8. Sarana dan Prasarana</h6>
            <h6>Sarana dan prasarana tersedia lengkap dan sesuai dengan jenis pelayanan publik yang diberikan.</h6>
            <div class="form-check">
                <h6>Sangat Tidak Setuju</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="sarana[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="sarana[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="sarana[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="sarana[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat Setuju</h6>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="SaranSaranadanPrasaranaPermohonanInformasi">Saran Sarana dan Prasarana Permohonan
                        Informasi</label>
                    <textarea id="SaranSaranadanPrasaranaPermohonanInformasi"
                        name="SaranSaranadanPrasaranaPermohonanInformasi"></textarea>
                </div>
            </div>
            <h6 style="font-weight: bold;">9. Pelayanan Pengaduan / Kelihan / Saran</h6>
            <h6>Sarana dan prasarana tersedia lengkap dan sesuai dengan jenis pelayanan publik yang diberikan.</h6>
            <div class="form-check">
                <h6>Sangat Tidak Jelas dan Sangat Sulit</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="pelayanan_pengaduan[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="pelayanan_pengaduan[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="pelayanan_pengaduan[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="pelayanan_pengaduan[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat Jelas dan Sangat Mudah</h6>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="SaranPelayananPengaduanPermohonanInformasi">Saran Pelayanan Pengaduan / Kelihan / Saran
                        Permohonan Informasi</label>
                    <textarea id="SaranPelayananPengaduanPermohonanInformasi"
                        name="SaranPelayananPengaduanPermohonanInformasi"></textarea>
                </div>
            </div>
            <h6 style="font-weight: bold;">10. Petugas</h6>
            <h6>Petugas melayani pengaduan/keluhan/saran Saudara tentang pelayanan publik di Pemerintah Provinsi Jawa
                Tengah dengan tanggap dan ramah.</h6>
            <div class="form-check">
                <h6>Sangat Tidak Tanggap dan Tidak Tamah</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="satu" name="petugas[]">
                    <label class="form-check-label" for="satu">1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="2" id="dua" name="petugas[]">
                    <label class="form-check-label" for="dua">2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3" id="tiga" name="petugas[]">
                    <label class="form-check-label" for="tiga">3</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="4" id="empat" name="petugas[]">
                    <label class="form-check-label" for="empat">4</label>
                </div>
                <h6>Sangat Tanggap dan Ramah</h6>
            </div>
            <div class="main-user-info">
                <div class="user-input-box1">
                    <label for="SaranPetugasPermohonanInformasi">Saran Petugas Permohonan Informasi</label>
                    <textarea id="SaranPetugasPermohonanInformasi" name="SaranPetugasPermohonanInformasi"></textarea>
                </div>
            </div>
            <div class="user-input-box1">
                <div id="captcha-container">
                    <div id="captcha"></div>
                    <button type="button" id="reload-button">Reload<br>CAPTCHA</button>
                </div>
            </div>
            <div class="user-input-box1">
                <input type="text1" id="user-input" name="user-input" placeholder="Enter the text in the CAPTCHA" />
                <div><button type="submit" id="kirim-button">Kirim</button>
                </div>
            </div>
            <!-- <div class="grid" style="--bs-columns: 18; --bs-gap: .5rem;">
                <div style="grid-column: span 10;">
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

                    </div>
                </div>
                <div class="g-col-8">
                    <input type="text1" id="user-input" name="user-input" placeholder="Enter the text in the CAPTCHA" />
                    <div><button type="submit" id="kirim-button">Kirim</button>
                    </div>
                </div>
            </div> -->
        </form>
    </div>
    <?php include '../../../components/footer.php'; ?>
    <script>
        function generateCaptcha() {
            // Mengambil nilai CAPTCHA dari server
            fetch('../../../Model/Captcha/generate_captcha.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('captcha').textContent = data;
                });
        }

        document.getElementById('reload-button').addEventListener('click', generateCaptcha);

        document.getElementById('mySurvey').addEventListener('submit', function (event) {
            event.preventDefault();

            var userInput = document.getElementById('user-input').value;
            var captchaValue = document.getElementById('captcha').textContent.trim();

            if (userInput === captchaValue) {
                fetch('../../../controller/SurveyController/data_survey.php', {
                    method: 'POST',
                    body: new URLSearchParams(new FormData(document.getElementById('mySurvey')))
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil Terkirim',
                                html: 'Terima kasih telah mengisi Kuesioner Indeks Kepuasan Masyarakat. Mohon masuk ke halaman riwayat permohonan untuk mengunduh jawaban permohonan informasi atau klik link berikut ini <a href="../../../view/User/Daftar/daftarRiwayat" style="color: red; text-decoration: underline;">riwayat permohonan</a>',
                                icon: 'success',
                            });

                            document.getElementById('user-input').value = '';
                            generateCaptcha();
                        } else {
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
        window.addEventListener('load', generateCaptcha);

    </script>
    <script src="../../../Model/Auth/TimeOutUser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>