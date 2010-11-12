<?php
/**
 * @version		$Id: track.php 1027 2008-07-06 22:46:07Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrgeneric.php');

/**
 * AllVideos Reloaded Track Controller
 */
class AvReloadedControllerTrack extends AvReloadedController
{
    var $_plink = 'index.php?option=com_avreloaded&controller=playlist&view=playlist';

    /**
     * constructor (registers additional tasks to methods)
     * @return void
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * save a record (and redirect to main page)
     * @return void
     */
    function save() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('track');
        $model->store();
        $track =& $model->getTrack();
        $model = $this->getModel('playlist');
        $model->setTrack($track);
        $data =& $model->getData();
        $msg = JText::_('AVR_MSG_TRACK_SAVED');
        JRequest::setVar('data', base64_encode(serialize($data)));
        JRequest::setVar('view', 'playlist');
        JRequest::setVar('controller', 'playlist');
        JRequest::setVar('layout', 'default');
        JRequest::setVar('hidemainmenu', 1);
        AvrGenericHelper::qmsg($msg);
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
        JRequest::setVar('view', 'playlist');
        JRequest::setVar('controller', 'playlist');
        JRequest::setVar('layout', 'default');
        JRequest::setVar('hidemainmenu', 1);
        AvrGenericHelper::qmsg($msg);
        parent::display();
    }
}
