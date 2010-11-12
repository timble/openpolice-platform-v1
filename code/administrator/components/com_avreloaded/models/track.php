<?php
/**
 * @version		$Id: track.php 952 2008-06-11 23:41:24Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrgeneric.php');

class AvReloadedModelTrack extends JModel {

    var $_track = null;

    /**
     * Constructor that retrieves the data from the request
     *
     * @access	public
     * @return	void
     */
    function __construct() {
        parent::__construct();
        $rdata = JRequest::getVar('track', '');
        if (!empty($rdata)) {
            $this->_track = unserialize(base64_decode($rdata));
        }
    }

    /**
     * Method to get a track object
     * @return object with data
     */
    function &getTrack() {
        if (!$this->_track) {
            $this->_track = new stdClass();
            $this->_track->index = 0;
            $this->_track->file = null;
            $this->_track->image = null;
            $this->_track->id = null;
            $this->_track->link = null;
            $this->_track->title = null;
            $this->_track->author = null;
            $this->_track->category = null;
            $this->_track->type = null;
            $this->_track->captions = null;
            $this->_track->audio = null;
        }
        return $this->_track;
    }

    function store() {
        $this->_track->file = JRequest::getVar('file', '');
        $this->_track->image = JRequest::getVar('image', '');
        $this->_track->id = JRequest::getVar('id', '');
        $this->_track->link = JRequest::getVar('link', '');
        $this->_track->title = JRequest::getString('title', '', 'default', JREQUEST_ALLOWRAW);
        $this->_track->author = JRequest::getString('author', '', 'default', JREQUEST_ALLOWRAW);
        $this->_track->category = JRequest::getString('category', '', 'default', JREQUEST_ALLOWRAW);
        $this->_track->type = JRequest::getVar('type', '');
        $this->_track->captions = JRequest::getVar('captions', '');
        $this->_track->audio = JRequest::getVar('audio', '');
        $this->_track->index = JRequest::getInt('index', 0);
    }
}
