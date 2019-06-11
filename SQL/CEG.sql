-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 11, 2019 at 11:08 PM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CEG`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`UserID`) VALUES
(0),
(7);

-- --------------------------------------------------------

--
-- Table structure for table `Attendee`
--

CREATE TABLE `Attendee` (
  `UserID` int(11) NOT NULL,
  `Birth_date` date NOT NULL,
  `Phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Attendee`
--

INSERT INTO `Attendee` (`UserID`, `Birth_date`, `Phone`) VALUES
(2, '2019-06-26', '7341111111'),
(3, '2019-06-11', '7341111111'),
(5, '2019-06-21', '7341231234');

-- --------------------------------------------------------

--
-- Table structure for table `Concert`
--

CREATE TABLE `Concert` (
  `ConcertID` int(11) NOT NULL,
  `Concert_name` varchar(25) NOT NULL,
  `Description` varchar(150) NOT NULL,
  `Published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Concert`
--

INSERT INTO `Concert` (`ConcertID`, `Concert_name`, `Description`, `Published`) VALUES
(1, 'Fiddle Fiasco', 'Description for Fiddle Fiasco', 0),
(2, 'Medieval Montage', 'Description for Medieval Montage', 1),
(3, 'Pipers in the Park', 'Description for Pipers in the Park', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`UserID`) VALUES
(1),
(4),
(6);

-- --------------------------------------------------------

--
-- Table structure for table `Schedule`
--

CREATE TABLE `Schedule` (
  `ScheduleID` int(11) NOT NULL,
  `ConcertID` int(11) NOT NULL,
  `VenueID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Schedule`
--

INSERT INTO `Schedule` (`ScheduleID`, `ConcertID`, `VenueID`, `Date`, `Time`) VALUES
(1, 1, 2, '2019-07-23', '7pm-9pm'),
(2, 2, 2, '2019-07-20', '7pm-9pm'),
(3, 3, 3, '2019-07-27', '7pm-9pm');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserID` int(11) NOT NULL,
  `First_name` varchar(25) NOT NULL,
  `Last_name` varchar(25) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `First_name`, `Last_name`, `Email`, `Password`) VALUES
(0, 'Mr', 'Admin', 'mradmin@gmail.com', '$2y$10$T4caspNQ8H7UAJQpwXwLpOk3HhmuHHjNSvhCiU.h6gjz3d0o8kdwi'),
(1, 'Mr', 'Employee', 'mremployee@gmail.com', '$2y$10$BhfKgDfaRVkn95fu61NOQOrwsMjTWub4lH3U.Favp5JDurZvGnrP6'),
(2, 'Mr', 'Attendee', 'mrattendee@gmail.com', '$2y$10$cFpwpJWdcCm81I9PKsc35ez/reddj9l7iQf13Ukg/4mjhTZPRaDdq'),
(3, 'Brian', 'Hildebrand', 'bhildeb@gmail.com', '$2y$10$sa6/VUUuFIOe27uHT1QiPOOHbs5GLMKzWVOgsSEWutFUGcxir.26.'),
(4, 'Mr', 'Employee2', 'mremployee2@gmail.com', '$2y$10$HexBZlTL8WmjV1BXldPfUesRCorEZqADcAywfSAxfA.9v.GSSJhCa'),
(5, 'Test', 'User', 'test@gmail.com', '$2y$10$SeBq6xcK1VxylSlR2wLNweNtWRljcRf0.3PxwUX1.3EwYkXyi9IWa'),
(6, 'Test', 'Employee', 'testemployee@gmail.com', '$2y$10$/t7jEN7mCqfk5XBpun.qwOHwc/j1qYcJ6A5NyFlP1W34.BelufyjS'),
(7, 'Test', 'Admin', 'testadmin@gmail.com', '$2y$10$5AxplnnLOw91CjKqo6OIqOoBw0lome6DBIplJ9Gozs.7MCSMnlcEi');

-- --------------------------------------------------------

--
-- Table structure for table `Venue`
--

CREATE TABLE `Venue` (
  `VenueID` int(11) NOT NULL,
  `Venue_name` varchar(25) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(5) NOT NULL,
  `Zip` int(11) NOT NULL,
  `Description` varchar(150) NOT NULL,
  `Max_attendees` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Venue`
--

INSERT INTO `Venue` (`VenueID`, `Venue_name`, `Address`, `City`, `State`, `Zip`, `Description`, `Max_attendees`) VALUES
(0, 'Venue 100', '123 Main Street', 'Ann Arbor', 'MI', 12345, 'venue 100 description', 100),
(1, 'Michigan Theater', '603 E Liberty St', 'Ann Arbor', 'MI', 48104, 'Description for Michigan Theater', 100),
(2, 'Big Top Chautauqua', '101 W Bayfield St', 'Washburn', 'WI', 54891, 'Description for Big Top Chautauqua', 200),
(3, 'Father Hennepin Park', '420 SE Main St', 'Minneapolis', 'MN', 55414, 'Description for Father Hennepin park', 150),
(4, 'Test Venue', '123 Main St', 'Ann Arbor', 'MI', 48104, 'Test Venue description', 225);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Concert`
--
ALTER TABLE `Concert`
  ADD PRIMARY KEY (`ConcertID`);

--
-- Indexes for table `Schedule`
--
ALTER TABLE `Schedule`
  ADD PRIMARY KEY (`ScheduleID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `Venue`
--
ALTER TABLE `Venue`
  ADD PRIMARY KEY (`VenueID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
