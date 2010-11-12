<?php
/**
 * @version		$Id: playlists.php 1027 2008-07-06 22:46:07Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'playlists.php');

/**
 * Playlists Model
 *
 */
class AvReloadedModelPlaylists extends JModel
{
    /** @var object AvrPlaylistsHelper object */
    var $_helper = null;
    var $_data = null;

    /**
     * Returns the internal helper object
     * @return AvrPlaylistsHelper
     */
    function &getHelper() {
        if ($this->_helper == null) {
            $this->_helper = new AvrPlaylistsHelper();
        }
        return $this->_helper;
    }

    function getTotal() {
        $folder = $this->getState('folder');
        $h =& $this->getHelper();
        return count($h->getPlaylists($folder));
    }

    function _cmpname(&$o1, &$o2) {
        $a = $o1->filename;
        $b = $o2->filename;
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

    function _cmptitle(&$o1, &$o2) {
        $a = $o1->title;
        $b = $o2->title;
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

    /**
     * Retrieves the players
     * @return array Array of objects containing the data from the database
     */
    function &getData() {
        $folder = $this->getState('folder');
        $filter_order = $this->getState('filter_order');
        $filter_order_Dir = $this->getState('filter_order_Dir');
        $h =& $this->getHelper();
        $data =& $h->getPlaylists($folder);
        usort($data, array('AvReloadedModelPlaylists',
            ($filter_order == 'filename') ? '_cmpname' : '_cmptitle'));
        if (strtolower($filter_order_Dir) != 'asc') {
            $data = array_reverse($data);
        }
        $limit = $this->getState('limit');
        $limit = ($limit == 'all') ? 9999 : $limit;
        $limitstart = $this->getState('limitstart');
        $data = array_slice($data, $limitstart, $limit);
        return $data;
    }

    function delete() {
        $cids = JRequest::getVar('cid', array(),'post','array');
        foreach ($cids as $cid) {
            if (!unlink($cid))
                return false;
        }
        return true;
    }
}
