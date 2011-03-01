CREATE TABLE `pol_docman` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '1',
  `dmname` text NOT NULL,
  `dmdescription` longtext,
  `dmdate_published` datetime NOT NULL default '0000-00-00 00:00:00',
  `dmowner` int(4) NOT NULL default '-1',
  `dmfilename` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `dmurl` text,
  `dmcounter` int(11) default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `approved` tinyint(1) NOT NULL default '0',
  `dmthumbnail` text,
  `dmlastupdateon` datetime default '0000-00-00 00:00:00',
  `dmlastupdateby` int(5) NOT NULL default '-1',
  `dmsubmitedby` int(5) NOT NULL default '-1',
  `dmmantainedby` int(5) default '0',
  `dmlicense_id` int(5) default '0',
  `dmlicense_display` tinyint(1) NOT NULL default '0',
  `access` int(11) unsigned NOT NULL default '0',
  `attribs` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pub_appr_own_cat_name` (`published`,`approved`,`dmowner`,`catid`,`dmname`(64)),
  KEY `appr_pub_own_cat_date` (`approved`,`published`,`dmowner`,`catid`,`dmdate_published`),
  KEY `own_pub_appr_cat_count` (`dmowner`,`published`,`approved`,`catid`,`dmcounter`),
  KEY `own_pub_appr_cat_id` (`dmowner`,`published`,`approved`,`catid`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_docman_groups` (
  `groups_id` int(11) NOT NULL auto_increment,
  `groups_name` text NOT NULL,
  `groups_description` longtext,
  `groups_access` tinyint(4) NOT NULL default '1',
  `groups_members` text,
  PRIMARY KEY  (`groups_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_docman_history` (
  `id` int(11) NOT NULL auto_increment,
  `doc_id` int(11) NOT NULL,
  `revision` int(5) NOT NULL default '1',
  `his_date` datetime NOT NULL,
  `his_who` int(11) NOT NULL,
  `his_obs` longtext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_docman_licenses` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `license` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pol_docman_log` (
  `id` int(11) NOT NULL auto_increment,
  `log_docid` int(11) NOT NULL,
  `log_ip` text NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_user` int(11) NOT NULL default '0',
  `log_browser` text,
  `log_os` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `pol_components` (`id`,`name`,`link`,`menuid`,`parent`,`admin_menu_link`,`admin_menu_alt`,`option`,`ordering`,`admin_menu_img`,`iscore`,`params`,`enabled`)
VALUES
	(0, 'DOCman', 'option=com_docman', 0, 0, 'option=com_docman', 'DOCman', 'com_docman', 0, 'components/com_docman/images/dm_logo_16.png', 0, '', 1);

SET @component_id = LAST_INSERT_ID();

INSERT INTO `pol_components` (`id`,`name`,`link`,`menuid`,`parent`,`admin_menu_link`,`admin_menu_alt`,`option`,`ordering`,`admin_menu_img`,`iscore`,`params`,`enabled`)
VALUES
	(0, 'Home', '', 0, @component_id, 'option=com_docman&task=cpanel', 'Home', 'com_docman', 0, 'components/com_docman/images/dm_cpanel_16.png', 0, '', 1),
	(0, 'Files', '', 0, @component_id, 'option=com_docman&section=files', 'Files', 'com_docman', 1, 'components/com_docman/images/dm_files_16.png', 0, '', 1),
	(0, 'Documents', '', 0, @component_id, 'option=com_docman&section=documents', 'Documents', 'com_docman', 2, 'components/com_docman/images/dm_documents_16.png', 0, '', 1),
	(0, 'Categories', '', 0, @component_id, 'option=com_docman&section=categories', 'Categories', 'com_docman', 3, 'components/com_docman/images/dm_categories_16.png', 0, '', 1),
	(0, 'Groups', '', 0, @component_id, 'option=com_docman&section=groups', 'Groups', 'com_docman', 4, 'components/com_docman/images/dm_groups_16.png', 0, '', 1),
	(0, 'Licenses', '', 0, @component_id, 'option=com_docman&section=licenses', 'Licenses', 'com_docman', 5, 'components/com_docman/images/dm_licenses_16.png', 0, '', 1),
	(0, 'Statistics', '', 0, @component_id, 'option=com_docman&task=stats', 'Statistics', 'com_docman', 6, 'components/com_docman/images/dm_stats_16.png', 0, '', 1),
	(0, 'Download Logs', '', 0, @component_id, 'option=com_docman&section=logs', 'Download Logs', 'com_docman', 7, 'components/com_docman/images/dm_logs_16.png', 0, '', 1),
	(0, 'Configuration', '', 0, @component_id, 'option=com_docman&section=config', 'Configuration', 'com_docman', 8, 'components/com_docman/images/dm_config_16.png', 0, '', 1),
	(0, 'Themes', '', 0, @component_id, 'option=com_docman&section=themes', 'Themes', 'com_docman', 9, 'components/com_docman/images/dm_templates_16.png', 0, '', 1);

UPDATE `pol_plugins` SET `published` = 1 WHERE `element` = 'standardbuttons' AND `folder` = 'docman';
UPDATE `pol_plugins` SET `published` = 1 WHERE `element` = 'docman.searchbot' AND `folder` = 'search';
UPDATE `pol_plugins` SET `published` = 1 WHERE `element` = 'doclink' AND `folder` = 'editors-xtd';