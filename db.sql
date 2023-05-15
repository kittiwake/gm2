-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 15 2023 г., 16:25
-- Версия сервера: 5.7.27-30
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `u0315626_graf`
--
CREATE DATABASE IF NOT EXISTS `db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db`;

-- --------------------------------------------------------

--
-- Структура таблицы `allowed`
--

CREATE TABLE `allowed` (
  `id` int(11) NOT NULL,
  `controller` varchar(10) NOT NULL,
  `action` varchar(16) NOT NULL,
  `allowed` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `bossnotes`
--

CREATE TABLE `bossnotes` (
  `id` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `pole` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `noteboss` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `categories_material`
--

CREATE TABLE `categories_material` (
  `id` int(11) NOT NULL,
  `category` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `otdel` enum('m','f','o') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_client-sdelka`
--

CREATE TABLE `crm_client-sdelka` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sdelka_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_sdelki`
--

CREATE TABLE `crm_sdelki` (
  `id` int(11) NOT NULL,
  `nomer` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `responsible` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `crm_zadacha`
--

CREATE TABLE `crm_zadacha` (
  `id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `sdelka` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `to_user` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `from_user` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type_zadacha` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `zadacha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stan` enum('new','done','transfer','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `comment` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dillers`
--

CREATE TABLE `dillers` (
  `id` int(11) NOT NULL,
  `flag` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `freemen`
--

CREATE TABLE `freemen` (
  `id` int(11) NOT NULL,
  `uid` int(8) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `incall`
--

CREATE TABLE `incall` (
  `id` int(11) NOT NULL,
  `event` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `call_start` datetime NOT NULL,
  `pbx_call_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `caller_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `called_did` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `internal` int(3) NOT NULL,
  `duration` int(11) NOT NULL,
  `disposition` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status_code` int(4) NOT NULL,
  `is_recorded` int(1) NOT NULL,
  `call_id_with_rec` varchar(120) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `last_gen`
--

CREATE TABLE `last_gen` (
  `key` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `val` varchar(8) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `logistic`
--

CREATE TABLE `logistic` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` enum('in','out','auto') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'out',
  `point` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `summ` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `driver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mater-prov`
--

CREATE TABLE `mater-prov` (
  `id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  `prov_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` int(64) NOT NULL,
  `oid` int(64) NOT NULL,
  `designation` varchar(256) CHARACTER SET utf8 NOT NULL,
  `count` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `catid` tinyint(11) NOT NULL,
  `prov_id` int(11) NOT NULL,
  `otdel` enum('m','f','o') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'm',
  `summ` int(11) NOT NULL,
  `plan_date` date NOT NULL,
  `date` date NOT NULL,
  `status` enum('forestgreen','orangered','lavender') CHARACTER SET utf8 NOT NULL DEFAULT 'lavender',
  `outlay_id` int(11) NOT NULL,
  `logist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `point` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `url` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL,
  `access` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `date_mes` date NOT NULL,
  `time_mes` time NOT NULL,
  `mes` text COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('sms','email') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sms'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mounting`
--

CREATE TABLE `mounting` (
  `oid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `m_date` date NOT NULL,
  `target` enum('assembly','measure','previously') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'assembly'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `notes`
--

CREATE TABLE `notes` (
  `oid` int(11) NOT NULL,
  `note` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `use` enum('order','mounting') CHARACTER SET utf8 NOT NULL DEFAULT 'order'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oldi_customer`
--

CREATE TABLE `oldi_customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `diller` tinyint(1) NOT NULL,
  `active_dil` int(11) NOT NULL,
  `sign` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lastnum` int(6) NOT NULL,
  `phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oldi_etaps`
--

CREATE TABLE `oldi_etaps` (
  `id` int(11) NOT NULL,
  `etap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `etap_stan` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `etap_date` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `visual_1` int(11) NOT NULL,
  `visual_2` int(11) NOT NULL,
  `visual_3` int(11) NOT NULL,
  `visual_41` int(11) NOT NULL,
  `visual_42` int(11) NOT NULL,
  `visual_43` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oldi_etaps2`
--

CREATE TABLE `oldi_etaps2` (
  `id` int(11) NOT NULL,
  `etap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `etap_stan` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `for_tip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oldi_orders`
--

CREATE TABLE `oldi_orders` (
  `id` int(32) NOT NULL,
  `contract` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `gmid` int(11) NOT NULL,
  `contract_date` date NOT NULL,
  `idcustomer` int(11) NOT NULL,
  `mkv` float NOT NULL,
  `tip` int(3) NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pokr` tinyint(1) NOT NULL,
  `dop_ef` tinyint(1) NOT NULL,
  `radius` tinyint(1) NOT NULL,
  `fotopec` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  `term` date NOT NULL,
  `sum` int(16) NOT NULL,
  `prepayment` int(16) NOT NULL,
  `beznal` tinyint(1) NOT NULL,
  `plan` date NOT NULL,
  `plan_em` date DEFAULT NULL,
  `malar` tinyint(4) DEFAULT '0',
  `na_pokr` tinyint(11) DEFAULT '0',
  `stan` tinyint(4) DEFAULT '0',
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oldi_stan`
--

CREATE TABLE `oldi_stan` (
  `id` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `vceh_date` date DEFAULT NULL,
  `v_ceh` tinyint(1) NOT NULL DEFAULT '0',
  `mat_mdf` tinyint(4) NOT NULL DEFAULT '0',
  `mat_radius` tinyint(4) NOT NULL DEFAULT '0',
  `emal_booked` tinyint(4) NOT NULL DEFAULT '0',
  `mat_oblic` tinyint(4) NOT NULL DEFAULT '0',
  `raspil` tinyint(1) NOT NULL DEFAULT '0',
  `raspil_date` date DEFAULT NULL,
  `radius` tinyint(1) NOT NULL DEFAULT '0',
  `frez` tinyint(1) NOT NULL DEFAULT '0',
  `frez_date` date DEFAULT NULL,
  `obk` tinyint(1) NOT NULL DEFAULT '0',
  `obk_date` date DEFAULT NULL,
  `pris` tinyint(1) NOT NULL DEFAULT '0',
  `klej` int(11) NOT NULL DEFAULT '0',
  `klej_date` date DEFAULT NULL,
  `pvh` tinyint(1) NOT NULL DEFAULT '0',
  `pvh_date` date DEFAULT NULL,
  `shlif0` int(11) NOT NULL,
  `shlif0_date` date DEFAULT NULL,
  `isolator` int(11) NOT NULL,
  `isolator_date` date DEFAULT NULL,
  `shlif1` int(11) NOT NULL DEFAULT '0',
  `shlif1_date` date DEFAULT NULL,
  `grunt` tinyint(1) NOT NULL DEFAULT '0',
  `grunt_date` date DEFAULT NULL,
  `shlif2` int(11) NOT NULL,
  `shlif2_date` date DEFAULT NULL,
  `emal` tinyint(1) NOT NULL DEFAULT '0',
  `emal_date` date DEFAULT NULL,
  `spef` tinyint(1) NOT NULL DEFAULT '0',
  `fotopec` tinyint(1) NOT NULL DEFAULT '0',
  `polir` tinyint(1) NOT NULL DEFAULT '0',
  `polir_date` date DEFAULT NULL,
  `upak` tinyint(1) NOT NULL DEFAULT '0',
  `upak_date` date DEFAULT NULL,
  `otgruz` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(32) NOT NULL,
  `contract` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `contract_date` date NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `company` enum('gm','als','mk') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'gm',
  `product` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `adress` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `latlng` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8 NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `personal_agree` enum('disagree','agree') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disagree',
  `date` date NOT NULL,
  `term` date NOT NULL,
  `designer` int(5) NOT NULL,
  `sum` int(16) NOT NULL,
  `prepayment` int(16) NOT NULL,
  `rassr` tinyint(1) NOT NULL,
  `beznal` tinyint(1) NOT NULL,
  `rebate` int(16) NOT NULL,
  `note` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `attention` int(11) NOT NULL DEFAULT '0',
  `technologist` int(5) NOT NULL,
  `collector` tinyint(4) NOT NULL,
  `sumdeliv` int(11) NOT NULL,
  `sumcollect` int(11) NOT NULL,
  `archive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders_copy`
--

CREATE TABLE `orders_copy` (
  `id` int(32) NOT NULL,
  `contract` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `contract_date` date NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `custid` int(11) NOT NULL,
  `product` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `adress` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `latlng` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8 NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `personal_agree` enum('disagree','agree') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disagree',
  `date` date NOT NULL,
  `term` date NOT NULL,
  `designer` int(5) NOT NULL,
  `sum` int(16) NOT NULL,
  `prepayment` int(16) NOT NULL,
  `rassr` tinyint(1) NOT NULL,
  `beznal` tinyint(1) NOT NULL,
  `rebate` int(16) NOT NULL,
  `note` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `technologist` int(5) NOT NULL,
  `collector` tinyint(4) NOT NULL,
  `sumdeliv` int(11) NOT NULL,
  `sumcollect` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order_part`
--

CREATE TABLE `order_part` (
  `id` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `suf` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `part_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `raspil` int(1) NOT NULL DEFAULT '0',
  `raspil_date` date DEFAULT NULL,
  `cpu` int(1) NOT NULL DEFAULT '0',
  `cpu_date` date DEFAULT NULL,
  `gnutje` int(1) NOT NULL DEFAULT '0',
  `gnutje_date` date DEFAULT NULL,
  `kromka` int(1) NOT NULL DEFAULT '0',
  `kromka_date` date DEFAULT NULL,
  `pris_end` int(1) NOT NULL DEFAULT '0',
  `pris_date` date DEFAULT NULL,
  `fas` int(1) NOT NULL DEFAULT '0',
  `fas_date` date DEFAULT NULL,
  `upak_end` int(1) NOT NULL DEFAULT '0',
  `upak_date` date DEFAULT NULL,
  `krivolin` int(1) NOT NULL DEFAULT '0',
  `krivolin_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order_stan`
--

CREATE TABLE `order_stan` (
  `id` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `plan` date NOT NULL,
  `pre_plan` date NOT NULL,
  `tech_date` date NOT NULL,
  `tech_end` tinyint(1) NOT NULL,
  `weight` float NOT NULL DEFAULT '0',
  `mater` tinyint(1) NOT NULL,
  `raspil` tinyint(1) NOT NULL,
  `cpu` tinyint(1) NOT NULL,
  `gnutje` tinyint(1) NOT NULL,
  `kromka` tinyint(1) NOT NULL,
  `krivolin` tinyint(1) NOT NULL,
  `pris_end` tinyint(1) NOT NULL,
  `emal` tinyint(1) NOT NULL,
  `pvh` tinyint(1) NOT NULL,
  `photo` tinyint(1) NOT NULL,
  `pesok` tinyint(1) NOT NULL,
  `oracal` tinyint(1) NOT NULL,
  `steklo` int(1) NOT NULL,
  `fas` tinyint(1) NOT NULL,
  `shpon` tinyint(1) NOT NULL,
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
  `krivolin_date` date NOT NULL,
  `pris_date` date NOT NULL,
  `emal_date` date NOT NULL,
  `pvh_date` date NOT NULL,
  `photo_date` date NOT NULL,
  `pesok_date` date NOT NULL,
  `vitrag_date` date NOT NULL,
  `oracal_date` date NOT NULL,
  `fas_date` date NOT NULL,
  `shpon_date` date NOT NULL,
  `upak_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `outlay`
--

CREATE TABLE `outlay` (
  `id` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `plan_dis`
--

CREATE TABLE `plan_dis` (
  `id` int(11) NOT NULL,
  `contract` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `date_dis` date NOT NULL,
  `dis` int(5) NOT NULL,
  `sum` int(16) NOT NULL,
  `prepayment` int(16) NOT NULL,
  `beznal` tinyint(1) NOT NULL,
  `stan` enum('new','zakluchen','otkaz','tekuch','delete','arhiv','holiday') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `render` enum('nothing','money','contract','all') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'nothing',
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `empty` int(11) NOT NULL,
  `name_men` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(5) NOT NULL,
  `list` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `progression`
--

CREATE TABLE `progression` (
  `oid` int(11) NOT NULL,
  `pole` int(11) NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `providers`
--

CREATE TABLE `providers` (
  `id` int(11) NOT NULL,
  `provider` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(226) COLLATE utf8_unicode_ci NOT NULL,
  `activity` int(1) NOT NULL DEFAULT '1',
  `snab_logist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sample_sms`
--

CREATE TABLE `sample_sms` (
  `id` int(11) NOT NULL,
  `subject_sms` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `text_sms` text COLLATE utf8_unicode_ci NOT NULL,
  `mes_type` enum('sms','email') CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL DEFAULT 'sms'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sequence`
--

CREATE TABLE `sequence` (
  `id` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `gm_ol` enum('g','o') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'g',
  `partid` int(11) DEFAULT NULL,
  `pole` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `stan`
--

CREATE TABLE `stan` (
  `id` int(11) NOT NULL,
  `_tech` tinyint(1) NOT NULL,
  `_mat` tinyint(1) NOT NULL,
  `_pila` tinyint(1) NOT NULL,
  `_krom` tinyint(1) NOT NULL,
  `_pris` tinyint(1) NOT NULL,
  `_emal` tinyint(1) NOT NULL,
  `_pvh` tinyint(1) NOT NULL,
  `_photo` tinyint(1) NOT NULL,
  `_pesok` tinyint(1) NOT NULL,
  `_oracal` tinyint(1) NOT NULL,
  `_fas` tinyint(1) NOT NULL,
  `_upak` tinyint(1) NOT NULL,
  `_otgruz` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tp_callmess`
--

CREATE TABLE `tp_callmess` (
  `id` int(11) NOT NULL,
  `to_user` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `from_user` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `stan` enum('new','deleted','read') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tp_clients`
--

CREATE TABLE `tp_clients` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `phone2` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `phone3` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `contracts` enum('error','no','yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `callmen` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `stan` enum('lead','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'lead',
  `date` date NOT NULL,
  `time` time NOT NULL,
  `istochnik` varchar(63) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tp_clients2`
--

CREATE TABLE `tp_clients2` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `istochnik` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `phone2` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `phone3` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `contracts` enum('error','no','yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `callmen` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `user_login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `validation` tinyint(1) DEFAULT NULL,
  `user_right` tinyint(4) DEFAULT NULL,
  `external_access` int(11) NOT NULL,
  `tel` varchar(77) COLLATE utf8_unicode_ci NOT NULL,
  `internal` int(11) NOT NULL,
  `operative` tinyint(1) NOT NULL,
  `user_ip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `error` int(11) NOT NULL,
  `session_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `us_post`
--

CREATE TABLE `us_post` (
  `uid` int(5) NOT NULL,
  `pid` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `allowed`
--
ALTER TABLE `allowed`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bossnotes`
--
ALTER TABLE `bossnotes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories_material`
--
ALTER TABLE `categories_material`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_client-sdelka`
--
ALTER TABLE `crm_client-sdelka`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_sdelki`
--
ALTER TABLE `crm_sdelki`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `crm_zadacha`
--
ALTER TABLE `crm_zadacha`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dillers`
--
ALTER TABLE `dillers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `freemen`
--
ALTER TABLE `freemen`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `incall`
--
ALTER TABLE `incall`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `last_gen`
--
ALTER TABLE `last_gen`
  ADD UNIQUE KEY `key` (`key`);

--
-- Индексы таблицы `logistic`
--
ALTER TABLE `logistic`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mater-prov`
--
ALTER TABLE `mater-prov`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oldi_customer`
--
ALTER TABLE `oldi_customer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oldi_etaps`
--
ALTER TABLE `oldi_etaps`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oldi_orders`
--
ALTER TABLE `oldi_orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oldi_stan`
--
ALTER TABLE `oldi_stan`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders_copy`
--
ALTER TABLE `orders_copy`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_part`
--
ALTER TABLE `order_part`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oid` (`oid`,`suf`);

--
-- Индексы таблицы `order_stan`
--
ALTER TABLE `order_stan`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `outlay`
--
ALTER TABLE `outlay`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `plan_dis`
--
ALTER TABLE `plan_dis`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `progression`
--
ALTER TABLE `progression`
  ADD KEY `oid` (`oid`),
  ADD KEY `pole` (`pole`);

--
-- Индексы таблицы `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sample_sms`
--
ALTER TABLE `sample_sms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sequence`
--
ALTER TABLE `sequence`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tp_callmess`
--
ALTER TABLE `tp_callmess`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `tp_clients`
--
ALTER TABLE `tp_clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tp_clients2`
--
ALTER TABLE `tp_clients2`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`user_login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `allowed`
--
ALTER TABLE `allowed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `bossnotes`
--
ALTER TABLE `bossnotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `categories_material`
--
ALTER TABLE `categories_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `crm_client-sdelka`
--
ALTER TABLE `crm_client-sdelka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `crm_sdelki`
--
ALTER TABLE `crm_sdelki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `crm_zadacha`
--
ALTER TABLE `crm_zadacha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dillers`
--
ALTER TABLE `dillers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `freemen`
--
ALTER TABLE `freemen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `incall`
--
ALTER TABLE `incall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `logistic`
--
ALTER TABLE `logistic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mater-prov`
--
ALTER TABLE `mater-prov`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `oldi_customer`
--
ALTER TABLE `oldi_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `oldi_etaps`
--
ALTER TABLE `oldi_etaps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `oldi_orders`
--
ALTER TABLE `oldi_orders`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `oldi_stan`
--
ALTER TABLE `oldi_stan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders_copy`
--
ALTER TABLE `orders_copy`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_part`
--
ALTER TABLE `order_part`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_stan`
--
ALTER TABLE `order_stan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `outlay`
--
ALTER TABLE `outlay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `plan_dis`
--
ALTER TABLE `plan_dis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sample_sms`
--
ALTER TABLE `sample_sms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sequence`
--
ALTER TABLE `sequence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tp_callmess`
--
ALTER TABLE `tp_callmess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tp_clients`
--
ALTER TABLE `tp_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tp_clients2`
--
ALTER TABLE `tp_clients2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
