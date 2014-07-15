-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2014 年 07 月 11 日 01:13
-- 伺服器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `relay`
--

-- --------------------------------------------------------

--
-- 表的結構 `345kv_newbus`
--

CREATE TABLE IF NOT EXISTS `345kv_newbus` (
  `name` varchar(10) CHARACTER SET utf8 NOT NULL,
  `break` tinyint(4) NOT NULL,
  `relayset` tinyint(4) NOT NULL,
  `short_3` float NOT NULL,
  `ground_1` float NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 轉存資料表中的資料 `345kv_newbus`
--

INSERT INTO `345kv_newbus` (`name`, `break`, `relayset`, `short_3`, `ground_1`) VALUES
('B中火#10', 1, 0, 0, 0),
('B中火#9', 1, 0, 0, 0),
('中寮北E', 1, 0, 0, 0),
('中寮南E', 1, 0, 0, 0),
('中港E', 1, 0, 0, 0),
('中火北E', 1, 0, 0, 0),
('中火南E', 1, 0, 0, 0),
('中科E', 1, 0, 0, 0),
('五甲E', 1, 0, 0, 0),
('仁武E', 1, 0, 0, 0),
('仙渡E', 1, 0, 0, 0),
('全興E', 1, 0, 0, 0),
('冬山E', 1, 0, 0, 0),
('協和E', 1, 0, 0, 0),
('南投E', 1, 0, 0, 0),
('南科E', 1, 0, 0, 0),
('后里E', 1, 0, 0, 0),
('和平E', 1, 0, 0, 0),
('嘉民E', 1, 0, 0, 0),
('國光E', 1, 0, 0, 0),
('塑化E', 1, 0, 0, 0),
('大潭E', 1, 0, 0, 0),
('大觀二E', 1, 0, 0, 0),
('大鵬E', 1, 0, 0, 0),
('天輪E', 1, 0, 0, 0),
('峨眉E', 1, 0, 0, 0),
('彰林E', 1, 0, 0, 0),
('彰濱E', 1, 0, 0, 0),
('明潭E', 1, 0, 0, 0),
('板橋E', 1, 0, 0, 0),
('核一E', 1, 0, 0, 0),
('核三E', 1, 0, 0, 0),
('核二E', 1, 0, 0, 0),
('汐止E', 1, 0, 0, 0),
('深美E', 1, 0, 0, 0),
('瀰力E', 1, 0, 0, 0),
('竹工E', 1, 0, 0, 0),
('興益E', 1, 0, 0, 0),
('興達北E', 1, 0, 0, 0),
('興達南E', 1, 0, 0, 0),
('路北E', 1, 0, 0, 0),
('霧峰#1', 1, 0, 0, 0),
('霧峰#2', 1, 0, 0, 0),
('霧峰#3', 1, 0, 0, 0),
('霧峰#4', 1, 0, 0, 0),
('霧峰E', 1, 0, 0, 0),
('頂湖E', 1, 0, 0, 0),
('高港E', 1, 0, 0, 0),
('高雄E', 1, 0, 0, 0),
('鳳林E', 1, 0, 0, 0),
('麥寮E', 1, 0, 0, 0),
('龍崎北E', 1, 0, 0, 0),
('龍崎南E', 1, 0, 0, 0),
('龍潭北E', 1, 0, 0, 0),
('龍潭南E', 1, 0, 0, 0),
('龍門E', 1, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
