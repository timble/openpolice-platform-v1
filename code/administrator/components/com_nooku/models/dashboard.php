<?php
/**
 * @version		$Id: dashboard.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */


/**
 * Nooku Dashboard Model
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Administrator
 * @subpackage  Models
 */
class NookuModelDashboard extends KModelAbstract
{
    /**
     * Returns a list of newly added items
     *
     * @return array
     */
    public function getAdditions()
    {
        $db = KFactory::get('lib.joomla.database');
    	$query = $db->getQuery()
        	->select(array('n.*', 'u.name AS created_by_name'))
        	->from('nooku_nodes AS n')
        	->join('LEFT', 'users AS u', 'u.id = n.created_by')
        	->where('n.original', '=', '1')
        	->where('n.deleted' , '=', '0')
        	->order('created', 'DESC');
        
        $db->select($query, 0, 5);
        $list = $db->loadObjectList();
        return $list;
    }

    /**
     * Returns a list of recently changed (translated) items
     * 
     * @return array
     */
    public function getChanges()
    {
        $db = KFactory::get('lib.joomla.database');
        
    	$query = $db->getQuery()
        	->select(array('n.*', 'u.name AS modified_by_name'))
        	->from('nooku_nodes AS n')
        	->join('LEFT', 'users AS u', 'u.id = n.modified_by')
        	->where('n.deleted' , '=', '0')
        	->where('n.original' , '=', '0')
        	->where('n.status' , '!=', Nooku::STATUS_MISSING)
        	->order('n.modified', 'DESC');
        
        $db->select($query, 0, 5);
        $list = $db->loadObjectList();

        return $list;
    }

    /**
     * Returns a list of recently deleted items
     *
     * @return array
     */
    public function getDeletes()
    {
		$db = KFactory::get('lib.joomla.database');
		
    	$query = $db->getQuery()
        	->select(array('n.*', 'u.name AS modified_by_name'))
        	->from('nooku_nodes AS n')
        	->join('LEFT', 'users AS u', 'u.id = n.modified_by')
        	->where('n.deleted' , '=', '1')
        	->order('n.modified', 'DESC');
    	
        $db->select($query, 0, 5);
        $list = $db->loadObjectList();

        return $list;
    }
}
