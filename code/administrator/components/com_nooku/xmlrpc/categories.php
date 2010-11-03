<?php
/**
 * @version		$Id:categories.php 777 2008-10-19 22:18:08Z mathias $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Xmlrpc
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Category Xmlrpc Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Xmlrpc
 */
class NookuXmlrpcCategories extends KEventHandler  
{
	public function describe() 
	{
		global $xmlrpcI4, $xmlrpcInt, $xmlrpcBoolean, $xmlrpcDouble, $xmlrpcString, $xmlrpcDateTime, $xmlrpcBase64, $xmlrpcArray, $xmlrpcStruct, $xmlrpcValue, $xmlrpcDateTime;
		$services = array();
		
		$services['nooku.categories.retrieve'] = array(
			'function' 	=> 'NookuXmlrpcCategories::retrieve',
			'signature'	=> array(array($xmlrpcArray, $xmlrpcString))
		);

		return $services;
	}

	public function retrieve($limit) 
	{
		$db =& JFactory::getDBO();
		$bLimit = stristr($limit, "com_");

		if ($bLimit === false) {
			$query = "SELECT id, title, name, section, description, published "
				. "\nFROM #__categories "
				. "\nWHERE CHAR_LENGTH(section) < 4";
		} else {
			$query = "SELECT id, title, name, section, description, published "
				. "\nFROM #__categories "
				. "\nWHERE section = '" . $limit . "'";
		}

		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$structArray = array();

		foreach ($rows as $row) {
			$structArray[] = array(
				'id'				=> (int) $row->id,
				'title'			=> $row->title,
				'name'			=> $row->name,
				'section'		=> (int) $row->section,
				'description'	=> $row->description,
				'published'		=> (bool) $row->published
			);
		}

		if ($bLimit === false) {
			$structArray[] = array(
				'id'				=> 0,
				'title'			=> "Uncategorized",
				'name'			=> "Uncategorized",
				'section'		=> 0,
				'description'	=> "Uncategorized category",
				'published'		=> true);
		}

		return $structArray;
	}
}