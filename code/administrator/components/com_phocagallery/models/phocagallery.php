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

class PhocaGalleryCpModelPhocaGallery extends JModel
{
	function __construct() {
		parent::__construct();
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id) {
		$this->_id				= $id;
		$this->_data			= null;
	}

	function &getData() {
		if ($this->_loadData()) {
			$user = &JFactory::getUser();

			// Check to see if the category is published
			// CHANGE - IF user wants to edit image, he can edit images which are in unpublished category too
			/*if (!$this->_data->cat_pub) {
				JError::raiseError( 404, JText::_("Resource Not Found") );
				return;
			}*/

			// Check whether category access level allows access
			if ($this->_data->cat_access > $user->get('aid', 0)) {
				JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
				return;
			}
		} else  {
			$this->_initData();
		}
		return $this->_data;
	}
	
	function isCheckedOut( $uid=0 ) {
		if ($this->_loadData()) {
			if ($uid) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		}
	}

	function checkin() {
		if ($this->_id) {
			$table = & $this->getTable();
			if(! $table->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}

	function checkout($uid = null) {
		if ($this->_id) {
			// Make sure we have a user id to checkout the article with
			if (is_null($uid)) {
				$user	=& JFactory::getUser();
				$uid	= $user->get('id');
			}
			// Lets get to it and checkout the thing...
			$table = & $this->getTable();
			if(!$table->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}
	
	
	function store($data, &$errorMsg) {
		
		$params						= &JComponentHelper::getParams( 'com_phocagallery' );
		$clean_thumbnails 			= $params->get( 'clean_thumbnails', 0 );
		$fileOriginalNotExist		= 0;
		
		if ($data['extlinkimage'] == 1) {
			$data['imgorigsize'] 	= 0;
			if ($data['title'] == '') {
				$data['title'] = 'External Image';
			}
		} else {
			//If this file doesn't exists don't save it
			if (!PhocaGalleryFile::existsFileOriginal($data['filename'])) {
				//$this->setError('Original File does not exist');
				//return false;
				$fileOriginalNotExist = 1;
				$errorMsg = JText::_('PHOCAGALLERY_ORIGINAL_IMAGE_NOT_EXIST');
			}
		
			$data['imgorigsize'] 	= PhocaGalleryFile::getFileSize($data['filename'], 0);
			
			//If there is no title and no alias, use filename as title and alias
			if ($data['title'] == '') {
				$data['title'] = PhocaGalleryFile::getTitleFromFile($data['filename']);
			}
		}
		

		if ($data['alias'] == '') {
			$data['alias'] = $data['title'];
		}
		
		//clean alias name (no bad characters)
		$data['alias'] = PhocaGalleryText::getAliasName($data['alias']);
		
		$row =& $this->getTable();

		// Bind the form fields to the Phoca gallery table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Create the timestamp for the date
		if (!$row->date) {
			$row->date = gmdate('Y-m-d H:i:s');
		}

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
		
		if ($data['extlinkimage'] == 1 || $fileOriginalNotExist == 1) {
		
		} else {
			// - - - - - - - - - - - - - - - - - -
			//Create thumbnail small, medium, large		
			//file - abc.img, file_no - folder/abc.img
			//Get folder variables from Helper
			//Create thumbnails small, medium, large
			$refresh_url = 'index.php?option=com_phocagallery&controller=phocagallery&task=thumbs';
			$file_thumb = PhocaGalleryFileThumbnail::getOrCreateThumbnail($row->filename, $refresh_url, 1, 1, 1);

			//Clean Thumbs Folder if there are thumbnail files but not original file
			if ($clean_thumbnails == 1) {
				phocagalleryimport('phocagallery.file.filefolder');
				PhocaGalleryFileFolder::cleanThumbsFolder();
			}
			// - - - - - - - - - - - - - - - - - - - - -
		}
		return $row->id;
	}

	function delete($cid = array()) {
		$params				= &JComponentHelper::getParams( 'com_phocagallery' );
		$clean_thumbnails 	= $params->get( 'clean_thumbnails', 0 );
		$result 			= false;

		
		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			
			// - - - - - - - - - - - - - 
			// Get all filenames we want to delete from database, we delete all thumbnails from server of this file
			$queryd = 'SELECT filename as filename FROM #__phocagallery WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery($queryd);
			$fileObject = $this->_db->loadObjectList();
			// - - - - - - - - - - - - - 

			//Delete it from DB
			$query = 'DELETE FROM #__phocagallery'
				. ' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}

			// - - - - - - - - - - - - - - 
			// Delete thumbnails - medium and large, small from server
			// All id we want to delete - gel all filenames
			foreach ($fileObject as $key => $value) {
				//The file can be stored in other category - don't delete it from server because other category use it
				$querys = "SELECT id as id FROM #__phocagallery WHERE filename='".$value->filename."' ";
				$this->_db->setQuery($queryd);
				$sameFileObject = $this->_db->loadObject();
				// same file in other category doesn't exist - we can delete it
				if (!$sameFileObject) {
					PhocaGalleryFileThumbnail::deleteFileThumbnail($value->filename, 1, 1, 1);
				}
			}
			// Clean Thumbs Folder if there are thumbnail files but not original file
			if ($clean_thumbnails == 1) {
				phocagalleryimport('phocagallery.file.filefolder');
				PhocaGalleryFileFolder::cleanThumbsFolder();
			}
			// - - - - - - - - - - - - - - 
		}
		return true;
	}
	
	function recreate($cid = array()) {

		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			$query = 'SELECT a.filename as filename'.
					' FROM #__phocagallery AS a' .
					' WHERE a.id IN ( '.$cids.' )';
			$this->_db->setQuery($query);
			$files = $this->_db->loadObjectList();
			if (isset($files) && count($files)) {
				foreach($files as $key => $value) {
					$deleteThubms = PhocaGalleryFileThumbnail::deleteFileThumbnail($value->filename, 1, 1, 1);
				
					if (!$deleteThubms) {
						return false;
					}
				}
			} else {
				return false;
			}

		} else {
			return false;
		}
		return true;
	}

	function publish($cid = array(), $publish = 1) {
		$user 	=& JFactory::getUser();

		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__phocagallery'
				. ' SET published = '.(int) $publish
				. ' WHERE id IN ( '.$cids.' )'
				. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )'
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}
	
	function approve($cid = array(), $approved = 1) {
		$user 	=& JFactory::getUser();

		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__phocagallery'
				. ' SET approved = '.(int) $approved
				. ' WHERE id IN ( '.$cids.' )'
				. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )'
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	function move($direction) {
		$row =& $this->getTable();
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->move( $direction, ' catid = '.(int) $row->catid.' AND published >= 0 ' )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}


	function saveorder($cid = array(), $order) {
		$row =& $this->getTable();
		$groupings = array();

		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$row->load( (int) $cid[$i] );
			// track categories
			$groupings[] = $row->catid;

			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder('catid = '.(int) $group);
		}
		return true;
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
		if (empty($this->_data))
		{
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
			$table->metakey				= null;
			$table->metadesc			= null;
			$table->extlink1			= null;
			$table->extlink2			= null;
			$table->category			= null;
			$this->_data				= $table;
			return (boolean) $this->_data;
		}
		return true;
	}
	
	
	function disableThumbs() {
		
		$paramsComponentArray 	= '';
		$paramsD 				= array();
		$paramsD[0] 			= array('name' => 'enable_thumb_creation',
										'value'=> 0);
		// Params - Get component params
		$paramsComponent		= JComponentHelper::getParams('com_phocagallery') ;
		$paramsComponentArray 	= $paramsComponent->_registry['_default']['data'];
		
		// if empty object, php doesn't say it...
		$isArray = 0;
		foreach ($paramsComponentArray as $isKey => $isValue) {
			$isArray = 1;
		}

		// If no params are saved, we add only one params
		if ($isArray == 1) {
			// We get the params values from database and add new values ( no lose the other params)
			$newParamsComponent = '';
			foreach ($paramsComponentArray as $keyC => $valueC) {
				$newParamsComponent['params'][$keyC] = $valueC;
				foreach ($paramsD as $keyD => $valueD) {
					if ($valueD['name'] == $keyC) {
						$newParamsComponent['params'][$keyC] = $valueD['value'];
					}
				}
			}
		} else {
			$newParamsComponent = '';
			foreach ($paramsD as $keyD => $valueD) {
				$newParamsComponent['params'][$valueD['name']] = $valueD['value'];
			}
		}
		
		$table =& JTable::getInstance( 'component' );
		$table->loadByOption( 'com_phocagallery' );

		if (!$table->bind($newParamsComponent)) {
			JError::raiseWarning( 500, 'Not a valid component' );
			return false;
		}
			
		// pre-save checks
		if (!$table->check()) {
			JError::raiseWarning( 500, $table->getError('Check Problem') );
			return false;
		}

		// save the changes
		if (!$table->store()) {
			JError::raiseWarning( 500, $table->getError('Store Problem') );
			return false;
		}
		return true;
	}
	
	function rotate($id, $angle, &$errorMsg) {
		phocagalleryimport('phocagallery.image.imagerotate');
		
		if ($id > 0 && $angle !='') {
			$query = 'SELECT a.filename as filename'.
					' FROM #__phocagallery AS a' .
					' WHERE a.id = '.(int) $id;
			$this->_db->setQuery($query);
			$file = $this->_db->loadObject();
			
			
			if (isset($file->filename) && $file->filename != '') {
				
				$thumbNameL	= PhocaGalleryFileThumbnail::getThumbnailName ($file->filename, 'large');
				$thumbNameM	= PhocaGalleryFileThumbnail::getThumbnailName ($file->filename, 'medium');
				$thumbNameS	= PhocaGalleryFileThumbnail::getThumbnailName ($file->filename, 'small');
				
				$errorMsg = $errorMsgS = $errorMsgM = $errorMsgL ='';				
				PhocaGalleryImageRotate::rotateImage($thumbNameL, 'large', $angle, $errorMsgS);
				if ($errorMsgS != '') {
					$errorMsg = $errorMsgS;
					return false;
				}
				PhocaGalleryImageRotate::rotateImage($thumbNameM, 'medium', $angle, $errorMsgM);
				if ($errorMsgM != '') {
					$errorMsg = $errorMsgM;
					return false;
				} 
				PhocaGalleryImageRotate::rotateImage($thumbNameS, 'small', $angle, $errorMsgL);
				if ($errorMsgL != '') {
					$errorMsg = $errorMsgL;
					return false;
				} 

				if ($errorMsgL == '' && $errorMsgM == '' && $errorMsgS == '' ) {
					return true;
				} else {
					$errorMsg = 'ErrorModel1';
					return false;
				}
			}
			$errorMsg = 'ErrorModel2';
			return false;
		}
		$errorMsg = 'ErrorModel3';
		return false;
	}
	
	function deletethumbs($id) {
		
		if ($id > 0) {
			$query = 'SELECT a.filename as filename'.
					' FROM #__phocagallery AS a' .
					' WHERE a.id = '.(int) $id;
			$this->_db->setQuery($query);
			$file = $this->_db->loadObject();
			if (isset($file->filename) && $file->filename != '') {
				
				$deleteThubms = PhocaGalleryFileThumbnail::deleteFileThumbnail($file->filename, 1, 1, 1);
				
				if ($deleteThubms) {
					return true;
				} else {
					return false;
				}
			} return false;
		} return false;
	}
}
?>