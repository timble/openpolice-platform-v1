<?php
/**
 * @version		$Id: players.php 945 2008-06-09 17:28:15Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * Players Model
 *
 */
class AvReloadedModelPlayers extends JModel
{
    /** @var object JTable object */
    var $_table = null;

    /**
     * Returns the internal table object
     * @return JTable
     */
    function &getTable() {
        if ($this->_table == null) {
            $this->_table =& JTable::getInstance('player', 'Table');
        }
        return $this->_table;
    }

    function getTotal() {
        $query = 'SELECT p.* FROM #__avr_player as p';
        return $this->_getListCount($query);
    }

    /**
     * Retrieves the players
     * @return array Array of objects containing the data from the database
     */
    function getData() {
        $orderby = ' ORDER BY p.description, p.name ASC';
        $filter_order = $this->getState('filter_order');
        $filter_order_Dir = $this->getState('filter_order_Dir');
        if ((!empty($filter_order)) && (!empty($filter_order_Dir))) {
            $orderby = ' ORDER BY '.$filter_order .' '.$filter_order_Dir;
        }
        $query = 'SELECT p.id, p.name, p.description, COUNT(t.id) AS used FROM #__avr_player as p '.
            'LEFT OUTER JOIN #__avr_tags AS t ON (t.player_id = p.id) GROUP BY p.id'.$orderby;
        return $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
    }
}
