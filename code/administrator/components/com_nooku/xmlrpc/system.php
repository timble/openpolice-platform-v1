<?php
/**
 * @version		$Id:system.php 777 2008-10-19 22:18:08Z mathias $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Xmlrpc
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku System Xmlrpc Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Xmlrpc
 */
class NookuEventXmlrpcSystem extends KEventHandler  
{
	public function describe() 
	{
		global $xmlrpcI4, $xmlrpcInt, $xmlrpcBoolean, $xmlrpcDouble, $xmlrpcString, $xmlrpcDateTime, $xmlrpcBase64, $xmlrpcArray, $xmlrpcStruct, $xmlrpcValue, $xmlrpcDateTime;
		$services = array();
		
		$services['nooku.system.authenticate'] = array(
			'function' 	=> 'NookuXmlrpcSystem::authenticate',
			'signature'	=> array(array($xmlrpcBoolean, $xmlrpcString, $xmlrpcString))
		);

		$services['nooku.system.valid'] = array(
			'function' 	=> 'NookuXmlrpcSystem::valid',
			'signature'	=> array(array($xmlrpcBoolean))
		);
		
		return $services;
	}

	public function authenticate($username, $password)  {
		return true;
	}
	
	public function valid() {
		return true;
	}
}