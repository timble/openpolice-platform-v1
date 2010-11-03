<?php
/**
 * @version		$Id: nodes.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Tables
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Nodes Table
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Tables
 */
class NookuTableNodes extends KDatabaseTableAbstract
{
    public function update( $data, $rows = null)
    {
        // we didn't get the id of the log item, so we find it ourselves
		if(!$rows) 
		{
            $params = array(
            	'iso_code' 		=> $data['iso_code'],
                'table_name' 	=> $data['table_name'],
               	'row_id' 		=> $data['row_id']
            );
            
            $rows = (array) $this->findByConditions($params)->nooku_node_id;
        }
        return parent::update($data, $rows);
    }

    /**
     * Returns the node based on an array of conditions
     *
     * @param	array	Array of conditions
     * @return	object 	The node object
     */
    public function findByConditions($conditions)
    {
    	$query = $this->getDBO()->getQuery();
		$query->select('*');
		$query->from('nooku_nodes');

		foreach($conditions as $property => $value) {
			$query->where($property, '=', $value);
		}

        $this->_db->select($query);
		$result = $this->_db->loadObject();
        return $result;
    }
    
    /**
     * Returns the node based on an alias and a table
     *
     * @param	string	$alias		Nodes alias to search for
     * @param	string	$table		Nodes table_name to search for
     * @param   string  $section	If table is categories, the section to search in 
     * @return	object 	The row object
     */
	public function findByAlias($alias, $table, $section = '')
	{
		//We need to add #__ as the prefix to allow translating of the query
		$query = $this->getDBO()->getQuery()
        	->where('alias', '=', $alias);
        
        //Exception for categories
        if($table == 'categories') 
        {
        	if(!empty($section)) {
        		$query->where('section', '=', $section);
        	} else {
        		$query->where('section', '>', 0);
        	}
        }
 
        $table = new KDatabaseTableDefault(array('table_name' => $table));
        $result = $table->fetchRow($query);
        
        return $result;
	}
	
	/**
     * Returns the node based on an alias and a table
     *
   	 * @param	string	$alias		Nodes alias to search for
     * @param	string	$table		Nodes table_name to search for
     * @param   string  $section	If table is categories, the section to search in 
     * @return	object 	The row object
     */
	public function findById($id, $table, $section = '')
	{
		//We need to add #__ as the prefix to allow translating of the query
		$query = $this->getDBO()->getQuery()
        	->where('id', '=', $id);
        
        //Exception for categories
        if($table == 'categories') 
        {
        	if(!empty($section)) {
        		$query->where('section', '=', $section);
        	} else {
        		$query->where('section', '>', 0);
        	}
        }
 
        $table = new KDatabaseTableDefault(array('table_name' => $table));
        $result = $table->fetchRow($query);
               
        return $result;
	}
}