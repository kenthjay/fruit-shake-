-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 11:17 AM
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
-- Database: `fruitshake_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(11) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(1, 'ccbd', '0d89ec971a7bcfe26d68c177a9d53334', 'admin@gmail.com', '', '2023-02-22 07:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(11) NOT NULL,
  `rs_id` int(11) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`) VALUES
(17, 4, 'MANGO SHAKE', 'Its vibrant orange-yellow color reflects the lusciousness of the mangoes, and the drink typically has a smooth, thick consistency.', 1.00, '672318eaaa5a7.png'),
(19, 4, 'MANGO GRAHAMS', 'Mango grahams, also known as mango float, is a delicious and no-bake dessert popular in the Philippines.', 1.00, '672319fecade8.png'),
(21, 4, 'BANANA FRUIT SHAKE', ' A banana fruit shake is a creamy and delicious beverage made primarily with ripe bananas, making it a nutritious and satisfying option for breakfast or a snack.', 1.00, '67231cd608752.jpg'),
(22, 4, 'MACARONI SALAD', ' Imagine a creamy, savory drink that incorporates the flavors and ingredients of a classic macaroni salad.', 1.00, '67231d104c9be.jpg'),
(23, 4, 'APPLE FRUIT SHAKE', 'An apple fruit shake is a refreshing and nutritious beverage that combines the crisp, sweet flavor of apples with creamy ingredients for a satisfying drink.', 1.00, '67231f3ac92d0.jpg'),
(24, 4, 'AVOCADO FRUIT SHAKE', 'An avocado fruit shake is a creamy and nutritious beverage that highlights the rich, buttery texture of avocados.', 1.00, '67231fa021560.jpg'),
(25, 4, 'GUYABANO FRUIT SHAKE', 'A guyabano fruit shake is a delicious and refreshing beverage made from the tropical guyabano (soursop) fruit, known for its creamy texture and unique sweet-tart flavor.', 1.00, '67231fd2c9f6c.jpg'),
(26, 4, 'DRAGON FRUIT SHAKE', ' It has bright pink or yellow skin with green, scale-like leaves, resembling something out of a fantasy novel.', 1.00, '672322d1c7dd3.jpg'),
(27, 4, 'MANGO TAPIOCA', 'Mango tapioca is a delightful dessert that combines the tropical flavor of ripe mangoes with the unique texture of tapioca pearls. ', 1.00, '672322fb9b054.jpg'),
(28, 4, 'MANGO TAPIOCA', 'Mango tapioca is a delightful dessert that combines the tropical flavor of ripe mangoes with the unique texture of tapioca pearls. ', 1.00, '67232895c8792.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `o_hr` varchar(222) NOT NULL,
  `c_hr` varchar(222) NOT NULL,
  `o_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`) VALUES
(4, 0, 'RN FRUIT SHAKE', 'shakeitghay@gmail.com', '09913251753', 'www.google.com', '--Select your Hours--', '--Select your Hours--', '--Select your Days--', 'KAMAGAYAN, COLON ST. CEBU CITY', '6723175602da1.png', '2024-10-31 05:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `address`, `status`, `date`) VALUES
(10, 'ken2xgwapo1235', 'kentoy', 'magbanua', 'kenthjayatuelmagbanua@gmail.com', '09302744954', 'e10adc3949ba59abbe56e057f20f883e', 'amoa lage', 1, '2024-10-31 05:18:48'),
(11, 'ken', 'kenth', 'magbanua', 'kenthatuelmagbanua@gmail.com', '09302744954', 'da7997531cc94117c23b9934a8bc3920', 'dadawd', 1, '2024-11-03 02:55:55'),
(12, 'Jem', 'Jem', 'estillore', 'johnjemuelestillore@gmail.com', '09956242605', 'e10adc3949ba59abbe56e057f20f883e', 'Pasil', 1, '2024-11-05 05:40:47'),
(13, 'Jake', 'Jake', 'James', 'jake@gmail.com', '09956242605', 'e10adc3949ba59abbe56e057f20f883e', 'Pasil', 1, '2024-11-06 08:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `title` varchar(222) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `title`, `quantity`, `price`, `status`, `date`) VALUES
(24, 10, 'MANGO SHAKE', 1, 1.00, NULL, '2024-10-31 06:30:33'),
(25, 10, 'AVOCADO FRUIT SHAKE', 1, 1.00, NULL, '2024-10-31 06:37:10'),
(26, 13, 'MANGO SHAKE', 1, 1.00, NULL, '2024-11-06 08:21:04'),
(27, 13, 'BANANA FRUIT SHAKE', 1, 1.00, NULL, '2024-11-06 08:21:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
