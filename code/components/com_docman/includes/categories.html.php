<?php
/**
 * @version		$Id: categories.html.php 1098 2009-12-17 13:36:28Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class HTML_DMCategories
{
    function displayCategory(&$links, &$paths, &$data)
    {
        $tpl = new DOCMAN_Theme();

        // Assign values to the Savant instance.
        $tpl->assignRef('links', $links);
        $tpl->assignRef('paths', $paths);
        $tpl->assignRef('data', $data);

        // Display a template using the assigned values.
        return $tpl->fetch('categories/category.tpl.php');
    }

    function displayCategoryList(&$items)
    {
        $tpl = new DOCMAN_Theme();

        // Assign values to the Savant instance.
        $tpl->assignRef('items', $items);

        // Display a template using the assigned values.
        return $tpl->fetch('categories/list.tpl.php');
    }
}