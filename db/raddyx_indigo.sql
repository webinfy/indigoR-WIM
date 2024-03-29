-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 28, 2016 at 06:47 AM
-- Server version: 5.6.34
-- PHP Version: 5.6.28RC1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `raddyx_indigo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `name`, `is_active`, `type`, `created`, `modified`) VALUES
(1, 'admin@indigo.com', '$2y$10$CQ7SeeDokW8ofNzoaQhR4eBkjeI5DTfLAqyPj.DQ9J5Nc6VAunIdq', 'Admin', 1, 1, '2016-11-02 00:00:00', '2016-11-02 00:00:00'),
(2, 'admin2@indigo.com', '$2y$10$CQ7SeeDokW8ofNzoaQhR4eBkjeI5DTfLAqyPj.DQ9J5Nc6VAunIdq', 'Admin2', 1, 2, '2016-11-02 00:00:00', '2016-11-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

DROP TABLE IF EXISTS `admin_settings`;
CREATE TABLE `admin_settings` (
  `id` int(11) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `bcc_email` varchar(100) NOT NULL,
  `from_email` varchar(100) NOT NULL,
  `support_email` varchar(100) NOT NULL,
  `newcard_notify_email` varchar(60) NOT NULL,
  `card_approve_email` varchar(60) NOT NULL,
  `site_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `admin_email`, `bcc_email`, `from_email`, `support_email`, `newcard_notify_email`, `card_approve_email`, `site_name`) VALUES
(1, 'admin@payuairline.com', 'bhupendra.khatri@payu.in', 'PayuAirline@payu.in', 'support@payuairline.com', 'ayush.mittal@payu.in', 'ayush.mittal@payu.in', 'PayuAirline');

-- --------------------------------------------------------

--
-- Table structure for table `airlines`
--

DROP TABLE IF EXISTS `airlines`;
CREATE TABLE `airlines` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `is_active` tinyint(4) NOT NULL COMMENT '1=Active/0=In-active',
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airlines`
--

INSERT INTO `airlines` (`id`, `name`, `username`, `password`, `is_active`, `created`) VALUES
(1, 'Indigo Airlines', 'indigo', '0bb3fd263da68491305dcfb64e5119f6', 1, '2016-09-13 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_token` varchar(50) DEFAULT NULL,
  `card_no` varchar(100) DEFAULT NULL,
  `card_type` varchar(50) DEFAULT NULL,
  `mode` varchar(20) DEFAULT NULL,
  `login_id` varchar(100) DEFAULT NULL,
  `agency_id` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mandate_form` varchar(100) DEFAULT NULL,
  `scanned_credit_card` varchar(100) DEFAULT NULL,
  `document3` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `is_approve` tinyint(4) DEFAULT NULL COMMENT '1 - approve, 2 - decline, 0 - pending',
  `is_enabled` tinyint(4) DEFAULT '1' COMMENT '1=Yes/0=No',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `user_id`, `card_token`, `card_no`, `card_type`, `mode`, `login_id`, `agency_id`, `email`, `mandate_form`, `scanned_credit_card`, `document3`, `bank_name`, `is_approve`, `is_enabled`, `created`, `modified`) VALUES
(22, 2, 'c5e2d74d2604be8ad25bd2938cc1a78729a16db7', '512345XXXXXX2346', 'VISA', NULL, '123456', '123456', 'pradeepta20@gmail.com', 'daa07dbee37c35857ac4d45900102277.docx', '9779c2a02c9541af236904c5a913b462.docx', 'a1712d6a1efedf3cc1fb907c7cf69d78.docx', 'dena', 1, 1, '2016-11-29 13:07:37', NULL),
(23, 2, 'e57dd1d5d6ee0b8f4c3c66776d82d2df4fd28943', '512345XXXXXX2346', 'VISA', NULL, '5468998', 't97ohddf', 'bhupendra.khatri@payu.in', 'ef606848783493a814c06a366881f0b6.png', '52685a19709eaf8d987516e96acda028.png', 'bff83c7d09df575e4f88bc3c5776cd94.png', 'axis', 1, 0, '2016-12-07 13:37:39', NULL),
(33, 2, '4abd61af8cfb4d46a1be1123098d1f7ee44e4a01', '528945XXXXXX4756', 'MASTER CARD', NULL, NULL, NULL, NULL, 'fa514f4d62ccebba90b1b1dbc8fee4a9.pdf', NULL, NULL, 'Decimal', 1, 0, '2016-12-19 09:59:31', NULL),
(34, 2, 'a0bf33a1b828147bdd0d190077c539fb2eff9844', '455701XXXXXX8902', 'VISA', NULL, NULL, NULL, NULL, 'c4711b58c2f535a5d76e50c6b3a4c97d.docx', NULL, NULL, 'ICICI', 2, 0, '2016-12-19 10:00:22', NULL),
(36, 2, '4abd61af8cfb4d46a1be1123098d1f7ee44e4a01', '528945XXXXXX4756', 'VISA', NULL, NULL, NULL, NULL, 'd0023673b8d551a61a97ee7049fc027a.docx', NULL, NULL, 'ICICI', 1, 0, '2016-12-19 11:35:06', NULL),
(37, 2, '5e1c282de31211910e6148d0354d013fe7b4e07a', '528945XXXXXX4756', 'MASTER CARD', NULL, NULL, NULL, NULL, '721a45d46cde02877f608be7a7bdccf2.docx', NULL, NULL, 'ayush', 1, 1, '2016-12-20 07:14:25', NULL),
(38, 2, '9a4291a26123e1cd1e16d633ed22bb771123d0af', '528945XXXXXX4756', 'VISA', NULL, NULL, NULL, NULL, '0aa3c456698b1e9089712f6b21dcea0d.pdf', NULL, NULL, 'AXIS', 1, 1, '2016-12-20 11:37:43', NULL),
(39, 2, '69ba9d39c5b2900c5a7e826eb20d300eb53ba3fb', '528945XXXXXX4756', 'VISA', NULL, NULL, NULL, NULL, 'bc7710540ce441063be2e72f3f05e8ad.docx', NULL, NULL, 'HDFC', 2, 1, '2016-12-21 05:13:05', NULL),
(40, 2, '882fdc65c58722c91cf219a31f323295b9bccf68', '500446XXXXXX0000', 'VISA', NULL, NULL, NULL, NULL, '213e8cae87396650e5583044dac25108.pdf', NULL, NULL, 'HDFC', 1, 1, '2016-12-21 08:06:07', NULL),
(44, 2, 'c90a42dff4278a0a15f57a1ebf943ab8d69754b6', '512345XXXXXX2346', 'VISA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SBI', 1, 0, '2016-12-26 09:13:53', NULL),
(45, 2, 'a19da2a491653941a3231b534bc1d5042e1a1538', '512345XXXXXX2346', 'MAESTRO', NULL, NULL, NULL, NULL, '53639299cf2f6c150e79cd57f5b3cada.pdf', NULL, NULL, 'hdfc', 0, 1, '2016-12-26 11:02:56', NULL),
(46, 2, 'c90a42dff4278a0a15f57a1ebf943ab8d69754b6', '512345XXXXXX2346', 'VISA', NULL, NULL, NULL, NULL, '702e55662551deace7d3383729a65bc4.docx', NULL, NULL, 'ICICI', 0, 1, '2016-12-27 05:49:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_transactions`
--

DROP TABLE IF EXISTS `failed_transactions`;
CREATE TABLE `failed_transactions` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `is_recovered` tinyint(4) NOT NULL COMMENT '1=Yes/0=No',
  `recovered_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `failed_transactions`
--

INSERT INTO `failed_transactions` (`id`, `transaction_id`, `is_recovered`, `recovered_at`) VALUES
(1, 22, 1, '2016-11-18 08:30:02'),
(2, 23, 1, '2016-11-18 08:30:03'),
(3, 24, 1, '2016-11-18 08:30:03'),
(4, 25, 1, '2016-11-18 08:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

DROP TABLE IF EXISTS `mail_templates`;
CREATE TABLE `mail_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `is_active` tinyint(4) NOT NULL COMMENT '1=Active / 0= Not'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `name`, `subject`, `content`, `is_active`) VALUES
(1, 'CARD_REGISTERED', 'New Card Registered', '<p>&nbsp;</p><p>Hi Admin,</p> <p>Please check the details of a new card which has been approved recently.</p> <p>&nbsp;</p> <p>Agent Name: [NAME]</p> <p>Card No: [CARD_NO]</p> <p>Login Id: [LOGIN_ID]</p> <p>Agency Id: [AGENCY_ID]</p> <p>Bank Name: [BANK_NAME]</p> <p>Email: [EMAIL]</p> <p>&nbsp;</p> <p>Best Regards,</p> <p>Team [SITE_NAME]</p> <p>&nbsp;</p>', 1),
(2, 'CARD_APPROVED', 'Card Approved', '<p>&nbsp;</p><p>Hi Admin,</p> <p>A new card has been approved by the admin please check the details.</p> <p>&nbsp;</p> <p>Agent Name: [NAME]</p> <p>Card No: [CARD_NO]</p> <p>Login Id: [LOGIN_ID]</p> <p>Agency Id: [AGENCY_ID]</p> <p>Bank Name: [BANK_NAME]</p> <p>Email: [EMAIL]</p> <p>&nbsp;</p> <p>Best Regards,</p> <p>Team [SITE_NAME]</p> <p>&nbsp;</p>', 1),
(3, 'CARD_DECLINED', 'Card Declined', '<p>&nbsp;</p>\r\n<p>Hi Admin,</p> \r\n<p>A card has been declined by the admin please check the details.</p> \r\n<p>&nbsp;</p> \r\n<p>Agent Name: [NAME]</p> \r\n<p>Card No: [CARD_NO]</p> \r\n<p>Login Id: [LOGIN_ID]</p> \r\n<p>Agency Id: [AGENCY_ID]</p> \r\n<p>Bank Name: [BANK_NAME]</p> \r\n<p>Email: [EMAIL]</p> \r\n<p>&nbsp;</p> \r\n<p>Best Regards,</p> \r\n<p>Team [SITE_NAME]</p> \r\n<p>&nbsp;</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `card_number` varchar(30) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `mihpayid` varchar(50) DEFAULT NULL,
  `pending_url_hit` tinyint(4) DEFAULT '0' COMMENT '1=Yes/0=No',
  `unmappedstatus` varchar(20) DEFAULT 'usercancelled' COMMENT 'dropped/bounced/captured/auth/failed/usercancelled/pending ',
  `payment_status` tinyint(4) DEFAULT '4' COMMENT '1=Success/2=Pending/3=Failure/4=Canceled',
  `navitor_status` tinyint(4) DEFAULT '0' COMMENT '0=Pending / 1= Paid',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `transaction_id`, `amount`, `card_number`, `token`, `mihpayid`, `pending_url_hit`, `unmappedstatus`, `payment_status`, `navitor_status`, `created`, `modified`) VALUES
(33, 2, '15411480414973', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515272422', 1, 'captured', 1, NULL, '2016-11-29 10:22:53', '2016-11-29 10:24:09'),
(34, 2, '95141480415293', '1234567890123.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, NULL, '2016-11-29 10:28:13', '2016-11-29 10:28:13'),
(35, 2, '89451480415505', '10.00', '401200XXXXXX1112', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-11-29 10:31:45', '2016-11-29 10:31:59'),
(36, 2, '63671480415532', '15.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515272533', 1, 'captured', 1, NULL, '2016-11-29 10:32:12', '2016-11-29 10:32:56'),
(37, 2, '55071480415981', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515272585', 1, 'captured', 1, NULL, '2016-11-29 10:39:41', '2016-11-29 10:40:23'),
(38, 2, '44771480416961', '101.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515272735', 1, 'captured', 1, NULL, '2016-11-29 10:56:01', '2016-11-29 11:04:36'),
(39, 2, '63411480417811', '102.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515272847', 1, 'captured', 1, NULL, '2016-11-29 11:10:11', '2016-11-29 11:10:48'),
(40, 2, '88511480417917', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515272868', 0, 'captured', 1, NULL, '2016-11-29 11:11:57', '2016-11-29 11:12:35'),
(41, 2, '84541480417995', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515272880', 1, 'captured', 1, NULL, '2016-11-29 11:13:15', '2016-11-29 11:13:52'),
(42, 2, '78651480418066', '100.00', '401200XXXXXX1112', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-11-29 11:14:26', '2016-11-29 11:15:42'),
(43, 2, '65331480418478', '700.00', '401200XXXXXX1112', '12DDF445SHHHS33', '403993715515273009', 1, 'captured', 1, NULL, '2016-11-29 11:21:18', '2016-11-29 11:22:45'),
(44, 2, '45541480418622', '898.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, NULL, '2016-11-29 11:23:42', '2016-11-29 11:23:42'),
(45, 2, '71551480419530', '89898.00', '401200XXXXXX1112', '12DDF445SHHHS33', '403993715515273275', 1, 'captured', 1, NULL, '2016-11-29 11:38:50', '2016-11-29 11:40:00'),
(46, 2, '99081480425200', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-11-29 13:13:20', '2016-11-29 13:14:08'),
(47, 2, '44851480425621', '10.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-11-29 13:20:21', '2016-11-29 13:20:40'),
(48, 2, '85731480426278', '10.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-11-29 13:31:18', '2016-11-29 13:34:45'),
(49, 2, '75221480426506', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-11-29 13:35:06', '2016-11-29 13:35:28'),
(50, 2, '41711480481426', '100000.00', '401200XXXXXX1112', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-11-30 04:50:26', '2016-11-30 04:51:01'),
(51, 2, '65951480481487', '30000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515275287', 1, 'captured', 1, NULL, '2016-11-30 04:51:27', '2016-11-30 04:52:09'),
(52, 2, '95411481009027', '10000.00', '401200XXXXXX1112', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-12-06 07:23:47', '2016-12-06 07:24:28'),
(53, 2, '55341481010726', '50000.00', '401200XXXXXX1112', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, NULL, '2016-12-06 07:52:06', '2016-12-06 07:52:06'),
(54, 2, '53791481010791', '500.00', '401200XXXXXX1112', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-12-06 07:53:11', '2016-12-06 07:55:07'),
(55, 2, '21931481011023', '2000.00', '401200XXXXXX1112', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-12-06 07:57:03', '2016-12-06 07:57:43'),
(56, 2, '64401481106944', '1000.00', '401200XXXXXX1112', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, NULL, '2016-12-07 10:35:44', '2016-12-07 10:36:22'),
(57, 2, '37811481117339', '35.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515325188', 1, 'captured', 1, NULL, '2016-12-07 13:28:59', '2016-12-07 13:29:42'),
(58, 2, '27361481118129', '456.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 3, 0, '2016-12-07 13:42:09', '2016-12-07 13:43:08'),
(59, 2, '80621481119798', '201.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515325349', 0, 'failed', 3, 0, '2016-12-07 14:09:58', '2016-12-07 14:10:24'),
(60, 2, '12081481120126', '102.00', '401200XXXXXX1112', '12DDF445SHHHS33', '403993715515325365', 0, 'failed', 3, 0, '2016-12-07 14:15:26', '2016-12-07 14:16:50'),
(61, 2, '64901481120249', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515325372', 0, 'captured', 1, 1, '2016-12-07 14:17:29', '2016-12-07 14:18:09'),
(62, 2, '32141481187144', '1000.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-08 08:52:24', '2016-12-08 08:52:24'),
(63, 2, '46491481189421', '100000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515328351', 0, 'failed', 3, 0, '2016-12-08 09:30:21', '2016-12-08 09:30:50'),
(64, 2, '72601481189994', '0.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-08 09:39:54', '2016-12-08 09:39:54'),
(65, 2, '64861481195245', '200.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-08 11:07:25', '2016-12-08 11:07:25'),
(66, 2, '39201481195604', '200.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-08 11:13:24', '2016-12-08 11:13:24'),
(67, 2, '44101481195783', '200.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515329842', 0, 'captured', 1, 0, '2016-12-08 11:16:23', '2016-12-08 11:17:10'),
(68, 2, '17481481195843', '1000.00', '401200XXXXXX1112', '12DDF445SHHHS33', '403993715515329859', 0, 'failed', 3, 0, '2016-12-08 11:17:23', '2016-12-08 11:17:58'),
(69, 2, '15891481277912', '455.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515338631', 1, 'captured', 1, 0, '2016-12-09 10:05:12', '2016-12-09 10:06:11'),
(70, 2, '14101481341367', '1500.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515340834', 1, 'captured', 1, 0, '2016-12-10 03:42:47', '2016-12-10 03:43:45'),
(71, 2, '33661481537403', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515354310', 0, 'failed', 3, 0, '2016-12-12 10:10:03', '2016-12-12 10:10:30'),
(72, 2, '17311481537452', '101.00', '401200XXXXXX1112', '12DDF445SHHHS33', '403993715515354321', 0, 'failed', 3, 0, '2016-12-12 10:10:52', '2016-12-12 10:11:15'),
(73, 2, '68621481538359', '5000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515354499', 0, 'failed', 3, 0, '2016-12-12 10:25:59', '2016-12-12 10:26:45'),
(74, 2, '33101481538461', '5000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515354537', 0, 'failed', 3, 0, '2016-12-12 10:27:41', '2016-12-12 10:28:12'),
(75, 2, '64281481538538', '5000.00', '401200XXXXXX1112', '12DDF445SHHHS33', '403993715515354561', 0, 'failed', 3, 0, '2016-12-12 10:28:58', '2016-12-12 10:30:02'),
(76, 2, '79201481538871', '5000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515354636', 0, 'failed', 3, 0, '2016-12-12 10:34:31', '2016-12-12 10:35:03'),
(77, 2, '12441481539525', '2000.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-12 10:45:25', '2016-12-12 10:46:29'),
(78, 2, '79911481539632', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515354770', 0, 'failed', 3, 0, '2016-12-12 10:47:12', '2016-12-12 10:49:49'),
(79, 2, '67771481539800', '10.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515354798', 0, 'failed', 3, 0, '2016-12-12 10:50:00', '2016-12-12 10:50:51'),
(80, 2, '26621481540094', '10.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515354851', 0, 'failed', 3, 0, '2016-12-12 10:54:54', '2016-12-12 10:55:19'),
(81, 2, '65961481540376', '1.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515354905', 0, 'failed', 3, 0, '2016-12-12 10:59:36', '2016-12-12 11:00:01'),
(82, 2, '26811481540735', '102.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515354966', 0, 'failed', 3, 0, '2016-12-12 11:05:35', '2016-12-12 11:06:03'),
(83, 2, '75841481541473', '1.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515355065', 0, 'failed', 3, 0, '2016-12-12 11:17:53', '2016-12-12 11:18:18'),
(84, 2, '26621481541522', '2.00', '401200XXXXXX1112', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-12 11:18:42', '2016-12-12 11:18:42'),
(85, 2, '63971481541685', '3.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-12 11:21:25', '2016-12-12 11:21:25'),
(86, 2, '20901481604661', '20.00', '401200XXXXXX1112', '12DDF445SHHHS33', '403993715515361641', 0, 'failed', 3, 0, '2016-12-13 04:51:01', '2016-12-13 04:51:46'),
(87, 2, '73091481607446', '1000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515361873', 0, 'failed', 3, 0, '2016-12-13 05:37:26', '2016-12-13 05:38:03'),
(88, 2, '68451481607564', '500.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515361892', 0, 'failed', 3, 0, '2016-12-13 05:39:24', '2016-12-13 05:40:12'),
(89, 2, '33661481609553', '1000.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-13 06:12:33', '2016-12-13 06:12:33'),
(90, 2, '90501481609632', '6789.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515362163', 1, 'captured', 1, 0, '2016-12-13 06:13:52', '2016-12-13 06:14:41'),
(91, 2, '90531481609638', '1000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515362166', 1, 'captured', 1, 0, '2016-12-13 06:13:58', '2016-12-13 06:15:05'),
(92, 2, '49281481609710', '99.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515362180', 0, 'failed', 3, 0, '2016-12-13 06:15:10', '2016-12-13 06:15:36'),
(93, 2, '48361481610018', '100.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-13 06:20:18', '2016-12-13 06:21:13'),
(94, 2, '43471481610102', '1000.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-13 06:21:42', '2016-12-13 06:21:42'),
(95, 2, '35621481610341', '2000.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-13 06:25:41', '2016-12-13 06:25:41'),
(96, 2, '88651481611218', '250.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515362376', 0, 'failed', 3, 0, '2016-12-13 06:40:18', '2016-12-13 06:44:05'),
(97, 2, '55521481611475', '1005.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515362411', 1, 'captured', 1, 1, '2016-12-13 06:44:35', '2016-12-13 06:45:46'),
(98, 2, '12711481612435', '1234.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515362539', 1, 'captured', 1, 0, '2016-12-13 07:00:35', '2016-12-13 07:01:33'),
(99, 2, '48911481613213', '0.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515362673', 0, 'failed', 3, 0, '2016-12-13 07:13:33', '2016-12-13 07:13:58'),
(100, 2, '97021481614278', '1000000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-13 07:31:18', '2016-12-13 07:35:23'),
(101, 2, '26981481614652', '99000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-13 07:37:32', '2016-12-13 07:38:32'),
(102, 2, '89311481614768', '9900000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515362886', 0, 'failed', 3, 0, '2016-12-13 07:39:28', '2016-12-13 07:40:13'),
(103, 2, '86111481615108', '999999.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515362922', 1, 'captured', 1, 0, '2016-12-13 07:45:08', '2016-12-13 07:45:54'),
(104, 2, '77971481619280', '0.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515363236', 0, 'failed', 3, 0, '2016-12-13 08:54:40', '2016-12-13 08:55:28'),
(105, 2, '24651481619390', '0.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515363244', 0, 'failed', 3, 0, '2016-12-13 08:56:30', '2016-12-13 08:56:58'),
(106, 2, '26761481619471', '1.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515363246', 0, 'failed', 3, 0, '2016-12-13 08:57:51', '2016-12-13 08:58:18'),
(107, 2, '26991481619847', '10000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515363282', 1, 'captured', 1, 0, '2016-12-13 09:04:07', '2016-12-13 09:05:58'),
(108, 2, '77421481620786', '10000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515363398', 1, 'captured', 1, 0, '2016-12-13 09:19:46', '2016-12-13 09:21:04'),
(109, 2, '28651481627293', '12345.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515364447', 0, 'failed', 3, 0, '2016-12-13 11:08:13', '2016-12-13 11:08:51'),
(110, 2, '50881481634092', '11.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515365551', 0, 'failed', 3, 0, '2016-12-13 13:01:32', '2016-12-13 13:02:01'),
(111, 2, '31881481634348', '11.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515365583', 0, 'failed', 3, 0, '2016-12-13 13:05:48', '2016-12-13 13:06:16'),
(112, 2, '23651481634434', '11.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515365596', 0, 'failed', 3, 0, '2016-12-13 13:07:14', '2016-12-13 13:07:39'),
(113, 2, '63801481635809', '1000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515365789', 0, 'failed', 3, 0, '2016-12-13 13:30:09', '2016-12-13 13:30:41'),
(114, 2, '61441481635935', '1000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515365804', 0, 'failed', 3, 0, '2016-12-13 13:32:15', '2016-12-13 13:32:41'),
(115, 2, '52971481636007', '10.00', '401200XXXXXX1112', '12DDF445SHHHS33', '403993715515365809', 0, 'failed', 3, 0, '2016-12-13 13:33:27', '2016-12-13 13:34:06'),
(116, 2, '34531481638662', '1000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515366018', 0, 'failed', 3, 0, '2016-12-13 14:17:42', '2016-12-13 14:18:08'),
(117, 2, '92141481800634', '10000000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-15 11:17:14', '2016-12-15 11:17:14'),
(118, 2, '14581481800770', '123456789.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-15 11:19:30', '2016-12-15 11:19:30'),
(119, 2, '77441481800976', '15001.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515378434', 0, 'failed', 3, 0, '2016-12-15 11:22:56', '2016-12-15 11:23:24'),
(120, 2, '21481481802302', '100000000000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515378626', 0, 'failed', 3, 0, '2016-12-15 11:45:02', '2016-12-15 11:46:54'),
(121, 2, '29251481803175', '1000000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-15 11:59:35', '2016-12-15 11:59:35'),
(122, 2, '63821481881686', '100000000000000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515382704', 0, 'failed', 3, 0, '2016-12-16 09:48:06', '2016-12-16 09:48:30'),
(123, 2, '98241481882597', '500000000.01', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-16 10:03:17', '2016-12-16 10:03:17'),
(124, 2, '77461481885945', '100.01', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515383402', 0, 'failed', 3, 0, '2016-12-16 10:59:05', '2016-12-16 10:59:42'),
(125, 2, '33901481886065', '1000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515383430', 1, 'captured', 1, 0, '2016-12-16 11:01:05', '2016-12-16 11:01:45'),
(126, 2, '48161481888009', '10000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515383687', 1, 'captured', 1, 0, '2016-12-16 11:33:29', '2016-12-16 11:34:03'),
(127, 2, '85281482127045', '123456789012350000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515388840', 0, 'failed', 3, 0, '2016-12-19 05:57:25', '2016-12-19 05:57:55'),
(128, 2, '40421482127143', '123456789012350000.00', '401200XXXXXX1112', '12DDF445SHHHS33', '403993715515388856', 0, 'failed', 3, 0, '2016-12-19 05:59:03', '2016-12-19 05:59:24'),
(129, 2, '23151482127290', '12345678901235678.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515388874', 0, 'failed', 3, 0, '2016-12-19 06:01:30', '2016-12-19 06:01:45'),
(130, 2, '89201482127522', '12345.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515388903', 0, 'failed', 3, 0, '2016-12-19 06:05:22', '2016-12-19 06:06:23'),
(131, 2, '32621482127949', '12345678901235678.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515388967', 0, 'failed', 3, 0, '2016-12-19 06:12:29', '2016-12-19 06:12:43'),
(132, 2, '21581482141784', '100000000000000000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515391081', 0, 'failed', 3, 0, '2016-12-19 10:03:04', '2016-12-19 10:03:17'),
(133, 2, '39161482141887', '100000.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515391099', 0, 'failed', 3, 0, '2016-12-19 10:04:47', '2016-12-19 10:05:06'),
(134, 2, '20211482141944', '10.00', '512345XXXXXX2346', '12DDF445SHHHS33', '403993715515391106', 0, 'failed', 3, 0, '2016-12-19 10:05:44', '2016-12-19 10:06:48'),
(135, 2, '50941482142513', '7.89', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515391208', 1, 'captured', 1, 0, '2016-12-19 10:15:13', '2016-12-19 10:15:20'),
(136, 2, '18241482142942', '1000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515391301', 1, 'captured', 1, 0, '2016-12-19 10:22:22', '2016-12-19 10:22:29'),
(137, 2, '85681482147485', '50000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515392057', 1, 'captured', 1, 1, '2016-12-19 11:38:05', '2016-12-19 11:38:16'),
(138, 2, '27221482147887', '1000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-19 11:44:47', '2016-12-19 11:44:47'),
(139, 2, '67911482148462', '1000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515392234', 1, 'captured', 1, 0, '2016-12-19 11:54:22', '2016-12-19 11:54:32'),
(140, 2, '40741482148740', '100000000000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515392291', 0, 'failed', 3, 0, '2016-12-19 11:59:00', '2016-12-19 11:59:15'),
(141, 2, '99041482148889', '0.01', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515392308', 1, 'captured', 1, 0, '2016-12-19 12:01:29', '2016-12-19 12:01:40'),
(142, 2, '58721482157806', '1000.01', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515393562', 1, 'captured', 1, 0, '2016-12-19 14:30:06', '2016-12-19 14:30:17'),
(143, 2, '53591482210076', '10.10', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515394368', 1, 'captured', 1, 0, '2016-12-20 05:01:16', '2016-12-20 05:01:26'),
(144, 2, '95421482218796', '1000000000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515395670', 0, 'failed', 3, 0, '2016-12-20 07:26:36', '2016-12-20 07:28:09'),
(145, 2, '63301482225698', '1000000000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515396541', 0, 'failed', 3, 0, '2016-12-20 09:21:38', '2016-12-20 09:21:43'),
(146, 2, '39101482225740', '100000000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515396549', 0, 'failed', 3, 0, '2016-12-20 09:22:20', '2016-12-20 09:22:24'),
(147, 2, '77211482225783', '1000000000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515396554', 0, 'failed', 3, 0, '2016-12-20 09:23:03', '2016-12-20 09:23:09'),
(148, 2, '26631482225805', '1000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515396557', 1, 'captured', 1, 0, '2016-12-20 09:23:25', '2016-12-20 09:23:31'),
(149, 2, '29781482225839', '100000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515396564', 1, 'captured', 1, 0, '2016-12-20 09:23:59', '2016-12-20 09:24:06'),
(150, 2, '24651482225882', '10000000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515396570', 0, 'failed', 3, 0, '2016-12-20 09:24:42', '2016-12-20 09:24:47'),
(151, 2, '25131482225913', '1000000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515396577', 0, 'failed', 3, 0, '2016-12-20 09:25:13', '2016-12-20 09:25:18'),
(152, 2, '28051482225991', '1000000000000.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515396592', 0, 'failed', 3, 0, '2016-12-20 09:26:31', '2016-12-20 09:26:35'),
(153, 2, '54551482307711', '0.01', '500446XXXXXX0000', '12DDF445SHHHS33', '403993715515401996', 1, 'captured', 1, 1, '2016-12-21 08:08:31', '2016-12-21 08:08:42'),
(154, 2, '34411482307782', '999999999999.00', '500446XXXXXX0000', '12DDF445SHHHS33', '403993715515402003', 1, 'captured', 1, 1, '2016-12-21 08:09:42', '2016-12-21 08:09:50'),
(155, 2, '44911482476163', '999999999999.00', '500446XXXXXX0000', '12DDF445SHHHS33', '403993715515412592', 1, 'captured', 1, 1, '2016-12-23 06:56:03', '2016-12-23 06:56:16'),
(156, 2, '62281482476306', '999999999998.01', '500446XXXXXX0000', '12DDF445SHHHS33', '403993715515412611', 0, 'failed', 3, 0, '2016-12-23 06:58:26', '2016-12-23 06:58:34'),
(157, 2, '58961482476739', '999999999999.00', '500446XXXXXX0000', '12DDF445SHHHS33', '403993715515412681', 1, 'captured', 1, 1, '2016-12-23 07:05:39', '2016-12-23 07:05:48'),
(158, 2, '65481482476864', '999999999998.01', '500446XXXXXX0000', '12DDF445SHHHS33', '403993715515412706', 0, 'failed', 3, 0, '2016-12-23 07:07:44', '2016-12-23 07:07:50'),
(159, 2, '75591482479734', '999999999998.01', '500446XXXXXX0000', '12DDF445SHHHS33', '403993715515413099', 0, 'failed', 3, 0, '2016-12-23 07:55:34', '2016-12-23 07:55:41'),
(160, 2, '33831482737355', '105.00', '528945XXXXXX4756', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-26 07:29:15', '2016-12-26 07:29:15'),
(161, 2, '42011482737654', '105.00', '528945XXXXXX4756', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-26 07:34:14', '2016-12-26 07:34:14'),
(162, 2, '41911482737668', '105.00', '512345XXXXXX2346', '12DDF445SHHHS33', NULL, 0, 'usercancelled', 4, 0, '2016-12-26 07:34:28', '2016-12-26 07:34:28'),
(163, 2, '66901482737877', '105.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515420223', 1, 'captured', 1, 1, '2016-12-26 07:37:57', '2016-12-26 07:38:06'),
(164, 2, '46061482738100', '106.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515420240', 1, 'captured', 1, 1, '2016-12-26 07:41:40', '2016-12-26 07:41:48'),
(165, 2, '23791482754205', '106.00', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515422211', 1, 'captured', 1, 1, '2016-12-26 12:10:05', '2016-12-26 12:10:18'),
(166, 2, '84821482754249', '107.50', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515422218', 0, 'failed', 3, 0, '2016-12-26 12:10:49', '2016-12-26 12:10:56'),
(167, 2, '42661482754336', '108.56', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515422237', 0, 'captured', 1, 0, '2016-12-26 12:12:16', '2016-12-26 12:12:24'),
(168, 2, '89111482754395', '109.60', '528945XXXXXX4756', '12DDF445SHHHS33', '403993715515422248', 1, 'captured', 1, 1, '2016-12-26 12:13:15', '2016-12-26 12:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `agent_id` varchar(50) DEFAULT NULL,
  `auth_token` varchar(500) DEFAULT NULL COMMENT 'Toen For Login',
  `agent_data` text,
  `airline_id` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '2' COMMENT '1=Admin/ 2= Agent',
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `agent_id`, `auth_token`, `agent_data`, `airline_id`, `type`, `firstname`, `lastname`, `email`, `mobile`, `token`, `created`, `updated`, `last_login_date`) VALUES
(2, '11111111', '', '', 1, 2, 'Ayush', 'Mittal', 'ayush.mittal@payu.in', '7503099896', '12DDF445SHHHS33', '2016-11-08 11:08:22', NULL, '2016-12-27 07:49:24'),
(3, '11111112', '', '', 1, 2, 'Ayush', 'Mittal', 'ayush.mbd@gmail.com', '7503099896', '12DDF445SHHHS33', '2016-11-09 07:04:28', NULL, '2016-11-10 10:04:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `airlines`
--
ALTER TABLE `airlines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_transactions`
--
ALTER TABLE `failed_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `airlines`
--
ALTER TABLE `airlines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `failed_transactions`
--
ALTER TABLE `failed_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
