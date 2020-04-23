-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2020 at 07:50 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `catid` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`catid`, `category`) VALUES
(1, 'Laptop'),
(2, 'iPhone'),
(3, 'Desktop'),
(5, 'Mobile Phone'),
(7, 'iPad'),
(8, 'Headphone');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(11) NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `order_date` date NOT NULL,
  `subtotal` double NOT NULL,
  `tax` double NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `paid` double NOT NULL,
  `due` double NOT NULL,
  `payment_type` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`invoice_id`, `customer_name`, `order_date`, `subtotal`, `tax`, `discount`, `total`, `paid`, `due`, `payment_type`) VALUES
(14, 'Deepmalya Sen', '2020-04-13', 438455, 21922.75, 0.75, 460377, 60377, 400000, 'Credit Card'),
(15, 'Bidisha Sen', '2020-04-14', 262200, 13110, 0, 275310, 200000, 75310, 'Credit Card'),
(16, 'Liza Das', '2020-04-14', 298250, 14912.5, 0.5, 313162, 56000, 257162, 'Debit Card'),
(17, 'Garga Chatterjee', '2020-04-15', 436500, 21825, 0, 458325, 458325, 0, 'Cheque'),
(18, 'Ankur Chakrobarty', '2020-04-15', 40999, 2049.95, 0.95, 43048, 43048, 0, 'Cash'),
(19, 'Indranil Choudhury', '2020-04-16', 975000, 48750, 0, 1023750, 1000000, 23750, 'Cheque'),
(20, 'Dipanwita Sarkar', '2020-04-17', 121500, 6075, 0, 127575, 27575, 100000, 'Debit Card'),
(21, 'Tarita Dutta', '2020-04-17', 450000, 22500, 0, 472500, 472500, 0, 'Cheque'),
(22, 'Ashish Das', '2020-04-18', 338500, 16925, 0, 355425, 55425, 300000, 'Debit Card'),
(23, 'Abira Roy', '2020-04-18', 14495, 724.75, 0.75, 15219, 15219, 0, 'Cheque'),
(24, 'Sk Salman Khan', '2020-04-19', 1189330, 59466.5, 0.5, 1248796, 248796, 1000000, 'Cheque'),
(25, 'Amitabha Dutta', '2020-04-19', 142500, 7125, 0, 149625, 49625, 100000, 'Cash'),
(26, 'Sunanda Sarkar', '2020-04-19', 36500, 1825, 0, 38325, 38325, 0, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_details`
--

CREATE TABLE `tbl_invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_invoice_details`
--

INSERT INTO `tbl_invoice_details` (`id`, `invoice_id`, `product_id`, `product_name`, `qty`, `price`, `order_date`) VALUES
(39, 14, 3, 'Asus Rog', 3, 56000, '2020-04-13'),
(40, 14, 4, 'Lenovo Think Pad', 4, 35000, '2020-04-13'),
(41, 14, 24, 'Nokia 8.1', 9, 14495, '2020-04-13'),
(42, 15, 5, 'Acer Think Pad', 2, 39850, '2020-04-14'),
(43, 15, 6, 'Lenovo Think Pad 2', 5, 36500, '2020-04-14'),
(44, 16, 22, 'HP Pavilion X360', 5, 59650, '2020-04-14'),
(46, 18, 23, 'Asus Rog Phone ||', 1, 40999, '2020-04-15'),
(47, 19, 15, 'Asus Rog 3 Desktop', 3, 325000, '2020-04-16'),
(48, 20, 21, 'uBon Earphone', 10, 150, '2020-04-17'),
(49, 20, 20, 'JBL Headphone X Series', 20, 3000, '2020-04-17'),
(50, 20, 20, 'JBL Headphone X Series', 20, 3000, '2020-04-17'),
(51, 21, 19, 'Tulik Tok Headphone', 100, 4500, '2020-04-17'),
(52, 22, 21, 'uBon Earphone', 90, 150, '2020-04-18'),
(53, 22, 15, 'Asus Rog 3 Desktop', 1, 325000, '2020-04-18'),
(54, 23, 24, 'Nokia 8.1', 1, 14495, '2020-04-18'),
(55, 17, 19, 'Tulik Tok Headphone', 97, 4500, '2020-04-15'),
(56, 24, 24, 'Nokia 8.1', 20, 14495, '2020-04-19'),
(57, 24, 23, 'Asus Rog Phone ||', 10, 40999, '2020-04-19'),
(58, 24, 22, 'HP Pavilion X360', 5, 59650, '2020-04-19'),
(59, 24, 19, 'Tulik Tok Headphone', 30, 4500, '2020-04-19'),
(60, 24, 21, 'uBon Earphone', 20, 150, '2020-04-19'),
(61, 24, 17, 'Boss Headphone 11', 54, 985, '2020-04-19'),
(62, 25, 12, 'Redmi 8 Pro', 5, 28500, '2020-04-19'),
(63, 26, 16, 'Dell Desktop 17\"', 1, 36500, '2020-04-19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `pid` int(11) NOT NULL,
  `pname` varchar(250) NOT NULL,
  `pcategory` varchar(250) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice` float NOT NULL,
  `pstock` int(11) NOT NULL,
  `pdescription` longtext NOT NULL,
  `pimage` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pid`, `pname`, `pcategory`, `purchaseprice`, `saleprice`, `pstock`, `pdescription`, `pimage`) VALUES
(3, 'Asus Rog', 'Laptop', 52000, 56000, 11, 'Asus Rog Black Model 2020', '5e8ff63c69091.jpg'),
(4, 'Lenovo Think Pad', 'Laptop', 29800, 35000, 20, 'Lenovo Think Pad Red Body 15\"', '5e8ff6742ee02.jpg'),
(5, 'Acer Think Pad', 'Laptop', 32000, 39850, 21, 'Acer Think Pad Blue and Red Body', '5e8ff6a743885.jpg'),
(6, 'Lenovo Think Pad 2', 'Laptop', 26500, 36500, 19, 'Best Laptop In 2020', '5e8ff6d0d931a.jpg'),
(7, 'iPhone 11', 'iPhone', 125000, 155000, 3, 'iPhone 11 Black Metal Body', '5e8ff6fd4fb55.jpg'),
(8, 'iPhone 12', 'iPhone', 145000, 195000, 3, 'iPhone 12 Metal Body', '5e8ff736bbfa1.jpg'),
(9, 'Bgr iPhone 11', 'iPhone', 126500, 138500, 5, 'Bgr iPhone 11 Plastic Body', '5e8ff75e8302c.jpg'),
(10, 'Redmi 6 Pro', 'Mobile Phone', 18500, 22500, 25, 'Redmi 6 Pro Black Model', '5e8ff784970fb.jpg'),
(11, 'Redmi Note 7 Pro', 'Mobile Phone', 24000, 26500, 25, 'Redmi Note 7 Pro Black Metal Body', '5e8ff7b4b32c5.jpg'),
(12, 'Redmi 8 Pro', 'Mobile Phone', 24000, 28500, 20, 'Redmi 8 Pro Red Plastic Body', '5e8ff7db107b2.jpg'),
(13, 'Dell Desktop 15\"', 'Desktop', 24600, 28500, 26, 'Dell Desktop 15\" Full Feature', '5e8ff802da178.jpg'),
(14, 'Asus Rog Desktop', 'Desktop', 65000, 79500, 2, 'Asus Rog Desktop For Gamers', '5e8ff82dcb8b9.jpg'),
(15, 'Asus Rog 3 Desktop', 'Desktop', 256000, 325000, 1, 'Asus Rog 3 Desktop For Gamers', '5e8ff85b1eac0.jpg'),
(16, 'Dell Desktop 17\"', 'Desktop', 25000, 36500, 4, 'Dell Desktop For Office Use', '5e8ff8817f4c6.jpg'),
(17, 'Boss Headphone 11', 'Headphone', 650, 985, 70, 'Boss Headphone 11 For Black Body', '5e8ff96ed729c.jpg'),
(18, 'JBL Headphone', 'Headphone', 850, 1000, 198, 'JBL Super Sound', '5e8ff9fe2d1a7.jpg'),
(19, 'Tulik Tok Headphone', 'Headphone', 3560, 4500, 20, 'Tulik Tok Black Body', '5e8ffa2c7742e.jpg'),
(20, 'JBL Headphone X Series', 'Headphone', 2650, 3000, 5, 'JBL Headphone X Series - 2292', '5e8ffa6fcc750.jpg'),
(21, 'uBon Earphone', 'Headphone', 100, 150, 80, 'uBon Earphone Low Budget', '5e8ffab3a2697.jpg'),
(22, 'HP Pavilion X360', 'Laptop', 45000, 59650, 5, 'HP Pavilion x360 14-cd0053TX Laptop(8th Gen i5-8250U/8GB', '5e9a960ac498f.png'),
(23, 'Asus Rog Phone ||', 'Mobile Phone', 32000, 40999, 14, 'Asus ROG Phone II 128GB (Black, 8GB RAM)', '5e9a965b54dc8.png'),
(24, 'Nokia 8.1', 'Mobile Phone', 10125, 14495, 20, 'Nokia 8.1 (Blue, 4GB RAM, 64GB Storage) (Open Box)', '5e9a96dd7b1f3.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `useremail`, `password`, `role`) VALUES
(1, 'Abhishek Majumdar', 'webdevabhi4@gmail.com', 'Abhishek@2020', 'Admin'),
(2, 'Bidisha Bhattacharjee', 'bidisha@gmail.com', 'Bidisha@2020', 'User'),
(3, 'Deepmalya Sarkar', 'deepmalya@yahoo.com', 'Deepmalya@2020', 'User'),
(4, 'Abira Majumdar', 'abira.majumdar@gmail.com', 'Abira@2020', 'User'),
(5, 'Ankan Dutta', 'ankandutta@hotmail.com', 'Ankan@2020', 'User'),
(6, 'Gurjeet Singh', 'gurjeet@rediffmail.com', 'Gurjeet@2020', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
