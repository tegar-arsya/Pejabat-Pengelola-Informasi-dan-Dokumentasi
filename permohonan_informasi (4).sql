-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 03:39 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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

--
-- Dumping data for table `answer_admin`
--

INSERT INTO `answer_admin` (`id`, `nama_pic`, `jawaban_permohonan`, `lampiran`, `tanggal_jawaban`, `nik_pemohon`, `nomer_registrasi_pemohon`, `status_balasan`) VALUES
(26, 'SUPER ADMIN', 'berikut jawaban anda', 'Desain tanpa judul.pdf', '2023-12-24 10:14:27', '3315182709010001', '0370/PPID-Jateng/XII/2023', 'Jawaban permohonan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat permohonan sesuai dengan nomer registrasi permohonan anda untuk mengunduh jawaban permohonan.'),
(27, 'SUPER ADMIN', 'FH', 'Desain tanpa judul.pdf', '2023-12-25 04:38:16', '3315182709010001', '0367/PPID-Jateng/XII/2023', 'Jawaban permohonan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat permohonan sesuai dengan nomer registrasi permohonan anda untuk mengunduh jawaban permohonan.'),
(28, 'SUPER ADMIN', 'iii', 'Desain tanpa judul.pdf', '2024-01-02 01:17:07', '3315182709010001', '0375/PPID-Jateng/XII/2023', 'Jawaban permohonan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat permohonan sesuai dengan nomer registrasi permohonan anda untuk mengunduh jawaban permohonan.');

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

--
-- Dumping data for table `keberatananswer_admin`
--

INSERT INTO `keberatananswer_admin` (`id`, `nama_pic`, `jawaban_keberatan`, `lampiran`, `nik_pemohon`, `nomer_registrasi_keberatan`, `status_balasan`, `tanggal`) VALUES
(7, 'SUPER ADMIN ', 'sasfdgdg', 'Desain tanpa judul.pdf', '3315182709010001', '0034/KEBERATAN/XII/2023', 'Jawaban keberatan informasi sudah kami kirimkan, silahkan masuk ke halaman riwayat keberatan sesuai dengan nomer registrasi keberatan anda untuk mengunduh jawaban keberatan anda. ', '2023-12-25 03:54:16');

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

--
-- Dumping data for table `notifikasi_pengiriman`
--

INSERT INTO `notifikasi_pengiriman` (`id`, `nomer_registrasi`, `nama_pengguna`, `opd_yang_dituju`, `status`, `tanggal_masuk`) VALUES
(25, '0369/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', 'TESTING DEV', 'Permohonan diposisikan ke TESTING DEV', '2023-12-24 05:09:06'),
(27, '0370/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', 'TESTING DEV', 'Permohonan diposisikan ke TESTING DEV', '2023-12-24 09:36:53'),
(28, '0367/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', 'TESTING DEV', 'Permohonan diposisikan ke TESTING DEV', '2023-12-25 04:37:45'),
(29, '0375/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', 'TESTING DEV', 'Permohonan diposisikan ke TESTING DEV', '2024-01-02 01:16:23');

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

--
-- Dumping data for table `notifikasi_pengiriman_keberatan`
--

INSERT INTO `notifikasi_pengiriman_keberatan` (`id`, `nomer_registrasi_keberatan`, `nik_pemohon`, `nama_pemohon`, `opd_yang_dituju`, `status`, `tanggal`) VALUES
(17, '0034/KEBERATAN/XII/2023', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'Permohonan Keberatan Informasi telah dikirim ke TESTING DEV', '2023-12-25 03:26:09');

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
-- Dumping data for table `pengajuan_keberatan`
--

INSERT INTO `pengajuan_keberatan` (`id`, `nomer_registrasi_keberatan`, `kode_permohonan_informasi`, `informasi_yang_diminta`, `kuasa_permohonan`, `nama_pemohon`, `nama`, `email`, `nik`, `no_hp`, `foto_ktp`, `alamat`, `kota_kabupaten`, `negara`, `kode_pos`, `provinsi`, `opd_yang_dituju`, `pekerjaan`, `unggah_surat_kuasa`, `alasan_keberatan`, `tanggal_pengajuan`, `tanggal_permohonan`, `nik_pemohon`, `email_pemohon`, `foto_ktp_pemohon`) VALUES
(34, '0034/KEBERATAN/XII/2023', '0362/PPID-Jateng/XII/2023', 'testting selasa 5 desember', 'Perorangan', 'TEGAR ARSYADANI', 'RAHMATIKA KUSUMA WARDANI', 'tegararsyadani0117@gmail.com', '1111', '12333333333', 'tg.jpg', 'pilang', 'KABUPATEN DEMAK', 'Indonesia', '12345', 'JAWA TENGAH', 'TESTING DEV', 'konsultan psikolog', 'CamScanner 24-09-2023 13.02(1).pdf', 'Informasi berkala tidak disediakan', '2023-12-14 06:38:09', '2023-12-05 11:17:23', '3315182709010001', 'tegararsya0117@gmail.com', '2021_10_21_21_17_IMG_1375.JPG'),
(35, '0035/KEBERATAN/XII/2023', '0368/PPID-Jateng/XII/2023', 'sebagai penelitian untuk skripsi', 'Perorangan', 'RAHMATIKA  KUSUMA WARDHANI', 'TEGAR ARSYADANI', 'tegararsya0117@gmail.com', '3315182709010001', '081353677822', 'White Green Watercolor Brush Typography Logo.png', 'curug', 'KABUPATEN GROBOGAN', 'Indonesia', '58165', 'JAWA TENGAH', 'TESTING DEV', 'Programmer', 'Desain tanpa judul.pdf', 'Informasi disampaikan melebihi jangka waktu yang ditentukan', '2023-12-19 04:30:40', '2023-12-13 14:00:50', '00', 'tegararsyadani0117@gmail.com', '2021_10_21_21_17_IMG_1375.JPG'),
(36, '0036/KEBERATAN/XII/2023', '0369/PPID-Jateng/XII/2023', 'rekap data permohonan informasi jateng tahun 2023', 'Perorangan', 'TEGAR ARSYADANI', 'RAHMATIKA KUSUMA WARDANI', 'tegararsyadani0117@gmail.com', '3315182709010001', '1111111111111', 'Desain tanpa judul.pdf', 'tegfefesf', 'KABUPATEN BEKASI', 'Indonesia', '123456', 'JAWA BARAT', 'TESTING DEV', 'Programmer', 'Desain tanpa judul.pdf', 'Permintaan informasi tidak ditanggapi', '2023-12-21 05:20:47', '2023-12-21 11:28:51', '3315182709010001', 'tegararsya0117@gmail.com', '2021_10_21_21_17_IMG_1375.JPG');

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
(361, '0361/PPID-Jateng/XII/2023', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'test', 'tes1', 'Melihat/Membaca/Mendengarkan/Mencatat', 'Mengambil Langsung', NULL, '2023-12-05 04:04:45'),
(362, '0362/PPID-Jateng/XII/2023', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'testting selasa 5 desember', 'testing again 5 desember', 'Melihat/Membaca/Mendengarkan/Mencatat', 'Mengambil Langsung', NULL, '2023-12-05 04:17:23'),
(363, '0363/PPID-Jateng/XII/2023', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'm', 'z', 'Melihat/Membaca/Mendengarkan/Mencatat', 'Mengambil Langsung', NULL, '2023-12-05 04:49:15'),
(364, '0364/PPID-Jateng/XII/2023', '33151827', 'Anggi Meidamara', 'TESTING DEV', 'data', 'data', 'Melihat/Membaca/Mendengarkan/Mencatat', 'Mengambil Langsung', NULL, '2023-12-05 07:21:23'),
(365, '0365/PPID-Jateng/XII/2023', '33151827', 'Anggi Meidamara', 'TESTING DEV', 'affef', 'efefef', 'Melihat/Membaca/Mendengarkan/Mencatat', 'Mengambil Langsung', NULL, '2023-12-05 07:21:52'),
(367, '0367/PPID-Jateng/XII/2023', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'dvvssv', 'dsvdvdvdvdv', 'Melihat/Membaca/Mendengarkan/Mencatat', 'Kurir / Pos', NULL, '2023-12-13 04:42:00'),
(368, '0368/PPID-Jateng/XII/2023', '00', 'RAHMATIKA  KUSUMA WARDHANI', 'TESTING DEV', 'sebagai penelitian untuk skripsi', 'sebagai data penguat skripsi', 'Mendapatkan Salinan Informasi Softcopy', 'Mengambil Langsung', NULL, '2023-12-13 07:00:50'),
(369, '0369/PPID-Jateng/XII/2023', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'rekap data permohonan informasi jateng tahun 2023', 'skripsi', 'Mendapatkan Salinan Informasi Softcopy', 'Email', NULL, '2023-12-21 04:28:51'),
(370, '0370/PPID-Jateng/XII/2023', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'rekap data tahun 2023', 'sebagai skrpisi', 'Mendapatkan Salinan Informasi Hardcopy', 'Kurir / Pos', 'update', '2023-12-21 04:31:07'),
(374, '0374/PPID-Jateng/XII/2023', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'laporan ', 'lapor', 'Mendapatkan Salinan Informasi Hardcopy', 'Faximile', NULL, '2023-12-27 04:09:53'),
(375, '0375/PPID-Jateng/XII/2023', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'dvdvddvcdcdssvddvdvdv', 'vdvdvdvwvwevlewdas edc', 'Mendapatkan Salinan Informasi Hardcopy', 'Kurir / Pos', NULL, '2023-12-28 01:33:21'),
(376, '0376/PPID-Jateng/I/2024', '3315182709010001', 'TEGAR ARSYADANI', 'TESTING DEV', 'efefefsdsdsds', 'ffs', 'Mendapatkan Salinan Informasi Hardcopy', 'Kurir / Pos', NULL, '2024-01-01 07:05:19');

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
(47, '0047/PPID-Jateng/XI/2023', 'TEGAR', 'ARSYADANI', 'Perorangan', 'KTP', '3315182709010001', '081353677822', '2021_10_21_21_17_IMG_1375.JPG', 'tidak punya', 'ASN/PNS/POLRI', 'desa Curug', 'Kabupaten Banjarnegara', 'Nanggroe Aceh Darussalam', 'Indonesia', 58165, 'tegararsya0117@gmail.com', '$2y$10$UPEbhG838yEm4/XCgTo8zuXrXvuvQo20.bYn1J.COBflGUDyeFug.', '2023-11-09 07:23:01', ''),
(49, '0049/PPID-Jateng/XI/2023', 'Mokhammad Alfin', 'Alfaridzi', 'Perorangan', 'KTP', '1', '081215847069', 'WIN_20231024_13_41_58_Pro.jpg', 'tidak punya', 'ASN/PNS/POLRI', 'fe', 'Kota/Kabupaten Tidak Ditemukan', 'JAWA TENGAH', 'Indonesia', 58165, 'mokhammadalfaridzi18@gmail.com', '$2y$10$xwXe6rzeOQ9IrEZbFEh3uOrmkw5gyRFA1v9Ilc6OiEt5IfnNG5ObW', '2023-11-13 04:22:42', ''),
(53, '0053/PPID-Jateng/XI/2023', 'arsyadani', 'gokil', 'Perorangan', 'KTP', '0987654321', '081353677822', 'tumblr_mkcd2vQieD1rr8hnzo1_400.gif', 'tidak punya', 'Karyawan BUMN/BUMD', 'desa Curug', 'KOTA PALANGKA RAYA', 'KALIMANTAN TENGAH', 'Bolivia', 58165, 'tegar2000018243@webmail.uad.ac.id', '$2y$10$DrNDYIlzSX/677DRjRbzQOSJgBV3sKAFE1wbDRt.Da7vbFnsZDCo.', '2023-11-18 05:15:04', ''),
(54, '0054/PPID-Jateng/XI/2023', 'Anggi', 'Meidamara', 'Perorangan', 'KTP', '33151827', '12345667', 'Screenshot 2023-11-27 143348.png', '1123', 'ASN/PNS/POLRI', 'semarang', 'KABUPATEN SEMARANG', 'JAWA TENGAH', 'Indonesia', 12345, 'ppid.diskominfo.jtg@gmail.com', '$2y$10$9Lk6JsUY6NbMnIk3e.BfT.ehYWe5JCHs3/JpI4f/M.E5mVf5NJWQa', '2023-11-29 07:40:04', ''),
(55, '0055/PPID-Jateng/XI/2023', 'RAHMATIKA ', 'KUSUMA WARDHANI', 'Perorangan', 'KTP', '00', '00', '2021_10_21_21_17_IMG_1375.JPG', '1123', 'Mahasiswa/Pelajar', 'pilang', 'KABUPATEN DEMAK', 'JAWA TENGAH', 'Indonesia', 12345, 'tegararsyadani0117@gmail.com', '$2y$10$6tgDZAIfrU2TMW5/6R78T.tV/txfk0ciiIrPE5GhVNMtLjxSmCAIu', '2023-12-13 06:59:44', 'ea902a533201d912237b78c635c02826275186c3a86e795c1bb5ba9d51d81ff3');

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

--
-- Dumping data for table `survey_kepuasan`
--

INSERT INTO `survey_kepuasan` (`id`, `nomer_registrasi`, `nama_pengguna`, `usia`, `pendidikan`, `pekerjaan`, `jenis_layanan`, `persyaratan`, `SaranPersyaratanPermohonanInformasi`, `prosedur`, `waktu`, `saran_waktu`, `biaya`, `saran_biaya`, `hasil`, `saran_hasil`, `kompetensi`, `saran_kompetensi`, `perilaku`, `saran_perilaku`, `sarana`, `saran_sarana`, `pelayanan`, `saran_pelayanan`, `petugas`, `saran_petugas`, `tanggal_survey`) VALUES
(95, '0370/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', '23 tahun', 'S2 Keatas', 'Wiraswasta / Usahawan', 'Aduan LaporGub', '2', '', '1', '3', '', '3', '', '3', '', '2', '', '3', '', '3', '', '4', '', '4', '', '2023-12-24 10:42:00'),
(96, '0367/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', '1010 tahun guys', 'S2 Keatas', 'Wiraswasta / Usahawan', 'Layanan Informasi melalui PPID Provinsi, Layanan Informasi melalui PPID Pelaksana, Aduan LaporGub', '4', '', '1', '3', '', '2', '', '2', '', '3', '', '4', '', '4', '', '3', '', '3', '', '2023-12-25 04:39:09');

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

--
-- Dumping data for table `survey_kepuasan_keberatan`
--

INSERT INTO `survey_kepuasan_keberatan` (`id`, `nomer_registrasi_keberatan`, `nama_pengguna`, `usia`, `pendidikan`, `pekerjaan`, `jenis_layanan`, `persyaratan`, `SaranPersyaratanPermohonanInformasi`, `prosedur`, `waktu`, `saran_waktu`, `biaya`, `saran_biaya`, `hasil`, `saran_hasil`, `kompetensi`, `saran_kompetensi`, `perilaku`, `saran_perilaku`, `sarana`, `saran_sarana`, `pelayanan`, `saran_pelayanan`, `petugas`, `saran_petugas`, `tanggal_survey`) VALUES
(1, '0034/KEBERATAN/XII/2023', 'TEGAR ARSYADANI', '23 tahun', 'SLTA', 'Lainnya', 'Layanan Informasi melalui PPID Pelaksana, Aduan LaporGub', '4', '', '1', '3', '', '3', '', '4', '', '4', '', '4', '', '4', '', '4', '', '4', '', '2023-12-25 04:35:02');

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

--
-- Dumping data for table `tbl_rejected`
--

INSERT INTO `tbl_rejected` (`id`, `nomer_registrasi`, `nama_pengguna`, `note`, `tanggal_penolakan`) VALUES
(48, '0365/PPID-Jateng/XII/2023', 'Anggi Meidamara', '', '2023-12-05 07:41:36'),
(55, '0361/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', 'data tidak lengkapi. silahkan mengisi formulir lagi                         ', '2023-12-25 03:12:23');

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
(8, 'PPID UTAMA', 'ppidutama.jateng@gmail.com', '$2y$10$39AsRWi4F3pvVZAoWtBQ5udeS1.xy5J9Xjh5ysdVGhFIVDXXzAEqK', 'superadmin');

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

--
-- Dumping data for table `verifikasi_keberatan`
--

INSERT INTO `verifikasi_keberatan` (`id`, `nomer_registrasi_keberatan`, `nama_pemohon`, `tanggal_permohonan`, `nik_pemohon`, `foto_ktp`, `opd_yang_dituju`, `informasi_yang_diminta`, `alasan_keberatan`, `nama_kuasa`, `pekerjaan`, `surat_kuasa`, `id_permohonan`, `email_pemohon`, `foto_ktp_pemohon`, `tanggal_verifikasi`, `nomer_registrasi_permohonan`, `status`) VALUES
(32, '0034/KEBERATAN/XII/2023', 'TEGAR ARSYADANI', '2023-12-05 11:17:23', '3315182709010001', 'tg.jpg', 'TESTING DEV', 'testting selasa 5 desember', 'Informasi berkala tidak disediakan', 'RAHMATIKA KUSUMA WARDANI', 'konsultan psikolog', 'CamScanner 24-09-2023 13.02(1).pdf', '34', 'tegararsya0117@gmail.com', '2021_10_21_21_17_IMG_1375.JPG', '2023-12-25 03:25:57', '0362/PPID-Jateng/XII/2023', 'Permohonan Selesai');

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
-- Dumping data for table `verifikasi_permohonan`
--

INSERT INTO `verifikasi_permohonan` (`id`, `nomer_registrasi`, `nama_pengguna`, `tanggal_permohonan`, `nik`, `foto_ktp`, `email`, `no_hp`, `alamat`, `informasi_yang_dibutuhkan`, `alasan_pengguna_informasi`, `id_permohonan`, `tanggal_verifikasi`, `opd_yang_dituju`, `status`) VALUES
(166, '0369/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', '2023-12-21 11:28:51', '3315182709010001', '2021_10_21_21_17_IMG_1375.JPG', 'tegararsya0117@gmail.com', '081353677822', 'desa Curug', 'rekap data permohonan informasi jateng tahun 2023', 'skripsi', 369, '2023-12-24 05:08:50', 'TESTING DEV', 'Pengajuan Keberatan'),
(168, '0370/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', '2023-12-21 11:31:07', '3315182709010001', '2021_10_21_21_17_IMG_1375.JPG', 'tegararsya0117@gmail.com', '081353677822', 'desa Curug', 'rekap data tahun 2023', 'sebagai skrpisi', 370, '2023-12-24 09:36:13', 'TESTING DEV', 'Permohonan Selesai'),
(169, '0361/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', '2023-12-05 11:04:45', '3315182709010001', '2021_10_21_21_17_IMG_1375.JPG', 'tegararsya0117@gmail.com', '081353677822', 'desa Curug', 'test', 'tes1', 361, '2023-12-25 03:12:24', 'TESTING DEV', 'Gugur'),
(170, '0367/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', '2023-12-13 11:42:00', '3315182709010001', '2021_10_21_21_17_IMG_1375.JPG', 'tegararsya0117@gmail.com', '081353677822', 'desa Curug', 'dvvssv', 'dsvdvdvdvdv', 367, '2023-12-25 04:37:24', 'TESTING DEV', 'Permohonan Selesai'),
(171, '0375/PPID-Jateng/XII/2023', 'TEGAR ARSYADANI', '2023-12-28 08:33:21', '3315182709010001', '2021_10_21_21_17_IMG_1375.JPG', 'tegararsya0117@gmail.com', '081353677822', 'desa Curug', 'dvdvddvcdcdssvddvdvdv', 'vdvdvdvwvwevlewdas edc', 375, '2024-01-02 01:16:12', 'TESTING DEV', 'Permohonan informasi Sudah Diverifikasi Oleh Admin.');

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=377;

--
-- AUTO_INCREMENT for table `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `verifikasi_keberatan`
--
ALTER TABLE `verifikasi_keberatan`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `verifikasi_permohonan`
--
ALTER TABLE `verifikasi_permohonan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
