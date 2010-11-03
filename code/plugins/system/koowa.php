<?php
/**
 * @version     $Id:koowa.php 251 2008-06-14 10:06:53Z mjaz $
 * @category	Koowa
 * @package     Koowa_Plugins
 * @subpackage  System
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPLv2
 * @link        http://www.koowa.org
 */

/**
 * Koowa System plugin
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package		Koowa
 */
class plgSystemKoowa extends JPlugin
{
	public function __construct($subject, $config = array())
	{
		set_exception_handler(array($this, 'exceptionHandler'));

		require_once JPATH_PLUGINS.DS.'system'.DS.'koowa'.DS.'koowa.php';
		require_once JPATH_PLUGINS.DS.'system'.DS.'koowa'.DS.'loader.php';

		// Proxy the application object
		$app  =& JFactory::getApplication();
		$app  = new KProxyJoomlaApplication($app);

		// Don't proxy the dataase if we are in com_installer
		if(KInput::get('option', array('get', 'post'), 'cmd') != 'com_installer')
		{
			// Proxy the database object
			$db  =& JFactory::getDBO();
			$db  = new KDatabase($db);

			//ACL uses the unwrapped DBO
	        $acl = JFactory::getACL();
	        $acl->_db = $db->getObject(); // getObject returns the unwrapped DBO
		}

		//Load the koowa plugins
		JPluginHelper::importPlugin('koowa', null, true, KFactory::get('lib.koowa.event.dispatcher'));

		parent::__construct($subject, $config = array());
	}

	/**
	 * Catch all exception handler
	 *
	 * Calls the Joomla error handler to process the exception
	 *
	 * @param object an Exception object
	 * @return void
	 */
	public function exceptionHandler($exception)
	{
		$this->_exception = $exception; //store the exception for later use

		//Change the Joomla error handler to our own local handler and call it
		JError::setErrorHandling( E_ERROR,	'callback', array($this,'errorHandler'));
		JError::raiseError('500', $exception->getMessage());
	}

	/**
	 * Custom JError callback
	 *
	 * Push the exception call stack in the JException returned through the call back
	 * adn then rener the custom error page
	 *
	 * @param object	A JException object
	 * @return void
	 */
	public function errorHandler($error)
	{
		$error->backtrace = $this->_exception->getTrace();
		JError::customErrorPage($error);
	}
}