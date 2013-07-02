-- phpMyAdmin SQL Dump
-- version 3.1.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 29, 2010 at 10:49 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `coinwhale`
--

-- --------------------------------------------------------

--
-- Table structure for table `buy_refer`
--

CREATE TABLE IF NOT EXISTS `buy_refer` (
  `serial` mediumint(5) NOT NULL auto_increment,
  `buy_id` int(10) default NULL,
  `refer_id` int(10) default NULL,
  `insert_date` date default NULL,
  PRIMARY KEY  (`serial`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `buy_refer`
--

INSERT INTO `buy_refer` (`serial`, `buy_id`, `refer_id`, `insert_date`) VALUES
(1, 2, 1, '2010-11-12');

-- --------------------------------------------------------

--
-- Table structure for table `callback_log`
--

CREATE TABLE IF NOT EXISTS `callback_log` (
  `serial` int(10) NOT NULL auto_increment,
  `buy_id` int(10) default NULL,
  `game_id` int(10) NOT NULL,
  `status` tinyint(1) default NULL,
  `send_time` datetime default NULL,
  PRIMARY KEY  (`serial`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `callback_log`
--

INSERT INTO `callback_log` (`serial`, `buy_id`, `game_id`, `status`, `send_time`) VALUES
(1, 23, 15, 1, '2010-11-19 22:50:08'),
(2, 23, 15, 1, '2010-11-19 23:00:00'),
(3, 23, 15, 1, '2010-11-19 23:01:42'),
(4, 23, 15, 1, '2010-11-19 23:07:17'),
(5, 23, 15, 1, '2010-11-19 23:07:17'),
(9, 23, 15, 1, '2010-11-19 23:07:17'),
(6, 23, 15, 1, '2010-11-19 23:33:42'),
(7, 26, 15, 1, '2010-11-22 16:14:12'),
(8, 28, 15, 1, '2010-11-22 17:52:51'),
(10, 26, 14, 1, '2010-11-23 05:04:18'),
(12, 23, 14, 1, '2010-11-26 14:15:01'),
(13, 23, 15, 1, '2010-11-26 14:15:01'),
(14, 23, 14, 1, '2010-11-29 16:41:32'),
(15, 23, 15, 1, '2010-11-29 16:41:32'),
(16, 23, 14, 1, '2010-11-29 16:56:51'),
(17, 23, 15, 1, '2010-11-29 16:56:51'),
(18, 23, 14, 1, '2010-11-29 17:02:19'),
(19, 23, 15, 1, '2010-11-29 17:02:19'),
(20, 23, 14, 1, '2010-11-29 17:07:55'),
(21, 23, 15, 1, '2010-11-29 17:07:55'),
(22, 23, 14, 1, '2010-11-29 17:10:56'),
(23, 23, 15, 1, '2010-11-29 17:10:56'),
(24, 23, 14, 1, '2010-11-29 17:11:35'),
(25, 23, 15, 1, '2010-11-29 17:11:35');

-- --------------------------------------------------------

--
-- Table structure for table `cms_user`
--

CREATE TABLE IF NOT EXISTS `cms_user` (
  `cuser_id` smallint(2) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `email` varchar(50) default NULL,
  `password` varchar(300) default NULL,
  `reg_date` date default NULL,
  `last_login` datetime NOT NULL,
  PRIMARY KEY  (`cuser_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cms_user`
--

INSERT INTO `cms_user` (`cuser_id`, `name`, `email`, `password`, `reg_date`, `last_login`) VALUES
(1, 'wasim chy', 'wasim@bluebd.com', 'c4ca4238a0b923820dcc509a6f75849b', '2010-11-12', '2010-11-26 13:28:42'),
(2, 'raymon', 'raymon@slighlysocial.com', 'e10adc3949ba59abbe56e057f20f883e', '2010-11-11', '2010-11-11 19:15:38'),
(3, 'Brad Mills', 'bradmills@hotmail.ca', '46b4ecebe400554a7c0f849d16352f2c', '2010-11-12', '2010-11-29 15:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `cuser_per`
--

CREATE TABLE IF NOT EXISTS `cuser_per` (
  `serial` mediumint(5) NOT NULL auto_increment,
  `cuser_id` smallint(2) default NULL,
  `per_id` smallint(2) default NULL,
  PRIMARY KEY  (`serial`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cuser_per`
--


-- --------------------------------------------------------

--
-- Table structure for table `deal`
--

CREATE TABLE IF NOT EXISTS `deal` (
  `deal_id` int(10) NOT NULL auto_increment,
  `deal_title` varchar(300) default NULL,
  `short_desc` text,
  `price` double(8,2) default NULL,
  `retail_price` double(8,2) default NULL,
  `start_date` datetime default NULL,
  `end_date` datetime default NULL,
  `deal_quantity` mediumint(5) default NULL,
  `insert_date` date default NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`deal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `deal`
--

INSERT INTO `deal` (`deal_id`, `deal_title`, `short_desc`, `price`, `retail_price`, `start_date`, `end_date`, `deal_quantity`, `insert_date`, `status`) VALUES
(5, 'The Amazing Sample Deal!', '<p><span style="font-size: large">This is a taste of what you can expect!</span></p>\r\n<p><br />Do you believe it, what a deal, Santa has come early this year! This is the kind of crazy deal you can expect every week with CoinWhale.</p>\r\n<p><br />You could sit around and wait for hell to freeze over for apps to run deals like this, or you could join CoinWhale and get notified of amazing deals for currency at your favorite apps.<br />Make sure to fill out the customer survey and vote for which apps you want in the next deal bundle.</p>\r\n<p><br />As a bonus, collect CoinWhale credits for interaction and participation! Rank up and get special prizes, CoinWhale is a game in itself!</p>\r\n<p><br />As an uber-bonus, everyone can refer friends to CoinWhale and get paid for it! That''s right, collect credits for every free member you recruit. Every time someone you referred buys a deal, you get even more credits to redeem for cash or prizes.</p>', 4.00, 149.00, '2010-11-14 00:00:00', '2010-11-24 23:59:59', 199, '2010-11-14', 1),
(8, 'Black Friday Fundle 78% Off', '<p><span style="font-size: medium">Moby Deal has found a great deal for Black Friday! This bundle has something for everyone, including a SURPRISE!</span><br /><br /><strong>Miss Bimbo </strong>allows you to become the hottest, coolest, most intelligent and talented bimbo the world has ever known! That''s right, move over Elle Woods, there''s a new blonde in town, get a headstart with <strong>140,000 Bimbo Dollars, a $40 value!</strong><br /><br /><strong>Peel A Meal</strong> is a collectible game like McDonald''s Monopoly, with a fun &amp supportive family friendly community on Facebook. Learn the tips and tricks from the pros who have been peelin'' since 2008. You''ll get a great start with <strong>90&nbspmillion coins &amp 90 Premium Credits, a $50 value!</strong><br /><br /><strong>The Third Game is Surprise</strong>. What is known is that you will get <strong>$20 worth of game currency</strong> at this cool game.</p>\r\n<p>Once this bundle is <strong>100% sold</strong> we will reveal the mystery game, so please tell your friends about CoinWhale by sharing on Facebook &amp Tweeting about us - we''d really appreciate it, and you get rewarded if anyone joins from your link!</p>', 20.00, 90.00, '2010-11-26 00:00:00', '2010-11-30 23:59:59', 250, '2010-11-25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `deal_content`
--

CREATE TABLE IF NOT EXISTS `deal_content` (
  `serial` int(10) NOT NULL auto_increment,
  `deal_id` int(10) default NULL,
  `game_name` varchar(20) default NULL,
  `short_title` varchar(200) default NULL,
  `game_image` varchar(200) default NULL,
  `credit_amt` mediumint(5) default NULL,
  `credit_val` double(8,2) default NULL,
  `currency_name` varchar(50) default NULL,
  `callback_url` varchar(300) default NULL,
  `owner_email` varchar(50) default NULL,
  `game_url` varchar(255) NOT NULL,
  PRIMARY KEY  (`serial`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `deal_content`
--

INSERT INTO `deal_content` (`serial`, `deal_id`, `game_name`, `short_title`, `game_image`, `credit_amt`, `credit_val`, `currency_name`, `callback_url`, `owner_email`, `game_url`) VALUES
(13, 5, 'Kung Fu Cookie', 'test', '1289782876.gif', 10000, 100.00, 'Chi', '', '', 'http://apps.facebook.com/kungfucookie/?ref=coinwhale'),
(14, 5, 'Peel A Meal', 'test', '1289782910.gif', 100, 100.00, 'Premium Credits', 'http://canadiantriangledevelopment.slightlysocial.com/cw_back.php', '', 'http://apps.facebook.com/peelameal/'),
(15, 5, 'Brimmies', 'test', '1289782947.gif', 500, 100.00, 'Brimbucks', 'http://canadiantriangledevelopment.slightlysocial.com/cw_back.php', '', 'http://google.com'),
(16, 8, 'My Bimbo', '', '1290788189.jpg', 140000, 40.00, 'Bimbo Dollars', 'http://www.mybimbo.com/bank/coinWhale.php', 'nicolas@blouzar.com', 'http://apps.facebook.com/mybimbo/?ref=coinwhale'),
(17, 8, 'Peel A Meal', '', '1290751752.gif', 8388607, 50.00, 'Coins', '', 'fbpeelameal@gmail.com', 'http://apps.facebook.com/peelameal/'),
(18, 8, 'Mystery Game', '', '1290752572.png', 1, 20.00, 'surprise', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `deal_content_analytics`
--

CREATE TABLE IF NOT EXISTS `deal_content_analytics` (
  `serial` int(11) NOT NULL,
  `count` mediumint(5) NOT NULL,
  PRIMARY KEY  (`serial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deal_content_analytics`
--

INSERT INTO `deal_content_analytics` (`serial`, `count`) VALUES
(13, 19),
(14, 18),
(15, 15),
(16, 4),
(17, 5);

-- --------------------------------------------------------

--
-- Table structure for table `email_not`
--

CREATE TABLE IF NOT EXISTS `email_not` (
  `email_not_id` int(10) NOT NULL auto_increment,
  `email` varchar(50) default NULL,
  `insert_date` date default NULL,
  PRIMARY KEY  (`email_not_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `email_not`
--

INSERT INTO `email_not` (`email_not_id`, `email`, `insert_date`) VALUES
(3, 'safiul@slightlysocial.com', '2010-11-15'),
(5, 'hackthesack@hotmail.com', '2010-11-21');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_log`
--

CREATE TABLE IF NOT EXISTS `paypal_log` (
  `paypal_id` int(10) NOT NULL auto_increment,
  `deal_id` varchar(50) default NULL,
  `payment_status` varchar(50) default NULL,
  `payment_amount` varchar(50) default NULL,
  `payment_currency` varchar(10) default NULL,
  `txn_id` varchar(100) default NULL,
  `receiver_email` varchar(50) default NULL,
  `payer_email` varchar(50) default NULL,
  `user_id` varchar(20) default NULL,
  `status` tinyint(1) default NULL,
  `insert_date` date default NULL,
  PRIMARY KEY  (`paypal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `paypal_log`
--

INSERT INTO `paypal_log` (`paypal_id`, `deal_id`, `payment_status`, `payment_amount`, `payment_currency`, `txn_id`, `receiver_email`, `payer_email`, `user_id`, `status`, `insert_date`) VALUES
(1, '5', 'Completed', '4.00', 'USD', '13764390XE551161S', 'w_sell_1289416740_biz@yahoo.com', 'w_buy_1289416676_per@yahoo.com', '1', 0, '2010-11-14'),
(2, '5', 'Completed', '4.00', 'USD', '1WJ45335MT436010V', 'w_sell_1289416740_biz@yahoo.com', 'w_buy_1289416676_per@yahoo.com', '1', 0, '2010-11-14'),
(3, '5', 'Completed', '4.00', 'USD', '4BG13703JH060281L', 'w_sell_1289416740_biz@yahoo.com', 'w_buy_1289416676_per@yahoo.com', '2', 0, '2010-11-14'),
(4, '', '', '', '', '', '', '', '', 0, '2010-11-14'),
(5, '5', 'Completed', '4.00', 'USD', '1X975670G6412954F', 'w_sell_1289416740_biz@yahoo.com', 'w_buy_1289416676_per@yahoo.com', '4', 0, '2010-11-14'),
(12, '5', 'Completed', '4.00', 'USD', '0WK864760H2761332', 'w_sell_1289416740_biz@yahoo.com', 'w_buy_1289416676_per@yahoo.com', '7', 0, '2010-11-22'),
(11, '5', 'Completed', '4.00', 'USD', '3KK27597ET769350C', 'w_sell_1289416740_biz@yahoo.com', 'w_buy_1289416676_per@yahoo.com', '1', 0, '2010-11-15'),
(13, '5', 'Completed', '4.00', 'USD', '1WX231561G003174D', 'w_sell_1289416740_biz@yahoo.com', 'w_buy_1289416676_per@yahoo.com', '7', 0, '2010-11-22'),
(14, '8', 'Completed', '20.00', 'USD', '15952418CH6783520', 'w_sell_1289416740_biz@yahoo.com', 'w_buy_1289416676_per@yahoo.com', '11', 0, '2010-11-25');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `per_id` smallint(2) NOT NULL auto_increment,
  `per_name` varchar(50) default NULL,
  PRIMARY KEY  (`per_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `permission`
--


-- --------------------------------------------------------

--
-- Table structure for table `sc_log`
--

CREATE TABLE IF NOT EXISTS `sc_log` (
  `sc_id` int(10) NOT NULL auto_increment,
  `deal_id` varchar(50) default NULL,
  `payment_point` varchar(50) default NULL,
  `payment_amount` varchar(50) default NULL,
  `txn_id` varchar(100) default NULL,
  `user_id` varchar(20) default NULL,
  `status` tinyint(1) default NULL,
  `insert_date` date default NULL,
  PRIMARY KEY  (`sc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `sc_log`
--

INSERT INTO `sc_log` (`sc_id`, `deal_id`, `payment_point`, `payment_amount`, `txn_id`, `user_id`, `status`, `insert_date`) VALUES
(1, '5', '1', '4', 'asdfwer', '1', 1, '2010-11-19'),
(2, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-19'),
(3, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-19'),
(4, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-19'),
(5, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-19'),
(6, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-19'),
(7, '5', '1', '4', 'asdfwer', '1', 1, '2010-11-26'),
(8, '5', '1', '4', 'asdfwer', '1', 1, '2010-11-29'),
(9, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-29'),
(10, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-29'),
(11, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-29'),
(12, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-29'),
(13, '5', '1', '4', 'asdfwer', '7', 1, '2010-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) NOT NULL auto_increment,
  `fb_id` bigint(18) NOT NULL,
  `name` varchar(70) NOT NULL,
  `fname` varchar(50) default NULL,
  `lname` varchar(50) default NULL,
  `email` varchar(50) default NULL,
  `not_email` varchar(50) default NULL,
  `credit` int(10) default NULL,
  `reg_date` date default NULL,
  `last_login` datetime default NULL,
  `refer` varchar(255) default NULL,
  PRIMARY KEY  (`user_id`,`fb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fb_id`, `name`, `fname`, `lname`, `email`, `not_email`, `credit`, `reg_date`, `last_login`, `refer`) VALUES
(1, 655193543, 'Tashfique Ahmed Raymon', 'Tashfique', 'Raymon', 'apps+167246169967286.655193543.efa2ff575b9dc706164', 'raymon007@gmail.com', 264, '2010-11-10', '2010-11-10 21:16:36', 'c51ce410c124a10e0db5e4b97fc2af39'),
(2, 500153809, 'Brad Mills', 'Brad', 'Mills', 'apps+167246169967286.500153809.2d110104b7ffa0dde8f', 'bradmills@hotmail.ca', 201, '2010-11-10', '2010-11-10 23:17:13', 'c51ce410c124a10e0db5e4b97fc2af39'),
(3, 1275111349, 'Tashfique Ahmed Chowdhury', 'Tashfique', 'Chowdhury', 'apps+167246169967286.1275111349.5a5dbdb693ceab42f2', 'raymon3r@yahoo.com', 60, '2010-11-13', '2010-11-13 15:51:24', 'c51ce410c124a10e0db5e4b97fc2af39'),
(5, 100001816860954, 'Robert Honda', 'Robert', 'Honda', 'apps+167246169967286.100001816860954.a25bc98d40a6e', NULL, 0, '2010-11-14', '2010-11-14 22:13:40', 'c51ce410c124a10e0db5e4b97fc2af39'),
(6, 766162836, 'Nicolas Jacquart', 'Nicolas', 'Jacquart', 'apps+167246169967286.766162836.949a72ca4015864b09c', NULL, 0, '2010-11-18', '2010-11-18 18:12:36', 'c51ce410c124a10e0db5e4b97fc2af39'),
(7, 100001671202587, 'Robert Bleck', 'Robert', 'Bleck', 'apps+167246169967286.100001671202587.7dd3189e46265', NULL, 0, '2010-11-19', '2010-11-19 18:44:37', 'c51ce410c124a10e0db5e4b97fc2af39'),
(8, 100001208713282, 'Raymond Angel', 'Raymond', 'Angel', 'apps+167246169967286.100001208713282.4512e71ba5e7e', 'ray@guildpresshq.com', 1, '2010-11-23', '2010-11-23 17:42:34', 'c51ce410c124a10e0db5e4b97fc2af39'),
(9, 641297802, 'Jessica Ly', 'Jessica', 'Ly', 'apps+167246169967286.641297802.87f45073484cd3f2e02', NULL, 0, '2010-11-23', '2010-11-23 19:54:40', 'c51ce410c124a10e0db5e4b97fc2af39'),
(10, 1256065561, 'Carl Yup', 'Carl', 'Yup', 'apps+167246169967286.1256065561.d61deea33041b58e3a', NULL, 0, '2010-11-23', '2010-11-23 20:09:56', 'c51ce410c124a10e0db5e4b97fc2af39'),
(11, 100001814731038, 'Jason Brown', 'Jason', 'Brown', 'apps+167246169967286.100001814731038.0acf439aa04fc', NULL, 0, '2010-11-25', '2010-11-25 20:09:34', 'c51ce410c124a10e0db5e4b97fc2af39'),
(13, 1459639733, 'Samy Stain', 'Samy', 'Stain', 'apps+167246169967286.1459639733.a37c99e844bea9e753', 'wasim2581@yahoo.com', 1, '2010-11-26', '2010-11-26 11:41:23', 'c51ce410c124a10e0db5e4b97fc2af39');

-- --------------------------------------------------------

--
-- Table structure for table `user_buy`
--

CREATE TABLE IF NOT EXISTS `user_buy` (
  `buy_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) default NULL,
  `deal_id` int(10) default NULL,
  `buy_qty` smallint(2) default NULL,
  `pro_price` double(8,2) default NULL,
  `total_price` double(8,2) default NULL,
  `total_retail` double(8,2) default NULL,
  `pay_type` tinyint(1) default NULL,
  `status` tinyint(1) default NULL,
  `buy_date` date default NULL,
  PRIMARY KEY  (`buy_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `user_buy`
--

INSERT INTO `user_buy` (`buy_id`, `user_id`, `deal_id`, `buy_qty`, `pro_price`, `total_price`, `total_retail`, `pay_type`, `status`, `buy_date`) VALUES
(1, 1, 2, 2, 27.00, 54.00, 758.00, 1, 1, '2010-11-11'),
(2, 2, 1, 1, 27.00, 27.00, 379.00, 1, 1, '2010-11-11'),
(9, 1, 5, 1, 4.00, 4.00, 149.00, 1, 1, '2010-11-14'),
(8, 1, 5, 1, 4.00, 4.00, 149.00, 1, 1, '2010-11-14'),
(10, 2, 5, 1, 4.00, 4.00, 149.00, 1, 1, '2010-11-14'),
(11, 4, 5, 1, 4.00, 4.00, 149.00, 1, 1, '2010-11-14'),
(12, 1, 5, 1, 4.00, 4.00, 149.00, 1, 1, '2010-11-15'),
(26, 7, 5, 1, 4.00, 4.00, 149.00, 1, 1, '2010-11-22'),
(25, 2, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-20'),
(24, 2, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-20'),
(23, 7, 5, 1, 4.00, 4.00, 149.00, 1, 1, '2010-11-19'),
(27, 7, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-22'),
(28, 7, 5, 1, 4.00, 4.00, 149.00, 1, 1, '2010-11-22'),
(29, 9, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-23'),
(30, 9, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-23'),
(31, 9, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-23'),
(32, 10, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-23'),
(33, 10, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-23'),
(34, 10, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-23'),
(35, 11, 8, 1, 20.00, 20.00, 70.00, 1, 0, '2010-11-25'),
(36, 11, 8, 1, 20.00, 20.00, 70.00, 1, 0, '2010-11-25'),
(37, 11, 8, 1, 20.00, 20.00, 70.00, 1, 1, '2010-11-25'),
(38, 3, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-26'),
(39, 3, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-26'),
(40, 3, 5, 1, 4.00, 4.00, 149.00, 1, 0, '2010-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `user_refer`
--

CREATE TABLE IF NOT EXISTS `user_refer` (
  `serial` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `refer_id` int(10) default NULL,
  `insert_date` date default NULL,
  PRIMARY KEY  (`serial`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user_refer`
--

INSERT INTO `user_refer` (`serial`, `user_id`, `refer_id`, `insert_date`) VALUES
(1, 2, 1, '2010-11-12'),
(2, 3, 1, '2010-11-13'),
(3, 4, 1, '2010-11-14'),
(4, 5, 1, '2010-11-14'),
(5, 8, 1, '2010-11-23'),
(6, 10, 1, '2010-11-23'),
(7, 12, 1, '2010-11-26'),
(8, 13, 1, '2010-11-26');
