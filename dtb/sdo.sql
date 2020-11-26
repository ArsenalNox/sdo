-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2020 at 06:03 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdo`
--

-- --------------------------------------------------------

--
-- Table structure for table `connectons`
--

CREATE TABLE `connectons` (
  `id` int(11) NOT NULL,
  `ip` varchar(120) NOT NULL,
  `student_uid` varchar(120) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `group_nl` varchar(12) NOT NULL,
  `test_status` varchar(120) NOT NULL,
  `test_id` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `connectons`
--

INSERT INTO `connectons` (`id`, `ip`, `student_uid`, `status`, `group_nl`, `test_status`, `test_id`) VALUES
(25, '::1', 'Ansimova Elizabeth Abdeeva', 1, '7A', 'test_not_selected', 'tr_86');

-- --------------------------------------------------------

--
-- Table structure for table `current_test`
--

CREATE TABLE `current_test` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `test_dir` varchar(120) NOT NULL,
  `group_to_test` varchar(120) NOT NULL,
  `time_to_complete` int(12) NOT NULL,
  `subject` varchar(120) NOT NULL,
  `question_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `date`
--

CREATE TABLE `date` (
  `ID` int(20) NOT NULL,
  `DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_student`
--

CREATE TABLE `group_student` (
  `ID` int(4) NOT NULL,
  `NAME` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_student`
--

INSERT INTO `group_student` (`ID`, `NAME`) VALUES
(1, '7A'),
(2, '8A'),
(3, '7B'),
(4, '9A');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `ID` int(10) NOT NULL,
  `ID_QUESTION` int(10) NOT NULL,
  `QUESTIONS` longtext DEFAULT NULL,
  `JSON_QUESTION` longtext NOT NULL CHECK (json_valid(`JSON_QUESTION`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `new_module`
--

CREATE TABLE `new_module` (
  `id` int(11) NOT NULL,
  `Name` varchar(120) NOT NULL,
  `Class` varchar(120) NOT NULL,
  `Questions` longtext NOT NULL,
  `subject` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `new_module`
--

INSERT INTO `new_module` (`id`, `Name`, `Class`, `Questions`, `subject`) VALUES
(28, '', '', 'tests//.json', '');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `ID` int(10) NOT NULL,
  `JSON_QUESTION` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `ID` int(7) NOT NULL,
  `NAME` varchar(28) NOT NULL,
  `LAST_NAME` varchar(28) NOT NULL,
  `MIDDLE_NAME` varchar(28) NOT NULL,
  `GROUP_STUDENT_ID` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`ID`, `NAME`, `LAST_NAME`, `MIDDLE_NAME`, `GROUP_STUDENT_ID`) VALUES
(1, 'Elizabeth', 'Ansimova', 'Abdeeva', 1),
(2, 'Marvey', 'Bekyaev', 'Artyomovich', 1),
(3, 'Виталий', 'Горбушин', 'Валерьевич', 1),
(4, 'Алексей', 'Гриненко', 'Алексеевич', 1),
(5, 'Марк', 'Грунталь', 'Альбертович', 1),
(6, 'George', 'Gurskyi', 'Valentinovich', 2),
(7, 'Очир', 'Джемгиров', 'Санджиевич', 2),
(8, 'Ярослав', 'Дунаев', 'Александрович', 2),
(9, 'Даниил', 'Исхаков', 'Рамильевич', 2),
(10, 'Михаил', 'Калинин', 'Антонович', 2);

-- --------------------------------------------------------

--
-- Table structure for table `teach`
--

CREATE TABLE `teach` (
  `id` int(11) NOT NULL,
  `uid` text NOT NULL,
  `pwd` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teach`
--

INSERT INTO `teach` (`id`, `uid`, `pwd`) VALUES
(1, 'uid', 'pwd');

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `id` int(11) NOT NULL,
  `student` varchar(120) NOT NULL,
  `class` varchar(120) NOT NULL,
  `date` date NOT NULL,
  `module` varchar(120) NOT NULL,
  `percent` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connectons`
--
ALTER TABLE `connectons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_test`
--
ALTER TABLE `current_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `date`
--
ALTER TABLE `date`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `group_student`
--
ALTER TABLE `group_student`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `new_module`
--
ALTER TABLE `new_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK` (`GROUP_STUDENT_ID`);

--
-- Indexes for table `teach`
--
ALTER TABLE `teach`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connectons`
--
ALTER TABLE `connectons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `current_test`
--
ALTER TABLE `current_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `date`
--
ALTER TABLE `date`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_student`
--
ALTER TABLE `group_student`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_module`
--
ALTER TABLE `new_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teach`
--
ALTER TABLE `teach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK` FOREIGN KEY (`GROUP_STUDENT_ID`) REFERENCES `group_student` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
