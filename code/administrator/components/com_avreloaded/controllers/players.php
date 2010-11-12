<?php
/**
 * @version		$Id: players.php 951 2008-06-10 14:25:53Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * AllVideos Reloaded Players Controller
 */
class AvReloadedControllerPlayers extends AvReloadedController
{
    var $_mylink = 'index.php?option=com_avreloaded&view=players';

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
        JRequest::setVar('view', 'player');
        JRequest::setVar('controller', 'players');
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
        $model = $this->getModel('player');
        if ($model->store()) {
            $msg = JText::_('AVR_MSG_PLAYER_SAVED');
            $msgtype = 'message';
        } else {
            $msg = JText::_('AVR_ERR_SAVING_PLAYER');
            $msgtype = 'error';
        }
        $this->setRedirect($this->_mylink, $msg, $msgtype);
    }

    /**
     * save a record (and redirect to main page)
     * @return void
     */
    function apply() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('player');
        if ($model->store()) {
            $msg = JText::_('AVR_MSG_PLAYER_SAVED');
            $msgtype = 'message';
        } else {
            $msg = JText::_('AVR_ERR_SAVING_PLAYER');
            $msgtype = 'error';
        }
        $id = JRequest::getVar('id');
        $this->setRedirect('index.php?option=com_avreloaded'.
            '&view=player&layout=form&task=edit&cid[]='.$id, $msgtype);
    }

    /**
     * remove record(s)
     * @return void
     */
    function remove() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('player');
        if (!$model->delete()) {
            $msg = JText::_('AVR_ERR_PLAYERS_DELETE');
            $msgtype = 'error';
        } else {
            $msg = JText::_('AVR_MSG_PLAYERS_DELETED');
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
