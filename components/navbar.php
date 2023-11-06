<header>
        <div class="container-fluid">
            <div class="navb-logo">
                <img src="../Assets/img/logo_jateng.png" alt="Logo" />
            </div>
            <div class="info">
                <h4>LAYANAN PERMOHONAN INFORMASI</h4>
                <h5>PROVINSI JAWA TENGAH</h5>
            </div>
            <div class="navb-items d-none d-xl-flex">
                <div class="item">
                    <a href="../view/formulir">Permohonan Informasi</a>
                </div>

                <div class="item">
                    <a href="../view/aduan">Pengajuan Keberatan</a>
                </div>

                <div class="item">
                    <a href="../components/panduan.html">Paduan</a>
                </div>

                <div class="item">
                    <a href="../controller/logout.php">Logout</a>
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
                            <img src="../Assets/img/logo_jateng.png" alt="Logo" />
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="modal-line">
                                <i class="fa-solid fa-circle-info"></i><a href="../view/formulir">Permohonan Informasi</a>
                            </div>

                            <div class="modal-line">
                                <i class="fa-solid fa-file-invoice"></i><a href="../view/aduan">Pengajuan Keberatan</a>
                            </div>

                            <div class="modal-line">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <a href="../components/panduan.html">Panduan</a>
                            </div>

                            <div class="modal-line">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i><a href="../controller/logout.php">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>