<?php
/**
 * @version		$Id: nooku.php 1126 2010-05-27 10:05:24Z johan $
 * @category   	Nooku
 * @package     Nooku_Plugins
 * @subpackage  System
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv2
 * @link     	http://www.nooku.org
 */

// Check if Koowa is active
if(!defined('KOOWA')){   
	return;
}

// Require the library loader
Koowa::import('admin::com.nooku.defines');

//import the dbo decorator
Koowa::import('admin::com.nooku.proxies.database');
Koowa::import('admin::com.nooku.proxies.language');
Koowa::import('com.nooku.proxies.application');

/**
 * Nooku System plugin
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Plugins
 * @subpackage  System
 */
class plgSystemNooku extends JPlugin
{
	public function __construct($subject, $config = array())
	{
		// Check if Koowa is active
		if(!defined('KOOWA')) {
    		return;
		}
		
		$db =& JFactory::getDBO();
		if($db instanceof KDatabase) 
		{
			//Create the application proxy object
			$app =& JFactory::getApplication();
			if($app instanceof KPatternProxy) {
				$app =& $app->getObject();
			}
			$app = new NookuProxyApplication($app);
		
			//Create the router proxy object (force load it)
			$router = $app->getRouter();
		
			//Create the database proxy object
			$db =& JFactory::getDBO();
			if($db instanceof KPatternProxy) {
				$db =& $db->getObject();
			}
			$db  = new NookuProxyDatabase($db);
			
			//Set the data in the database proxy
			$nooku = KFactory::get('admin::com.nooku.model.nooku');
			$db->setLanguages($nooku->getLanguages());
			$db->setTables($nooku->getTables());
			$db->setPrimaryLanguage($nooku->getPrimaryLanguage()->iso_code);
		
        	//Set the language
			$nooku->setLanguage();
		
			//Create the language proxy object
			$lang =& JFactory::getLanguage();
			$lang = new NookuProxyLanguage($lang);
	
			// Add 'metadata' to inflector cache
			KInflector::addWord('metadata', 'metadata');
        
			// Nooku is active
			define('NOOKU', 1);
		}

		parent::__construct($subject, $config);
	}
	
	/**
     * Register the nooku event handler and deal with legacy handling
	 * 
	 * We register the nooku event handler this as soon as possible to be able to react on all 
	 * applicatio events that are being fired.
	 */
	public function onAfterInitialise()
	{
		if(defined('NOOKU')) 
		{
			// This cannot be done in the constructor to prevent possible issue with plugin ordering.
        	if(defined('_JLEGACY') && (_JLEGACY == '1.0')) 
        	{
        		$database = & $GLOBALS['database'];
				$nooku = KFactory::get('admin::com.nooku.model.nooku');
				$database = new NookuProxyDatabase($database);
				$database->setLanguages($nooku->getLanguages());
				$database->setTables($nooku->getTables());
				$database->setPrimaryLanguage($nooku->getPrimaryLanguage()->iso_code);
        	}
		}
		
		$app   = KFactory::get('lib.joomla.application');
		$event = KFactory::get($app->getName().'::com.nooku.event.system');
		
		KFactory::get('lib.koowa.event.dispatcher')->register($event);
	}
	
	/**
	 * Register the component specific event handler
     * 
     * We can only do this after routing has occured since we relying on the component name
	 */
	public function onAfterRoute()
	{
		if(defined('NOOKU')) 
		{
			$component 	= JRequest::getCmd('option');
        	$app	   	= KFactory::get('lib.joomla.application'); 
        	$model      = KFactory::get('admin::com.nooku.model.components');
        
        	//Only register the event handler if the component is translatable
        	if($model->isTranslatable($component)) 
        	{
        		$identifier = $app->getName().'::com.nooku.event.'. substr( $component, 4 );;
        	
				/*
        	 	 * If the identifier does not exist, meaning the file could not be found
        	 	 * handle gracefull and continue 
        	 	 */
        	
        		try
        		{
					$event = KFactory::get($identifier);
        			KFactory::get('lib.koowa.event.dispatcher')->register($event);
        		
        		} catch(KFactoryException $e) { /*do nothing*/ }
     	   }
		}
	}
}