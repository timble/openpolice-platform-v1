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

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_HEADER, true);

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

		curl_setopt($curl, CURLOPT_URL, 'http://support.lokalepolitie.be/access/remote/?'.implode('&', $url));

		$result = curl_exec($curl);

		if(preg_match('/Set-Cookie: zendesk_user_version=([^;]*);/', $result, $matches)) {
			setcookie('zendesk_user_version', urldecode($matches[1]), 0, '/', '.lokalepolitie.be');
		}

		if(preg_match('/Set-Cookie: _zendesk_session=([^;]*);/', $result, $matches)) {
			setcookie('_zendesk_session', urldecode($matches[1]), 0, '/', '.lokalepolitie.be');
		}

		curl_close($curl);

		$application->redirect('http://support.lokalepolitie.be/home');
	}
}