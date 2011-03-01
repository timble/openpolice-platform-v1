<?php
jimport('joomla.plugin.plugin');

class plgUserZendesk extends JPlugin
{
	public function onBeforeStoreUser($user, $new)
	{
		$name	= JRequest::getVar('name', '', 'post', 'string');
		$email	= JRequest::getVar('email', '', 'post', 'string');
		$group	= JRequest::getVar('gid', '', 'post', 'int');

		if(($new && $group >= 24) || (!$new && $user['gid'] < 24 && $group >= 24 && !$this->_find($user['email'])))
		{
			$method	= 'POST';
			$url	= 'users.xml';
		}
		elseif(!$new && ($user['email'] != $email || $user['name'] != $name
			|| ($user['gid'] < 24 && $group >= 24 && ($user['email'] != $email || $user['name'] != $name))))
		{
			if($item = $this->_find($user['email']))
			{
				$method	= 'PUT';
				$url	= 'users/'.$item->id.'.xml';
			}
		}
		else {
			return;
		}

		$xml[] = '<user>';
		$xml[] = '<name>'.$name.'</name>';
		$xml[] = '<email>'.$email.'</email>';
		$xml[] = '</user>';

		$this->_request($method, $url, implode(PHP_EOL, $xml));
	}

	public function onAfterDeleteUser($user, $success, $message)
	{
		if($success && $item = $this->_find($user['email'])) {
			$this->_request('DELETE', 'users/'.$item->id.'.xml');
		}
	}

	protected function _find($email)
	{
		$result	= $this->_request('GET', 'users.xml?query='.$email);
		$xml	= new SimpleXMLElement($result);

		if((int) $xml['count'])
		{
			foreach($xml->user as $user)
			{
				if((string) $user->email == $email) {
					return $user;
				}
			}
		}

		return false;
	}

	protected function _request($method, $url, $xml = null)
	{
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_USERPWD, 'account@timble.net:timblian456zen');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_URL, 'http://support.lokalepolitie.be/'.$url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

		if(!empty($xml))
		{
			$headers = array(
				'Content-type: application/xml',
				'Content-Length: '.strlen($xml)
			);

			curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		}

		$result = curl_exec($curl);
		curl_close($curl);

		return $result;
	}
}