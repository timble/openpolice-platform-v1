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
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );
phocagalleryimport( 'phocagallery.file.filefolder' );

class PhocaGalleryCpModelPhocaGalleryUsers extends JModel
{

	var $_data 			= null;
	var $_total 		= null;
	var $_pagination 	= null;
	var $_context		= 'com_phocagallery.phocagalleryuser';

	function __construct() {
		parent::__construct();

		global $mainframe;
		
		// Get the pagination request variables
		$limit	= $mainframe->getUserStateFromRequest( $this->_context.'.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $this->_context.'.limitstart', 'limitstart',	0, 'int' );
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	function getData() {
		
		$params							= &JComponentHelper::getParams( 'com_phocagallery' );	
		
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

		$query = ' SELECT a.*, us.name AS username, u.name AS editor, c.countcid, i.countiid'
			. ' FROM #__phocagallery_user AS a '
		
			. ' LEFT JOIN #__users AS us ON us.id = a.userid '
			. ' LEFT JOIN #__users AS u ON u.id = a.checked_out '
			
			. ' LEFT JOIN (SELECT  c.owner_id, c.id, count(*) AS countcid'
			. ' FROM #__phocagallery_categories AS c'
			. ' GROUP BY c.owner_id) AS c '
			. ' ON a.userid = c.owner_id'
			
			. ' LEFT JOIN (SELECT i.catid, uc.userid AS uid, count(i.id) AS countiid'
			. ' FROM #__phocagallery AS i'
			. ' LEFT JOIN #__phocagallery_categories AS cc ON cc.id = i.catid'
			. ' LEFT JOIN #__phocagallery_user AS uc ON uc.userid = cc.owner_id'
			//. ' WHERE cc.owner_id = uc.userid'
			//. ' AND cc.id = i.catid'
			. ' GROUP BY uc.userid'
			. ' ) AS i '
			. ' ON i.uid = c.owner_id'
			
			. $where
			. $orderby;
		return $query;
	}


	function _buildContentOrderBy() {
		global $mainframe;
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );

		if ($filter_order == 'a.ordering'){
			$orderby 	= ' ORDER BY  a.ordering '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' , a.ordering ';
		}
		return $orderby;
	}

	function _buildContentWhere() {
		global $mainframe;
		$filter_state		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_state',	'filter_state',	'',	'word' );
		//$filter_catid		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_catid',	'filter_catid',	0,	'int' );
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'', 'word' );
		$search				= $mainframe->getUserStateFromRequest( $this->_context.'.search', 'search', '', 'string' );
		$search				= JString::strtolower( $search );

		$where = array();
		
		$where[] = 'us.id > 0';

		/*if ($filter_catid > 0) {
			$where[] = 'a.userid = '.(int) $filter_catid;
		}*/
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
	
	
	function getOwnerMainCategory($userId) {

		$query = 'SELECT cc.*'
			. ' FROM #__phocagallery_categories AS cc'
			. ' WHERE cc.owner_id = '.(int)$userId
			//. ' AND cc.id <> '.(int)$categoryId // Check other categories
			. ' AND cc.owner_id > 0' // Ignore -1
			. ' AND cc.parent_id = 0';
		
		$this->_db->setQuery( $query );
		$ownerMainCategoryId = $this->_db->loadObject();
		if (isset($ownerMainCategoryId->id)) {
			return $ownerMainCategoryId;
		}
		return false;
	}
	
	function getCountUserSubCat($userId) {
		$query = 'SELECT count(cc.id) AS countid'
			. ' FROM #__phocagallery_categories AS cc'
			. ' WHERE cc.owner_id = '.(int)$userId
			. ' AND cc.parent_id <> 0';

		$this->_db->setQuery( $query );
		$categoryCount = $this->_db->loadObject();
		if (isset($categoryCount->countid)) {
			return $categoryCount->countid;
		}
		return 0;
	}
	
	function getCountUserImage($userId) {
		$query = 'SELECT count(a.id) AS count'
			. ' FROM #__phocagallery AS a'
			. ' LEFT JOIN #__phocagallery_categories AS cc ON cc.id = a.catid '
			. ' WHERE cc.owner_id = '.(int)$userId;

		$this->_db->setQuery( $query );
		$imageCount = $this->_db->loadObject();
		if (isset($imageCount->count)) {
			return $imageCount->count;
		}
		return 0;
	}
}
?>