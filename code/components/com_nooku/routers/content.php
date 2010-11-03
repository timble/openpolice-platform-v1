<?php
/**
 * @version		$Id: content.php 1121 2010-05-26 16:53:49Z johan $
 * @category	Nooku
 * @package 	Nooku_Site
 * @subpackage	Routers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Content Router
 *
 * @author 		Johan Janssens <johan@joomlatools.org>
 * @category	Nooku
 * @package 	Nooku_Site
 * @subpackage	Routers
 */
class NookuRouterContent
{
	public function encode(array $segments)
	{
		foreach($segments as $key => $value)  
		{	
			if(strpos($value, ':') === false) {
		    	continue;
		 	}
		 	
		 	if(strpos($value, ':') == 0) {
			    $segments[$key] = '';
			 } else {
			    list($id, $segments[$key]) = explode(':', $value);
		 	}
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
		
		if((int)$segments['id'] > 0) {
			return $segments;
		}
		
		if($segments['view'] == 'article')  
		{
			list($alias) = explode(':', $segments['id']);
			
			if(isset($segments['catid'])) 
			{
				list($catalias) = explode(':', $segments['catid']);
				$catid = $model->findByAlias($catalias, 'categories')->id;
				$segments['catid'] = $catid.':'.$catalias;
			}

			$id = $model->findByAlias($alias, 'content')->id;
			$segments['id'] = $id.':'.$alias;
		}
				
		if($segments['view'] == 'category') 
		{
			list($alias) = explode(':', $segments['id']);
			
			$item = JSite::getMenu()->getActive();
			
			$section = 0;
			if($item->query['view'] == 'section') {
				$section = $item->query['id'];
			} 
			
			$id = $model->findByAlias($alias, 'categories', $section)->id;
			$segments['id'] = $id.':'.$alias;
		}
		
		return $segments;
	}
	
	public function translate(array $segments)
	{
		$model = KFactory::get('admin::com.nooku.table.nodes');
		
		if(strpos($segments['id'], ':') === false) {
			return $segments;
		}
		
		if($segments['view'] == 'article')  
		{
			list($id, $alias) = explode(':', $segments['id']);
			
			if(isset($segments['catid'])) 
			{
				list($catid, $catalias) = explode(':', $segments['catid']);
				$catalias = $model->findById($catid, 'categories')->alias;
				$segments['catid'] = $catid.':'.$catalias;
			}

			$alias = $model->findById($id, 'content')->alias;
			$segments['id'] = $id.':'.$alias;
		}
				
		if($segments['view'] == 'category') 
		{
			list($id, $alias) = explode(':', $segments['id']);
			
			$section = 0;
			if($item->query['view'] == 'section') {
				$section = $item->query['id'];
			}
			
			$alias = $model->findById($id, 'categories', $section)->alias;
			$segments['id'] = $id.':'.$alias;
		}
		
		return $segments;
	}
}