-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-09-10 00:10:11
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

--
-- 转存表中的数据 `file`
--

INSERT INTO `file` (`file_id`, `file_name`, `file_comment`, `file_size`, `file_uploadtime`, `file_owner`, `file_valid`) VALUES
(7, '1441210289_README', 'ffff', 679, '2015-09-02 16:11:29', 'hzh', 0);

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

--
-- 转存表中的数据 `forum`
--

INSERT INTO `forum` (`forum_id`, `forum_title`, `forum_content`, `forum_owner`, `forum_estab`, `forum_type`) VALUES
(1, 'hello!世界', 'just\r\na\r\ntest!\r\n!', 'hzh', '2015-08-27 14:34:55', 0),
(2, 'ceshi', 'ceshi', 'hzh', '2015-09-09 10:55:45', 0);

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

--
-- 转存表中的数据 `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `group_chant`, `group_foundtime`, `group_leader`, `group_valid`, `group_pretime`) VALUES
(1, 'test', '测试一下', '2015-09-09 15:05:59', 'hzh', 1, -1);

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

--
-- 转存表中的数据 `group_req`
--

INSERT INTO `group_req` (`req_id`, `req_owner`, `req_groupid`, `req_content`, `req_foundtime`, `req_status`) VALUES
(1, 'hzh', 1, 0, '2015-09-09 15:05:59', 3);

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

--
-- 转存表中的数据 `thread`
--

INSERT INTO `thread` (`thread_id`, `thread_forumid`, `thread_owner`, `thread_estab`, `thread_content`) VALUES
(1, 1, 'hzh', '2015-08-27 15:53:01', '回复试试。。\r\n。\r\n'),
(2, 1, 'hzh', '2015-08-27 16:21:37', '    ffff'),
(3, 1, 'hzh', '2015-09-07 12:05:16', '<script>alert(''fffff'');</script>'),
(5, 2, 'hzh', '2015-09-09 11:41:02', '针对中文,演示Markdown的各种语法\r\n  \r\n大标题\r\n===================================\r\n  大标题一般显示工程名,类似html的\\<h1\\><br />\r\n  你只要在标题下面跟上=====即可\r\n\r\n  \r\n中标题\r\n-----------------------------------\r\n  中标题一般显示重点项,类似html的\\<h2\\><br />\r\n  你只要在标题下面输入------即可'),
(6, 2, 'hzh', '2015-09-09 11:57:50', '方法  烦烦烦    ffff');

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
(15, 'hzh', '*A5598B808C0F9532C02390633521C53ADA41654A', 1, '何子昊', '无45', '13522200713', 'hzh_1996@sina.com', '2015-08-24 14:00:26', '2015-09-10 00:00:06', NULL, 0, '2015-09-07 12:02:44', '2015-09-09 15:25:25', '192.168.1.104'),
(16, '测试员', '*A5598B808C0F9532C02390633521C53ADA41654A', 0, '测试', '法', '13533333333', 'h@d', '2015-08-25 01:32:41', '0000-00-00 00:00:00', NULL, 0, '1999-12-31 16:00:00', '1999-12-31 16:00:00', ''),
(17, 'fff', '*748A64860BBBCF47FEC51C21756E579E70707ED7', 0, 'f', 'f', '13422222222', 'd@d', '2015-08-29 16:37:03', '0000-00-00 00:00:00', NULL, 0, '1999-12-31 16:00:00', '1999-12-31 16:00:00', ''),
(18, 'ttt', '*6F021E72032DB29F9DA5E7ED9708305F5D82F769', 0, 't', 't', '12345678901', 'f@f', '2015-08-29 16:59:44', '0000-00-00 00:00:00', NULL, 0, '1999-12-31 16:00:00', '1999-12-31 16:00:00', ''),
(19, 'rrr', '*4EF9C32D3E8E72F010A4842267F7C1971BC6E347', 0, 'r', 'r', '13422222222', 'f@f', '2015-08-30 15:26:23', NULL, NULL, 0, '1999-12-31 16:00:00', '1999-12-31 16:00:00', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
