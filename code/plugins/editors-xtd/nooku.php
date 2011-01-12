<?php
/**
 * @version		$Id: nooku.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Plugins
 * @subpackage  Editor-Xtd
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv2
 * @link     	http://www.nooku.org
 */

Koowa::import('admin::com.nooku.defines');

/**
 * Nooku Editors-xtd plugin
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Plugins
 * @subpackage  Editor-Xtd
 */
class plgButtonNooku extends JPlugin
{
	/**
	 * Handle the onDisplay event for the button
	 *
	 * @return object A JObject containing the button settings
	 */
	function onDisplay($name)
	{
		if(!KFactory::get('admin::com.nooku.model.permissions')->canTranslate()
			|| KInput::get('option', array('post', 'get'), 'cmd') != 'com_content'
			|| KInput::get('task', array('post', 'get'), 'cmd') != 'edit') 
		{
			return new JObject();
		}
		
		KViewHelper::_('behavior.modal');

		$doc = KFactory::get('lib.joomla.document');
		$css =  ' .button2-left .translate { '
			   .' 	background:transparent url( '.Nooku::getURL('media').'images/button_translate.png) no-repeat scroll 100% 0pt;'
			   .' } ';
		$doc->addStyleDeclaration($css);

		$cid = KInput::get('cid', array('post', 'get'), 'array.ints');
		$cid = (int) $cid[0];
		
		if($cid === 0) {
			$cid = KInput::get('id', array('post', 'get'), 'string', 'int');
		}

		$button = new JObject();
		$button->set('modal', true);
		$button->set('link', JRoute::_('index.php?option=com_nooku&amp;view=translate&amp;tmpl=component&amp;id='.$cid.'&amp;editor='.$name));
		$button->set('text', JText::_('Translate'));
		$button->set('name', 'translate');
		$button->set('options', "{handler: 'iframe', size: {x: 900, y: 600}}");

		return $button;
	}
}
