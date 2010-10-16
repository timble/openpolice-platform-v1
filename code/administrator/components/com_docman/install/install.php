<?php
/**
 * @version		$Id: install.php 1049 2009-12-14 17:05:40Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');

function com_install() 
{	
	// Joomla's archive handler eats a lot of memory
	if((int) ini_get('memory_limit') < 24) {
		@ini_set('memory_limit', '24M');
	}
	
	$lang = JFactory::getLanguage();
	$lang->load('com_installer');
	
	$tasks = array('logo', 'copyFiles', 'insertInDb', 
		'removeAdminMenuImages', 'setAdminMenuImages', 'cpanel' );
	$status = & DMStatus::getInstance();
	
	while($status->get() && $task = array_shift($tasks))
	{
		call_user_func(array('DMInstallHelper', $task));
	}

	
	echo '<ul>';
	foreach($status->getMsgs() as $msg) {
		echo '<li>'.$msg.'</li>';
	}
	echo '</ul>'; 
	return $status->get();
	
}
