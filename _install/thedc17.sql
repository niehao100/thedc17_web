-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-09-20 21:42:47
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的结构 `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
  `forum_id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_title` text NOT NULL,
  `forum_content` text NOT NULL,
  `forum_owner` text NOT NULL,
  `forum_estab` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `forum_type` int(11) NOT NULL,
  PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` text NOT NULL,
  `group_chant` text NOT NULL,
  `group_foundtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `group_leader` text NOT NULL,
  `group_valid` int(11) NOT NULL DEFAULT '1' COMMENT '0 is invalid, 1 is valid',
  `group_pretime` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `group_req`
--

CREATE TABLE IF NOT EXISTS `group_req` (
  `req_id` int(11) NOT NULL AUTO_INCREMENT,
  `req_owner` text NOT NULL,
  `req_groupid` int(11) NOT NULL,
  `req_content` int(11) NOT NULL,
  `req_foundtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `req_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 is requesting, 1 is approved, 2 is invalid,3 is leader',
  PRIMARY KEY (`req_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_forumid` int(11) NOT NULL,
  `thread_owner` text NOT NULL,
  `thread_estab` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `thread_content` text NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

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
  `user_group` int(11) NOT NULL,
  `user_lastfile` timestamp NOT NULL DEFAULT '1999-12-31 16:00:00',
  `user_lastmessage` timestamp NOT NULL DEFAULT '1999-12-31 16:00:00',
  `user_lastip` text NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_nickname` (`user_nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `user_nickname`, `user_pass`, `user_type`, `user_realname`, `user_class`, `user_phone`, `user_email`, `user_createtime`, `user_lastlogin`, `user_lastfaillogin`, `user_group`, `user_lastfile`, `user_lastmessage`, `user_lastip`) VALUES
(15, 'hzh', '*A5598B808C0F9532C02390633521C53ADA41654A', 1, '何子昊', '无45', '13522200713', 'hzh_1996@sina.com', '2015-08-24 14:00:26', '2015-09-10 08:51:32', '2015-09-10 08:51:27', 0, '2015-09-07 12:02:44', '2015-09-09 15:25:25', '192.168.1.103');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
