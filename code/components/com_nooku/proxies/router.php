<?php
/**
 * @version		$Id: router.php 1121 2010-05-26 16:53:49Z johan $
 * @category	Nooku
 * @package 	Nooku_Site
 * @subpackage	Proxies
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

require_once(JPATH_SITE.DS.'includes'.DS.'router.php');

/**
 * Router Proxy
 *
 * @author 		Johan Janssens <johan@joomlatools.org>
 * @category	Nooku
 * @package 	Nooku_Site
 * @subpackage	Proxies
 */
class NookuProxyRouter extends JRouterMultisite
{
	/*
	 * The option (stored for each new call to build)
	 * 
	 * var string
	 */
	protected $_option = '';

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
		
		// Fool the parent in thinking we are coming in through index
		$path = $uri->getPath();
		$path = str_replace('index2.php', 'index.php', $path);
		$uri->setPath($path);
		
		// Perform the actual parse
		$result = parent::parse($uri);
		$result = $this->_parseSegments($result);
		$this->setVars($result);
		
		//Get the active languages
		$languages = $nooku->getLanguages();
		if(count($languages) > 1)
		{
		
			// Redirect if the language has changed
			if(KInput::getMethod() == 'POST')
			{
				$old = $nooku->getLanguage();
				$new = KInput::get('lang', array('post', 'get'), 'lang');
			
				if(isset($new) && strtolower($new) !=  strtolower($old))
				{
					//Set the language
					$nooku->setLanguage($new);
				
					//Force a reload on the menu
					$menu = $app->getMenu();
					$menu->load();
				
					$result = $this->_translateSegments($result);
					$this->setVars($result);
					
					$app->redirect(JRoute::_('&lang='.$new, false));
				}
			}

			//Set the language
			$nooku->setLanguage($result['lang']);
			
 			//Set language in case no language information cannot be found
			if(empty($result['lang']) && !is_null($result['lang'])) 
			{
				$result['lang'] = $nooku->getLanguage();
				$uri->setQuery($result);
				$this->setVars($result);
			
				/*
			 	 * Redirect if language information is empty
			  	 * 
			 	 * This fix was added to deal with forms that don't use JRoute in the action.
			 	 * for example mod_search.
			 	 */
				if(JRequest::getMethod() != 'POST') {
					$app->redirect(JRoute::_('index.php'.$uri->toString(array('query')), false));
				}
			}
			
		
			//Error : language cannot be found
			if(is_null($result['lang']) || !isset($languages[$result['lang']])) {
				throw new KProxyJoomlaException(JText::_("Language Not Found"));
			}
		}
				
		return $result;
	}
	
	/**
	 * Proxy the router processBuildRules functions
	 * 
	 * @return void
	 */
	public function _processBuildRules($uri)
	{	
		$nooku = KFactory::get('admin::com.nooku.model.nooku');
		
		$result = $this->_buildSegments($uri->getQuery(true));
		$uri->setQuery($result);
		
		// Get the option from the uri and store it
		$this->_option = $uri->getVar('option', $this->getVar('option'));
		
		//Get the active languages
		$languages = $nooku->getLanguages();
		if(count($languages) > 1)
		{
			// Get the language from the router
			$lang = $this->getVar('lang');
		
			//If the language was switched delete it from the request and switch it
			if($new = $uri->getVar('lang')) {
				$uri->delVar('lang');
				$lang = $new;
			}
		
			switch($this->getMode())
			{
				case JROUTER_MODE_RAW :
				{
					$uri->setVar('lang', $lang);
				} break;

				case JROUTER_MODE_SEF :
				{
					$languages = $nooku->getLanguages();
							
					// Get the path
					$path  = $uri->getPath();
					$alias =  $languages[$lang]->alias;

					$path = $path.'/'.$alias.'/';
					$uri->setPath($path);
				} break;
			}
		}
		
		parent::_processBuildRules($uri);
	}

	/**
	 * Parse route callback function
	 *
	 * @return	array
	 */
	public function _processParseRules($uri)
	{
		$vars =  parent::_processParseRules($uri);
		
		$lang  = null; //force to empty
		$nooku = KFactory::get('admin::com.nooku.model.nooku');
		
		switch($this->getMode())
		{
			case JROUTER_MODE_RAW :
			{
				$lang = $uri->getVar('lang', '');
			} break;

			case JROUTER_MODE_SEF :
			{
				$languages = $nooku->getLanguages();
				
				/*
				 * Try to find the language based on the first segment in thu URL
				 */
				$path     = $uri->getPath();
				$segments = explode('/', $path);
					
				/*
				 * If no path information exist, set the language to empty
				 */
				if(!empty($path)) 
				{
					$alias    = array_shift($segments);
					$aliases  = array_flip(KHelperArray::getColumn($languages, 'alias'));
					$lang     = isset($aliases[$alias]) ? $aliases[$alias] : null;
				} 
				else  $lang = '';
						
				/*
				 * Prepend the URL with the default alias and perform a re-route. If the result returns 
				 * option information the URL is valid and we assume the request doesn't contain any
				 * language information, otherwise the URL did contain language information.
				 */
				
				if(is_null($lang)) 
				{
					$primary = $nooku->getPrimaryLanguage();
					$url      = str_replace($path, $primary->alias.'/'.$path, JURI::current());
					
					$result = $this->parse(new JURI($url));
						
					if(isset($result['option'])) {
							$lang = '';
					}
				} 
							
				//Remove the language from the path
				if(!empty($lang))  {
					$uri->setPath(implode($segments, '/'));
				}
					
			} break;
		}
		
		//Force a reload the menu
		if(!empty($lang) && (strtolower($lang) !=  strtolower($nooku->getLanguage())))
		{
			//Set the language
			$nooku->setLanguage($lang);
					
			$menu = KFactory::get('lib.joomla.application')->getMenu();
			$menu->load();
		}
		
		$this->setVar('lang', $lang);
		
		return $vars;
	}
	
	public function _encodeSegments(array $segments)
	{	
		try
        {
			$router = KFactory::get('site::com.nooku.router.'. substr( $this->_option, 4 ));
			$segments = $router->encode($segments);
        } 
        catch(KFactoryException $e) {
        	$segments = parent::_encodeSegments($segments);
        }
        
		return $segments;
	}
	
	public function _decodeSegments(array $segments)
	{
		try
        {
			$router = KFactory::get('site::com.nooku.router.'. substr(  $this->getVar('option'), 4 ));
			$segments = $router->decode($segments);
        } 
        catch(KFactoryException $e) {
        	$segments = parent::_decodeSegments($segments);
        }
		
		return $segments;
	}
	
	protected function _buildSegments(array $segments)
	{
		if(isset($segments['id']) || isset($segments['catid'])) 
		{
			try
        	{
				$router = KFactory::get('site::com.nooku.router.'. substr(  $this->_option, 4 ));
				$segments = $router->build($segments);
        	} 
        	catch(KFactoryException $e) { }
		}
		
		return $segments;
	}
	
	protected function _parseSegments(array $segments)
	{
		if(isset($segments['id']) || isset($segments['catid'])) 
		{
			try
        	{
        		$router = KFactory::get('site::com.nooku.router.'. substr(  $this->getVar('option'), 4 ));
				$segments = $router->parse($segments);
        	} 
        	catch(KFactoryException $e) { }
		}
		
		return $segments;
	}
	
	protected function _translateSegments(array $segments)
	{
		if(isset($segments['id']) || isset($segments['catid'])) 
		{
			try
        	{
				$router = KFactory::get('site::com.nooku.router.'. substr( $this->getVar('option'), 4 ));
				$segments = $router->translate($segments);
        	} 
        	catch(KFactoryException $e) { }
		}
		
		return $segments;
	}
}