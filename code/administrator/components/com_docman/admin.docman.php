<?php
/**
 * @version		$Id: admin.docman.php 1351 2010-04-28 12:20:51Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

$acl = JFactory::getACL();
$app = JFactory::getApplication();

require_once JApplicationHelper::getPath('admin_html');
require_once JApplicationHelper::getPath('class');

global $_DOCMAN, $_DMUSER, $cid, $gid, $id, $pend, $updatedoc, $sort, $view_type, $css, $task, $option;

$_DOCMAN = new dmMainFrame();
if(JRequest::getCmd('task') != 'doclink-listview') { // bit of a hack for doclink issue
	$_DOCMAN->loadLanguage('backend');
}

$_DMUSER = $_DOCMAN->getUser();

require_once $_DOCMAN->getPath('classes', 'html');
require_once($_DOCMAN->getPath('classes', 'utils'));
require_once($_DOCMAN->getPath('classes', 'token'));


$cid = JRequest::getVar('cid', array(0), 'request', 'array');
$gid = JRequest::getInt('gid', 0);


// retrieve some expected url (or form) arguments
$pend      = JRequest::getWord('pend', 'no');
$updatedoc = JRequest::getInt('updatedoc', 0);
$sort      = JRequest::getString('sort', 0);
$view_type = JRequest::getInt('view', 1);
$task		=JRequest::getVar('task');
if( !isset($section)) {
    global $section;
    $section =  JRequest::getCmd('section', '');
}

// add stylesheet
$css = JURI::root(true).'/administrator/components/com_docman/includes/docman.css';
$mainframe = JFactory::getApplication();
$mainframe->addCustomHeadTag( '<link rel="stylesheet" type="text/css" media="all" href="'.$css.'" id="docman_stylesheet" />' );

// Little hack to make sure mosmsg is always displayed:
if( !isset( $_SERVER['HTTP_REFERER'] )) {
	$_SERVER['HTTP_REFERER'] = JURI::root(true) . '/administrator/index.php?option=com_docman';
}

// execute task
if (($task == 'cpanel') || ($section == null)){
   include_once($_DOCMAN -> getPath('includes', 'docman'));
}else{
    include_once($_DOCMAN -> getPath('includes', $section));
}

