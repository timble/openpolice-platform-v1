<?php
/**
 * @version		$Id: nooku.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Plugins
 * @subpackage  Xmlrpc
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPLv2
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Xmlrpc plugin
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Plugins
 * @subpackage  Xmlrpc
 */
class plgXMLRPCNooku extends JPlugin
{
	public function __construct($subject, $config = array())
	{
		define('JPATH_COMPONENT', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_nooku');
	
		require_once JPATH_PLUGINS.DS.'system'.DS.'koowa'.DS.'koowa.php';
		require_once JPATH_PLUGINS.DS.'system'.DS.'koowa'.DS.'loader.php';
		
		parent::__construct($subject, $config = array());
	}

	/**
	 * Proxy for the onGetWebServices
	 * 
	 * Will call describe for each xmlrpc event handler and return the results to
	 * the xmlrpc server.
	 * 
	 * @return array An array of associative arrays defining the available methods
	 */
	function onGetWebServices()
	{
		$services = array();	
	
		//Get the event dispatcher
		$dispatcher = KFactory::get('lib.koowa.event.dispatcher');
		
		$path = JPATH_COMPONENT.DS.'xmlrpc';
		$dir  = new DirectoryIterator($path);
		foreach($dir as $file) 
		{
    		//Make sure we found a valid file
			if($file->isDot() || in_array($file->getFilename(), array('.svn', 'index.html'))) {
        		continue;
    		}
    		
    		$filename = basename($file->getFilename(), ".php");
    		
    		//Load the event handler
    		Koowa::import('admin::com.nooku.xmlrpc.'.$filename);
    		
    		//Register the event handler
    		$dispatcher->register('NookuXmlrpc'.ucfirst($filename));
		}
		
		$results = $dispatcher->dispatch('describe',  new ArrayObject());
	
		foreach($results as $result) {
			foreach($result as $key => $value) {
				$services[$key] = $value;
			}
		}
		
		return $services;
	}
}