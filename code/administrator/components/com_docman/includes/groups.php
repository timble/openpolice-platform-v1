<?php
/**
 * @version		$Id: groups.php 1348 2010-04-27 15:26:15Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__) .DS.'groups.html.php';
 JArrayHelper::toInteger( $cid );

switch ($task) {
    case "new":
        editGroup($option, 0);
        break;
    case "edit":
        editGroup($option, $cid[0]);
        break;
    case "remove":
        removeGroup($cid);
        break;
    case "apply":
    case "saveg":
    case "save":
        saveGroup($option);
        break;
    case "cancel":
        cancelGroup($option);
        break;
    case "emailgroup":
        emailGroup($gid);
        break;
    case "sendemail":
        sendEmail($gid);
        break;
    case "show" :
    default :
        showGroups($option);
}

function editGroup($option, $uid)
{
    $database = JFactory::getDBO();

    // disable the main menu to force user to use buttons
    $_REQUEST['hidemainmenu']=1;

    $row = new mosDMGroups($database);
    $row->load($uid);

    $musers = array();
    $toAddUsers = array();
    // get selected members
    if ($row->groups_members) {
        $database->setQuery("SELECT id,name,username, block "
                . "\n FROM #__users "
                . "\n WHERE id IN (" . $row->groups_members . ")"
                . "\n ORDER BY block ASC, name ASC"
            );
        $usersInGroup = $database->loadObjectList();

        foreach($usersInGroup as $user) {
            $musers[] = JHTML::_('select.option',$user->id,
                    $user->id . "-" . $user->name . " (" . $user->username . ")"
                    . ($user->block ? ' - ['._DML_USER_BLOCKED.']':'')
                    );
        }

    }
    // get non selected members
    $query = "SELECT id,name,username, block FROM #__users ";
    if ($row->groups_members) {
        $query .= "\n WHERE id NOT IN (" . $row->groups_members . ")" ;
    }
    $query .= "\n ORDER BY block ASC, name ASC";
    $database->setQuery($query);
    $usersToAdd = $database->loadObjectList();
    foreach($usersToAdd as $user) {
        $toAddUsers[] = JHTML::_('select.option',$user->id,
                        $user->id . "-" . $user->name . " (" . $user->username . ")"
                        . ($user->block ? ' - ['._DML_USER_BLOCKED.']':'')
                        );
    }

    $usersList = JHTML::_('select.genericlist',$musers, 'users_selected[]',
        'class="inputbox" size="20" onDblClick="moveOptions(document.adminForm[\'users_selected[]\'], document.adminForm.users_not_selected)" multiple="multiple"', 'value', 'text', null);
    $toAddUsersList = JHTML::_('select.genericlist',$toAddUsers,
        'users_not_selected', 'class="inputbox" size="20" onDblClick="moveOptions(document.adminForm.users_not_selected, document.adminForm[\'users_selected[]\'])" multiple="multiple"',
        'value', 'text', null);

    HTML_DMGroups::editGroup($option, $row, $usersList, $toAddUsersList);
}

function saveGroup($option)
{
    DOCMAN_token::check() or die('Invalid Token');

    global $task;

    $database = JFactory::getDBO();
    $mainframe = JFactory::getApplication();

    $row = new mosDMGroups($database);

    if (!$row->bind(DOCMAN_Utils::stripslashes($_POST))) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }
    if (!$row->check()) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }
    if (!$row->store()) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }
    $row->checkin();
    $members = JRequest::getVar('users_selected', array(), 'post', 'array');
    $members_imploded = implode(',', $members);

    $database->setQuery("UPDATE #__docman_groups SET groups_members='" . $members_imploded . "' WHERE groups_id=". (int) $row->groups_id);
    $database->query();

    if( $task == 'save' OR $task == 'saveg' ) {
        $url = 'index.php?option=com_docman&section=groups&task=show';
    } else { // $task = 'apply'
        $url = 'index.php?option=com_docman&section=groups&task=edit&cid[0]='.$row->groups_id;
    }

    $mainframe->redirect( $url, _DML_SAVED_CHANGES);
}

function showGroups($option)
{
    $database = JFactory::getDBO();

    $search = trim(strtolower(JRequest::getString('search', '', 'post')));
    $limit = intval(JRequest::getInt('limit', 10, 'post'));
    $limitstart = intval(JRequest::getInt('limitstart', 0, 'post'));
    $where = array();
    if ($search) {
        $where[] = "LOWER(groups_name) LIKE '%$search%'";
    }
    // get the total number of records
    $database->setQuery("SELECT count(*) FROM #__docman_groups" . (count($where) ? "\nWHERE " . implode(' AND ', $where) : ""));
    $total = $database->loadResult();

    echo $database->getErrorMsg();

    if ($limit > $total) {
        $limitstart = 0;
    }

    $pageNav = new DOCMAN_Pagination($total, $limitstart, $limit);

    $query = "SELECT *"
            ."\n FROM #__docman_groups"
            .(count($where) ? "\n WHERE " . implode(' AND ', $where) : "")
            ."\n ORDER BY groups_name";
    $database->setQuery($query, $pageNav->limitstart, $pageNav->limit);
    $rows = $database->loadObjectList();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }



    HTML_DMGroups::showGroups($option, $rows, $search, $pageNav);
}

function removeGroup($cid)
{
    DOCMAN_token::check() or die('Invalid Token');

	$mainframe = JFactory::getApplication();
    $database = JFactory::getDBO();
    if (!is_array($cid) || count($cid) < 1) {
        echo "<script> alert('" . _DML_SELECT_ITEM_DEL . "'); window.history.go(-1);</script>\n";
        exit;
    }
    if (count($cid)) {
        $cids = implode(',', $cid);
        // lets see if some document is owned by this group and not allow to delete it
        for ($g = 0;$g < count($cid);$g++) {
            $ttt = $cid[$g];
            $ttt = ($ttt-2 * $ttt) -10;
            $query = "SELECT id FROM #__docman WHERE dmowner=" . $ttt;
            $database->setQuery($query);
            if (!($result = $database->query())) {
                echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
            }
            if ($database->getNumRows($result) != 0) {
                $mainframe->redirect("index.php?option=com_docman&section=groups", _DML_CANNOT_DEL_GROUP);
            }
        }
        $database->setQuery("DELETE FROM #__docman_groups WHERE groups_id IN ($cids)");
        if (!$database->query()) {
            echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        }
    }
    $mainframe->redirect("index.php?option=com_docman&section=groups");
}

function emailGroup($gid)
{
    $sitename = JFactory::getApplication()->getCfg('sitename');
    $group = DOCMAN_groups::get((int) $gid);

    $lists = array();
    $lists['leadin'] = _DML_THIS_IS.' '.$sitename.' '._DML_SENT_BY." '".$group->groups_name."'";

    HTML_DMGroups::messageForm($group, $lists);
}

function cancelGroup($option)
{
	$mainframe = JFactory::getApplication();
    $database = JFactory::getDBO();
    $row = new mosDMGroups($database);
    $row->bind(DOCMAN_Utils::stripslashes($_POST));
    $row->checkin();
    $mainframe->redirect("index.php?option=$option&section=groups");
}

function sendEmail($gid)
{
    DOCMAN_token::check() or die('Invalid Token');

    $database 	= JFactory::getDBO();
    $my       	= JFactory::getUser();
    $mainframe 	= JFactory::getApplication();

    $link = 'index.php?option=com_docman&section=groups';

    $message = JRequest::getString("mm_message", '', 'post');
    $subject = JRequest::getString("mm_subject", '', 'post');
    $leadin = JRequest::getString("mm_leadin", '', 'post');

    if (!$message || !$subject) {
        $mainframe->redirect($link . '&task=emailgroup&gid=' . $gid , _DML_FILL_FORM);
    }

    // Get the 'TO' list of addresses
    $group = DOCMAN_groups::get((int) $gid);
    $database->setQuery("SELECT * FROM #__users WHERE id in (".$group->groups_members.") AND email !=''");
    $users = $database->loadObjectList();
    if (! count($users)) {
        $mainframe->redirect($link , _DML_NO_TARGET_EMAIL . " " . $group->groups_name);
    }


    // Build e-mail message format
    $message = ($leadin ? (stripslashes($leadin)."\r\n\r\n"):'').stripslashes($message);
    $subject = stripslashes($subject);

    foreach($users as $user) {
        JUtility::sendMail($mainframe->getCfg('mailfrom'),$mainframe->getCfg('fromname'), $user->email, $subject, $message);
    }
    $mainframe->redirect($link, _DML_EMAIL_SENT_TO.' '.count($users).' '._DML_USERS);
}