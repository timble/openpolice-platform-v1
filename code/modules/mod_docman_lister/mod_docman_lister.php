<?php
/**
 * @version		$Id: mod_docman_lister.php 1126 2010-01-15 14:09:03Z tom $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

// you can define the following parameters at administration:

// show_icon = displays a generic icon near the name of the document, using the theme defined (default = 1) No=0; Yes=1
// show_counter = displays the number of downloads (default = 1) No=0; Yes=1
// show_category = display the category name after the document name (default = 1) No=0; Yes=1
// link_type = the type of link to display (default = 0) List=0; Search=1; Details=2; Direct=3
// moduleclass_sfx = module class suffix (default='')
// show_list = show results using <ul> tag (default = 0) No=0; Yes=1
// text_pfx = text to show before list (default='')
// text_sfx = text to show after list (default='')
// limits = number of downloads to display (default = '')
// cat_limit = search a specific category ( or list ) if provided (default='')
// itid = override the passed itemid and use this one, if present (default='')
// order_by = how to order the results (default = 0) Most hits=0; Least hits=1; Newest=2;
//            oldest=3; Alphabet=4; Alphabet, reverse=5


// Include the DOCman class
include_once( JPATH_ADMINISTRATOR .DS."components".DS."com_docman".DS."docman.class.php");

//DOCman core interaction API
global $_DOCMAN, $_DMUSER;
if(!is_object($_DOCMAN)) {
    $_DOCMAN = new dmMainFrame();
    $_DMUSER = $_DOCMAN->getUser();
}

$_DOCMAN->setType(_DM_TYPE_MODULE);
$_DOCMAN->loadLanguage('modules');

// Include some other DOCman classes
require_once($_DOCMAN->getPath('classes', 'utils'));
require_once($_DOCMAN->getPath('classes', 'file'));
require_once($_DOCMAN->getPath('classes', 'model'));

// get the parameters
$show_icon 		 = (int) $params->def( 'show_icon', 1 );
$show_counter	 = (int) $params->def( 'show_counter', 1 );
$show_category 	 = (int) $params->def( 'show_category', 1 );
$link_type   	 = (int) $params->def( 'link_type', 0 );
$moduleclass_sfx = $params->get( 'moduleclass_sfx' );
$show_list   	 = (int) $params->def( 'show_list', 0 );
$text_pfx     	 = $params->def( 'text_pfx', '' );
$text_sfx     	 = $params->def( 'text_sfx', '' );
$limits  		 = (int) $params->def( 'limits', '' );
$cat_limit     	 = $params->def( 'cat_limit', '' );
$itid          	 = $params->def( 'itid', '' );
$order_by   	 = (int) $params->def( 'order_by', 0 );

$menuid = $_DOCMAN->getMenuId();
$user   = $_DOCMAN->getUser();

// Some strings
$string_icon_alt = "File icon";
$class_link 	= "mod_docman_lister_link" . $moduleclass_sfx;
$class_prefix 	= "mod_docman_lister_prefix" . $moduleclass_sfx;
$class_suffix 	= "mod_docman_lister_suffix" . $moduleclass_sfx;

// Setup some variables
$html = "";

// Sort out the ordering
switch ( $order_by ) {
    case 0:
        // Most hits
        $order = "hits";
        $dir   = "DESC";
        break;
    case 1:
        // Least hits
        $order = "hits";
        $dir   = "ASC";
        break;
    case 2:
        // Newest
        $order = "date";
        $dir   = "DESC";
        break;
    case 3:
        // Oldest
        $order = "date";
        $dir   = "ASC";
        break;
    case 4:
        // Alphabetically
        $order = "name";
        $dir   = "ASC";
        break;
    case 5:
        // Alphabetically, reverse
        $order = "name";
        $dir   = "DESC";
        break;
}

$rows = DOCMAN_Docs::getDocsByUserAccess($cat_limit, $order, $dir, $limits);

// If we have a textual prefix, show it now
if ( strlen($text_pfx) > 0 ) {
    $html .= "<span class='$class_prefix'>" . $text_pfx . "</span><br />";
}

// List output
if ( $show_list == 1 ) {
    $html .= "<ul>";
}

// For each row of our result..
foreach ($rows as $row) {

    // List output
    if ( $show_list == 1 ) {
        $html .= "<li>";
    }

    // Create a new document
    $doc = new DOCMAN_Document($row->id);

    // Create the appropriate type of link
    $linkText = "";
    switch ($link_type) {
        case 0:
            $linkText = "index.php?option=com_docman&task=cat_view&amp;Itemid=$menuid&amp;gid=".$row->catid."&amp;orderby=dmdatecounter&ascdesc=DESC";
            break;
        case 1:
            $linkText = "index.php?option=com_docman&amp;task=search_result&amp;Itemid=$menuid&amp;search_phrase=" . urlencode($row->dmname) . "&amp;search_mode=phrase";
            break;
        case 2:
            $linkText = "index.php?option=com_docman&amp;task=doc_details&amp;Itemid=$menuid&amp;gid=" . $row->id;
            break;
        case 3:
            $linkText = "index.php?option=com_docman&amp;Itemid=$menuid&amp;task=doc_download" . $itid . "&amp;gid=" . $row->id;
            break;
    }
    $url = JRoute::_( $linkText );
    $html .= "<a class=\"$class_link\" href=\"$url\">";

    // If we are showing the icon, do it
    if ($show_icon) {
    	$html .= "<img border='0' src=\"".$doc->getPath('icon', 1, '16x16')."\" alt=\"". _DML_FILEICON_ALT ."\" /> ";
    }

    // Output the document name
    $html .= $doc->getData('dmname');

	// If we are showing the counter or the category, do it
	if ($show_counter) {
	    $html .= " (".$doc->getData('dmcounter').")";
	}
    if ($show_category) {
    	$html .= "<br />(".$row->cat_title.")";
    }

	// Add the end link and break
	$html .= "</a>";

    // List output
    if ( $show_list == 1 ) {
        $html .= "</li>";
    } else {
        $html .= "<br />";
    }

}

// If we had 0 results..
if ( count($rows) == 0 ) {
    // List output
    if ( $show_list == 1 ) {
        $html .= "<li>";
    }

    $html .= _DML_MOD_NODOCUMENTS ;

    // List output
    if ( $show_list == 1 ) {
        $html .= "</li>";
    }
}

// List output
if ( $show_list == 1 ) {
    $html .= "</ul>" ;
}

// If we have a textual suffix, show it now
if ( strlen($text_sfx) > 0 ) {
    $html .= "<span class='$class_suffix'>" . $text_sfx . "</span><br />";
}


echo $html;