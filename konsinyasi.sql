-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Mar 2025 pada 19.01
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
-- Struktur dari tabel `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbluser`
--

INSERT INTO `tbluser` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'admin', '$2y$10$vvprq2d0i47T.IDB2zOECOiEVbO3J..3YLfOFxftJ7.cMPzy/C8pa', 'admin@gmail.com', 1),
(2, 'admin2', '$2y$10$MhiXxKcNYKaY43rscA4MDejeAqk8/Nvoc6NItiVsKCgQEljdCrC.u', 'admin2@gmail.com', 1),
(3, 'admin3', '$2y$10$q5cu5ktUJFc5KG4lcOULW.ZmyHamHx9xBIOS6vqymj3H4/R4x2Gpm', 'admin3@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbloutlet`
--
ALTER TABLE `tbloutlet`
  ADD PRIMARY KEY (`id_outlet`);

--
-- Indeks untuk tabel `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
