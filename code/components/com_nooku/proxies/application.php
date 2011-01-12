<?php
/**
 * @version		$Id: application.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Site
 * @subpackage  Proxies
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Application Object Proxy
 *
 * This object proxies the application object.  It allows us to proxy the methods
 * that we want and modify the way the system behaves based on that information.
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Site
 * @subpackage  Proxies
 */
class NookuProxyApplication extends KProxyJoomlaApplication
{
	/**
	 * The menu object
	 *
	 * @var	object
	 */
	protected static $_menu = null;		

	/**
	 * Proxy the application getMenu() method
	 *
	 * @access public
	 * @param  array	$options 	An optional associative array of configuration settings.
	 * @return object NookuProxyMenu.
	 */
	public function getMenu($name = null, $options = array())
	{
		if(!isset(self::$_menu))  {	
			self::$_menu = KFactory::get('site::com.nooku.proxy.menu', $options); 
		}
		
		return self::$_menu;
	}
	
	/**
	 * Proxy the application getRouter() method
	 *
	 * @param  array	$options 	An optional associative array of configuration settings.
	 * @return object NookuProxyRouter.
	 */
	public function getRouter($name = null, array $options = array())
	{	
		$router =& $this->_object->getRouter();
		
		if($router instanceof JRouter)
		{
			$router = KFactory::get('site::com.nooku.proxy.router', array(
				'mode' => $router->getMode(),
				'vars' => $router->getVars()
			));	
		}
		
		return $router;
	}
}