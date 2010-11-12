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
 * Tag View
 *
 */
class AvReloadedViewTag extends JView {
    /**
     * display method of Ripper view
     * @return void
     **/
    function display($tpl = null) {
        AvrGenericHelper::addCSS(
            '.icon-48-avreloaded {background-image:url('.
            JURI::root().'/administrator/components/com_avreloaded/assets/avreloaded-48x48.png);}');
        // get the Tag
        $tag =& $this->get('Data');
        $isNew = ($tag->id < 1);
        $text = $isNew ? JText::_('New') : JText::_('Edit');
        JToolBarHelper::title($text.' '.JText::_('AVR_TITLE_TAG').' - AllVideos Reloaded', 'avreloaded');
        JToolBarHelper::save();
        if ($isNew)  {
            JToolBarHelper::cancel();
        } else {
            // for existing items the button is renamed `close`
            JToolBarHelper::apply();
            JToolBarHelper::cancel('cancel', 'Close');
        }
        JToolBarHelper::help('tag', true);
        // Build players combobox
        $list = array(JHTML::_('select.option',  '', '- '.JText::_('AVR_SELECT_PLAYER').' -'));
        $pmodel =& $this->getModel('players');
        $players = $pmodel->getData();
        foreach ($players as $p) {
            $pn = empty($p->description) ? $p->name : $p->description;
            $list[] = JHTML::_('select.option', $p->id, htmlspecialchars($pn));
        }
        $plist = JHTML::_('select.genericlist', $list, 'player_id',
            'class="inputbox" size="1" ', 'value', 'text', $tag->player_id);
        // Build rippers combobox
        $list = array(JHTML::_('select.option',  '', '- '.JText::_('AVR_SELECT_NONE').' -'));
        $rmodel =& $this->getModel('rippers');
        $rippers = $rmodel->getData();
        foreach ($rippers as $r) {
            $rn = empty($r->description) ? $r->name : $r->description;
            $list[] = JHTML::_('select.option', $r->id, htmlspecialchars($rn));
        }
        $rlist = JHTML::_('select.genericlist', $list, 'ripper_id',
            'class="inputbox" size="1" ', 'value', 'text', $tag->ripper_id);
        $imgarrow = 'components/com_avreloaded/assets/j_arrow.png';
        $imgdel = 'components/com_avreloaded/assets/delete.png';
        $altarrow = JText::_('AVR_ALT_REPLACEDBY', true);
        $ttdel = JText::_('AVR_DSC_DELPPREP', true);
        $this->assignRef('prtab', $this->_buildPra($tag->pra));
        $this->assignRef('tag', $tag);
        $this->assignRef('plist', $plist);
        $this->assignRef('rlist', $rlist);
        $this->assignRef('imgarrow', $imgarrow);
        $this->assignRef('imgdel', $imgdel);
        $this->assignRef('altarrow', $altarrow);
        parent::display($tpl);
    }

    function _buildPra(&$pra) {
        $ret = '<table id="prt">'."\n";
        if (is_array($pra) && (count($pra))) {
            $ret .= '<tr id="prtfirst"><td colspan="4"><img id="nnb" class="hasTip" '.
                'src="components/com_avreloaded/assets/new.png" '.
                'alt="" onclick="addprrow();" title="::'.JText::_('AVR_DSC_NEWPPREP').'" /></td></tr>';
            $i = 0;
            foreach ($pra as $search => $replace) {
                $ret .= "\n<tr><td>".
                    '<input class="text_area" type="text" name="pres[]" '.
                    'size="40" maxlength="255" value="'.htmlspecialchars($search).
                    '" /></td><td><img alt="'.JText::_('AVR_ALT_REPLACEDBY').'" src="'.
                    'components/com_avreloaded/assets/j_arrow.png" />'.
                    '</td><td><input class="text_area" type="text" name="prer[]" '.
                    'size="40" maxlength="255" value="'.htmlspecialchars($replace).
                    '" /></td><td><img class="hasTip" src="components/com_avreloaded/assets/delete.png" '.
                    ' title="::'.JText::_('AVR_DSC_DELPPREP').'" alt="" onclick="delprrow(this);"/></td>'."</td></tr>";
                $i++;
            }
        } else {
            $ret .= '<tr id="prtfirst"><td colspan="4"><span id="prtnone">'.
                JText::_('AVR_LBL_NONE').',&nbsp;</span><img id="nnb" class="hasTip" '.
                'src="components/com_avreloaded/assets/new.png" '.
                'alt="" onclick="addprrow();" title="::'.JText::_('AVR_DSC_NEWPPREP').'" /></td></tr>';
        }
        $ret .= "\n</table>\n";
        return $ret;
    }
}
