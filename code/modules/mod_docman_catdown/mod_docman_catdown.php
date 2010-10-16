<?php
/**
 * @version		$Id: mod_docman_catdown.php 1127 2010-01-15 14:22:23Z tom $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

// you can define the following parameters at administration:

// limits = number of downloads to display (default = 3);
// show_icon = displays a generic icon near the name of the document
// show_category = displays the category of the document

include_once( JPATH_ADMINISTRATOR .DS."components".DS."com_docman".DS."docman.class.php");

//DOCman core interaction API
global $_DOCMAN, $_DMUSER;
if(!is_object($_DOCMAN)) {
	$_DOCMAN = new dmMainFrame();
    $_DMUSER = $_DOCMAN->getUser();
}

$_DOCMAN->setType(_DM_TYPE_MODULE);
$_DOCMAN->loadLanguage('modules');

require_once($_DOCMAN->getPath('classes', 'utils'));
require_once($_DOCMAN->getPath('classes', 'file'));
require_once($_DOCMAN->getPath('classes', 'model'));

// get the parameters

$catid  		= $params->def( 'catid', '' );
$limits  		= (int) $params->def( 'limits', 3 );
$show_icon 		= (int) $params->def( 'show_icon', 1 );
$show_category 	= (int) $params->def( 'show_category', 1 );

$menuid = $_DOCMAN->getMenuId();

$html = '<div class="mod_docman_catdown'.$params->get( 'moduleclass_sfx' ).'">';

$rows = DOCMAN_Docs::getDocsByUserAccess($catid, '', '', $limits);

if (count($rows)) {
    $html .='<ul class="mod_docman_catdown'.$params->get( 'moduleclass_sfx' ).'">';
    foreach ($rows as $row)
    {
     	$doc = new DOCMAN_Document($row->id);

       	$url = JRoute::_( "index.php?option=com_docman&amp;task=cat_view&amp;Itemid=$menuid&amp;gid=".$doc->getData('catid')."&amp;orderby=dmdate_published&amp;ascdesc=DESC" );
       	$html.='<li><a href="'.$url.'">';

        if ($show_icon)
        	$html .= '<img src="'.$doc->getPath('icon', 1, '16x16').'" alt="file icon" border="0" />';

       	$html .= $doc->getData('dmname');

        if ($show_category)
        	$html .= '<br />('.$row->cat_title.')';

        $html .= '</a></li>';
    }
    $html .= '</ul>';
} else {
	$html .= '<br />'._DML_MOD_NODOCUMENTS;
}
$html .= '</div>';
echo $html;
