<?php
/**
 * @version		$Id: mod_language_select.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Site
 * @subpackage  Module_Language_Select
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Check if Koowa and Nooku plugins are active
if(!(defined('KOOWA') && defined('NOOKU'))) {
    return;
}

KViewHelper::addIncludePath(dirname(__FILE__).DS.'helpers');

$app	 = KFactory::get('lib.joomla.application');
$uri	 = JURI::getInstance();
$model	 = KFactory::get('site::com.nooku.model.languages');
$nooku   = KFactory::get('admin::com.nooku.model.nooku');

// Parameters
$langformat		= $params->get('langformat', 'name');
$style 			= $params->get('style', 'default');
$display_flag	= $params->get('display_flag', 'both');

// Get data
$langs 			= $model->getList();

// Get the view
$view = KFactory::get('site::com.nooku.view.html');
$view->addTemplatePath(dirname(JModuleHelper::getLayoutPath('mod_language_select', $style)));

// Assign vars
$view->assign('langformat', 		$langformat);
$view->assign('display_flag', 		$display_flag);
$view->assignRef('uri', 			$uri);
$view->assignRef('current_lang' , 	$langs->findRow('iso_code', $nooku->getLanguage()));
$view->assignRef('languages', 		$langs);
$view->setLayout($style);
$view->display();
