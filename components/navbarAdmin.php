<div class="nav-header">
    <div class="brand-logo">
        <a href="../view/dashboard">
            <b class="logo-abbr"><img src="../Assets/images/logo_jateng.png" alt=""> </b>
            <span class="logo-compact"><img src="../Assets/images/PERMOHONAN INFORMASI PROVINSI JAWA TENGAH.png"
                    alt=""></span>
            <span class="brand-title">
                <div style="width: 100%; text-align: center; color: white; font-weight: 600; word-wrap: break-word">
                    PERMOHONAN INFORMASI <br />PROVINSI JAWA TENGAH</div>
            </span>
        </a>
    </div>
</div>
<div class="header">
    <div class="user-info-container" style="color: white; margin-left: 100px; margin-top: 30px; ">
    </div>
    <div class="header-content clearfix">

        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>
        <div class="header-right">
            <ul class="clearfix">
            </ul>
        </div>
    </div>
</div>
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li id="logo-title-container">
                <div class="logo-container">
                    <img src="../Assets/images/logo_jateng.png" alt="Logo" class="logo">
                    <span class="logo-text">PERMOHONAN INFORMASI
                        PROVINSI JAWA TENGAH</span>
                </div>
                <div class="title-container">
                    <div class="title">Menu Permohonan Informasi</div>
                </div>
            </li>
            <li>
                <a href="../view/dashboard" aria-expanded="false">
                    <i class="icon-user menu-icon"></i><span class="nav-text">dashboard</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-envelope menu-icon"></i> <span class="nav-text">Permohonan Informasi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="../view/listPM">Daftar Permohonan Masuk</a></li>
                    <li><a href="../view/listPI">Daftar Permohonan Informasi</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-screen-tablet menu-icon"></i><span class="nav-text">Keberatan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="../view/listkeberatan">Daftar Keberatan Masuk</a></li>
                    <li><a href="../view/daftarK">Verifikasi Pengajuan Keberatan</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-graph menu-icon"></i> <span class="nav-text">Referensi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="../view/listopd">Daftar OPD</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-screen-tablet menu-icon"></i><span class="nav-text">Survey Kepuasan Masyarakat</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="../view/SKM">Survey Kepuasan Masyarakat Permohonan Informasi</a></li>
                    <li><a href="../view/SKMKeberatan">Survey Kepuasan Masyarakat Keberatan Informasi</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="../view/User" aria-expanded="false">
                    <i class="icon-user menu-icon"></i><span class="nav-text">User</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-screen-tablet menu-icon"></i><span class="nav-text">Aktivitas</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="../view/Service">Log</a></li>
                    <li><a href="../view/RiwayatJawaban">Riwayat Permohonan</a>
                    <li><a href="../view/RiwayatJawabanKeberatan">Riwayat Keberatan</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="../controller/Admin/logoutAdmin.php" aria-expanded="false">
                    <i class="icon-settings menu-icon"></i><span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Letakkan script ini di akhir tag body -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var hamburgerIcon = document.querySelector('.hamburger');
        var logoTitleContainer = document.getElementById('logo-title-container');

        // Periksa apakah local storage didukung
        if (typeof Storage !== "undefined") {
            // Periksa apakah status kontainer tersimpan di local storage
            var isContainerVisible = localStorage.getItem('logoTitleContainerVisible');

            // Atur status awal berdasarkan local storage
            if (isContainerVisible === 'true') {
                logoTitleContainer.style.display = 'block';
            } else {
                logoTitleContainer.style.display = 'none';
            }

            // Atur visibilitas kontainer saat ikon hamburger diklik
            hamburgerIcon.addEventListener('click', function () {
                if (logoTitleContainer.style.display === 'none') {
                    logoTitleContainer.style.display = 'block';
                    // Simpan status di local storage
                    localStorage.setItem('logoTitleContainerVisible', true);
                } else {
                    logoTitleContainer.style.display = 'none';
                    // Simpan status di local storage
                    localStorage.setItem('logoTitleContainerVisible', false);
                }
            });
        } else {
            console.error("Local storage tidak didukung di browser ini.");
        }
    });
</script>
