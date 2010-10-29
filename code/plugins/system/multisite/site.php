<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

require_once(JPATH_BASE.'/includes/router.php');

class JRouterMultisite extends JRouterSite
{
	/*
	 * The site alias we are using.
	 * 
	 * @var mixed
	 */
	protected $_site = 'default';

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
			if(strlen($segments[0]) == 4)
			{
				$site = array_shift($segments);
				
				if(is_int((int) $site)) 
				{
					//Set the site
					$this->setSite($site);
			
					$uri->setPath('/'.implode('/', $segments));
				}
				else JError::raiseError(404, JText::_('Site not found'));
			}
		}
		
		//Redirect to the default menu item.
		if(empty($segments)) 
		{
			$menu = JSite::getMenu(true);
			JFactory::getApplication()->redirect(JRoute::_('index.php?Itemid='.$menu->getDefault()->id));
		}	
	
		return parent::parse($uri);
	}
	
	public function setSite($site) 
	{
		$this->_site = $site;
		
		//Load the site configuration
		require_once( JPATH_SITES.'/'.$site.'/configuration.php');
		$config = JFactory::getConfig()->loadObject(new JConfigSite());	
		
		//Set Database
		$database = JFactory::getDBO();
		$database->select($app->getCfg('db'));
		$database->setPrefix($app->getCfg('dbprefix'));

		//Force a reload on the menu
		if($app->getName() == 'site') { 
			$app->getMenu()->load();
		}
		
		return $this;
	}
	
	public function getSite()
	{
		return $this->_site;
	}
	
	public function _createURI($url)
	{
		$uri  = parent::_createURI($url);
		$site = $this->getSite();
		
		//Exception for the default site
		if($site != 'default') {
			$uri->setPath($uri->getPath().'/'.$site);
		}
		
		return $uri;
	}
}