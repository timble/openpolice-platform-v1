<?php
/**
* @version		$Id: framework.php 19058 2010-10-08 04:15:39Z dextercowley $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

@set_magic_quotes_runtime( 0 );
@ini_set('zend.ze1_compatibility_mode', '0');

// System includes
require_once( JPATH_LIBRARIES.DS.'joomla'.DS.'import.php');

// Joomla! library imports
jimport( 'joomla.application.menu' );
jimport( 'joomla.user.user');
jimport( 'joomla.environment.uri' );
jimport( 'joomla.html.html' );
jimport( 'joomla.html.parameter' );
jimport( 'joomla.utilities.utility' );
jimport( 'joomla.event.event');
jimport( 'joomla.event.dispatcher');
jimport( 'joomla.language.language');
jimport( 'joomla.utilities.string' );