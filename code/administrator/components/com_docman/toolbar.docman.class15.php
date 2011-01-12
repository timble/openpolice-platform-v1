<?php
/**
 * @version		$Id: toolbar.docman.class15.php 1165 2010-02-01 21:54:15Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
* MenuBar class
* @package DOCman_1.5
* */
class dmToolBar {

    function logo(){
        //JToolBarHelper::title('DOCman');
    }

    /**
    * Writes the start of the button bar table
    */
    function startTable() {
    }

    /**
    * Writes a spacer cell
    * @param string The width for the cell
    */
    function spacer( $width='' ) {
        JToolBarHelper::spacer($width);
    }

    /**
    * Write a divider between menu buttons
    */
    function divider() {
        JToolBarHelper::divider();
    }

    /**
    * Writes the end of the menu bar table
    */
    function endTable() {
    }

    /**
    * Writes a common icon button
    * @param string The task
    * @param string The alt text
    * @param string The icon name
    */
    function icon( $task, $alt, $icon) {
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Standard', $icon, $alt, $task, false, false );
    }

    function save($task='save', $alt=_DML_TOOLBAR_SAVE, $icon='dm_save') {
        dmToolBar::icon($task, $alt, $icon);
    }
    function apply($task='apply', $alt=_DML_TOOLBAR_APPLY, $icon='dm_apply') {
        dmToolBar::icon($task, $alt, $icon);
    }

    function cancel($task='cancel', $alt=_DML_TOOLBAR_CANCEL, $icon='dm_cancel' ) {
        dmToolBar::icon($task, $alt, $icon);
    }

    function addNew($task = 'new', $alt = _DML_TOOLBAR_NEW, $icon = 'dm_newdocument') {
        dmToolBar::icon($task, $alt, $icon);
    }
    function addNewDocument($task = 'new', $alt = _DML_TOOLBAR_NEW_DOC, $icon = 'dm_newdocument') {
        dmToolBar::icon($task, $alt, $icon);
    }

    function cpanel() {
        dmToolBar::icon('cpanel', _DML_TOOLBAR_HOME, 'dm_cpanel');
    }

    function upload($task = 'upload', $alt = _DML_TOOLBAR_UPLOAD, $icon = 'dm_upload') {
        dmToolBar::icon($task, $alt, $icon);
    }

    function move($task = 'move', $alt = _DML_TOOLBAR_MOVE, $icon='dm_move') {
        dmToolBar::icon($task, $alt, $icon);
    }

    function copy($task = 'copy', $alt = _DML_TOOLBAR_COPY, $icon='dm_copy') {
        dmToolBar::icon($task, $alt, $icon);
    }

    function sendEmail(){
        dmToolBar::icon('sendemail', _DML_TOOLBAR_SEND, 'dm_sendemail');

    }

    /**
    * Writes a cancel button that will go back to the previous page without doing
    * any other operation
    */
    function back($task = 'back', $alt = _DML_TOOLBAR_BACK, $href="javascript:window.history.back();", $icon='dm_back') {
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Link', $icon, $alt, $href );
    }

    /**
    * Writes a common icon button for a list of records
    * @param string The task
    * @param string The alt text
    * @param string The icon name
    */
    function iconList( $task, $alt, $icon='dm_edit') {
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Standard', $icon, $alt, $task, true, false );
    }

    function iconListConfirm( $task, $alt, $icon='dm_edit' ) {
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Confirm', _DML_ARE_YOU_SURE, $icon, $alt, $task, true, false );
    }

    function publishList($task='publish', $alt=_DML_TOOLBAR_PUBLISH, $icon='dm_publish') {
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Standard', $icon, $alt, $task, true, false );
    }

    function unpublishList($task='unpublish', $alt=_DML_TOOLBAR_UNPUBLISH, $icon='dm_unpublish') {
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Standard', $icon, $alt, $task, true, false );
    }

    function deleteList($task='remove', $alt=_DML_TOOLBAR_DELETE, $icon='dm_delete') {
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Confirm', _DML_ARE_YOU_SURE, $icon, $alt, $task, true, false );
    }
    function clear($task='remove', $alt=_DML_TOOLBAR_CLEAR) {
        dmToolBar::deleteList($task, $alt, 'dm_cleardata');
    }
    function editList($task='edit', $alt=_DML_TOOLBAR_EDIT, $icon='dm_edit') {
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Standard', $icon, $alt, $task, true, false );
    }

    function editCss( $task='edit_css', $alt=_DML_TOOLBAR_EDIT_CSS, $icon='dm_editcss') {
        dmToolBar::icon($task, $alt, $icon);
    }

    function help()
    {
        $bar = & JToolBar::getInstance('toolbar');
        $bar->appendButton( 'Dmexternal', 'dm_help', 'Support', _DM_HELP_URL);
    }

}

// include JButtonLink so we can extend it
JToolbar::getInstance()->loadButtonType('link');

/**
 * Same as JButtonLink but opening in a new window
 */
class JButtonDmexternal extends JButtonLink
{
	var $_name = 'Dmexternal';

	function fetchButton( $type='Dmexternal', $name = 'back', $text = '', $url = null )
	{
		$text	= JText::_($text);
		$class	= $this->fetchIconClass($name);
		$doTask	= $this->_getCommand($url);

		$html	= "<a href=\"$doTask\" target=\"_blank\">\n";
		$html .= "<span class=\"$class\" title=\"$text\">\n";
		$html .= "</span>\n";
		$html	.= "$text\n";
		$html	.= "</a>\n";

		return $html;
	}
}