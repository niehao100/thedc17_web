-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-08-25 09:09:34
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thedc17`
--

DELIMITER $$
--
-- 函数
--
CREATE DEFINER=`root`@`localhost` FUNCTION `check_user`(nickname varchar(50),pass varchar(100)) RETURNS int(11)
begin
DECLARE c INT;
set c=0;
select count(*) into c from user where user_nickname=nickname and user_pass=password(pass);
if c>0 then
	update user set user_lastlogin=now() where user_nickname=nickname;
	return 1;
else
   return -1;
end if;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `register_user`(nickname varchar(50),pass varchar(100),type tinyint(4),realname varchar(20),class varchar(20),phone varchar(11),email varchar(50)) RETURNS int(11)
begin
DECLARE c INT;
set c=0;
select count(*) into c from user where user_nickname=nickname;
if c>0 then
	return -1;
else
	insert into user(user_nickname,user_pass,user_type,user_realname,user_class,user_phone,user_email,user_lastlogin) 
    VALUES(nickname,password(pass),type,realname,class,phone,email,now());
   return 1;
end if;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(100) NOT NULL,
  `file_comment` mediumtext NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_uploadtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_owner` varchar(50) NOT NULL,
  `file_valid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 is valid,0 is invalid',
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `mess_id` int(11) NOT NULL AUTO_INCREMENT,
  `mess_title` text NOT NULL,
  `mess_content` text NOT NULL,
  `mess_owner` text NOT NULL,
  `mess_uploadtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mess_valid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 is valid,0 is not.',
  PRIMARY KEY (`mess_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_nickname` varchar(50) NOT NULL,
  `user_pass` varchar(100) NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 is guest,1 is admin',
  `user_realname` varchar(20) NOT NULL,
  `user_class` varchar(20) NOT NULL,
  `user_phone` varchar(11) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_lastlogin` datetime DEFAULT NULL,
  `user_lastfaillogin` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_nickname` (`user_nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `user_nickname`, `user_pass`, `user_type`, `user_realname`, `user_class`, `user_phone`, `user_email`, `user_createtime`, `user_lastlogin`, `user_lastfaillogin`) VALUES
(15, 'hzh', '*A5598B808C0F9532C02390633521C53ADA41654A', 1, '何子昊', '无45', '13522200713', 'hzh_1996@sina.com', '2015-08-24 14:00:26', '0000-00-00 00:00:00', NULL),
(16, '测试员', '*A5598B808C0F9532C02390633521C53ADA41654A', 0, '测试', '法', '13533333333', 'h@d', '2015-08-25 01:32:41', '0000-00-00 00:00:00', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
