<?php
/**
 * @version		$Id: modules.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

//include_once dirname(__FILE__) . DS.'modules.html.php';

$moduleid  = JRequest::getInt( 'moduleid', null );
$mainframe = JFactory::getApplication();
$client = strval( JRequest::getCmd( 'client', 'admin' ) );
 JArrayHelper::toInteger( $cid );

switch ($task) {
    case 'publish':
    case 'unpublish':
        publishModule( array($moduleid), ($task == 'publish'), $option, $client );
        break;
    case 'orderup':
    case 'orderdown':
        orderModule( $moduleid, ($task == 'orderup' ? -1 : 1), $option, $client );
        break;
    default:
        $mainframe->redirect( 'index.php?option=com_docman' );
        break;
}


function publishModule( $cid=null, $publish=1, $option, $client='admin' )
{
    $database = JFactory::getDBO();
    $my       = JFactory::getUser();
    $mainframe = JFactory::getApplication();

    if (count( $cid ) < 1) {
        $action = $publish ? 'publish' : 'unpublish';
        echo "<script> alert('Select a module to $action'); window.history.go(-1);</script>\n";
        exit;
    }

     JArrayHelper::toInteger( $cid );
    $cids = 'id=' . implode( ' OR id=', $cid );

    $query = "UPDATE #__modules"
    . "\n SET published = " . (int) $publish
    . "\n WHERE ( $cids )"
    . "\n AND ( checked_out = 0 OR ( checked_out = " . (int) $my->id . " ) )"
    ;
    $database->setQuery( $query );
    if (!$database->query()) {
        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        exit();
    }

    if (count( $cid ) == 1) {
        $row = JTable::getInstance('module');
        $row->checkin( $cid[0] );
    }

    $cache =& JFactory::getCache('com_content');
	$cache->clean('com_content');

    $redirect = JRequest::getString( 'redirect', 'index.php?option='. $option .'&client='. $client );
    $mainframe->redirect( $redirect );
}

/*
 * using custom function because the core function in com_modules doesn't
 * read id from $_GET
 */
function orderModule( $uid, $inc, $option, $client='admin' )
{
    $database = JFactory::getDBO();
    $mainframe = JFactory::getApplication();

    $row =& JTable::getInstance('module');
    $row->load( (int)$uid );

    if ($client == 'admin') {
        $where = "client_id = 1";
    } else {
        $where = "client_id = 0";
    }

    $row->move( $inc, "position = " . $database->Quote( $row->position ) . " AND ( $where )"  );

     $cache =& JFactory::getCache('com_content');
	$cache->clean('com_content');

    $redirect = JRequest::getString( 'redirect', 'index.php?option='. $option .'&client='. $client );
    $mainframe->redirect( $redirect );

}