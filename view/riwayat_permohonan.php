<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['id'];
include('../controller/koneksi/config.php');
if (!isset($_SESSION['nomer_registrasi'])) {
    header("Location: ../components/eror.html");
    exit();
}
$nomer_registrasi = $_SESSION['nomer_registrasi'];
$query = "SELECT * FROM verifikasi_permohonan WHERE nomer_registrasi = '$nomer_registrasi'";
$result = $conn->query($query);

// Array untuk menyimpan data timeline
$timelineData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        $tanggal = $row['tanggal_verifikasi']; // Sesuaikan dengan nama kolom di tabel Anda
        
        // Tambahkan data ke dalam objek timelineData
        $timelineData[] = array("date" => $tanggal, "status" => $status);
    }
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
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.css" rel="stylesheet" />
    <link rel="stylesheet" href="../Assets/fontawesome/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../Assets/css/style.css" />

    <title>-</title>
</head>

<body>
    <!-- navbar -->
    <?php include '../components/navbar.php'; ?>
    <div class="custom-line"></div>
    <h1 class="form-title">Detail Permohonan<br />Informasi Publik</h1>
    <div class="container-riwayat">
        <div class="left-container">
            <div class="box-left">
                <div style="width: 100%; border-radius: 10px; border: 1px black solid">
                    <div
                        style="width: 100%; height: 10%; background: #9F0000; border-top-left-radius: 10px; border-top-right-radius: 10px; border: 1px black solid">
                        <div
                            style="width: 100%; color: white; font-size: 25px; font-family: Inter; font-weight: 700; word-wrap: break-word; margin-top: 20px;">
                            Permohonan Informasi
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <?php
                        if (!isset($_SESSION['nomer_registrasi'])) {
                            header("Location: halaman_error.php");
                            exit();
                        }
                        $nomer_registrasi = $_SESSION['nomer_registrasi'];
                        $query = "SELECT * FROM verifikasi_permohonan WHERE nomer_registrasi = '$nomer_registrasi'";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            // Data ditemukan, tampilkan atau proses data di sini
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><strong>Nama :</strong></td>";
                                echo "<td>{$row['nama_pengguna']}</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>Tanggal Permohonan:</strong></td>";
                                echo "<td>{$row['tanggal_permohonan']}</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>Nomor Register:</strong></td>";
                                echo "<td>{$row['nomer_registrasi']}</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>Informasi yang Diminta:</strong></td>";
                                echo "<td>{$row['informasi_yang_dibutuhkan']}</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>Alasan Pengguna Informasi:</strong></td>";
                                echo "<td>{$row['alasan_pengguna_informasi']}</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td><strong>OPD Yang Dituju:</strong></td>";
                                echo "<td>{$row['opd_yang_dituju']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            // Data tidak ditemukan, berikan respons sesuai ke pengguna
                            echo "<tr><td colspan='2'>Data permohonan tidak ditemukan.</td></tr>";
                        }
                        ?>

                    </table>
                </div>
            </div>
            <div style="width: 100%; border-radius: 10px; border: 1px black solid">
                <div
                    style="width: 100%; height: 10%; background: #9F0000; border-top-left-radius: 10px; border-top-right-radius: 10px; border: 1px black solid">
                    <div
                        style="width: 100%; color: white; font-size: 25px; font-family: Inter; font-weight: 700; word-wrap: break-word; margin-top: 20px;">
                        Jawaban Permohonan Informasi
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <td><strong>Nama PIC :</strong></td>
                        <td>Astika</td>
                    </tr>
                    <tr>
                        <td><strong>Jawaban Permohonan :</strong></td>
                        <td>rg</td>
                    </tr>
                    <tr>
                        <td><strong>Lampiran :</strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal :</strong></td>
                        <td></td>
                    </tr>
                </table>

                <img src="../Assets/img/logo_jateng.png" style="width: 50px;" alt="">
                Admin PPID Dishub Prov Jateng
                </p>
            </div>
            <div style="width: 100%; background: white; border-radius: 10px; border: 1px black solid">
                <div
                    style="width: 100%; height: 10%; background: #9F0000; border-top-left-radius: 10px; border-top-right-radius: 10px; border: 1px black solid">
                    <div
                        style="width: 100%; color: white; font-size: 25px; font-family: Inter; font-weight: 700; word-wrap: break-word; margin-top: 20px;">
                        Survey
                    </div>
                </div>
                <h5 style="text-align: center;">Apakah permohonan informasi Anda sudah terjawab?</h5>
                <div style="text-align: center;">
                    <button class="button-ya" type="button">Ya</button>
                    <button class="button-tdk" type="button">Tidak</button>
                </div>
            </div>
        </div>
        <div class="right-container">
        <div class="box-right" style="width: 100%; height: 100%; border-radius: 10px; border: 1px black solid">
            <div style="width: 100%; height: 10%; background: #9F0000; border-top-left-radius: 10px; border-top-right-radius: 10px; border: 1px black solid">
                <div style="width: 100%; color: white; font-size: 25px; font-family: Inter; font-weight: 700; word-wrap: break-word; margin-top: 20px;">
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
                        <div class="timeline-number"><?php echo $index + 1; ?></div>
                        <div class="timeline-content">
                            <strong><?php echo $date; ?></strong><br>
                            Status: <?php echo $status; ?>
                        </div>
                    </div>
                <?php
                }
                ?>
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

// Fungsi untuk menangani klik tombol "Ya"
function handleYesClick() {
    // Lakukan aksi yang diperlukan ketika pengguna memilih "Ya"
    alert("Terima kasih atas tanggapan Anda!");
}

// Fungsi untuk menangani klik tombol "Tidak"
function handleNoClick() {
    // Lakukan aksi yang diperlukan ketika pengguna memilih "Tidak"
    alert("Terima kasih atas tanggapan Anda! Kami akan memperbaiki pelayanan kami.");
}

// Menangani klik tombol "Ya"
var yesButton = document.querySelector(".button-ya");
yesButton.addEventListener("click", handleYesClick);

// Menangani klik tombol "Tidak"
var noButton = document.querySelector(".button-tdk");
noButton.addEventListener("click", handleNoClick);
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
</body>

</html>