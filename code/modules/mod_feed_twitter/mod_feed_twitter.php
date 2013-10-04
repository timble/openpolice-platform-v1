<?php
/**
* @version		$Id: mod_feed.php 10396 2008-06-05 19:19:55Z willebil $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

//check if feed URL has been set
if (!$params->get('account', ''))
{
	echo '<div>';
	echo JText::_('No Twitter account specified.');
	echo '</div>';
	return;
}

require(JModuleHelper::getLayoutPath('mod_feed_twitter'));
