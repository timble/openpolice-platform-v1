<?php
/**
 * @version		$Id: view.html.php 1027 2008-07-06 22:46:07Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrgeneric.php');

/**
 * Ripper View
 *
 */
class AvReloadedViewRipper extends JView {
    /**
     * display method of Ripper view
     * @return void
     **/
    function display($tpl = null) {
        AvrGenericHelper::addCSS(
            '.icon-48-avreloaded {background-image:url('.
            JURI::root().'/administrator/components/com_avreloaded/assets/avreloaded-48x48.png);}');
        // get the Ripper
        $ripper	=& $this->get('Data');
        $isNew  = ($ripper->id < 1);
        $text = $isNew ? JText::_('New') : JText::_('Edit');
        JToolBarHelper::title($text.' '.JText::_('AVR_TITLE_RIPPER').' - AllVideos Reloaded', 'avreloaded');
        JToolBarHelper::save();
        if ($isNew)  {
            JToolBarHelper::cancel();
        } else {
            // for existing items the button is renamed `close`
            JToolBarHelper::apply();
            JToolBarHelper::cancel('cancel', 'Close');
        }
        JToolBarHelper::help('ripper', true);
        $this->assignRef('ripper', $ripper);
        parent::display($tpl);
    }
}
