<?php
/**
 * @version		$Id: tags.php 945 2008-06-09 17:28:15Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * Tags Model
 *
 */
class AvReloadedModelTags extends JModel
{
    /** @var object JTable object */
    var $_table = null;

    /**
     * Returns the internal table object
     * @return JTable
     */
    function &getTable() {
        if ($this->_table == null) {
            $this->_table =& JTable::getInstance('tags', 'Table');
        }
        return $this->_table;
    }

    function getTotal() {
        $query = 'SELECT t.* FROM #__avr_tags as t';
        return $this->_getListCount($query);
    }

    /**
     * Retrieves the players
     * @return array Array of objects containing the data from the database
     */
    function getData() {
        $orderby = '';
        $filter_order = $this->getState('filter_order');
        $filter_order_Dir = $this->getState('filter_order_Dir');
        if ((!empty($filter_order)) && (!empty($filter_order_Dir))) {
            $orderby = ' ORDER BY '.$filter_order .' '.$filter_order_Dir;
        }
        $query = 'SELECT t.*, p.name AS player, r.name AS ripper FROM #__avr_tags AS t '.
            'LEFT JOIN #__avr_player AS p ON (p.id = t.player_id) '.
            'LEFT OUTER JOIN #__avr_ripper as r ON (r.id = t.ripper_id)'.$orderby;
        return $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
    }
}
