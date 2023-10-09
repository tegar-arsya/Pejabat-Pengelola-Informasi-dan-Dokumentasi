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
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheaet" href="/fontawesome/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
    <title>-</title>
</head>

<body id="page-top">

    <!-- navbar -->
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
                            <img src="/img/logo_jateng.png" alt="Logo">
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
    <div class="container">
        <h1 class="form-title">Registration</h1>
        <form action="simpan.php" method="POST" enctype="multipart/form-data">
            <h3>Personal Infromation</h3>
            <div class="main-user-info">
                <div class="user-input-box">
                    <label for="namadepan">Nama Depan</label>
                    <input type="text" id="namadepan" name="namadepan" required />
                </div>
                <div class="user-input-box">
                    <label for="namabelakang">Nama Belakang</label>
                    <input type="text" id="namabelakang" name="namabelakang" required />
                </div>
                <div class="user-input-box">
                    <label for="jns_nik">Jenis NIK</label>
                    <select type="text" id="jns_nik" name="jns_nik" required>
                        <option>Perorangan</option>
                        <option>Kelompok Orang</option>
                        <option>Badan Hukum</option>
                    </select>
                </div>
                <div class="user-input-box">
                    <label for="jns_pemohon">Jenis Pemohon</label>
                    <select type="text" id="jns_pemohon" name="jns_pemohon" required>
                        <option>KTP</option>
                        <option>KTP Penerima Kuasa</option>
                        <option>KTP Pemberi Kuasa</option>
                        <option>Surat Kuasa</option>
                    </select>
                </div>
                <div class="user-input-box">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" required />
                </div>
                <div class="user-input-box">
                    <label for="fotoktp">foto ktp</label>
                    <input type="file" id="fotoktp" name="fotoktp" accept="upload/*"
                        placeholder="Drag file Or klik tO upload" required />
                </div>
                <div class="user-input-box">
                    <label for="npwp">NPWP</label>
                    <input type="text" id="npwp" name="npwp" required />
                </div>
                <div class="user-input-box">
                    <label for="pekerjaan">PEKERJAAN</label>
                    <select type="text" id="pekerjaan" name="pekerjaan" required>
                        <option>ASN/PNS/POLRI</option>
                        <option>Mahasiswa/Pelajar</option>
                        <option>Wiraswasta</option>
                        <option>Karyawan BUMN/BUMD</option>
                        <option>Karyawan Swasta</option>
                        <option>Lainnya</option>
                    </select>
                </div>
                <div class="user-input-box">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required />
                </div>
                <div class="user-input-box">
                    <label for="kota_kabupaten">Kota/Kabupaten</label>
                    <select type="text" id="kota_kabupaten" name="kota_kabupaten" required>
                        <option>semarang</option>
                        <option>Kelompok Orang</option>
                        <option>Badan Hukum</option>
                    </select>
                </div>
                <div class="user-input-box">
                    <label for="provinsi">PROVINSI</label>
                    <select id="provinsi" name="provinsi" required>
                        <option value="Aceh">Nanggroe Aceh Darussalam</option>
                        <option value="Sumatera Utara">Sumatera Utara</option>
                        <option value="Sumatera Barat">Sumatera Barat</option>
                        <option value="Riau">Riau</option>
                        <option value="Kepulauan Riau">Kepulauan Riau</option>
                        <option value="Jambi">Jambi</option>
                        <option value="Sumatera Selatan">Sumatera Selatan</option>
                        <option value="Bengkulu">Bengkulu</option>
                        <option value="Lampung">Lampung</option>
                        <option value="Bangka Belitung">Bangka Belitung</option>
                        <option value="Banten">Banten</option>
                        <option value="DKI Jakarta">DKI Jakarta</option>
                        <option value="Jawa Barat">Jawa Barat</option>
                        <option value="Jawa Tengah">Jawa Tengah</option>
                        <option value="DI Yogyakarta">Daerah Istimewa Yogyakarta</option>
                        <option value="Jawa Timur">Jawa Timur</option>
                        <option value="Bali">Bali</option>
                        <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                        <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                        <option value="Kalimantan Barat">Kalimantan Barat</option>
                        <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                        <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                        <option value="Kalimantan Timur">Kalimantan Timur</option>
                        <option value="Kalimantan Utara">Kalimantan Utara</option>
                        <option value="Gorontalo">Gorontalo</option>
                        <option value="Sulawesi Barat">Sulawesi Barat</option>
                        <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                        <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                        <option value="Sulawesi Utara">Sulawesi Utara</option>
                        <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                        <option value="Maluku">Maluku</option>
                        <option value="Maluku Utara">Maluku Utara</option>
                        <option value="Papua Barat">Papua Barat</option>
                        <option value="Papua">Papua</option>
                        <option value="Papua Tengah">Papua Tengah</option>
                        <option value="Papua Pegunungan">Papua Pegunungan</option>
                        <option value="Papua Selatan">Papua Selatan</option>
                        <option value="Papua Barat Daya">Papua Barat Daya</option>
                    </select>
                </div>
                <div class="user-input-box">
                    <label for="kode_pos">KODE POS</label>
                    <input type="text" id="kode_pos" name="kode_pos" required />
                </div>
                <div class="user-input-box">
                    <label for="email">EMAIL</label>
                    <input type="text" id="email" name="email" required />
                </div>
                <div class="user-input-box">
                    <label for="password">PASSWORD</label>
                    <input type="password" id="password" name="password" required />
                </div>
            </div>

            <div class="form-submit-btn">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
    <footer class="footer">

        <div class="left-section">
            <img src="img/logo_jateng.png" alt="Logo">
            <h4 style="font-size: 15px; margin-left: 70px; margin-top: -40px;">LAYANAN PERMOHONAN INFORMASI</h4>
            <h5 style="font-size: 15px; margin-left: 70px;">PROVINSI JAWA TENGAH</h5>
            <p style="margin-left: 70px; margin-top: 30px;">Alamat</p>
            <p style="margin-left: 70px;">Alamat Surel: example@example.com</p>
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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>