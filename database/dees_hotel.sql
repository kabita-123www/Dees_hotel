-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2026 at 04:01 AM
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
-- Database: `dees_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$sUIy3FrA2rZhvk3PpOKTPeC8i4jyP8sNV.foczmBEutPti9sWrwo.', '2026-07-10 01:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `image`, `description`, `created_at`) VALUES
(2, 'Banquet Hall', 'uploads/facilities/facility_1783767343_6a52212f2d9a0.jpg', 'An elegant hall perfect for weddings, corporate events, and celebrations of every scale.', '2026-07-10 01:26:18'),
(5, 'Swimming Pool', 'uploads/facilities/facility_1783767273_6a5220e98db5e.jpg', 'A serene pool area to relax, unwind, and soak in the boutique ambience.', '2026-07-10 01:26:18'),
(6, 'Bar', 'uploads/facilities/facility_1783767256_6a5220d8391f3.jpeg', 'Savor authentic Nepali and international cuisine prepared by our expert culinary team.', '2026-07-10 01:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'General',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image_path`, `category`, `created_at`) VALUES
(13, 'uploads/gallery/gallery_1783765874_6a521b722ab5f.jpg', 'Buildings', '2026-07-11 10:31:14'),
(14, 'uploads/gallery/gallery_1783765892_6a521b840f61c.jpeg', 'General', '2026-07-11 10:31:32'),
(15, 'uploads/gallery/gallery_1783765919_6a521b9f09456.jpg', 'Bar', '2026-07-11 10:31:59'),
(16, 'uploads/gallery/gallery_1783765962_6a521bca1084d.jpg', 'Bed Room', '2026-07-11 10:32:42'),
(17, 'uploads/gallery/gallery_1783766024_6a521c086f992.jpg', 'Reception', '2026-07-11 10:33:44'),
(18, 'uploads/gallery/gallery_1783766061_6a521c2d2249e.jpg', 'Living Area', '2026-07-11 10:34:21'),
(20, 'uploads/gallery/gallery_1783766199_6a521cb743d71.jpg', 'Rooms', '2026-07-11 10:36:39'),
(21, 'uploads/gallery/gallery_1783766228_6a521cd43d118.jpg', 'Night View', '2026-07-11 10:37:08'),
(22, 'uploads/gallery/gallery_1783766245_6a521ce50273d.jpg', 'General', '2026-07-11 10:37:25'),
(23, 'uploads/gallery/gallery_1783766273_6a521d01f1175.jpg', 'General', '2026-07-11 10:37:53'),
(24, 'uploads/gallery/gallery_1783766319_6a521d2f3cbfa.jpg', 'indoor swimming  pool', '2026-07-11 10:38:39'),
(25, 'uploads/gallery/gallery_1783766363_6a521d5bce770.jpg', 'General', '2026-07-11 10:39:23'),
(26, 'uploads/gallery/gallery_1783766389_6a521d756d8a8.jpg', 'General', '2026-07-11 10:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `features` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `type`, `description`, `price`, `image`, `features`, `created_at`) VALUES
(1, 'Deluxe Room', 'Spacious and elegantly furnished room with modern amenities, perfect for solo travelers or couples.', 4500.00, 'uploads/rooms/room_1783767021_6a521fed3fcc5.jpg', 'Free WiFi,Air Conditioning, Flat TV,Comfortable Bedding,Daily Housekeeping', '2026-07-10 01:26:18'),
(2, 'Super Deluxe Room', 'A step above, offering extra space, premium furnishings, and a stunning city view.', 0.00, 'uploads/rooms/room_1783766961_6a521fb1f10c4.jpg', 'Free WiFi,Air Conditioning,City View, Comfortable Bedding,Daily Housekeeping', '2026-07-10 01:26:18'),
(3, 'Suite', 'Enjoy a comfortable stay in our Suite, featuring plenty of space to unwind. This room is fully equipped with air conditioning, a flat-screen TV, and complimentary WiFi for your convenience.', 5500.00, 'uploads/rooms/room_1783766882_6a521f62eb96e.jpeg', 'Flat-screen TV, Air Conditioning, Free WiFi, Comfortable Bedding,Daily Housekeeping', '2026-07-10 01:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `slideshow`
--

CREATE TABLE `slideshow` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slideshow`
--

INSERT INTO `slideshow` (`id`, `image_path`, `caption`, `created_at`) VALUES
(6, 'uploads/slideshow/slide_1783682723_6a50d6a32eefc.jpg', 'Dees Hotel', '2026-07-10 11:25:23'),
(7, 'uploads/slideshow/slide_1783682785_6a50d6e13ddf6.jpg', 'Welcome Dees Boutique', '2026-07-10 11:26:25'),
(8, 'uploads/slideshow/slide_1783682835_6a50d7133a123.jpg', 'property inside', '2026-07-10 11:27:15');

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
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slideshow`
--
ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
