<?php
session_start();
include '../Model/Admin/DashboardModel.php';
if (!isset($_SESSION['id'])) {
    header("Location: ../view/admin");
    exit();
}
// Pemeriksaan peran (role)
if ($_SESSION['role'] !== 'superadmin' && $_SESSION['role'] !== 'admin') {
    // Redirect non-superadmin and non-admin users to a different page
    header("Location: ../components/ErorAkses");
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
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/images/logo_jateng.png">
    <link href="../Assets/plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="../Assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <link href="../Assets/css/style-admin.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="https://unpkg.com/topojson-client@3"></script>
    <link rel="stylesheet" href="../Assets/fontawesome/css/all.min.css">
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
        <?php include '../components/navbarAdmin.php'; ?>
        <div class="content-body">
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-1" onclick="toggleGraph('graphSurvey')">
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
                        <div class="card gradient-7" onclick="toggleGraph('graphPermohonan')">
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
                    <div class="col-lg-4 col-sm-12" onclick="toggleGraph('graphVerifikasiPermohonan')">
                        <div class="card gradient-9">
                            <div class="card-body">
                                <h3 class="card-title text-white">Permohonan Informasi Yang Sudah Diverifikasi</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">
                                        <?php echo array_sum($dataVerifikasiPermohonan); ?>
                                    </h2>
                                    <p class="text-white mb-0">Total permohonan yang diverifikasi</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-info-circle"></i></span>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-8" onclick="toggleGraph('graphVerifikasiPermohonanKeberatan')">
                            <div class="card-body">
                                <h3 class="card-title text-white">Permohonan Keberatan Informasi Yang Sudah Diverifikasi
                                </h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">
                                        <?php echo array_sum($dataVerifikasiPermohonanKeberatan); ?>
                                    </h2>
                                    <p class="text-white mb-0">Total permohonan yang diverifikasi</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-info-circle"></i></span>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-8">
                            <div class="card-body">
                                <h3 class="card-title text-white">Download</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">
                                        Download laporan
                                    </h2>
                                    <p class="text-white mb-0">klik icon download</p>
                                </div>
                                <span class="float-right display-5 opacity-5">
                                    <i class="fa fa-download" id="exportExcel" data-toggle="modal"
                                        data-target="#downloadModal"></i>
                                </span>
                                <!-- Dropdown menu for download options -->
                                <div class="modal fade" id="downloadModal" tabindex="-1" role="dialog"
                                    aria-labelledby="downloadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="downloadModalLabel">Pilih Opsi Download</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <button onclick="window.open('../controller/Admin/Laporan/survey.php')"
                                                    class="btn btn-primary">Download Laporan Survey</button>
                                                <button
                                                    onclick="window.open('../controller/Admin/Laporan/PermohonanInformasi.php')"
                                                    class="btn btn-primary">Download Laporan Permohonan
                                                    Informasi</button>
                                                <button
                                                    onclick="window.open('../controller/Admin/Laporan/KeberatanInformasi.php')"
                                                    class="btn btn-primary">Download Laporan Keberatan
                                                    Informasi</button>
                                                <button
                                                    onclick="window.open('../controller/Admin/Laporan/verifikasiPermohonan.php')"
                                                    class="btn btn-primary">Download Laporan Verifikasi
                                                    Permohonan</button>
                                                <button
                                                    onclick="window.open('../controller/Admin/Laporan/VerifikasiKeberatan.php')"
                                                    class="btn btn-primary">Download Laporan Verifikasi
                                                    Keberatan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-2 col-sm-12">
                        <div class="card gradient-2">
                            <div class="card-body">
                                <h3 class="card-title text-white">
                                </h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">
                                    </h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fas fa-chart-line"></i></span>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div id="graphSurvey" class="graph-container">
                                <canvas id="lineChartSurvey"></canvas>
                            </div>
                            <div id="graphPermohonan" class="graph-container">
                                <canvas id="lineChartPermohonan"></canvas>
                            </div>
                            <div id="graphKeberatan" class="graph-container">
                                <canvas id="lineChartKeberatan"></canvas>
                            </div>
                            <div id="graphVerifikasiPermohonan" class="graph-container">
                                <canvas id="lineChartVerifikasiPermohonan"></canvas>
                            </div>
                            <div id="graphVerifikasiPermohonanKeberatan" class="graph-container">
                                <canvas id="lineChartVerifikasiPermohonanKeberatan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../components/footer.html'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleGraph(graphId) {
            var graphContainer = document.getElementById(graphId);
            if (graphContainer.style.display === 'none') {
                // Sembunyikan semua grafik lainnya
                document.querySelectorAll('.graph-container').forEach(graph => {
                    if (graph.id !== graphId) {
                        graph.style.display = 'none';
                    }
                });
                graphContainer.style.display = 'block';
                initOrUpdateChart(graphId);
            } else {
                graphContainer.style.display = 'none';
            }
        }
        function initOrUpdateChart(graphId) {
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
                case 'graphVerifikasiPermohonan':
                    data = <?php echo json_encode(array_values($dataVerifikasiPermohonan)); ?>;
                    break;
                case 'graphVerifikasiPermohonanKeberatan':
                    data = <?php echo json_encode(array_values($dataVerifikasiPermohonanKeberatan)); ?>;
                    break;
                default:
                    data = [];
            }
            var ctxLine = document.getElementById(graphId).getElementsByTagName('canvas')[0].getContext('2d');
            var lineChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: 'Jumlah',
                        data: data,
                        borderColor: 'rgb(238, 238, 238)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(0, 0, 255, 1)',
                        fill: true,
                        backgroundColor: 'rgb(128, 128, 128)'
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
    <script>
        function toggleTable(tableId) {
            var table = document.getElementById(tableId);
            if (table.style.display === 'block') {
                table.style.display = 'none';
            } else {
                document.querySelectorAll('[id^="table"]').forEach(t => {
                    if (t.id !== tableId) {
                        t.style.display = 'none';
                    }
                });
                table.style.display = 'block';
            }
        }
    </script>
    <script src="../Model/Auth/TimeOut.js"></script>
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