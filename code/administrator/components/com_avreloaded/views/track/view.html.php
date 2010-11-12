<?php
/**
 * @version		$Id: view.html.php 1027 2008-07-06 22:46:07Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'elements'.DS.'insertbutton.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrgeneric.php');

/**
 * Track View
 */
class AvReloadedViewTrack extends JView {
    /**
     * Track view display method
     * @return void
     **/
    function display($tpl = null) {
        AvrGenericHelper::addCSS(
            '.icon-48-avreloaded {background-image:url('.
            JURI::root().'/administrator/components/com_avreloaded/assets/avreloaded-48x48.png);}');
        // Get data from the model
        $track =& $this->get('Track');
        $data = JRequest::getVar('data', '');
        $isNew = (empty($track->file));
        $text = $isNew ? JText::_('New') : JText::_('Edit');

        JToolBarHelper::title($text.' '.JText::_('AVR_TITLE_TRACK').' - AllVideos Reloaded', 'avreloaded');
        JToolBarHelper::save();
        if ($isNew)  {
            JToolBarHelper::cancel();
        } else {
            // for existing items the button is renamed `close`
            JToolBarHelper::cancel('cancel', 'Close');
        }
        JToolBarHelper::help('track', true);

        $list = array(JHTML::_('select.option', '', '- '.JText::_('AVR_SELECT_NONE').' -'));
        foreach (split(',','gif,flv,jpg,mp3,png,rtmp,swf') as $type) {
            $list[] = JHTML::_('select.option', $type, $type);
        }
        $types = JHTML::_('select.genericlist', $list, 'type',
            'class="inputbox" size="1" ', 'value', 'text', $track->type);
        $mbutton = JElementInsertButton::fetchElementImplicit(
            'mtext&playlist=1&noplists=1', JText::_('AVR Media'), false);
        $ibutton = $this->_imgButton();
        $root = AvrGenericHelper::rootURI(true).'/';
        $aloc = AvrGenericHelper::getAloc(true).'/';
        $vloc = AvrGenericHelper::getVloc(true).'/';
        $this->assignRef('types', $types);
        $this->assignRef('track', $track);
        $this->assignRef('data', $data);
        $this->assignRef('ibutton', $ibutton);
        $this->assignRef('mbutton', $mbutton);
        $this->assignRef('aloc', $aloc);
        $this->assignRef('vloc', $vloc);
        $this->assignRef('root', $root);
        parent::display($tpl);
    }

    function _imgButton() {
            $link = 'index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;e_name=pvi';
            JHTML::_('behavior.modal');
            $button = new JObject();
            $button->set('modal', true);
            $button->set('link', $link);
            $button->set('text', JText::_('Image'));
            $button->set('name', 'image');
            $button->set('options', "{handler: 'iframe', size: {x: 570, y: 400}}");

            $modal = ($button->get('modal')) ? 'class="modal-button"' : null;
            $href  = ($button->get('link')) ? 'href="'.$button->get('link').'"' : null;
            $onclick        = ($button->get('onclick')) ? 'onclick="'.$button->get('onclick').'"' : null;
            return "<div class=\"button2-left\"><div class=\"".$button->get('name').
                "\"><a ".$modal." title=\"".$button->get('text')."\" ".$href." ".$onclick.
                " rel=\"".$button->get('options')."\">".$button->get('text')."</a></div></div>\n";
    }
}
