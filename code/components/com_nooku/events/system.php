<?php
/**
 * @version		$Id: system.php 1128 2010-06-22 15:20:08Z johan $
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Events
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku System Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Events
 */
class NookuEventSystem extends KEventHandler 
{
	public function onApplicationBeforeRender(ArrayObject $args)
	{
		$nooku = KFactory::get('admin::com.nooku.model.nooku');
		
		// Input
		$view 	   = KInput::get('view', 	array('post', 'get'), 'cmd');
		$task 	   = KInput::get('task', 	array('post', 'get'), null, 'cmd');
		$format    = KInput::get('format', 	array('post', 'get'), 'cmd', null, 'html');
		$component = KInput::get('option', 	array('post', 'get'), 'cmd');
		
		// onBeforeRender
		if( 'html' != $format || $task == 'edit') {
			return;
		}
		
		$table_name = 'menu';
		$row_id	    = KInput::get('Itemid', array('post', 'get'), 'int');
		
		if($view == 'article' && $component == 'com_content') {
			$table_name = 'content';
			$row_id	    = KInput::get('id', 'get', 'slug');
		}
 		
 		$query = KFactory::get('lib.joomla.database')->getQuery()
 					->select(array('m.*', 'n.*', 'm.nooku_node_id AS id'))
 					->from('nooku_metadata AS m')
 					->join('LEFT', 'nooku_nodes AS n', 'n.nooku_node_id = m.nooku_node_id')
            		->where('row_id', '=', $row_id)
            		->where('table_name', '=', $table_name)
            		->where('iso_code', '=', $nooku->getLanguage());
        $meta = KFactory::get('admin::com.nooku.table.metadata')->fetchRow($query);

		// get head data
		$doc 	= KFactory::get('lib.joomla.document');
		$head 	= $doc->getHeadData();
		
		$head['description'] 						
			= empty($meta->description)	? @$head['description'] : $meta->description;
		$head['metaTags']['standard']['keywords'] 	
			= empty($meta->keywords) 	? @$head['metaTags']['standard']['keywords'] : $meta->keywords;
		$head['metaTags']['standard']['author']   	
			= empty($meta->author) 		? @$head['metaTags']['standard']['author'] 	 : $meta->author;
		
		$doc->setHeadData($head);	
	}
	
	public function onApplicationAfterRender(ArrayObject $args)
	{
		$menu    = $args['notifier']->getMenu();
		$default = $menu->getDefault();

		//Replace src links
      	$base   = JURI::base();
		$buffer = JResponse::getBody();
    	$buffer = str_replace('<a href="'.$base.'"', '<a href="'.JRoute::_($default->link.'&Itemid='.$default->id).'"', $buffer);
		JResponse::setBody($buffer);
		
		return true;
	}
}