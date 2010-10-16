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

class PhocaGalleryCpModelPhocaGalleryI extends JModel
{
	function getState($property = null) {
		static $set;

		if (!$set) {
			$folder = JRequest::getVar( 'folder', '', '', 'path' );
			$upload = JRequest::getVar( 'upload', '', '', 'int' );
			

			$this->setState('folder', $folder);

			$parent = str_replace("\\", "/", dirname($folder));
			$parent = ($parent == '.') ? null : $parent;
			$this->setState('parent', $parent);
			$set = true;
		}
		return parent::getState($property);
	}

	function getImages() {
		$tab = JRequest::getVar( 'tab', 0, '', 'int' );
		$refreshUrl = 'index.php?option=com_phocagallery&view=phocagalleryi&tab='.$tab.'&tmpl=component';
		$list = PhocaGalleryFileFolderList::getList(0,1,0,$refreshUrl);
		return $list['images'];
	}

	function getFolders() {
		$tab = JRequest::getVar( 'tab', 0, '', 'int' );
		$refreshUrl = 'index.php?option=com_phocagallery&view=phocagalleryi&tab='.$tab.'&tmpl=component';
		$list = PhocaGalleryFileFolderList::getList(0,0,0,$refreshUrl);
		return $list['folders'];
	}
}
?>