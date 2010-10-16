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

class PhocaGalleryCpModelPhocaGalleryD extends JModel
{
	function __construct() {
		parent::__construct();
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id) {
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData() {
		if (!$this->_loadData()) {
			$this->_initData();
		}
		return $this->_data;
	}
	
	function _loadData() {
		if (empty($this->_data)) {
			$query = 'SELECT a.*' .
					' FROM #__phocagallery AS a' .
					' WHERE a.id = '.(int) $this->_id;
			$this->_db->setQuery($query);
			$fileObject = $this->_db->loadObject();
			
			$file 	= new JObject();

			$refresh_url = 'index.php?option=com_phocagallery&view=phocagalleryd&tmpl=component&cid[]='.$this->_id;
			
			//Creata thumbnails if not exist
			PhocaGalleryFileThumbnail::getOrCreateThumbnail($fileObject->filename, $refresh_url, 1, 1, 1);
			
			jimport( 'joomla.filesystem.file' );
			if (!isset($fileObject->filename)) {					
				$file->set('linkthumbnailpath', '');			
			} else {
				$thumbFile = PhocaGalleryFileThumbnail::getThumbnailName ($fileObject->filename, 'large');
				$file->set('linkthumbnailpath', $thumbFile->rel);
				$file->set('extid', $fileObject->extid);
				$file->set('extl', $fileObject->extl);
				$file->set('extw', $fileObject->extw);
				$file->set('exth', $fileObject->exth);
			}
				
			$this->_data = $file;
			return (boolean) $this->_data;
		}
		return true;
	}
	
	function _initData() {
		if (empty($this->_data)) {
			$this->_data	= '';
			return (boolean) $this->_data;
		}
		return true;
	}
	
}
?>
