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
class PhocaGalleryViewMap extends JView
{
	function display($tpl = null) {
		global $mainframe;
		$tmpl = array();
		
		// PLUGIN WINDOW - we get information from plugin
		$get		= '';
		$get['map']	= JRequest::getVar( 'map', '', 'get', 'string' );
		
		$document	= & JFactory::getDocument();		
		$params		= &$mainframe->getParams();
		
		// START CSS
		$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/phocagallery.css');
		
		// PARAMS - Open window parameters - modal popup box or standard popup window
		$detail_window = $params->get( 'detail_window', 0 );
		
		// Plugin information
		if (isset($get['map']) && $get['map'] != '') {
			$detail_window = $get['map'];
		}
		
		// Standard popup window
		if ($detail_window == 1) {
			$detail_window_close 	= 'window.close();';
			$detail_window_reload	= 'window.location.reload(true);';
		} else {//modal popup window
			$detail_window_close 	= 'window.parent.document.getElementById(\'sbox-window\').close();';
			$detail_window_reload	= 'window.location.reload(true);';
		}
		
		// PARAMS - Display Description in Detail window - set the font color
		$tmpl['detailwindow']			 	= $params->get( 'detail_window', 0 );
		$tmpl['detailwindowbackgroundcolor']= $params->get( 'detail_window_background_color', '#ffffff' );
		$tmpl['pgl'] 						= PhocaGalleryRenderInfo::getPhocaIc((int)$params->get( 'display_phoca_info', 1 ));
		$description_lightbox_font_color 	= $params->get( 'description_lightbox_font_color', '#ffffff' );
		$description_lightbox_bg_color 		= $params->get( 'description_lightbox_bg_color', '#000000' );
		$description_lightbox_font_size 	= $params->get( 'description_lightbox_font_size', 12 );
		$tmpl['gallerymetakey'] 		= $params->get( 'gallery_metakey', '' );
		$tmpl['gallerymetadesc'] 		= $params->get( 'gallery_metadesc', '' );
		if ($tmpl['gallerymetakey'] != '') {
			$mainframe->addMetaTag('keywords', $tmpl['gallerymetakey']);
		}
		if ($tmpl['gallerymetadesc'] != '') {
			$mainframe->addMetaTag('description', $tmpl['gallerymetadesc']);
		}

		// NO SCROLLBAR IN DETAIL WINDOW
		if ($detail_window == 7) {
	
		} else {
			$document->addCustomTag( "<style type=\"text/css\"> \n" 
				." html,body, .contentpane{overflow:hidden;background:".$tmpl['detailwindowbackgroundcolor'].";} \n" 
				." center, table {background:".$tmpl['detailwindowbackgroundcolor'].";} \n" 
				." #sbox-window {background-color:#fff;padding:5px} \n" 
				." </style> \n");
		}
		
		// PARAMS - Get image height and width
		$tmpl['largemapwidth']		= (int)$params->get( 'front_modal_box_width', 680 ) - 20;
		$tmpl['largemapheight']		= (int)$params->get( 'front_modal_box_height', 560 ) - 20;
		$tmpl['googlemapsapikey']	= $params->get( 'google_maps_api_key', '' );
		$tmpl['efd'] 				= PhocaGalleryRenderFront::getString();
			
		// MODEL
		$model	= &$this->getModel();
		$map	= $model->getData();

		phocagalleryimport('phocagallery.image.imagefront');
		if (!empty($map)) {
			if (isset($map->filename) && $map->filename != '') {
				$file_thumbnail = PhocaGalleryImageFront::displayCategoryImageOrNoImage($map->filename, 'small');
				$map->thumbnail = $file_thumbnail;
			} else {
				$map->thumbnail = '';
			}
			
			if (isset($map->latitude) && $map->latitude != '' && $map->latitude != 0
				&& isset($map->longitude) && $map->longitude != '' && $map->longitude != 0 ) {
				
			} else {
				$map->longitude	= '';
				$map->latitude	= '';
				$map->zoom		= 2;
				$map->geotitle	= '';
			}
		}
			
		// Second try to get category data
		if ((empty($map)) || ($map->longitude == '' && $map->latitude	== '' && $map->geotitle == '')) {
			
			$map	= $model->getDataCategory();
			
			if (!empty($map)) {
			
				if (isset($map->latitude) && $map->latitude != '' && $map->latitude != 0
					&& isset($map->longitude) && $map->longitude != '' && $map->longitude != 0 ) {
					$map->thumbnail = '';
					
				} else {
					$map->longitude	= '';
					$map->latitude	= '';
					$map->zoom		= 2;
					$map->geotitle	= '';
				}
			} else {
				$map->longitude	= '';
				$map->latitude	= '';
				$map->zoom		= 2;
				$map->geotitle	= '';
				$map->catslug	= '';
			}
		}
		
		
		// Back button
		$tmpl['backbutton'] = '';
		if ($tmpl['detailwindow'] == 7) {
			phocagalleryimport('phocagallery.image.image');
			$formatIcon = &PhocaGalleryImage::getFormatIcon();
			$tmpl['backbutton'] = '<div><a href="'.JRoute::_('index.php?option=com_phocagallery&view=category&id='. $map->catslug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')).'"'
				.' title="'.JText::_( 'Back to category' ).'">'
				. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-up-images.' . $formatIcon, JText::_( 'Back to category' )).'</a></div>';
		}
	
		// ASIGN
		$this->assignRef( 'tmpl', $tmpl );
		$this->assignRef( 'map', $map );
		parent::display($tpl);
	}
}
?>