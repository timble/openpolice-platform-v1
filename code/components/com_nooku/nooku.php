<?php
/**
 * @version		$Id: nooku.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Site
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Check if Koowa is active
if(!defined('KOOWA')) {
    JError::raiseWarning(0, JText::_("Koowa wasn't found. Please install the Koowa plugin and enable it."));
    return;
}

// Check if Nooku is active
if(!defined('NOOKU')) {
    JError::raiseWarning(0, JText::_("The Nooku plugin isn't enabled."));
    return;
}

// Require the defines
Koowa::import('site::com.nooku.defines');
Koowa::import('site::com.nooku.loader');

// Options for the dispatcher
$options = array('default_view' => 'translate');

// Map views to dispatchers
$map = array(
	'translate' 	=> 'admin::com.nooku.dispatcher',
	'translate.source' 	=> 'admin::com.nooku.dispatcher',
	'redirect' 		=> 'site::com.nooku.dispatcher',
	'default'		=> 'site::com.nooku.dispatcher'
);

// Create the component dispatcher
$view 		= KInput::get('view', 'get', 'cmd');
$name 		= array_key_exists($view, $map) ? $map[$view] : $map['default'];
KFactory::get($name)->dispatch($options);