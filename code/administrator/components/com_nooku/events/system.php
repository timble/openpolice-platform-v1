<?php
/**
 * @version		$Id: system.php 1139 2010-07-23 09:33:48Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

Koowa::import('admin::com.nooku.loader');

/**
 * Nooku Application Koowa Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 */
class NookuEventSystem extends KEventHandler 
{
	public function onDatabaseBeforeInsert(ArrayObject $args) 
	{
		//Check the language permissions based on the operation
		if(!$this->onAuthorize($args))
		{
			KFactory::get('lib.joomla.application')->redirect(
				KInput::get('HTTP_REFERER', 'server', 'internalurl'),
				JText::_('You are not allowed to perform this action'),
				'error'
			);
		}	
	}
	
	public function onDatabaseBeforeUpdate(ArrayObject $args) 
	{
		//Check the language permissions based on the operation
		if(!$this->onAuthorize($args))
		{
			KFactory::get('lib.joomla.application')->redirect(
				KInput::get('HTTP_REFERER', 'server', 'internalurl'),
				JText::_('You are not allowed to perform this action'),
				'error'
			);
		}	
	}
	
	public function onDatabaseBeforeDelete(ArrayObject $args) 
	{
		//Check the language permissions based on the operation
		if(!$this->onAuthorize($args))
		{
			KFactory::get('lib.joomla.application')->redirect(
				KInput::get('HTTP_REFERER', 'server', 'internalurl'),
				JText::_('You are not allowed to perform this action'),
				'error'
			);
		}	
	}
	
	public function onApplicationBeforeRender(ArrayObject $args) 
	{	
		$option = KInput::get('option', array('get', 'post'), 'cmd');
		$task   = KInput::get('task', 'post', 'cmd');
		
		if($option == 'com_installer' && $task == 'doInstall')
		{
			// Proxy the database object
			$db  =& JFactory::getDBO();
			if(!$db instanceof KDatabase) {
				$db  = new KDatabase($db);
			}
			
			//Sync the database tables
			$controller = KFactory::get('admin::com.nooku.controller.table');
			$controller->execute('syncInsert');
			
			//Set the database object back
			$db = $db->getObject();
		}
		
		if($option == 'com_installer' && $task == 'remove')
		{
			// Proxy the database object
			$db  =& JFactory::getDBO();
			if(!$db instanceof KDatabase) {
				$db  = new KDatabase($db);
			}
			
			//Sync the database tables
			$controller = KFactory::get('admin::com.nooku.controller.table');
			$controller->execute('syncDelete');
			
			//Set the database object back
			$db = $db->getObject();
		}
	}
	
	public function onApplicationBeforeRedirect(ArrayObject $args) 
	{	
		if(defined('NOOKU'))
		{
			//If we are applying a change stay on the same page
			$task = KInput::get('task', array('post', 'get'), 'cmd');
			
			if($task == 'save' || $task == 'cancel')   
			{
				//Get the URL in case a redirect was set
				$redirect = $args['notifier']->getUserState('nooku.redirect');
		
				//Get the referer and make sure it's an internal url
				$referer = KInput::get('HTTP_REFERER', 'server', 'internalurl');
		
				if($redirect && (strpos($referer, $redirect) == false))
				{
					//Unset the redirect, to make sure
					$args['notifier']->setUserState('nooku.redirect', null);
			
					//Set the url to the redirect
					$args['url'] = $redirect;
				}
			}
		}
	}
	
	public function onApplicationAfterRoute(ArrayObject $args) 
	{
		if(defined('NOOKU'))
		{
			if(KInput::getMethod() != 'POST') {
				return;
			}
		
			$nooku = KFactory::get('admin::com.nooku.model.nooku');
			
			$old = $nooku->getLanguage();
			$new = KInput::get('lang', array('post', 'get'), 'lang');
			
			//Set the language
			if(!empty($new) && $new !=  $old) {
				$nooku->setLanguage($new);
			}
		}
	}
	
	public function onAuthorize(ArrayObject $args)
	{
		if(defined('NOOKU'))
		{
			if(!$args['notifier']->isTableTranslatable($args['table'])) {
				return true;
			}
		
			$nooku = KFactory::get('admin::com.nooku.model.nooku');
			$languages = $nooku->getLanguages();
			$language  = $nooku->getLanguage();
			
			if(!($languages[$language]->operations & $args['operation'])) {
				return false;
			}
		}
		
		return true;
	}
	
}