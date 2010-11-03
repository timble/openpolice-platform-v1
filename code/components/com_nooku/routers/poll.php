<?php
/**
 * @version		$Id: poll.php 1121 2010-05-26 16:53:49Z johan $
 * @category	Nooku
 * @package 	Nooku_Site
 * @subpackage	Routers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Poll Router
 *
 * @author 		Johan Janssens <johan@joomlatools.org>
 * @category	Nooku
 * @package 	Nooku_Site
 * @subpackage	Routers
 */
class NookuRouterPoll
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
		
		$id = $model->findByAlias($alias, 'polls')->id;
		$segments['id'] = $id.':'.$alias;
	
		return $segments;
	}
	
	public function translate(array $segments)
	{
		$model = KFactory::get('admin::com.nooku.table.nodes');
		
		list($id, $alias) = explode(':', $segments['id']);
		
		$alias = $model->findById($id, 'polls')->alias;
		$segments['id'] = $id.':'.$alias;
	
		return $segments;
	}
}