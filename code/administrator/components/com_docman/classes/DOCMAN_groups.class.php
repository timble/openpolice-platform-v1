<?php
/**
 * @version		$Id: DOCMAN_groups.class.php 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class DOCMAN_groups 
{

    /**
     * Provides a list of all groups
     *
     * @deprecated
     */
    function & getList() 
    {
        static $groups;

        if( !isset( $groups )) 
        {
            $database = JFactory::getDBO();
            $database->setQuery("SELECT groups_id, groups_name "
             . "\n  FROM #__docman_groups "
             . "\n ORDER BY groups_name ASC");
            $groups = $database->loadObjectList();
        }

        return $groups;
    }

    /**
     * Get a group object, caches results
     */
    function & get($id)
    {
        static $groups;

        if( !isset( $groups )) {
            $groups = array();
        }

        if( !isset( $groups[$id] )) 
        {
            $database = JFactory::getDBO();
            $groups[$id] = new mosDMGroups($database);
            $groups[$id]->load($id);
        }

        return $groups[$id];
    }
}