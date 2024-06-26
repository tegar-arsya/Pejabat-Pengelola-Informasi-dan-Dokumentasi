<?php
session_start();
include('../../../controller/koneksi/config.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: ../../../view/Admin/Form/loginadmin");
    exit();
}

$user_id = $_SESSION['id'];

// Pastikan parameter nomer registrasi keberatan tersedia dalam URL
if (isset($_GET['registrasi'])) {
    // Ambil nilai nomer registrasi keberatan dari parameter GET
    $nomer_registrasi_keberatan = $_GET['registrasi'];

    // Prepared statement untuk query
    $query = "SELECT p.id, p.nomer_registrasi_keberatan, p.email_pemohon, v.id_permohonan_keberatan, p.nama_pemohon
              FROM pengajuan_keberatan p
              JOIN verifikasi_keberatan v ON v.id_permohonan_keberatan = p.id
              WHERE p.id = ?";

    // Siapkan statement dan bind parameter
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nomer_registrasi_keberatan);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah hasil query mengembalikan baris data
    if ($result->num_rows > 0) {
        // Ambil baris data sebagai array asosiatif
        while ($row = $result->fetch_assoc()) {
            $namapemohon = $row['nama_pemohon'];
            $email = $row['email_pemohon'];
            $nomer_registrasi_keberatan = $row['nomer_registrasi_keberatan'];
            $id_permohonan_keberatan = $row['id_permohonan_keberatan'];
        }

        // Di sini Anda dapat melanjutkan untuk menggunakan nilai-nilai yang telah Anda ambil dari $row sesuai kebutuhan aplikasi Anda

    } else {
        // Tampilkan pesan kesalahan jika data tidak ditemukan
        echo "Data tidak ditemukan";
    }
} else {
    // Redirect atau tampilkan pesan kesalahan jika parameter nomer registrasi keberatan tidak ada dalam URL
    header("Location: ../../../components/ErorAkses");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Formulir Answer Keberatan</title>
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
                                
                                                           
                                <form method="post" action="../../../controller/AnswerController/adminAnswerKeberatan.php" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="namaPIC" class="form-label">Nama PIC</label>
                                        <input type="text" class="form-control" id="namaPIC" name="namaPIC" value="<?php echo htmlspecialchars($_SESSION['nama_pengguna']);?> " required readonly>
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
                                            <input type="hidden" name="norek" value="<?php echo $nomer_registrasi_keberatan; ?>">
                                            <input type="hidden" name="id_permohonan_keberatan" value="<?php echo $id_permohonan_keberatan; ?>">
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