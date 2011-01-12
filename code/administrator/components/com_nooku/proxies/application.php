<?php
/**
 * @version		$Id: application.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
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
 * @package     Nooku_Administrator
 * @subpackage  Proxies
 */
class NookuProxyApplication extends KProxyJoomlaApplication
{	
	/**
	 * Proxy the application getRouter() method
	 *
	 * @param  array	$options 	An optional associative array of configuration settings.
	 * @return object NookuProxyRouter.
	 */
	public function getRouter($name = null, array $options = array())
	{	
		$router =& $this->getObject()->getRouter();
			
		if($router instanceof JRouter)
		{
			$router = KFactory::get('admin::com.nooku.proxy.router', array(
					'mode' => $router->getMode(),
					'vars' => $router->getVars()
			));
		}
		
		return $router;
	}
	
	/**
	 * Proxy the application route() method
	 */
	public function route()
	{
		// get the full request URI
		$uri = clone(JURI::getInstance());

		$router =& $this->getRouter();
		$result = $router->parse($uri);

		JRequest::set($result, 'get', true );
		
		parent::route();
	}
}