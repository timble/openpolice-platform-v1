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

        require_once JPATH_LIBRARIES.DS.'php-jwt'.DS.'Authentication'.DS.'JWT.php';

        $key       = "8Rs5RSUA4OL8luwHi3UCQp5U3hOIXWj3c2bvedRa3LvdmtfY";
        $now       = time();

        $token = array(
            "jti"   => md5($now . rand()),
            "iat"   => $now,
            "name"  => $user->name,
            "email" => $user->email
        );

        $jwt = JWT::encode($token, $key);

		$application->redirect('https://police.zendesk.com/access/jwt?jwt=' . $jwt);
	}
}