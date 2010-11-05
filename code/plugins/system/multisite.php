<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin');

class plgSystemMultisite extends JPlugin
{
	public function onAfterRender()
	{
		$app  = JFactory::getApplication();
		$site = $app->getSite();
		
		//Exception for the default site
		if($site != 'default') 
		{
			if($app->isSite()) 
			{
				//Make images paths absolute
				$body = str_replace(JURI::base().'images/', JURI::root(true).'/sites/'.$site.'/images/', JResponse::getBody());
				$body = str_replace(array('"images/','"/images/') , '"/sites/'.$site.'/images/', $body);
			
				JResponse::setBody($body);
			}
		
			if($app->isAdmin()) 
			{
				//Make images paths absolute
				$body = str_replace(array('../images', './images'), JURI::root(true).'/sites/'.$site.'/images', JResponse::getBody());
				
				JResponse::setBody($body);
			}
		}
	}
}