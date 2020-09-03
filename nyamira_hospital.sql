-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2019 at 12:07 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nyamira_hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `userId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `ward` varchar(10) NOT NULL,
  `bed` varchar(10) NOT NULL,
  `doctor` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`userId`, `name`, `ward`, `bed`, `doctor`, `date`, `time`) VALUES
(1, '1', 'g1', '12', '1', '2016-08-10', '2018-06-21 11:51:11'),
(2, '1', 'g1', '12', '1', '2016-08-10', '2018-06-21 11:52:47'),
(3, 'kevin', 'g2', '32', 'cyrus', '2016-08-10', '2018-06-21 11:53:24'),
(4, 'kevin', 'b1', '43', 'lucy', '2016-08-10', '2018-06-21 11:55:28'),
(5, 'kevin', 'b2', '22', 'wqeda', '2016-08-10', '2018-06-21 12:00:01'),
(6, 'dsfds', 'g2', '45', 'tim', '2018-07-10', '2018-06-21 15:14:14'),
(7, 'kevin', 'g2', '12', 'tom', '2016-08-10', '2018-06-23 16:24:56'),
(8, 'kevin munene', '', '', '', '0000-00-00', '2018-09-27 10:59:37'),
(9, 'kevin munene', '', '', '', '0000-00-00', '2018-09-27 11:08:07'),
(10, 'kevin munene', '', '', '', '0000-00-00', '2018-09-27 11:09:38'),
(11, 'kevin munene', '', '', '', '0000-00-00', '2018-09-27 11:10:13'),
(12, 'Select Patient', '', '', 'doctor', '0000-00-00', '2019-06-28 09:01:03'),
(13, 'Select Patient', '', '', 'doctor', '0000-00-00', '2019-06-28 09:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `userId` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `doctor` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`userId`, `fname`, `lname`, `phone`, `doctor`, `date`, `time`) VALUES
(1, 'jim', 'kennedy', '0722768549', 'Levonne', '2018-07-10', '12 noon'),
(2, 'milicah', 'njeri', '0734576899', 'lucy', '2018-07-10', '4 pm'),
(3, 'kevin', 'kennedy', '0712457947', 'tom', '2018-07-12', '12 noon'),
(4, 'milicah', 'Aputo', '0742021083', 'Fred', '2018-05-12', '4:34pm'),
(5, 'jim', 'kennedy', '0712457947', 'tim', '2016-08-10', '4 pm'),
(6, 'Milcah', 'Aputo', '0742021083', 'Fred', '2019-06-20', '11am'),
(7, 'Moses', 'Ocharo', '0718653422', 'Fred', '2019-06-01', '11:00AM'),
(8, '', '', '', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `userId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `number` varchar(10) NOT NULL,
  `discharged` varchar(10) NOT NULL,
  `room` varchar(10) NOT NULL,
  `medicine` varchar(10) NOT NULL,
  `amount` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`userId`, `name`, `gender`, `number`, `discharged`, `room`, `medicine`, `amount`) VALUES
(1, 'kevin munene', 'Male', '0716641005', '', '5000', '5000', '10000'),
(2, 'JIMMY', 'Male', '0712147841', '2018/02/12', '2000', '1000', '3000'),
(3, 'select patient', 'Male', '', '', '', '', ''),
(4, 'select patient', 'Male', '', '', '', '', ''),
(5, 'select patient', 'Male', '', '', '', '', ''),
(6, 'milcah Aputo', 'Female', '0742021083', '2019/06/20', '1000', '7000', '8000'),
(7, 'Moses Ocharo', 'Male', '0718486544', '2019/04/23', '500', '600', '1100');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `userId` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` int(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `speciality` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`userId`, `fname`, `lname`, `email`, `phone`, `address`, `date_of_birth`, `speciality`, `department`, `username`, `password`) VALUES
(1, 'Fred', 'Nyaboga', 'frednyaboga10@gmail.com', 722520741, '144 Nyamira', '1996-12-15', 'specialit\r\n				', 'Renal', 'fredd', 'bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a'),
(2, 'lucy', 'kendi', 'lucy@gmail.com', 710214562, '657-657 Kerugoya', '1970-11-04', 'specialit\r\n			', 'ENT', 'lucy', 'bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a'),
(3, 'waeda', 'sadi', 'adasa@gmail.com', 747483647, '646-76 Kisumu', '1999-10-10', 'specialit				', 'sad', '111111', 'bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a'),
(4, 'tim', 'Khasakala', 'tim@tim.com', 2147483647, '86-868 Kakamega', '1000-10-10', 'specialit\r\n				', 'Pharmacy', 'tim', 'bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a'),
(5, 'tom', 'tommy', 'tom@gmail.com', 734746265, '213 Nairobi', '1943-12-02', 'nurse				', 'theatre', 'tom', 'bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a'),
(6, 'Levonne', 'vuyombe', 'vuyombe@gmail.com', 715478471, '1234 Nairobi', '1994-10-12', 'Specialist\r\n				', 'CTC', 'Levonne', 'bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a'),
(7, 'Muthike', 'Wanjiku', 'wanjiku25@gmail.com', 714866485, '20 Kiambu', '1995-04-14', 'dentist\r\n				', 'dental care', 'milan', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
(8, 'cyrus', 'bundi', 'cyrus@gmail.com', 716641005, '43844 Nairobi', '1990-10-12', 'optician\r\n				', 'ENT\r\n', 'cyro', 'bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a'),
(9, 'Fred', 'Nyaboga', 'Nyaboga10@gmail.com', 722520741, '40-500 Nairobi', '1996-12-15', 'Medical Doctor\r\n				', 'CTC', 'freddie', 'bc6f82f15ec431b9893cec176f5ba72d495c988723269b86b60f90e6dfa120d5'),
(10, 'Nerus', 'Dickson', 'nereuscorazon10@gmail.com', 727300141, '200-540', '2000-12-12', 'Optician\r\n				', 'Opticiary', 'Nereus', '2cbb9cfa217be95e7cac55ab30d9897cbd4af2bbdef5e80eef106e4596c04ee9'),
(11, 'carol', 'ndegwa', 'caronde@gmail.com', 722345412, '333-9998', '1996-12-15', 'medical doctor\r\n				', 'renal', 'caro', 'ef46657fa6e5fa12f77773b8be355aa36f241d182de658af2ba9f48356376e6c'),
(12, 'gabriel', 'eva', 'gabueva@gmail.com', 796034555, 'kinyanjui', '1997-09-09', 'medical doctor\r\n				', 'renal', 'gabu', '909c5d7e7647af2be32bc5043e67669da957c0c4a0e436940c5f8a4763404e95');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `userId` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(100) NOT NULL,
  `blood_group` varchar(50) NOT NULL,
  `diagnosis` varchar(1000) NOT NULL,
  `date_of_admission` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`userId`, `fname`, `lname`, `email`, `phone`, `address`, `date_of_birth`, `gender`, `blood_group`, `diagnosis`, `date_of_admission`) VALUES
(1, 'kevin', 'munene', 'kevin@gmail.com', '0712457947', 'kutus', '1990-12-12', 'male', 'O-', 'Cancer\r\n', '2018-02-01'),
(2, 'winnie', 'bona', 'melvin@gmail.com', '0712457947', 'kutus', '1990-12-12', 'female', 'B+', 'pneumonia', '2018-02-02'),
(3, 'kevin', 'munene', 'kevin@gmail.com', '0712457947', '776-76788-Nairobi', '1990-12-12', 'male', 'O+', 'leukemia\r\n', '2018-03-04'),
(4, 'martin', 'makori', 'makori@gmail.com', '0722452344', '54356', '1993-12-12', 'Male', 'O+', 'typhoid', '2018-03-04'),
(5, 'Ruth', 'Awinja', 'kevin@gmail.com', '0712457947', 'h664', '1990-12-12', 'female', 'B-', 'amoeba', '2019-03-02'),
(6, 'Martha', 'kim', 'kim@gmail.com', '0713154784', '43844', '1995-12-10', 'female\r\n', 'B+', '\r\nUlcers', '2019-03-02'),
(7, 'july', 'august', 'july@gmail.com', '0711764522', 'd235510', '1995-12-08', 'male', 'B+', 'malaria', '2019-04-01'),
(8, 'paul', 'omondi', '999chh', '0734746265', '267627', '1980-12-12', 'Male', 'o', 'headache', '2019-04-01'),
(9, 'milcah', 'Aputo', 'Aputo@gmail.com', '0742021083', 'kakamega', '1999-10-27', 'Female', 'B+', 'Malaria', '2019-04-01'),
(10, 'fred', 'namu', 'fred@gmail.com', '07225267876', 'jfwhf22', '1996-12-13', 'Male', 'o', '2009/01/7', '0000-00-00'),
(11, '', '', '', '', '', '0000-00-00', 'Male', '', '', '0000-00-00'),
(12, '', '', '', '', '', '0000-00-00', 'Male', '', '', '0000-00-00'),
(13, 'Moses', 'Ocharo', 'ochamose@gmail.com', '0718653422', 'Kinyanjui', '1989-09-09', 'Male', 'AB+', '2019/04/05', '0000-00-00'),
(14, '', '', '', '', '', '0000-00-00', 'Male', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `Month` text NOT NULL,
  `Ailment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
