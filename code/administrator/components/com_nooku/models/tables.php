<?php
/**
 * @version		$Id: tables.php 1142 2010-07-23 17:42:46Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Database Tables Model
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 */
class NookuModelTables extends KModelTable
{
	/**
	 * List of untranslatable tables
	 *
	 * @var	array
	 */
	protected $_untranslatable = array (
			// Core
			'bannertrack',
			'components',
			'core_acl_aro',
			'core_acl_aro_groups',
			'core_acl_aro_map',
			'core_acl_aro_sections',
			'core_acl_groups_aro_map',
			'core_log_items',
			'core_log_searches',
			'groups',
			'menu_types',
			'messages',
			'messages_cfg',
			'modules_menu',
			'plugins',
			'poll_date',
			'poll_menu',
			'session',
			'stats_agents',
			'templates_menu',
			'users',
			'migration_backlinks',

			// Nooku
			'nooku_languages',
			'nooku_tables',
			'nooku_translators',
            'nooku_nodes',
	 		'nooku_metadata',
	
			// Virtuemart
			'vm_affiliate',
			'vm_affiliate_sale',
			'vm_auth_group',
			'vm_auth_user_group',
			'vm_auth_user_vendor',
			'vm_cart',
			'vm_category_xref',
			'vm_country',
			'vm_coupons',
			'vm_creditcard',
			'vm_csv',
			'vm_currency',
			'vm_export',
			'vm_function',
			'vm_module',
			'vm_orders',
			'vm_order_history',
			'vm_order_item',
			'vm_order_payment',
			'vm_order_status',
			'vm_order_user_info',
			'vm_payment_method',
			'vm_product_category_xref',
			'vm_product_discount',
			'vm_product_download',
			'vm_product_mf_xref',
			'vm_product_price',
			'vm_product_product_type_xref',
			'vm_product_relations',
			'vm_product_type_parameter',
			'vm_product_votes',
			'vm_shipping_carrier',
			'vm_shipping_label',
			'vm_shipping_rate',
			'vm_shopper_vendor_xref',
			'vm_state',
			'vm_tax_rate',
			'vm_userfield',
			'vm_user_info',
			'vm_visit',
			'vm_waiting_list',	
	
			// Virtuemart, @todo these could be added back in later
			'vm_manufacturer',
			'vm_manufacturer_category',
			'vm_product_attribute',
			'vm_product_attribute_sku',
			'vm_product_files',
			'vm_product_reviews',
			'vm_product_type',
			'vm_shopper_group',
			'vm_userfield_values',
			'vm_vendor',
			'vm_vendor_category',
			'vm_zone_shipping',
		);

	public function getList()
	{
		$list = parent::getList();
		
		// Add table comment information
		$tables = $this->getTableList();
		foreach($list as $item) 
		{
			if(isset($tables[$item->table_name])) {
				$item->comment = $tables[$item->table_name]->comment;
			} else { 
				$item->comment = '';
			}
		}
		
		return $list;
	}	
		
	/**
	 * Get a list of all tables
	 * 
	 * @return 	array	List of tables with metadata 
	 */
	public function getTableList()
	{
		$nooku		= KFactory::get('admin::com.nooku.model.nooku');
		$languages	= array_keys($nooku->getLanguages());
		$prefix		= $this->_db->getPrefix();
		
		// Exclude tables without prefix 
		$like = $prefix.'%';
		
		// Get the list of tables from SHOW TABLE STATUS
		$tables = $this->_db->getTableStatus($like); 
		
		$result = array();
		foreach ($tables as $key => $table)
		{	
			$table->table_name	= str_replace($prefix, '', $table->Name); //remove prefix
			
			if(!$this->_isTranslatedTable($table->table_name)  // Exclude #__isocode_tablename
				&& !in_array($table->table_name, $this->_untranslatable)) // Exclude  untranslatable core tables	
			{				
				$table->comment		= $table->Comment; // naming convention	
				$result[$table->table_name] = $table; 
			}
		}
		
		$this->_flagTextTables($result);
		
		return $result;
	}
	
	public function getUntranslatedTables()
	{
		$tables     = $this->getTableList();
		foreach($this->getTranslatedTables() as $table) {
			unset($tables[$table]);
		}
		return $tables;
	}
		
	public function getTranslatedTables()
	{
		$nooku  = KFactory::get('admin::com.nooku.model.nooku');
		$tables = array_keys($nooku->getTables());
		return $tables;
	}

	/**
	 * For each table, get metadata
	 *
	 * @param 	array	List of table names
	 * @return	array	Associated array
	 */
	public function getTableData($tables)
	{
		$result = array();
		settype($tables, 'array');
		
		$fields = $this->_db->getTableFields($tables);
	
		foreach($tables as $table){
			$result[$table] = $this->_getTableData($table, $fields[$table]);
		}
		
		return $result;
	}	
	
	protected function _getTableData($table, $fields)
	{
		$result = array(
			'table_name' => $table, 
			'unique_column' => '', 
			'title_column' => '', 
			'fields' => $fields);

		/************************
		 * Find the unique column
		 ************************/
		
		// Find the primary key
		foreach($fields as $fieldname => $field)
		{
			if($field->Key == 'PRI')
			{
				$result['unique_column'] = $fieldname;
				break;
			}
		}
		
		// if no primary key was found, try a unique field
		if(empty($result['unique_column']))
		{
			foreach($fields as $fieldname => $field)
			{
				if($field->Key == 'UNI')
				{
					$result['unique_column'] = $fieldname;
					break;
				}
			}
		}
		
		
		/***********************
		 * Find the title column
		 ***********************/
		
		// find the title column, based on a list of typical names
		$titles = array('title', 'name', 'alias', 'text', 'dmname');
		foreach($titles as $title)
		{
			if(array_key_exists($title, $fields))
			{
				$result['title_column'] = $title;
				break;
			}
			
		}
		
		// if no suitable column was found, find a char or varchar field to use as title
		if(empty($result['title_column']))
		{
			foreach($fields as $fieldname => $field)
			{
				if(strpos($field->Type, 'char'))
				{
					$result['title_column'] = $fieldname;
					break;
				}
			}
		}
		
		// if still nothing was found, try text fields
		if(empty($result['title_column']))
		{
			foreach($fields as $fieldname => $field)
			{
				if(strpos($field->Type, 'text'))
				{
					$result['title_column'] = $fieldname;
					break;
				}
			}
		}
		
		// and finally, simply use the unique key
		if(empty($result['title_column']))
		{
			$result['title_column'] = $result['unique_column'];
		}
		
		return $result;
	}

	
	/**
	 * Check if a table is translated (= contains an ISO code after the prefix)
	 *
	 * @param	string	Full table name
	 * @return	boolean	True if translated 
	 */
	protected function _isTranslatedTable($table)
	{
		static $languages;
		
		if(!isset($languages)) 
		{
			$nooku     = KFactory::get('admin::com.nooku.model.nooku');
			$languages = array_keys($nooku->getLanguages());
		}
		
		$result = false;
		foreach($languages as $language)
		{
			if (strpos(strtolower($table), strtolower($language).'_') === 0) {
				$result = true;
			}
		}
		return $result;
	}

	/**
	 * Add a flag to all content tables (aka tables having text fields)
	 *
	 * @param	array	tables
	 * @return 	array	tables
	 */
	protected function _flagTextTables(& $tables)
	{
		$tablefields = $this->_db->getTableFields(array_keys($tables));

		foreach($tablefields as $tablename => $fields)
		{
			$tables[$tablename]->has_text = false;
			foreach($fields as $fieldname => $field)
			{
				if(stripos($field->Type, 'char') || $field->Type=='text')
				{
					$tables[$tablename]->has_text = true;
					break;	
				}
			}
		}
	}
}