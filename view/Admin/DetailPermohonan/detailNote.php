<?php
session_start();
include('../../../controller/koneksi/config.php');
if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}
$user_id = $_SESSION['id'];
if (!isset($_GET['registrasi'])) {
    header("Location: ../../../components/eror.html");
    exit();
}
$nomer_registrasi_keberatan = $_GET['registrasi'];

$query = "SELECT * FROM note_admin WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$result = $conn->query($query);

if ($result -> num_rows > 0) {
    while ($row = $result -> fetch_assoc()) {
        $keterangan = $row['keterangan'];
        $namapemohon = $row['nama_pemohon'];
        $status = $row ['status'];
        $nomer_registrasi = $row['nomer_registrasi_keberatan'];
    }
}
else {
    
}
$queryTabelLain = "SELECT * FROM pengajuan_keberatan WHERE nomer_registrasi_keberatan = '$nomer_registrasi_keberatan'";
$resultTabelLain = $conn->query($queryTabelLain);

if ($resultTabelLain->num_rows > 0) {
    while ($row = $resultTabelLain->fetch_assoc()) {
        $nama = $row['nama_pemohon']; 
        $tgl =$row['tanggal_permohonan'];
        $code =$row['kode_permohonan_informasi'];
        $noreg =$row['nomer_registrasi_keberatan'];
        $nik =$row['nik_pemohon'];
        $email =$row['email_pemohon'];
        $foto =$row['foto_ktp_pemohon'];
        $opd =$row['opd_yang_dituju'];
        $inf =$row['informasi_yang_diminta'];
        $alasan =$row['alasan_keberatan'];
    }
} else {
    // Tidak ada hasil yang ditemukan
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PERMOHONAN INFORMASI PROVINSI JAWA TENGAH</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/images/logo_jateng.png">
    <!-- Custom Stylesheet -->
    <link href="../../../Assets//plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../../../Assets/css/style-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../Assets/fontawesome/css/all.min.css">
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
    <?php include '../../../components/navbarAdmin.php'; ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                <div class="col-12">
                        <div class="card">
                            <h1>Detail Pengajuan Keberatan Informasi</h1>
                            <div class="card-body">
                                <h4>Identitas Pemohon</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Nama Pemohon</strong></td>
                                        <td>
                                            <?php echo $nama; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Permohonan</strong></td>
                                        <td>
                                        <?php echo !empty($tgl) ? date('d-m-Y H:i:s', strtotime($tgl)) : ''; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor Registasi Permohonan</strong></td>
                                        <td>
                                            <?php echo $code; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor Register Keberatan</strong></td>
                                        <td id="nomorRegistrasiCell">
                                            <?php echo $noreg; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIK</strong></td>
                                        <td>
                                            <?php echo $nik; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email Pemohon</strong></td>
                                        <td>
                                            <?php echo $email; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Foto KTP</strong></td>
                                        <td><a href="../Assets/uploads/<?php echo $foto; ?>"
                                                target="_blank">
                                                <?php echo $foto; ?>
                                            </a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Opd Yang Di Tuju</strong></td>
                                        <td>
                                            <?php echo $opd; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Informasi yang Dibutuhkan</strong></td>
                                        <td>
                                            <?php echo $inf; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alasan Keberatan</strong></td>
                                        <td>
                                            <?php echo $alasan; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h1>Catatan</h1>
                                <h4 class="card-title">Daftar Catatan</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No.Register Keberatan</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            include('../../../controller/koneksi/config.php');
                                            $sql = "SELECT * FROM note_admin WHERE nomer_registrasi_keberatan =  '$nomer_registrasi_keberatan'";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                $counter = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $formattedDate = date('d-m-Y', strtotime($row["keterangan"]));
                                                    echo "<tr>
                                                            <td>" . $counter . "</td>
                                                            <td>" . $row["nomer_registrasi_keberatan"] . "</td>
                                                            <td>" . $formattedDate . "</td>
                                                            <td>" . $row["status"] . "</td>
                                                        </tr>";
                                                        $counter++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                                            }
                                            $conn->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../../../components/footer.html'; ?>
    </div>
    <script src="../../../Model/Auth/TimeOut.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../../Assets/plugins/common/common.min.js"></script>
    <script src="../../../Assets/js/custom.min.js"></script>
    <script src="../../../Assets/js/settings.js"></script>
    <script src="../../../Assets/js/gleek.js"></script>
    <script src="../../../Assets/js/styleSwitcher.js"></script>

    <script src="../../../Assets/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../../../Assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../../../Assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

</body>

</html>