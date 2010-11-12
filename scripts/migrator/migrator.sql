# Create a view for pol_session.

DROP TABLE IF EXISTS `pol_session`;

CREATE VIEW `pol_session` AS
	SELECT * FROM `police_default`.`pol_session`;


# Rename admin user to administrator.

UPDATE `pol_users` SET `username` = 'administrator' WHERE `username` = 'admin';


# Install JCE editor.

INSERT INTO `pol_components` VALUES(0, 'JCE', 'option=com_jce', 0, 0, 'option=com_jce', 'JCE', 'com_jce', 0, 'components/com_jce/img/logo.png', 0, '\npackage=1', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU CPANEL', '', 0, 34, 'option=com_jce', 'JCE MENU CPANEL', 'com_jce', 0, 'templates/khepri/images/menu/icon-16-cpanel.png', 0, '', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU CONFIG', '', 0, 34, 'option=com_jce&type=config', 'JCE MENU CONFIG', 'com_jce', 1, 'templates/khepri/images/menu/icon-16-config.png', 0, '', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU GROUPS', '', 0, 34, 'option=com_jce&type=group', 'JCE MENU GROUPS', 'com_jce', 2, 'templates/khepri/images/menu/icon-16-user.png', 0, '', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU PLUGINS', '', 0, 34, 'option=com_jce&type=plugin', 'JCE MENU PLUGINS', 'com_jce', 3, 'templates/khepri/images/menu/icon-16-plugin.png', 0, '', 1);
INSERT INTO `pol_components` VALUES(0, 'JCE MENU INSTALL', '', 0, 34, 'option=com_jce&type=install', 'JCE MENU INSTALL', 'com_jce', 4, 'templates/khepri/images/menu/icon-16-install.png', 0, '', 1);

INSERT INTO `pol_plugins` VALUES(0, 'Editor - JCE', 'jce', 'editors', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');

DROP TABLE IF EXISTS `pol_jce_groups`;
CREATE OR REPLACE VIEW `pol_jce_groups` AS
	SELECT * FROM `police_default`.`pol_jce_groups`;

DROP TABLE IF EXISTS `pol_jce_plugins`;
CREATE OR REPLACE VIEW `pol_jce_plugins` AS
	SELECT * FROM `police_default`.`pol_jce_plugins`;


# Copy plugins table from police_default.

DROP TABLE IF EXISTS `pol_plugins`;

CREATE TABLE `pol_plugins` LIKE `police_default`.`pol_plugins`;
INSERT INTO `pol_plugins` SELECT * FROM `police_default`.`pol_plugins`;


# Delete Joomap component.

DROP TABLE IF EXISTS `pol_joomap`;
DELETE FROM `pol_components` WHERE `option` = 'com_joomap';
DELETE FROM `pol_menu` WHERE LOCATE('option=com_joomap', `link`) <> 0;


# Delete Linkr component.
DROP TABLE IF EXISTS `pol_linkr`;


# Install AvReloaded component and plugin.

DELETE FROM `pol_components` WHERE `option` = 'com_avreloaded';

INSERT INTO `pol_components` VALUES(0, 'AvReloaded', '', 0, 0, '', 'AvReloaded', 'com_avreloaded', 0, '', 0, '', 0);
INSERT INTO `pol_components` VALUES(0, 'AVR_TITLE_MANAGE_PLAYERS', '', 0, 40, 'option=com_avreloaded&view=players', 'AVR_TITLE_MANAGE_PLAYERS', 'com_avreloaded', 0, 'components/com_avreloaded/assets/avreloaded-16x16.png', 0, '', 0);
INSERT INTO `pol_components` VALUES(0, 'AVR_TITLE_MANAGE_RIPPERS', '', 0, 40, 'option=com_avreloaded&view=rippers', 'AVR_TITLE_MANAGE_RIPPERS', 'com_avreloaded', 1, 'components/com_avreloaded/assets/avreloaded-16x16.png', 0, '', 0);
INSERT INTO `pol_components` VALUES(0, 'AVR_TITLE_MANAGE_TAGS', '', 0, 40, 'option=com_avreloaded&view=tags', 'AVR_TITLE_MANAGE_TAGS', 'com_avreloaded', 2, 'components/com_avreloaded/assets/avreloaded-16x16.png', 0, '', 0);
INSERT INTO `pol_components` VALUES(0, 'AVR_TITLE_MANAGE_PLAYLISTS', '', 0, 40, 'option=com_avreloaded&view=playlists', 'AVR_TITLE_MANAGE_PLAYLISTS', 'com_avreloaded', 3, 'components/com_avreloaded/assets/avreloaded-16x16.png', 0, '', 0);

DROP TABLE IF EXISTS `pol_avr_player`;
CREATE OR REPLACE VIEW `pol_avr_player` AS
	SELECT * FROM `police_default`.`pol_avr_player`;

DROP TABLE IF EXISTS `pol_avr_popup`;
CREATE OR REPLACE VIEW `pol_avr_popup` AS
	SELECT * FROM `police_default`.`pol_avr_popup`;

DROP TABLE IF EXISTS `pol_avr_ripper`;
CREATE OR REPLACE VIEW `pol_avr_ripper` AS
	SELECT * FROM `police_default`.`pol_avr_ripper`;

DROP TABLE IF EXISTS `pol_avr_tags`;
CREATE OR REPLACE VIEW `pol_avr_tags` AS
	SELECT * FROM `police_default`.`pol_avr_tags`;