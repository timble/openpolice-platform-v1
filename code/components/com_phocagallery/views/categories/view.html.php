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
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view');
jimport( 'joomla.filesystem.file' );
phocagalleryimport('phocagallery.access.access');
phocagalleryimport('phocagallery.path.path');
phocagalleryimport('phocagallery.file.file');
phocagalleryimport('phocagallery.render.renderinfo');
phocagalleryimport('phocagallery.picasa.picasa');

class PhocaGalleryViewCategories extends JView
{
	function display($tpl = null) {		
		
		global $mainframe;
		$user 		= &JFactory::getUser();
		$uri 		= &JFactory::getURI();
		$path		= &PhocaGalleryPath::getPath();
		$params		= &$mainframe->getParams();
		$tmpl		= array();
		$tmplGeo	= array();
		
		$this->_setLibraries();
		
		// PARAMS - - - - - - - - - -
		$image_categories_size 			= $params->get( 'image_categories_size', 4 );
		$medium_image_width 			= (int)$params->get( 'medium_image_width', 100 ) + 18;
		$medium_image_height 			= (int)$params->get( 'medium_image_height', 100 ) + 18;
		$small_image_width 				= (int)$params->get( 'small_image_width', 50 ) + 18;
		$small_image_height 			= (int)$params->get( 'small_image_height', 50 ) + 18;
		$tmpl['phocagallerywidth'] 		= $params->get( 'phocagallery_width', '' );
		$tmpl['categoriescolumns'] 		= $params->get( 'categories_columns', 1 );
		$tmpl['displayrating']			= $params->get( 'display_rating', 0 );
		$tmpl['phocagallerycenter']		= $params->get( 'phocagallery_center', '');
		$tmpl['categoriesimageordering']= $params->get( 'categories_image_ordering', 9 );
		$tmpl['displayimagecategories'] = $params->get( 'display_image_categories', 1 );// Display or hide image beside the category name
		$display_categories_geotagging 	= $params->get( 'display_categories_geotagging', 0 );// Display Geo CATEGORIES VIEW
		// Access Category - display category in CATEGORIES VIEW, which user cannot access
		$display_access_category 		= $params->get( 'display_access_category', 1 );
		$display_empty_categories		= $params->get( 'display_empty_categories', 0 );
		$hideCatArray					= explode( ';', trim( $params->get( 'hide_categories', '' ) ) );
		$showCatArray    				= explode( ';', trim( $params->get( 'show_categories', '' ) ) );
		$tmpl['equalpercentagewidth']	= $params->get( 'equal_percentage_width');
		$tmpl['categoriesdisplayavatar']= $params->get( 'categories_display_avatar');
		$tmpl['categoriesboxwidth']		= $params->get( 'categories_box_width');
		$tmpl['gallerymetakey'] 		= $params->get( 'gallery_metakey', '' );
		$tmpl['gallerymetadesc'] 		= $params->get( 'gallery_metadesc', '' );
		
		
		

		
		// Correct Picasa Images - get Info
		switch($image_categories_size) {
			// medium
			case 1:
			case 5:
				$tmpl['picasa_correct_width']	= (int)$params->get( 'medium_image_width', 100 );	
				$tmpl['picasa_correct_height']	= (int)$params->get( 'medium_image_height', 100 );
			break;
			
			case 0:
			case 4:
			default:
				$tmpl['picasa_correct_width']	= (int)$params->get( 'small_image_width', 50 );	
				$tmpl['picasa_correct_height']	= (int)$params->get( 'small_image_height', 50 );
			break;
		}
		
		// - - - - - - - - - - - - - - - 
	
		// Get background for the image
		phocagalleryimport('phocagallery.image.imagefront');
		$catImg = PhocaGalleryImageFront::getCategoriesImageBackground($image_categories_size, $small_image_width, $small_image_height,  $medium_image_height, $medium_image_width);
		
		$tmpl['imagebg'] 		= $catImg->image;
		$tmpl['imagewidth'] 	= $catImg->width;
		

		//$total				= $this->get('total');
		//$tmpl['pagination']	= &$this->get('pagination');
		
		// Image next to Category in Categories View is ordered by Random as default
		phocagalleryimport('phocagallery.ordering.ordering');
		$categoriesImageOrdering = PhocaGalleryOrdering::getOrderingString($tmpl['categoriesimageordering']);
		
		// MODEL
		$model		= &$this->getModel();
		$items		= $this->get('data');
		
		
		// Add link and unset the categories which user cannot see (if it is enabled in params)
		// If it will be unset while access view, we must sort the keys from category array - ACCESS
		$unSet = 0;
		foreach ($items as $key => $item) {

			// Unset empty categories if it is set
			if ($display_empty_categories == 0) {
				if($items[$key]->numlinks < 1) {
					unset($items[$key]);
					$unSet 		= 1;
					continue;
				}
			}
			 
			// Set only selected category ID    
			if (!empty($showCatArray[0]) && is_array($showCatArray)) {
				$unSetHCA = 0;
         
				foreach ($showCatArray as $valueHCA) {
            
					if((int)trim($valueHCA) == $items[$key]->id) {
						$unSetHCA 	= 0;
						$unSet 		= 0;
						break;
					} else {
						$unSetHCA 	= 1;
						$unSet 		= 1;
                    }
                }
				if ($unSetHCA == 1) {
					unset($items[$key]);
					continue;
				}
			}

			
			// Unset hidden category
			if (!empty($hideCatArray) && is_array($hideCatArray)) {
				$unSetHCA = 0;
				foreach ($hideCatArray as $valueHCA) {
					if((int)trim($valueHCA) == $items[$key]->id) {
						unset($items[$key]);
						$unSet 		= 1;
						$unSetHCA 	= 1;
						break;
					}
				}
				if ($unSetHCA == 1) {
					continue;
				}
			}
		
			
			// Link
			$items[$key]->link	= JRoute::_('index.php?option=com_phocagallery&view=category&id='. $item->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ); 
			
			// USER RIGHT - ACCESS - - - - -
			// First Check - check if we can display category
			$rightDisplay	= 1;
			if (!empty($items[$key])) {
			
				$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $items[$key]->accessuserid, $items[$key]->access, $user->get('aid', 0), $user->get('id', 0), $display_access_category);
			}
			// Second Check - if we can display hidden category, set Key icon for them
			//                if we don't have access right to see them
			// Display Key Icon (in case we want to display unaccessable categories in list view)
			$rightDisplayKey  = 1;
		
			if ($display_access_category == 1) {
				// we simulate that we want not to display unaccessable categories
				// so if we get rightDisplayKey = 0 then the key will be displayed
				if (!empty($items[$key])) {
					$rightDisplayKey = PhocaGalleryAccess::getUserRight('accessuserid', $items[$key]->accessuserid, $items[$key]->access, $user->get('aid', 0), $user->get('id', 0), 0); // 0 - simulation
				}
			}
			
			// DISPLAY AVATAR, IMAGE(ordered), IMAGE(not ordered, not recursive) OR FOLDER ICON
			$displayAvatar = 0;
			if($tmpl['categoriesdisplayavatar'] == 1 && isset($items[$key]->avatar) && $items[$key]->avatar !='' && $items[$key]->avatarapproved == 1 && $items[$key]->avatarpublished == 1) {
				$sizeString = PhocaGalleryImageFront::getSizeString($image_categories_size);
				$pathAvatarAbs	= $path->avatar_abs  .'thumbs'.DS.'phoca_thumb_'.$sizeString.'_'. $items[$key]->avatar;
				$pathAvatarRel	= $path->avatar_rel . 'thumbs/phoca_thumb_'.$sizeString.'_'. $items[$key]->avatar;
				if (JFile::exists($pathAvatarAbs)){
					$items[$key]->linkthumbnailpath	=  $pathAvatarRel;
					$displayAvatar = 1;
				}
			}
			if ($displayAvatar == 0) {	
				if (isset($items[$key]->extid) && $items[$key]->extid != '') {
					if ($tmpl['categoriesimageordering'] != 10) {
						$imagePic		= PhocaGalleryImageFront::getRandomImageRecursive($items[$key]->id, $categoriesImageOrdering, 1);
						$fileThumbnail	= PhocaGalleryImageFront::displayCategoriesExtImgOrFolder($imagePic->exts,$imagePic->extm, $imagePic->extw,$imagePic->exth, $image_categories_size, $rightDisplayKey);
					} else {	
						$fileThumbnail		= PhocaGalleryImageFront::displayCategoriesExtImgOrFolder($items[$key]->exts,$items[$key]->extm, $items[$key]->extw, $items[$key]->exth, $image_categories_size, $rightDisplayKey);
					}

					$items[$key]->linkthumbnailpath	= $fileThumbnail->rel;
					$items[$key]->extw				= $fileThumbnail->extw;
					$items[$key]->exth				= $fileThumbnail->exth;
					$items[$key]->extpic			= $fileThumbnail->extpic;
				} else {
					if ($tmpl['categoriesimageordering'] != 10) {
						$items[$key]->filename	= PhocaGalleryImageFront::getRandomImageRecursive($items[$key]->id, $categoriesImageOrdering);
					}
					$fileThumbnail	= PhocaGalleryImageFront::displayCategoriesImageOrFolder($items[$key]->filename, $image_categories_size, $rightDisplayKey);
					$items[$key]->linkthumbnailpath	= $fileThumbnail->rel;
				}
			}
		
			if ($rightDisplay == 0) {
				unset($items[$key]);
				$unSet = 1;
			}
			// - - - - - - - - - - - - - - - 	
			
		}
		
		$tmpl['mtb'] = PhocaGalleryRenderInfo::getPhocaIc((int)$params->get( 'display_phoca_info', 1 ));
		
		
		// ACCESS - - - - - - 
		// In case we unset some category from the list, we must sort the array new
		if ($unSet == 1) {
			$items = array_values($items);
		}
		// - - - - - - - - - - - - - - - -

		// Do Pagination - we can do it after reducing all unneeded items, not before
		$totalCount 		= count($items);
		$model->setTotal($totalCount);
		$tmpl['pagination']	= &$this->get('pagination');
		$items 				= array_slice($items,(int)$tmpl['pagination']->limitstart, (int)$tmpl['pagination']->limit);
		// - - - - - - - - - - - - - - - -

		
		// Display Image of Categories Description
		if ($params->get('image') != -1) {
			$attribs['align']	= $params->get('image_align');
			$attribs['hspace']	= 6;
			// Use the static HTML library to build the image tag
			$tmpl['image'] 		= JHTML::_('image', 'images/stories/'.$params->get('image'), JText::_('Phoca Gallery'), $attribs);
		}
		// ACTION
		$tmpl['action']	= $uri->toString();
		$tmpl['action'] = str_replace ('&amp;', '&', $tmpl['action']);// in case mixed amp will be included in the link
		$tmpl['action'] = str_replace ('&', '&amp;', $tmpl['action']);
		
		// ASSIGN
		$this->assignRef('tmpl',		$tmpl);
		$this->assignRef('params',		$params);
		$this->assignRef('categories',	$items);
		
		// Meta data
		if ($tmpl['gallerymetakey'] != '') {
			$mainframe->addMetaTag('keywords', $tmpl['gallerymetakey']);
		}
		if ($tmpl['gallerymetadesc'] != '') {
			$mainframe->addMetaTag('description', $tmpl['gallerymetadesc']);
		}
		
		$tmpl['phoac'] = '<div style="tex'.'t-align: center; color:#d3d3'.'d3;">Power'.'ed by <a href="htt'.'p://www.pho'.'ca.cz" style="text-decor'.'ation: none;" tar'.'get="_bl'.'ank" title="Ph'.'oca.cz">Phoc'.'a</a> <a href="http://www.p'
			   .'hoca.cz/phocagallery" style="tex'.'t-decoration: none;" ta'.'rget="_bla'.'nk" title="Pho'.'ca Gal'.'lery">Gal'.'lery</a></div>';
		
		if ($display_categories_geotagging == 1) {
		
			// PARAMS - - - - - - - - - -
			$tmplGeo['categorieslng'] 		= $params->get( 'categories_lng', '' );
			$tmplGeo['categorieslat'] 		= $params->get( 'categories_lat', '' );
			$tmplGeo['categorieszoom'] 		= $params->get( 'categories_zoom', 2 );
			$tmplGeo['googlemapsapikey'] 	= $params->get( 'google_maps_api_key', '' );
			$tmplGeo['categoriesmapwidth'] 	= $params->get( 'categories_map_width', '' );
			$tmplGeo['categoriesmapheight'] = $params->get( 'categorires_map_height', 500 );
			// - - - - - - - - - - - - - - -
			
			// if no lng and lat will be added, Phoca Gallery will try to find it in categories
			if ($tmplGeo['categorieslat'] == '' || $tmplGeo['categorieslng'] == '') {
				phocagalleryimport('phocagallery.geo.geo');
				$latLng = PhocaGalleryGeo::findLatLngFromCategory($items);
				$tmplGeo['categorieslng'] = $latLng['lng'];
				$tmplGeo['categorieslat'] = $latLng['lat'];
			}
		
			$this->assignRef('tmplGeo',	$tmplGeo);
			parent::display('map');
		} else {
		
			parent::display($tpl);
		}
	}

	function _setLibraries() {
		
		$document	= &JFactory::getDocument();
		
		// Libraries
		$library 				= &PhocaGalleryLibrary::getLibrary();
		$libraries['pg-css-ie'] = $library->getLibrary('pg-css-ie');
		
		// CSS for IE 8
		if ( $libraries['pg-css-ie']->value == 0 ) {
			$document->addCustomTag("<!--[if lt IE 8]>\n<link rel=\"stylesheet\" href=\""
			.JURI::base(true)
			."/components/com_phocagallery/assets/phocagalleryieall.css\" type=\"text/css\" />\n<![endif]-->");
			$library->setLibrary('pg-css-ie', 1);
		}
		
		// CSS
		JHTML::stylesheet( 'phocagallery.css', 'components/com_phocagallery/assets/' );
	}
}
?>