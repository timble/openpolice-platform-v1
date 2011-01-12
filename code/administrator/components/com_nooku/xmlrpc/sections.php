<?php
/**
 * @version		$Id:sections.php 777 2008-10-19 22:18:08Z mathias $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Xmlrpc
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Section Xmlrpc Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Xmlrpc
 */
class NookuXmlrpcSections extends KEventHandler  
{
	public function describe() 
	{
		global $xmlrpcI4, $xmlrpcInt, $xmlrpcBoolean, $xmlrpcDouble, $xmlrpcString, $xmlrpcDateTime, $xmlrpcBase64, $xmlrpcArray, $xmlrpcStruct, $xmlrpcValue, $xmlrpcDateTime;
		$services = array();
		
		$services['nooku.sections.retrieve'] = array(
			'function' 	=> 'NookuXmlrpcSections::retrieve',
			'signature'	=> array(array($xmlrpcArray, $xmlrpcString))
		);

		return $services;
	}
	
	/**
 	* Returns array of sections
 	*
 	* @param xmlrpcmsg XML-RPC message passed to the method
 	* @return xmlrpcresp XML-RPC response
 	*/
	public function retrieve($scope) 
	{
		global $xmlrpcArray, $xmlrpcBoolean, $xmlrpcStruct, $xmlrpcString, $xmlrpcInt;
		$db =& JFactory::getDBO();

		$query =  "SELECT id, title, name, description, published "
			. "\nFROM #__sections "
			. "\nWHERE scope = '$scope' ";

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		$structArray = array();
		foreach ($rows as $row) {
			$structArray[] = array(
			    'id'      		=> (int) $row->id,
			    'title'   		=> $row->title,
			    'name' 			=> $row->name,
			    'description' 	=> $row->description,
		         'published'		=> (bool) $row->published
		 	);
		}

		$structArray[] = array(
			    'id'      		=> 0,
			    'title'   		=> "Uncategorized",
			    'name' 			=> "Uncategorized",
			    'description' 	=> "Uncategorized section",
			    'published'		=> (bool) $row->published
		 	);

		return $structArray;
	}
}