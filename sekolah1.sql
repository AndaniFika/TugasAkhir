-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2024 at 05:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah1`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`) VALUES
(48, 'PENGUMUMAN LIBUR', 'Kepada para siswa,\r\n\r\nDiberitahukan bahwa, sekolah akan libur dalam rangka menjelang hari raya Idulfitri\r\nTanggal libur: Jumat 21 April s.d Selasa 25 April 2023. Dan pada 26 April 2023 proses belajar akan dimulai kembali', '2024-07-30 18:06:53'),
(50, '1', '2\r\n', '2024-09-12 19:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `berkas`
--

CREATE TABLE `berkas` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `ijazah` varchar(255) NOT NULL,
  `skhun` varchar(255) NOT NULL,
  `kk` varchar(255) NOT NULL,
  `ktp_ayah` varchar(255) NOT NULL,
  `ktp_ibu` varchar(255) NOT NULL,
  `kbs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berkas`
--

INSERT INTO `berkas` (`id`, `users_id`, `ijazah`, `skhun`, `kk`, `ktp_ayah`, `ktp_ibu`, `kbs`) VALUES
(12, 2363, '../uploads/ijasa_1722929548.pdf', '../uploads/skhun_1722929548.pdf', '../uploads/kk_1722929548.jpg', '../uploads/ktp ayah_1722929548.jpg', '../uploads/ktp ibu_1722929548.jpg', '../uploads/kbs_1722929548.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `orang_tua`
--

CREATE TABLE `orang_tua` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `nama_ayah` varchar(255) NOT NULL,
  `alamat_ayah` text NOT NULL,
  `telepon_ayah` varchar(20) NOT NULL,
  `pekerjaan_ayah` varchar(100) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `alamat_ibu` text NOT NULL,
  `telepon_ibu` varchar(20) NOT NULL,
  `pekerjaan_ibu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orang_tua`
--

INSERT INTO `orang_tua` (`id`, `users_id`, `nama_ayah`, `alamat_ayah`, `telepon_ayah`, `pekerjaan_ayah`, `nama_ibu`, `alamat_ibu`, `telepon_ibu`, `pekerjaan_ibu`) VALUES
(14, 2363, 'Muhammad', 'Atiahu', '082354448766', 'Petani', 'Siti Fatimah', 'Atiahu', '-', 'Ibu Rumah Tangga'),
(15, 2366, '2', '2', '2', '2', '2', '2', '22', '2'),
(16, 2367, '2', '2', '2', '2', '2', '2', '2', '2'),
(17, 2368, '3232', '232', '3232232332', '32323323', '2323', '223', '2326', '323ggggggggggggggggg'),
(18, 2369, '2', '2', '2', '2', '2', '2', '2', '2'),
(19, 2370, '4', '4', '4', '4', '4', '4', '4', '4'),
(20, 2371, '5', '5', '5', '5', '5', '5', '5', '5'),
(21, 2372, '6', '6', '6', '6', '6', '6', '6', '6'),
(22, 2373, '3', '3', '3', '3', '3', '3', '3', '3'),
(23, 2374, '3', '3', '3', '3', '3', '3', '3', '3');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `npsn` varchar(20) NOT NULL,
  `sejarah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id`, `nama`, `foto`, `npsn`, `sejarah`) VALUES
(1, 'YUSUF MIHRAJI,S.Ag', 'IMG_20211024_182934.jpg', '60105555', 'Sekolah MTS AL-MUHAJIRIN Waihatu Berdiri Tahun 2012');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'Buka', 'Tutup');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nomor_induk` varchar(50) NOT NULL,
  `nisn` varchar(50) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Budha','Konghucu') NOT NULL,
  `status_dalam_keluarga` enum('Kandung','Tiri','Angkat') NOT NULL,
  `anak_ke` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `telepon_hp` varchar(20) NOT NULL,
  `sekolah_asal` varchar(100) NOT NULL,
  `tanggal_mendaftar` date NOT NULL,
  `users_id` int(11) NOT NULL,
  `tahun_daftar` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nomor_induk`, `nisn`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `status_dalam_keluarga`, `anak_ke`, `alamat`, `telepon_hp`, `sekolah_asal`, `tanggal_mendaftar`, `users_id`, `tahun_daftar`) VALUES
(14, 'Abd Rahman Assagaf', '201', '8023466986', 'Atiahu', '2002-03-23', 'Laki-laki', 'Islam', 'Kandung', 2, 'Atiahu', '-', 'SD Negeri Atiahu', '2024-08-05', 2363, '2019'),
(15, '2', '2', '2', '2', '0002-02-02', 'Laki-laki', 'Hindu', 'Kandung', 2, '2', '2', '2', '2024-09-12', 2366, '2023'),
(16, '3', '3', '3', '3', '0002-03-03', 'Laki-laki', 'Katolik', 'Tiri', 2, '2', '2', '2', '2024-09-12', 2367, '2017'),
(17, 'aco', '2121212', '212121212', 'at', '2024-09-11', 'Laki-laki', 'Hindu', 'Kandung', 2, '222', 'eeeh', '232', '2024-09-12', 2368, '2024'),
(18, '2', '2', '233', '2', '0003-02-02', 'Laki-laki', 'Katolik', 'Tiri', 2, '2', '2', '2', '2024-09-12', 2369, '2034'),
(19, '4', '4', '4', '4', '0004-04-04', 'Laki-laki', 'Kristen', 'Tiri', 4, '4', '4', '4', '2024-09-12', 2370, '2012'),
(20, '5', '5', '5', '5', '0005-05-05', 'Laki-laki', 'Hindu', 'Kandung', 5, '5', '5', '5', '2024-09-12', 2371, '2012'),
(21, '6', '6', '6', '6', '0006-06-06', 'Perempuan', 'Hindu', 'Tiri', 6, '6', '6', '6', '2024-09-12', 2372, '2001'),
(22, '7', '7', '7', '7', '0007-07-07', 'Perempuan', 'Islam', 'Kandung', 3, '3', '3', '3', '2024-09-12', 2373, '2024'),
(23, '2', '2', '233444444444444', '2', '0002-02-02', 'Laki-laki', 'Islam', 'Kandung', 3, '3', '3', '3', '2024-09-12', 2374, '2024');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL,
  `data_filled` tinyint(1) DEFAULT 0,
  `profile_picture` varchar(255) DEFAULT 'path/to/default/profile_picture.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `data_filled`, `profile_picture`) VALUES
(1, '10', '10', 'admin', 0, 'path/to/default/profile_picture.png'),
(3, 'admin', '$2y$10$yAvcBoubfY67iKpRz.0a6e41IbsFWzANE.aJF4ZaJ8FrnnPbMytu.', 'admin', 0, '66e4e9d7b5c4a.png'),
(2363, 'rahman002', '$2y$10$NMDFm4n0guq.aDS2cSr5KuFn6/Y1M.1b1XBZURD8.eNPsi.7jvWmW', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2366, '2', '$2y$10$aN5NPdSQYWKw7KWdx5osyeDfThNrtduaI7g/uKmmBpHjrcoF81bw6', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2367, '3', '$2y$10$adNMRg.DvY8B96aa4Su4K.ccr6tKFcZseF0rzRzVK/eEF.Ql8WLou', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2368, 'strike', '$2y$10$0J8B0OhoHk0P.FrWJ8dSKO3Gahl6mnVWX9kotG1KGGL8ggsEgfrPi', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2369, '43', '$2y$10$vCBG1COfvLvfSIUMhOEkvubf5PuE72jY3/JdKi7YYzdFRDnn6F5A6', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2370, '4', '$2y$10$PtTGcxH68OrFzF9oEapJ0uwdzJoCjR1yfpracHnRcvBhIzP0cgilO', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2371, '5', '$2y$10$g//5T2wtN4Kscc1YnZut6u/kuaP/5IZjadSmHRYgXvNiDQB6B4sLC', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2372, '6', '$2y$10$zThZ8Z/zbGw/Jy2y6fyCyuDqkFVEu0WYIWQQe.4i15KzqbxdG9.PC', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2373, '7', '$2y$10$T9xFCJ1C4VNoqxefT4e6Ue.z38/xPIEW1LIWu3yIQCF81yn6/Lgx.', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2374, '8', '$2y$10$AdInr8cCOrF0GqN9l9l/B.hrwyuf3BQD5cQsakxEEwRrGklZVdpFy', 'siswa', 1, 'path/to/default/profile_picture.png'),
(2375, '9', '$2y$10$vrnp3wsnbAIJgzBd5oWtQ.CcAPOcVkk.ZTsEPjula7HMMHSH8TqxW', 'siswa', 0, 'path/to/default/profile_picture.png'),
(2376, '44', '$2y$10$hnD3qLDL1sLQ7YETXM0UKOQWmp2MSoAPlQ06i3UABaNNXUuK8oDHW', 'siswa', 0, 'path/to/default/profile_picture.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `berkas`
--
ALTER TABLE `berkas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orang_tua`
--
ALTER TABLE `orang_tua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2377;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berkas`
--
ALTER TABLE `berkas`
  ADD CONSTRAINT `berkas_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD CONSTRAINT `orang_tua_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
