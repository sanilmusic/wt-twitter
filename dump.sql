-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 14, 2017 at 06:13 PM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wtdb`
--
CREATE DATABASE IF NOT EXISTS `wtdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci;
USE `wtdb`;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(10) UNSIGNED NOT NULL,
  `ime` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  `prezime` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  `lozinka` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `email`, `lozinka`, `admin`) VALUES
(1, 'Admin', 'Korisnik', 'admin@test.com', '$2y$10$p5T4AH7fHuNG4EeCpwBeauVhjBFS.yWAFg1nrdNUCHVnxDS7juHf6', 1),
(2, 'Test', 'Test', 'test@test.com', '$2y$10$FetxzJdwBKINFqtHHbQUz.YPFjMgFyVQ.9b9mVJfi6k5pnoond5zG', 0),
(3, 'Novi', 'Korisnik', 'novi@korisnik.com', '$2y$10$87TlTMJidnYof7xHEUKb7.s/61qRAQC7RSMdj9SbVNbWPcLoz4DzG', 0);

-- --------------------------------------------------------

--
-- Table structure for table `poruke`
--

CREATE TABLE `poruke` (
  `id` int(10) UNSIGNED NOT NULL,
  `korisnik_id` int(10) UNSIGNED NOT NULL,
  `tekst` text COLLATE utf8_slovenian_ci NOT NULL,
  `kad` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `poruke`
--

INSERT INTO `poruke` (`id`, `korisnik_id`, `tekst`, `kad`) VALUES
(1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec eros nisi. Proin luctus tristique tortor id ultrices. Nullam pharetra orci in ante finibus, nec malesuada metus porttitor. Nullam fringilla libero in malesuada iaculis. Sed eget odio elementum nisl ullamcorper dictum. Nulla leo est, mattis eu ligula eget, vestibulum tristique lorem. Aenean turpis enim, posuere nec aliquam egestas, scelerisque vel purus. Nulla id turpis vitae risus dignissim auctor et eget neque. Cras eget auctor elit, a aliquam augue. Vestibulum gravida gravida hendrerit. Nunc consequat dui eget lectus commodo mollis. Pellentesque augue diam, convallis at libero ut, dictum ullamcorper justo. Suspendisse id nibh non elit fringilla cursus eu sed dolor. Etiam sodales lectus maximus, interdum est eget, sagittis ligula. Mauris id urna vitae massa faucibus consequat in non mauris. Vivamus faucibus vulputate elit a tincidunt.', 1482930450),
(2, 2, 'Fusce turpis tortor, viverra a ex nec, volutpat lacinia libero. Vestibulum imperdiet feugiat odio, at tincidunt orci dapibus sit amet. Nunc facilisis ullamcorper nulla.', 1482931675),
(3, 3, 'Sed lacinia augue ut tellus venenatis, at commodo quam mattis. In nisl ipsum, porttitor in dolor vitae, semper bibendum orci.', 1482931685),
(4, 1, 'Etiam convallis arcu nec feugiat fermentum. Donec elementum rhoncus est, quis sagittis enim aliquet sed. Suspendisse aliquam et erat a malesuada.', 1482931695),
(5, 3, 'Etiam libero ipsum, dapibus eget iaculis at, tempor eget enim. Vestibulum a imperdiet diam. Nullam aliquam consectetur mollis. Integer sed posuere enim. Morbi condimentum ante ut metus consequat, id consequat urna condimentum. Quisque in enim a nisl dignissim efficitur eu at massa. In volutpat arcu ligula, ut maximus sem auctor et. Sed condimentum, quam in aliquam consequat, arcu ex fringilla velit, sed pharetra massa libero ut libero.', 1482931715),
(6, 2, 'Phasellus enim metus, dictum a neque a, dapibus luctus metus. Maecenas tempus est eget ultrices molestie. Proin sodales mauris id pulvinar accumsan.', 1482931727),
(10, 3, '<script>alert(\'test\');</script>', 1482932322);

-- --------------------------------------------------------

--
-- Table structure for table `pratitelji`
--

CREATE TABLE `pratitelji` (
  `pratitelj_id` int(10) UNSIGNED NOT NULL,
  `prati_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `pratitelji`
--

INSERT INTO `pratitelji` (`pratitelj_id`, `prati_id`) VALUES
(1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poruke`
--
ALTER TABLE `poruke`
  ADD PRIMARY KEY (`id`),
  ADD KEY `korisnik_id` (`korisnik_id`);

--
-- Indexes for table `pratitelji`
--
ALTER TABLE `pratitelji`
  ADD KEY `pratitelj_id` (`pratitelj_id`),
  ADD KEY `prati_id` (`prati_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `poruke`
--
ALTER TABLE `poruke`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `poruke`
--
ALTER TABLE `poruke`
  ADD CONSTRAINT `fk_poruke_korisnici_korisnik_id` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`);

--
-- Constraints for table `pratitelji`
--
ALTER TABLE `pratitelji`
  ADD CONSTRAINT `fk_pratitelji_korisnici_prati_id` FOREIGN KEY (`prati_id`) REFERENCES `korisnici` (`id`),
  ADD CONSTRAINT `fk_pratitelji_korisnici_pratitelj_id` FOREIGN KEY (`pratitelj_id`) REFERENCES `korisnici` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
