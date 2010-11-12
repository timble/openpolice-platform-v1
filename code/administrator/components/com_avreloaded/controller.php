<?php
/**
 * AllVideos Reloaded default controller
 * 
 * @version		$Id: controller.php 945 2008-06-09 17:28:15Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

jimport('joomla.application.component.controller');

/**
 * AllVideos Reloaded Component Controller
 */
class AvReloadedController extends JController
{
    /**
     * Method to display the view
     *
     * @access	public
     */
    function display()
    {
        $view = JRequest::getCmd('view', null);
        if ($view == 'tag') {
            $document =& JFactory::getDocument();
            $vt = $document->getType();
            $vl = JRequest::getCmd('layout', 'default');
            $v =& $this->getView($view, $vt, '', array('base_path'=>$this->_basePath));
            // Add players and rippers models to the view (no default!)
            $v->setModel($this->getModel('players'));
            $v->setModel($this->getModel('rippers'));
        }
        parent::display();
    }
}
