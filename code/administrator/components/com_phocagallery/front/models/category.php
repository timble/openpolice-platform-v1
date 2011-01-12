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
phocagalleryimport('phocagallery.ordering.ordering');
phocagalleryimport('phocagallery.file.filethumbnail');
class PhocagalleryModelCategory extends JModel
{
	var $_id 				= null;
	var $_data 				= null;
	var $_category 			= null;
	var $_total 			= null;
	var $_context 			= 'com_phocagallery.category';

	function __construct() {
		
		global $mainframe;
		parent::__construct();

		$config 			= JFactory::getConfig();		
		$paramsC 			= JComponentHelper::getParams('com_phocagallery') ;
		$default_pagination	= $paramsC->get( 'default_pagination_category', '20' );
		$context			= $this->_context.'.';
	
		// Get the pagination request variables
		$this->setState('limit', $mainframe->getUserStateFromRequest($context .'limit', 'limit', $default_pagination, 'int'));
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
		// In case limit has been changed, adjust limitstart accordingly
		$this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));
		// Get the filter request variables
		$this->setState('filter_order', JRequest::getCmd('filter_order', 'ordering'));
		$this->setState('filter_order_dir', JRequest::getCmd('filter_order_Dir', 'ASC'));
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	}

	function setId($id) {
		$this->_id			= $id;
		$this->_category	= null;
	}
	
	/*
	 * IMAGES
	 */
	function getData( $rightDisplayDelete = 0) {
		if (empty($this->_data)) { 
		  
			$query = $this->_buildQuery($rightDisplayDelete);
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;
	 }

	function getTotal($rightDisplayDelete = 0) {
		if (empty($this->_total)) {
			$query = $this->_buildQuery($rightDisplayDelete);
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}

	function getPagination($rightDisplayDelete = 0) {
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new PhocaGalleryPaginationCategory( $this->getTotal($rightDisplayDelete), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	function _buildQuery($rightDisplayDelete = 0) {
		
		global $mainframe;
		$params				= &$mainframe->getParams();
		$image_ordering		= $params->get( 'image_ordering', 1 );
		$imageOrdering 		= PhocaGalleryOrdering::getOrderingString($image_ordering);
		
		// Link from comment system
		$wherecimgid	= '';
		$cimgid			= JRequest::getVar( 'cimgid', 0, '', 'int');
		if ($cimgid > 0) {
			$wherecimgid	= ' AND a.id = '.(int)$cimgid;
		}
		
		if ($rightDisplayDelete == 0 ) {
			$published  = ' AND published = 1';
			$published  .= ' AND approved = 1';
		} else {
			$published  = '';
		}
		
		$votes	= ' ORDER BY a.';
		switch ($imageOrdering) {
		  case 'count ASC':
			$votes	= ' ORDER BY r.';
			break;
		  case 'count DESC':
			$votes	= ' ORDER BY r.';
			break;
		  case 'average ASC':
			$votes	= ' ORDER BY r.';
			break;
		  case 'average DESC':
			$votes	= ' ORDER BY r.';
			break;
		  default:
			$votes	= ' ORDER BY a.';
		}
		
		$query = 'SELECT a.*, r.count as count, r.average as average'
			.' FROM #__phocagallery AS a'
			.' LEFT JOIN #__phocagallery_img_votes_statistics AS r ON r.imgid = a.id'
			.' WHERE a.catid = '.(int) $this->_id
			.$wherecimgid
			.$published
			. $votes . $imageOrdering;
			
		return $query;
	}

	/*
	 * CATEGORY - get info about this category
	 */
	function getCategory() {
		
		global $mainframe;
		if ($this->_loadCategory()) {
			
			$user = &JFactory::getUser();
			if (!$this->_category->published) {
				//$mainframe->redirect(JRoute::_('index.php', false), JText::_("PHOCAGALLERY_CATEGORY_IS_UNPUBLISHED"));
				JError::raiseError( 404, JText::_( "PHOCAGALLERY_CATEGORY_IS_UNPUBLISHED" ) );
				exit;
			}
			if (!$this->_category->approved) {
				//$mainframe->redirect(JRoute::_('index.php', false), JText::_("PHOCAGALLERY_CATEGORY_IS_UNAUTHORIZED"));// don't loop
				JError::raiseError( 404, JText::_( "PHOCAGALLERY_CATEGORY_IS_UNAUTHORIZED" ) );
				exit;
			}
			
			// USER RIGHT - ACCESS - - - - - -
			$rightDisplay	= 1;//default is set to 1 (all users can see the category)
			if (!empty($this->_category)) {
				$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $this->_category->accessuserid, $this->_category->access, $user->get('aid', 0), $user->get('id', 0), 0);
			}
			
			if ($rightDisplay == 0) {
				$uri 			= &JFactory::getURI();
				$tmpl['pl']		= 'index.php?option=com_user&view=login&return='.base64_encode($uri->toString());
				$mainframe->redirect(JRoute::_($tmpl['pl'], false), JText::_("ALERTNOTAUTH"));
				exit;
			}
			// - - - - - - - - - - - - - - - - 
		}
		return $this->_category;
	}
	
	function _loadCategory() {
		if (empty($this->_category)){
			
			$query = 'SELECT c.*,' .
				' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as slug '.
				' FROM #__phocagallery_categories AS c' .
				' WHERE c.id = '. (int) $this->_id;
				' AND c.approved = 1';
			$this->_db->setQuery($query, 0, 1);
			$this->_category = $this->_db->loadObject();
		}
		return true;
	}
	
	
	/*
	 * PARENT CATEGORIES
	 */
	 function getParentCategory() {
	
		global $mainframe;
		$params				= &$mainframe->getParams();
		$category_ordering	= $params->get( 'category_ordering', 1 );
		$categoryOrdering 		= PhocaGalleryOrdering::getOrderingString($category_ordering);

		$query = 'SELECT *' .
			' FROM #__phocagallery_categories' .
			' WHERE id = '.(int) $this->_category->parent_id.
			' AND published = 1' .
			' AND approved = 1' .
			' AND id <> '.(int) $this->_category->id.
			' ORDER BY '.$categoryOrdering;
		$this->_db->setQuery($query, 0, 1);
		$parentCategory = $this->_db->loadObject();
			
		return $parentCategory ;
	}
	
	/*
	 * SUB CATEGORIES
	 */
	function getSubCategory() {
	
		global $mainframe;
		$params				= &$mainframe->getParams();
		$category_ordering	= $params->get( 'category_ordering', 1 );
		$categoryOrdering 	= PhocaGalleryOrdering::getOrderingString($category_ordering);
		
		
		//$query = 'SELECT c.*, COUNT(a.id) countimage' ... Cannot be used because get error if there is no image
		$query = 'SELECT c.*, a.filename, a.extm, a.exts, a.extw, a.exth'
			.' FROM #__phocagallery_categories AS c'
			.' LEFT JOIN #__phocagallery AS a ON c.id = a.catid'
			.' WHERE c.parent_id = '.(int) $this->_id
			.' AND c.published = 1'
			.' AND c.approved = 1'
			.' AND c.id <> '.(int) $this->_id
		//	.' AND a.published = 1'
		//	.' AND countimage > 0'
		//	.' AND (SELECT COUNT(a.id) AS countimage'
		//	.' FROM #__phocagallery as a'
        //	.' WHERE a.catid = c.id' 
        //	.' AND a.published = 1) > 0'
			.' GROUP BY c.id'
			.' ORDER BY c.'.$categoryOrdering;
			
		$this->_db->setQuery($query);
		$subCategory = $this->_db->loadObjectList();
		return $subCategory;
	}
	
	// Called from SubCategories
	// Called from Category Controller
	function getCountItem($catid = 0, $rightDisplayDelete = 0) {
	
		if ($rightDisplayDelete == 0 ) {
			$published  = ' WHERE a.published = 1 AND a.approved = 1 AND a.catid = '.$catid;
		} else {
			$published  = ' WHERE a.catid = '.$catid;
		}
		
		$query = 'SELECT COUNT(a.id) FROM #__phocagallery AS a'
			. $published;
		;
		$this->_db->setQuery( $query );
		if (!$this->_db->query()) {
			$this->setError('Database Error 3');
			return false;
		}
		return $this->_db->loadRow();
	}
	
	
	/*
	 * Called from Controller
	 */	
	function getCategoryIdFromImageId($id) {
		// id is id
		$query = 'SELECT a.catid' .
			' FROM #__phocagallery AS a' .
			' WHERE a.id = '. (int) $id;
		$this->_db->setQuery($query, 0, 1);
		$categoryId = $this->_db->loadObject();
		
		return $categoryId;
	}

	function getCategoryAlias($id) {
		// id is catid
		$query = 'SELECT c.alias' .
			' FROM #__phocagallery_categories AS c' .
			' WHERE c.id = '. (int) $id;
		$this->_db->setQuery($query, 0, 1);
		$categoryAlias = $this->_db->loadObject();

		return $categoryAlias;
	}
	
	/*
	 * Actions
	 */
	function delete($id = 0) {
		
		// Get all filenames we want to delete from database, we delete all thumbnails from server of this file
		$queryd = 'SELECT filename as filename FROM #__phocagallery WHERE id ='.(int)$id;
		$this->_db->setQuery($queryd);
		$file_object = $this->_db->loadObjectList();

		$query = 'DELETE FROM #__phocagallery'
			. ' WHERE id ='.(int)$id;
			
		$this->_db->setQuery( $query );
		if(!$this->_db->query()) {
			$this->setError('Database Error 2');
			return false;
		}
		
		// Delete thumbnails - medium and large, small from server
		// All id we want to delete - gel all filenames
		foreach ($file_object as $key => $value) {
			//The file can be stored in other category - don't delete it from server because other category use it
			$querys = "SELECT id as id FROM #__phocagallery WHERE filename='".$value->filename."' ";
			$this->_db->setQuery($queryd);
			$same_file_object = $this->_db->loadObject();
			
			//same file in other category doesn't exist - we can delete it
			if (!$same_file_object){
				//Delete all thumbnail files but not original
				PhocaGalleryFileThumbnail::deleteFileThumbnail($value->filename, 1, 1, 1);
				PhocaGalleryFile::deleteFile($value->filename);
			}
		}
		return true;
	}

	function publish($id = 0, $publish = 1) {
		
		$user 	=& JFactory::getUser();
		$query = 'UPDATE #__phocagallery'
			. ' SET published = '.(int) $publish
			. ' WHERE id = '.(int)$id
			. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )';
		
		$this->_db->setQuery( $query );
		if (!$this->_db->query()) {
			$this->setError('Database Error 2');
			return false;
		}
		return true;
	}
	
	function store($data, $return) {
		//If this file doesn't exists don't save it
		if (!PhocaGalleryFile::existsFileOriginal($data['filename'])) {
			$this->setError('File not exists');
			return false;
		}
		
		$data['imgorigsize'] 	= PhocaGalleryFile::getFileSize($data['filename'], 0);
		
		//If there is no title and no alias, use filename as title and alias
		if (!isset($data['title']) || (isset($data['title']) && $data['title'] == '')) {
			$data['title'] = PhocaGalleryFile::getTitleFromFile($data['filename']);
		}

		if (!isset($data['alias']) || (isset($data['alias']) && $data['alias'] == '')) {
			$data['alias'] = PhocaGalleryFile::getTitleFromFile($data['filename']);
		}
		
		//clean alias name (no bad characters)
		$data['alias'] = PhocaGalleryText::getAliasName($data['alias']);
		
		$row =& $this->getTable('phocagallery');
		
		// Bind the form fields to the Phoca gallery table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Create the timestamp for the date
		$row->date = gmdate('Y-m-d H:i:s');

		// if new item, order last in appropriate group
		if (!$row->id) {
			$where = 'catid = ' . (int) $row->catid ;
			$row->ordering = $row->getNextOrder( $where );
		}

		// Make sure the Phoca gallery table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the Phoca gallery table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		//Create thumbnail small, medium, large	
		$returnFrontMessage = PhocaGalleryFileThumbnail::getOrCreateThumbnail($row->filename, $return, 1, 1, 1, 1);
		
		if ($returnFrontMessage == 'Success') {
			return true;
		} else {
			return false;
		}
		
	}
	
	function rate($data) {
		$row =& $this->getTable('phocagalleryvotes');
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		$row->date 		= gmdate('Y-m-d H:i:s');
		
		$row->published = 1;

		if (!$row->id) {
			$where = 'catid = ' . (int) $row->catid ;
			$row->ordering = $row->getNextOrder( $where );
		}

		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// Update the Vote Statistics
		phocagalleryimport('phocagallery.rate.ratecategory');
		if (!PhocaGalleryRateCategory::updateVoteStatistics( $data['catid'])) {
			return false;
		}
		
		return true;
	}
	
	function comment($data) {
		
		$row =& $this->getTable('phocagallerycomments');
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		$row->date 		= gmdate('Y-m-d H:i:s');
		$row->published = 1;

		if (!$row->id) {
			$where = 'catid = ' . (int) $row->catid ;
			$row->ordering = $row->getNextOrder( $where );
		}

		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function hit($id) {
	
		global $mainframe;
		$table = & JTable::getInstance('phocagalleryc', 'Table');
		$table->hit($id);
		return true;
	}
	
	
	
	function getCountImages($catId, $published = 1) {
		global $mainframe;
		
		$query = 'SELECT COUNT(i.id) AS countimg'
			.' FROM #__phocagallery AS i'
			.' WHERE i.catid = '. (int) $catId
			.' AND i.published ='.(int)$published
			.' AND i.approved = 1';
		$this->_db->setQuery($query, 0, 1);
		$countPublished = $this->_db->loadObject();
		
		return $countPublished;
	}
	
	function getHits($catId) {
		global $mainframe;
		
		$query = 'SELECT cc.hits AS catviewed'
			.' FROM #__phocagallery_categories AS cc'
			.' WHERE cc.id = '. (int) $catId;
		$this->_db->setQuery($query, 0, 1);
		$categoryViewed = $this->_db->loadObject();
		
		return $categoryViewed;
	}
	
	function getStatisticsImages($catId, $order, $order2 = 'ASC', $limit = 3) {
	
		$query = 'SELECT i.*'
			.' FROM #__phocagallery AS i'
			.' WHERE i.catid = '.(int) $catId
			.' AND i.published = 1'
			.' AND i.approved = 1'
			.' ORDER BY '.$order.' '.$order2;
			
		$this->_db->setQuery($query, 0, $limit);
		$statistics = $this->_db->loadObjectList();
		$item = array();
	 
			$count = 0;
			$total = count($statistics);
			for($i = 0; $i < $total; $i++) {
				$statisticsData[$count] 		= $statistics[$i] ;
				$item[$i] 						=& $statisticsData[$count];
				$item[$i]->slug 				= $item[$i]->id.':'.$item[$i]->alias;
				$item[$i]->item_type 			= "image";
				if (isset($item[$i]->extid) && $item[$i]->extid != '') {
					$item[$i]->linkthumbnailpath = $item[$i]->extm;
				} else {
					$item[$i]->linkthumbnailpath  = PhocaGalleryImageFront::displayCategoryImageOrNoImage($item[$i]->filename, 'medium');
				}
				$count++;
			}
		return $item;
	}
}
?>