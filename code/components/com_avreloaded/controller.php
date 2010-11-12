<?php
/**
 * AllVideos Reloaded default controller
 *
 * @version		$Id: controller.php 945 2008-06-09 17:28:15Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

jimport('joomla.application.component.controller');

class AvReloadedController extends JController
{
    /**
     * Method to display the view
     *
     * @access	public
     */
    function display() {
        $view = JRequest::getCmd('view', null);
        switch ($view) {
            // mod_avreloaded popup
        case 'popup':
            JRequest::setVar('tmpl', 'component');
            break;
            // "Insert media" editor-xtd
        case 'insert':
            $user =& JFactory::getUser();
            if (!$user->authorize('com_media', 'popup')) {
                $this->redirect('index.php', JText::_('ALERTNOTAUTH'), 'error');
            }
            // Use the backend files of the insert view
            $this->_basePath = JPATH_COMPONENT_ADMINISTRATOR;
            $this->addViewPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'views');
            $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models');
            break;
        default:
            // There are no other views
            $this->redirect('index.php', JText::_('ALERTNOTAUTH'), 'error');
            break;
        }
        parent::display();
    }
}
