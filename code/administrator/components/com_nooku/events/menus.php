<?php
/**
 * @version		$Id: menus.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Menus Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 */
class NookuEventMenus extends KEventHandler 
{	
	public function onDatabaseAfterInsert(ArrayObject $args) 
	{
		$language = KFactory::get('admin::com.nooku.model.nooku')->getLanguage();
		$row_id   = KInput::get('row_id', 'post', 'int');
		
		if($args['table'] == 'nooku_nodes' && $args['data']['iso_code'] == $language && empty($row_id)) {
			KInput::set('row_id', $args['data']['row_id'], 'post');
		}
		
		//Clean the menu cache
		JFactory::getCache('mod_mainmenu')->clean();
	}
	
	public function onDatabaseAfterUpdate(ArrayObject $args)
	{
		//Clean the menu cache 
		JFactory::getCache('mod_mainmenu')->clean();
	}
	
	public function onApplicationBeforeRedirect(ArrayObject $args) 
	{
		if(in_array(KInput::get('task', 'post', 'cmd'), array('save', 'apply'))) 
		{
			$controller = KFactory::get('admin::com.nooku.controller.metadata');
			$controller->execute('save');
		}
	}
	
	public function onApplicationAfterDispatch(ArrayObject $args)
	{
		if(KInput::get('task', 'get', 'cmd') == 'edit') 
		{
			$doc = KFactory::get('lib.joomla.document');
			$doc->addScript( Koowa::getUrl('js').'koowa.js');
			$doc->addScript( Nooku::getUrl('js').'ajax.metadata.menus.js');
		}
	}
	
	public function onApplicationAfterRender(ArrayObject $args)
	{
		// only insert the js when editing a menu item
		if( KInput::get('task', 'get', 'cmd') == 'edit') 
		{
			$buffer = JResponse::getBody();
    		$buffer = str_replace('new Accordion', 'document.accordion = new Accordion', $buffer);
			JResponse::setBody($buffer);
		}
	}
}