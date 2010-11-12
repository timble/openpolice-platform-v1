<?php
/**
 * @version		$Id: insertbutton.php 1051 2008-07-19 20:06:43Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementInsertButton extends JElement {
    /**
     * Element name
     *
     * @access	protected
     * @var		string
     */
    var	$_name = 'InsertButton';

    /**
     * Render a button similar to an editor button
     *
     * @access protected
     * @param object The button to render,
     */
    function _renderButton($button) {
        $ret = '';
        if ($button->get('name')) {
            $modal = ($button->get('modal')) ? 'class="modal-button"' : null;
            $href = ($button->get('link')) ? 'href="'.$button->get('link').'"' : null;
            $onclick = ($button->get('onclick')) ? 'onclick="'.$button->get('onclick').'"' : null;
            $ret .= '<div class="button2-left"><div class="'.$button->get('name').'">'.
                '<a '.$modal.' title="'.$button->get('text').'" '.$href.' '.
                $onclick.' rel="'.$button->get('options').'">'.$button->get('text').'</a>'.
                '</div></div>'."\n";
        }
        return $ret;
    }

    /**
     * Render an insertbutton element
     *
     * @access public
     */
    function fetchElementImplicit($field, $label, $withjs = true) {
        if ($withjs) {
            $js =
                "// <![CDATA[
                function insertAtCursor(myField, myValue) {
                    if (document.selection) {
                        // IE support
                        myField.focus();
                        sel = document.selection.createRange();
                        sel.text = myValue;
                    } else if (myField.selectionStart || myField.selectionStart == '0') {
                        // MOZILLA/NETSCAPE support
                        var startPos = myField.selectionStart;
                        var endPos = myField.selectionEnd;
                        myField.value = myField.value.substring(0, startPos)
                            + myValue
                            + myField.value.substring(endPos, myField.value.length);
                    } else {
                        myField.value += myValue;
                    }
                }
                function jInsertEditorText(text, editor) {
                    insertAtCursor($(editor), text);
                }
                // ]]>
                ";
            $doc =& JFactory::getDocument();
            $doc->addScriptDeclaration($js);
        }
        JHTML::_('behavior.modal', 'a.modal-button');
        $link = 'index.php?option=com_avreloaded&amp;view=insert&amp;tmpl=component&amp;e_name='.$field;
        $button = new JObject();
        $button->set('modal', true);
        $button->set('link', $link);
        $button->set('text', JText::_($label));
        $button->set('name', 'image');
        $button->set('options', "{handler: 'iframe', size: {x: 600, y: 650}}");
        return JElementInsertButton::_renderButton($button);
    }

    function fetchElement($name, $value, &$node, $control_name) {
        $label = $node->attributes('buttonlabel') ? $node->attributes('buttonlabel') : '';
        $field = $control_name.$node->attributes('textfield');
        return $this->fetchElementImplicit($field, $label);
    }
}
