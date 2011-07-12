-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) NOT NULL,
  `addressline1` varchar(100) NOT NULL,
  `addressline2` varchar(100) DEFAULT NULL,
  `town` varchar(50) NOT NULL,
  `county` varchar(50) DEFAULT NULL,
  `country` varchar(50) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `attached` tinyint(1) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `sig` varchar(255) DEFAULT NULL,
  `account_identifier` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `appsyncs`
--

CREATE TABLE IF NOT EXISTS `appsyncs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) NOT NULL,
  `datasource` varchar(255) NOT NULL,
  `data_name` varchar(255) NOT NULL,
  `data_value` varchar(255) DEFAULT NULL,
  `synced` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `primary` tinyint(1) NOT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `identities`
--

CREATE TABLE IF NOT EXISTS `identities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `name` varchar(14) DEFAULT NULL,
  `title` varchar(25) NOT NULL,
  `gender` varchar(14) NOT NULL,
  `language` varchar(8) NOT NULL,
  `timezone` varchar(25) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `tagline` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `identity_id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `managments`
--

CREATE TABLE IF NOT EXISTS `managments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `allow` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `miscs`
--

CREATE TABLE IF NOT EXISTS `miscs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) NOT NULL,
  `fieldname` varchar(100) NOT NULL,
  `fieldvalue` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `numbers`
--

CREATE TABLE IF NOT EXISTS `numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) NOT NULL,
  `number` varchar(15) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_default` int(11) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(25) DEFAULT NULL,
  `privacy` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
