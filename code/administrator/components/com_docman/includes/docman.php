<?php
/**
 * @version		$Id: docman.php 1347 2010-04-27 14:07:24Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__) .DS.'docman.html.php';

switch ($task)
{
    case 'stats':
        showStatistics();
        break;

    case 'sampledata':
        installSampleData();
        break;

    // DOClink
    case "doclink":
        require_once($_DOCMAN->getPath('includes_f', 'doclink'));
        showDoclink();
        break;

    case "doclink-listview":
        require_once($_DOCMAN->getPath('includes_f', 'doclink'));
        showListview();
        break;

    // CPanel
    case 'cpanel':
    default:
        showCPanel();
}

function showCPanel()
{
    HTML_DMDocman::showCPanel();
}


function showStatistics()
{
    $database = JFactory::getDBO();
    $query = "SELECT id, catid , dmname , dmcounter from #__docman " .
            // removed to fix artf7530
            // "\n WHERE dmowner=-1 OR dmowner=0 " .
            "\n ORDER BY dmcounter DESC";
    $database->setQuery($query, 0, 50);
    $row = $database->loadObjectList();
    HTML_DMDocman::showStatistics($row);
}

/**
 * Add sample category, file and document
 */
function installSampleData()
{
    $database = JFactory::getDBO();
    $my       = JFactory::getUser();
    $mainframe = JFactory::getApplication();

    $dmdoc  = JPATH_ROOT.DS._DM_DEFAULT_DATA_FOLDER;
    $img    = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_docman'.DS.'images';
    $now = date('Y-m-d H:i:s');

    // get all super admins
    $database->setQuery("SELECT id FROM `#__users` WHERE `usertype`='Super Administrator'");
    $admins = implode(',', $database->loadResultArray() );

    // add sample group
    $group = new mosDMGroups($database);
    $group->groups_name         = _DML_SAMPLE_GROUP;
    $group->groups_description  = _DML_SAMPLE_GROUP_DESC;
    $group->groups_access       = 1;
    $group->groups_members      = $admins;
    if(!$group->store()) {
    	$mainframe->redirect('index.php?option=com_docman', 'Error: installSampleData, $groups->store()');
    }
    $groupid = (-1 * $database->insertid()) + _DM_PERMIT_GROUP;

    // add sample license
    $license = new mosDMLicenses($database);
    $license->name      = _DML_SAMPLE_LICENSE;
    $license->license   = _DML_SAMPLE_LICENSE_DESC;
    if(!$license->store()) {
        $mainframe->redirect('index.php?option=com_docman', 'Error: installSampleData, $license->store()');
    }
    $licenseid = $database->insertid();

    // add a sample file
    //if ( !file_exists($dmdoc.DS.'sample_file.png')) {
    //   @copy($img.DS.'dm_logo.png', $dmdoc.DS._DML_SAMPLE_FILENAME);
    //}

    // add sample category
    $category = new mosDMCategory($database);
    $category->parent_id        = 0;
    $category->title            = 'DOCman Sample Data';
    $category->name             = 'DOCman Sample Data';
    $category->image            = '';
    $category->section          = 'com_docman';
    $category->image_position   = 'left';
    $category->description      = '<p>Congratulations on installing DOCman! This is a category with some sample documents, so you can get a feel of how DOCman works. Did you know you can have unlimited nested categories? Just give it a try!</p>';
    $category->published        = 1;
    $category->checked_out      = 0;
    $category->checked_out_time = '0000-00-00 00:00:00';
    $category->editor           = NULL;
    $category->ordering         = 1;
    $category->access           = 0;
    $category->count            = 0;
    $category->params           = '';
    if(!$category->store()) {
        $mainframe->redirect('index.php?option=com_docman', 'Error: installSampleData, $category->store()');
    }
    $catid = $database->insertId();

    // add sample document
    $doc = new mosDMDocument($database);
    $doc->catid             = $catid;
    $doc->dmname            = 'About DOCman 1.5';
    $doc->dmdescription     = '<p>Short presentation about DOCman 1.5</p>';
    $doc->dmdate_published  = $now;
    $doc->dmowner           = -1;
    $doc->dmfilename        = 'Link: http://www.box.net/shared/static/kvxyc2jjk0.pdf';
    $doc->published         = 1;
    $doc->dmurl             = 'http://www.joomlatools.eu';
    $doc->dmcounter         = 0;
    $doc->checked_out       = 0;
    $doc->checked_out_time  = '0000-00-00 00:00:00';
    $doc->approved          = 1;
    $doc->dmthumbnail       = '';
    $doc->dmlastupdateon    = $now;
    $doc->dmlastupdateby    = $my->id;
    $doc->dmsubmitedby      = $my->id;
    $doc->dmmantainedby     = $groupid;
    $doc->dmlicense_id      = $licenseid;
    $doc->dmlicense_display = 1;
    $doc->access            = 0;
    $doc->attribs           = '';
    if(!$doc->store()) {
        $mainframe->redirect('index.php?option=com_docman', 'Error: installSampleData, $doc->store()');
    }

    // ... and another
    $doc = new mosDMDocument($database);
    $doc->catid             = $catid;
    $doc->dmname            = 'Nooku Framework: A new brain for Joomla';
    $doc->dmdescription     = "<p>At the core of Joomla, there's a framework. It's the engine that powers all of Joomla, and a lot of the third-party extensions. It's great platform, but sites today are more demanding, and extensions require more power. We felt it was time to build <strong>a new brain for Joomla</strong>.</p><p><a href='http://nooku.org/framework'>Nooku Framework</a> can be installed in Joomla as a plugin. As a developer, you can now build your extensions using Nooku's intuitive API. Because the framework handles most of the work, you'll need only a <strong>fraction of the amount of code</strong>. You can focus on what really matters: business logic and the user experience.</p><p>But there's more: Nooku Framework provides you with excellent out-of-the-box <strong>security features</strong>. The great <strong>design patterns</strong> based architecture makes your extension very flexible: all your code automatically becomes re-usable, extensible and replaceable. We believe Nooku Framework is the boost Joomla needs to keep competing.</p>";
    $doc->dmdate_published  = $now;
    $doc->dmowner           = -1;
    $doc->dmfilename        = 'Link: http://www.box.net/shared/static/pqsjzv0rko.pdf';
    $doc->published         = 1;
    $doc->dmurl             = 'http://www.nooku.org/framework';
    $doc->dmcounter         = 0;
    $doc->checked_out       = 0;
    $doc->checked_out_time  = '0000-00-00 00:00:00';
    $doc->approved          = 1;
    $doc->dmthumbnail       = '';
    $doc->dmlastupdateon    = $now;
    $doc->dmlastupdateby    = $my->id;
    $doc->dmsubmitedby      = $my->id;
    $doc->dmmantainedby     = $groupid;
    $doc->dmlicense_id      = $licenseid;
    $doc->dmlicense_display = 1;
    $doc->access            = 0;
    $doc->attribs           = '';
    if(!$doc->store()) {
        $mainframe->redirect('index.php?option=com_docman', 'Error: installSampleData, $doc->store()');
    }



    $mainframe->redirect('index.php?option=com_docman', _DML_SAMPLE_COMPLETED);
}
