<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin');

class plgSystemMultisite extends JPlugin
{
	public function onAfterInitialise()
	{
		$app = JFactory::getApplication();
		
		//Define the sites folder
		define( 'JPATH_SITES',	JPATH_ROOT.DS.'sites');
		
		//Load the default router first
		$router =& $app->getRouter();
				
		//Replace default with our custom router
		require_once(dirname(__FILE__).'/multisite/'.$app->getName().'.php');
		$router = new JRouterMultisite(array('mode' => $router->getMode())); 
	}
	
	public function onAfterRoute()
	{
		$app  = JFactory::getApplication();
		$user = JFactory::getUser();
		
		//Perform Route
		if($app->getName() == 'administrator') {
			$app->getRouter()->parse(clone(JURI::getInstance()));
		}
		
		//Load Config
		$site = $app->getRouter()->getSite();
		
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
		
		//Re-login
		if($app->getUserState('application.site') != $site && !$user->get('guest'))
		{
			// Fork the session to prevent session fixation issues
			$session = JFactory::getSession();
			$session->fork();
			
			$app->_createSession($session->getId());
			
			// Import the user plugin group
			JPluginHelper::importPlugin('user');

			$response = array(
				'username' 		=> $user->get('username'),
				'email'	   		 => $user->get('username'),
				'fullname' 		 => $user->get('fullname'),
				'password_clear' => ''
			);
			
			$options = array(
				'group' 		=> 'Public Backend',
				'autoregister' 	=> false,
			);
			
			$results = $app->triggerEvent('onLoginUser', array($response, $options));
			
			if(JError::isError($results[0])) 
			{
				$app->triggerEvent('onLoginFailure', array((array)$response));
				
				//Log the user out
				$app->logout();
			}
		}
		
		// Set session
		JFactory::getApplication()->setUserState('application.site', $site);
	}
	
	public function onAfterRender()
	{
		$app  = JFactory::getApplication();
		$site = $app->getRouter()->getSite();
		
		//Exception for the default site
		if($site == 'default') {
			$site = '';
		}
		
		if($app->getName() == 'site' && !empty($site)) 
		{
			//Make images paths absolute
			$body = str_replace('"images/', '"sites/'.$site.'/images/', JResponse::getBody());
				
			JResponse::setBody($body);
		}
		
		if($app->getName() == 'administrator' && !empty($site)) 
		{
			$index = $app->getCfg('sef_rewrite') ? ''  : 'index.php/';
			
			//Make images paths absolute
			$body = str_replace(array('../images', './images'), JURI::root(true).'/sites/'.$site.'/images', JResponse::getBody());
			
			//Make links absolute
			$body = str_replace('index.php/'.$site, 'index.php', $body);
			$body = str_replace('index.php', JURI::base(true).'/'.$index.$site, $body);
			
			JResponse::setBody($body);
		}
	}
}