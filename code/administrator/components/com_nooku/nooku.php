<?php
/**
 * @version		$Id: nooku.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
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
Koowa::import('admin::com.nooku.defines');
Koowa::import('admin::com.nooku.loader');

// Check if this is the first run
include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_nooku'.DS.'configs'.DS.'first_run.php';
if($first_run) {
	KInput::set('view', 'installation', 'get');
	KInput::set('task', 'finish', 'get');
}

// Create the component dispatcher
$dispatcher = KFactory::get('admin::com.nooku.dispatcher');
$dispatcher->dispatch(
	array('default_view' => 'dashboard')
);