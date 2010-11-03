<?php
/**
 * @version     $Id: nodes.php 1134 2010-07-02 12:55:44Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * Nooku Nodes Model
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 */
class NookuModelNodes extends KModelTable
{
 	/**
     * Generic counter for nodes by parameters
     *
     * @param array		Conditions
     */
	public function count($conds)
    {
        $nooku   = KFactory::get('admin::com.nooku.model.nooku');
        $primary = $nooku->getPrimaryLanguage();
        
        $query = $this->_db->getQuery()
        	->count()
        	->from('nooku_nodes AS n');
        
       foreach($conds as $cond) {
        	$query->where($cond[0], $cond[1], $cond[2]);
        }
      
        $this->_db->select($query);
        return $this->_db->loadResult();
    }
	
	public function getFilters()
    {
        $filters                = parent::getFilters();
        $filters['table_name']  = $this->getState('filter_table_name');
        $filters['iso_code']    = $this->getState('filter_iso_code');
        $filters['status']      = $this->getState('filter_status');
        $filters['translator']  = $this->getState('filter_translator');
        return $filters;
    }
    
    public function getDefaultState()
    {
        $app 	= KFactory::get('lib.joomla.application');
    	$ns		= $this->getClassName('prefix').'.'.$this->getClassName('suffix');

    	$state = parent::getDefaultState();
      	$state['filter_table_name'] = $app->getUserStateFromRequest($ns.'table_name', 'filter_table_name', '', 'cmd');
        $state['filter_iso_code']   = $app->getUserStateFromRequest($ns.'iso_code',   'filter_iso_code',   '', 'cmd');
        $state['filter_status']     = $app->getUserStateFromRequest($ns.'status',     'filter_status',     '', 'int');
        $state['filter_translator'] = $app->getUserStateFromRequest($ns.'translator', 'filter_translator', 0,  'int');
        
        return $state;
    }

    protected function _buildQueryFields(KDatabaseQuery $query)
    {
    	$query->select(array(
    		'u1.name AS modified_by_name',
    		'u2.name AS created_by_name'
    	));
    }
    
 	protected function _buildQueryJoins(KDatabaseQuery $query)
    {
        $query->join('LEFT', 'users AS u1', 'u1.id = tbl.modified_by');
        $query->join('LEFT', 'users AS u2', 'u2.id = tbl.created_by');
    }

    protected function _buildQueryOrder(KDatabaseQuery $query)
    {
        $nooku  = KFactory::get('admin::com.nooku.model.nooku');

      	// Assemble the clause pieces
       	$order      = $this->getState('order', 'tbl.table_name');
      	$direction  = strtoupper($this->getState('direction', 'ASC'));
      	
      	// Assemble the clause
        switch($order) 
        {
          	case 'table_name':
          		$query->order('tbl.table_name', $direction);
          		$query->order('tbl.row_id', $direction);
          		$query->order('tbl.original', 'DESC');
              	break;
            default:
               if($order) {
            		$query->order($order, $direction);
               }
               break;
        }
    }

    protected function _buildQueryWhere(KDatabaseQuery $query)
    {
       	$filter     = $this->getState('filter');
       	$table_name = $this->getState('filter_table_name');
        $iso_code   = $this->getState('filter_iso_code');
        $status     = $this->getState('filter_status');
        $translator = $this->getState('filter_translator');

       	if ($filter) {
         	$query->where('tbl.title', 'LIKE', '%'.$filter.'%');
       	}
        if ($table_name) {
          	$query->where('tbl.table_name', '=', $table_name);
       	}
        if ($iso_code) {
          	$query->where('tbl.iso_code', '=', $iso_code);
       	}
        if ($status) {
          	$query->where('tbl.status', '=', $status);
        }
       	if ($translator) {
          	$query->where('tbl.modified_by', '=', $translator);
       	}
       	
       $query->where('tbl.deleted', '=', 0);
    }
}