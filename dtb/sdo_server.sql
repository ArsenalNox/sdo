-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2021 at 10:18 AM
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
-- Database: `sdo_server`
--

-- --------------------------------------------------------

--
-- Table structure for table `connectons`
--

CREATE TABLE `connectons` (
  `id` int(11) NOT NULL,
  `ip` varchar(120) NOT NULL,
  `uiqname` varchar(120) NOT NULL,
  `student_uid` varchar(120) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `group_nl` varchar(12) NOT NULL,
  `test_status` varchar(120) NOT NULL,
  `test_id` varchar(120) NOT NULL,
  `lastdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `connectons`
--

INSERT INTO `connectons` (`id`, `ip`, `uiqname`, `student_uid`, `status`, `group_nl`, `test_status`, `test_id`, `lastdate`) VALUES
(69, '94.41.177.73', '328a53e5d445ff51143e89e42789c8b6', '', 0, '', 'test_not_selected', 'tr_131', '2020-12-08 07:38:48'),
(70, '94.41.177.73', '91e4b5e9d23f4bb13d442958dc640f7c', '', 0, '', 'test_not_selected', 'tr_117', '2020-12-08 07:40:40'),
(71, '94.41.177.73', '50d3319fad18ab4d2149de2cdd55b083', '', 0, '', 'test_not_selected', 'tr_132', '2020-12-08 07:38:51'),
(72, '94.41.177.73', '4bb59f7a0f6d7021b533f29d100b8851', '', 0, '', 'test_not_selected', 'tr_120', '2020-12-12 06:09:05'),
(73, '94.41.177.73', 'f1d2f7f0369e2f42777b12d710c38e89', '', 0, '', 'test_not_selected', 'tr_116', '2020-12-08 07:40:48'),
(74, '94.41.177.73', '491e689414f1116eb3736d1b23d2fb78', '', 0, '', 'test_not_selected', 'tr_127', '2020-12-08 07:40:53'),
(75, '94.41.177.73', '447475f5eecb2a588fde7174de8931c1', '', 0, '', 'test_not_selected', 'tr_124', '2020-12-08 07:40:36'),
(76, '94.41.177.73', '8a533dfbe9f1bfbbd23c1d67e6bce972', '', 0, '', 'test_not_selected', 'tr_126', '2020-12-08 07:40:46'),
(77, '94.41.177.73', 'fef0631190a03ac0a01c6f77659c678f', '', 0, '', 'test_not_selected', 'tr_125', '2020-12-08 07:40:31'),
(78, '94.41.177.73', '5d59667e635636734facc339b065f6f0', '', 0, '', 'test_not_selected', 'tr_130', '2020-12-08 07:38:53'),
(79, '94.41.177.73', '02d9744eeb4b96a7db853e0b856da20b', '', 0, '', 'test_not_selected', 'tr_133', '2020-12-08 07:42:09'),
(80, '94.41.177.73', '08f3e0531f35550c38de9698f770489d', '', 0, '', 'test_not_selected', 'tr_110', '2020-12-08 07:27:35'),
(81, '94.41.177.73', '05e06ebb58fbbd6c1348dc4d2b29d276', '', 0, '', 'test_not_selected', 'tr_114', '2020-12-08 07:41:00'),
(82, '94.41.177.73', '1f356ac5a627ac25e2166265ebdb9a63', '', 0, '', 'test_not_selected', 'tr_134', '2020-12-08 07:42:04'),
(83, '94.41.177.73', '6f2275c2474349726b6147c19357970b', '', 0, '', 'test_not_selected', 'tr_123', '2020-12-08 07:39:54'),
(84, '94.41.177.73', 'ae7268855dadcea81aca550ec3eeca52', '', 0, '', 'test_not_selected', 'tr_129', '2020-12-08 07:40:17'),
(85, '94.41.177.73', '50dad36504e8e81370fc853dc4f88f68', '', 0, '', 'test_not_selected', 'tr_113', '2020-12-08 07:31:27'),
(86, '94.41.177.73', '9593ba8966c73452e71f1178c56321a3', '', 0, '', 'test_not_selected', 'tr_135', '2020-12-08 07:41:59'),
(87, '94.41.177.73', 'ded9047d9b146e045812f0c96513bffa', '', 0, '', 'test_not_selected', 'tr_111', '2020-12-08 07:39:59'),
(88, '94.41.177.73', '367111c6fb27d811b44c2c34418e8e44', '', 0, '', 'test_not_selected', 'tr_137', '2020-12-08 07:43:08'),
(89, '94.41.177.73', 'd06d2387e8fb23ebe4fb713f8297a98c', '', 0, '', 'test_not_selected', 'tr_121', '2020-12-08 07:42:16'),
(90, '94.41.177.73', '4ef300b1e9eadad4fa913d8cb218be8e', '', 0, '', 'test_not_selected', 'tr_128', '2020-12-08 07:39:05'),
(91, '94.41.177.73', '6632a8fd879d98291e07910ca9d234f8', '', 0, '', 'test_not_selected', 'tr_115', '2020-12-08 07:39:04'),
(92, '94.41.177.73', '9db20834035be3b5552d0cdb517890c6', '', 0, '', 'test_not_selected', '', '2020-12-08 07:40:35'),
(93, '94.41.177.73', 'b784cf8e025050e4f87bf8858c55cddc', '', 0, '', 'test_not_selected', 'tr_118', '2020-12-08 07:39:58'),
(94, '94.41.177.73', '2d1f5eec7ed036ccc885e02bf1a661ec', '', 0, '', 'test_not_selected', 'tr_119', '2020-12-08 07:40:26'),
(95, '85.26.233.10', 'eda488ce5626403e25925ac2a012d81d', '', 0, '', 'test_not_selected', 'tr_112', '2020-12-08 07:40:25'),
(96, '192.168.101.250', 'a96db554807e202a547b762205b035ac', '', 0, '', 'test_not_selected', '', '2020-12-08 06:38:16'),
(97, '94.41.177.73', '1f3ffa140ae9628620e54a5ddf27bfae', '', 0, '', 'test_not_selected', 'tr_136', '2020-12-08 07:42:47'),
(98, '83.149.21.165', '660b4def91e792142ed566b2b6d8f970', '', 0, '', 'test_not_selected', '', '2020-12-08 12:39:42'),
(99, '92.62.150.140', 'a7d7e3d4118b00d94121957dc127c591', '', 0, '', 'test_not_selected', '', '2020-12-12 20:15:04'),
(100, '192.168.101.73', 'cd30849594722adc369fd03467dc637a', '', 0, '', 'test_not_selected', '', '2020-12-12 10:44:15'),
(101, '192.168.101.117', '504d49ba9fa3d228216d92d3d4f982fe', '', 0, '', 'test_not_selected', '', '2020-12-12 08:01:51'),
(102, '::1', '709984b3cdc9664d090d9cbc4682d6b9', 'Стрелков Варлаам Филиппович', 0, '8Б', 'test_started', '', '2020-12-12 10:35:45'),
(103, '::1', 'be0ea881a7c5bb8bc96358148db5084c', '', 0, '', '', '', '2020-12-14 12:51:21');

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
(29, '2020-12-08', 'Работа с текстовыми заданиями', '4A', 45, 'Математика', 8),
(30, '2020-12-08', 'Работа с текстовыми заданиями', '4Б', 45, 'Математика', 8),
(31, '2020-12-12', 'Электрический ток. Электрические цепи', '8Б', 45, 'Физика', 8);

-- --------------------------------------------------------

--
-- Table structure for table `entrylogs`
--

CREATE TABLE `entrylogs` (
  `id` varchar(120) NOT NULL,
  `name` varchar(120) NOT NULL,
  `ip` varchar(120) NOT NULL,
  `entryTime` datetime NOT NULL,
  `exitTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entrylogs`
--

INSERT INTO `entrylogs` (`id`, `name`, `ip`, `entryTime`, `exitTime`) VALUES
('5fcf129a8bc99', '2f6a5efbc382e1ae8e147fd19dd9c768', '85.26.233.10', '2020-12-08 06:43:54', NULL),
('5fcf1b08d1fa7', '154874a35270d3e823acad8f91bfc980', '31.13.144.64', '2020-12-08 07:19:52', NULL),
('5fcf1c70d3c20', '8eff7c7f0f7396fa129dbe1f736573d8', '94.41.177.73', '2020-12-08 07:25:52', '2020-12-08 07:27:23'),
('5fcf1dd51333f', '8eff7c7f0f7396fa129dbe1f736573d8', '94.41.177.73', '2020-12-08 07:31:49', '2020-12-08 07:34:53'),
('5fcf1e5583bc0', '8414f9e38e979654478e2870337eb190', '85.26.233.10', '2020-12-08 07:33:57', NULL),
('5fcf1fa56104a', '8eff7c7f0f7396fa129dbe1f736573d8', '94.41.177.73', '2020-12-08 07:39:33', NULL),
('5fcf356a30d02', 'bfaf30c98b3524b953669a528110590b', '::1', '2020-12-08 09:12:26', NULL),
('5fd198661e42d', 'bfaf30c98b3524b953669a528110590b', '::1', '2020-12-10 04:39:18', NULL),
('5fd19dd1d6eeb', '3ae778119e3a6e22f3bd61611b1bd5f5', '31.13.144.17', '2020-12-10 05:02:25', NULL),
('5fd1fa7acba21', '480b147d374e58cf3e7367562f04da28', '85.26.234.73', '2020-12-10 11:37:46', '2020-12-10 11:39:04'),
('5fd1fadad6ef7', '480b147d374e58cf3e7367562f04da28', '85.26.234.73', '2020-12-10 11:39:22', NULL),
('5fd323261e204', '23b4ba709cce1c3fb9fe05c85a0f6260', '192.168.101.73', '2020-12-11 08:43:34', NULL),
('5fd33aa6ce41c', 'bfaf30c98b3524b953669a528110590b', '::1', '2020-12-11 10:23:50', NULL),
('5fd46aed3b427', '9169edb304d95f57c2a37ebfe166d327', '192.168.101.117', '2020-12-12 08:02:05', NULL),
('5fd47c640f251', 'bfaf30c98b3524b953669a528110590b', '::1', '2020-12-12 09:16:36', NULL),
('5fd486face1aa', '23b4ba709cce1c3fb9fe05c85a0f6260', '192.168.101.73', '2020-12-12 10:01:46', NULL),
('5fd6e0c62da80', 'bfaf30c98b3524b953669a528110590b', '::1', '2020-12-14 04:49:26', NULL),
('5fd71f737506e', '0283c72e452fd55303b69e4bb142dab8', '::1', '2020-12-14 09:16:51', NULL),
('5fd751bcc4471', '0283c72e452fd55303b69e4bb142dab8', '::1', '2020-12-14 12:51:24', NULL);

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
(5, '4A'),
(6, '4Б'),
(7, '8Б'),
(8, '7Б');

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
(2, 'Работа с текстовыми заданиями', '7', 'json/Working_with_word_problems/wwwp.json', 'Математика'),
(3, 'Пространственные отношения и геометрические фигуры', '7', 'json/Working_with_word_problems/wwwp.json', 'Математика'),
(4, 'Контрольная работа', '9', 'json/Working_with_word_problems/Контрольная работа.json', 'Биология'),
(9, 'Работа и мощность тока. Закон Джоуля-Ленца', '8', 'tests/Работа_и_мощность_тока._Закон_Джоуля-Ленца/Работа и мощность тока. Закон Джоуля-Ленца.json', 'Физика'),
(10, 'Работа и мощность тока. Закон Джоуля-Ленца', '8', 'tests/Работа_и_мощность_тока._Закон_Джоуля-Ленца/Работа и мощность тока. Закон Джоуля-Ленца.json', 'Физика'),
(11, 'Химические свойства оксидов', '8', 'tests/Химические_свойства_оксидов/Химические свойства оксидов.json', 'химия'),
(12, 'Итоговая годовая контрольная работа', '8', 'tests/Итоговая_годовая_контрольная_работа/Итоговая годовая контрольная работа.json', 'Химия'),
(13, 'Итоговая годовая контрольная работа', '9', 'tests/Итоговая_годовая_контрольная_работа/Итоговая годовая контрольная работа.json', 'Химия'),
(14, 'Итоговая годовая контрольная работа', '10', 'tests/Итоговая_годовая_контрольная_работа/Итоговая годовая контрольная работа.json', 'Химия'),
(21, 'Электрический ток. Электрические цепи', '8', 'tests/Электрический_ток._Электрические_цепи/Электрический ток. Электрические цепи.json', 'Физика'),
(22, 'Уравнения', '7', 'tests/Уравнения/Уравнения.json', 'Математика');

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
(10, 'Михаил', 'Калинин', 'Антонович', 2),
(11, 'Варлаам', 'Стрелков', 'Филиппович', 7),
(13, 'Евгений', 'Авинов', ' ', 5),
(14, 'Ксения', 'Бежецких', ' ', 5),
(15, 'Абдухалил', 'Хайитов', ' ', 5),
(16, 'Анна', 'Бессонова', ' ', 5),
(17, 'Федор', 'Жуков', ' ', 5),
(18, 'Егор', 'Журавлев', ' ', 5),
(19, 'Мария', 'Мальцева', ' ', 5),
(20, 'Елизавета', 'Нефедова', ' ', 5),
(21, 'Всеволод', 'Распятиков', ' ', 5),
(22, 'Семен', 'Семенов', ' ', 5),
(23, 'Дарина', 'Аменова', ' ', 5),
(24, 'Анна', 'Варникова', ' ', 5),
(25, 'Тимур', 'Жаппаров', ' ', 5),
(26, 'Денис', 'Афанасьев', ' ', 5),
(27, 'Егов', 'Донковцев', ' ', 5),
(28, 'Миша', 'Анисимов', ' ', 6),
(29, 'Злата', 'Костина', ' ', 6),
(30, 'Полина', 'Кладова', ' ', 6),
(31, 'Иван', 'Денисов', ' ', 6),
(32, 'Лев', 'Литвинцев', ' ', 6),
(33, 'Степан', 'Алексеев', ' ', 6),
(34, 'Кирилл', 'Анучин', ' ', 6),
(35, 'Павел', 'Ахмедов', ' ', 6),
(36, 'Никита', 'Долгов', ' ', 6),
(37, 'Семен', 'Каравайцев', ' ', 6),
(38, 'Екатерина', 'Лукьянова', ' ', 6),
(39, 'Сергей', 'Тугов', ' ', 6),
(40, 'Андрей', 'Хайнюк', ' ', 6),
(41, 'Камилла', 'Япрынцева', ' ', 6),
(42, 'Даниль', 'Мазитов', ' ', 6);

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
  `student_id` int(11) NOT NULL,
  `student` varchar(120) NOT NULL,
  `class` varchar(120) NOT NULL,
  `date` date NOT NULL,
  `module` varchar(120) NOT NULL,
  `percent` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`id`, `student_id`, `student`, `class`, `date`, `module`, `percent`) VALUES
(110, 0, 'Нефедова Елизавета  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '14%'),
(111, 0, 'Жуков Федор  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '100%'),
(112, 13, 'Авинов Евгений  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(113, 0, 'Долгов Никита  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(114, 0, 'Мальцева Мария  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(115, 0, 'Распятиков Всеволод  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '71%'),
(116, 0, 'Костина Злата  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(117, 0, 'Денисов Иван  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(118, 26, 'Афанасьев Денис  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(119, 0, 'Кладова Полина  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '71%'),
(120, 0, 'Литвинцев Лев  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(121, 0, 'Тугов Сергей  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '71%'),
(122, 0, 'Жаппаров Тимур  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '57%'),
(123, 0, 'Семенов Семен  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '100%'),
(124, 23, 'Аменова Дарина  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(125, 0, 'Донковцев Егов  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '57%'),
(126, 0, 'Журавлев Егор  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '100%'),
(127, 0, 'Варникова Анна  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(128, 0, 'Лукьянова Екатерина  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(129, 0, 'Бессонова Анна  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '57%'),
(130, 33, 'Алексеев Степан  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '71%'),
(131, 0, 'Ахмедов Павел  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(132, 0, 'Каравайцев Семен  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(133, 0, 'Хайитов Абдухалил  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(134, 34, 'Анучин Кирилл  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '71%'),
(135, 0, 'Мазитов Даниль  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '100%'),
(136, 0, 'Бежецких Ксения  ', '4A', '2020-12-08', 'Работа с текстовыми заданиями', '86%'),
(137, 0, 'Хайнюк Андрей  ', '4Б', '2020-12-08', 'Работа с текстовыми заданиями', '71%');

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
-- Indexes for table `entrylogs`
--
ALTER TABLE `entrylogs`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connectons`
--
ALTER TABLE `connectons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `current_test`
--
ALTER TABLE `current_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `group_student`
--
ALTER TABLE `group_student`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_module`
--
ALTER TABLE `new_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `teach`
--
ALTER TABLE `teach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
