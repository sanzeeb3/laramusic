-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2016 at 05:12 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laramusic`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `q_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `answer` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `q_id`, `user_id`, `answer`) VALUES
(76, 61, 2, 'United stores of asses'),
(77, 62, 3, 'Slash'),
(78, 65, 2, 'Hari '),
(79, 64, 1, 'Haha'),
(80, 65, 1, 'asdf'),
(81, 65, 1, 'asdfv'),
(82, 65, 1, 'vvvdf'),
(83, 65, 1, 'Answer here...bfg'),
(84, 65, 1, 'dfer');

-- --------------------------------------------------------

--
-- Table structure for table `betplayers`
--

CREATE TABLE `betplayers` (
  `id` int(11) NOT NULL,
  `match_id` int(11) DEFAULT NULL,
  `player` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `betplayer_user`
--

CREATE TABLE `betplayer_user` (
  `betplayer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bets`
--

CREATE TABLE `bets` (
  `id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `team` varchar(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `win_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bets`
--

INSERT INTO `bets` (`id`, `match_id`, `price`, `team`, `created_at`, `updated_at`, `win_price`) VALUES
(13, 8, 500, 'SOU', '2016-09-29', '2016-09-29', 1000),
(14, 8, 200, 'SOU', '2016-09-29', '2016-09-29', 400),
(15, 4, 5, 'WHU', '2016-09-29', '2016-09-29', 15),
(16, 12, 89, 'CRY', '2016-10-03', '2016-10-03', 400.5),
(17, 17, 34, 'ARS', '2016-10-18', '2016-10-18', 136);

-- --------------------------------------------------------

--
-- Table structure for table `bet_user`
--

CREATE TABLE `bet_user` (
  `bet_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bet_user`
--

INSERT INTO `bet_user` (`bet_id`, `user_id`) VALUES
(11, 3),
(12, 2),
(13, 2),
(14, 3),
(15, 2),
(16, 3),
(17, 2),
(18, 2),
(19, 2),
(16, 4),
(17, 3);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_body` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `answer_id`, `user_id`, `comment_body`) VALUES
(1, 77, 3, 'did you mean saul hudson?'),
(2, 77, 3, 'he;s great'),
(3, 78, 2, 'hari? lol'),
(4, 78, 2, 'Comment here...'),
(5, 79, 1, 'what??');

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `team1` varchar(30) DEFAULT NULL,
  `team2` varchar(30) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `team1_value` float DEFAULT NULL,
  `team2_value` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`id`, `team1`, `team2`, `start_date`, `team1_value`, `team2_value`) VALUES
(1, 'CHE', 'EVE', '2016-10-14', 4.3, 2),
(2, 'CHE', 'LIV', '2016-10-13', 6.5, 8),
(3, 'MUN', 'CHE', '2016-09-26', 3.2, 1),
(4, 'WHU', 'WBA', '2016-09-05', 3, 1),
(5, 'BUR', 'BOU', '2016-09-27', 2, 3.4),
(6, 'STK', 'MID', '2016-10-01', 4, 1.645),
(7, 'MCI', 'STK', '2016-09-28', 1.24, 4),
(8, 'BOU', 'SOU', '2016-09-27', 3, 2),
(9, 'WHU', 'MCI', '2016-10-30', 1.9, 3.2),
(10, 'CRY', 'ARS', '2016-09-02', 1.1, 67),
(11, 'MUN', 'MCI', '2016-09-07', 1.6, 1.2),
(12, 'STK', 'CRY', '2016-10-04', 1.2, 4.5),
(13, 'MUN', 'CHE', '2016-08-13', 32, 3),
(14, 'ARS', 'CHE', '2016-10-14', 3.2, 3.2),
(15, 'MUN', 'CHE', '2016-10-15', 23, 1.34),
(16, 'CRY', 'STO', '2016-10-07', 4, 1.4),
(17, 'ARS', 'CHE', '2016-10-22', 4, 2),
(18, 'CHE', 'BUR', '2016-10-22', 1.25, 5);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `team` varchar(40) DEFAULT NULL,
  `player_name` varchar(30) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`team`, `player_name`, `id`) VALUES
('ARS', 'Mesut Ozil', 1),
('CHE', 'Ivanovic', 2),
('MCI', 'David Silva', 3),
('MCI', 'Sergio Augerio', 5),
('MCI', 'Otamendi', 7),
('MUN', 'Rooney', 8),
('MUN', 'Rashford', 9),
('MUN', 'Martial', 10),
('LEI', 'Mahrez', 11),
('LEI', 'Vardy', 12),
('LEI', 'Albrighton', 13),
('ARS', 'Alexis Sanchez', 14),
('ARS', 'Hector Bellerin', 15),
('ARS', 'Nacho Monreal', 16),
('CHE', 'Eden Hazard', 17),
('CHE', 'John Terry', 18),
('CHE', 'Azpilicueta', 19),
('CHE', 'Willian', 20),
('CHE', 'Pedro Rodriguez', 21);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) NOT NULL,
  `question` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`) VALUES
(61, 'What is the full form of USA?'),
(62, 'Who is the lead guitarist of the band GNR?'),
(64, 'What are the sources of energy?');

-- --------------------------------------------------------

--
-- Table structure for table `question_user`
--

CREATE TABLE `question_user` (
  `user_id` int(11) DEFAULT NULL,
  `q_id` int(11) DEFAULT NULL,
  `approved` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_user`
--

INSERT INTO `question_user` (`user_id`, `q_id`, `approved`) VALUES
(1, 66, NULL),
(1, 66, 1),
(2, 66, 0);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(10) NOT NULL,
  `match_id` int(11) NOT NULL,
  `won_by` varchar(30) DEFAULT NULL,
  `highest_scorer` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `match_id`, `won_by`, `highest_scorer`) VALUES
(3, 2, 'CHE', 'Ivanovic'),
(5, 15, 'CHE', 'Eden Hazard'),
(9, 1, 'CHE', 'Willian');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `status`, `remember_token`, `deleted_at`, `role`) VALUES
(1, 'Ram', '$2y$10$Us/WJ3YLw801p0hLl2.mV.GiWSozJaDwCAzL9ng66/ArFK08Iq2fC', 'ram@kam.com', 1, 'oZ9SSyaV79Bo9WCUhGW1W7jXsI065ASDWXamGqN8Ug7WiV2dOKczI9lpEP80', NULL, 1),
(2, 'Hari', '$2y$10$GXoMwY6jI7BsSaA6D/4F.ua1kvkwDJlHm1qx3DKsWJOWSR5FeQYiC', 'hari@sory.com', 1, 'lxZn5LDzoLTylmWZEdJ1ikN9H5DHiXinSomD6s2YuQIkMBJxbnHIXbtJYkhf', NULL, 0),
(3, 'mahesh', '$2y$10$t69Z7AB/EbCCbbw89zgTUeXGni8iZjFa9HRc1zGI93sbhwSok1Upa', 'mahesh@kam.com', 1, 'E8gksLJQxNWe2M17pRqLHAUvEZCYPud7bZY48I05Vke5kchksQ0MACEBIHhh', NULL, 0),
(4, 'haku', '$2y$10$Q5mh5JddsW.mOOYODiTssuXOfK.HZgH1Zb6qMjGsrp3ci9nZEehiC', 'haku@kale.com', 1, 'ZRyGNZgcVlZTxET1aMVhVspnIZ5fCFxrQ8ANUfi9l0EMdh8ZDjDu962aU5Zx', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vote` int(11) DEFAULT NULL,
  `votable_id` int(11) DEFAULT NULL,
  `votable_type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `vote`, `votable_id`, `votable_type`) VALUES
(141, 1, 4, 74, 'App\\Answer'),
(142, 2, 4, 73, 'App\\Answer'),
(143, 2, 4, 22, 'App\\Comment'),
(144, 1, 4, 24, 'App\\Comment'),
(145, 3, 4, 77, 'App\\Answer'),
(146, 3, 4, 75, 'App\\Answer'),
(147, 3, -5, 75, 'App\\Answer'),
(148, 3, -5, 75, 'App\\Answer'),
(149, 3, -5, 75, 'App\\Answer'),
(150, 3, -5, 75, 'App\\Answer'),
(151, 3, -5, 75, 'App\\Answer'),
(152, 3, -5, 75, 'App\\Answer'),
(153, 2, 4, 78, 'App\\Answer'),
(154, 2, 4, 78, 'App\\Answer'),
(155, 134, -5, 4, 'App\\Comment'),
(156, 134, -5, 3, 'App\\Comment'),
(157, 2, 4, 3, 'App\\Comment'),
(158, 2, 4, 3, 'App\\Comment'),
(159, 2, 4, 3, 'App\\Comment'),
(160, 134, -5, 4, 'App\\Comment'),
(161, 134, -5, 4, 'App\\Comment'),
(163, 1, -5, 79, 'App\\Answer'),
(164, 1, -5, 79, 'App\\Answer'),
(165, 1, 4, 78, 'App\\Answer'),
(166, 1, 4, 5, 'App\\Comment'),
(167, 1, 4, 73, 'App\\Answer'),
(168, 1, 4, 76, 'App\\Answer'),
(169, 1, 4, 76, 'App\\Answer'),
(170, 1, 4, 76, 'App\\Answer'),
(171, 1, 4, 78, 'App\\Answer'),
(172, 1, 4, 77, 'App\\Answer');

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `match_date` date DEFAULT NULL,
  `team1` varchar(10) DEFAULT NULL,
  `team2` varchar(10) DEFAULT NULL,
  `team` varchar(20) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `win_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `winners_players`
--

CREATE TABLE `winners_players` (
  `id` int(11) NOT NULL,
  `match_id` int(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `player` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `betplayers`
--
ALTER TABLE `betplayers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `match_id` (`match_id`),
  ADD UNIQUE KEY `match_id_2` (`match_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `winners_players`
--
ALTER TABLE `winners_players`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `betplayers`
--
ALTER TABLE `betplayers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bets`
--
ALTER TABLE `bets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `winners_players`
--
ALTER TABLE `winners_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
