<?php
/**
 * @version		$Id: cleardata.php 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__) . DS.'cleardata.html.php';
require_once($_DOCMAN->getPath('classes', 'cleardata'));

switch ($task) 
{
    case 'remove':
        clearData( $cid );
        break;

    default:
    case 'show':
        showClearData();
}

function clearData( $cid = array() )
{
    DOCMAN_token::check('request') or die('Invalid Token');
    
    $mainframe = JFactory::getApplication();

    $msgs=array();

    $cleardata = new DOCMAN_Cleardata( $cid );
    $cleardata->clear();
    $rows = & $cleardata->getList();
    foreach( $rows as $row ){
        $msgs[] = $row->msg;
    }
    $mainframe->redirect( 'index.php?option=com_docman&section=cleardata', implode(' | ', $msgs));
}

function showClearData()
{
    $cleardata = new DOCMAN_Cleardata();
    $rows = & $cleardata->getList();
	HTML_DMClear::showClearData( $rows );
}
