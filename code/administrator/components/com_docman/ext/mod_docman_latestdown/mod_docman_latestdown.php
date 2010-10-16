<?php
/**
 * @version		$Id: mod_docman_latestdown.php 1338 2010-04-26 10:52:38Z mathias $
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
$_DOCMAN->loadLanguage('frontend');

require_once($_DOCMAN->getPath('classes', 'utils'));
require_once($_DOCMAN->getPath('classes', 'file'));
require_once($_DOCMAN->getPath('classes', 'model'));

// get the parameters

$limits  		= abs($params->def( 'limits', 3 ));
$show_icon 		= abs($params->def( 'show_icon', 1 ));
$show_category 	= abs($params->def( 'show_category', 1 ));
$moduleclass_sfx = $params->get( 'moduleclass_sfx' );

$menuid = $_DOCMAN->getMenuId();

$html = '<div class="mod_docman_latestdown'.$moduleclass_sfx.'">';

$rows = DOCMAN_Docs::getDocsByUserAccess(0, 'date', 'desc', $limits);
if (count($rows)) {
    $html .= '<ul class="mod_docman_latestdown">';
    foreach ($rows as $row)
    {
     	$doc = new DOCMAN_Document($row->id);
        $catid = $doc->getData('catid');

    	$url = JRoute::_( "index.php?option=com_docman&task=cat_view&Itemid=$menuid&gid=$catid&orderby=dmdate_published" );
    	$html .= '<li><a href="'.$url.'">';

        if ($show_icon)
        	$html .= '<img border="0" src="'.$doc->getPath('icon', 1, '16x16').'" alt="file icon" /> ';

       	$html .= $doc->getData('dmname');

        if ($show_category)
        	$html .= '<br />('.$row->cat_title.')';

        $html .= '</a></li>';
    }
    $html .='</ul>';
} else {
	$html .= "<br />"._DML_MOD_NODOCUMENTS;
}
$html .= '</div>';
echo $html;
