-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jun 2023 pada 06.42
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_water`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `role_id` int(1) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `role_id`, `password`, `image`) VALUES
(1, 'admin', 'admin', 1, '$2y$10$uerWeERaeKa/0h9MdNXEm.aRZ4mYuXE1JdK53sQboMb/mViY4oiy2', 'default.jpg'),
(3, 'bung sandy', 'sandy', 2, '$2y$10$xJE0wx0tNVc.JZcqUBUQxOyRowkur7WHb3wpucbnCuS6mAGygrDma', 'default.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sensor`
--

CREATE TABLE `sensor` (
  `id` int(11) NOT NULL,
  `pH` float NOT NULL,
  `statuspH` varchar(15) NOT NULL,
  `ppm` int(11) NOT NULL,
  `statusTds` varchar(15) NOT NULL,
  `debit` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sensor`
--

INSERT INTO `sensor` (`id`, `pH`, `statuspH`, `ppm`, `statusTds`, `debit`, `date`) VALUES
(1, 0.36, 'baik', 2, 'buruk', 0, '2023-04-09 05:09:02'),
(2, 1.3, '', 0, '0', 0, '2023-04-09 05:09:04'),
(3, 1.49, '', 0, '0', 0, '2023-04-09 05:09:06'),
(4, 1.68, '', 0, '0', 0, '2023-04-09 05:09:09'),
(5, 1.87, '', 2, '0', 0, '2023-04-09 05:09:11'),
(6, 2.06, '', 0, '0', 0, '2023-04-09 05:09:13'),
(7, 2.25, '', 2, '0', 0, '2023-04-09 05:09:19'),
(8, 2.62, '', 4, '0', 1893, '2023-04-09 05:09:19'),
(9, 2.81, '', 0, '0', 2520, '2023-04-09 05:09:21'),
(10, 3, '', 2, '0', 1266, '2023-04-09 05:09:24'),
(11, 3.19, '', 4, '0', 26, '2023-04-09 05:09:27'),
(12, 3.38, '', 0, '0', 0, '2023-04-09 05:09:28'),
(13, 3.57, '', 2, '0', 0, '2023-04-09 05:09:30'),
(14, 3.76, '', 0, '0', 0, '2023-04-09 05:09:32'),
(15, 6, 'sangat baik', 300, 'sangat baik', 1000, '2023-04-18 03:00:06');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sensor`
--
ALTER TABLE `sensor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sensor`
--
ALTER TABLE `sensor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
