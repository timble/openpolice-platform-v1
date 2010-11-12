<?php
/**
 * @version		$Id: playlist.php 957 2008-06-15 00:21:44Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'playlist.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrgeneric.php');

class AvReloadedModelPlaylist extends JModel
{

    var $_filename = null;

    var $_lasterror = null;

    var $_id = null;

    /**
     * Constructor that retrieves the filename from the request
     *
     * @access	public
     * @return	void
     */
    function __construct() {
        parent::__construct();
        $this->_filename = JRequest::getVar('filename', null);
        $array = JRequest::getVar('cid', 0,'','array');
        $this->_id = (int)$array[0];
        $rdata = JRequest::getVar('data', '');
        if (!empty($rdata)) {
            $this->_data = unserialize(base64_decode($rdata));
            $this->_filename = $this->_data->filename;
        }
    }

    function getTotal() {
        $tmp =& $this->getData();
        return count($tmp->items);
    }

    function getFilename() {
        return $this->_filename;
    }

    function getLastError() {
        return $this->_lasterror;
    }

    /**
     * Method to get a playlist object
     * @return object with data
     */
    function &getData() {
        // Load the data
        if (empty($this->_data)) {
            $helper = new AvrPlaylistHelper($this->_filename);
            $this->_data =& $helper->read();
            $this->_lasterror = $helper->getLastError();
        }
        if (!$this->_data) {
            $this->_data = new stdClass();
            $this->_data->items = array();
            $this->_data->filename = $this->_filename;
            $this->_data->title = null;
            $this->_data->info = null;
            $this->_data->creator = null;
            $this->_data->license = null;
            $this->_data->annotation = null;
            $this->_data->attribution = null;
        }
        return $this->_data;
    }

    function setTrack(&$track) {
        if ($track->index <= 0) {
            $track->index = count($this->_data->items) + 1;
            array_push($this->_data->items, $track);
        } else {
            if ($track->index <= count($this->_data->items)) {
                $this->_data->items[$track->index - 1] = $track;
            }
        }
    }

    /**
     * Method to store a playlist
     *
     * @access	public
     * @return	boolean	True on success
     */
    function store() {
        $this->_data->title = JRequest::getVar('title', $this->_data->title);
        $this->_data->info = JRequest::getVar('info', $this->_data->info);
        $this->_data->creator = JRequest::getVar('creator', $this->_data->creator);
        $this->_data->license = JRequest::getVar('license', $this->_data->license);
        $this->_data->annotation = JRequest::getVar('annotation', $this->_data->annotation);
        $this->_data->attribution = JRequest::getVar('attribution', $this->_data->attribution);
        $helper = new AvrPlaylistHelper($this->_data->filename);
        $this->_filename = $this->_data->filename;
        $ret = $helper->write($this->_data);
        $this->_lasterror = $helper->getLastError();
        return $ret;
    }

    /**
     * Method to move a track up or down
     *
     * @access	public
     * @return	boolean	True on success
     */
    function move($direction) {
        $opos = $this->_id;
        $npos = $opos + $direction;
        if ($npos != $opos) {
            if (($npos < 0) || ($npos >= count($this->_data->items))) {
                return false;
            }
            $tmp = $this->_data->items[$npos];
            $this->_data->items[$npos] = $this->_data->items[$opos];
            $this->_data->items[$opos] = $tmp;
            $this->_data->items[$opos]->index = $opos + 1;
            $this->_data->items[$npos]->index = $npos + 1;
        }
        return true;
    }

    /**
     * Callback to sort tracks by index
     *
     * @access	private
     */
    function _sortByIndex($obja, $objb) {
        $keya = $obja->index;
        $keyb = $objb->index;
        if ($keya == $keyb) {
            return 0;
        }
        return ($keya < $keyb) ? -1 : 1;
    }

    /**
     * Renumbers track indexes
     *
     * @access	private
     */
    function _renumber() {
        for ($i = 0; $i < count($this->_data->items); $i++) {
            $this->_data->items[$i]->index = $i + 1;
        }
    }

    /**
     * Method to save ordering
     *
     * @access	public
     * @return	boolean	True on success
     */
    function saveorder($cid = array(), $order) {
        // update ordering values
        for ($i = 0; $i < count($cid); $i++) {
            $row = $this->_data->items[(int)$cid[$i]];
            if ($row->index != $order[$i]) {
                $row->index = $order[$i];
            }
        }
        usort($this->_data->items, array($this, '_sortByIndex'));
        $this->_renumber();
        return true;
    }

    /**
     * Method to delete tracks
     *
     * @access	public
     * @return	boolean	True on success
     */
    function delete($cid) {
        $narray = array();
        for ($i = 0; $i < count($this->_data->items); $i++) {
            if (!in_array($i, $cid)) {
                array_push($narray, $this->_data->items[$i]);
            }
        }
        $this->_data->items = $narray;
        $this->_renumber();
        return true;
    }
}
