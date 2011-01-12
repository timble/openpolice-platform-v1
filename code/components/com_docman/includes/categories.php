<?php
/**
 * @version		$Id: categories.php 1262 2010-02-17 19:27:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

include_once dirname(__FILE__) . DS.'categories.html.php';
require_once($_DOCMAN->getPath('classes', 'model'));
require_once($_DOCMAN->getPath('classes', 'theme'));

function fetchCategory($id)
{
    global $_DMUSER;

    $cat = new DOCMAN_Category($id);

    // if the user is not authorized to access this category, redirect
    if(!$_DMUSER->canAccessCategory($cat->getDBObject())) {
    	_returnTo('' , _DML_NOT_AUTHORIZED);
    }

    // process content mambots
    DOCMAN_Utils::processContentBots(  $cat, 'description' );

    return HTML_DMCategories::displayCategory($cat->getLinkObject(),
        $cat->getPathObject(),
        $cat->getDataObject());
}

function fetchCategoryList($id)
{
    global $_DOCMAN, $_DMUSER;

    $children = DOCMAN_Cats::getChildsByUserAccess($id);

    $items = array();
    foreach($children as $child)
    {
        $cat = new DOCMAN_Category($child->id);

        // process content mambots
        DOCMAN_Utils::processContentBots(  $cat, 'description' );

     	$item = new StdClass();
       	$item->links = &$cat->getLinkObject();
       	$item->paths = &$cat->getPathObject();
        $item->data = &$cat->getDataObject();

       	$items[] = $item;
    }
    // display the entries
    return HTML_DMCategories::displayCategoryList($items);
}
