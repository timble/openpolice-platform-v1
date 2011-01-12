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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
phocagalleryimport('phocagallery.file.filefolderlist');

class PhocaGalleryCpModelPhocaGalleryM extends JModel
{
	var $imageCount;
	var $categoryCount;
	
	/*form*/
	function __construct() {
		$this->imageCount 		= 0;
		$this->categoryCount 	= 0;
		parent::__construct();
	}

	function &getData() {
		$this->_initData();
		return $this->_data;
	}

	function setImageCount($count) {
		$this->imageCount = $this->imageCount + $count;
	}
	
	function setCategoryCount($count) {
		$this->categoryCount = $this->categoryCount + $count;
	}


	function store($data) {		
		global $mainframe;
		
		//Params
		$params				= &JComponentHelper::getParams( 'com_phocagallery' );
		$clean_thumbnails 	= $params->get( 'clean_thumbnails', 0 );
		
		//Get folder variables from Helper
		$path 			= PhocaGalleryPath::getPath();
		$origPath 		= $path->image_abs;
		$origPathServer = str_replace(DS, '/', $path->image_abs);
		
		// Cache all existing categories	
		$query = 'SELECT id, title, parent_id'
	    . ' FROM #__phocagallery_categories' ;
		$this->_db->setQuery( $query );
	    $existingCategories = $this->_db->loadObjectList() ;
		
		// Cache all existing images
		$query = 'SELECT catid, filename'
	    . ' FROM #__phocagallery';	    
		$this->_db->setQuery( $query );
	    $existingImages = $this->_db->loadObjectList() ;
		
		$result->category_count = 0;
		$result->image_count 	= 0;
		
		if (isset($data['foldercid'])) {
			foreach ($data['foldercid'] as $foldername) {
				if (strlen($foldername) > 0) {
					$fullPath = $path->image_abs.$foldername;
					$result = $this->_createCategoriesRecursive( $origPathServer, $fullPath, $existingCategories, $existingImages, $data['catid'], $data['published'] );					
				}		
			}
		}
	
		if (isset($data['cid'])) {
			foreach ($data['cid'] as $filename) {				
				if ($filename) {
					$ext = strtolower(JFile::getExt($filename));
					// Don't create thumbnails from defined files (don't save them into a database)...			
					$dontCreateThumb	= PhocaGalleryFileThumbnail::dontCreateThumb ($filename);
					if ($dontCreateThumb == 1) {
						$ext = '';// WE USE $ext FOR NOT CREATE A THUMBNAIL CLAUSE
					}
					if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'jpeg') {	
			
						$row =& $this->getTable('phocagallery');
						
						$datam = array();
						$datam['published']		= $data['published'];
						$datam['catid']			= $data['catid'];
						$datam['approved']		= 1;
						$datam['filename']		= $filename;
						$datam['title']			= PhocaGalleryFile::getTitleFromFile($filename);
						$datam['alias'] 		= PhocaGalleryText::getAliasName($datam['title']);
						$datam['imgorigsize'] 	= PhocaGalleryFile::getFileSize($datam['filename'], 0);
						
					
						// Save
						// Bind the form fields to the Phoca gallery table
						if (!$row->bind($datam)) {
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
						$result->image_count++;
					}
				}
			}
			$this->setImageCount($result->image_count);
			
		}
		$msg = $this->categoryCount. ' ' .JText::_('Categories added') .', '.$this->imageCount. ' ' . JText::_('Images added');
		$mainframe->redirect('index.php?option=com_phocagallery&view=phocagallerys&countimg='.$this->imageCount, JText::_( $msg ));		
		
		// - - - - - - - - - - - - - - - - - 
		//Create thumbnail small, medium, large		
		//file - abc.img, file_no - folder/abc.img
		//Get folder variables from Helper
		$refresh_url 	= 'index.php?option=com_phocagallery&controller=phocagallery&task=thumbs';	
		$fileThumb 		= PhocaGalleryFileThumbnail::getOrCreateThumbnail($row->filename, $refresh_url, 1, 1, 1);

		//Clean Thumbs Folder if there are thumbnail files but not original file
		if ($clean_thumbnails == 1) {
			PhocaGalleryFolder::cleanThumbsFolder();
		}
		// - - - - - - - - - - - - - - - - -
		return true;
	}
	
	function _getCategoryId( &$existingCategories, &$title, $parentId ) {
	    $id = -1 ;
		$i 	= 0;
		$count = count($existingCategories);
		
		while ( $id == -1 && $i < $count ) {
			if ( $existingCategories[$i]->title == $title &&
			     $existingCategories[$i]->parent_id == $parentId ) {
				$id = $existingCategories[$i]->id ;
			}
			$i++;
		}
		return $id ;
	}
	
	function _ImageExist( &$existing_image, &$filename, $catid ) {
	    $result = false ;
		$i 		= 0;
		$count = count($existing_image);
		
		while ( $result == false && $i < $count ) {
			if ( $existing_image[$i]->filename == $filename &&
			     $existing_image[$i]->catid == $catid ) {
				$result = true;
			}
			$i++;
		}
		return $result;
	}
	
	function _addAllImagesFromFolder(&$existingImages, $category_id, $fullPath, $rel_path, $published = 1) {
		$count = 0;
		$fileList = JFolder::files( $fullPath );
		natcasesort($fileList);
		// Iterate over the files if they exist
		//file - abc.img, file_no - folder/abc.img
	
		if ($fileList !== false) {
			foreach ($fileList as $filename) {
			    $storedfilename	= ltrim(str_replace(DS, '/', JPath::clean($rel_path . DS . $filename )), '/');
				$ext = strtolower(JFile::getExt($filename));
				// Don't create thumbnails from defined files (don't save them into a database)...			
				$dontCreateThumb	= PhocaGalleryFileThumbnail::dontCreateThumb ($filename);
				if ($dontCreateThumb == 1) {
					$ext = '';// WE USE $ext FOR NOT CREATE A THUMBNAIL CLAUSE
				}
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'jpeg') {				
					if (JFile::exists($fullPath.DS.$filename) && 
					    substr($filename, 0, 1) != '.' && 
						strtolower($filename) !== 'index.html' &&
						!$this->_ImageExist($existingImages, $storedfilename, $category_id) ) {
						
						$row =& $this->getTable('phocagallery');
						
						$datam = array();
						$datam['published']		= $published;
						$datam['catid']			= $category_id;
						$datam['filename']		= $storedfilename;
						$datam['approved']		= 1;
						$datam['title']			= PhocaGalleryFile::getTitleFromFile($filename);
						$datam['alias'] 		= PhocaGalleryText::getAliasName($datam['title']);
						$datam['imgorigsize'] 	= PhocaGalleryFile::getFileSize($datam['filename'], 0);
	
						// Save
						// Bind the form fields to the Phoca gallery table
						if (!$row->bind($datam)) {
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
						
						$image 				= new JObject();
					    $image->filename 	= $storedfilename ;
					    $image->catid 		= $category_id;
					    $existingImages[] 	= &$image ;
						$count++ ;
					}
				} 
			}
		}
		
	//	$this->setImageCount($count);
		return $count;
	}
	
	function _createCategoriesRecursive(&$origPathServer, $path, &$existingCategories, &$existingImages, $parentId = 0, $published = 1 ) {
		$totalresult->image_count 		= 0 ;
		$totalresult->category_count	= 0 ;
				
		$categoryName 	= basename($path);
		$id 			= $this->_getCategoryId( $existingCategories, $categoryName, $parentId ) ;
		$category 		= null;
		
		// Full path: eg. "/home/www/joomla/images/categ/subcat/"
		$fullPath	   	= str_replace(DS, '/', JPath::clean(DS . $path));
		// Relative path eg "categ/subcat"
		$relativePath 	= str_replace($origPathServer, '', $fullPath);
		
		// Category doesn't exist
		if ( $id == -1 ) {
		  $row =& $this->getTable('phocagalleryc');
		  $row->published 	= $published;
		  $row->approved	= 1;
		  $row->parent_id 	= $parentId;
		  $row->title 		= $categoryName;
		  
		  // Create the timestamp for the date
		  $row->date 		= gmdate('Y-m-d H:i:s');
		  $row->alias 		= PhocaGalleryText::getAliasName($categoryName);
		  $row->userfolder	= ltrim(str_replace(DS, '/', JPath::clean($relativePath )), '/');
		  $row->ordering 	= $row->getNextOrder( "parent_id = " . $this->_db->Quote($row->parent_id) );				
		
		  if (!$row->check()) {
			JError::raiseError(500, $row->getError('Check Problem') );
		  }

		  if (!$row->store()) {
			JError::raiseError(500, $row->getError('Store Problem') );
		  }
		  
		  $category 			= new JObject();
		  $category->title 		= $categoryName ;
		  $category->parent_id 	= $parentId;
		  $category->id 		= $row->id;
		  $totalresult->category_count++;
		  $id = $category->id;
		  $existingCategories[] = &$category ;
		  $this->setCategoryCount(1);//This subcategory was added
		}
		
			

		// Add all images from this folder
		$totalresult->image_count += $this->_addAllImagesFromFolder( $existingImages, $id, $path, $relativePath, $published );
		$this->setImageCount($totalresult->image_count);
		
		// Do sub folders
		$parentId 		= $id;		
		$folderList 	= JFolder::folders( $path, $filter = '.', $recurse = false, $fullpath = true, $exclude = array('thumbs') );		
		// Iterate over the folders if they exist
		if ($folderList !== false) {
			foreach ($folderList as $folder) {
				//$this->setCategoryCount(1);//This subcategory was added
				$result = $this->_createCategoriesRecursive( $origPathServer, $folder, $existingCategories, $existingImages, $id , $published);
				$totalresult->image_count += $result->image_count ;
				$totalresult->category_count += $result->category_count ;
			}
		}
		return $totalresult ;
	}
	
	function _loadData() {
		if (empty($this->_data)) {
			$query = 'SELECT p.*, cc.title AS category,'.
					' cc.published AS cat_pub, cc.access AS cat_access'.
					' FROM #__phocagallery AS p' .
					' LEFT JOIN #__phocagallery_categories AS cc ON cc.id = p.catid' .
					' WHERE p.id = '.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}
	
	function _initData() {
		if (empty($this->_data)) {
			$table = new stdClass();
			$table->id					= 0;
			$table->catid				= 0;
			$table->sid					= 0;
			$table->title				= null;
			$table->alias				= null;
			$table->filename         	= null;
			$table->description			= null;
			$table->date				= null;
			$table->hits				= 0;
			$table->latitude			= null;
			$table->longitude			= null;
			$table->zoom				= null;
			$table->geotitle			= null;
			$table->videocode			= null;
			$table->vmproductid			= null;
			$table->imgorigsize			= null;
			$table->published			= 0;
			$table->approved			= 0;
			$table->checked_out			= 0;
			$table->checked_out_time	= 0;
			$table->ordering			= 0;
			$table->params				= null;
			$table->extlink1			= null;
			$table->extlink2			= null;
			$table->category			= null;
			$this->_data				= $table;
			return (boolean) $this->_data;
		}
		return true;
	}
	
	/*
	 * Images
	 */
	function getState($property = null) {
		static $set;

		if (!$set) {
			$folder = JRequest::getVar( 'folder', '', '', 'path' );
			$this->setState('folder', $folder);

			$parent = str_replace("\\", "/", dirname($folder));
			$parent = ($parent == '.') ? null : $parent;
			$this->setState('parent', $parent);
			$set = true;
		}
		return parent::getState($property);
	}

	function getImages() {
		$refreshUrl = 'index.php?option=com_phocagallery&view=phocagalleryi&tmpl=component';
		$list = PhocaGalleryFileFolderList::getList(0,0,0,$refreshUrl);
		return $list['images'];
	}

	function getFolders() {
		$refreshUrl = 'index.php?option=com_phocagallery&view=phocagalleryi&tmpl=component';
		$list = PhocaGalleryFileFolderList::getList(0,0,0,$refreshUrl);
		return $list['folders'];
	}

}
?>