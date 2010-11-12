<?php
/**
 * @version		$Id: tag.php 980 2008-06-23 18:54:52Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

/**
 * AllVideos Reloaded Tag Model
 */
class AvReloadedModelTag extends JModel
{
    /** @var object JTable object */
    var $_table = null;

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

    function &getTable() {
        if ($this->_table == null) {
            $this->_table =& JTable::getInstance('tags', 'Table');
        }
        return $this->_table;
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
            $query = 'SELECT * FROM #__avr_tags WHERE id = '.$this->_id;
            $this->_db->setQuery($query);
            $this->_data = $this->_db->loadObject();
            $this->_data->pra = null;
            if (!empty($this->_data->postreplace)) {
                $pra = unserialize($this->_data->postreplace);
                if (is_array($pra)) {
                    $this->_data->pra = $pra;
                }
            }
        }
        if (!$this->_data) {
            $this->_data = new stdClass();
            $this->_data->id = 0;
            $this->_data->version = 0;
            $this->_data->player_id = 0;
            $this->_data->ripper_id = 0;
            $this->_data->local = 0;
            $this->_data->plist = 0;
            $this->_data->name = null;
            $this->_data->description = null;
            $this->_data->postreplace = null;
            $this->_data->sampleregex = null;
            $this->_data->pra = null;
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
        $pr = array();
        if (isset($data['pres']) && isset($data['prer']) && (count($data['pres']) == count($data['prer']))) {
            $search = $data['pres'];
            $replace = $data['prer'];
            $n = count($search);
            for ($i = 0; $i < $n; $i++) {
                $s = trim($search[$i]);
                if (!empty($s)) {
                    $pr[$s] = trim($replace[$i]);
                }
            }
        }
        unset($data['pres']);
        unset($data['pres']);
        if (empty($pr)) {
            $data['postreplace'] = '';
        } else {
            $data['postreplace'] = serialize($pr);
        }
        if (!isset($data['local'])) {
            $data['local'] = 0;
        }
        if (!isset($data['plist'])) {
            $data['plist'] = 0;
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
