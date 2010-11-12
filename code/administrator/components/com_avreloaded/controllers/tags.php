<?php
/**
 * @version		$Id: tags.php 951 2008-06-10 14:25:53Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * AllVideos Reloaded Tags Controller
 */
class AvReloadedControllerTags extends AvReloadedController
{
    var $_mylink = 'index.php?option=com_avreloaded&view=tags';

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
        JRequest::setVar('view', 'tag');
        JRequest::setVar('controller', 'tags');
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
        $model = $this->getModel('tag');
        if ($model->store()) {
            $msg = JText::_('AVR_MSG_TAG_SAVED');
            $msgtype = 'message';
        } else {
            $msg = JText::_('AVR_ERR_SAVING_TAG');
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
        $model = $this->getModel('tag');
        if ($model->store()) {
            $msg = JText::_('AVR_MSG_TAG_SAVED');
            $msgtype = 'message';
        } else {
            $msg = JText::_('AVR_ERR_SAVING_TAG');
            $msgtype = 'error';
        }
        $id = JRequest::getVar('id');
        $this->setRedirect('index.php?option=com_avreloaded'.
            '&view=tag&layout=form&task=edit&cid[]='.$id, $msg, $msgtype);
    }

    /**
     * remove record(s)
     * @return void
     */
    function remove() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('tag');
        if (!$model->delete()) {
            $msg = JText::_('AVR_ERR_TAGS_DELETE');
            $msgtype = 'error';
        } else {
            $msg = JText::_('AVR_MSG_TAGS_DELETED');
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
