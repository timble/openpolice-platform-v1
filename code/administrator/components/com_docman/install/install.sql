

CREATE TABLE IF NOT EXISTS `#__docman` (
      `id` int(11) NOT NULL auto_increment,
      `catid` int(11) NOT NULL default 1,
      `dmname` text NOT NULL, `dmdescription` longtext,
      `dmdate_published` datetime NOT NULL default '0000-00-00 00:00:00',
      `dmowner` int(4) NOT NULL default -1,
      `dmfilename` text NOT NULL,
      `published` tinyint(1) NOT NULL default 0,
      `dmurl` text NULL,
      `dmcounter` int(11) NULL default 0,
      `checked_out` int(11) NOT NULL default 0,
      `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
      `approved` tinyint(1) NOT NULL default 0,
      `dmthumbnail` text NULL,
      `dmlastupdateon` datetime default '0000-00-00 00:00:00',
      `dmlastupdateby` int(5) NOT NULL default -1,
      `dmsubmitedby` int(5) NOT NULL default -1,
      `dmmantainedby` int(5) default 0,
      `dmlicense_id` int(5) default 0,
      `dmlicense_display` tinyint(1) NOT NULL default 0,
      `access` int(11) unsigned NOT NULL default 0,
      `attribs` text NOT NULL,
      PRIMARY KEY (`id`),
	  KEY `pub_appr_own_cat_name` (`published`,`approved`,`dmowner`,`catid`,`dmname`(64)),
	  KEY `appr_pub_own_cat_date` (`approved`,`published`,`dmowner`,`catid`,`dmdate_published`),
	  KEY `own_pub_appr_cat_count`(`dmowner`,`published`,`approved`,`catid`,`dmcounter`),
	  KEY `own_pub_appr_cat_id`   (`dmowner`, `published`, `approved`, `catid`, `id`)
 ) TYPE=MyISAM;
 
CREATE TABLE IF NOT EXISTS `#__docman_groups` (
      `groups_id` int(11) NOT NULL auto_increment,
      `groups_name` text NOT NULL,
      `groups_description` longtext,
      `groups_access` tinyint(4) NOT NULL default 1,
      `groups_members` text NULL,
       PRIMARY KEY (`groups_id`) 
) TYPE=MyISAM;


CREATE TABLE IF NOT EXISTS `#__docman_history` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `doc_id` INT NOT NULL ,
      `revision` INT( 5 ) DEFAULT 1 NOT NULL,
      `his_date` DATETIME NOT NULL ,
      `his_who` INT NOT NULL ,
      `his_obs` LONGTEXT, PRIMARY KEY (`id`) 
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__docman_licenses` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `name` text NOT NULL ,
      `license` text NOT NULL, PRIMARY KEY (`id`) 
) TYPE=MyISAM;


CREATE TABLE IF NOT EXISTS `#__docman_log` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `log_docid` INT NOT NULL ,
      `log_ip` text NOT NULL,
      `log_datetime` DATETIME NOT NULL,
      `log_user` INT NOT NULL DEFAULT 0,
      `log_browser` text, `log_os` text,
      PRIMARY KEY (`id`) 
) TYPE=MyISAM;

INSERT INTO `#__modules`
      SET title='Latest docs', ordering=2, position='dmcpanel', published=1, module='mod_docman_latest', access=2, showtitle=1, iscore=2, client_id=1;
INSERT INTO `#__modules`
      SET title='Top docs', ordering=3, position='dmcpanel', published=1, module='mod_docman_top', access=2, showtitle=1, iscore=2, client_id=1;
INSERT INTO `#__modules`
	  SET title='Latest logs', ordering=4, position='dmcpanel', published=1, module='mod_docman_logs', access=2, showtitle=1, iscore=2, client_id=1;
INSERT INTO `#__modules`
	  SET title='News', ordering=0, position='dmcpanel', published=1, module='mod_docman_news', access=2, showtitle=1, iscore=2, client_id=1;
INSERT INTO `#__modules`
	  SET title='Unapproved', ordering=1, position='dmcpanel', published=1, module='mod_docman_approval', access=2, showtitle=1, iscore=2, client_id=1;
