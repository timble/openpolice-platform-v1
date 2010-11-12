<?php
/**
 * @version		$Id: playlist.php 1027 2008-07-06 22:46:07Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrgeneric.php');

/**
 * AllVideos Reloaded Playlists Controller
 */
class AvReloadedControllerPlaylist extends AvReloadedController
{
    var $_plink = 'index.php?option=com_avreloaded&controller=playlists&view=playlists';

    /**
     * constructor (registers additional tasks to methods)
     * @return void
     */
    function __construct() {
        parent::__construct();
        // Register Extra tasks
        $this->registerTask('add', 'edit');
    }

    /**
     * display the edit form
     * @return void
     */
    function edit() {
        $model = $this->getModel('playlist');
        $data =& $model->getData();
        JRequest::setVar('data', base64_encode(serialize($data)));
        JRequest::setVar('view', 'track');
        JRequest::setVar('controller', 'track');
        JRequest::setVar('layout', 'form');
        JRequest::setVar('hidemainmenu', 1);
        parent::display();
    }

    /**
     * save a record (and redirect to main page)
     * @return void
     */
    function save() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('playlist');
        if ($model->store()) {
            $msg = JText::_('AVR_MSG_PLAYLIST_SAVED');
            $this->setRedirect($this->_plink, $msg);
        } else {
            $msg = JText::sprintf('AVR_ERR_SAVING_PLAYLIST', $model->getLastError());
            JRequest::setVar('view', 'playlist');
            JRequest::setVar('controller', 'playlist');
            JRequest::setVar('layout', 'default');
            JRequest::setVar('hidemainmenu', 1);
            JRequest::setVar('filename', $model->getFilename());
            AvrGenericHelper::qmsg($msg, 'error');
            parent::display();
        }
    }

    /**
     * save a record (and redirect to main page)
     * @return void
     */
    function apply() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('playlist');
        if ($model->store()) {
            $msg = JText::_('AVR_MSG_PLAYLIST_SAVED');
            $msgtype = 'message';
            $data =& $model->getData();
            JRequest::setVar('data', base64_encode(serialize($data)));
        } else {
            $msg = JText::sprintf('AVR_ERR_SAVING_PLAYLIST', $model->getLastError());
            $msgtype = 'error';
        }
        JRequest::setVar('view', 'playlist');
        JRequest::setVar('controller', 'playlist');
        JRequest::setVar('layout', 'default');
        JRequest::setVar('hidemainmenu', 1);
        JRequest::setVar('filename', $model->getFilename());
        AvrGenericHelper::qmsg($msg, $msgtype);
        parent::display();
    }

    /**
     * remove record(s)
     * @return void
     */
    function remove() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('playlist');
		$cid = JRequest::getVar('cid', array(), 'post', 'array');
        if (!$model->delete($cid)) {
            $msg = JText::_('AVR_ERR_TRACKS_DELETE');
            $msgtype = 'error';
        } else {
            $msg = JText::_('AVR_MSG_TRACKS_DELETED');
            $msgtype = 'message';
        }
        $data =& $model->getData();
        JRequest::setVar('data', base64_encode(serialize($data)));
        JRequest::setVar('view', 'playlist');
        JRequest::setVar('controller', 'playlist');
        JRequest::setVar('layout', 'default');
        JRequest::setVar('hidemainmenu', 1);
        JRequest::setVar('filename', $model->getFilename());
        AvrGenericHelper::qmsg($msg, $msgtype);
        parent::display();
    }

    /**
     * cancel editing a record
     * @return void
     */
    function cancel() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $msg = JText::_('AVR_MSG_CANCELLED');
        $this->setRedirect($this->_plink, $msg);
    }

	function orderup() {
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		$model = $this->getModel('playlist');
		$model->move(-1);
        $data =& $model->getData();
        JRequest::setVar('data', base64_encode(serialize($data)));
        JRequest::setVar('view', 'playlist');
        JRequest::setVar('controller', 'playlist');
        JRequest::setVar('layout', 'default');
        JRequest::setVar('hidemainmenu', 1);
        JRequest::setVar('filename', $model->getFilename());
        parent::display();
	}

	function orderdown() {
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		$model = $this->getModel('playlist');
		$model->move(1);
        $data =& $model->getData();
        JRequest::setVar('data', base64_encode(serialize($data)));
        JRequest::setVar('view', 'playlist');
        JRequest::setVar('controller', 'playlist');
        JRequest::setVar('layout', 'default');
        JRequest::setVar('hidemainmenu', 1);
        JRequest::setVar('filename', $model->getFilename());
        parent::display();
	}

	function saveorder() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
        $model = $this->getModel('playlist');
		$cid 	= JRequest::getVar('cid', array(), 'post', 'array');
        $order 	= JRequest::getVar('order', array(), 'post', 'array');
		JArrayHelper::toInteger($cid);
        JArrayHelper::toInteger($order);
        $model->saveorder($cid, $order);
		$msg = JText::_('New ordering saved');
        $data =& $model->getData();
        JRequest::setVar('data', base64_encode(serialize($data)));
        JRequest::setVar('view', 'playlist');
        JRequest::setVar('controller', 'playlist');
        JRequest::setVar('layout', 'default');
        JRequest::setVar('hidemainmenu', 1);
        JRequest::setVar('filename', $model->getFilename());
        AvrGenericHelper::qmsg($msg);
        parent::display();
	}
}
