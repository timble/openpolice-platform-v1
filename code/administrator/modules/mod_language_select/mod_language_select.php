<?php
/**
 * @version		$Id: mod_language_select.php 1130 2010-06-22 16:16:27Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Module_Language_Select
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

// Check if Koowa and Nooku plugins are active
if(!(defined('KOOWA') && defined('NOOKU'))) {
    return;
}

$view = KFactory::get('admin::com.nooku.view.html');

$app		= KFactory::get('lib.joomla.application');
$db			= KFactory::get('lib.joomla.database');
$user		= KFactory::get('lib.joomla.user');
$acl		= KFactory::get('admin::com.nooku.model.permissions');

//Simple check to determine if we need to show the language selector or not
$component = KFactory::get('admin::com.nooku.model.components');
if(!$component->isTranslatable(JRequest::getCmd('option'), JRequest::getCmd('view'))) {
	return;
}

if(!$acl->canTranslate()) {
	return;
}

$langs = KFactory::get('admin::com.nooku.model.nooku')->getLanguages();
$language = $app->getUserState('application.language.content', 'en-GB');

$view->assign('langformat', 	$params->get('langformat', 'name'));
$view->assign('show_flag', 		$params->get('display_flag', 1));
$view->assign('show_name', 		$params->get('display_name', 1));
$view->assignRef('uri', 		JURI::getInstance());
$view->assign('language' , 		$language);
$view->assign('languages', 		$langs);
$view->addTemplatePath(dirname(JModuleHelper::getLayoutPath('mod_language_select', 'default')));
$view->setLayout($params->get('style', 'default'));
$view->display();