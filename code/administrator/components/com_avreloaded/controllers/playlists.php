<?php
/**
 * @version		$Id: playlists.php 951 2008-06-10 14:25:53Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * AllVideos Reloaded Playlists Controller
 */
class AvReloadedControllerPlaylists extends AvReloadedController
{
    var $_mylink = 'index.php?option=com_avreloaded&view=playlists';

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
        JRequest::checkToken() or jexit('Invalid Token');
        JRequest::setVar('view', 'playlist');
        JRequest::setVar('controller', 'playlist');
        JRequest::setVar('layout', 'default');
        JRequest::setVar('hidemainmenu', 1);
        parent::display();
    }

    /**
     * remove a playlist
     * @return void
     */
    function remove() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('playlists');
        if (!$model->delete()) {
            $msg = JText::_('AVR_ERR_PLAYLISTS_DELETE');
            $msgtype = 'error';
        } else {
            $msg = JText::_('AVR_MSG_PLAYLISTS_DELETED');
            $msgtype = 'message';
        }
        $this->setRedirect($this->_mylink, $msg, $msgtype);
    }

    /**
     * cancel editing a record
     * @return void
     */
    function cancel() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $msg = JText::_('AVR_MSG_CANCELLED');
        $this->setRedirect($this->_mylink, $msg);
    }
}
