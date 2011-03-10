<?php
jimport('joomla.application.component.controller');

class ZendeskController extends JController
{
	public function authenticate()
	{
		$application	= JFactory::getApplication();
		$user			= JFactory::getUser();

		if($user->gid < 24) {
			$application->redirect('index.php', JText::_('ALERTNOTAUTH'), 'error');
		}

		$token			= 'zZrkinswnaUzmFtQTGg5zblw3N7OOd7IElIRwo91n5rAOExl';
		$attributes		= array(
			'name'			=> $user->name,
			'email'			=> $user->email,
			'timestamp'		=> time()
		);

		$attributes['hash'] = md5($attributes['name'].$attributes['email'].$token.$attributes['timestamp']);

		foreach($attributes as $key => $value) {
			$url[] = $key.'='.urlencode($value);
		}

		$application->redirect('http://support.lokalepolitie.be/access/remote/?'.implode('&', $url));
	}
}