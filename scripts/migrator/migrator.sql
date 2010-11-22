# Create a view for pol_session.

DROP TABLE IF EXISTS `pol_session`;

CREATE VIEW `pol_session` AS
	SELECT * FROM `police_default`.`pol_session`;


# Demote super administrators to administrator.

UPDATE `pol_core_acl_groups_aro_map` SET `group_id` = 24
	WHERE `group_id` = 25 AND `aro_id` <> (
		SELECT `aro`.`id` FROM `pol_core_acl_aro` AS `aro`
		LEFT JOIN `pol_users` AS `user` ON `aro`.`value` = `user`.`id`
		WHERE `user`.`username` = 'admin');

UPDATE `pol_users` SET `usertype` = 'Administrator', `gid` = 24
	WHERE `gid` = 25 AND `username` <> 'admin';


# Rename admin user to administrator.

UPDATE `pol_users` SET `username` = 'sheriff' WHERE `username` = 'admin';


# Install JCE editor.

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


# Updated front-end template name.

UPDATE `pol_templates_menu` SET `template` = 'site' WHERE `template` = 'rhuk_milkyway_police';