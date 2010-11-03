<?php
/**
 * @version		$Id: translators.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Stats Translators Model
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 */
class NookuModelTranslators extends KModelTable
{
	public function getStats()
    {
        // Get models
       $nooku = KFactory::get('admin::com.nooku.model.nooku');

	   $translators = $nooku->getTranslators();
	   
        // Count items for each translator
        $stats = array();
        foreach($translators as $k => $translator)
		{
			$count = $this->_count($translator);

			foreach($count as $data => $value) {
				@$translator->total +=  $value;
			}

			$translator->count = $count;
			$stats[$translator->user_id] =  $translator;
        }

        return $stats;
    }

    public function getDates()
    {
        static $result;

        if(!isset($result))
        {
            $year   = $this->getState('year');
            $month  = $this->getState('month');
            $days   = KDate::getDaysInMonth($month, $year);

            $date   = new KDate();
            $date->year($year);
            $date->month($month);

            $result = array();
        	for($day = 1; $day <= $days; $day++)
            {
                $date->day($day);
            	$result[$date->format('%Y-%m-%d')] = 0;
            }
        }

        return $result;
    }

    public function getGoogleChartUrl()
    {
        $c = KChartGoogle::getInstance(KChartGoogle::PIE);

        $data = $this->getStats();

        $count = array(); $names = array();
        foreach($data as $stat)
        {
            $count[] = $stat->total;
            $names[] = $stat->name;
        }

        $color = new NookuConfigColor(); 
        //unset red
        $color->set('red', null);
        $color->setPrefix('');

        $c->addData($count)
          ->setValueLabels($names)
          ->setColors($color->getSet());

        return $c->getUrl();
    }
    
    public function getDefaultState()
    {
        $state = parent::getDefaultState();
      	$state['user_id']	 = KInput::get('user_id', 	'get', 'int', null, 0);
        $state['year']       = KInput::get('year', 	'get', 'int', null, date('Y'));
        $state['month']      = KInput::get('month', 	'get', 'digit', null, date('m'));
        $state['table_name'] = KInput::get('table_name', 'get', KFactory::tmp('admin::com.nooku.filter.tablename'), null, '');
        return $state;
    }
    
   	protected function _count($translator)
    {
        // Get models
        $nooku = KFactory::get('admin::com.nooku.model.nooku');

        // Get the wrapped database object
        $db = KFactory::get('lib.joomla.database');
        
        $result = $this->getDates();
        $filter = $this->_buildCountWhere();
        $query = "SELECT COUNT(*) AS cnt, DATE(modified) AS mdate"
                ." FROM #__nooku_nodes"
                ." WHERE modified_by = {$translator->user_id} "
                ." AND (status = ".Nooku::STATUS_COMPLETED." OR status = ".Nooku::STATUS_OUTDATED." ) "
                ." AND deleted = 0 "
                .($filter ? ' AND '.$filter : '')
                ." GROUP BY DATE(modified) ASC";
        $db->select($query);
        $tmp = $db->loadObjectList('mdate');

        foreach($tmp as $date => $item ) 
        {
        	if(isset($result[$date])) {
        		$result[$date] += $item->cnt;
        	}
        }
        
        return $result;
    }
    
 	protected function _buildQueryFields(KDatabaseQuery $query)
    {
    	$query->select(array('tbl.*', 't.id AS user_id', 't.username', 't.gid', 't.name'));
    }

    protected function _buildCountWhere()
    {
        // get state
        $table_name = $this->getState('table_name');
        $year   	= $this->getState('year');
        $month  	= $this->getState('month');

        $query = array();;
        
        if($table_name) {
        	$query[] = "`table_name` = '$table_name'";
        }

        if($year) {
            $query[] = "YEAR(`modified`) = $year";
        }

        if($month) {
            $query[] = "MONTH(`modified`) = $month";
        }
       
        return implode(' AND ', $query);
    }
    
    protected function _buildQueryJoins(KDatabaseQuery $query)
    {
    	$query->join('RIGHT', 'users AS t', 't.id = tbl.user_id');
    }
    
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		$filter		= $this->getState('filter');
       	$user_id    = $this->getState('user_id');

		if ($filter) {
			$query->where('t.name', 'LIKE', '%'.$filter.'%');
		}

       	if ($user_id) {
           $query->where('tbl.user_id', '=', $user_id);
       	}
       	
       	$query->where('t.gid', '>', 18);
       	$query->where('t.gid', '<', 25);
	}
	
	public function countContributors()
	{
		static $count;
		
		if(!isset($count)) 
		{
			$query = 'SELECT DISTINCT modified_by FROM #__nooku_nodes'
					.' WHERE modified_by <> 0';
			$this->_db->select($query);
			$count = count($this->_db->loadResultArray());
		}
		return $count;
	}
	
	public function enable($enable = 1, $cid = array())
	{
		$db = KFactory::get('lib.joomla.database');
		
		foreach($cid as $id)
		{
			$query = 'INSERT INTO #__nooku_translators '
					." (user_id, enabled) VALUES ($id, $enable)"
					.' ON DUPLICATE KEY UPDATE '
					." enabled = $enable";
			$db->execute($query);			
		}

	}
}
