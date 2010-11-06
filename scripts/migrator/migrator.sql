DROP TABLE IF EXISTS `pol_session`;

CREATE VIEW `pol_session` AS
	SELECT * FROM `police_default`.`pol_session`;

UPDATE `pol_users` SET `username` = 'administrator' WHERE `username` = 'admin';

INSERT INTO `pol_components` VALUES(0, 'JCE', 'option=com_jce', 0, 0, 'option=com_jce', 'JCE', 'com_jce', 0, 'components/com_jce/img/logo.png', 0, '\npackage=1', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU CPANEL', '', 0, 34, 'option=com_jce', 'JCE MENU CPANEL', 'com_jce', 0, 'templates/khepri/images/menu/icon-16-cpanel.png', 0, '', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU CONFIG', '', 0, 34, 'option=com_jce&type=config', 'JCE MENU CONFIG', 'com_jce', 1, 'templates/khepri/images/menu/icon-16-config.png', 0, '', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU GROUPS', '', 0, 34, 'option=com_jce&type=group', 'JCE MENU GROUPS', 'com_jce', 2, 'templates/khepri/images/menu/icon-16-user.png', 0, '', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU PLUGINS', '', 0, 34, 'option=com_jce&type=plugin', 'JCE MENU PLUGINS', 'com_jce', 3, 'templates/khepri/images/menu/icon-16-plugin.png', 0, '', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU INSTALL', '', 0, 34, 'option=com_jce&type=install', 'JCE MENU INSTALL', 'com_jce', 4, 'templates/khepri/images/menu/icon-16-install.png', 0, '', 1);

INSERT INTO `pol_plugins` VALUES(0, 'Editor - JCE', 'jce', 'editors', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');

CREATE VIEW `pol_jce_groups` AS
	SELECT * FROM `police_default`.`pol_jce_groups`;

CREATE VIEW `pol_jce_plugins` AS
	SELECT * FROM `police_default`.`pol_jce_plugins`;

DROP TABLE IF EXISTS `pol_plugins`;

CREATE TABLE `pol_plugins` LIKE `police_default`.`pol_plugins`;
INSERT INTO `pol_plugins` SELECT * FROM `police_default`.`pol_plugins`;

DROP TABLE IF EXISTS `pol_joomap`;
DELETE FROM `pol_components` WHERE `option` = 'com_joomap';

DROP TABLE IF EXISTS `pol_linkr`;