<?php
/**
 * @version		$Id: config.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once ($_DOCMAN->getPath('classes', 'utils'));

include_once dirname(__FILE__) . DS.'config.html.php';
include_once dirname(__FILE__) . DS.'defines.php';

switch ($task) {
    case "cancel":
        $mainframe->redirect("index.php?option=com_docman");
        break;
    case "apply":
    case "save":
        saveConfig();
        break;
    case "show" :
    default :
        showConfig($option);
        break;
}

function showConfig($option)
{
    global $_DOCMAN;

    // disable the main menu to force user to use buttons
    $_REQUEST['hidemainmenu']=1;

    $std_inp = 'style="width: 125px" size="2"';
    $std_opt = 'size="2"';

    // Create the 'yes-no' radio options
    foreach(array('isDown' , 'display_license', 'log' , 'emailgroups',
            'user_all', 'fname_lc' , 'overwrite' , 'security_anti_leech',
            'trimwhitespace', 'process_bots', 'individual_perm', 'hide_remote'
            )
        AS $field) {
        $lists[ $field ] = JHTML::_('select.booleanlist', $field, $std_opt,
            $_DOCMAN->getCfg($field , 0));
    }

    $guest[] = JHTML::_('select.option',_DM_GRANT_NO , _DML_CFG_GUEST_NO);
    $guest[] = JHTML::_('select.option',_DM_GRANT_X , _DML_CFG_GUEST_X);
    $guest[] = JHTML::_('select.option',_DM_GRANT_RX , _DML_CFG_GUEST_RX);
    $lists['guest'] = JHTML::_('select.genericlist',$guest, 'registered',
        '' , 'value', 'text',
        $_DOCMAN->getCfg('registered', _DM_GRANT_RX));

  	$upload = new dmHTML_UserSelect('user_upload', 1 );
    $upload->addOption(_DML_CFG_USER_UPLOAD, _DM_PERMIT_NOOWNER);
    $upload->addGeneral(_DML_NO_USER_ACCESS, 'all');
    $upload->addMamboGroups();
    $upload->addDocmanGroups();
    $upload->addUsers();
    $upload->setSelectedValues(array($_DOCMAN->getCfg('user_upload', 0)));
    $lists['user_upload'] = $upload;

    $publish = new dmHTML_UserSelect('user_publish', 1 );
    $publish->addOption(_DML_CFG_USER_PUBLISH, _DM_PERMIT_NOOWNER);
    $publish->addGeneral(_DML_AUTO_PUBLISH, 'all');
    $publish->addMamboGroups();
    $publish->addDocmanGroups();
    $publish->addUsers();
    $publish->setSelectedValues(array($_DOCMAN->getCfg('user_publish', 0)));
    $lists['user_publish'] = $publish;

    $approve = new dmHTML_UserSelect('user_approve', 1 );
    $approve->addOption(_DML_CFG_USER_APPROVE, _DM_PERMIT_NOOWNER);
    $approve->addGeneral(_DML_AUTO_APPROVE, 'all');
    $approve->addMamboGroups();
    $approve->addDocmanGroups();
    $approve->addUsers();
    $approve->setSelectedValues(array($_DOCMAN->getCfg('user_approve', 0)));
    $lists['user_approve'] = $approve;

    $viewer = new dmHTML_UserSelect('default_viewer', 1 );
    $viewer->addOption(_DML_SELECT_USER, _DM_PERMIT_NOOWNER);
    $viewer->addGeneral(_DML_EVERYBODY);
    $viewer->addMamboGroups();
    $viewer->addDocmanGroups();
    $viewer->addUsers();
    $viewer->setSelectedValues(array($_DOCMAN->getCfg('default_viewer', 0)));
    $lists['default_viewer'] = $viewer;

    $maintainer = new dmHTML_UserSelect('default_editor', 1 );
    $maintainer->addOption(_DML_SELECT_USER, _DM_PERMIT_NOOWNER);
    $maintainer->addGeneral(_DML_NO_USER_ACCESS);
    $maintainer->addMamboGroups();
    $maintainer->addDocmanGroups();
    $maintainer->addUsers();
    $maintainer->setSelectedValues(array($_DOCMAN->getCfg('default_editor', 0)));
    $lists['default_maintainer'] = $maintainer;

    $author_can = array();
    $author_can[] = JHTML::_('select.option',_DM_AUTHOR_NONE , _DML_CFG_AUTHOR_NONE);
    $author_can[] = JHTML::_('select.option',_DM_AUTHOR_CAN_READ , _DML_CFG_AUTHOR_READ);
    $author_can[] = JHTML::_('select.option',_DM_AUTHOR_CAN_EDIT , _DML_CFG_AUTHOR_BOTH);
    $lists['creator_can'] = JHTML::_('select.genericlist',$author_can, 'author_can',
        '', 'value', 'text',
        $_DOCMAN->getCfg('author_can', _DM_AUTHOR_CAN_EDIT));

    // Blank handling for filenames
    $blanks[] = JHTML::_('select.option','0', _DML_CFG_ALLOWBLANKS);
    $blanks[] = JHTML::_('select.option','1', _DML_CFG_REJECT);
    $blanks[] = JHTML::_('select.option','2', _DML_CFG_CONVERTUNDER);
    $blanks[] = JHTML::_('select.option','3', _DML_CFG_CONVERTDASH);
    $blanks[] = JHTML::_('select.option','4', _DML_CFG_REMOVEBLANKS);
    $lists['fname_blank'] = JHTML::_('select.genericlist',$blanks, 'fname_blank',
        '', 'value', 'text',
        $_DOCMAN->getCfg('fname_blank', 0));

    // assemble icon sizes
    $size[] = JHTML::_('select.option','0', '16x16 pixel');
    $size[] = JHTML::_('select.option','1', '32x32 pixel');
    $lists['icon_size'] = JHTML::_('select.genericlist',$size, 'icon_size',
        $std_inp, 'value', 'text',
        $_DOCMAN->getCfg('icon_size', 0));

    // assemble displaying order
    $order[] = JHTML::_('select.option','name', _DML_NAME);
    $order[] = JHTML::_('select.option','date', _DML_DATE);
    $order[] = JHTML::_('select.option','hits', _DML_HITS);
    $lists['default_order'] = JHTML::_('select.genericlist',$order, 'default_order',
        'style="width: 125px"', 'value', 'text',
        $_DOCMAN->getCfg('default_order', 'name'));
    $order2[] = JHTML::_('select.option','ASC', _DML_ASCENDENT);
    $order2[] = JHTML::_('select.option','DESC', _DML_DESCENDENT);
    $lists['default_order2'] = JHTML::_('select.genericlist',$order2, 'default_order2',
        'style="width: 125px"', 'value', 'text',
        $_DOCMAN->getCfg('default_order2', 'DESC'));

    // Perpage list
    for ( $counter = 5; $counter <= 100; $counter += 5) {
		$perpage[] = JHTML::_('select.option',$counter, $counter);
	}
    $lists['perpage'] = JHTML::_('select.genericlist',$perpage, 'perpage',
        '', 'value', 'text',
        $_DOCMAN->getCfg('perpage', 0));

    // Assemble the methods we allow
    $methods = array();
    $methods[] = JHTML::_('select.option','http' , _DML_OPTION_HTTP);
    $methods[] = JHTML::_('select.option','link' , _DML_OPTION_LINK);
    $methods[] = JHTML::_('select.option','transfer' , _DML_OPTION_XFER);
    $default_methods = $_DOCMAN->getCfg('methods', array('http'));
    // ugh ... all because they like arrays of classes....
    $class_methods = array();
    foreach($default_methods as $a_method) {
        $class_methods[] = JHTML::_('select.option',$a_method);
    }

    $lists['methods'] = JHTML::_('select.genericlist',$methods, 'methods[]',
        'size="3" multiple', 'value', 'text', $class_methods);

    $lists['maxini'] = DOCMAN_Utils::number2text(DOCMAN_utils::getMaxUploadSize());

    HTML_DMConfig::configuration($lists);
    $_DOCMAN->saveConfig(); // Save any defaults we created...

}



function saveConfig()
{
    DOCMAN_token::check() or die('Invalid Token');

    global $_DOCMAN, $task;

    $mainframe = JFactory::getApplication();

    $_POST = DOCMAN_Utils::stripslashes($_POST);

    $docmanMax = DOCMAN_Utils::text2number($_POST['maxAllowed']);
    $_POST[ 'maxAllowed'] = $docmanMax;

    $max = DOCMAN_utils::getMaxUploadSize();

    if ($docmanMax < 0) {
       $mainframe->redirect("index.php?option=com_docman&section=config", _DML_CONFIG_ERROR_UPLOAD);
    }

    $override_edit = _DM_ASSIGN_NONE;
    $author = JRequest::getBool('assign_edit_author', 0 ,'post');
    $editor = JRequest::getBool('assign_edit_editor', 0, 'post');

    if ($author) {
        $override_edit = _DM_ASSIGN_BY_AUTHOR;
    }
    if ($editor) {
        $override_edit = _DM_ASSIGN_BY_EDITOR;
    }
    if ($author && $editor) {
        $override_edit = _DM_ASSIGN_BY_AUTHOR_EDITOR;
    }

    $_POST['editor_assign'] = $override_edit;
    unset($_POST['assign_edit_author']);
    unset($_POST['assign_edit_editor']);

    $override_down = _DM_ASSIGN_NONE;
    $author = JRequest::getBool('assign_download_author', 0, 'post');
    $editor = JRequest::getBool('assign_download_editor', 0, 'post');

    if ($author) {
        $override_down = _DM_ASSIGN_BY_AUTHOR;
    }
    if ($editor) {
        $override_down = _DM_ASSIGN_BY_EDITOR;
    }
    if ($author && $editor) {
        $override_down = _DM_ASSIGN_BY_AUTHOR_EDITOR;
    }

    $_POST['reader_assign'] = $override_down;
    unset($_POST['assign_download_author']);
    unset($_POST['assign_download_editor']);

    foreach($_POST as $key => $value) {
        $_DOCMAN->setCfg($key, $value);
    }

    if ($_DOCMAN->saveConfig())
    {
        if ($max < $docmanMax) {
            $mainframe->redirect("index.php?option=com_docman&section=config", _DML_CONFIG_WARNING . DOCMAN_UTILS::number2text($max));
        } else {
            $section = ($task=='apply') ? '&section=config' : '';
            $mainframe->redirect('index.php?option=com_docman'.$section, _DML_CONFIG_UPDATED);
        }
    } else {
        $mainframe->redirect("index.php?option=com_docman&section=config", _DML_CONFIG_ERROR);
    }
}