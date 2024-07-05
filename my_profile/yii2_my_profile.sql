-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 11:39 PM
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
-- Database: `yii2_my_profile`
--

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL COMMENT '連番',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `self_introduction` text DEFAULT NULL COMMENT '自己紹介文',
  `service1` varchar(255) DEFAULT NULL COMMENT 'サービス名1',
  `service1_url` varchar(255) DEFAULT NULL COMMENT 'サービスURL1',
  `service2` varchar(255) DEFAULT NULL COMMENT 'サービス名2',
  `service2_url` varchar(255) DEFAULT NULL COMMENT 'サービスURL2',
  `service3` varchar(250) DEFAULT NULL COMMENT 'サービス名3',
  `service3_url` varchar(250) DEFAULT NULL COMMENT 'サービスURL3',
  `service4` varchar(250) DEFAULT NULL COMMENT 'サービス名4',
  `service4_url` varchar(250) DEFAULT NULL COMMENT 'サービスURL4',
  `service5` varchar(250) DEFAULT NULL COMMENT 'サービス名5',
  `service5_url` varchar(250) DEFAULT NULL COMMENT 'サービスURL5',
  `service6` varchar(250) DEFAULT NULL COMMENT 'サービス名6',
  `service6_url` varchar(250) DEFAULT NULL COMMENT 'サービスURL6',
  `service7` varchar(250) DEFAULT NULL COMMENT 'サービス名7',
  `service7_url` varchar(250) DEFAULT NULL COMMENT 'サービスURL7',
  `service8` varchar(250) DEFAULT NULL COMMENT 'サービス名8',
  `service8_url` varchar(250) DEFAULT NULL COMMENT 'サービスURL8',
  `service9` varchar(250) DEFAULT NULL COMMENT 'サービス名9',
  `service9_url` varchar(250) DEFAULT NULL COMMENT 'サービスURL9',
  `service10` varchar(250) DEFAULT NULL COMMENT 'サービス名10',
  `service10_url` varchar(250) DEFAULT NULL COMMENT 'サービスURL10',
  `img_url1` text DEFAULT NULL,
  `thum_url1` text DEFAULT NULL,
  `img_url2` text DEFAULT NULL,
  `thum_url2` text DEFAULT NULL,
  `img_url3` text DEFAULT NULL,
  `thum_url3` text DEFAULT NULL,
  `img_url4` text DEFAULT NULL,
  `thum_url4` text DEFAULT NULL,
  `img_url5` text DEFAULT NULL,
  `thum_url5` text DEFAULT NULL,
  `movie_url1` text DEFAULT NULL,
  `movie_thum_url1` text DEFAULT NULL,
  `movie_url2` text DEFAULT NULL,
  `movie_thum_url2` text DEFAULT NULL,
  `movie_url3` text DEFAULT NULL,
  `movie_thum_url3` text DEFAULT NULL,
  `movie_url4` text DEFAULT NULL,
  `movie_thum_url4` text DEFAULT NULL,
  `movie_url5` text DEFAULT NULL,
  `movie_thum_url5` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='プロフィール登録テーブル';



-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL COMMENT 'ユーザーID',
  `role` int(11) NOT NULL DEFAULT 0 COMMENT 'ユーザーロール',
  `mail` varchar(255) NOT NULL COMMENT 'ユーザーメールアドレス',
  `username` varchar(250) NOT NULL COMMENT 'ユーザー名',
  `password` varchar(255) NOT NULL COMMENT 'パスワード',
  `auth_key` varchar(32) NOT NULL,
  `ip` varchar(255) DEFAULT NULL COMMENT 'IPアドレス',
  `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT '登録日',
  `token` text DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `google_token` text DEFAULT NULL,
  `auth_provider` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ユーザー情報テーブル';



--
-- Indexes for dumped tables
--

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ユーザーID` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '連番', AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザーID', AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
