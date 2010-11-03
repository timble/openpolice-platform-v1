<?php
/**
 * @version     $Id: node.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * View helper for items in translatable tables
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Helpers
 */
class NookuHelperNode
{
    public static function link($title, $table_name, $id, $iso_code, $tooltip = true, $icon = true)
    {
        KViewHelper::_('behavior.tooltip');
        KViewHelper::_('behavior.modal');

        // Create edit links to items
        $links  = KFactory::get('admin::com.nooku.model.editlinks')->getLinks();

		if(array_key_exists($table_name, $links))
        {
            $tooltip = $tooltip ? ' class="editlinktip hasTip" title="'.JText::_('Edit')." $table_name ($iso_code)::$title".'"' : '';
            $class   = $icon    ? ' class="editlink"' : '';
			
            $link = JRoute::_('index.php?option=com_nooku&view=node&task=edit&type='.$table_name.'&id='.$id.'&lang='.$iso_code);
			$result = "<span $tooltip>"
					. '<a href="'.$link.'" "'.$class.'">'.$title.'</a>'		
                    . '</span>';
        } 
        else 
        {
			$result = "<span>"
                    . $title
                    .'</span>';
        }

        return $result;
    }
}