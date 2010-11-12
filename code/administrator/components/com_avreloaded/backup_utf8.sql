-- $Id: backup_utf8.sql 1059 2008-07-23 00:55:23Z Fritz Elfert $
--
DROP TABLE IF EXISTS `#__avrbak_avr_player`;
CREATE TABLE IF NOT EXISTS `#__avr_player` (
  `id` int(11) NOT NULL auto_increment,
  `version` int(11) NOT NULL DEFAULT 0,
  `minw` int(11) NOT NULL DEFAULT 0,
  `minh` int(11) NOT NULL DEFAULT 0,
  `isjw` int(1) NOT NULL DEFAULT '0',
  `name` varchar(25) NOT NULL,
  `code` mediumtext NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 CHARACTER SET `utf8`;
RENAME TABLE `#__avr_player` TO `#__avrbak_avr_player`;

DROP TABLE IF EXISTS `#__avrbak_avr_ripper`;
CREATE TABLE IF NOT EXISTS `#__avr_ripper` (
  `id` int(11) NOT NULL auto_increment,
  `version` int(11) NOT NULL DEFAULT 0,
  `flags` int(11) NOT NULL DEFAULT '0',
  `cindex` int(11) NOT NULL DEFAULT '0',
  `name` varchar(25) NOT NULL,
  `url` varchar(255) NOT NULL,
  `regex` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 CHARACTER SET `utf8`;
RENAME TABLE `#__avr_ripper` TO `#__avrbak_avr_ripper`;

DROP TABLE IF EXISTS `#__avrbak_avr_tags`;
CREATE TABLE IF NOT EXISTS `#__avr_tags` (
  `id` int(11) NOT NULL auto_increment,
  `version` int(11) NOT NULL DEFAULT 0,
  `player_id` int(11) NOT NULL,
  `ripper_id` int(11) NOT NULL default '0',
  `local` int(1) NOT NULL default '0',
  `plist` int(1) NOT NULL default '0',
  `name` varchar(25) NOT NULL,
  `postreplace` varchar(255) NOT NULL default '',
  `sampleregex` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `tag` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=83 CHARACTER SET `utf8`;
RENAME TABLE `#__avr_tags` TO `#__avrbak_avr_tags`;

-- Temporary for Transition from Version 1.2.3 -> 1.2.4
DROP TABLE IF EXISTS `#__avr_popup`;
