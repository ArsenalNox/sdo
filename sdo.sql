-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2020 at 03:43 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

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
(21, '::1', 'Исхаков Даниил Рамильевич', 1, '8A', 'test_not_selected', 'tr_65');

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

--
-- Dumping data for table `current_test`
--

INSERT INTO `current_test` (`id`, `date`, `test_dir`, `group_to_test`, `time_to_complete`, `subject`, `question_num`) VALUES
(2, '2020-10-15', 'Working with word problems', '9A', 45, 'Math', 8),
(5, '2020-10-15', 'Пространственные отношения и геометрические фигуры', '8A', 20, 'Math', 8),
(7, '2020-10-15', 'Working with word problems', '8A', 45, 'Math', 8),
(8, '2020-10-28', 'Пространственные отношения и геометрические фигуры', '7A', 45, 'Math', 8),
(9, '2020-10-28', 'Working with word problems', '7A', 45, 'Math', 8);

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
(2, 'Working with word problems', '7', 'json/Working_with_word_problems/wwwp.json', 'Math'),
(3, 'Пространственные отношения и геометрические фигуры', '7', 'json/Working_with_word_problems/wwwp.json', 'Math');

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
(1, 'Елизавета', 'Ансимиова', 'Адеева', 1),
(2, 'Матвей', 'Беляев', 'Артёмович', 1),
(3, 'Виталий', 'Горбушин', 'Валерьевич', 1),
(4, 'Алексей', 'Гриненко', 'Алексеевич', 1),
(5, 'Марк', 'Грунталь', 'Альбертович', 1),
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
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`id`, `student`, `class`, `date`, `module`, `percent`) VALUES
(65, 'Исхаков Даниил Рамильевич', '8A', '2020-11-03', 'Working with word problems', '0%');

-- --------------------------------------------------------

--
-- Table structure for table `tr_65`
--

CREATE TABLE `tr_65` (
  `id` int(4) NOT NULL,
  `Question_var` int(4) DEFAULT NULL,
  `Question_text` varchar(512) DEFAULT NULL,
  `Given_answer` varchar(512) DEFAULT NULL,
  `Correct_answer` varchar(512) DEFAULT NULL,
  `Correctness` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tr_65`
--

INSERT INTO `tr_65` (`id`, `Question_var`, `Question_text`, `Given_answer`, `Correct_answer`, `Correctness`) VALUES
(1, 2, 'Решите задачу: Для приготовления 10 пол-литровых банок салата из чёрной̆ редьки, кроме других продуктов, надо 3 кг редьки. Сколько килограммов редьки нужно, чтобы приготовить 30 таких же банок салата?', '', '9 кг', 0),
(2, 1, 'Решите задачу:  Между двумя гаванями 1 530 км. Два корабля вышли одновременно из этих гаваней и идут друг другу навстречу. Один корабль проходит в час 24 км, другой – 7 этого расстояния. Сколько километров пройдёт каждый из них до встречи?', '', '816 км; 714 км', 0),
(3, 3, 'Решите задачу: На заводе было 3 600 рабочих. 3/5 всех рабочих составляли мужчины, а остальные – женщины. Сколько женщин было на заводе?', '', '1440 женщин', 0),
(4, 3, 'На диаграмме показано количество каждого вида цветов на клумбе – ромашек, фиалок, тюльпанов и колокольчиков. Известно, что больше всего ромашек, меньше всего фиалок, а тюльпанов больше, чем колокольчиков. Используя диаграмму, ответьте на вопрос. Сколько фиалок на клумбе?', '', '10', 0),
(5, 3, 'В одной из поездок Елена сначала проехала 4 км за 10 минут, а затем ещё 2 км за следующие 5 минут. Верно ли следующее утверждение? Средняя скорость Елены была меньше в первые 10 минут, чем в последующие 5 минут.', '', 'Неверно', 0),
(6, 1, 'За каждую эстафету команда получает количество баллов, равное занятому в этой эстафете месту, затем баллы по всем эстафетам суммируются. Какая команда получила 3 балла в третьей эстафете?', '', 'Рывок', 0),
(7, 1, 'Рассмотрите данную таблицу, дайте ответ на вопрос. Для приготовления 100 миллилитров (мл) заправки для салата потребуется: Сколько миллилитров (мл) салатного масла понадобится, чтобы сделать 150 мл этой заправки?', '', '90 мл', 0);

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
-- Indexes for table `tr_65`
--
ALTER TABLE `tr_65`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connectons`
--
ALTER TABLE `connectons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `current_test`
--
ALTER TABLE `current_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tr_65`
--
ALTER TABLE `tr_65`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
