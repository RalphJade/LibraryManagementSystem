-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 04:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libmansys`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `ISBN` varchar(13) NOT NULL,
  `AvailableCopies` int(11) DEFAULT 1,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BookID`, `Title`, `Author`, `CategoryID`, `ISBN`, `AvailableCopies`, `CreatedAt`, `image_url`) VALUES
(1, 'Human-Computer Interaction', 'Alan Dix', 2, '1', 2, '2025-05-02 13:53:26', '../images/HumanComputerInteraction.jpg'),
(4, 'Computational Science and Engineering', 'Gilbert Strang', NULL, '9780961408817', 1, '2025-05-26 12:12:33', '../images/ComputationalScienceandEngineering.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `BorrowID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BookID` int(11) DEFAULT NULL,
  `BorrowDate` datetime DEFAULT current_timestamp(),
  `DueDate` datetime NOT NULL,
  `ReturnDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`BorrowID`, `UserID`, `BookID`, `BorrowDate`, `DueDate`, `ReturnDate`) VALUES
(1, 1, 1, '2025-05-03 14:24:35', '2025-05-17 08:24:35', '2025-05-03 14:30:53'),
(2, 1, 1, '2025-05-03 14:30:43', '2025-05-17 08:30:43', '2025-05-03 14:31:18'),
(3, 1, 1, '2025-05-03 14:34:54', '2025-05-17 08:34:54', '2025-05-03 14:35:12'),
(4, 1, 1, '2025-05-03 14:36:34', '2025-05-17 08:36:34', '2025-05-03 14:37:00'),
(5, 1, 1, '2025-05-26 07:30:25', '2025-06-09 01:30:25', '2025-05-26 07:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `ReturnID` int(11) NOT NULL,
  `BorrowID` int(11) NOT NULL,
  `ReturnDate` datetime DEFAULT current_timestamp(),
  `Condition` enum('new','good','fair','poor') DEFAULT 'good'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`ReturnID`, `BorrowID`, `ReturnDate`, `Condition`) VALUES
(1, 4, '2025-05-03 14:37:00', 'good'),
(2, 5, '2025-05-26 07:30:55', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Role` enum('admin','member') DEFAULT 'member',
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `Role`, `CreatedAt`) VALUES
(1, 'ralphjadeomega', '$2y$10$FRF66B019JCc.0pQrwUowePd/SbqDSAppHnRZrGqICp/QWi.rORJS', 'ralphjadeomega@gmail.com', 'member', '2025-05-02 13:07:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`),
  ADD UNIQUE KEY `ISBN` (`ISBN`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`BorrowID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BookID` (`BookID`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`ReturnID`),
  ADD KEY `BorrowID` (`BorrowID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `BorrowID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `ReturnID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`BorrowID`) REFERENCES `borrowings` (`BorrowID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
