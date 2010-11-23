<?php
/*
# SQL table schema:

CREATE TABLE IF NOT EXISTS `pol_users_logs` (
	`users_log_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`created_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`username` VARCHAR(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	`status` ENUM('success', 'fail') NOT NULL,
	PRIMARY KEY (`users_log_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE utf8_general_ci;

# Installation:

INSERT INTO `pol_plugins` VALUES(0, 'User - Log', 'log', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
*/

jimport('joomla.plugin.plugin');

class plgUserLog extends JPlugin
{
	public function onLoginUser($user, $options)
	{
		$database = JFactory::getDBO();

		$query = 'INSERT INTO `#__users_logs` (`created_on`, `username`, `status`) VALUES (\''.gmdate('Y-m-d H:i:s').'\', \''.$user['username'].'\', \'success\');';
		$database->setQuery($query);
		$database->query();
	}

	public function onLoginFailure($user)
	{
		$database = JFactory::getDBO();

		$query = 'INSERT INTO `#__users_logs` (`created_on`, `username`, `status`) VALUES (\''.gmdate('Y-m-d H:i:s').'\', \''.$user['username'].'\', \'fail\');';
		$database->setQuery($query);
		$database->query();
	}
}