<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

require_once(JPATH_BASE.'/includes/router.php');

class JRouterMultisite extends JRouterAdministrator
{
	/*
	 * The site alias we are using.
	 * 
	 * @var mixed
	 */
	protected $_site;

	public function parse(&$uri)
	{
		$path = trim(str_replace(array(JURI::base(true), 'index.php'), '', $uri->getPath()), '/');
		
		$segments = array();
		if(!empty($path)) {
			$segments = explode('/', $path);
		}
		
		if(!empty($segments))
		{		
			//Check to see if we found a matching site number
			if(is_int((int) $segments[0]) && strlen($segments[0]) == 4)
			{
				$site = array_shift($segments);
				
				//Set the site
				$this->setSite($site);
			
				$uri->setPath('/'.implode('/', $segments));
				
			} else JError::raiseError(404, JText::_('Site not found'));
		} 
		else $this->setSite('default');
		
		
		return parent::parse($uri);
	}
	
	public function setSite($site) 
	{
		$app = JFactory::getApplication();
			
		//Load the site configuration
		require_once( JPATH_SITES.'/'.$site.'/configuration.php');
		$config = JFactory::getConfig()->loadObject(new JConfigSite());	
		
		//Set Database
		$database = JFactory::getDBO();
		$database->select($app->getCfg('db'));
		$database->setPrefix($app->getCfg('dbprefix'));
		
		//Force a reload on the plugins
		JPluginHelper::load(true);
		
		//Set the site in the router
		$this->_site = $site;

		return $this;
	}
	
	public function getSite()
	{
		//Get the site from the session
		if(empty($this->_site)) {
			$this->_site = 'default';
		}
			
		return $this->_site;
	}
	
	public function _createURI($url)
	{
		$uri  = parent::_createURI($url);
		$site = $this->getSite();
		$path = $uri->getPath();
		
		if(JFactory::getApplication()->getCfg('sef_rewrite')) {
			$path = str_replace('index.php', '', $path);
		}
		
		//Exception for the default site
		if($site != 'default') {
			$uri->setPath(empty($path) ? $site : $path.'/'.$site);
		}
		
		return $uri;
	}
}