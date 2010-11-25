<?php
/*
# SQL table schema:

CREATE TABLE IF NOT EXISTS `pol_users_logs` (
	`users_log_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`created_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`username` VARCHAR(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	`status` ENUM('success', 'fail') NOT NULL,
	`site` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	PRIMARY KEY (`users_log_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE utf8_general_ci;
*/

jimport('joomla.plugin.plugin');

class plgSystemLog extends JPlugin
{
	public function onLoginUser($user, $options)
	{
		$database	= JFactory::getDBO();
		$site		= JFactory::getApplication()->getSite();

		$query = 'INSERT INTO `#__users_logs` (`created_on`, `username`, `status`, `site`) VALUES (\''.gmdate('Y-m-d H:i:s').'\', \''.$user['username'].'\', \'success\', \''.$site.'\');';
		$database->setQuery($query);
		$database->query();
	}

	public function onLoginFailure($user)
	{
		$database	= JFactory::getDBO();
		$site		= JFactory::getApplication()->getSite();

		$query = 'INSERT INTO `#__users_logs` (`created_on`, `username`, `status`, `site`) VALUES (\''.gmdate('Y-m-d H:i:s').'\', \''.$user['username'].'\', \'fail\', \''.$site.'\');';
		$database->setQuery($query);
		$database->query();
	}
}