-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2026 at 03:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_kue`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'Administrator', 'admin', '$2y$10$98vbxh4xT65X0Rnc9/L33eWkPdxz8VL4hbvd338D7IILqDOqYj4e6', '2026-09-27 13:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `deskripsi`, `harga`, `stok`, `gambar`, `created_at`) VALUES
(3, 'Donat Mesis', 'Donat', 'Donat lembut dari bahan kentang asli dengan topping coklat yang masnis.', '4000.00', 25, '1790824842_6abdd18a672de.jpg', '2026-09-27 13:32:53'),
(6, 'Donat Mix', 'Donat', 'Donat dengan rasa yang di MIX', '17000.00', 30, '1790824767_6abdd13fdd549.jpg', '2026-10-01 03:15:23'),
(7, 'Donat Original', 'Donat', 'Donat Original tanpa ada rasa tambahan lainnya', '3000.00', 22, '6abdd10fc5625.jpg', '2026-10-01 03:18:39'),
(8, 'Cheese Cake Coklat', 'Cake', 'Cheese Cake Coklat dengan rasa lezat dan coklat yang lumer', '25000.00', 23, '6abdd29fb0b86.jpg', '2026-10-01 03:25:19'),
(9, 'Cheese Cake Stroberry', 'Cake', 'Cheese Cake Stroberry dengan rasa yang manis dengan perpaduan dengan stroberry', '23000.00', 15, '6abdd2fe7e21d.jpg', '2026-10-01 03:26:54'),
(10, 'Cheese Cake MIX', 'Cake', 'Cheese Cake MIX dengan cake lezat manis dan rasa yang beragam', '49994.00', 12, '6abdd39d3ee1c.jpg', '2026-10-01 03:29:33'),
(11, 'Brownies Coklat', 'Brownies', 'Brownies Coklat dengan brownies yang tebal  dan rasa yang mantab', '15000.00', 24, '6abdd4242b461.jpg', '2026-10-01 03:31:48'),
(12, 'Brownies Ice Cream', 'Brownies', 'Brownies Ice Cream perpaduan rasa antara manisnya brownies dan ice cream', '18000.00', 24, '6abdd4977fe8c.jpg', '2026-10-01 03:33:43'),
(13, 'Brownies MIX', 'Brownies', 'Brownies dengan manisnya yang mantap dan rasa yang beragam', '78000.00', 23, '6abdd521a44a9.jpg', '2026-10-01 03:36:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
