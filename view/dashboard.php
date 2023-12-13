<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/admin");
    exit();
}
$user_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PERMOHONAN INFORMASI PROVINSI JAWA TENGAH</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/images/logo_jateng.png">
    <!-- Pignose Calender -->
    <link href="../Assets/plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="../Assets/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="../Assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="../Assets/css/style-admin.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="https://unpkg.com/topojson-client@3"></script>
</head>

<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <div id="main-wrapper">
        <?php include '../components/navbar.html'; ?>
        <div class="content-body">
            <div class="container-fluid mt-3">
                <div class="row">
                    <?php
                    include '../controller/koneksi/config.php';
                    $sqlSurvey = "SELECT COUNT(*) as total_survey, MONTH(tanggal_survey) as month FROM survey_kepuasan GROUP BY MONTH(tanggal_survey)";
                    $resultSurvey = $conn->query($sqlSurvey);

                    $dataSurvey = array_fill(0, 12, 0); // Inisialisasi array dengan 12 bulan, diisi dengan 0
                    while ($rowSurvey = $resultSurvey->fetch_assoc()) {
                        $dataSurvey[$rowSurvey['month'] - 1] = $rowSurvey['total_survey'];
                    }
                    $sqlPermohonan = "SELECT COUNT(*) as total_permohonan, MONTH(tanggal_permohonan) as month FROM permohonan_informasi GROUP BY MONTH(tanggal_permohonan)";
                    $resultPermohonan = $conn->query($sqlPermohonan);

                    $dataPermohonan = array_fill(0, 12, 0); // Inisialisasi array dengan 12 bulan, diisi dengan 0
                    
                    while ($rowPermohonan = $resultPermohonan->fetch_assoc()) {
                        $dataPermohonan[$rowPermohonan['month'] - 1] = $rowPermohonan['total_permohonan'];
                    }
                    $sqlKeberatan = "SELECT COUNT(*) as total_keberatan, MONTH(tanggal_pengajuan) as month FROM pengajuan_keberatan GROUP BY MONTH(tanggal_pengajuan)";
                    $resultKeberatan = $conn->query($sqlKeberatan);

                    $dataKeberatan = array_fill(0, 12, 0); // Inisialisasi array dengan 12 bulan, diisi dengan 0
                    while ($rowKeberatan = $resultKeberatan->fetch_assoc()) {
                        $dataKeberatan[$rowKeberatan['month'] - 1] = $rowKeberatan['total_keberatan'];
                    }
                    $conn->close();
                    ?>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-2" onclick="toggleGraph('graphSurvey')">
                            <div class="card-body">
                                <h3 class="card-title text-white">Survey Kepuasan</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">
                                        <?php echo array_sum($dataSurvey); ?>
                                    </h2>
                                    <p class="text-white mb-0">Total Survey</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-info-circle"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-3" onclick="toggleGraph('graphPermohonan')">
                            <div class="card-body">
                                <h3 class="card-title text-white">Permohonan Informasi</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">
                                        <?php echo array_sum($dataPermohonan); ?>
                                    </h2>
                                    <p class="text-white mb-0">Total Permohonan Informasi</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-info-circle"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-4" onclick="toggleGraph('graphKeberatan')">
                            <div class="card-body">
                                <h3 class="card-title text-white">Permohonan Keberatan</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">
                                        <?php echo array_sum($dataKeberatan); ?>
                                    </h2>
                                    <p class="text-white mb-0">Total Permohonan Keberatan</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-info-circle"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div id="graphSurvey" class="graph-container" >
                                <canvas id="lineChartSurvey"></canvas>
                            </div>
                            <div id="graphPermohonan" class="graph-container" >
                                <canvas id="lineChartPermohonan" ></canvas>
                            </div>
                            <div id="graphKeberatan" class="graph-container" >
                                <canvas id="lineChartKeberatan" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../components/footer.html'; ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleGraph(graphId) {
            var graphContainer = document.getElementById(graphId);

            // Jika grafik sedang tersembunyi, tampilkan
            if (graphContainer.style.display === 'none') {
                // Sembunyikan semua grafik lainnya
                document.querySelectorAll('.graph-container').forEach(graph => {
                    if (graph.id !== graphId) {
                        graph.style.display = 'none';
                    }
                });

                graphContainer.style.display = 'block';

                // Inisialisasi atau update grafik jika diperlukan
                initOrUpdateChart(graphId);
            } else {
                // Jika grafik sedang terbuka, tutup
                graphContainer.style.display = 'none';
            }
        }

        function initOrUpdateChart(graphId) {
            // Lakukan inisialisasi atau pengambilan data dari server jika diperlukan
            // ...

            // Ambil data berdasarkan ID grafik
            var data;
            switch (graphId) {
                case 'graphSurvey':
                    data = <?php echo json_encode(array_values($dataSurvey)); ?>;
                    break;
                case 'graphPermohonan':
                    data = <?php echo json_encode(array_values($dataPermohonan)); ?>;
                    break;
                case 'graphKeberatan':
                    data = <?php echo json_encode(array_values($dataKeberatan)); ?>;
                    break;
                default:
                    data = [];
            }

            // Contoh inisialisasi grafik dengan Chart.js
            var ctxLine = document.getElementById(graphId).getElementsByTagName('canvas')[0].getContext('2d');
            var lineChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: 'Jumlah',
                        data: data,
                        borderColor: 'rgba(0, 255, 0, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(0, 0, 255, 1)',
                        fill: true,
                        backgroundColor: 'rgba(255, 225, 0, 1)'
                    }],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            enabled: true,
                            intersect: false,
                            mode: 'index',
                        },
                        legend: {
                            display: false,
                        },
                    },
                }
            });
        }
    </script>
    </div>
    <script>
        function toggleTable(tableId) {
            var table = document.getElementById(tableId);

            // Jika tabel sedang terbuka, tutup
            if (table.style.display === 'block') {
                table.style.display = 'none';
            } else {
                // Jika tabel sedang tertutup, buka
                // Sembunyikan semua tabel lainnya
                document.querySelectorAll('[id^="table"]').forEach(t => {
                    if (t.id !== tableId) {
                        t.style.display = 'none';
                    }
                });

                table.style.display = 'block';
            }
        }
    </script>

    <script src="../Assets/plugins/topojson/topojson.min.js"></script>
    <script src="../Assets/plugins/datamaps/datamaps.world.min.js"></script>
    <script src="../Assets/plugins/raphael/raphael.min.js"></script>
    <script src="../Assets/plugins/morris/morris.min.js"></script>
    <script src="../Assets/plugins/moment/moment.min.js"></script>
    <script src="../Assets/plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <script src="../Assets/plugins/common/common.min.js"></script>
    <script src="../Assets/js/custom.min.js"></script>
    <script src="../Assets/js/settings.js"></script>
    <script src="../Assets/js/gleek.js"></script>
    <script src="../Assets/js/styleSwitcher.js"></script>
    <script src="../Assets/plugins/chart.js/Chart.bundle.min.js"></script>
    <script src="../Assets/plugins/circle-progress/circle-progress.min.js"></script>
    <script src="../Assets/js/dashboard/dashboard-1.js"></script>
    <script src="../Assets/plugins/chartist/js/chartist.min.js"></script>
    <script src="../Assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>
</body>

</html>