<?php
/**
* @version		$Id: router.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla.Framework
* @subpackage	Application
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Class to create and parse routes
 *
 * @package 	Joomla
 * @since		1.5
 */
class JRouterAdministrator extends JRouter
{
	/**
	 * Function to convert a route to an internal URI
	 *
	 * @access public
	 */
	function parse($uri)
	{
		return array();
	}

	/**
	 * Function to convert an internal URI to a route
	 *
	 * @param	string	$string	The internal URL
	 * @return	string	The absolute search engine friendly URL
	 * @since	1.5
	 */
	function &build($url)
	{
		//Create the URI object
		$uri  = parent::_createURI($url);
		
		$site = JFactory::getApplication()->getSite();
		$path = $uri->getPath();
		
		if(JFactory::getApplication()->getCfg('sef_rewrite')) {
			$path = str_replace('index.php', '', $path);
		}
		
		//Exception for the default site
		if($site != 'default') {
			$uri->setPath(empty($path) ? $site : $path.'/'.$site);
		} else {
			$uri->setPath($path);
		}
		
		return $uri;
	}
}