<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}

$user_id = $_SESSION['id'];
$role = $_SESSION['role'];

// Pemeriksaan peran (role)
if ($role !== 'superadmin' && $role !== 'admin') {
    // Redirect non-superadmin and non-admin users to a different page
    header("Location: ../../../components/ErorAkses");
    exit();
}

include('../../../controller/koneksi/config.php');

function readLogFile($filePath) {
    $logs = [];
    if (file_exists($filePath)) {
        $file = fopen($filePath, 'r');
        while (($line = fgets($file)) !== false) {
            // Parsing data dari baris log
            preg_match("/\[(.*?)\] activity_log\.INFO: (.*?) (\{.*\})/", $line, $matches);
            if (count($matches) == 4) {
                // Buat objek DateTime dari timestamp log
                $dateTime = new DateTime($matches[1], new DateTimeZone('UTC'));
                
                // Konversi ke zona waktu WIB
                $dateTime->setTimezone(new DateTimeZone('Asia/Jakarta'));
                
                // Format tanggal ke d/m/Y H:i
                $tanggal = $dateTime->format('d/m/Y H:i');

                // Decode log data
                $logData = json_decode($matches[3], true);
                if ($logData !== null) {
                    $logs[] = [
                        'tanggal' => $tanggal,
                        'admin' => isset($logData['admin']) ? htmlspecialchars($logData['admin']) : '',
                        'description' => isset($logData['description']) ? htmlspecialchars($logData['description']) : ''
                    ];
                }
            }
        }
        fclose($file);
    }
    return $logs;
}





$logFilePath = __DIR__ . '/../../../Model/Logs/activity.log';
$logs = readLogFile($logFilePath);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Aktiviti</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/images/logo_jateng.png">
    <!-- Custom Stylesheet -->
    <link href="../../../Assets/css/style-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../Assets/fontawesome/css/all.min.css">
    <style>
        /* CSS untuk gaya berbeda pada setiap kalimat log */
        .log-1 {
            background-color: #f0f0f0; /* Warna latar belakang */
            color: #333; /* Warna font */
        }

        .log-2 {
            background-color: #e3f2fd; /* Warna latar belakang */
            color: #1565c0; /* Warna font */
        }

        .log-3 {
            background-color: #f8bbd0; /* Warna latar belakang */
            color: #880e4f; /* Warna font */
        }
        .scrollable-card {
            max-height: 600px; /* Atur tinggi maksimum card */
            overflow-y: auto; /* Aktifkan overflow vertikal */
            border: 1px solid #ccc; /* Tambahkan border untuk membedakan card dari background */
            border-radius: 5px; /* Bulatkan sudut card */
            padding: 10px; /* Tambahkan padding agar konten tidak berdekatan dengan tepi card */
        }
        /* Tambahkan gaya untuk setiap kalimat log di sini sesuai kebutuhan */
    </style>
</head>

<body>
    <!-- <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div> -->
    <div id="main-wrapper">
        <?php include '../../../components/navbarAdmin.php'; ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="text-align: center;">
                            <div class="card-body">
                                <h1>Log Aktivitas</h1>
                            </div>
                        </div>
                        <div class="card scrollable-card">
                            <div class="card-body">
                            <?php
                                $logClasses = ['log-1', 'log-2', 'log-3']; // Array kelas log
                                foreach ($logs as $index => $log) {
                                    $logClass = $logClasses[$index % count($logClasses)]; // Tentukan kelas CSS berdasarkan indeks log
                                    echo "<p class='{$logClass}'>{$log['tanggal']} - Admin: {$log['admin']} - Description: {$log['description']}</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../../../components/footer.html'; ?>
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../../Model/Auth/TimeOut.js"></script>
    <script src="../../../Assets/plugins/common/common.min.js"></script>
    <script src="../../../Assets/js/custom.min.js"></script>
    <script src="../../../Assets/js/settings.js"></script>
    <script src="../../../Assets/js/gleek.js"></script>
    <script src="../../../Assets/js/styleSwitcher.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>
