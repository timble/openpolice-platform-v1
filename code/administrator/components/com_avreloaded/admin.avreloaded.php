<?php
/**
 * AllVideos Reloaded Component Entry Point
 * 
 * @version		$Id: admin.avreloaded.php 1069 2009-05-02 21:13:44Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Make sure the user is authorized to view this page
$user =& JFactory::getUser();
$app =& JFactory::getApplication();
if (!$user->authorize('com_media', 'manage')) {
    $app->redirect('index.php', JText::_('ALERTNOTAUTH'));
}

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Require specific controller if requested
if ($controller = JRequest::getVar('controller')) {
    require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

// Handle admin component menu toplevel
$view = JRequest::getVar('view', null);
if (empty($controller) && empty($view)) {
        $app->redirect('index.php?option=com_avreloaded&view=about');
}

// Create the controller
$classname = 'AvReloadedController'.$controller;
$controller = new $classname( );

// Perform the Request task
$controller->execute(JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();
