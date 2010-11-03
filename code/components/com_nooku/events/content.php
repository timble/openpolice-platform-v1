<?php
/**
 * @version		$Id: content.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Events
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku System Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Events
 */
class NookuEventContent extends KEventHandler 
{
	public function onApplicationBeforeRedirect(ArrayObject $args) 
	{
		if(in_array(KInput::get('task', 'post', 'cmd'), array('save'))) 
		{	
			$id = KInput::get('id', array('get', 'post'), 'int');
			
			KInput::set('table_name', 'content', 'post');
			KInput::set('row_id', $id, 'post');
			
			$controller = KFactory::get('site::com.nooku.controller.metadata');
			$controller->execute('save');
		}
	}
}