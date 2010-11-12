<?php
/**
 * @version		$Id: view.html.php 1072 2009-05-03 02:23:14Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrgeneric.php');

/**
 * About View
 */
class AvReloadedViewAbout extends JView {
    /**
     * Tags view display method
     * @return void
     **/
    function display($tpl = null) {
        AvrGenericHelper::addCSS(
            '.icon-48-avreloaded {background-image:url('.
            JURI::root().'/administrator/components/com_avreloaded/assets/avreloaded-48x48.png);}');
        JToolBarHelper::title('About - AllVideos Reloaded', 'avreloaded');
        JToolBarHelper::help('about', true);
        $changelog = JURI::root().'/administrator/components/com_avreloaded/assets/ChangeLog.html';
        $lang =& JFactory::getLanguage();
        $tag = $lang->getTag();
        $welcome = JPATH_COMPONENT_ADMINISTRATOR.DS.'assets'.DS.$tag.'.welcome.html';
        if (!file_exists($welcome))
            $welcome = JPATH_COMPONENT_ADMINISTRATOR.DS.'assets'.DS.'en-GB.welcome.html';
        $this->assignRef('welcome', $welcome);
        $this->assignRef('changelog', $changelog);
        parent::display($tpl);
    }
}
