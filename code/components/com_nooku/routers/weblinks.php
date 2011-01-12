<?php
/**
 * @version		$Id: weblinks.php 1121 2010-05-26 16:53:49Z johan $
 * @category	Nooku
 * @package 	Nooku_Site
 * @subpackage	Routers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Weblinks Router
 *
 * @author 		Johan Janssens <johan@joomlatools.org>
 * @category	Nooku
 * @package 	Nooku_Site
 * @subpackage	Routers
 */
class NookuRouterWeblinks
{
	public function encode(array $segments)
	{
		foreach($segments as $key => $value)  
		{
			if(strpos($value, ':') === false) {
				continue; 
			}
			
			list($id, $segments[$key]) = explode(':', $value);
		}
			
		return $segments;
	}
	
	public function decode(array $segments)
	{
		return $segments;
	}
	
	public function build(array $segments)
	{		
		return $segments;
	}
	
	public function parse(array $segments)
	{
		$model = KFactory::get('admin::com.nooku.table.nodes');
		
		list($alias) = explode(':', $segments['id']);
		
		if($segments['view'] == 'weblink') 
		{
			$id = $model->findByAlias($alias, 'weblinks')->id;
			$segments['id'] = $id.':'.$alias;
		}
				
		if($segments['view'] == 'category') 
		{	
			$id = $model->findByAlias($alias, 'categories', 'com_weblinks')->id;
			$segments['id'] = $id.':'.$alias;
		}
	
		return $segments;
	}
	
	public function translate(array $segments)
	{
		$model = KFactory::get('admin::com.nooku.table.nodes');
		
		list($id, $alias) = explode(':', $segments['id']);
		
		if($segments['view'] == 'weblink') 
		{
			$alias = $model->findById($id, 'weblinks')->alias;
			$segments['id'] = $id.':'.$alias;
		}
				
		if($segments['view'] == 'category') 
		{	
			$alias = $model->findById($id, 'categories', 'com_weblinks')->alias;
			$segments['id'] = $id.':'.$alias;
		}
	
		return $segments;
	}
}