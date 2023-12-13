<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['id'];
include('../controller/koneksi/config.php');
if (!isset($_GET['registrasi'])) {
    header("Location: ../components/eror.html");
    exit();
}
$nomer_registrasi_keberatan = $_GET['registrasi'];
// $nik = $_SESSION['nik'];
$query = "SELECT * FROM verifikasi_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$result = $conn->query($query);


$timelineData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        $tanggal = $row['tanggal_verifikasi'];
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggal)), "status" => $status);
    }
}
$queryNotifikasi = "SELECT * FROM notifikasi_pengiriman_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$resultNotifikasi = $conn->query($queryNotifikasi);
if ($resultNotifikasi->num_rows > 0) {
    while ($rowNotifikasi = $resultNotifikasi->fetch_assoc()) {
        $statusNotifikasi = $rowNotifikasi['status'];
        $tanggalMasukNotifikasi = $rowNotifikasi['tanggal'];
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggalMasukNotifikasi)), "status" => $statusNotifikasi);
    }
}
$queryJawaban = "SELECT * FROM keberatananswer_admin WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$resultJawaban = $conn->query($queryJawaban);
if ($resultJawaban->num_rows > 0) {
    while ($rowJawaban = $resultJawaban->fetch_assoc()) {
        $statusJawaban = $rowJawaban['status_balasan'];
        $tanggalMasukJawaban = $rowJawaban['tanggal'];
        $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggalMasukJawaban)), "status" => $statusJawaban);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/e601bb8c4c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Add your additional CSS and JS links here -->
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/img/logo_jateng.png">
    <link rel="stylesheet" href="../Assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="../Assets/css/style.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <title>Riwayat Keberatan Permohonan Informasi</title>
</head>

<body>
    <!-- navbar -->
    <?php include '../components/navbar.php'; ?>
    <div class="custom-line"></div>
    <h1 class="form-title">Detail Pengajuan<br />Keberatan Informasi</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
            <div class="box-left">
                <div class="up">
                    <div class="fill">
                        <div class="style-font">
                            Identitas Pemohon
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <?php
                        
                        $query = "SELECT * FROM verifikasi_keberatan WHERE nomer_registrasi_keberatan= '$nomer_registrasi_keberatan'";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            // Data ditemukan, tampilkan atau proses data di sini
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><strong>Nama Pemohon</strong></td>";
                                echo "<td>{$row['nama_pemohon']}</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>Tanggal Permohonan</strong></td>";
                                echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>Nomor Register Keberatan</strong></td>";
                                echo "<td>{$row['nomer_registrasi_keberatan']}</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><strong>Nomor Register Permohonan</strong></td>";
                                echo "<td>{$row['nomer_registrasi_permohonan']}</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><strong>Alasan Keberatan</strong></td>";
                                echo "<td>{$row['alasan_keberatan']}</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>Informasi yang diminta</strong></td>";
                                echo "<td>{$row['informasi_yang_diminta']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            $query_alternatif = "SELECT * FROM pengajuan_keberatan where nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
                            $result_alternatif = $conn->query($query_alternatif);
                            while ($row_alternatif = $result_alternatif->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><strong>Nama</strong></td>";
                                echo "<td>{$row_alternatif['nama_pemohon']}</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><strong>Tanggal Permohonan</strong></td>";
                                echo "<td>" . (!empty($row_alternatif['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row_alternatif['tanggal_permohonan']))) : '') . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><strong>Nomor Register</strong></td>";
                                echo "<td>{$row_alternatif['nomer_registrasi_keberatan']}</td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td><strong>Alasan Keberatan</strong></td>";
                                echo "<td>{$row_alternatif['alasan_keberatan']}</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>Informasi Yang Diminta</strong></td>";
                                echo "<td>{$row_alternatif['informasi_yang_diminta']}</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>OPD Yang Dituju</strong></td>";
                                echo "<td>{$row_alternatif['opd_yang_dituju']}</td>";
                                echo "</tr>";

                                // Ambil tanggal dari kolom tanggal_permohonan
                                $tanggal = $row_alternatif['tanggal_permohonan'];

                                $status = "Belum Diverifikasi";

                                // Tambahkan status "Belum Diverifikasi" ke dalam objek timelineData
                                $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggal)), "status" => $status);
                            }
                        }

                        ?>

                    </table>
                </div>
            </div>
            <div id="header-flex">
                <div class="fill">
                    <div class="style-font">
                        Dikuasakan Kepada
                    </div>
                </div>
                <table class="table table-bordered">
                    <?php
                    $nik = $_SESSION['nik'];
                    $query = "SELECT * FROM pengajuan_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><strong>Nama</strong></td>";
                            echo "<td>{$row['nama']}</td>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td><strong>Pekerjaan</strong></td>";
                            echo "<td>{$row['pekerjaan']}</td>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td><strong>Surat Kuasa</strong></td>";
                            echo "<td>";

                            // Tambahkan tautan lampiran dengan atribut download jika ada lampiran
                            if (!empty($row['unggah_surat_kuasa'])) {
                                $file_path = "../Assets/Uploads/keberatan/dokumen/" . $row['unggah_surat_kuasa'];
                                echo "<a href=\"$file_path\" download>{$row['unggah_surat_kuasa']}</a>";
                            } else {
                                echo "Tidak ada lampiran";
                            }

                            echo "</td>";
                            echo "</tr>";

                            echo "<tr>";
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "kosong";
                    }
                    ?>
                </table>


                <img src="../Assets/img/logo_jateng.png" style="width: 50px;" alt="">
                Admin PPID Dishub Prov Jateng
                </p>
            </div>
            <div id="tabelcontainer">
                <div class="fill">
                    <div class="style-font">
                        Jawaban Pengajuan Keberatan
                    </div>
                </div>
                <table id="datatabel" class="table table-bordered">
                    <?php
                    $nik = $_SESSION['nik'];
                    $query = "SELECT * FROM keberatananswer_admin WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><strong>Jawaban Permohonan Informasi</strong></td>";
                            echo "<td>{$row['nama_pic']}</td>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td><strong>Dokumen</strong></td>";
                            echo "<td>";
                                
                            $querySurvey = "SELECT * FROM survey_kepuasan_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
                            $resultSurvey = $conn->query($querySurvey);

                            if ($resultSurvey->num_rows > 0) {
                                // Pengguna telah mengisi survei kepuasan, berikan tautan unduh
                                if (!empty($row['lampiran'])) {
                                    $file_path = "../Assets/uploads/keberatan/jawabanKeberatan/" . $row['lampiran'];
                                    echo "<a href=\"$file_path\" download>{$row['lampiran']}</a>";
                                } else {
                                    echo "Tidak ada lampiran";
                                }
                            } else {
                                // Pengguna belum mengisi survei kepuasan, berikan tautan pratinjau
                                if (!empty($row['lampiran'])) {
                                    $file_path = "../Assets/uploads/keberatan/jawabanKeberatan/" . $row['lampiran'];
                                    echo "<a href=\"javascript:void(0);\" onclick=\"previewLampiran('$file_path')\">Pratinjau Lampiran</a>";
                                } else {
                                    echo "Tidak ada lampiran";
                                }
                            }
                            echo "</td>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td><strong>Tanggal</strong></td>";
                            echo "<td>" . (!empty($row['tanggal']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal']))) : '') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "kosong";
                    }
                    ?>
                </table>


                <img src="../Assets/img/logo_jateng.png" style="width: 50px;" alt="">
                Admin PPID Dishub Prov Jateng
                </p>
            </div>
            <?php
            $querySurveyk = "SELECT * FROM survey_kepuasan_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
            $resultSurveyk = $conn->query($querySurveyk);

            $surveyKomplit = ($resultSurveyk->num_rows > 0);
            $surveyPesan = $surveyKomplit ? "Terima kasih telah mengisi survey, silahkan unduh jawaban Keberatan Anda." : "Apakah keberatan informasi Anda sudah terjawab?";
            ?>
            <div class="up-survey">
                <div class="fill">
                    <div class="style-font">
                        Survey
                    </div>
                </div>
                <?php if ($surveyKomplit): ?>
                <h5 class="message"><?php echo $surveyPesan; ?></h5>
                <div class="message">
                    <a href="../controller/download-responsek.php?registrasi=<?php echo $nomer_registrasi_keberatan; ?>" target="_blank">
                            <button class="button-ya" type="button">Unduh Jawaban</button>
                        </a>
                </div>
                <?php else: ?>
                <h5 class="message"><?php echo $surveyPesan; ?></h5>
                <div class="message">
                    <a href="../view/surveyKeberatan?registrasi=<?php echo $nomer_registrasi_keberatan; ?>"> <button class="button-ya" type="button">Ya</button> </a>
                    <button class="button-tdk" type="button">Tidak</button>
                </div>
                <?php endif; ?>
            </div>
            </div>
            <div class="col-md-4">
            <div class="follow-up">
                <div class="fill">
                    <div class="style-font">
                        Tindak Lanjut
                    </div>
                </div>
                <div class="timeline-container">
                    <?php
                    // Loop untuk membuat timeline dari data yang didapatkan dari database
                    foreach ($timelineData as $index => $item) {
                        $date = $item['date'];
                        $status = $item['status'];
                        ?>
                        <div class="timeline-item">
                            <div class="timeline-line"></div>
                            <div class="timeline-number">
                                <?php echo $index + 1; ?>
                            </div>
                            <div class="timeline-content">
                                <strong>
                                    <?php echo $date; ?>
                                </strong><br>
                                Status:
                                <?php echo $status; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php include '../components/footer.php'; ?>

    <script>
        var timelineData = <?php echo json_encode($timelineData); ?>;

        function createTimelineItem(date, status, number) {
            var timelineItem = document.createElement("div");
            timelineItem.className = "timeline-item";

            var timelineLine = document.createElement("div");
            timelineLine.className = "timeline-line";

            var timelineNumber = document.createElement("div");
            timelineNumber.className = "timeline-number";
            timelineNumber.textContent = number;

            var timelineContent = document.createElement("div");
            timelineContent.className = "timeline-content";
            timelineContent.innerHTML = "<strong>" + date + "</strong><br>Status: " + status;

            timelineItem.appendChild(timelineLine);
            timelineItem.appendChild(timelineNumber);
            timelineItem.appendChild(timelineContent);

            return timelineItem;
        }

        var timelineContainer = document.querySelector(".timeline-container");

        // Fungsi untuk membuat timeline dari data yang ada
        function createTimeline() {
            timelineContainer.innerHTML = ""; // Bersihkan kontainer timeline terlebih dahulu

            timelineData.forEach(function (item, index) {
                var timelineItem = createTimelineItem(item.date, item.status, index + 1);
                timelineContainer.appendChild(timelineItem);
            });
        }

        // Inisialisasi timeline saat halaman dimuat
        createTimeline();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi untuk menampilkan pop-up SweetAlert2
            function showSweetAlert() {
                Swal.fire({
                    title: 'Apakah Anda akan mengajukan keberatan?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Logika jika tombol "Ya" pada SweetAlert2 diklik
                        // Misalnya, Anda dapat menambahkan logika untuk mengirimkan permintaan ke server
                        window.location.href = 'aduan';
                    } else {
                        // Logika jika tombol "Tidak" pada SweetAlert2 diklik
                        console.log("Anda tidak mengajukan keberatan.");
                    }
                });
            }

            // Mendapatkan elemen tombol "Tidak"
            var buttonTidak = document.querySelector('.button-tdk');

            // Menambahkan event listener untuk menampilkan SweetAlert2 ketika tombol "Tidak" diklik
            buttonTidak.addEventListener('click', showSweetAlert);
        });
    </script>
    <script>
        var datatabel =document.getElementById("datatabel");
        var tabelcontainer = document.getElementById("tabelcontainer");

        if (datatabel.rows.length <= 1) {
            tabelcontainer.style.display = "none";
        }
    </script>
    <script>
    // Add this function to your script
function openModal(file_path) {
    var modalBody = document.getElementById('lampiranModalBody');
    modalBody.innerHTML = '<iframe src="' + file_path + '></iframe>';

    $('#lampiranModal').modal('show');
}

// Modify your previewLampiran function
function previewLampiran(file_path) {
    openModal(file_path);
}

</script>
<script>
    function previewLampiran(file_path) {
    var container = document.createElement('div');

    // Initialize PDF.js
    pdfjsLib.getDocument(file_path).promise.then(function(pdfDoc) {
        for (var pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
            pdfDoc.getPage(pageNum).then(function(page) {
                var canvas = document.createElement('canvas');
                var context = canvas.getContext('2d');
                var viewport = page.getViewport({ scale: 1.5 });

                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext).promise.then(function() {
                    container.appendChild(canvas);
                });
            });
        }
    });

    // Show modal with PDF content
    Swal.fire({
        title: 'Pratinjau Lampiran',
        html: container,
        showCloseButton: true,
        showConfirmButton: false,
        focusConfirm: false,
    });
}

</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>
