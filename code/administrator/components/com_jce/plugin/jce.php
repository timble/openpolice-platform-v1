<?php
/**
 * @version   $Id: jce.php 110 2009-06-21 19:25:09Z happynoodleboy $
 * @package      JCE
 * @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author    Ryan Demmer
 * @license      GNU/GPL
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// Do not allow direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');
jimport('joomla.application.component.model');

/**
 * JCE WYSIWYG Editor Plugin
 *
 * @author Ryan Demmer <ryandemmer@gmail.com>
 * @package Editor - JCE
 * @since 1.5
 */
class plgEditorJCE extends JPlugin
{
    /**
	 * Constructor
	 *
	 * @access      public
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.5
	 */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
    }
    
    /**
     * Method to handle the onInit event.
     *  - Initializes the JCE WYSIWYG Editor
     *
     * @access public
     * @return string JavaScript Initialization string
     * @since 1.5
     */
    public function onInit()
    {
        $app 		= JFactory::getApplication();
		$language 	= JFactory::getLanguage();
        
    	// Check for existence of Admin Component
        if (!is_dir(JPATH_SITE . DS . 'components' . DS . 'com_jce') || !is_dir(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jce')) {
            JError::raiseWarning('SOME_ERROR_CODE', 'WF_COMPONENT_MISSING');
        }

        $language->load('plg_editors_jce', JPATH_ADMINISTRATOR);
        $language->load('com_jce', JPATH_ADMINISTRATOR);
        
        // set admin base path
        $base = JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jce';
        // load constants and loader
        require_once($base . DS . 'includes' . DS . 'base.php');
        // load model
        JModel::addIncludePath($base . DS . 'models');
        $model = JModel::getInstance('editor', 'WFModel');

        $model->buildEditor();        
    }
    
    /**
     * JCE WYSIWYG Editor - get the editor content
     *
     * @vars string   The name of the editor
     */
    public function onGetContent($editor)
    {
        //return "WFEditor.getContent('" . $editor . "');";
        return $this->onSave($editor);
    }
    
    /**
     * JCE WYSIWYG Editor - set the editor content
     *
     * @vars string   The name of the editor
     */
    public function onSetContent($editor, $html)
    {
        return "WFEditor.setContent('" . $editor . "','" . $html . "');";
    }
    
    /**
     * JCE WYSIWYG Editor - copy editor content to form field
     *
     * @vars string   The name of the editor
     */
    public function onSave($editor)
    {
        return "WFEditor.getContent('" . $editor . "');";
    }
    
    /**
     * JCE WYSIWYG Editor - display the editor
     *
     * @vars string The name of the editor area
     * @vars string The content of the field
     * @vars string The width of the editor area
     * @vars string The height of the editor area
     * @vars int The number of columns for the editor area
     * @vars int The number of rows for the editor area
     * @vars mixed Can be boolean or array.
     */
     public function onDisplay($name, $content, $width, $height, $col, $row, $buttons = true, $id = null, $asset = null, $author = null)
     {
        if (empty($id)) {
			$id = $name;
		}
        
        // Only add "px" to width and height if they are not given as a percentage
        if (is_numeric($width)) {
            $width .= 'px';
        }
        if (is_numeric($height)) {
            $height .= 'px';
        }
        
        if (empty($id)) {
            $id = $name;
        }
        
        $editor  = '<label for="' . $id . '" style="display:none;" aria-visible="false">' . $id . '_textarea</label><textarea id="' . $id . '" name="' . $name . '" cols="' . $col . '" rows="' . $row . '" style="width:' . $width . ';height:' . $height . ';" class="wfEditor source" wrap="off">' . $content . '</textarea>';
		$editor .= $this->_displayButtons($id, $buttons, $asset, $author);


		return $editor;
	}
    
    public function onGetInsertMethod($name)
    {
    }
    
	private function _displayButtons($name, $buttons, $asset, $author)
	{
		// Load modal popup behavior
		JHTML::_('behavior.modal', 'a.modal-button');

		$args['name'] = $name;
		$args['event'] = 'onGetInsertMethod';

		$return = '';
		$results[] = $this->update($args);

		foreach ($results as $result)
		{
			if (is_string($result) && trim($result)) {
				$return .= $result;
			}
		}

		if (is_array($buttons) || (is_bool($buttons) && $buttons)) {
			$results = $this->_subject->getButtons($name, $buttons, $asset, $author);

			/*
			 * This will allow plugins to attach buttons or change the behavior on the fly using AJAX
			 */
			$return .= "\n<div id=\"editor-xtd-buttons\">\n";

			foreach ($results as $button)
			{
				/*
				 * Results should be an object
				 */
				if ( $button->get('name') ) {
					$modal		= ($button->get('modal')) ? 'class="modal-button"' : null;
					$href		= ($button->get('link')) ? 'href="'.JURI::base().$button->get('link').'"' : null;
					$onclick	= ($button->get('onclick')) ? 'onclick="'.$button->get('onclick').'"' : 'onclick="IeCursorFix(); return false;"';
					$title      = ($button->get('title')) ? $button->get('title') : $button->get('text');
					$return .= "<div class=\"button2-left\"><div class=\"".$button->get('name')."\"><a ".$modal." title=\"".$title."\" ".$href." ".$onclick." rel=\"".$button->get('options')."\">".$button->get('text')."</a></div></div>\n";
				}
			}

			$return .= "</div>\n";
		}

		return $return;
	}
}
?>