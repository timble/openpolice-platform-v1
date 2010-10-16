<?php
/**
 * @version		$Id: logs.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__) . DS.'logs.html.php';
require_once($_DOCMAN->getPath('classes', 'mambots'));
 JArrayHelper::toInteger( $cid );

switch ($task) {
    case "remove":
        removeLog($cid);
        break;
    case "show" :
    default :
        showLogs($option);
}

function showLogs($option)
{
    global $sectionid;

    $database = JFactory::getDBO();
    $mainframe = JFactory::getApplication();

    // request
    $limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', 10);
    $limitstart = $mainframe->getUserStateFromRequest("view{$option}{$sectionid}limitstart", 'limitstart', 0);
    $search = $mainframe->getUserStateFromRequest("search{$option}{$sectionid}", 'search', '');
    $search = $database->getEscaped(trim(strtolower($search)));
    $wheres = array();
    $wheres2 = array();

    // get the total number of records
    $query = "SELECT count(*)"
            ."\n FROM #__docman_log";
    $database->setQuery($query);
    $total = $database->loadResult();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }

    //  WHERE clause
    //$wheres[] = "(l.log_user = u.id OR l.log_user = 0)";
    $wheres[] = "l.log_docid = d.id";
    if ($search) {
        $wheres[] = "( LOWER(l.log_ip) LIKE '%$search%'"
                    ."\n OR LOWER(l.log_datetime) LIKE '%$search%'"
                    ."\n OR LOWER(IF(l.log_user, u.name, '"._DML_ANONYMOUS."')) LIKE '%$search%'"
                    ."\n OR LOWER(d.dmname) LIKE '%$search%'"
                    ."\n OR LOWER(l.log_browser) LIKE '%$search%'"
                    ."\n OR LOWER(l.log_os) LIKE '%$search%' )";
    }
    $where = "\n WHERE " . implode(' AND ', $wheres) ;

    $wheres2[] = "l.log_docid = d.id";
    if ($search) {
        $wheres2[] = "( LOWER(l.log_ip) LIKE '%$search%'"
                    ."\n OR LOWER(l.log_datetime) LIKE '%$search%'"
                    ."\n OR LOWER('"._DML_ANONYMOUS."') LIKE '%$search%'"
                    ."\n OR LOWER(d.dmname) LIKE '%$search%'"
                    ."\n OR LOWER(l.log_browser) LIKE '%$search%'"
                    ."\n OR LOWER(l.log_os) LIKE '%$search%' )";
    }
    $where2 = "\n WHERE " . implode(' AND ', $wheres2) ;



    // Navigation
 	jimport('joomla.html.pagination');
    $pageNav = new DOCMAN_Pagination($total, $limitstart, $limit);

    // Query
    $query = "( SELECT l.*, u.name AS user, d.dmname"
            ."\n FROM #__docman_log AS l, #__users AS u, #__docman AS d "
            .$where
            ."\n AND l.log_user = u.id )"
            ."\n UNION "
            ."( SELECT l.*, '"._DML_ANONYMOUS."' AS user, d.dmname"
            ."\n FROM #__docman_log AS l, #__docman AS d "
            .$where2
            ."\n AND l.log_user = 0"
            .")"
            ."\n ORDER BY log_datetime DESC";
    $database->setQuery($query, $pageNav->limitstart, $pageNav->limit);
    $rows = $database->loadObjectList();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }

    HTML_DMLogs::showLogs($option, $rows, $search, $pageNav);
}

function removeLog($cid)
{
    DOCMAN_token::check() or die('Invalid Token');

    global $_DMUSER;

    $database = JFactory::getDBO();
    $mainframe = JFactory::getApplication();

    $log = new mosDMLog($database);
    $rows = $log->loadRows($cid); // For log mambots

    if ($log->remove($cid)) {
        if ($rows) {
            $logbot = new DOCMAN_mambot('onLogDelete');
            $logbot->setParm('user' , $_DMUSER);
            $logbot->copyParm('process' , 'delete log');
            $logbot->setParm('rows' , $rows);
            $logbot->trigger(); // Delete the logs
        }
        $mainframe->redirect("index.php?option=com_docman&section=logs");
    }
}