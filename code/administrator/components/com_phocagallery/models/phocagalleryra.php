<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class PhocaGalleryCpModelPhocaGalleryRa extends JModel
{
	var $_data 			= null;
	var $_total 		= null;
	var $_pagination 	= null;
	var $_context		= 'com_phocagallery.phocagalleryra';

	function __construct() {
		parent::__construct();

		global $mainframe, $option;		
		
		// Get the pagination request variables
		$limit	= $mainframe->getUserStateFromRequest( $this->_context.'.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $this->_context.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		
	}

	function getData() {
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;
	}

	function getTotal() {
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}

	function getPagination() {
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	

	function _buildQuery() {

		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();

		$query = ' SELECT a.*, cc.title AS category, ua.name AS editor, u.id AS ratinguserid, u.username AS ratingusername '
			. ' FROM #__phocagallery_votes AS a '
			. ' LEFT JOIN #__phocagallery_categories AS cc ON cc.id = a.catid '
			. ' LEFT JOIN #__users AS ua ON ua.id = a.checked_out '
			. ' LEFT JOIN #__users AS u ON u.id = a.userid'
			. $where
			. ' GROUP by a.id'
			. $orderby
		;
		return $query;
	}
	

	function _buildContentOrderBy() {
		global $mainframe;
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',				'word' );

		if ($filter_order == 'a.ordering'){
			$orderby 	= ' ORDER BY category, a.ordering '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' , category, a.ordering ';
		}
		return $orderby;
	}

	function _buildContentWhere() {
		global $mainframe;

		$filter_catid		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_catid',	'filter_catid',	0,	'int' );

		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );
		$search				= $mainframe->getUserStateFromRequest( $this->_context.'.search', 'search', '', 'string' );
		$search				= JString::strtolower( $search );
		
		$where = array();
		$where[] = 'a.userid = u.id';
		
		if ($filter_catid > 0) {
			$where[] = 'a.catid = '.(int) $filter_catid;
		}
		if ($search) {
			$where[] = 'LOWER(u.username) LIKE '.$this->_db->Quote('%'.$search.'%');
		}

		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );

		return $where;
	}
	
	function delete($cid = array()) {
		
		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			
			//Select affected catids
			$query = 'SELECT v.catid AS catid'
				. ' FROM #__phocagallery_votes AS v'
				. ' WHERE v.id IN ( '.$cids.' )';
			$catids = $this->_getList($query);
			
			//Delete it from DB
			$query = 'DELETE FROM #__phocagallery_votes'
				. ' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			phocagalleryimport('phocagallery.rate.ratecategory');
			foreach ($catids as $valueCatid) {
				$updated = PhocaGalleryRateCategory::updateVoteStatistics( $valueCatid->catid );
				if(!$updated) {
					return false;
				}				
			}
		}
		return true;
	}
	
}
?>