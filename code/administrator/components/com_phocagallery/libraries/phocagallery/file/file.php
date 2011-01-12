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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.filesystem.folder' ); 
jimport( 'joomla.filesystem.file' );
phocagalleryimport('phocagallery.image.image');
phocagalleryimport('phocagallery.path.path');

class PhocaGalleryFile
{
	function getTitleFromFile(&$filename, $displayExt = 0) {
		
		$filename 			= str_replace('//', '/', $filename);
		$filename			= str_replace(DS, '/', $filename);
		$folderArray		= explode('/', $filename);// Explode the filename (folder and file name)
		$countFolderArray	= count($folderArray);// Count this array
		$lastArrayValue 	= $countFolderArray - 1;// The last array value is (Count array - 1)	
		
		$title = new JObject();
		$title->with_extension 		= $folderArray[$lastArrayValue];
		$title->without_extension	= PhocaGalleryFile::removeExtension($folderArray[$lastArrayValue]);
		
		if ($displayExt == 1) {
			return $title->with_extension;
		} else if ($displayExt == 0) {
			return $title->without_extension;
		} else {
			return $title;
		}
	}
	
	function removeExtension($filename) {
		return substr($filename, 0, strrpos( $filename, '.' ));
	}

	
	function getMimeType($filename) {
		$ext = JFile::getExt($filename);		
		switch(strtolower($ext)) {
			case 'png':
				$mime = 'image/png';
			break;
			case 'jpg':
			case 'jpeg':
				$mime = 'image/jpeg';
			break;
			case 'gif':
				$mime = 'image/gif';
			break;
			default:
				$mime = '';
			break;
		}
		return $mime;
	}
	
	function getFileSize($filename, $readable = 1) {
		
		$path			= &PhocaGalleryPath::getPath();
		$fileNameAbs	= JPath::clean($path->image_abs . $filename);
		$formatIcon 	= &PhocaGalleryImage::getFormatIcon();
		
		if (!JFile::exists($fileNameAbs)) {
			$fileNameAbs	= $path->image_abs_front . 'phoca_thumb_l_no_image.' . $formatIcon;
		}	

		if ($readable == 1) {
			return PhocaGalleryFile::getFileSizeReadable(filesize($fileNameAbs));
		} else {
			return filesize($fileNameAbs);
		}
	}
	
	/*
	 * http://aidanlister.com/repos/v/function.size_readable.php
	 */
	function getFileSizeReadable ($size, $retstring = null) {
        $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        if ($retstring === null) { $retstring = '%01.2f %s'; }
        $lastsizestring = end($sizes);
        foreach ($sizes as $sizestring) {
                if ($size < 1024) { break; }
                if ($sizestring != $lastsizestring) { $size /= 1024; }
        }
        if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
        return sprintf($retstring, $size, $sizestring);
	}
	
	function getFileOriginal($filename, $rel = 0) {
		$path	= PhocaGalleryPath::getPath();
		if ($rel == 1) {
			return str_replace('//', '/', $path->image_rel . $filename);
		} else {
			return JPath::clean($path->image_abs . $filename);
		}
	}
	
	function existsFileOriginal($filename) {
		$fileOriginal = PhocaGalleryFile::getFileOriginal($filename);
		if (JFile::exists($fileOriginal)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	function deleteFile ($filename) {			
		$fileOriginal = PhocaGalleryFile::getFileOriginal($filename);
		if (JFile::exists($fileOriginal)){
			JFile::delete($fileOriginal);
			return true;
		}
		return false;
	}
	
}
?>