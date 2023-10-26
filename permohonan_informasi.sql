-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2023 at 03:34 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama_pengguna`, `username`, `password`) VALUES
(4, 'Master Admin PPID', 'ppidjateng@gmail.com', '$2y$10$/N.na0CW8qWaf/jCRus8Du0FxngevyENh48Y9zG4tM1SFchC0GPka');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_keberatan`
--

CREATE TABLE `pengajuan_keberatan` (
  `id` int(100) NOT NULL,
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
  `odp_yang_dituju` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `unggah_surat_kuasa` varchar(255) NOT NULL,
  `alasan_keberatan` varchar(255) NOT NULL,
  `tanggal_pengajuan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_informasi`
--

CREATE TABLE `permohonan_informasi` (
  `id` int(255) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `opd_yang_dituju` varchar(255) NOT NULL,
  `informasi_yang_dibutuhkan` varchar(255) NOT NULL,
  `alasan_pengguna_informasi` varchar(255) NOT NULL,
  `cara_mendapatkan_informasi` varchar(255) NOT NULL,
  `cara_mendapatkan_salinan` varchar(255) NOT NULL,
  `tanggal_permohonan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permohonan_informasi`
--

INSERT INTO `permohonan_informasi` (`id`, `id_user`, `nama_pengguna`, `opd_yang_dituju`, `informasi_yang_dibutuhkan`, `alasan_pengguna_informasi`, `cara_mendapatkan_informasi`, `cara_mendapatkan_salinan`, `tanggal_permohonan`) VALUES
(220, '3315182709010001', 'TEGAR ARSYADANI', 'Sekretaris Daerah Provinsi Jawa Tengah', 'rekap data 2020 sampai 2022', 'sebagai presentasi', 'Melihat/Membaca/Mendengarkan/Mencatat', 'Email', '2023-10-25 04:33:44'),
(221, '3374101004020005', 'rahmatika kusumawardani', 'Direktur PT. Kawan Indutri Wijayakusuma', 'rekap data 2020 sampai 2022', 'sebagai penelitian untuk skripsi', 'Mendapatkan Salinan Informasi Hardcopy', 'Mengambil Langsung', '2023-10-25 04:38:09'),
(222, '3315182709010001', 'TEGAR ARSYADANI', 'Sekretaris Daerah Provinsi Jawa Tengah', 'anajyyy', 'mabar', 'Melihat/Membaca/Mendengarkan/Mencatat', 'Mengambil Langsung', '2023-10-25 14:19:32'),
(223, '3315182709010001', 'TEGAR ARSYADANI', 'Sekretaris Daerah Provinsi Jawa Tengah', 'golden', 'muncak', 'Melihat/Membaca/Mendengarkan/Mencatat', 'Mengambil Langsung', '2023-10-26 01:07:46');

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
  `kode_pos` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_registrasi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`id`, `nomer_registrasi`, `nama_depan`, `nama_belakang`, `jenis_nik`, `jenis_pemohon`, `nik`, `no_hp`, `foto_ktp`, `npwp`, `pekerjaan`, `alamat`, `kota_kabupaten`, `provinsi`, `kode_pos`, `email`, `password`, `tanggal_registrasi`) VALUES
(30, '0030/PI/2023', 'TEGAR', 'ARSYADANI', 'Perorangan', 'KTP', '3315182709010001', '081353677822', '2019_02_02_09_20_IMG_6746.JPG', 'tidak punya', 'Mahasiswa/Pelajar', 'Desa Curug Rt 03 Rw 02 Kecamatan Tegowanu Kabupaten Grobogan', 'Kabupaten Grobogan', 'Jawa Tengah', 58165, 'tegararsya0117@gmail.com', '$2y$10$yq7cDpdQp2KWYXWuu11tL.SZdN/QnWvEue0GcbulktozgJfY6fVie', '2023-10-24 07:57:30'),
(31, '0031/PI/2023', 'rahmatika', 'kusumawardani', 'Perorangan', 'KTP', '3374101004020005', '081353777777', '2021_03_18_00_29_IMG_7363.JPG', 'tidak punya', 'ASN/PNS/POLRI', 'pilang', 'Kabupaten Grobogan', 'Jawa Tengah', 58165, 'rahmatika@gmail.com', '$2y$10$Y.gvLOWG5sQJXvc8mmZJYecSt83IbSWXA2GMq6ZwuXbHhbKc0pztS', '2023-10-24 07:59:09');

--
-- Triggers `registrasi`
--
DELIMITER $$
CREATE TRIGGER `before_insert_registrasi` BEFORE INSERT ON `registrasi` FOR EACH ROW BEGIN
    DECLARE new_id INT;
    SET new_id = (SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'registrasi');
    SET NEW.nomer_registrasi = CONCAT(LPAD(new_id, 4, '0'), '/PI/', YEAR(CURDATE()));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(100) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_kepuasan`
--

CREATE TABLE `survey_kepuasan` (
  `id` int(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `usia` varchar(10) NOT NULL,
  `pendidikan_terakhir` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `jenis_layanan` varchar(255) NOT NULL,
  `mendapatkan_informasi` varchar(255) NOT NULL,
  `mendapatkan_salinan` varchar(255) NOT NULL,
  `tanggal_survey` timestamp NOT NULL DEFAULT current_timestamp()
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
  `no_hp` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `informasi_yang_dibutuhkan` varchar(255) NOT NULL,
  `alasan_pengguna_informasi` varchar(255) NOT NULL,
  `id_permohonan` int(11) NOT NULL,
  `tanggal_verifikasi` timestamp NOT NULL DEFAULT current_timestamp(),
  `opd_yang_dituju` varchar(255) NOT NULL,
  `status_verifikasi` enum('sudah terverifikasi','belum terverifikasi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verifikasi_permohonan`
--

INSERT INTO `verifikasi_permohonan` (`id`, `nomer_registrasi`, `nama_pengguna`, `tanggal_permohonan`, `nik`, `foto_ktp`, `no_hp`, `alamat`, `informasi_yang_dibutuhkan`, `alasan_pengguna_informasi`, `id_permohonan`, `tanggal_verifikasi`, `opd_yang_dituju`, `status_verifikasi`) VALUES
(27, '0030/PI/2023', 'TEGAR ARSYADANI', '2023-10-25 11:33:44', '3315182709010001', '2019_02_02_09_20_IMG_6746.JPG', '081353677822', 'Desa Curug Rt 03 Rw 02 Kecamatan Tegowanu Kabupaten Grobogan', 'rekap data 2020 sampai 2022', 'sebagai presentasi', 220, '2023-10-25 08:10:51', 'Sekretaris Daerah Provinsi Jawa Tengah', 'sudah terverifikasi'),
(28, '0031/PI/2023', 'rahmatika kusumawardani', '2023-10-25 11:38:09', '3374101004020005', '2021_03_18_00_29_IMG_7363.JPG', '081353777777', 'pilang', 'rekap data 2020 sampai 2022', 'sebagai penelitian untuk skripsi', 221, '2023-10-25 13:35:52', 'Direktur PT. Kawan Indutri Wijayakusuma', 'sudah terverifikasi'),
(29, '0030/PI/2023', 'TEGAR ARSYADANI', '2023-10-25 21:19:32', '3315182709010001', '2019_02_02_09_20_IMG_6746.JPG', '081353677822', 'Desa Curug Rt 03 Rw 02 Kecamatan Tegowanu Kabupaten Grobogan', 'anajyyy', 'mabar', 222, '2023-10-25 14:22:16', 'Sekretaris Daerah Provinsi Jawa Tengah', 'sudah terverifikasi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
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
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_kepuasan`
--
ALTER TABLE `survey_kepuasan`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengajuan_keberatan`
--
ALTER TABLE `pengajuan_keberatan`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permohonan_informasi`
--
ALTER TABLE `permohonan_informasi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_kepuasan`
--
ALTER TABLE `survey_kepuasan`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `verifikasi_permohonan`
--
ALTER TABLE `verifikasi_permohonan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
