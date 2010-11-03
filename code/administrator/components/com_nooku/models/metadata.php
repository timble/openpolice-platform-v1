<?php
/**
 * @version     $Id: metadata.php 1121 2010-05-26 16:53:49Z johan $
 * @package     Nooku
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * Nooku metadata model
 * 
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @package     Nooku
 * @subpackage  Administrator
 * @version     1.0
 */
class NookuModelMetadata extends KModelTable
{
 	/**
 	 * Returns a row with keywords, description and author, based on the 
 	 * tablename and row_id from the nodes table
 	 * 
 	 * @return 	object
 	 */
 	public function getItem()
 	{
 		$nooku = KFactory::get('admin::com.nooku.model.nooku');
 		
 		$table_name     = KInput::get('table_name', array('get', 'post'), 'cmd');
 		$row_id         = KInput::get('row_id', array('get', 'post'), 'int');
 		
 		$query = $this->getDBO()->getQuery()
 					->select(array('m.*', 'n.*'))
 					->from('nooku_metadata AS m')
 					->join('RIGHT', 'nooku_nodes AS n', 'n.nooku_node_id = m.nooku_node_id')
            		->where('row_id', '=', $row_id)
            		->where('table_name', '=', $table_name);
        $result = $this->getTable()->fetchAll($query);
          
        //Get the row
       	$item = $result->findRow('iso_code', $nooku->getLanguage());
       	 	 	
        //If no existing row was found populate it
     	if(!$item->id) 
     	{
     		$original = $result->findRow('iso_code', $nooku->getPrimaryLanguage()->iso_code);
       		if($original->id)
       		{
        		$item->description	 = $original->description;
        		$item->keywords		 = $original->keywords;
        		$item->author		 = $original->author;
        	} 
       		else 
        	{
        		$app				 = KFactory::get('lib.joomla.application');
        		$item->description	 = $app->getCfg('MetaDesc');
        		$item->keywords		 = $app->getCfg('MetaKeys');
        		$item->author		 = KFactory::get('lib.joomla.user')->name;
        	}
        	
        	$item->table_name    = $table_name;
        	$item->row_id		 = $row_id;
     	}
       	  			
        return $item;
 	}
}