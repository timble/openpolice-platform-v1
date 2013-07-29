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

        $key       = "4DbI0vrQfmQqhZuIAp6NapeI92kEL8CJpb2n4vIT0aGeGiu0";
        $now       = time();

        $token = array(
            "jti"   => md5($now . rand()),
            "iat"   => $now,
            "name"  => $user->name,
            "email" => $user->email
        );

        $jwt = JWT::encode($token, $key);

		$application->redirect('http://support.lokalepolitie.be/access/jwt?jwt=' . $jwt);
	}
}