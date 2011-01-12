<?php
/**
 * @version		$Id: doclink.php 1308 2010-03-09 12:06:07Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__).DS.'doclink.html.php';

global $_DOCMAN;

// Load classes and language
require_once($_DOCMAN->getPath('classes', 'utils'));
require_once($_DOCMAN->getPath('classes', 'file'));
require_once($_DOCMAN->getPath('classes', 'model'));
$_DOCMAN->loadLanguage('doclink');

JRequest::setVar('tmpl', 'component');

function showDoclink()
{
	$user = JFactory::getUser();

	if(!$user->authorize('com_content', 'add', 'content', 'all')) {
		JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
	}

    $assets = JURI::root()."components/com_docman/assets";

    // add styles and scripts
    $doc =& JFactory::getDocument();
    JHTML::_('behavior.mootools');
    $doc->addStyleSheet($assets.'/css/doclink.css');
    $doc->addScript($assets.'/js/dlutils.js');
    $doc->addScript($assets.'/js/popup.js');
    $doc->addScript($assets.'/js/dialog.js');


    $rows = DOCMAN_utils::categoryArray();

    HTML_DMDoclink::showDoclink($rows);
}

function showListview()
{
	$user = JFactory::getUser();
	if(!$user->authorize('com_content', 'add', 'content', 'all')) {
		JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
	}

    global $_DOCMAN;

    $assets = JURI::root()."components/com_docman/assets";

    // add styles and scripts
    $doc =& JFactory::getDocument();
    JHTML::_('behavior.mootools');
    $doc->addStyleSheet($assets.'/css/doclink.css');
    $doc->addScript($assets.'/js/sortabletable.js');
    $doc->addScript($assets.'/js/listview.js');

    if (isset($_REQUEST['catid'])) {
        $cid =  intval($_REQUEST['catid']);
    } else {
        $cid = 0;
    }
        //get folders
        $cats = DOCMAN_Cats::getChildsByUserAccess($cid);

        //get items
        if ($cid) {
            $docs = DOCMAN_Docs::getDocsByUserAccess($cid, 'name', 'ASC', 2500, 0);
        } else {
            $docs = array();
        }


        //if ($entries_cnt)
        HTML_DMDoclink::createHeader();
        HTML_DMDoclink::createFolders($cats,$cid);
        HTML_DMDoclink::createItems($docs, $cid);
        HTML_DMDoclink::createFooter();
}