<?php
/**
 * @version		$Id: ripper.php 980 2008-06-23 18:54:52Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

/**
 * AllVideos Reloaded Ripper Model
 */
class AvReloadedModelRipper extends JModel
{
    /**
     * Constructor that retrieves the ID from the request
     *
     * @access	public
     * @return	void
     */
    function __construct() {
        parent::__construct();
        $array = JRequest::getVar('cid', 0,'','array');
        $this->setId((int)$array[0]);
    }

    /**
     * Method to set the player identifier
     *
     * @access	public
     * @param	int player identifier
     * @return	void
     */
    function setId($id) {
        // Set id and wipe data
        $this->_id		= $id;
        $this->_data	= null;
    }


    /**
     * Method to get a player object
     * @return object with data
     */
    function &getData() {
        // Load the data
        if (empty($this->_data)) {
            $query = 'SELECT * FROM #__avr_ripper WHERE id = '.$this->_id;
            $this->_db->setQuery($query);
            $this->_data = $this->_db->loadObject();
        }
        if (!$this->_data) {
            $this->_data = new stdClass();
            $this->_data->id = 0;
            $this->_data->version = 0;
            $this->_data->cindex = 0;
            $this->_data->flags = 0;
            $this->_data->url = null;
            $this->_data->name = null;
            $this->_data->regex = null;
            $this->_data->description = null;
        }
        return $this->_data;
    }

    /**
     * Method to store a player record
     *
     * @access	public
     * @return	boolean	True on success
     */
    function store() {
        $row =& $this->getTable();
        // Must allow raw request here, because ripper regex
        // can contain html and scripting.
        $data = JRequest::get('post', JREQUEST_ALLOWRAW);
        // Build tha flags value
        for ($i = 0; $i < 11; $i++) {
            if (isset($data['flags'.$i])) {
                $data['flags'] |= (1 << $i);
                unset($data['flags'.$i]);
            }
        }
        // Bind the form fields to the player table
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        // Make sure record is valid
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        // Store the table to the database
        if (!$row->store()) {
            $this->setError($row->getErrorMsg());
            return false;
        }
        return true;
    }

    /**
     * Method to delete record(s)
     *
     * @access	public
     * @return	boolean	True on success
     */
    function delete() {
        $cids = JRequest::getVar('cid', array(0),'post','array');
        $row =& $this->getTable();
        if (count($cids)) {
            foreach($cids as $cid) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
            }
        }
        return true;
    }
}
