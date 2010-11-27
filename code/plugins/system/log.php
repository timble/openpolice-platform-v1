<?php
/*
# SQL table schema:

CREATE TABLE IF NOT EXISTS `pol_users_logs` (
	`users_log_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`created_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`username` VARCHAR(75) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	`status` ENUM('success', 'fail') NOT NULL,
	`site` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	`ip` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	`referrer` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	`user_agent` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	PRIMARY KEY (`users_log_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE utf8_general_ci;
*/

jimport('joomla.plugin.plugin');

class plgSystemLog extends JPlugin
{
	public function onLoginUser($user, $options)
	{
		$this->_log($user['username'], 'success');
	}

	public function onLoginFailure($user)
	{
		$this->_log($user['username'], 'fail');
	}

	protected function _log($username, $status)
	{
		$database	= JFactory::getDBO();
		$data		= array(
			'created_on'	=> gmdate('Y-m-d H:i:s'),
			'username'		=> $user['username'],
			'status'		=> $username,
			'site'			=> JFactory::getApplication()->getSite(),
			'ip'			=> $_SERVER['REMOTE_ADDR'],
			'referrer'		=> $_SERVER['HTTP_REFERER'],
			'user_agent'	=> $_SERVER['HTTP_USER_AGENT']
		);

		$query = 'INSERT INTO `police_default`.`#__users_logs` (`'.implode('`, `', array_keys($data)).'`) VALUES (\''.implode('\', \'', array_values($data)).'\');';
		$database->setQuery($query);
		$database->query();
	}
}