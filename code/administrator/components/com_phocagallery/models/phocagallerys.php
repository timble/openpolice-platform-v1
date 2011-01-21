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

class PhocaGalleryCpModelPhocaGalleryS extends JModel
{

	var $_data 			= null;
	var $_total 		= null;
	var $_pagination 	= null;
	var $_context		= 'com_phocagallery.phocagallery';

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
		
		//Params
		$params							= &JComponentHelper::getParams( 'com_phocagallery' );
		$pagination_thumbnail_creation 	= $params->get( 'pagination_thumbnail_creation', 0 );
		$clean_thumbnails 				= $params->get( 'clean_thumbnails', 0 );		
		
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		
		//Server doesn't have CPU power
		//we do thumbnail for all images - there is no pagination...
		//or we do thumbanil for only listed images
		if (empty($this->_data_thumbnail)) {	
			if ($pagination_thumbnail_creation == 1) {
				$this->_data_thumbnail = $this->_data;
			} else {
				$query = $this->_buildQueryThumbnail();
				$this->_data_thumbnail = $this->_getList($query);
				
			}
		}

		// - - - - - - - - - - - - - - - - - - - -
		// Check if the file stored in database is on the server. If not please refer to user
		// Get filename from every object there is stored in database	
		// file - abc.img, file_no - folder/abc.img
		// Get folder variables from Helper
		$path 				= PhocaGalleryPath::getPath();
		$origPath 			= $path->image_abs;
		$origPathServer 	= str_replace(DS, '/', $path->image_abs);
		
		//-----------------------------------------
		//Do all thumbnails no limit no pagination
		if (!empty($this->_data_thumbnail)) {
			foreach ($this->_data_thumbnail as $key => $value) {	
				$fileOriginalThumb = PhocaGalleryFile::getFileOriginal($value->filename);
				//Let the user know that the file doesn't exists and delete all thumbnails
				if (JFile::exists($fileOriginalThumb)) {
					
					$refreshUrlThumb = 'index.php?option=com_phocagallery&view=phocagallerys';
					$fileThumb = PhocaGalleryFileThumbnail::getOrCreateThumbnail( $value->filename, $refreshUrlThumb, 1, 1, 1);	
				}
			}
		}
		
		$this->_data_thumbnail = null; // delete data to reduce memory
		
		//Only the the site with limitation or pagination...
		if (!empty($this->_data)) {
			foreach ($this->_data as $key => $value) {	
				$fileOriginal = PhocaGalleryFile::getFileOriginal($value->filename);
				//Let the user know that the file doesn't exists and delete all thumbnails
				
				if (!JFile::exists($fileOriginal)) {
					$this->_data[$key]->filename = JText::_( 'Image Filename does not exist' );
					$this->_data[$key]->fileoriginalexist = 0;
				} else {
					//Create thumbnails small, medium, large
					$refresh_url 	= 'index.php?option=com_phocagallery&view=phocagallerys';
					$fileThumb 		= PhocaGalleryFileThumbnail::getOrCreateThumbnail($value->filename, $refresh_url, 1, 1, 1);
					
					$this->_data[$key]->linkthumbnailpath 	= $fileThumb['thumb_name_s_no_rel'];
					$this->_data[$key]->fileoriginalexist = 1;	
				}
			}
		}
		
		//Clean Thumbs Folder if there are thumbnail files but not original file
		if ($clean_thumbnails == 1) {
			PhocaGalleryFileFolder::cleanThumbsFolder();
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

		$query = ' SELECT a.*, cc.title AS category, cc.owner_id AS ownerid, u.name AS editor, v.average AS ratingavg, ua.username AS usercatname'
			. ' FROM #__phocagallery AS a '
			. ' LEFT JOIN #__phocagallery_categories AS cc ON cc.id = a.catid '
			. ' LEFT JOIN #__phocagallery_img_votes_statistics AS v ON v.imgid = a.id'
			. ' LEFT JOIN #__users AS u ON u.id = a.checked_out '
			. ' LEFT JOIN #__users AS ua ON ua.id = cc.owner_id'
			. $where
			. $orderby;
		return $query;
	}
	
	function _buildQueryThumbnail() {
		$queryt = ' SELECT a.filename '
			. ' FROM #__phocagallery AS a ';
		return $queryt;
	}

	function _buildContentOrderBy() {
		global $mainframe;
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );

		if ($filter_order == 'a.ordering'){
			$orderby 	= ' ORDER BY category, a.ordering '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' , category, a.ordering ';
		}
		return $orderby;
	}

	function _buildContentWhere() {
		global $mainframe;
		$filter_state		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_state',	'filter_state',	'',	'word' );
		$filter_catid		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_catid',	'filter_catid',	0,	'int' );
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'', 'word' );
		$search				= $mainframe->getUserStateFromRequest( $this->_context.'.search', 'search', '', 'string' );
		$search				= JString::strtolower( $search );

		$where = array();

		if ($filter_catid > 0) {
			$where[] = 'a.catid = '.(int) $filter_catid;
		}
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
	
	function getNotApprovedImage() {
		
		$query = 'SELECT COUNT(a.id) AS count'
			.' FROM #__phocagallery AS a'
			.' WHERE approved = 0';
		$this->_db->setQuery($query, 0, 1);
		$countNotApproved = $this->_db->loadObject();
		return $countNotApproved;
	}
}
?>