<?php
session_start();
include('../../../controller/koneksi/config.php');

if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}

$user_id = $_SESSION['id'];

if (!isset($_GET['permohonan'])) {
    header("Location: ../../../components/ErorAkses");
    exit();
}

$id_permohonan = $_GET['permohonan'];
$pic = $_SESSION['nama_pengguna'];

// Prepared statement untuk query
$query = "SELECT p.id, p.id_registrasi, p.nomer_registrasi, r.nik, r.id, r.email, v.id_permohonan
          FROM permohonan_informasi p
          JOIN registrasi r ON p.id_registrasi = r.id
          JOIN verifikasi_permohonan v ON v.id_permohonan = p.id
          WHERE p.id = ?";
          
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_permohonan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_registrasi = $row['id_registrasi'];
        $email = $row['email'];
        $nomer_registrasi = $row['nomer_registrasi'];
        $id_permohonan = $row['id_permohonan'];
    }
} else {
    echo "Data tidak ada";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Formulir Answer</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/images/logo_jateng.png">
    <!-- Custom Stylesheet -->
    <link href="../../../Assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../../../Assets/css/style-admin.css" rel="stylesheet">

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
                            <div class="card-body">
                                
                                                           
                                <form method="post" action="../../../controller/AnswerController/adminAnswer.php" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="namaPIC" class="form-label">Nama PIC</label>
                                        <input type="text" class="form-control" id="namaPIC" name="namaPIC" value="<?php echo isset($_SESSION['nama_pengguna']) ? htmlspecialchars($_SESSION['nama_pengguna']) : ''; ?>" required readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jawabanPermohonan" class="form-label">jawaban Permohonan</label>
                                        <textarea class="form-control" id="jawabanPermohonan" name="jawabanPermohonan" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lampiran" class="form-label">Lampiran</label>
                                        <input type="file" class="form-control" id="lampiran" name="lampiran" required />
                                    </div>
                
                                            
                                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                                            <input type="hidden" name="id_registrasi" value="<?php echo $id_registrasi; ?>">
                                            <input type="hidden" name="norek" value="<?php echo $nomer_registrasi; ?>"> 
                                            <input type="hidden" name="id_permohonan" value="<?php echo $id_permohonan; ?>">
                                    <button type="submit" class="btn btn-primary">submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../../../components/footer.html'; ?>
    </div>
    <script src="../../../Model/Auth/TimeOut.js"></script>
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