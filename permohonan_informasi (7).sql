-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 12:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `permohonan_informasi`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `to_roman` (`month_num` INT) RETURNS VARCHAR(3) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    DECLARE result VARCHAR(3);

    CASE month_num
        WHEN 1 THEN SET result = 'I';
        WHEN 2 THEN SET result = 'II';
        WHEN 3 THEN SET result = 'III';
        WHEN 4 THEN SET result = 'IV';
        WHEN 5 THEN SET result = 'V';
        WHEN 6 THEN SET result = 'VI';
        WHEN 7 THEN SET result = 'VII';
        WHEN 8 THEN SET result = 'VIII';
        WHEN 9 THEN SET result = 'IX';
        WHEN 10 THEN SET result = 'X';
        WHEN 11 THEN SET result = 'XI';
        WHEN 12 THEN SET result = 'XII';
        ELSE SET result = 'Invalid Month';
    END CASE;

    RETURN result;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `to_romanK` (`month_num` INT) RETURNS VARCHAR(3) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    DECLARE result VARCHAR(3);

    CASE month_num
        WHEN 1 THEN SET result = 'I';
        WHEN 2 THEN SET result = 'II';
        WHEN 3 THEN SET result = 'III';
        WHEN 4 THEN SET result = 'IV';
        WHEN 5 THEN SET result = 'V';
        WHEN 6 THEN SET result = 'VI';
        WHEN 7 THEN SET result = 'VII';
        WHEN 8 THEN SET result = 'VIII';
        WHEN 9 THEN SET result = 'IX';
        WHEN 10 THEN SET result = 'X';
        WHEN 11 THEN SET result = 'XI';
        WHEN 12 THEN SET result = 'XII';
        ELSE SET result = 'Invalid Month';
    END CASE;

    RETURN result;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `answer_admin`
--

CREATE TABLE `answer_admin` (
  `id` int(100) NOT NULL,
  `nama_pic` varchar(255) NOT NULL,
  `jawaban_permohonan` text NOT NULL,
  `lampiran` varchar(255) NOT NULL,
  `tanggal_jawaban` timestamp NOT NULL DEFAULT current_timestamp(),
  `nik_pemohon` varchar(255) NOT NULL,
  `nomer_registrasi_pemohon` varchar(255) NOT NULL,
  `status_balasan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keberatananswer_admin`
--

CREATE TABLE `keberatananswer_admin` (
  `id` int(11) NOT NULL,
  `nama_pic` varchar(100) NOT NULL,
  `jawaban_keberatan` varchar(255) NOT NULL,
  `lampiran` varchar(255) NOT NULL,
  `nik_pemohon` varchar(255) NOT NULL,
  `nomer_registrasi_keberatan` varchar(255) NOT NULL,
  `status_balasan` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `note_admin`
--

CREATE TABLE `note_admin` (
  `id` int(100) NOT NULL,
  `nomer_registrasi_keberatan` varchar(255) NOT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `keterangan` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_pengiriman`
--

CREATE TABLE `notifikasi_pengiriman` (
  `id` int(100) NOT NULL,
  `nomer_registrasi` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `opd_yang_dituju` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tanggal_masuk` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_pengiriman_keberatan`
--

CREATE TABLE `notifikasi_pengiriman_keberatan` (
  `id` int(100) NOT NULL,
  `nomer_registrasi_keberatan` varchar(255) NOT NULL,
  `nik_pemohon` varchar(255) NOT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `opd_yang_dituju` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_keberatan`
--

CREATE TABLE `pengajuan_keberatan` (
  `id` int(100) NOT NULL,
  `nomer_registrasi_keberatan` varchar(255) NOT NULL,
  `kode_permohonan_informasi` varchar(255) NOT NULL,
  `informasi_yang_diminta` varchar(255) NOT NULL,
  `kuasa_permohonan` varchar(255) NOT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota_kabupaten` varchar(2552) NOT NULL,
  `negara` varchar(255) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `opd_yang_dituju` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `unggah_surat_kuasa` varchar(255) NOT NULL,
  `alasan_keberatan` varchar(255) NOT NULL,
  `tanggal_pengajuan` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_permohonan` varchar(255) NOT NULL,
  `nik_pemohon` varchar(255) NOT NULL,
  `email_pemohon` varchar(255) NOT NULL,
  `foto_ktp_pemohon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `pengajuan_keberatan`
--
DELIMITER $$
CREATE TRIGGER `regis_keberatan` BEFORE INSERT ON `pengajuan_keberatan` FOR EACH ROW BEGIN
    DECLARE new_id INT;

    -- Mendapatkan ID baru dari tabel registrasi
    SET new_id = (SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'pengajuan_keberatan');

    -- Mengatur nomor registrasi dengan format yang diinginkan
    SET NEW.nomer_registrasi_keberatan = CONCAT(
        LPAD(new_id, 4, '0'), 
        '/KEBERATAN/', 
        to_romanK(MONTH(NOW())), 
        '/', 
        DATE_FORMAT(NOW(), '%Y')
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_informasi`
--

CREATE TABLE `permohonan_informasi` (
  `id` int(255) NOT NULL,
  `nomer_registrasi` varchar(255) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `opd_yang_dituju` varchar(255) NOT NULL,
  `informasi_yang_dibutuhkan` varchar(255) NOT NULL,
  `alasan_pengguna_informasi` varchar(255) NOT NULL,
  `cara_mendapatkan_informasi` varchar(255) NOT NULL,
  `cara_mendapatkan_salinan` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `tanggal_permohonan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permohonan_informasi`
--

INSERT INTO `permohonan_informasi` (`id`, `nomer_registrasi`, `id_user`, `nama_pengguna`, `opd_yang_dituju`, `informasi_yang_dibutuhkan`, `alasan_pengguna_informasi`, `cara_mendapatkan_informasi`, `cara_mendapatkan_salinan`, `status`, `tanggal_permohonan`) VALUES
(377, '0377/PPID-Jateng/III/2024', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'data perencanaan pemabngunan jalan mranggen ', 'sebagai tugas akhir', 'Mendapatkan Salinan Informasi Hardcopy', 'Mengambil Langsung', NULL, '2024-03-13 22:03:48');

--
-- Triggers `permohonan_informasi`
--
DELIMITER $$
CREATE TRIGGER `before_insert_permohonan_informasi` BEFORE INSERT ON `permohonan_informasi` FOR EACH ROW BEGIN
    DECLARE new_id INT;

    -- Mendapatkan ID baru dari tabel registrasi
    SET new_id = (SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'permohonan_informasi');

    -- Mengatur nomor registrasi dengan format yang diinginkan
    SET NEW.nomer_registrasi = CONCAT(
        LPAD(new_id, 4, '0'), 
        '/PPID-Jateng/', 
        to_roman(MONTH(NOW())), 
        '/', 
        DATE_FORMAT(NOW(), '%Y')
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `registrasi`
--

CREATE TABLE `registrasi` (
  `id` int(11) NOT NULL,
  `nomer_registrasi` varchar(255) NOT NULL,
  `nama_depan` varchar(255) NOT NULL,
  `nama_belakang` varchar(255) NOT NULL,
  `jenis_nik` varchar(255) NOT NULL,
  `jenis_pemohon` varchar(50) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `npwp` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota_kabupaten` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `negara` varchar(255) NOT NULL,
  `kode_pos` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_registrasi` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_reset_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`id`, `nomer_registrasi`, `nama_depan`, `nama_belakang`, `jenis_nik`, `jenis_pemohon`, `nik`, `no_hp`, `foto_ktp`, `npwp`, `pekerjaan`, `alamat`, `kota_kabupaten`, `provinsi`, `negara`, `kode_pos`, `email`, `password`, `tanggal_registrasi`, `token_reset_password`) VALUES
(56, '0056/PPID-Jateng/II/2024', 'TEGAR', 'ARSYADANI', 'Perorangan', 'KTP', '3315182709010001', '081353677822', 'WhatsApp Image 2024-01-24 at 10.59.55_9adbd651.jpg', 'tidak punya', 'Mahasiswa/Pelajar', 'Desa Curug Rt 03 Rw 02 Kecamatan Tegowanu Kabupaten Grobogan', 'KABUPATEN GROBOGAN', 'JAWA TENGAH', 'Indonesia', 58165, 'tegararsya0117@gmail.com', '$2y$10$zlsWsmCODnzm8A8P.HTVPurd7rJQhn7j6phyH08Qc.IGl0B4NkivO', '2024-03-13 22:02:59', '');

--
-- Triggers `registrasi`
--
DELIMITER $$
CREATE TRIGGER `nomer_reg` BEFORE INSERT ON `registrasi` FOR EACH ROW BEGIN
    DECLARE new_id INT;
    DECLARE roman_month CHAR(2);
    DECLARE current_year INT;
    DECLARE last_year INT;

    -- Mendapatkan ID baru dari tabel registrasi
    SET new_id = (SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'registrasi');

    -- Mendapatkan bulan dalam format romawi
    SET roman_month = CASE
        WHEN MONTH(CURDATE()) = 1 THEN 'I'
        WHEN MONTH(CURDATE()) = 2 THEN 'II'
        WHEN MONTH(CURDATE()) = 3 THEN 'III'
        WHEN MONTH(CURDATE()) = 4 THEN 'IV'
        WHEN MONTH(CURDATE()) = 5 THEN 'V'
        WHEN MONTH(CURDATE()) = 6 THEN 'VI'
        WHEN MONTH(CURDATE()) = 7 THEN 'VII'
        WHEN MONTH(CURDATE()) = 8 THEN 'VIII'
        WHEN MONTH(CURDATE()) = 9 THEN 'IX'
        WHEN MONTH(CURDATE()) = 10 THEN 'X'
        WHEN MONTH(CURDATE()) = 11 THEN 'XI'
        WHEN MONTH(CURDATE()) = 12 THEN 'XII'
    END;

    -- Mendapatkan tahun saat ini dan tahun sebelumnya
    SET current_year = YEAR(CURDATE());
    SET last_year = (SELECT MAX(YEAR(CURDATE())) FROM registrasi);

    -- Cek apakah tahun saat ini berbeda dengan tahun sebelumnya
    IF current_year <> last_year THEN
        SET new_id = 1; -- Jika berbeda, reset ID ke 1
    END IF;

    -- Mengatur nomor registrasi dengan format yang diinginkan
    SET NEW.nomer_registrasi = CONCAT(LPAD(new_id, 4, '0'), '/PPID-Jateng/', roman_month, '/', current_year);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `survey_kepuasan`
--

CREATE TABLE `survey_kepuasan` (
  `id` int(255) NOT NULL,
  `nomer_registrasi` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `usia` varchar(255) NOT NULL,
  `pendidikan` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `jenis_layanan` varchar(255) NOT NULL,
  `persyaratan` varchar(255) NOT NULL,
  `SaranPersyaratanPermohonanInformasi` varchar(255) DEFAULT NULL,
  `prosedur` varchar(255) NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `saran_waktu` varchar(255) DEFAULT NULL,
  `biaya` varchar(255) NOT NULL,
  `saran_biaya` varchar(255) DEFAULT NULL,
  `hasil` varchar(255) NOT NULL,
  `saran_hasil` varchar(255) DEFAULT NULL,
  `kompetensi` varchar(255) NOT NULL,
  `saran_kompetensi` varchar(255) DEFAULT NULL,
  `perilaku` varchar(255) NOT NULL,
  `saran_perilaku` varchar(255) DEFAULT NULL,
  `sarana` varchar(255) NOT NULL,
  `saran_sarana` varchar(255) DEFAULT NULL,
  `pelayanan` varchar(255) NOT NULL,
  `saran_pelayanan` varchar(255) DEFAULT NULL,
  `petugas` varchar(255) NOT NULL,
  `saran_petugas` varchar(255) DEFAULT NULL,
  `tanggal_survey` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_kepuasan_keberatan`
--

CREATE TABLE `survey_kepuasan_keberatan` (
  `id` int(255) NOT NULL,
  `nomer_registrasi_keberatan` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `usia` varchar(255) NOT NULL,
  `pendidikan` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `jenis_layanan` varchar(255) NOT NULL,
  `persyaratan` varchar(255) NOT NULL,
  `SaranPersyaratanPermohonanInformasi` varchar(255) DEFAULT NULL,
  `prosedur` varchar(255) NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `saran_waktu` varchar(255) DEFAULT NULL,
  `biaya` varchar(255) NOT NULL,
  `saran_biaya` varchar(255) DEFAULT NULL,
  `hasil` varchar(255) NOT NULL,
  `saran_hasil` varchar(255) DEFAULT NULL,
  `kompetensi` varchar(255) NOT NULL,
  `saran_kompetensi` varchar(255) DEFAULT NULL,
  `perilaku` varchar(255) NOT NULL,
  `saran_perilaku` varchar(255) DEFAULT NULL,
  `sarana` varchar(255) NOT NULL,
  `saran_sarana` varchar(255) DEFAULT NULL,
  `pelayanan` varchar(255) NOT NULL,
  `saran_pelayanan` varchar(255) DEFAULT NULL,
  `petugas` varchar(255) NOT NULL,
  `saran_petugas` varchar(255) DEFAULT NULL,
  `tanggal_survey` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_daftar_opd`
--

CREATE TABLE `tbl_daftar_opd` (
  `id_opd` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat_opd` varchar(255) NOT NULL,
  `email_opd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_daftar_opd`
--

INSERT INTO `tbl_daftar_opd` (`id_opd`, `nama`, `alamat_opd`, `email_opd`) VALUES
(1, 'BADAN KEPEGAWAIAN DAERAH', 'Jl. Stadion Selatan No. 1, Semarang 50136', 'bkd@jatengprov.go.id'),
(2, 'BADAN KESATUAN BANGSA DAN POLITIK', 'Jl. Ahmad Yani No.160, Karangkidul, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50136', 'info@kesbangpol.jatengprov.go.id'),
(3, 'BADAN PENGELOLA KEUANGAN DAN ASET DAERAH', 'Jalan Sriwijaya No. 29 Tegalsari, Kec. Candisari, Kota Semarang, Jawa Tengah 50614', 'bpkad@jatengprov.go.id'),
(4, 'BADAN PENGELOLA PENDAPATAN DAERAH', 'Jl. Pemuda No 1\r\nSemarang\r\nJawa Tengah - Indonesia\r\nTelp. (024) 3515514\r\nFax (024) 3555704\r\nPIC +6281126716', 'bapenda@jatengprov.go.id'),
(5, 'BADAN PENGEMBANGAN SUMBER DAYA MANUSIA DAERAH', 'Jl. Setia Budi No.201A, Srondol Kulon, Kec. Banyumanik, Kota Semarang, Jawa Tengah 50263', 'bpsdmd@jatengprov.go.id'),
(6, 'BADAN PENGHUBUNG', 'Jalan Dharmawangsa VIII No. 26  Kebayoran Baru, Jakarta Selatan 12150', 'badanpenghubungjateng@gmail.com'),
(7, 'BADAN PERENCANAAN PEMBANGUNAN DAERAH', 'Jl. Pemuda No.127-133, Sekayu, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50132', 'bappeda@jatengprov.go.id'),
(8, 'BADAN RISET DAN INOVASI DAERAH', 'Jl. Imam Bonjol No.190, Pendrikan Kidul, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50131', 'brida@jatengprov.go.id'),
(9, 'BIRO ADMINISTRASI PEMBANGUNAN DAERAH', 'Jalan pahlawan No.9, Kota Semarang', 'info@bangda.jatengprov.go.id'),
(10, 'BIRO ADMINISTRASI PENGADAAN BARANG/JASA', 'Biro Administrasi Pengadaan Barang Jasa Provinsi Jawa Tengah, Gedung D Kantor Gubernur Jawa Tengah, Jl. Pahlawan No.9, Mugassari, Semarang Selatan, Semarang City, Central Java 50243', 'biroapbj@jatengprov.go.id'),
(11, 'BIRO HUKUM', 'Gedung A Lantai 5, Jl. Pahlawan No.9 Semarang Jawa Tengah', 'rohukumjateng@gmail.com'),
(12, 'BIRO INFRASTRUKTUR DAN SUMBER DAYA ALAM', 'Jl. Pahlawan No. 9 Semarang 50249', 'biroisda@gmail.com'),
(13, 'BIRO KESEJAHTERAAN RAKYAT', 'Jalan Pahlawan No. 9 Semarang Kode Pos 50243', 'kesraprovjateng@gmail.com'),
(14, 'BIRO ORGANISASI', 'Jl. Pahlawan No.9, Mugassari, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50243', 'biroorganisasi@jatengprov.go.id'),
(15, 'BIRO PEMERINTAHAN, OTONOMI DAERAH DAN KERJASAMA', 'Jl. Pahlawan No.9, Mugassari, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50249', 'info@pemotdaks.jatengprov.go.id'),
(16, 'BIRO PEREKONOMIAN', 'Jl. Pahlawan No.9, Mugassari, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50249', 'biroperekonomian6@gmail.com'),
(17, 'BIRO UMUM', '2C49+FRQ, Mugassari, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50249', 'biroumum.provjateng@gmail.com'),
(18, 'DINAS ENERGI DAN SUMBER DAYA MINERAL', 'Jl. Madukoro AA-BB No.44 Semarang 50144\r\n', 'esdm@jatengprov.go.id'),
(19, 'DINAS KEARSIPAN DAN PERPUSTAKAAN', 'Jl. Dr. Setiabudi No 201C, Kode Pos 50263', 'dinas.arpusjateng@gmail.com'),
(20, 'DINAS KELAUTAN DAN PERIKANAN', 'Jl. Imam Bonjol No. 134 Semarang\r\nJawa Tengah, Indonesia 50132', 'dkpjateng@gmail.com'),
(21, 'DINAS KEPEMUDAAN, OLAHRAGA DAN PARIWISATA', 'Jl. Ki Mangunsarkoro No 12, Semarang', 'disporapar@jatengprov.go.id'),
(22, 'DINAS KESEHATAN', 'Jl. Piere Tendean No.24 Semarang 50131', 'dinkes@jatengprov.go.id'),
(23, 'DINAS KETAHANAN PANGAN', 'Jl. Gatot Subroto Komplek Pertanian Tarubudaya Ungaran Timur', 'dishanpan@jatengprov.go.id'),
(24, 'DINAS KOMUNIKASI DAN INFORMATIKA', 'Sekayu, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50132', 'diskominfo@semarangkota.go.id'),
(25, 'DINAS KOPERASI, USAHA KECIL DAN MENENGAH', 'Jl. Sisingamangaraja No. 3A Semarang, Jawa Tengah 50232', 'dinkopjateng@gmail.com'),
(26, 'DINAS LINGKUNGAN HIDUP DAN KEHUTANAN', 'Diklat, Jalan Setia Budi No.201 B, Srondol Kulon\r\nKec. Banyumanik, Kota Semarang, Jawa Tengah 50263', ''),
(27, 'DINAS PEKERJAAN UMUM BINA MARGA DAN CIPTA KARYA', 'Jl. Madukoro Blok AA-BB, Tawangmas, Kec. Semarang Barat, Kota Semarang, Provinsi Jawa Tengah, Kode Pos (50144)', 'dpubmck@gmail.com'),
(28, 'DINAS PEKERJAAN UMUM SUMBER DAYA AIR DAN PENATAAN RUANG', 'Jl. Madukoro Blok AA-BB Semarang 50144', 'dpusdataru@gmail.com'),
(29, 'DINAS PEMBERDAYAAN MASYARAKAT, DESA, KEPENDUDUKAN DAN PENCATATAN SIPIL', 'Jl. Menteri Supeno No.17, Semarang', 'dispermadesdukcapil@jatengprov.go.id'),
(30, 'DINAS PEMBERDAYAAN PEREMPUAN, PERLINDUNGAN ANAK, PENGENDALIAN PENDUDUK DAN KELUARGA BERENCANA', 'Jl. Pamularsih Raya No.28, Bongsari, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50148', 'dpppadaldukkb@jatengprov.go.id'),
(31, 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU', 'Jalan Mgr. Soegiyopranoto Nomor 1 Semarang Kode Pos 50131', 'dpmptsp@jatengprov.go.id'),
(32, 'DINAS PENDIDIKAN DAN KEBUDAYAAN', 'Jl. Pemuda No.134, Sekayu, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah', 'disdikbud@jatengprov.go.id'),
(33, 'DINAS PERHUBUNGAN', 'JL. Siliwangi, No. 355 - 357, Krapyak, Semarang Barat, Kota Semarang, Jawa Tengah', 'perhubungan@jatengprov.go.id'),
(34, 'DINAS PERINDUSTRIAN DAN PERDAGANGAN', 'Jl. Pahlawan No.4, Pleburan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50241', 'dinperindag@jatengprov.go.id'),
(35, 'DINAS PERTANIAN DAN PERKEBUNAN', 'Komplek, Tarubudaya, Jl. Tarubudaya Jl. Jenderal Gatot Subroto, Bandarjo, Kec. Ungaran Bar., Kabupaten Semarang, Jawa Tengah 50517', 'distanbun@jatengprov.go.id'),
(36, 'DINAS PERUMAHAN RAKYAT DAN KAWASAN PERMUKIMAN', 'Jalan Madukoro Blok AA-BB Komplek PRPP Semarang Kode Pos 50144', 'disperakim@jatengprov.go.id'),
(37, 'DINAS PETERNAKAN DAN KESEHATAN HEWAN', 'VCR7+3VR, JL. Jenderal Gatot Soebroto, Tarubudaya, Ungaran, Central Java, Tarubudaya, Bandarjo, Ungaran Barat, Semarang Regency, Central Java 50517', '	disnakkeswan@jatengprov.go.id'),
(38, 'DINAS SOSIAL', 'Jl. Pahlawan No.12, Pleburan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50241', 'dinsos@jatengprov.go.id'),
(39, 'DINAS TENAGA KERJA DAN TRANSMIGRASI', 'Jl. Pahlawan No.16, Pleburan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50241', 'disnakertrans@jatengprov.go.id'),
(40, 'GUBERNUR JAWA TENGAH', 'Jl. Pahlawan No.9, Mugassari, Semarang Sel., Kota Semarang, Jawa Tengah 50249', 'ppid@jatengprov.go.id'),
(41, 'INSPEKTORAT', 'Jl. Pemuda No.127-133, Sekayu, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50132', 'inspektorat@jatengprov.go.id'),
(42, 'KOMISI IRIGASI PROVINSI JAWA TENGAH', 'Jl. Madukoro Blok AA-BB Semarang 50144', 'pusdataru@jatengprov.go.id'),
(43, 'KOMITE OLAHRAGA NASIONAL INDONESIA PROVINSI JAWA TENGAH', 'Komplek “GOR JATIDIRI” Karangrejo,\r\nSemarang 50234', 'konijateng@gmail.com'),
(44, 'RUMAH SAKIT JIWA DAERAH AMINO GONDOHUTOMO', 'Jl. Brigjen Sudiarto No.347\r\nPalebon, Pedurungan, Kota Semarang, Jawa Tengah\r\nKode Pos 50246, Indonesia', 'amino@jatengprov.go.id'),
(45, 'RUMAH SAKIT JIWA DAERAH Dr. AMINO GONDOHUTOMO', 'Jl. Brigjen Sudiarto No.347, Gemah, Kec. Pedurungan, Kota Semarang, Jawa Tengah 50611', 'amino@jatengprov.go.id'),
(46, 'RUMAH SAKIT JIWA DAERAH Dr. ARIF ZAINUDIN', 'Jl. Ki Hajar Dewantoro No. 80 Jebres Surakarta 57126', 'rsjsurakarta@jatengprov.go.id'),
(47, 'RUMAH SAKIT JIWA DAERAH DR. RM. SOEDJARWADI', 'Jl. Ki Pandanaran No.KM. 2, Senden, Danguran, Kec. Klaten Sel., Kabupaten Klaten, Jawa Tengah 57426', 'soedjarwadi@jatengprov.go.id'),
(48, 'RUMAH SAKIT JIWA DAERAH SURAKARTA', 'Jl. Ki Hajar Dewantara No.80, Jebres, Kec. Jebres, Kota Surakarta, Jawa Tengah 57126', 'rsjsurakarta@jatengprov.go.id'),
(49, 'RUMAH SAKIT UMUM DAERAH dr. ADHYATMA, MPH', 'Jl. Walisongo KM 8,5 No. 137 Semarang, Jawa Tengah', 'tugurejo@jatengprov.go.id'),
(50, 'RUMAH SAKIT UMUM DAERAH DR. MOEWARDI', 'Jl. Kolonel Sutarto No.132, Jebres, Kec. Jebres, Kota Surakarta, Jawa Tengah 57126', 'rsmoewardi@jatengprov.go.id'),
(51, 'RUMAH SAKIT UMUM DAERAH Dr. REHATTA', 'Jalan Raya Kelet - Jepara KM 37 Jepara', 'rskelet@jatengprov.go.id'),
(52, 'RUMAH SAKIT UMUM DAERAH KELET', 'Jl. Raya Kelet-Jepara No.Km.37, Karang Anyar, Kelet, Kec. Keling, Kabupaten Jepara, Jawa Tengah 59454', 'rskelet@jatengprov.go.id'),
(53, 'RUMAH SAKIT UMUM DAERAH PROF. DR. MARGONO SOEKARJO', 'Jl. Dr. Gumbreg No.1, Kebontebu, Berkoh, Kec. Purwokerto Sel., Kabupaten Banyumas, Jawa Tengah 53146', 'rsmargono@jatengprov.go.id'),
(54, 'RUMAH SAKIT UMUM DAERAH TUGUREJO', 'Jl. Walisongo KM 8,5 No.137, Tambakaji, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50185', 'tugurejo@jatengprov.go.id'),
(55, 'SATUAN POLISI PAMONG PRAJA', 'Jl. Imam Bonjol No. 154-160 Semarang', 'satpolpp@jatengprov.go.id'),
(56, 'SEKRETARIAT BADAN PENANGGULANGAN BENCANA DAERAH', 'Jl. Imam Bonjol 15, Dadapsari, Kec. Semarang Utara, Kota Semarang, Jawa Tengah 50173', 'bpbd@jatengprov.go.id'),
(57, 'SEKRETARIAT DPRD', 'Jl. Pahlawan No.7, Mugassari, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50249', 'setwan.dprd@jatengprov.go.id'),
(58, 'SEKRETARIS DAERAH', 'Jl. Pahlawan No. 9, Mugassari, Semarang Selatan, Jawa Tengah, Kode Pos 50243', 'setda@jatengprov.go.id'),
(59, 'WAKIL GUBERNUR JAWA TENGAH', 'Jl. Pahlawan No.9, Mugassari, Semarang Sel., Kota Semarang, Jawa Tengah 50249', 'ppid@jatengprov.go.id'),
(60, 'TESTING DEV', 'TESTING  DEVELOPER V1', 'tegar2000018243@webmail.uad.ac.id'),
(62, 'RAHMATIKA KUSUMA WARDANI ', 'cantiqqqqqqq', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penolakan`
--

CREATE TABLE `tbl_penolakan` (
  `id` int(100) NOT NULL,
  `nomer_registrasi_keberatan` varchar(255) NOT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `tanggal_penolakan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rejected`
--

CREATE TABLE `tbl_rejected` (
  `id` int(100) NOT NULL,
  `nomer_registrasi` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `tanggal_penolakan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `id` int(10) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`id`, `nama_pengguna`, `username`, `password`, `role`) VALUES
(1, 'Master Admin PPID', 'ppidutama.jateng@gmail.com', '$2y$10$Vu3Vio/gyiggpMsj6BW8x.pV3TImu.y4xF1qvcVL11KhywQKzSMlm', 'superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi_keberatan`
--

CREATE TABLE `verifikasi_keberatan` (
  `id` int(100) NOT NULL,
  `nomer_registrasi_keberatan` varchar(255) NOT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `tanggal_permohonan` varchar(255) NOT NULL,
  `nik_pemohon` varchar(255) NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `opd_yang_dituju` varchar(255) NOT NULL,
  `informasi_yang_diminta` varchar(255) NOT NULL,
  `alasan_keberatan` varchar(255) NOT NULL,
  `nama_kuasa` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `surat_kuasa` varchar(255) NOT NULL,
  `id_permohonan` varchar(255) NOT NULL,
  `email_pemohon` varchar(255) NOT NULL,
  `foto_ktp_pemohon` varchar(255) NOT NULL,
  `tanggal_verifikasi` timestamp NOT NULL DEFAULT current_timestamp(),
  `nomer_registrasi_permohonan` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi_permohonan`
--

CREATE TABLE `verifikasi_permohonan` (
  `id` int(11) NOT NULL,
  `nomer_registrasi` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `tanggal_permohonan` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `informasi_yang_dibutuhkan` varchar(255) NOT NULL,
  `alasan_pengguna_informasi` varchar(255) NOT NULL,
  `id_permohonan` int(11) NOT NULL,
  `tanggal_verifikasi` timestamp NOT NULL DEFAULT current_timestamp(),
  `opd_yang_dituju` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer_admin`
--
ALTER TABLE `answer_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keberatananswer_admin`
--
ALTER TABLE `keberatananswer_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `note_admin`
--
ALTER TABLE `note_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi_pengiriman`
--
ALTER TABLE `notifikasi_pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi_pengiriman_keberatan`
--
ALTER TABLE `notifikasi_pengiriman_keberatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan_keberatan`
--
ALTER TABLE `pengajuan_keberatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_informasi`
--
ALTER TABLE `permohonan_informasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_kepuasan`
--
ALTER TABLE `survey_kepuasan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_kepuasan_keberatan`
--
ALTER TABLE `survey_kepuasan_keberatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_daftar_opd`
--
ALTER TABLE `tbl_daftar_opd`
  ADD PRIMARY KEY (`id_opd`);

--
-- Indexes for table `tbl_penolakan`
--
ALTER TABLE `tbl_penolakan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rejected`
--
ALTER TABLE `tbl_rejected`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verifikasi_keberatan`
--
ALTER TABLE `verifikasi_keberatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verifikasi_permohonan`
--
ALTER TABLE `verifikasi_permohonan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer_admin`
--
ALTER TABLE `answer_admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `keberatananswer_admin`
--
ALTER TABLE `keberatananswer_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `note_admin`
--
ALTER TABLE `note_admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifikasi_pengiriman`
--
ALTER TABLE `notifikasi_pengiriman`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notifikasi_pengiriman_keberatan`
--
ALTER TABLE `notifikasi_pengiriman_keberatan`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pengajuan_keberatan`
--
ALTER TABLE `pengajuan_keberatan`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `permohonan_informasi`
--
ALTER TABLE `permohonan_informasi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT for table `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `survey_kepuasan`
--
ALTER TABLE `survey_kepuasan`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `survey_kepuasan_keberatan`
--
ALTER TABLE `survey_kepuasan_keberatan`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_daftar_opd`
--
ALTER TABLE `tbl_daftar_opd`
  MODIFY `id_opd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tbl_penolakan`
--
ALTER TABLE `tbl_penolakan`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_rejected`
--
ALTER TABLE `tbl_rejected`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `verifikasi_keberatan`
--
ALTER TABLE `verifikasi_keberatan`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
