-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 16, 2018 at 05:43 AM
-- Server version: 10.1.9-MariaDB-log
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `radius`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nama_kepala` varchar(150) NOT NULL,
  `jabatan_kepala` varchar(150) NOT NULL,
  `joining_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `nama`, `nama_kepala`, `jabatan_kepala`, `joining_date`) VALUES
(1, 'admin', 'admin@mail.com', '$2y$10$MYA3of3jvHr08URMkWNJweq3NYDPRIPeLtKIDBwou5Y8BEEGnGAvC', 'Administrator', 'Wandie Wijaya', 'Chief Executive Officer', '2016-07-14 19:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `harga`
--

CREATE TABLE `harga` (
  `groupname` varchar(255) NOT NULL,
  `harga` int(20) DEFAULT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `harga`
--

INSERT INTO `harga` (`groupname`, `harga`, `deskripsi`, `tgl_dibuat`) VALUES
('Ekonomis 2 jam', 3000, 'Paket ekonomis 2 jam dihitung dari pertama kali login', '2017-01-15 14:04:15'),
('Ekonomis 3 Jam', 10000, 'Paket ekonomis 3 jam dihitung saat pertama login', '2017-05-13 03:06:40'),
('Ekonomis 5 jam', 20000, 'Paket ekonomis 1 jam dihitung saat pertama kali login.', '2017-01-15 14:04:15'),
('sadasdsad', 4324234, 'sdasdasdasda sdasd', '2017-07-18 13:49:32'),
('tetes', 34000, 'dsadasd', '2017-07-14 02:00:20');

-- --------------------------------------------------------

--
-- Table structure for table `nas`
--

CREATE TABLE `nas` (
  `id` int(10) NOT NULL,
  `nasname` varchar(128) NOT NULL,
  `shortname` varchar(32) DEFAULT NULL,
  `type` varchar(30) DEFAULT 'other',
  `ports` int(5) DEFAULT NULL,
  `secret` varchar(60) NOT NULL DEFAULT 'secret',
  `community` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT 'RADIUS Client'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radacct`
--

CREATE TABLE `radacct` (
  `radacctid` bigint(21) NOT NULL,
  `acctsessionid` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `acctuniqueid` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `groupname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `realm` varchar(64) COLLATE utf8_unicode_ci DEFAULT '',
  `nasipaddress` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nasportid` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nasporttype` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acctstarttime` datetime DEFAULT NULL,
  `acctstoptime` datetime DEFAULT NULL,
  `acctsessiontime` int(12) DEFAULT NULL,
  `acctauthentic` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `connectinfo_start` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `connectinfo_stop` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `acctinputoctets` bigint(20) DEFAULT NULL,
  `acctoutputoctets` bigint(20) DEFAULT NULL,
  `calledstationid` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `callingstationid` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `acctterminatecause` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `servicetype` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `framedprotocol` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `framedipaddress` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `acctstartdelay` int(12) DEFAULT NULL,
  `acctstopdelay` int(12) DEFAULT NULL,
  `xascendsessionsvrkey` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `radacct`
--

INSERT INTO `radacct` (`radacctid`, `acctsessionid`, `acctuniqueid`, `username`, `groupname`, `realm`, `nasipaddress`, `nasportid`, `nasporttype`, `acctstarttime`, `acctstoptime`, `acctsessiontime`, `acctauthentic`, `connectinfo_start`, `connectinfo_stop`, `acctinputoctets`, `acctoutputoctets`, `calledstationid`, `callingstationid`, `acctterminatecause`, `servicetype`, `framedprotocol`, `framedipaddress`, `acctstartdelay`, `acctstopdelay`, `xascendsessionsvrkey`) VALUES
(1, '8050005e', 'b508af5a236b444c', 'dalo', '', '', '192.168.137.87', '2152726622', 'Wireless-802.11', '2016-09-18 09:22:33', NULL, 359, '', '', '', 41480, 155549, 'HotspotRizal-Smd', '3C:B6:B7:15:3C:AB', '', '', '', '192.168.10.248', 0, 0, ''),
(2, '80700001', '9ccac9afe32c8d14', 'tap', '', '', '192.168.137.118', '2154823681', 'Wireless-802.11', '2016-09-23 00:11:03', NULL, 120, '', '', '', 109437, 251666, 'HotspotRizal-Smd', 'AC:9E:17:DD:44:A0', '', '', '', '192.168.10.254', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `radcheck`
--

CREATE TABLE `radcheck` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '==',
  `value` varchar(253) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `no_hp` varchar(25) COLLATE utf8_unicode_ci DEFAULT '',
  `tgl_submit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `radcheck`
--

INSERT INTO `radcheck` (`id`, `username`, `attribute`, `op`, `value`, `no_hp`, `tgl_submit`) VALUES
(105, 'Q7KMl', 'Cleartext-Password', ':=', '0fN0J', '085705392530', '2017-01-06 14:20:27'),
(101, 'Vd8Ux', 'Cleartext-Password', ':=', 'Vd8Ux', '085705392530', '2017-01-05 12:59:21'),
(102, 'OUnw5', 'Cleartext-Password', ':=', 'OUnw5', '085705392530', '2017-01-05 12:59:22'),
(103, 'Rlm7c', 'Cleartext-Password', ':=', 'Rlm7c', '085705392530', '2017-01-05 12:59:22'),
(106, 'WKNRy', 'Cleartext-Password', ':=', 'Xavji', '085705392530', '2017-01-06 14:20:27'),
(111, 'WcPmY', 'Cleartext-Password', ':=', 'ejSdt', '085705392530', '2017-01-06 14:20:27'),
(114, 'ulIUr', 'Cleartext-Password', ':=', 'amlUZ', '085705392530', '2017-01-06 14:20:27'),
(115, 'WLB9W', 'Cleartext-Password', ':=', 'fKuio', '085705392530', '2017-01-06 14:20:27'),
(117, 'OfJYm', 'Cleartext-Password', ':=', 'YVmCQ', '085705392530', '2017-01-06 14:20:27'),
(119, 'TEZdH', 'Cleartext-Password', ':=', 'YGK4p', '085705392530', '2017-01-06 14:20:27'),
(123, 'vDKj1', 'Cleartext-Password', ':=', 'aRohf', '085705392530', '2017-01-06 14:20:27'),
(124, 'TdnVb', 'Cleartext-Password', ':=', 'JkW1E', '085705392530', '2017-05-13 03:10:37'),
(125, 'uzDNQ', 'Cleartext-Password', ':=', 'rIxQD', '085705392530', '2017-05-13 03:10:37'),
(126, 'vHtJI', 'Cleartext-Password', ':=', 'DcQzb', '085705392530', '2017-05-13 03:10:37'),
(127, 'YyMGh', 'Cleartext-Password', ':=', 'Wy06D', '085705392530', '2017-05-13 03:10:37'),
(129, 'adit', 'Cleartext-Password', ':=', '123', '', '2017-05-29 08:39:41'),
(130, 'rio', 'Cleartext-Password', ':=', 'rio', '', '2017-07-13 14:32:07'),
(131, 'agata', 'Cleartext-Password', ':=', 'agata', '', '2017-07-13 14:34:08'),
(132, 'sdas', 'Cleartext-Password', ':=', 'sdas', '090923023', '2017-07-13 14:49:35'),
(133, 'Ku036', 'Cleartext-Password', ':=', 'Ku036', '', '2017-07-18 07:16:08'),
(134, 'cUcfR', 'Cleartext-Password', ':=', 'cUcfR', '', '2017-07-18 07:16:09'),
(135, 'Eo84V', 'Cleartext-Password', ':=', 'Eo84V', '', '2017-07-18 07:16:09'),
(136, '0eUYQ', 'Cleartext-Password', ':=', '0eUYQ', '', '2017-07-18 07:16:09'),
(137, 'wXugt', 'Cleartext-Password', ':=', 'wXugt', '', '2017-07-18 07:16:09'),
(138, 'kJ72C', 'Cleartext-Password', ':=', 'kJ72C', '', '2017-07-18 07:16:09'),
(139, 'nJHUE', 'Cleartext-Password', ':=', 'nJHUE', '', '2017-07-18 07:16:09'),
(140, 'YpOia', 'Cleartext-Password', ':=', 'YpOia', '', '2017-07-18 07:16:09'),
(141, 'Eowap', 'Cleartext-Password', ':=', 'Eowap', '', '2017-07-18 07:16:09'),
(142, 'g2j7w', 'Cleartext-Password', ':=', 'g2j7w', '', '2017-07-18 07:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `radgroupcheck`
--

CREATE TABLE `radgroupcheck` (
  `id` int(11) UNSIGNED NOT NULL,
  `groupname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '==',
  `value` varchar(253) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `radgroupcheck`
--

INSERT INTO `radgroupcheck` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES
(54, 'Ekonomis 2 jam', 'Idle-Timeout', ':=', '7200'),
(1, 'Disabled-Users', 'Auth-Type', ':=', 'Reject'),
(55, 'Ekonomis 2 jam', 'Simultaneous-Use', ':=', '1'),
(53, 'Ekonomis 5 jam', 'Max-All-Session', ':=', '3600'),
(52, 'Ekonomis 5 jam', 'Simultaneous-Use', ':=', '1'),
(51, 'Ekonomis 5 jam', 'Idle-Timeout', ':=', '3600'),
(56, 'Ekonomis 2 jam', 'Max-All-Session', ':=', '7200'),
(61, 'Ekonomis 3 Jam', 'Simultaneous-Use', ':=', '1'),
(60, 'Ekonomis 3 Jam', 'Idle-Timeout', ':=', '3600'),
(62, 'Ekonomis 3 Jam', 'Max-All-Session', ':=', '3200'),
(63, 'tetes', 'Idle-Timeout', ':=', '60'),
(64, 'tetes', 'Simultaneous-Use', ':=', '1'),
(65, 'tetes', 'Max-All-Session', ':=', '60'),
(66, 'tetes', 'Expiration', ':=', '13 Jul 2017'),
(67, 'sadasdsad', 'Idle-Timeout', ':=', '32423423'),
(68, 'sadasdsad', 'Simultaneous-Use', ':=', '1');

-- --------------------------------------------------------

--
-- Table structure for table `radgroupreply`
--

CREATE TABLE `radgroupreply` (
  `id` int(11) UNSIGNED NOT NULL,
  `groupname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '=',
  `value` varchar(253) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radpostauth`
--

CREATE TABLE `radpostauth` (
  `id` int(11) NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pass` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `reply` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `authdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `radpostauth`
--

INSERT INTO `radpostauth` (`id`, `username`, `pass`, `reply`, `authdate`) VALUES
(1, 'dalo', '123', 'Access-Accept', '2016-12-09 11:04:17'),
(2, 'dalo', '123', 'Access-Accept', '2016-09-18 13:14:35'),
(3, 'dalo', '123', 'Access-Accept', '2016-09-18 13:20:57'),
(4, 'dalo', '0xd1b87502aa1bd423f3a8ab3d08e594b5d8', 'Access-Accept', '2016-09-18 13:22:33'),
(5, 'tap', 'tap', 'Access-Accept', '2016-09-19 01:29:33'),
(6, 'tap', 'tap', 'Access-Accept', '2016-09-23 04:10:50'),
(7, 'tap', '0xca9b2b292ac6c3474a4517a1c2819681cc', 'Access-Accept', '2016-09-23 04:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `radreply`
--

CREATE TABLE `radreply` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '=',
  `value` varchar(253) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radusergroup`
--

CREATE TABLE `radusergroup` (
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `groupname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT '1',
  `groupname_awal` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tgl_submit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `radusergroup`
--

INSERT INTO `radusergroup` (`username`, `groupname`, `priority`, `groupname_awal`, `tgl_submit`, `tgl_dibuat`) VALUES
('Rlm7c', 'Ekonomis 5 jam', 0, 'Rlm7c', '2017-05-13 03:07:22', '2017-01-15 14:30:44'),
('OUnw5', 'Ekonomis 5 jam', 0, 'OUnw5', '2017-05-13 03:07:22', '2017-01-15 14:30:44'),
('Vd8Ux', 'Ekonomis 5 jam', 0, 'Vd8Ux', '2017-05-13 03:07:22', '2017-01-15 14:30:44'),
('Q7KMl', 'Ekonomis 2 jam', 0, 'Q7KMl', '2017-01-06 14:20:27', '2017-01-15 14:30:44'),
('rio', 'Ekonomis 2 jam', 0, 'rio', '2017-07-13 14:32:07', '2017-07-13 14:32:07'),
('WKNRy', 'Ekonomis 2 jam', 0, 'WKNRy', '2017-01-06 14:20:27', '2017-01-15 14:30:44'),
('wXugt', 'Ekonomis 2 jam', 0, 'wXugt', '2017-07-18 07:16:09', '2017-07-18 07:16:09'),
('kJ72C', 'Ekonomis 2 jam', 0, 'kJ72C', '2017-07-18 07:16:09', '2017-07-18 07:16:09'),
('0eUYQ', 'Ekonomis 2 jam', 0, '0eUYQ', '2017-07-18 07:16:09', '2017-07-18 07:16:09'),
('WcPmY', 'Ekonomis 2 jam', 0, 'WcPmY', '2017-01-06 14:20:27', '2017-01-15 14:30:44'),
('Ku036', 'Ekonomis 2 jam', 0, 'Ku036', '2017-07-18 07:16:08', '2017-07-18 07:16:08'),
('ulIUr', 'Ekonomis 2 jam', 0, 'ulIUr', '2017-01-06 14:20:27', '2017-01-15 14:30:44'),
('WLB9W', 'Ekonomis 2 jam', 0, 'WLB9W', '2017-01-06 14:20:27', '2017-01-15 14:30:44'),
('nJHUE', 'Ekonomis 2 jam', 0, 'nJHUE', '2017-07-18 07:16:09', '2017-07-18 07:16:09'),
('OfJYm', 'Ekonomis 2 jam', 0, 'OfJYm', '2017-01-06 14:20:27', '2017-01-15 14:30:44'),
('adit', 'Ekonomis 2 jam', 0, 'adit', '2017-05-29 08:39:41', '2017-05-29 08:39:41'),
('TEZdH', 'Ekonomis 2 jam', 0, 'TEZdH', '2017-01-06 14:20:27', '2017-01-15 14:30:44'),
('cUcfR', 'Ekonomis 2 jam', 0, 'cUcfR', '2017-07-18 07:16:09', '2017-07-18 07:16:09'),
('agata', 'Ekonomis 2 jam', 0, 'agata', '2017-07-13 14:34:08', '2017-07-13 14:34:08'),
('sdas', 'Ekonomis 3 Jam', 0, 'sdas', '2017-07-13 14:49:35', '2017-07-13 14:49:35'),
('vDKj1', 'Ekonomis 2 jam', 0, 'vDKj1', '2017-01-06 14:20:27', '2017-01-15 14:30:44'),
('TdnVb', 'Ekonomis 3 Jam', 0, 'TdnVb', '2017-05-13 03:10:37', '2017-05-13 03:10:37'),
('uzDNQ', 'Ekonomis 3 Jam', 0, 'uzDNQ', '2017-05-13 03:10:37', '2017-05-13 03:10:37'),
('vHtJI', 'Ekonomis 3 Jam', 0, 'vHtJI', '2017-05-13 03:10:37', '2017-05-13 03:10:37'),
('YyMGh', 'Ekonomis 3 Jam', 0, 'YyMGh', '2017-05-13 03:10:37', '2017-05-13 03:10:37'),
('Eo84V', 'Ekonomis 2 jam', 0, 'Eo84V', '2017-07-18 07:16:09', '2017-07-18 07:16:09'),
('YpOia', 'Ekonomis 2 jam', 0, 'YpOia', '2017-07-18 07:16:09', '2017-07-18 07:16:09'),
('Eowap', 'Ekonomis 2 jam', 0, 'Eowap', '2017-07-18 07:16:09', '2017-07-18 07:16:09'),
('g2j7w', 'Ekonomis 2 jam', 0, 'g2j7w', '2017-07-18 07:16:09', '2017-07-18 07:16:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harga`
--
ALTER TABLE `harga`
  ADD PRIMARY KEY (`groupname`);

--
-- Indexes for table `nas`
--
ALTER TABLE `nas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nasname` (`nasname`);

--
-- Indexes for table `radacct`
--
ALTER TABLE `radacct`
  ADD PRIMARY KEY (`radacctid`),
  ADD KEY `username` (`username`),
  ADD KEY `framedipaddress` (`framedipaddress`),
  ADD KEY `acctsessionid` (`acctsessionid`),
  ADD KEY `acctsessiontime` (`acctsessiontime`),
  ADD KEY `acctuniqueid` (`acctuniqueid`),
  ADD KEY `acctstarttime` (`acctstarttime`),
  ADD KEY `acctstoptime` (`acctstoptime`),
  ADD KEY `nasipaddress` (`nasipaddress`);

--
-- Indexes for table `radcheck`
--
ALTER TABLE `radcheck`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`(32));

--
-- Indexes for table `radgroupcheck`
--
ALTER TABLE `radgroupcheck`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupname` (`groupname`(32));

--
-- Indexes for table `radgroupreply`
--
ALTER TABLE `radgroupreply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupname` (`groupname`(32));

--
-- Indexes for table `radpostauth`
--
ALTER TABLE `radpostauth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `radreply`
--
ALTER TABLE `radreply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`(32));

--
-- Indexes for table `radusergroup`
--
ALTER TABLE `radusergroup`
  ADD KEY `username` (`username`(32));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nas`
--
ALTER TABLE `nas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `radacct`
--
ALTER TABLE `radacct`
  MODIFY `radacctid` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `radcheck`
--
ALTER TABLE `radcheck`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
--
-- AUTO_INCREMENT for table `radgroupcheck`
--
ALTER TABLE `radgroupcheck`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `radgroupreply`
--
ALTER TABLE `radgroupreply`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `radpostauth`
--
ALTER TABLE `radpostauth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `radreply`
--
ALTER TABLE `radreply`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
