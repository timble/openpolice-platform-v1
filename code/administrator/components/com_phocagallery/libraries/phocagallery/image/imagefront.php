<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class PhocaGalleryImageFront
{
	/*
	 * IMAGE BACKGROUND - CATEGORIES VIEW - INTERNAL IMAGE
	 * 0-small,1-medium,2-smallFolder,3-mediumFolder,4-smallShadow,5-mediumShadow,6-smallFolderShadow,7-mediumFolderShadow
	 */
	function getCategoriesImageBackground($imgCatSize, $smallImgHeigth, $smallImgWidth, $mediumImgHeight, $mediumImgWidth) {
		
		phocagalleryimport('phocagallery.image.image');
		phocagalleryimport('phocagallery.path.path');
		$formatIcon	= &PhocaGalleryImage::getFormatIcon();
		$path		= &PhocaGalleryPath::getPath();
		$imgBg 		= new JObject();
		
		switch ($imgCatSize) {	
			case 4:
			case 6:			
				$imgBg->image = 'background: url(\''
				.$path->image_rel_front_full . 'shadow3.'.$formatIcon.'\') 50% 50% no-repeat;height:'
				.$smallImgHeigth.'px;width:'.$smallImgWidth.'px;';
				$imgBg->width = $smallImgWidth + 20;//Categories Detailed View
			break;
			
			case 5:
			case 7:
				$imgBg->image = 'background: url(\''
				.$path->image_rel_front_full . 'shadow1.'.$formatIcon.'\') 50% 50% no-repeat;height:'
				.$mediumImgHeight.'px;width:'.$mediumImgWidth.'px;';
				$imgBg->width = $mediumImgWidth + 20;//Categories Detailed View
			break;
			
			case 1:
			case 3:
				$imgBg->image 	= 'width:'.$mediumImgWidth.'px;';
				$imgBg->width	= $mediumImgWidth +20;//Categories Detailed View
			break;
			
			case 0:
			case 2:
			default:
				$imgBg->image 	= 'width:'.$smallImgWidth.'px;';
				$imgBg->width	= $smallImgWidth + 20;//Categories Detailed View
			break;
		}
		return $imgBg;
	}
	
	/*
	 * IMAGE OR FOLDER - CATEGORIES VIEW - INTERNAL IMAGE
	 * 0-small,1-medium,2-smallFolder,3-mediumFolder,4-smallShadow,5-mediumShadow,6-smallFolderShadow,7-mediumFolderShadow
	 */
	function displayCategoriesImageOrFolder ($filename, $imgCategoriesSize, $rightDisplayKey = 0) {
		
		phocagalleryimport('phocagallery.image.image');
		phocagalleryimport('phocagallery.path.path');
		phocagalleryimport('phocagallery.file.filethumbnail');
		
		$formatIcon	= &PhocaGalleryImage::getFormatIcon();
		$path		= &PhocaGalleryPath::getPath();

		// if category is not accessable, display the key in the image:
		$key = '';
		if ((int)$rightDisplayKey == 0) {
			$key = '-key';
		}
		switch ($imgCategoriesSize) {	
			// user wants to display only icon folder (parameters) medium
			case 3:
			case 7:
			$fileThumbnail 		= PhocaGalleryFileThumbnail::getThumbnailName($filename, 'medium');
			$fileThumbnail->rel	= $path->image_rel_front . 'icon-folder-medium'.$key.'.' . $formatIcon;
			break;
			// user wants to display only icon folder (parameters) small
			case 2:
			case 6:
			$fileThumbnail 		= PhocaGalleryFileThumbnail::getThumbnailName($filename, 'small');
			$fileThumbnail->rel	= $path->image_rel_front . 'icon-folder-small-main'.$key.'.' . $formatIcon;
			break;
			
			// standard medium image next to category in categories view - if the file doesn't exist, it will be displayed folder icon
			case 1:
			case 5:
			$fileThumbnail = PhocaGalleryFileThumbnail::getThumbnailName($filename, 'medium');
			if (!JFile::exists($fileThumbnail->abs) || $rightDisplayKey == 0) {
				$fileThumbnail->rel	= $path->image_rel_front . 'icon-folder-medium'.$key.'.' . $formatIcon;
			}
			break;
			
			// standard small image next to category in categories view - if the file doesn't exist, it will be displayed folder icon
			case 0:
			case 4:
			$fileThumbnail = PhocaGalleryFileThumbnail::getThumbnailName($filename, 'small');
			if (!JFile::exists($fileThumbnail->abs) || $rightDisplayKey == 0) {
				$fileThumbnail->rel	= $path->image_rel_front . 'icon-folder-small-main'.$key.'.' . $formatIcon;
			}
			break;
		}
		
		return $fileThumbnail;	
	}
	
	/*
	 * IMAGE OR FOLDER - CATEGORIES VIEW - EXTERNAL IMAGE
	 * 0-small,1-medium,2-smallFolder,3-mediumFolder,4-smallShadow,5-mediumShadow,6-smallFolderShadow,7-mediumFolderShadow
	 */
	function displayCategoriesExtImgOrFolder ($exts, $extm, $extw, $exth, $imgCategoriesSize, $rightDisplayKey = 0) {
		
		phocagalleryimport('phocagallery.image.image');
		phocagalleryimport('phocagallery.path.path');
		phocagalleryimport('phocagallery.file.filethumbnail');
		$formatIcon	= &PhocaGalleryImage::getFormatIcon();
		$path		= &PhocaGalleryPath::getPath();
		
		$fileThumbnail =  new JObject;
		$fileThumbnail->rel 	= '';
		$fileThumbnail->extw 	= '';
		$fileThumbnail->exth 	= '';
		$fileThumbnail->extpic 	= false;
		$extw = explode(',',$extw);
		$exth = explode(',',$exth);
		
		// if category is not accessable, display the key in the image:
		$key = '';
		if ((int)$rightDisplayKey == 0) {
			$key = '-key';
		}
		
		switch ($imgCategoriesSize) {	
			// user wants to display only icon folder (parameters) medium
			case 3:
			case 7:
			$fileThumbnail->rel	= $path->image_rel_front . 'icon-folder-medium'.$key.'.' . $formatIcon;
			break;
			// user wants to display only icon folder (parameters) small
			case 2:
			case 6:
			$fileThumbnail->rel	= $path->image_rel_front . 'icon-folder-small-main'.$key.'.' . $formatIcon;
			break;
			
			// standard medium image next to category in categories view - if the file doesn't exist, it will be displayed folder icon
			case 1:
			case 5:
			if ($extm == '' || (int)$rightDisplayKey == 0) {
				$fileThumbnail->rel		= $path->image_rel_front . 'icon-folder-medium'.$key.'.' . $formatIcon;
			} else {
				$fileThumbnail->rel 	= $extm;
				$fileThumbnail->extw 	= $extw[1];
				$fileThumbnail->exth 	= $exth[1];
				$fileThumbnail->extpic 	= true;
			}
			break;
		
			// standard small image next to category in categories view - if the file doesn't exist, it will be displayed folder icon
			case 0:
			case 4:
			if ($exts == '' || (int)$rightDisplayKey == 0) {
				$fileThumbnail->rel		= $path->image_rel_front . 'icon-folder-small-main'.$key.'.' . $formatIcon;
			}else {
				$fileThumbnail->rel 	= $exts;	
				$fileThumbnail->extw 	= $extw[2];
				$fileThumbnail->exth 	= $exth[2];
				$fileThumbnail->extpic 	= true;
			}
			break;
		}
		return $fileThumbnail;	
	}
	
	/*
	 * IMAGE OR FOLDER - CATEGORY VIEW - INTERNAL IMAGE
	 */
	function displayCategoryImageOrFolder ($filename, $size, $rightDisplayKey, $param= 'display_category_icon_image') {
		
		phocagalleryimport('phocagallery.image.image');
		phocagalleryimport('phocagallery.path.path');
		phocagalleryimport('phocagallery.file.filethumbnail');
		
		$paramsC = JComponentHelper::getParams('com_phocagallery') ;
		
		$formatIcon					= &PhocaGalleryImage::getFormatIcon();
		$path						= &PhocaGalleryPath::getPath();
		$fileThumbnail				= PhocaGalleryFileThumbnail::getThumbnailName($filename, $size);
		$displayCategoryIconImage	= $paramsC->get( $param, 0 );
		$imageBackgroundShadow 		= $paramsC->get( 'image_background_shadow', 'none' );
		
		// if category is not accessable, display the key in the image:
		$key = '';
		if ((int)$rightDisplayKey == 0) {
			$key = '-key';
		}
		
		//Thumbnail_file doesn't exists or user wants to display folder icon
		if (!JFile::exists($fileThumbnail->abs) ||  $displayCategoryIconImage != 1) {
			if ( $imageBackgroundShadow != 'none') {
				$fileThumbnail->rel	= $path->image_rel_front . 'icon-folder-medium'.$key.'.' . $formatIcon;
			} else {
				$fileThumbnail->rel	= $path->image_rel_front . 'icon-folder-medium'.$key.'.' . $formatIcon;
			}
		}	
		return $fileThumbnail;	
	}
	
	
	/*
	 * IMAGE OR FOLDER - CATEGORY VIEW - EXTERNAL IMAGE
	 */
	function displayCategoryExtImgOrFolder ($extS, $extM, $size, $rightDisplayKey, $param= 'display_category_icon_image') {
		
		phocagalleryimport('phocagallery.image.image');
		phocagalleryimport('phocagallery.path.path');
		
		$paramsC = JComponentHelper::getParams('com_phocagallery') ;
		$path				= &PhocaGalleryPath::getPath();
		$formatIcon			= &PhocaGalleryImage::getFormatIcon();
	
		$fileThumbnail = new JObject();
		$fileThumbnail->extm				= $extM;
		$fileThumbnail->exts				= $extS;
		$fileThumbnail->linkthumbnailpath	= $extS; // in case external image doesn't exist or the category is locked
		$displayCategoryIconImage	= $paramsC->get( $param, 0 );
		$imageBackgroundShadow 		= $paramsC->get( 'image_background_shadow', 'none' );

		// if category is not accessable, display the key in the image:
		$key = '';
		if ((int)$rightDisplayKey == 0) {
			$key = '-key';
		}
		
		//Thumbnail_file doesn't exists or user wants to display folder icon
		$fileThumbnail->extpic = true;
		if ($size == 'medium') {
			if ($extM == '' || (int)$rightDisplayKey == 0 || $displayCategoryIconImage != 1) {
				if ( $imageBackgroundShadow != 'none') {
					$fileThumbnail->linkthumbnailpath	= $path->image_rel_front . 'icon-folder-medium'.$key.'.' . $formatIcon;
				} else {
					$fileThumbnail->linkthumbnailpath	= $path->image_rel_front . 'icon-folder-medium'.$key.'.' . $formatIcon;
				}
				$fileThumbnail->extpic = false;
			}
		}
		
		if ($size == 'small') {
			if ($extS == '' || (int)$rightDisplayKey == 0 || $displayCategoryIconImage != 1) {
				if ( $imageBackgroundShadow != 'none') {
					$fileThumbnail->linkthumbnailpath	= $path->image_rel_front . 'icon-folder-small'.$key.'.' . $formatIcon;
				} else {
					$fileThumbnail->linkthumbnailpath	= $path->image_rel_front . 'icon-folder-small'.$key.'.' . $formatIcon;
				}
				$fileThumbnail->extpic = false;
			}
		}
		return $fileThumbnail;	
	}
	
	/*
	 * IMAGE OR FOLDER - CATEGORIES VIEW IN CATEGORY VIEW- INTERNAL IMAGE
	 * 0-small,1-medium,2-smallFolder,3-mediumFolder,4-smallShadow,5-mediumShadow,6-smallFolderShadow,7-mediumFolderShadow
	 * We now the path from CATEGORY VIEW, we only change the path for CATEGORIES VIEW
	 * If there is a folder icon - medium to small main, if image - phoca_thumb_m to phoca_thumb_s
	 */
	function displayCategoriesCVImageOrFolder ($linkThumbnailPath, $imgCategoriesSizeCV) {

		switch((int)$imgCategoriesSizeCV) {
			case 0:
			case 2:
			case 4:
			case 6:
				$imageThumbnail = str_replace('medium', 'small-main', $linkThumbnailPath);

				$imageThumbnail = str_replace('phoca_thumb_m_', 'phoca_thumb_s_', $imageThumbnail);
			break;
			default:
				$imageThumbnail = str_replace('small-main', 'medium', $linkThumbnailPath);
				$imageThumbnail = str_replace('phoca_thumb_s_', 'phoca_thumb_m_', $imageThumbnail);
			break;
		}
		return $imageThumbnail;
	}
	
	/*
	 * IMAGE OR FOLDER - CATEGORIES VIEW IN CATEGORY VIEW- EXTERNAL IMAGE
	 * 0-small,1-medium,2-smallFolder,3-mediumFolder,4-smallShadow,5-mediumShadow,6-smallFolderShadow,7-mediumFolderShadow
	 */
	function displayCategoriesCVExtImgOrFolder ($linkThumbnailPathM, $linkThumbnailPathS, $linkThumbnailPath, $imgCategoriesSizeCV) {
		switch((int)$imgCategoriesSizeCV) {
			case 0:
			case 2:
			case 4:
			case 6:
				if ($linkThumbnailPathS != '') {
					$imageThumbnail = $linkThumbnailPathS;
				} else {
					$imageThumbnail = str_replace('medium', 'small-main', $linkThumbnailPath);
					$imageThumbnail = str_replace('phoca_thumb_m_', 'phoca_thumb_s_', $imageThumbnail);
				}
				
			break;
			default:
				if ($linkThumbnailPathM != '') {
					$imageThumbnail = $linkThumbnailPathM;
				} else {
					$imageThumbnail = str_replace('small-main', 'medium', $linkThumbnailPath);
					$imageThumbnail = str_replace('phoca_thumb_s_', 'phoca_thumb_m_', $imageThumbnail);
				}
				
			break;
		 }
		 return $imageThumbnail;
	}
	
	
	/*
	 * IMAGE OR NO IMAGE - CATEGORY VIEW - INTERNAL IMAGE
	 */
	function displayCategoryImageOrNoImage ($filename, $size) {
	
		phocagalleryimport('phocagallery.image.image');
		phocagalleryimport('phocagallery.path.path');
		phocagalleryimport('phocagallery.file.filethumbnail');
		$path			= &PhocaGalleryPath::getPath();
		$fileThumbnail	= PhocaGalleryFileThumbnail::getThumbnailName($filename, $size);
		$formatIcon 	= &PhocaGalleryImage::getFormatIcon();
		
		
		//Thumbnail_file doesn't exists
		if (!JFile::exists($fileThumbnail->abs)) {
			switch ($size) {
				case 'large':
				$fileThumbnail->rel	= $path->image_rel_front . 'phoca_thumb_l_no_image.' .$formatIcon;
				break;
				case 'medium':
				$fileThumbnail->rel	= $path->image_rel_front . 'phoca_thumb_m_no_image.' .$formatIcon;
				break;
				default:
				case 'small':
				$fileThumbnail->rel	= $path->image_rel_front . 'phoca_thumb_s_no_image.'  .$formatIcon;
				break;	
			}
		}	
		return $fileThumbnail->rel;	
	}
	
	/*
	* BACK FOLDER - CATEGORY VIEW
	*/
	function displayBackFolder ($size, $rightDisplayKey) {
	
		// if category is not accessable, display the key in the image:
		$key = '';
		if ((int)$rightDisplayKey == 0) {
			$key = '-key';
		}
		
		phocagalleryimport('phocagallery.image.image');
		phocagalleryimport('phocagallery.path.path');
		$path				= &PhocaGalleryPath::getPath();
		$formatIcon 		= &PhocaGalleryImage::getFormatIcon();
		$fileThumbnail->abs = '';
		$paramsC 			= JComponentHelper::getParams('com_phocagallery') ;
		
		if ( $paramsC->get( 'image_background_shadow' ) != 'none' ) {
			$fileThumbnail->rel	= $path->image_rel_front . 'icon-up-images'.$key.'.' . $formatIcon;
		} else {
			$fileThumbnail->rel	= $path->image_rel_front . 'icon-up-images'.$key.'.' . $formatIcon;
		}
		return $fileThumbnail->rel;	
	}
	
	/*
	 * RANDOM IMAGE OR IMAGE ORDERED BY PARAM - CATEGORIES VIEW, CATEGORY VIEW
	 * $extImage - for example Picasa image
	 * $extImageSize - 1 - small, 2 - medium, 3 - large
	 */
	function getRandomImageRecursive($categoryid, $categoryImageOrdering = '', $extImage = 0, $extImageSize = 1) {
		
		$db 	=& JFactory::getDBO();
		$image 	= '';
		
		// We need to get a list of all subcategories in the given category
		if ($categoryImageOrdering == '') {
			$ordering = ' ORDER BY RAND()'; 
		} else {
			$ordering = ' ORDER BY a.'.$categoryImageOrdering;
		}
		
        $query = 'SELECT a.id, a.filename, a.exts, a.extm, a.extw, a.exth' .
            ' FROM #__phocagallery AS a' .
            ' WHERE a.catid = '.(int) $categoryid.
            ' AND a.published = 1'.
            $ordering.
			' LIMIT 0,1';
		$db->setQuery($query);
	    $images = $db->loadObjectList();
		
		
		
        if (count($images) == 0) {
			
			$image->exts		= '';
			$image->extm		= '';
			$image->exth		= '';
			$image->extw		= '';
            $image->filename 	= '';
			
            $subCategories = PhocaGalleryImageFront::getRandomCategory($categoryid);
            foreach ($subCategories as $subCategory) {
                $image = PhocaGalleryImageFront::getRandomImageRecursive($subCategory->id, $categoryImageOrdering, $extImage, $extImageSize);
				// external image - e.g. Picasa
				if ($extImage == 1) {
					if ($extImageSize == 2) {
						if (isset($image->extm) && $image->extm != '') {
							break;
						}
					} else {
						if (isset($image->exts) && $image->exts != '') {
							break;
						}
					}
				} else {
					if (isset($image->filename) && $image->filename != '') {
						break;
					}
				}
            }
        } else {
            $image = $images[0] ;
        }
		
		if ($extImage == 1) {
			return $image;
		} else {
			if(isset($image->filename)) {
				return $image->filename;
			} else {
				return $image;
			}
		}
    }
	
	function getRandomCategory($parentid) {
        $db 	=& JFactory::getDBO();
		$query = 'SELECT c.id' .
            ' FROM #__phocagallery_categories AS c' .
            ' WHERE c.parent_id = '.(int) $parentid.
            ' AND c.published = 1' .
            ' ORDER BY RAND()';
		$db->setQuery($query);
	    $images = $db->loadObjectList();

        return $images;
    }

	function getSizeString($size) {
		switch((int)$size) {
			case 3: case 7: case 1: case 5: 
			$output = 'm';
			break;
			
			case 2: case 6: case 0: case 4: default:
			$output = 's';
			break;
		}
		return $output;
	}
}
?>