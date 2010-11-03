<?php
/**
 * @version		$Id: languages.php 1132 2010-07-02 12:34:12Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Tables
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Languages Table
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Tables
 */
class NookuTableLanguages extends KDatabaseTableAbstract
{
	public function filter($data)
	{
		if (isset($data['operations']) && is_array($data['operations']))
		{
			$result = 0;
			foreach($data['operations'] as $operation) {
				$result += $operation;
			}
			$data['operations'] = $result;
		}

		$data = parent::filter($data);
		return $data;
	}

	public function insert($data)
	{
		// Validate data
		if (!is_array($data)) {
			return false;
		}

		if (empty($data['iso_code'])) {
			return false;
		}
		
		if(empty($data['created_date'])) {
			$data['created_date'] = date('Y-m-d H:i:s');
		}

		// Get all the translatable tables so that we can recreate them in the new language.
		$this->_db->select('SELECT * FROM `#__nooku_tables`');
		$tables = $this->_db->loadObjectList('table_name');
		
        // Get the unwrapped db
        $db = $this->_db->getObject();

		// Copy all the translatable tables for the new language.
		$return = array();
		foreach ($tables as $table)
		{
			$table_name = '#__'.strtolower($data['iso_code']).'_'.$table->table_name;

			$syncing = $this->_db->setSyncing(false);

			$this->_db->execute("CREATE TABLE `$table_name` LIKE `#__{$table->table_name}`");
			$this->_db->execute("INSERT INTO `$table_name` SELECT * FROM `#__{$table->table_name}`");
			
		 	if($table != 'modules') 
		 	{
            	$status = Nooku::STATUS_MISSING;

            	// sync node table
            	$query = "INSERT INTO #__nooku_nodes "
                	." (iso_code, table_name, row_id, title, created, created_by, modified, modified_by, status, original) "
               		." SELECT "
                	."   '{$data['iso_code']}' AS iso_code, "
                	."   '{$table->table_name}' AS table_name, "
                	."   t.{$table->unique_column} AS row_id, "
                	."   t.{$table->title_column} AS title, "
                	."   n.created AS created, "
                	."   n.created_by AS created_by, "
                	."   n.modified AS modified, "
                	."   n.modified_by AS modified_by, "
                	."   $status AS status, "
                	."   0 AS original"
                	." FROM `$table_name` AS t, #__nooku_nodes AS n"
                	." WHERE n.row_id = t.{$table->unique_column}"
                	."   AND n.table_name = '{$table->table_name}'"
                	."   AND n.original = 1"
                	;
		 	

            	$this->_db->execute($query);
            	
		 	}

			$this->_db->setSyncing($syncing);
		}

		return parent::insert($data);
	}


	/**
	 * Update the rows, and change the #__isocode_tables and nodes isocodes when necessary
	 *
	 * @param  array	An associative array of data to be updated
	 * @param  mixed	Can either be a row, an array of rows or a query object
	 * @return boolean 	True if successful otherwise returns false
	 */
	public function update( $data, $where = null)
	{
		$nooku = KFactory::get('admin::com.nooku.model.nooku');
 
 		// Check if the new data contains an iso_code
 		if(isset($data['iso_code']))
 		{
		    $new_iso = $data['iso_code'];
		    $primary = $nooku->getPrimaryLanguage()->iso_code;
		    settype($where, 'array');
		    
		    // Update #__isocode_tables names if necessary
		    foreach($where as $id)
		    {
		        $old_iso = $this->find($id)->get('iso_code');
		        if($new_iso != $old_iso)
		        {	        	
		            if($primary != $old_iso) { // don't rename the primary lang tables, they dont have an iso in there name
		            	$this->_renameIsoTable($old_iso, $new_iso);
		            }
		            $this->_renameIsoNodes($old_iso, $new_iso);
		        }
		    }
 		}
	   
	    
	    return parent::update($data, $where);
	}
	
	/**
	 * Rename all #__old_iso_tables to #__new_iso_tables
	 *
	 * @param string	Old iso code
	 * @param string	New iso code
	 */
	protected function _renameIsoTable($old, $new)
	{
	    $tables = KFactory::get('admin::com.nooku.model.nooku')->getTables();

	    // build the rename sql statement
	    $renames = array();
	    foreach($tables as $name => $table)
	    {
	        $renames[] = '`#__'.strtolower($old).'_'.$name.'`'
	                    .' TO '
	                    .'`#__'.strtolower($new).'_'.$name.'`';
	    }
	    
	    // Perform the renaming
	    if(count($renames))
	    {
	        $sql = 'RENAME TABLE '.implode(', ', $renames);
	        $this->_db->execute($sql);
	    }
	}
	
	
	/**
	 * Rename all #__nooku_nodes.iso_code
	 *
	 * @param string	Old iso code
	 * @param string	New iso code
	 */
	protected function _renameIsoNodes($old, $new)
	{
		$table = KFactory::get('admin::com.nooku.table.nodes');
		$table->update(
			array('iso_code' => $new),
			$this->_db->getQuery()->where('iso_code', '=', $old)
		);
	}

    /**
     * Drops all tables for the language, as well as all nodes
     */
    public function delete($wheres)
    {
        $nooku      = KFactory::get('admin::com.nooku.model.nooku');
        $nodes      = KFactory::get('admin::com.nooku.table.nodes');
        $tables     = $nooku->getTables();
        $primary    = $nooku->getPrimaryLanguage();

        foreach($wheres as $key => $where)
        {
            $iso_code = KFactory::get('admin::com.nooku.table.languages')
                            ->find($where)
                            ->get('iso_code');

            // the primary language can't be deleted
            if($primary->iso_code == $iso_code)
            {
            	unset($wheres[$key]);
                JError::raiseNotice(0, "The primary language can't be deleted");
                if(count($wheres)) {
                    continue;
                } else {
                	return true;
                }
            }

            // Delete all items for this lang from the nodes table
            $query = $this->_db->getQuery()->where('iso_code', '=', $iso_code);
            $nodes->delete($query);

            // Delete all #__isocode_table_name
            foreach ($tables as $table)
            {
                $query = 'DROP TABLE '.$this->_db->quoteName('#__'.strtolower($iso_code).'_'.$table->table_name);
                $this->_db->execute($query);
            }
        }

        // Delete the table item in nooku_tables
        return parent::delete($wheres);
    }
}