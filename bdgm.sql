-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 14 2016 г., 11:57
-- Версия сервера: 5.5.46
-- Версия PHP: 5.3.10-1ubuntu3.21

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `bdgm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `freemen`
--

CREATE TABLE IF NOT EXISTS `freemen` (
  `uid` tinyint(4) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mounting`
--

CREATE TABLE IF NOT EXISTS `mounting` (
  `oid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `m_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `oid` int(11) NOT NULL,
  `note` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `contract` varchar(9) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contract_date` date NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `adress` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) NOT NULL,
  `date` date NOT NULL,
  `term` date NOT NULL,
  `designer` int(5) NOT NULL,
  `sum` int(16) NOT NULL,
  `prepayment` int(16) NOT NULL,
  `rassr` tinyint(1) NOT NULL,
  `beznal` tinyint(1) NOT NULL,
  `note` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `technologist` int(5) NOT NULL,
  `collector` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2686 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order_stan`
--

CREATE TABLE IF NOT EXISTS `order_stan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) NOT NULL,
  `plan` date NOT NULL,
  `tech_date` date NOT NULL,
  `tech_end` tinyint(1) NOT NULL,
  `mater` tinyint(1) NOT NULL,
  `raspil` tinyint(1) NOT NULL,
  `cpu` tinyint(1) NOT NULL,
  `gnutje` tinyint(1) NOT NULL,
  `kromka` tinyint(1) NOT NULL,
  `pris_end` tinyint(1) NOT NULL,
  `emal` tinyint(1) NOT NULL,
  `pvh` tinyint(1) NOT NULL,
  `photo` tinyint(1) NOT NULL,
  `pesok` tinyint(1) NOT NULL,
  `oracal` tinyint(1) NOT NULL,
  `fas` tinyint(1) NOT NULL,
  `vitrag` tinyint(1) NOT NULL,
  `upak_end` tinyint(1) NOT NULL,
  `otgruz_end` tinyint(1) NOT NULL,
  `sborka_end` tinyint(1) NOT NULL,
  `sborka_date` date NOT NULL,
  `sborka_end_date` date NOT NULL,
  `raspil_date` date NOT NULL,
  `cpu_date` date NOT NULL,
  `gnutje_date` date NOT NULL,
  `kromka_date` date NOT NULL,
  `pris_date` date NOT NULL,
  `emal_date` date NOT NULL,
  `pvh_date` date NOT NULL,
  `photo_date` date NOT NULL,
  `pesok_date` date NOT NULL,
  `vitrag_date` date NOT NULL,
  `oracal_date` date NOT NULL,
  `fas_date` date NOT NULL,
  `upak_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2674 ;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `list` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(77) COLLATE utf8_unicode_ci NOT NULL,
  `operative` tinyint(1) NOT NULL,
  `user_hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_ip` int(10) NOT NULL,
  `user_right` tinyint(2) NOT NULL,
  `error` int(11) NOT NULL,
  `session_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Структура таблицы `us_post`
--

CREATE TABLE IF NOT EXISTS `us_post` (
  `uid` int(5) NOT NULL,
  `pid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
