DROP TABLE `pol_session`;

CREATE VIEW `pol_session` AS
	SELECT * FROM `police_default`.`pol_session`;

UPDATE `pol_users` SET `username` = 'administrator' WHERE `username` = 'admin';