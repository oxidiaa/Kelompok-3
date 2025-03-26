-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Mar 2025 pada 23.30
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `konsinyasi`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GenerateNoPesan` (OUT `new_no_pesan` VARCHAR(15))   BEGIN
    DECLARE current_counter INT;
    DECLARE current_month_year VARCHAR(6);
    DECLARE new_counter INT;

    -- Ambil bulan dan tahun dalam format MMYYYY
    SET current_month_year = DATE_FORMAT(CURDATE(), '%m%Y');

    -- Cek apakah bulan ini sudah ada dalam counter_pembelian
    SELECT counter INTO current_counter 
    FROM counter_pembelian 
    WHERE bulan_tahun = current_month_year;

    IF current_counter IS NULL THEN
        -- Jika belum ada, mulai dari 1 dan masukkan ke tabel
        SET new_counter = 1;
        INSERT INTO counter_pembelian (bulan_tahun, counter) VALUES (current_month_year, new_counter);
    ELSE
        -- Jika sudah ada, increment counter
        SET new_counter = current_counter + 1;
        UPDATE counter_pembelian SET counter = new_counter WHERE bulan_tahun = current_month_year;
    END IF;

    -- Format nomor pesanan
    SET new_no_pesan = CONCAT('PP', current_month_year, LPAD(new_counter, 4, '0'));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `counter_pembelian`
--

CREATE TABLE `counter_pembelian` (
  `bulan_tahun` varchar(6) NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `counter_pembelian`
--

INSERT INTO `counter_pembelian` (`bulan_tahun`, `counter`) VALUES
('032025', 52);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbljabatan`
--

CREATE TABLE `tbljabatan` (
  `kd_jabatan` varchar(20) NOT NULL,
  `nm_jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbljabatan`
--

INSERT INTO `tbljabatan` (`kd_jabatan`, `nm_jabatan`) VALUES
('ADM', 'Administrator'),
('IT', 'Staff IT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblkaryawan`
--

CREATE TABLE `tblkaryawan` (
  `id_karyawan` varchar(20) NOT NULL,
  `nm_karyawan` varchar(100) NOT NULL,
  `fk_jabatan` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tgl_keluar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblkaryawan`
--

INSERT INTO `tblkaryawan` (`id_karyawan`, `nm_karyawan`, `fk_jabatan`, `tempat_lahir`, `tgl_lahir`, `tgl_masuk`, `tgl_keluar`) VALUES
('200203101', 'Alan Walker', 'IT', 'Jakarta', '1892-03-09', '2025-03-09', NULL),
('90010010202', 'Jubaer', 'ADM', 'Karawang', '2000-10-01', '2025-03-09', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbloutlet`
--

CREATE TABLE `tbloutlet` (
  `id_outlet` varchar(10) NOT NULL,
  `nm_outlet` varchar(255) NOT NULL,
  `alamat_outlet` text NOT NULL,
  `no_telp_outlet` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbloutlet`
--

INSERT INTO `tbloutlet` (`id_outlet`, `nm_outlet`, `alamat_outlet`, `no_telp_outlet`) VALUES
('OTL-JHR', 'Ordinary Outlet Johor 1', 'Jl. Ahmad Yani 21221', '08912882929292'),
('OTL-LMR', 'Ordinary Outlet Lamaran', 'JL. Manunggal VII, Ruko Baru Lamarang No 7', '081389788828'),
('OTL-TLJ', 'Ordinary Outlet Teluk Jambe', 'Jl Teluk Jambe', '0812992281891');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblpembelian_stok`
--

CREATE TABLE `tblpembelian_stok` (
  `no_pesan` varchar(15) NOT NULL,
  `tgl_pesan` date NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tgl_terima` date DEFAULT NULL,
  `tgl_batal` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblpembelian_stok`
--

INSERT INTO `tblpembelian_stok` (`no_pesan`, `tgl_pesan`, `status`, `tgl_terima`, `tgl_batal`, `keterangan`) VALUES
('PP0320250046', '2025-03-08', 'Proses', NULL, NULL, 'test test 134'),
('PP0320250047', '2025-03-08', 'Proses', NULL, NULL, '1298319'),
('PP0320250048', '2025-03-08', 'Proses', NULL, NULL, 'testset'),
('PP0320250049', '2025-03-08', 'Proses', NULL, NULL, 'test12345678'),
('PP0320250050', '2025-03-08', 'Proses', NULL, NULL, '1231123123'),
('PP0320250051', '2025-03-08', 'Proses', NULL, NULL, 'aelah'),
('PP0320250052', '2025-03-09', 'Proses', NULL, NULL, 'yes no');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblpembelian_stok_detail`
--

CREATE TABLE `tblpembelian_stok_detail` (
  `id` int(11) NOT NULL,
  `fk_pesan` varchar(15) DEFAULT NULL,
  `fk_product` varchar(50) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblpembelian_stok_detail`
--

INSERT INTO `tblpembelian_stok_detail` (`id`, `fk_pesan`, `fk_product`, `qty`, `harga`) VALUES
(1, 'PP0320250047', 'MD-MR', 50, '19.00'),
(2, 'PP0320250048', 'MD-MR', 50, '19.00'),
(3, 'PP0320250049', 'MD-TK', 20, '1.00'),
(4, 'PP0320250050', 'MD-TK', 20, '1.00'),
(5, 'PP0320250051', 'MD-SB', 2, '23000.00'),
(9, NULL, NULL, 0, '0.00'),
(10, NULL, NULL, 0, '0.00'),
(11, NULL, NULL, 0, '0.00'),
(12, NULL, NULL, 0, '0.00'),
(13, NULL, NULL, 0, '0.00'),
(14, NULL, NULL, 0, '0.00'),
(15, NULL, NULL, 0, '0.00'),
(16, NULL, NULL, 0, '0.00'),
(25, 'PP0320250052', 'MD-TJ', 1, '3000000.00'),
(26, 'PP0320250052', 'MD-SB', 4, '23000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblproduct`
--

CREATE TABLE `tblproduct` (
  `kd_product` varchar(50) NOT NULL,
  `nm_product` varchar(255) NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `image_product` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `fk_satuan` varchar(5) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblproduct`
--

INSERT INTO `tblproduct` (`kd_product`, `nm_product`, `harga_beli`, `harga_jual`, `image_product`, `is_active`, `fk_satuan`, `keterangan`) VALUES
('MD-MR', 'MADU MURNI', '25000.00', '31000.00', '15627526979232.png', 1, 'PCS', 'hadeh'),
('MD-SB', 'Madu Segar', '28000.00', '45000.00', '15627526979232.png', 1, 'PCS', 'akakaka'),
('MD-TJ', 'Madu TJ', '20000.00', '33000.00', 'IMG202103131305495.jpg', 1, 'PCS', 'etst ja'),
('MD-TK', 'Produk Serupa', '15000.00', '20000.00', '15627526979232.png', 1, 'PCS', 'etst ja'),
('MD-TRT', 'Produk Serupa', '18000.00', '29000.00', '15627526979232.png', 1, 'PCS', 'etst ja');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblsatuan`
--

CREATE TABLE `tblsatuan` (
  `kd_satuan` varchar(5) NOT NULL,
  `nm_satuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblsatuan`
--

INSERT INTO `tblsatuan` (`kd_satuan`, `nm_satuan`) VALUES
('PCK', 'PACK'),
('PCS', 'PCS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblstok_product`
--

CREATE TABLE `tblstok_product` (
  `id` int(11) NOT NULL,
  `fk_product` varchar(50) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `on_hand` int(11) DEFAULT 0,
  `hpp` decimal(10,2) DEFAULT 0.00,
  `qty_out` int(11) DEFAULT 0,
  `qty_in` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblstok_product`
--

INSERT INTO `tblstok_product` (`id`, `fk_product`, `bulan`, `tahun`, `on_hand`, `hpp`, `qty_out`, `qty_in`) VALUES
(1, 'MD-MR', 3, 2025, 100, '19.00', 0, 100),
(2, 'MD-TK', 3, 2025, 40, '1.00', 0, 40),
(3, 'MD-SB', 3, 2025, 2, '23000.00', 0, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(10) DEFAULT NULL,
  `fk_karyawan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbluser`
--

INSERT INTO `tbluser` (`id`, `username`, `password`, `email`, `role`, `fk_karyawan`) VALUES
(1, 'admin', '$2y$10$vvprq2d0i47T.IDB2zOECOiEVbO3J..3YLfOFxftJ7.cMPzy/C8pa', 'admin@gmail.com', 1, '200203101'),
(2, 'admin2', '$2y$10$8XOzFDaZKkrHfBEfiHnN9.MPh.i41aZQuOEV64YbvRL3czcDRmq/q', 'admin2@gmail.com', 1, '200203101'),
(3, 'admin3', '$2y$10$IAD8zC05JFRd9QUV3HT.9OP3Crm0.vpB5mDQMMlj0TDfOzQpixC46', 'admin3@gmail.com', 1, '90010010202'),
(4, 'sibotak12', '$2y$10$nRRCkcbOhTykdGrrIXH4ZOqIfSOM.gX06aCYKMkNggjX65gY4rypu', 'botak@gmail.com', 1, '90010010202');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `counter_pembelian`
--
ALTER TABLE `counter_pembelian`
  ADD PRIMARY KEY (`bulan_tahun`);

--
-- Indeks untuk tabel `tbljabatan`
--
ALTER TABLE `tbljabatan`
  ADD PRIMARY KEY (`kd_jabatan`);

--
-- Indeks untuk tabel `tblkaryawan`
--
ALTER TABLE `tblkaryawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `fk_jabatan` (`fk_jabatan`);

--
-- Indeks untuk tabel `tbloutlet`
--
ALTER TABLE `tbloutlet`
  ADD PRIMARY KEY (`id_outlet`);

--
-- Indeks untuk tabel `tblpembelian_stok`
--
ALTER TABLE `tblpembelian_stok`
  ADD PRIMARY KEY (`no_pesan`);

--
-- Indeks untuk tabel `tblpembelian_stok_detail`
--
ALTER TABLE `tblpembelian_stok_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pesan` (`fk_pesan`),
  ADD KEY `fk_product` (`fk_product`);

--
-- Indeks untuk tabel `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`kd_product`),
  ADD KEY `fk_satuan` (`fk_satuan`);

--
-- Indeks untuk tabel `tblsatuan`
--
ALTER TABLE `tblsatuan`
  ADD PRIMARY KEY (`kd_satuan`);

--
-- Indeks untuk tabel `tblstok_product`
--
ALTER TABLE `tblstok_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`fk_product`);

--
-- Indeks untuk tabel `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_tbluser_karyawan` (`fk_karyawan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tblpembelian_stok_detail`
--
ALTER TABLE `tblpembelian_stok_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `tblstok_product`
--
ALTER TABLE `tblstok_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tblkaryawan`
--
ALTER TABLE `tblkaryawan`
  ADD CONSTRAINT `tblkaryawan_ibfk_1` FOREIGN KEY (`fk_jabatan`) REFERENCES `tbljabatan` (`kd_jabatan`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tblpembelian_stok_detail`
--
ALTER TABLE `tblpembelian_stok_detail`
  ADD CONSTRAINT `tblpembelian_stok_detail_ibfk_1` FOREIGN KEY (`fk_pesan`) REFERENCES `tblpembelian_stok` (`no_pesan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblpembelian_stok_detail_ibfk_2` FOREIGN KEY (`fk_product`) REFERENCES `tblproduct` (`kd_product`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD CONSTRAINT `fk_satuan` FOREIGN KEY (`fk_satuan`) REFERENCES `tblsatuan` (`kd_satuan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tblstok_product`
--
ALTER TABLE `tblstok_product`
  ADD CONSTRAINT `tblstok_product_ibfk_1` FOREIGN KEY (`fk_product`) REFERENCES `tblproduct` (`kd_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbluser`
--
ALTER TABLE `tbluser`
  ADD CONSTRAINT `fk_tbluser_karyawan` FOREIGN KEY (`fk_karyawan`) REFERENCES `tblkaryawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
