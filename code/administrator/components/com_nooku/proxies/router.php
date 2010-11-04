<?php
/**
 * @version		$Id: router.php 1121 2010-05-26 16:53:49Z johan $
 * @category	Nooku
 * @package 	Nooku_Administrator
 * @subpackage	Proxies
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

require_once(JPATH_ADMINISTRATOR.DS.'includes'.DS.'router.php');

/**
 * Router Proxy
 *
 * @author 		Johan Janssens <johan@joomlatools.org>
 * @category	Nooku
 * @package 	Nooku_Administrator
 * @subpackage	Proxies
 */
class NookuProxyRouter extends JRouterMultisite
{
	/**
	 * Class constructor
	 */
	public function __construct($options = array())
	{
		parent::__construct($options);
		
		if(array_key_exists('vars', $options)) {
			$this->_vars = $options['vars'];
		}
	}

	/**
	 * Proxy the router parse function to fix a bug in the core
	 *
	 * @param	object	$url	The URI to parse
	
	 * @return	array
	 */
	public function parse($uri)
	{
		$nooku = KFactory::get('admin::com.nooku.model.nooku');
		$app   = KFactory::get('lib.joomla.application');
		
		// Perform the actual parse
		$result = parent::parse($uri);
		$this->setVars($result);
		
		// Redirect if the language has changed
		$old = $nooku->getLanguage();
		$new = KInput::get('lang', array('post', 'get'), 'lang');
		
		if(isset($new) && strtolower($new) !=  strtolower($old))
		{
			//Set the language
			$nooku->setLanguage($new);
				
			if(KInput::getMethod() == 'POST')
			{
				$uri->setVar('lang', $new);
				$route = JRoute::_($uri->toString(), false);
				
				/*
				 * Dirty hack. Joomla URI class transforms cid[] into cid[0]
				 * 
				 * TODO : either fix in KUri or in the koowa javascript uri parser
				 */
				$route =  str_replace('cid[0]', 'cid[]', $route);
				$app->redirect($route);
			}
		}
					
		return $result;
	}
	
	/**
	 * Porxy the router build function to convert an internal URI to a route
	 *
	 * @param	string	$string	The internal URL
	 * @return	string	The absolute search engine friendly URL
	 */
	public function build($url)
	{
		return parent::build($url);
	}
}