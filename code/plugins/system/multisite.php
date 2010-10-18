<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin');

class plgSystemMultisite extends JPlugin
{
	public function onAfterInitialise()
	{
		//Define the sites folder
		define( 'JPATH_SITES',	JPATH_BASE.DS.'sites');
		
		//Load the default router first
		$router =& JFactory::getApplication()->getRouter('site');
			
		//Replace default with our custom router
		require_once(dirname(__FILE__).'/multisite/router.php');
		$router = new JRouterMultisite(array('mode' => $router->getMode())); 
	}
	
	public function onAfterRoute()
	{
		$app  = JFactory::getApplication();
		$site = $app->getRouter()->getSite();
		
		require_once( JPATH_SITES.'/'.$site.'/configuration.php');
		$config = JFactory::getConfig()->loadObject(new JConfigSite());	
		
		$database = JFactory::getDBO();
		$database->select($app->getCfg('db'));
		$database->setPrefix($app->getCfg('dbprefix'));
	}
}
