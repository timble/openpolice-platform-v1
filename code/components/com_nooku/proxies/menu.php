<?php
/**
 * @version		$Id: menu.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Site
 * @subpackage  Proxies
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

require_once(JPATH_SITE.DS.'includes'.DS.'menu.php');

/**
 * Nooku Menu Object Proxy
 *
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Site
 * @subpackage  Proxies
 */
class NookuProxyMenu extends JMenuSite
{
	/**
	 * Constructor
	 *
	 * @param	object	$router	The menu object to proxy
	 * @return	void
	 */
	public function __construct($menu) {
		parent::__construct($menu);
	}
	
	/**
	 * Loads the entire menu table into memory
	 */
	public function load()
	{
		$cache = KFactory::tmp('lib.joomla.cache', array('sys_menu', 'output'));
		if (!$data = $cache->get('items')) 
		{
			$db      = KFactory::get('lib.joomla.database');
			$nooku   = KFactory::get('admin::com.nooku.model.nooku');
			$primary = $nooku->getPrimaryLanguage();
			
			$lang = KInput::get('lang', array('post', 'get'), 'lang', null, $primary->iso_code);
		
			$sql	= 'SELECT m.*, c.`option` as component' .
				' FROM #__menu AS m' .
				' LEFT JOIN #__components AS c ON m.componentid = c.id'.
				' WHERE m.published = 1'.
				' ORDER BY m.sublevel, m.parent, m.ordering';
			$db->select($sql);
			$items = $db->loadObjectList('id');
			
			$query = $db->getQuery()
				->select(array('row_id', 'status'))
				->from('nooku_nodes')
				->where('table_name', '=', 'menu')
				->where('iso_code', '=', $lang);
        
			$db->select($query);
			$nodes = $db->loadObjectList('row_id');

			foreach($items as $item)
			{
				//Get parent information
				$parent_route = '';
				$parent_tree  = array();
				if(($parent = $item->parent) && (isset($items[$parent])) &&
					(is_object($items[$parent])) && (isset($items[$parent]->route)) && isset($items[$parent]->tree)) {
					$parent_route = $items[$parent]->route.'/';
					$parent_tree  = $items[$parent]->tree;
				}

				//Create tree
				array_push($parent_tree, $item->id);
				$item->tree   = $parent_tree;

				//Create route
				$route = $parent_route.$item->alias;
				$item->route  = $route;

				//Create the query array
				$url = str_replace('index.php?', '', $item->link);
				if(strpos($url, '&amp;') !== false){
			   		$url = str_replace('&amp;','&',$url);
				}
				
				//Set the item status
				$item->status = isset($nodes[$item->id]) ?  $nodes[$item->id]->status : Nooku::STATUS_UNKNOWN;

				parse_str($url, $item->query);
			}
				
           	$cache->store(serialize($items), 'items');
         	$this->_items = $items;
        } 
        else $this->_items = unserialize($data);
	}
}