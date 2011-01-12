<?php
/**
 * @version		$Id: database.php 1138 2010-07-23 09:32:57Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Proxies
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Database Object Proxy
 *
 * This object proxies the database connector object.  It allows us to proxy the methods
 * that we want and modify the way the system behaves based on that information.
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Proxies
 */
class NookuProxyDatabase extends KDatabase
{
	protected $_languages		= array();
	
	/**
	 * Tables that are available to be translated
	 *
	 * @var array
	 */
	protected $_avail_tables = array();

	protected $_lang_primary 	= 'en-GB';
	protected $_lang_active     = 'en-GB';

	protected $_lang_queries    = array();

	protected $_lang_syncing    = false;
	
	protected $_last_insert_id;

	/**
	 * Regular expression to match all tables in a query, 
	 * format `#__table-name` (with or without quotes) 
	 *
	 * @var string
	 */
	protected $_tables_regex 	= '/`?#__([\w-]*?)`?(\.|\s|$|,|\()/';	 	 
	
	/**
	 * Get the last inserted id
	 *
	 * @return	integer
	 */
	public function insertid()
	{
		if(!isset($this->_last_insert_id)) {
			$this->_last_insert_id = $this->_object->insertid();
		}
		return $this->_last_insert_id;
	}

	/**
	 * Set the current language
	 *
	 * @TODO This function will check the language against the list of available langauges
	 * and only set the language if a matching language could be found. 
	 * 
	 * If the language is set to null then no translations will happen on the query.
	 *
	 * @param  string 	$language 	The language tag to be used
	 * @return string	Existing language
	 */
	public function setActiveLanguage($language = null)
	{
		$old = $this->_lang_active;
		$this->_lang_active = $language;
		return $old;
	}

	/**
	 * Set the primary language
	 *
	 * @TODO This function will check the language against the list of available langauges
	 * and only set the language if a matching language could be found
	 *
	 * @param  string 	$language 	The language tag to be used
	 * @return string	Existing language
	 */
	public function setPrimaryLanguage($language = null)
	{
		$old = $this->_lang_primary;
		$this->_lang_primary = $language;
		return $old;
	}

	/**
	 * Set the available languages to translate
	 *
	 * @param  array 	$languages 	An associative array of languages
	 * @return void
	 */
	public function setLanguages($languages) {
		$this->_languages = $languages;
	}

	/**
	 * Set the available tables to translate
	 *
	 * @param  array 	$languages 	An associative array of languages
	 * @return void
	 */
	public function setTables($tables) {
		$this->_avail_tables  =  $tables;
	}

	/**
	 * Enable or disable language syncing
	 *
	 * @param boolean $syncing If true, enable language syncing. Default is true
	 * @return boolean Existing value
	 */
	public function setSyncing($syncing = false)
	{
		$old = $this->_lang_syncing;
		$this->_lang_syncing  =  $syncing;
		return $old;
	}

	/**
     * Preforms a select query
     *
     * Use for SELECT and anything that returns rows.
     *
     * @param string $sql 		A full SQL query to run.
     * @param string $prefix 	A table prefix, this will be replaced
     *
     * @return object A KRowset.
     */
	public function select($sql, $offset = 0, $limit = 0)
	{	
		// Make sure the active language differs from the primary language
		if ($this->_lang_active == $this->_lang_primary || empty($this->_lang_active)) {
			return parent::select($sql, $offset, $limit);
		}
		
		// Match all of the database tables in the query using the prefix modifier
		if (!preg_match_all($this->_tables_regex, $sql, $tables)) {
			return parent::select($sql, $offset, $limit);
		}
	
		// For each found table iterate over and lets modify the translatable ones
		for($i = 0, $n = count($tables[1]); $i < $n; $i++)
		{
			if ($this->isTableTranslatable($tables[1][$i])) 
			{
				$table = $this->_object->nameQuote('#__'.strtolower($this->_lang_active).'_'.$tables[1][$i]);
				$sql = str_replace($tables[0][$i], $table.$tables[2][$i], $sql);
			}
		}
		
		return parent::select($sql, $offset, $limit);
	}

	/**
	 * Overrides the database connector insert method
	 *
	 * @return	mixed	Database connector return value
	 */
	public function insert($table, $data, $quote = true)
	{
		if (!$this->isTableTranslatable($table)) {
			$ret = parent::insert($table, $data, $quote);
			$this->_last_insert_id = $this->_object->insertid();
			return $ret;
		}

		$this->_lang_syncing = true; //turn on lang syncing
		$result = parent::insert($table, $data, $quote);
		$this->_lang_syncing = false; //turn off lang syncing (default)
		
		if($result !== false && $table != 'modules')
		{
			//Get the primary key and value
			$unique_column = $this->_avail_tables[$table]->unique_column;
           	$title_column  = $this->_avail_tables[$table]->title_column;

			$data[$unique_column] = $this->_object->insertid();

			$user = KFactory::get('lib.joomla.user');

            // insert in the nodes table
           	$node_data = array(
             	'iso_code'      => $this->_lang_active,
                'table_name'    => $table,
               	'row_id'        => $data[$unique_column],
               	'title'         => $data[$title_column],
               	'created'       => $this->getNow(),
               	'created_by'    => $user->id,
               	'modified'      => $this->getNow(),
                'modified_by'   => $user->id,
               	'status'        => Nooku::STATUS_COMPLETED,
                'original'      => 1
           	);

           	$nodes = KFactory::get('admin::com.nooku.table.nodes');
           	$nodes->insert($node_data);

			foreach (array_keys($this->_languages) as $language)
			{
				if($language == $this->_lang_active) {
					continue;
				}

              	// insert in the log
              	$node_data['iso_code']   = $language;
               	$node_data['status']     = Nooku::STATUS_MISSING;
                $node_data['original']   = 0;
               	$nodes->insert($node_data);
			}

			$this->_last_insert_id = $data[$unique_column];
		
		}

		return $result;
	}

	/**
	 * Overrides the database connector update method
	 *
	 * @return	mixed	Database connector return value
	 */
    public function update($table, $data, $where = null, $quote = true)
	{
		if (!$this->isTableTranslatable($table)) {
			return parent::update($table, $data, $where, $quote);
		}

        // Do the language specific table switch on the table
        $table_translated = $table;
        if ($this->_lang_primary != $this->_lang_active) {
            $table_translated = strtolower($this->_lang_active).'_'.$table_translated;
        }

         //Perform the actual update
        $result = parent::update($table_translated, $data, $where, $quote);

        //Check if the title_column exists in the data otherwise don't update the item
		$title_column = $this->_avail_tables[$table]->title_column;
        if($result !== false  && isset($data[$title_column]) && ($id = $this->_findPkInWhere($where)) && $table != 'modules') // don't update if no id was found
        {
        	$node_data = array(
            	'iso_code'      => $this->_lang_active,
            	'table_name'    => $table,
            	'row_id'        => $id,
            	'modified'      => $this->getNow(),
            	'modified_by'   => KFactory::get('lib.joomla.user')->id,
                'status'        => Nooku::STATUS_COMPLETED,
         	  	'title'			=> $data[$title_column]
            	);
            	 	
            $nodes = KFactory::get('admin::com.nooku.table.nodes');
            $nodes->update($node_data);
		
            // are we updating the original item?
        	if($nodes->findByConditions($node_data)->original) {
				$this->_updateOriginalItem($table, $id);				
        	}
        }

        return $result;
	}
	
	/**
     * Overrides the database connector delete query function
     *
     * @param string $sql 		A full SQL query to run.
     * @param string $prefix 	A table prefix, this will be replaced
     *
     * @return integer Number of rows updated.
     */
	public function delete($table, $where = null)
	{
        if (!$this->isTableTranslatable($table)) {
			return parent::delete($table, $where);
		}
		
		// Do the language specific table switch on the table
        $table_translated = $table;
        if ($this->_lang_primary != $this->_lang_active) {
           	$table_translated = strtolower($this->_lang_active).'_'.$table_translated;
        }
		
		// Execute successful update the nodes accordingly
		$this->_lang_syncing = true; //turn on lang syncing
		$result = parent::delete($table_translated, $where);
		$this->_lang_syncing = false; //turn off lang syncing (default)
		
		if($result !== false && $table != 'modules')
		{
			$parser = new KDatabaseQueryParser(str_replace('WHERE', '', $where));
			$sql    = $parser->parseSearchClause();
			$ids    = $sql['arg_2']['value'];

    		settype($ids ,'array'); //force the $ids to an array

    		$node = KFactory::get('admin::com.nooku.table.nodes');

      		$node_data = array(
       			'deleted'       => 1,
           		'modified'      => $this->getNow(),
            	'modified_by'   => KFactory::get('lib.joomla.user')->id
      			//'iso_code'      => $this->_lang_active
			);

			foreach($ids as $id)
			{
				$query = $this->getQuery()
            		->where('table_name', '=', $table)
					->where('row_id'    , '=', $id);

				$node->update($node_data, $query);
			}
		}

		return $result;
	}

	/**
	 * Used for executing INSERT, UPDATE, DELETE, and other queries that don't return rows.
	 * Returns number of affected rows.
	 *
	 * @param  string 	$sql 		The query to run.	
	 * @return integer 	The number of rows affected by $sql.
	 */
	public function execute($sql)
	{
		//Execute original query
		$execute = parent::execute($sql);
		if ($execute ===  false) {
			$this->setError($this->getErrorMsg());
			return false;
		}
		
		//Store last insert id in case of an insert query
		$this->_last_insert_id = $this->_object->insertid();

		//Sync tables
		if($this->_lang_syncing) 
		{
			$sync = $this->sync($sql);
			if($sync === false) {
				$this->setError($this->getErrorMsg());
				return false;
			}
		}
	
		return $execute;
	}
	
	/**
	 * Used for syncing INSERT, UPDATE, DELETE, and other queries that don't return rows.
	 * Returns number of affected rows.
	 *
	 * @param  string 	$sql 		The query to run.
	 * @return integer 	The number of rows affected by $sql.
	 */
	public function sync($sql)
	{
		// Match all of the database tables in the query using the prefix modifier
		if (preg_match($this->_tables_regex, $sql, $tName)) 
		{
			if ($this->isTableTranslatable($tName[1]) )
			{
				foreach (array_keys($this->_languages) as $language)
				{
					if($language == $this->_lang_primary) {
						continue;
					}

					$query = str_replace($tName[0], $this->_object->nameQuote('#__'.strtolower($language).'_'.$tName[1]).$tName[2], $sql);
					if (parent::execute($query) ===  false) {
						$this->setError($this->getErrorMsg());
						return false;
					}
				}
			}
		}
		
		return 0;
	}
		
	/**
	 * Check to see if a table is translatable
	 *
	 * @param string $table 	The name of the table
	 *
	 * @return	boolean 	True if the table is translatable
	 */
	public function isTableTranslatable($table) 
	{
		return in_array($table, array_keys($this->_avail_tables));
	}
	
	/**
	 * Get the #__tablename or #__iso_code_tablename according to whether the table is primary or not 
	 *
	 * @param 	string	Table name without prefix
	 * @param 	string	Iso code
	 * @return	string	Full table name
	 */
	public function getTranslatedTable($table, $iso_code)
	{
		$primary = KFactory::get('admin::com.nooku.model.nooku')->getPrimaryLanguage();
		return ($iso_code == $primary->iso_code) ? $tbl = '#__'.$table : '#__'.strtolower($iso_code).'_'.$table;
	}
	
	/**
	 * List tables in a database
	 *
	 * @return array A list of all the tables in the database
	 */
	public function getTableList()
	{
		$tables	= KFactory::get('admin::com.nooku.model.tables');
		$result = $tables->getTableList();
		
		$list = array();
		foreach($result as $table) {
			$list[] = $table->Name;
		}
		
		return $list;
	}
	
	protected function _updateOriginalItem($table, $id)
	{
		$nodes = KFactory::get('admin::com.nooku.table.nodes');
		
		/*
		 * Get the original node to use later
		 */
		$query = $this->getQuery()
            ->where('iso_code', 	'=', $this->_lang_active)
            ->where('table_name',  	'=' , $table)
			->where('row_id', 	 	'=' , $id);
		$origNode	= $nodes->fetchRow($query);	
		
        /*
         * set the other items to outdated, if they were completed before
         */
		$query = $this->getQuery()
            ->where('iso_code', 	'!=', $this->_lang_active)
            ->where('table_name',  	'=' , $table)
			->where('row_id', 	 	'=' , $id)
            ->where('status',       '=' , Nooku::STATUS_COMPLETED);

		$nodes->update(array('status' => Nooku::STATUS_OUTDATED), $query);

		
		/*
		 * copy the item's data to all missing items
		 */
				
		// get the table's unique column
		$queryKey	= $this->getQuery()->where('table_name', '=', $table);
        $srcKey 	= KFactory::get('admin::com.nooku.table.tables')->fetchRow($queryKey)->unique_column; 
        
        // get the table to copy from
        $srcTbl 	= $this->getTranslatedTable($table, $this->_lang_active);
        
        // get the nodes with status=missing
		$query 		= $this->getQuery()
            ->where('iso_code', 	'!=', $this->_lang_active)
            ->where('table_name',  	'=' , $table)
			->where('row_id', 	 	'=' , $id)
            ->where('status',       '=' , Nooku::STATUS_MISSING);
        $missing 	= $nodes->fetchAll($query);    

        // copy item to all missing items
        foreach( $missing as $node)
		{		
			$targetTbl = $this->getTranslatedTable($table, $node->iso_code);
			$query = "REPLACE INTO `$targetTbl` "
					." SELECT * FROM `$srcTbl` WHERE `$srcKey` = $id";	
			$this->execute($query);
	
			//  copy the node's metadata to all missing items
			$data = array(	'title' 		=> $origNode->title,
							'modified'		=> $origNode->modified,
							'modified_by'	=> $origNode->modified_by	);
			$where = $this->getQuery()
				->where('nooku_node_id', '=', $node->nooku_node_id);
			
			$this->update('nooku_nodes', $data, $where);
		}
	
	}
	
	protected function _findPkInWhere($where)
	{
        $parser = new KDatabaseQueryParser(str_replace('WHERE', '', $where));
		$sql    = $parser->parseSearchClause();
		
		// Assumptions:
		// Depth 1: "WHERE primary_key = n"
		// Depth 2: "WHERE primary_key = n AND foo = bar [AND ....]"
		
		$depth = array_key_exists('arg_1', $sql['arg_1']) ? 2 : 1;
		switch($depth)
		{
			case 1:
				$id     = $sql['arg_2']['value'];
				break;
			case 2:
				$id     = $sql['arg_1']['arg_2']['value'];
				break;
			default:
				$id 	= false;
		}	
		
		// extra failsafe
		$id = is_numeric($id) ? $id : false;
	
		return $id;
	}
}