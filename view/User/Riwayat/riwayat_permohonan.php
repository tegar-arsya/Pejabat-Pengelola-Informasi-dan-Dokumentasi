<?php
require '../../../controller/RiwayatController/applicationHistory.php';
include ('../../../controller/koneksi/config.php');
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
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/img/logo_jateng.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../Assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../../../Assets/css/style.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.0.0/mammoth.browser.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <title>Riwayat Permohonan</title>
</head>

<body>
    <!-- navbar -->
    <?php include '../../../components/navbar.php'; ?>
    <div class="custom-line"></div>
    <h1 class="form-title">Detail Permohonan<br />Informasi Publik</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!-- Left Container Content -->
                <div class="box-left">
                    <div class="up">
                        <div class="fill">
                            <div class="style-font">
                                Permohonan Informasi
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <?php
                            $query = "SELECT p.id,  p.nomer_registrasi, p.nama_pengguna, p.opd_yang_dituju, p.tanggal_permohonan, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi, p.id_registrasi, v.id_permohonan, v.status
                                                FROM verifikasi_permohonan v
                                                JOIN permohonan_informasi p ON p.id= v.id_permohonan
                                                WHERE p.id = '$id_permohonan'";
                            $result = $conn->query($query);

                            // Menambahkan data dari tbl_rejected
                            $queryRejected = "SELECT * FROM tbl_rejected WHERE id_permohonan = '$id_permohonan'";
                            $resultRejected = $conn->query($queryRejected);

                            $isRejected = $resultRejected->num_rows > 0;

                            if ($result->num_rows > 0) {
                                // Data ditemukan, tampilkan atau proses data di sini
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><strong>Nama</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['nama_pengguna'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Tanggal Permohonan</strong></td>";
                                    echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Nomor Register</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['nomer_registrasi'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Informasi yang Diminta</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['informasi_yang_dibutuhkan'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Alasan Pengguna Informasi</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['alasan_pengguna_informasi'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>OPD Yang Dituju</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['opd_yang_dituju'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                $query_alternatif = "SELECT p.id,  p.nomer_registrasi, p.nama_pengguna, p.opd_yang_dituju, p.tanggal_permohonan, r.nik, r.foto_ktp, r.no_hp, r.alamat, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi, p.id_registrasi
                                                FROM registrasi r
                                                JOIN permohonan_informasi p ON p.id_registrasi = r.id
                                                WHERE p.id = '$id_permohonan'";

                                $result_alternatif = $conn->query($query_alternatif);
                                while ($row_alternatif = $result_alternatif->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><strong>Nama</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['nama_pengguna'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Tanggal Permohonan</strong></td>";
                                    echo "<td>" . (!empty($row_alternatif['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row_alternatif['tanggal_permohonan']))) : '') . "</td>";                                    echo "</tr>";

                                    // echo "<tr>";
                                    // echo "<td><strong>ID Registasi:</strong></td>";
                                    // echo "<td>" . htmlspecialchars($row_alternatif['id_registrasi'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    // echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Nomor Register</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['nomer_registrasi'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Informasi yang Diminta</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['informasi_yang_dibutuhkan'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Alasan Pengguna Informasi</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['alasan_pengguna_informasi'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>OPD Yang Dituju</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['opd_yang_dituju'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    // Ambil tanggal dari kolom tanggal_permohonan
                                    $tanggal = $row_alternatif['tanggal_permohonan'];

                                    $status = "Belum Diverifikasi";

                                    // Tambahkan status "Belum Diverifikasi" ke dalam objek timelineData
                                    // $timelineData[] = array("date" => $tanggal, "status" => $status);
                                    $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggal)), "status" => $status);
                                }
                            }

                            ?>

                        </table>
                    </div>
                    <div id="tableContainer">
                        <div class="fill">
                            <div class="style-font">
                                Jawaban Permohonan Informasi
                            </div>
                        </div>
                        <table id="dataTable" class="table table-bordered">
                            <?php

                            $query = "SELECT * FROM answer_admin WHERE id_permohonan = '$id_permohonan'";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><strong>Nama PIC</strong></td>";
                                    echo "<td>{$row['nama_pic']}</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Jawaban Permohonan</strong></td>";
                                    echo "<td>{$row['jawaban_permohonan']}</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Lampiran</strong></td>";
                                    echo "<td>";

                                    // Periksa apakah pengguna telah mengisi survei kepuasan
                                    $querySurvey = "SELECT * FROM survey_kepuasan WHERE id_permohonan = '$id_permohonan'";
                                    $resultSurvey = $conn->query($querySurvey);

                                    if ($resultSurvey->num_rows > 0) {
                                        // Pengguna telah mengisi survei kepuasan, berikan tautan unduh
                                        if (!empty ($row['lampiran'])) {
                                            $file_path = "../../../Assets/JawabanPI/" . $row['lampiran'];
                                            echo "<a href=\"$file_path\" download>{$row['lampiran']}</a>";
                                        } else {
                                            echo "Tidak ada lampiran";
                                        }
                                    } else {
                                        // Pengguna belum mengisi survei kepuasan, berikan tautan pratinjau
                                        if (!empty ($row['lampiran'])) {
                                            $file_path = "../../../Assets/JawabanPI/" . $row['lampiran'];
                                            echo "<a href=\"javascript:void(0);\" onclick=\"previewLampiran('$file_path')\">Pratinjau Lampiran</a>";
                                        } else {
                                            echo "Tidak ada lampiran";
                                        }
                                    }

                                    echo "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Tanggal</strong></td>";
                                    echo "<td>" . (!empty ($row['tanggal_jawaban']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_jawaban']))) : '') . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "kosong";
                            }
                            ?>
                        </table>


                        <img src="../../../Assets/img/logo_jateng.png" style="width: 50px;" class="img-fluid" alt="Logo">
                        Admin PPID Dishub Prov Jateng
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box-right follow-up">
                    <div class="fill">
                        <div class="style-font">
                            Tindak Lanjut
                        </div>
                    </div>
                    <div class="timeline-container">
                        <img src="../../../Assets/img/logo_jateng.png" alt="Logo" />
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
                <div class="box-left">
                    <?php
                    // Check if the user has completed the survey
                    $querySurvey = "SELECT * FROM survey_kepuasan WHERE id_permohonan = '$id_permohonan'";
                    $resultSurvey = $conn->query($querySurvey);

                    $surveyCompleted = ($resultSurvey->num_rows > 0);

                    // Determine the appropriate message based on whether the survey is completed
                    $surveyMessage = $surveyCompleted ? "Terima kasih telah mengisi survey, silahkan unduh jawaban permohonan Anda." : "Apakah permohonan informasi Anda sudah terjawab?";
                    ?>

                    <div class="up-survey">
                        <div class="fill">
                            <div class="style-font">
                                Survey
                            </div>
                        </div>
                        <?php if ($surveyCompleted): ?>
                            <h5 class="message">
                                <?php echo $surveyMessage; ?>
                            </h5>
                            <div class="message">
                                <a href="../../../controller/User/Download/download-response.php?Permohonan=<?php echo $id_permohonan; ?>"
                                    target="_blank">
                                    <button class="button-ya" type="button">Unduh Jawaban</button>
                                </a>
                            </div>
                        <?php else: ?>
                            <h5 class="message">
                                <?php echo $surveyMessage; ?>
                            </h5>
                            <div class="message">
                                <a href="../../../view/User/Form/survey?Permohonan=<?php echo $id_permohonan; ?>">
                                    <button class="button-ya" type="button">Ya</button>
                                </a>
                                <button class="button-tdk" type="button">Tidak</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        </div>
    </div>
    <?php include '../../../components/footer.php'; ?>

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
                        window.location.href = '../Form/aduan';
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
        // Dapatkan elemen tabel dan kontainer
        var dataTable = document.getElementById("dataTable");
        var tableContainer = document.getElementById("tableContainer");

        // Periksa apakah ada baris data dalam tabel
        if (dataTable.rows.length <= 1) { // Anggap ada selalu satu baris untuk header
            // Sembunyikan kontainer jika tidak ada baris data
            tableContainer.style.display = "none";
        }
    </script>
    <!-- Tambahkan script di bagian head atau sebelum </body> -->
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
            pdfjsLib.getDocument(file_path).promise.then(function (pdfDoc) {
                for (var pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                    pdfDoc.getPage(pageNum).then(function (page) {
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
                        page.render(renderContext).promise.then(function () {
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
    <script src="../Model/Auth/TimeOutUser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>