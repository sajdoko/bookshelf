-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2023 at 12:04 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookshelf`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `publication_year` year(4) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `language`, `publisher`, `publication_year`, `genre`, `price`, `featured`, `image_url`) VALUES
(1, 'The Great Gatsby', 'F. Scott Fitzgerald', 'English', 'Charles Scribner\'s Sons', 1925, 'Novel', '9.99', 1, 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1490528560l/4671._SY475_.jpg'),
(2, 'To Kill a Mockingbird', 'Harper Lee', 'English', 'J. B. Lippincott & Co.', 1960, 'Novel', '8.99', 0, 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1553383690l/2657.jpg'),
(3, 'Pride and Prejudice', 'Jane Austen', 'English', 'T. Egerton', 0000, 'Novel', '7.99', 1, 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1320399351l/1885.jpg'),
(4, 'Wuthering Heights', 'Emily Brontë', 'English', 'Thomas Cautley Newby', 0000, 'Novel', '10.99', 1, 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1388212715l/6185._SY475_.jpg'),
(5, 'One Hundred Years of Solitude', 'Gabriel García Márquez', 'Spanish', 'Editorial Sudamericana S.A.', 1967, 'Novel', '11.99', 1, 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1327881361l/320.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `book_id`, `quantity`, `total_price`) VALUES
(7, 1, 1, 2, '19.98'),
(8, 2, 2, 1, '8.99'),
(9, 3, 3, 1, '7.99');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` binary(60) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `address`, `city`, `country`, `zipcode`, `phone`, `is_admin`) VALUES
(1, 'Sajmir', 'Doko', 'sajdoko@gmail.com', 0x2432792431302449772e655a41344e4d4a3863416e744d47704a39646557393339464a6232457871685130703432524f5a55736856442f39676d3961, 'Rruga Ska Fare', 'Tirane', 'Tirane', '1001', '', 1),
(2, '', '', '', 0x243279243130246964463778594f50636f624b6b5333555458724736655477314776757979536c67346e2e787445655070704c68766d356641476879, '', '', '', '', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
