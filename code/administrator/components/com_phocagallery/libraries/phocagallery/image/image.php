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

class PhocaGalleryImage
{
	function getFormatIcon() {
		$paramsC 	= JComponentHelper::getParams('com_phocagallery') ;
		$iconFormat = $paramsC->get( 'icon_format', 'gif' );
		return $iconFormat;
	}

	function getImageSize($filename, $returnString = 0, $extLink = 0) {
		
		phocagalleryimport('phocagallery.image.image');
		phocagalleryimport('phocagallery.path.path');
		
		if ($extLink == 1) {
			$fileNameAbs	= $filename;
		} else {
			$path			= &PhocaGalleryPath::getPath();
			$fileNameAbs	= JPath::clean($path->image_abs . $filename);
			$formatIcon 	= &PhocaGalleryImage::getFormatIcon();
		
			if (!JFile::exists($fileNameAbs)) {
				$fileNameAbs	= $path->image_abs_front . 'phoca_thumb_l_no_image.' . $formatIcon;
			}
		}

		if ($returnString == 1) {
			$imageSize = getimagesize($fileNameAbs);
			return $imageSize[0] . ' x '.$imageSize[1];
		} else {
			return getimagesize($fileNameAbs);
		}
	}
	
	function getRealImageSize($filename, $size = 'large', $extLink = 0) {
	
		phocagalleryimport('phocagallery.file.thumbnail');
		
		if ($extLink == 1) {
			list($w, $h, $type) = @GetImageSize($filename);
		} else {
			$thumbName			= PhocaGalleryFileThumbnail::getThumbnailName ($filename, $size);
			list($w, $h, $type) = @getimagesize($thumbName->abs);
		}
		$size = '';
		if (isset($w) && isset($h)) {
			$size['w'] 	= $w;
			$size['h']	= $h;
		} else {
			$size['w'] 	= 0;
			$size['h']	= 0;
		}
		return $size;
	}
	
	
	function correctSizeWithRate($width, $height, $corWidth = 100, $corHeight = 100) {
		$image['width']		= $corWidth;
		$image['height']	= $corHeight;
		

		
		if ($width > $height) {
			if ($width > $corWidth) {
				$image['width']		= $corWidth;
				$rate 				= $width / $corWidth;
				$image['height']	= $height / $rate;
			} else {
				$image['width']		= $width;
				$image['height']	= $height;
			}
		} else {
			if ($height > $corHeight) {
				$image['height']	= $corHeight;
				$rate 				= $height / $corHeight;
				$image['width'] 	= $width / $rate;
			} else {
				$image['width']		= $width;
				$image['height']	= $height;
			}
		}
		return $image;
	}
	
	function correctSize($imageSize, $size = 100, $sizeBox = 100, $sizeAdd = 0) {

		$image['size']	= $imageSize;
		if ($image['size'] < $size ) {
			$image['size']		= $size;
			$image['boxsize'] 	= $size + $sizeAdd;
		} else {
			$image['boxsize'] 	= $image['size'] + $sizeAdd;
		}
		return $image;		
	}
	
	function correctSwitchSize($switchHeight, $switchWidth) {

		$switchImage['height'] 	= $switchHeight;
		$switchImage['centerh']	= ($switchHeight / 2) - 18;
		$switchImage['width'] 	= $switchWidth;
		$switchImage['centerw']	= ($switchWidth / 2) - 18;
		$switchImage['height']	= $switchImage['height'] + 5;
		return $switchImage;		
	}
	
	function setBoxSize(
		$imageHeight,
		$imageWidth, 
		$name, 
		$detail 				= 0, 
		$download				= 0,
		$vm						= 0,
		$startpiclens			= 0,
		$trash					= 0, 
		$publishunpublish		= 0,
		$geo					= 0, 
		$camerainfo				= 0, 
		$extlink1				= 0, 
		$extlink2				= 0, 
		$boxSpace				= 0,
		$imageShadow 			= '',
		$rateImage 				= 0,
		$iconfolder 			= 0,
		$imgdescbox 			= 0,
		$approvednotapproved	= 0, 
		$commentImage 			= 0) {
		
		$w 	= 20;
		$w2 = 25;
		$w3 = 18;
		
		$boxWidth 	= 0;
		if ($detail == 1) {
			$boxWidth = $boxWidth + $w;
		}
		if ($download > 0) {
			$boxWidth = $boxWidth + $w;
		}
		if ($vm == 1) {
			$boxWidth = $boxWidth + $w;
		}
		if ($startpiclens == 1) {
			$boxWidth = $boxWidth + $w;
		}
		if ($trash == 1) {
			$boxWidth = $boxWidth + $w;
		}
		if ($publishunpublish == 1) {
			$boxWidth = $boxWidth + $w;
		}
		if ($geo == 1) {
			$boxWidth = $boxWidth + $w;
		}
		if ($camerainfo == 1) {
			$boxWidth = $boxWidth + $w;
		}
		if ($extlink1 == 1) {
			$boxWidth = $boxWidth + $w;
		}
		if ($extlink2 == 1) {
			$boxWidth = $boxWidth + $w;
		}

		if ($approvednotapproved == 1) {
			$boxWidth = $boxWidth + $w;
		}
		if ($commentImage == 1) {
			$boxWidth = $boxWidth + $w;
		}
		
		// Name
		if ($name == 1 || $name == 2) {
			$imageHeight['boxsize'] = $imageHeight['boxsize'] + $w;
		}
		
		// Rate Image
		if ($rateImage == 1) {
			$imageHeight['boxsize'] = $imageHeight['boxsize'] + $w2;
		}

		$boxHeightRows 			= ceil($boxWidth/$imageWidth['boxsize']);
		$imageHeight['boxsize'] = ($w * $boxHeightRows) + $imageHeight['boxsize'];

		
		if ( $imageShadow != 'none' ) {		
			$imageHeight['boxsize'] = $imageHeight['boxsize'] + $w3;
		}
		
		// Icon folder - is not situated in image boxes but it affect it
		// There were no icons but icon is here
		if ($iconfolder == 1 && $boxWidth == 0) {
			$imageHeight['boxsize'] = $imageHeight['boxsize'] + $w;
		}
		
		// Image Description Box Heiht in Category View
		$imageHeight['boxsize'] = $imageHeight['boxsize'] + (int)$imgdescbox;
	
		$imageHeight['boxsize'] = $imageHeight['boxsize'] + $boxSpace;
		
		
		return $imageHeight['boxsize'];
	}
	
	function getJpegQuality($jpegQuality) {
		if ((int)$jpegQuality < 0) {
			$jpegQuality = 0;
		}
		if ((int)$jpegQuality > 100) {
			$jpegQuality = 100;
		}
		return $jpegQuality;
	}
	
	/*
	 * Transform image (only with html method) for overlib effect e.g.
	 *
	 * @param array An array of image size (width, height)
	 * @param int Rate
	 * @access public
	 */
	 
	 function getTransformImageArray($imgSize, $rate) {
		if (isset($imgSize[0]) && isset($imgSize[1])) {
			$w = (int)$imgSize[0];
			$h = (int)$imgSize[1];
		
			if ($w != 0) {$w = $w/$rate;} // plus or minus should be divided, not null
			if ($h != 0) {$h = $h/$rate;}
			$wHOutput = array('width' => $w, 'height' => $h);
		} else {
			$w = $h = 0;
			$wHOutput = array();
		}
		return $wHOutput;
	}
}
?>