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

class PhocaGalleryCpModelPhocaGalleryCs extends JModel
{

	var $_data 					= null;
	var $_data_categories 		= null;
	var $_data_outcome_array	= null;
	var $_total 				= null;
	var $_pagination 			= null;
	var $_context				= 'com_phocagallery.phocagalleryc';

	function __construct() {
		parent::__construct();
		
		global $mainframe, $option;		
		// Get the pagination request variables
		$limit	= $mainframe->getUserStateFromRequest( $this->_context.'.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $this->_context.'.limitstart', 'limitstart',	0, 'int' );
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	
	function getData() {
		global $mainframe;
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query );// We need all data because of tree

			// Order Categories to tree
			$text = ''; // test is tree name e.g. Category >> Subcategory
			$tree = array();
			$this->_data = $this->_categoryTree($this->_data, $tree, 0, $text, -1);
			return $this->_data;
		}
	}

	/*
	* Is called after setTotal from the view
	*/
	function getTotal() {
		return $this->_total;
	}
	
	function setTotal($total) {
		$this->_total = (int)$total;
	}
	
	/*
	 * Is called after setTotal from the view
	 */
	function getPagination() {
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	function _buildQuery() {
		
		global $mainframe;
		
		$user		= &JFactory::getUser();
		$gid		= $user->get('aid', 0);
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy('cc.parent_id');
		

		/*
		$query = ' SELECT a.*, cc.title AS parentname, u.name AS editor, g.name AS groupname, v.average AS ratingavg, ua.username AS usercatname, '
			.'(SELECT count(*) AS countid'// used because Order down icon link
			.' FROM #__phocagallery_categories AS c'
			.' WHERE a.parent_id = c.parent_id'
			.' GROUP BY c.parent_id ) AS countid'
			. ' FROM #__phocagallery_categories AS a '
			. ' LEFT JOIN #__users AS u ON u.id = a.checked_out '
			. ' LEFT JOIN #__groups AS g ON g.id = a.access '
			. ' LEFT JOIN #__phocagallery_categories AS cc ON cc.id = a.parent_id'
			. ' LEFT JOIN #__phocagallery_votes_statistics AS v ON v.catid = a.id'
			//. ' LEFT JOIN #__phocagallery_user_category AS uc ON uc.catid = a.id'
			. ' LEFT JOIN #__users AS ua ON ua.id = a.owner_id'
			. $where
			. $orderby;*/
			
			
			$query = ' SELECT a.*, cc.title AS parentname, u.name AS editor, g.name AS groupname, v.average AS ratingavg, ua.username AS usercatname, c.countid AS countid'
			. ' FROM #__phocagallery_categories AS a '
			. ' LEFT JOIN #__users AS u ON u.id = a.checked_out '
			. ' LEFT JOIN #__groups AS g ON g.id = a.access '
			. ' LEFT JOIN #__phocagallery_categories AS cc ON cc.id = a.parent_id'
			. ' LEFT JOIN #__phocagallery_votes_statistics AS v ON v.catid = a.id'
			. ' LEFT JOIN #__users AS ua ON ua.id = a.owner_id'
			. ' JOIN (SELECT c.parent_id, count(*) AS countid'
			. ' FROM #__phocagallery_categories AS c'
			.' GROUP BY c.parent_id ) AS c'
			.' ON a.parent_id = c.parent_id'
			. $where
			. $orderby;
			
		return $query;
	}
	

	/*
	 * Create category tree
	 */
	function _categoryTree( $data, $tree, $id = 0, $text='', $currentId) {		

		// Ordering
		$countItemsInCat 	= 0;
		foreach ($data as $key) {	
			$show_text =  $text . $key->title;
			
			static $iCT = 0;// All displayed items
	
			if ($key->parent_id == $id && $currentId != $id && $currentId != $key->id ) {	

				
				
				$tree[$iCT] 					= new JObject();
				
				// Ordering MUST be solved here
				if ($countItemsInCat > 0) {
					$tree[$iCT]->orderup				= 1;
				} else {
					$tree[$iCT]->orderup 				= 0;
				}
				
				if ($countItemsInCat < ($key->countid - 1)) {
					$tree[$iCT]->orderdown 				= 1;
				} else {
					$tree[$iCT]->orderdown 				= 0;
				}
				
				
				$tree[$iCT]->id 				= $key->id;
				$tree[$iCT]->title 				= $show_text;
				$tree[$iCT]->title_self 		= $key->title;
				$tree[$iCT]->parent_id			= $key->parent_id;
				$tree[$iCT]->owner_id			= $key->owner_id;
				$tree[$iCT]->name				= $key->name;
				$tree[$iCT]->alias				= $key->alias;
				$tree[$iCT]->image				= $key->image;
				$tree[$iCT]->section			= $key->section;
				$tree[$iCT]->image_position		= $key->image_position;
				$tree[$iCT]->description		= $key->description;
				$tree[$iCT]->published			= $key->published;
				$tree[$iCT]->editor				= $key->editor;
				$tree[$iCT]->ordering			= $key->ordering;
				$tree[$iCT]->access				= $key->access;
				$tree[$iCT]->count				= $key->count;
				$tree[$iCT]->params				= $key->params;
				$tree[$iCT]->checked_out		= $key->checked_out;
				$tree[$iCT]->groupname			= $key->groupname;
				$tree[$iCT]->usercatname		= $key->usercatname;
				$tree[$iCT]->parentname			= $key->parentname;
				$tree[$iCT]->hits				= $key->hits;
				$tree[$iCT]->ratingavg			= $key->ratingavg;
				$tree[$iCT]->accessuserid		= $key->accessuserid;
				$tree[$iCT]->uploaduserid		= $key->uploaduserid;
				$tree[$iCT]->deleteuserid		= $key->deleteuserid;
				$tree[$iCT]->userfolder			= $key->userfolder;
				$tree[$iCT]->latitude			= $key->latitude;
				$tree[$iCT]->longitude			= $key->longitude;
				$tree[$iCT]->zoom				= $key->zoom;
				$tree[$iCT]->geotitle			= $key->geotitle;
				$tree[$iCT]->approved			= $key->approved;
				$tree[$iCT]->link				= '';
				$tree[$iCT]->filename			= '';// Will be added in View (after items will be reduced)
				$tree[$iCT]->linkthumbnailpath	= '';

				$iCT++;
				
				$tree = $this->_categoryTree($data, $tree, $key->id, $show_text . " &raquo; ", $currentId );
				$countItemsInCat++;
			}	
		}
		
		return($tree);
	}
	
	
	function _buildContentOrderBy($cc_or_a){		
		global $mainframe;
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',		'a.ordering',	'cmd' );// Category tree works with id not with ordering
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );

		if ($filter_order == 'a.ordering'){
			$orderby 	= ' ORDER BY  a.ordering '.$filter_order_Dir;
		} else if ($filter_order == 'category'){
			$orderby 	= ' ORDER BY ' .$cc_or_a . ', a.ordering ' .$filter_order_Dir;
		} else if ($filter_order == 'groupname'){
			$orderby 	= ' ORDER BY a.groupname , a.ordering ' .$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order . ' ' . $filter_order_Dir .  ' ';
		}
		return $orderby;
	}


	function _buildContentWhere() {
		global $mainframe;
		$filter_state		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_state',	'filter_state',	'',	'word' );
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'a.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'', 'word' );
		$search				= $mainframe->getUserStateFromRequest( $this->_context.'.search', 'search', '', 'string' );
		$search				= JString::strtolower( $search );
		
		$where = array();

		if ($search) {
			$where[] = 'LOWER(a.title) LIKE '.$this->_db->Quote('%'.$search.'%');
		}
		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = 'a.published = 1';
			} else if ($filter_state == 'U' ) {
				$where[] = 'a.published = 0';
			}
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		return $where;
	}
	
	function getNotApprovedCategory() {
		
		$query = 'SELECT COUNT(a.id) AS count'
			.' FROM #__phocagallery_categories AS a'
			.' WHERE approved = 0';
		$this->_db->setQuery($query, 0, 1);
		$countNotApproved = $this->_db->loadObject();
		return $countNotApproved;
	}
}
?>