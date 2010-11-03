<?php
/**
 * @version		$Id: tables.php 1141 2010-07-23 17:37:43Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Tables
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Tables Table
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Tables
 */
class NookuTableTables extends KDatabaseTableAbstract
{
	public function insert($data)
	{
        // Validate data
		if (!is_array($data)) {
			return false;
		}

		if (empty($data['table_name'])) {
			return false;
		}

		if (empty($data['unique_column'])) {
			return false;
		}

		$nooku    = KFactory::get('admin::com.nooku.model.nooku');
		$primary  = $nooku->getPrimaryLanguage();

		// Get all the languages so we can create a translated table for each.
		$languages = $nooku->getLanguages();

		// Copy all the translatable table for all languages.
		$return = array();
		foreach ($languages as $language)
		{
			$table_name = '#__'.$data['table_name'];

			if ($language->iso_code != $primary->iso_code)
			{
				$table_name = '#__'.strtolower($language->iso_code).'_'.$data['table_name'];

				$syncing = $this->_db->setSyncing(false);
				$this->_db->execute("CREATE TABLE `$table_name` LIKE `#__{$data['table_name']}`");
				$this->_db->execute("INSERT INTO `$table_name` SELECT * FROM `#__{$data['table_name']}`");
				$this->_db->setSyncing($syncing);

				$status     = Nooku::STATUS_MISSING;
                $original   = 0;

			} else {
				$status     = Nooku::STATUS_COMPLETED;
                $original   = 1;
			}

			if($data['table_name'] != 'modules')
			{
				// sync node table
            	$query = "INSERT INTO #__nooku_nodes "
                	." (iso_code, table_name, row_id, title, created, created_by, modified, modified_by, status, original) "
                	." SELECT "
                	."   '{$language->iso_code}' AS iso_code, "
                	."   '{$data['table_name']}' AS table_name, "
                	."   {$data['unique_column']} AS row_id, "
                	."   {$data['title_column']} AS title, "
                	."   NOW() AS created, "
                	."   -1 AS created_by, "
                	."   NOW() AS modified, "
                	."   -1 AS modified_by, "
                	."   '$status' AS status, "
                	."   $original AS original "
                	." FROM `$table_name`"
                	;
                	
                $this->_db->execute($query);
			}

            
		}

		return parent::insert($data);
	}

    /**
     * Drops all translated copies of the table, as well as all nodes
     */
    public function delete($wheres)
    {
        $nooku      = KFactory::get('admin::com.nooku.model.nooku');
        $nodes      = KFactory::get('admin::com.nooku.table.nodes');
        $languages  = $nooku->getAddedLanguages();
        
        foreach($wheres as $where)
        {
            $table_name = KFactory::get('admin::com.nooku.table.tables')
                            ->find($where)
                            ->get('table_name');
                            
            // Delete all items for this table from the nodes table
            $query = $this->_db->getQuery()->where('table_name', '=', $table_name);
            $nodes->delete($query);
        	
            // Delete all #__isocode_table_name
            foreach ($languages as $language)
            {
                $query = 'DROP TABLE '.$this->_db->quoteName('#__'.strtolower($language->iso_code).'_'.$table_name);
                $this->_db->execute($query);
            }
        }

        // Delete the table item in nooku_tables
        return parent::delete($wheres);
    }
}
