<?php
/**
 * @version     $Id: components.php 1129 2010-06-22 15:53:15Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Components model
 * 
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @package     Nooku
 * @subpackage  Administrator
 * @version     1.0
 */
class NookuModelComponents extends KModelTable
{
	/**
	 * Maps component names to table prefixes
	 *
	 * @var array
	 */
	protected $_list = array(
		'virtuemart' => 'vm',
		'menus' 	 => 'menu',
	);
	
	/**
	 * Finds the table prefix for a component
	 *
	 * @param 	string	Component name
	 * @return	string	Table prefix
	 */
	public function getTablePrefix($option)
	{
		$component = substr($option, 4);
		
		if('trash' == $component) {
			$prefix = strtolower(substr(JRequest::getCmd('task'), 4));
		} elseif(array_key_exists($component, $this->_list)) {
			$prefix =  $this->_list[$component];			
		} else {
			$prefix = $component;
		}
		
		return $prefix;
	}
	
	/**
	 * Is a component translatable?
	 *
	 * @param	string	Component name
	 * @param	string	View name
	 * @return 	bool
	 */
	public function isTranslatable($option, $view = '')
	{
		if(empty($option)) {
			return false;
		}
		
		$prefix = $this->getTablePrefix($option);
		if(!empty($view)) {
			$prefix = $prefix.'_'.$view;
		}
		
		$nooku  = KFactory::get('admin::com.nooku.model.tables');
		$tables = $nooku->getTranslatedTables();
		
		foreach($tables as $table)
		{
			if(strpos($table, $prefix) !== FALSE) {
				return true;
			}
		}
		
		return false;
	}
}