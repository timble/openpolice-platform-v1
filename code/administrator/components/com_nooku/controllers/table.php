<?php
/**
 * @version		$Id: table.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Controllers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */


/**
 * Nooku Table Controller
 *
 * @author      Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Controllers
 */
class NookuControllerTable extends NookuController
{
	public function __construct($options = array())
	{
		parent::__construct($options);

		// Register extra tasks
		$this->registerTask( 'add'    , 'add'  );
	}

	public function add()
	{
		KSecurityToken::check() or die('Invalid token or time-out, please try again');
		
		$model	= KFactory::get('admin::com.nooku.model.tables');
		$tbl	= KFactory::get('admin::com.nooku.table.tables');

		$cid 	= KInput::get('cid', 'post', 'array.cmd');
		$tables	= $model->getTableData($cid);
		
		foreach($tables as $table) {
			$tbl->insert($table);
		}
		
		$this->setRedirect('view=tables');
	}
	
	public function syncInsert()
	{
		$db        = KFactory::get('lib.joomla.database');
		
		$nooku     = KFactory::get('admin::com.nooku.model.nooku');
		$languages = $nooku->getLanguages();
		
		unset($languages[$nooku->getPrimaryLanguage()->iso_code]);
		
		//We need to load all the languages
		$db->select($db->getQuery()
				->select(array('*', 'nooku_table_id AS id'))
				->from('nooku_tables')
				->order('table_name')
		);
		
		$tables = $db->loadObjectList('table_name');
			
		// walk through nooku tables
		foreach($tables as $table)
		{
		    // walk through nooku languages
		    foreach($languages as $language)
		    {	
		    	// select missing records
    		    $query = "SELECT id FROM #__".$table->table_name." WHERE ".$db->nameQuote($table->unique_column)." NOT IN" 
    		    	    ." (SELECT id FROM ".$db->nameQuote("#__".strtolower($language->iso_code)."_".$table->table_name).")";
    		   	$db->setQuery($query);
    		   	$missing = $db->loadObjectList();

    		    // insert missing record into Nooku table	
    		  	foreach($missing as $record)
    		    {
    		       	$query = "INSERT INTO ".$db->nameQuote("#__".strtolower($language->iso_code)."_".$table->table_name)
    		       			." ( SELECT * FROM #__".$table->table_name." WHERE ".$db->nameQuote($table->unique_column)." = ".$db->Quote($record->id).")";
    		       	$db->setQuery($query);
    		       	
    		       	if($db->Query()) {
    		         	KFactory::get('lib.joomla.application')->enqueueMessage("Nooku Sync - copied row with ".$table->unique_column.":".$record->id." from table ".$table->table_name." in ".strtolower($language->iso_code)."_".$table->table_name);
    		        }     
		        }
		    }    
		}
	}
	
	public function syncDelete()
	{
		$db        = KFactory::get('lib.joomla.database');
		
		$nooku     = KFactory::get('admin::com.nooku.model.nooku');
		$languages = $nooku->getLanguages();
		
		unset($languages[$nooku->getPrimaryLanguage()->iso_code]);
		
		//We need to load all the languages
		$db->select($db->getQuery()
				->select(array('*', 'nooku_table_id AS id'))
				->from('nooku_tables')
				->order('table_name')
		);
		
		$tables = $db->loadObjectList('table_name');
			
		// walk through nooku tables
		foreach($tables as $table)
		{
		    // walk through nooku languages
		    foreach($languages as $language)
		    {	
		    	// select missing records
    		    // select missing records
    		    $query = "SELECT id FROM ".$db->nameQuote("#__".strtolower($language->iso_code)."_".$table->table_name)." WHERE ".$db->nameQuote($table->unique_column)." NOT IN" 
    		    	    ." (SELECT id FROM #__".$table->table_name.")";
    		   	$db->setQuery($query);
    		   	$missing = $db->loadObjectList();

    		    // insert missing record into Nooku table	
    		  	foreach($missing as $record)
    		    {
    		       	$query = "DELETE FROM ".$db->nameQuote("#__".strtolower($language->iso_code)."_".$table->table_name). "WHERE ".$db->nameQuote($table->unique_column)." = ".$db->Quote($record->id);
    		       	$db->setQuery($query);
    		       	
    		       	if($db->Query()) {
    		         	KFactory::get('lib.joomla.application')->enqueueMessage("Nooku Sync - deleted row with ".$table->unique_column.":".$record->id." from table ".strtolower($language->iso_code)."_".$table->table_name);
    		        }     
		        }
		    }    
		}
	}
}