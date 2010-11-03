<?php
/**
 * @version		$Id: languages.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Models
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Languages Model
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Models
 */
class NookuModelLanguages extends KModelTable
{
	public function __construct(array $options)
	{
		parent::__construct($options);
		
		$this->setState('key', 'iso_code');
		$this->setState('offset', 0);
		$this->setState('limit' , 0);
	}

	public function getList()
	{
		if (!isset($this->_list)) 
		{
        	 $list = parent::getList();
       
        	//Get the menu item data from all the languages
			$menu    = KFactory::get('lib.joomla.application')->getMenu();	
			$user    = KFactory::get('lib.joomla.user');
			$nooku   = KFactory::get('admin::com.nooku.model.nooku');
			$primary = $nooku->getPrimaryLanguage()->iso_code;
					
			//If an active menu item can be found use it to get all relevant menu item data on all languages
			if($item =  $menu->getActive()) 
			{
				$query = $this->_db->getQuery()
					->select($primary.'.published AS '.$primary.'_published')
					->select($primary.'.access AS '.$primary.'_access')
					->from('menu AS '.$primary)
					->where($primary.'.id', '=', $item->id);
		
				foreach($list as $lang) 
				{
					if($lang->iso_code != $primary) {
						$query->join('LEFT', strtolower($lang->iso_code).'_menu AS '.$lang->iso_code, $primary.'.id = '.$lang->iso_code.'.id')
							->select($lang->iso_code.'.published AS '.$lang->iso_code.'_published')
							->select($lang->iso_code.'.access AS '.$lang->iso_code.'_access');
					}
				}

				//Turn query translations off
				$active = $this->_db->setActiveLanguage();
		
				$this->_db->select($query);
				$result = $this->_db->loadAssoc();
		
				//Turn query translations on
				$this->_db->setActiveLanguage($active);
			
				//Decide based on publish and access information which items to return
				foreach($list as $item) 
				{
					if($result[$item->iso_code.'_published'] == 0 || $result[$item->iso_code.'_access'] > $user->aid) {
						$list->offsetUnset($list->key()); 
					}
				}
			}
			
			foreach($list as $item) 
			{
				$item->fullname = $item->name.' ('.$item->native_name.')';
			}
		}
		
		return $this->_list;
	}

	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		$query->where('enabled','>', 0);
	}
	
	protected function _buildQueryOrder(KDatabaseQuery $query)
	{
		$query->order('ordering', 'ASC');
	}
}