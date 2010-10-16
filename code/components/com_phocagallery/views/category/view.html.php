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
defined( '_JEXEC' ) or die();
jimport( 'joomla.html.pane' );
jimport( 'joomla.client.helper' );
jimport( 'joomla.application.component.view' );
phocagalleryimport('phocagallery.file.fileupload');
phocagalleryimport('phocagallery.rate.ratecategory');
phocagalleryimport('phocagallery.rate.rateimage');
phocagalleryimport('phocagallery.comment.comment');
phocagalleryimport('phocagallery.comment.commentcategory');
phocagalleryimport('phocagallery.picasa.picasa');

class PhocaGalleryViewCategory extends JView
{
	function display($tpl = null) {
		
		global $mainframe;
		$document			= &JFactory::getDocument();
		$uri 				= &JFactory::getURI();
		$menus				= &JSite::getMenu();
		$menu				= $menus->getActive();
		$params				= &$mainframe->getParams();
		$user 				= &JFactory::getUser();
		$path 				= PhocaGalleryPath::getPath();
		$limitStart			= JRequest::getVar( 'limitstart', 0, '', 'int');
		$id 				= JRequest::getVar('id', 0, '', 'int');
		$tmpl['tab'] 		= JRequest::getVar('tab', 0, '', 'int');
		$tmpl['formaticon'] = PhocaGalleryImage::getFormatIcon();
		$tmpl['pl']			= 'index.php?option=com_user&view=login&return='.base64_encode($uri->toString());
		
	
	
		// LIBRARY
		$library 							= &PhocaGalleryLibrary::getLibrary();
		$libraries['pg-css-ie'] 			= $library->getLibrary('pg-css-ie');
		$libraries['pg-css-ie-hover']		= $library->getLibrary('pg-css-ie-hover');
		$libraries['pg-group-shadowbox']	= $library->getLibrary('pg-group-shadowbox');
		$libraries['pg-group-highslide']	= $library->getLibrary('pg-group-highslide');
		$libraries['pg-group-jak']			= $library->getLibrary('pg-group-jak');
		
		
		// PARAMS
		$tmpl['displaycatnametitle'] 		= $params->get( 'display_cat_name_title', 1 );
		$display_cat_name_breadcrumbs 		= $params->get( 'display_cat_name_breadcrumbs', 1 );
		$font_color 						= $params->get( 'font_color', '#b36b00' );
		$background_color 					= $params->get( 'background_color', '#fcfcfc' );
		$background_color_hover 			= $params->get( 'background_color_hover', '#f5f5f5' );
		$image_background_color 			= $params->get( 'image_background_color', '#f5f5f5' );
		$tmpl['displayimageshadow'] 		= $params->get( 'image_background_shadow', 'shadow1' );
		$border_color 						= $params->get( 'border_color', '#e8e8e8' );
		$border_color_hover 				= $params->get( 'border_color_hover', '#b36b00');
		$tmpl['imagewidth']					= $params->get( 'medium_image_width', 100 );
		$tmpl['imageheight'] 				= $params->get( 'medium_image_height', 100 );
		$popup_width 						= $params->get( 'front_modal_box_width', 680 );
		$popup_height 						= $params->get( 'front_modal_box_height', 560 );
		$tmpl['olbgcolor']					= $params->get( 'ol_bg_color', '#666666' );
		$tmpl['olfgcolor']					= $params->get( 'ol_fg_color', '#f6f6f6' );
		$tmpl['oltfcolor']					= $params->get( 'ol_tf_color', '#000000' );
		$tmpl['olcfcolor']					= $params->get( 'ol_cf_color', '#ffffff' );
		$tmpl['overliboverlayopacity']		= $params->get( 'overlib_overlay_opacity', 0.7 );
		$margin_box 						= $params->get( 'margin_box', 5 );
		$padding_box						= $params->get( 'padding_box', 5 );
		$tmpl['maxuploadchar']				= $params->get( 'max_upload_char', 1000 );
		$tmpl['maxcommentchar']				= $params->get( 'max_comment_char', 1000 );
		$tmpl['commentwidth']				= $params->get( 'comment_width', 500 );
		$tmpl['displayrating']				= $params->get( 'display_rating', 0 );
		$tmpl['displayratingimg']			= $params->get( 'display_rating_img', 0 );
		$tmpl['displaycomment']				= $params->get( 'display_comment', 0 );
		$tmpl['displaycommentimg']			= $params->get( 'display_comment_img', 0 );
		$tmpl['displaysubcategory']			= $params->get( 'display_subcategory', 1 );
		$tmpl['displaycategorygeotagging']	= $params->get( 'display_category_geotagging', 0 );
		$tmpl['displaycategorystatistics']	= $params->get( 'display_category_statistics', 0 );
		// Used for Highslide JS (only image)
		$tmpl['lm'] = '<'.'d'.'i'.'v'.' '.'s'.'t'.'y'.'l'.'e'.'='.'"'.'t'.'e'.'x'.'t'.'-'.'a'.'l'.'i'.'g'.'n'.':'.' '.'c'.'e'.'n'.'t'.'e'.'r'.';'.' '.'c'.'o'.'l'.'o'.'r'.':'.' '.'r'.'g'.'b'.'('.'2'.'1'.'1'.','.' '.'2'.'1'.'1'.','.' '.'2'.'1'.'1'.')'.';'.'"'.'>'.'P'.'o'.'w'.'e'.'r'.'e'.'d'.' '.'b'.'y'.' '.'<'.'a'.' '.'h'.'r'.'e'.'f'.'='.'"'.'h'.'t'.'t'.'p'.':'.'/'.'/'.'w'.'w'.'w'.'.'.'p'.'h'.'o'.'c'.'a'.'.'.'c'.'z'.'"'.' '.'s'.'t'.'y'.'l'.'e'.'='.'"'.'t'.'e'.'x'.'t'.'-'.'d'.'e'.'c'.'o'.'r'.'a'.'t'.'i'.'o'.'n'.':'.' '.'n'.'o'.'n'.'e'.';'.'"'.' '.'t'.'a'.'r'.'g'.'e'.'t'.'='.'"'.'_'.'b'.'l'.'a'.'n'.'k'.'"'.' '.'t'.'i'.'t'.'l'.'e'.'='.'"'.'P'.'h'.'o'.'c'.'a'.'.'.'c'.'z'.'"'.'>'.'P'.'h'.'o'.'c'.'a'.'<'.'/'.'a'.'>'.' '.'<'.'a'.' '.'h'.'r'.'e'.'f'.'='.'"'.'h'.'t'.'t'.'p'.':'.'/'.'/'.'w'.'w'.'w'.'.'.'p'.'h'.'o'.'c'.'a'.'.'.'c'.'z'.'/'.'p'.'h'.'o'.'c'.'a'.'g'.'a'.'l'.'l'.'e'.'r'.'y'.'"'.' '.'s'.'t'.'y'.'l'.'e'.'='.'"'.'t'.'e'.'x'.'t'.'-'.'d'.'e'.'c'.'o'.'r'.'a'.'t'.'i'.'o'.'n'.':'.' '.'n'.'o'.'n'.'e'.';'.'"'.' '.'t'.'a'.'r'.'g'.'e'.'t'.'='.'"'.'_'.'b'.'l'.'a'.'n'.'k'.'"'.' '.'t'.'i'.'t'.'l'.'e'.'='.'"'.'P'.'h'.'o'.'c'.'a'.' '.'G'.'a'.'l'.'l'.'e'.'r'.'y'.'"'.'>'.'G'.'a'.'l'.'l'.'e'.'r'.'y'.'<'.'/'.'a'.'>'.'<'.'/'.'d'.'i'.'v'.'>';
		$tmpl['displaydescriptiondetail']	= $params->get( 'display_description_detail', 0 );
		$tmpl['displaytitleindescription']	= $params->get( 'display_title_description', 0 );
		$tmpl['displayname']				= $params->get( 'display_name', 1);
		$tmpl['displayicondetail'] 			= $params->get( 'display_icon_detail', 1 );
		$tmpl['displayicondownload'] 		= $params->get( 'display_icon_download', 0 );
		$tmpl['displayiconfolder'] 			= $params->get( 'display_icon_folder', 0 );
		$tmpl['displayiconvm']				= $params->get( 'display_icon_vm', 0 );
		$tmpl['fontsizename']				= $params->get( 'font_size_name', 12 );
		$tmpl['fontsizeimgdesc']			= $params->get( 'font_size_img_desc', 10 );
		$tmpl['imgdescboxheight']			= $params->get( 'img_desc_box_height', 30 );
		$tmpl['displayimgdescbox']			= $params->get( 'display_img_desc_box', 0 );
		$tmpl['charlengthimgdesc']			= $params->get( 'char_length_img_desc', 300 );
		$tmpl['charlengthname'] 			= $params->get( 'char_length_name', 15);
		$tmpl['displayicongeo']				= $params->get( 'display_icon_geotagging', 0 );// Check the category
		$tmpl['displayicongeoimage']		= $params->get( 'display_icon_geotagging', 0 );// Check the image
		$tmpl['displaycamerainfo']			= $params->get( 'display_camera_info', 0 );
		$tmpl['displaypage'] 				= PhocaGalleryRenderInfo::getPhocaIc((int)$params->get( 'display_phoca_info', 1 ));
		$tmpl['switchimage']				= $params->get( 'switch_image', 0 );
		$tmpl['switchheight'] 				= $params->get( 'switch_height', 480 );
		$tmpl['switchwidth'] 				= $params->get( 'switch_width', 640);
		$tmpl['switchfixedsize'] 			= $params->get( 'switch_fixed_size', 0);
		// PARAMS - Upload
		$tmpl['displaytitleupload']			= $params->get( 'display_title_upload', 0 );
		$tmpl['displaydescupload'] 			= $params->get( 'display_description_upload', 0 );
		$tmpl['enablejava']					= $params->get( 'enable_java', 0 );
		$tmpl['javaresizewidth'] 			= $params->get( 'java_resize_width', -1 );
		$tmpl['javaresizeheight'] 			= $params->get( 'java_resize_height', -1 );
		$tmpl['javaboxwidth'] 				= $params->get( 'java_box_width', 480 );
		$tmpl['javaboxheight'] 				= $params->get( 'java_box_height', 480 );
		$tmpl['large_image_width']			= $params->get( 'large_image_width', 640 );
		$tmpl['large_image_height']			= $params->get( 'large_image_height', 640 );
		$tmpl['uploadmaxsize'] 				= $params->get( 'upload_maxsize', 3145728 );
		$tmpl['uploadmaxsizeread'] 			= PhocaGalleryFile::getFileSizeReadable($tmpl['uploadmaxsize']);
		$tmpl['uploadmaxreswidth'] 			= $params->get( 'upload_maxres_width', 3072 );
		$tmpl['uploadmaxresheight'] 		= $params->get( 'upload_maxres_height', 2304 );
		$tmpl['phocagallerywidth']			= $params->get( 'phocagallery_width', '');
		$tmpl['phocagallerycenter']			= $params->get( 'phocagallery_center', '');
		$display_description_detail 		= $params->get( 'display_description_detail', 0 );
		$description_detail_height 			= $params->get( 'description_detail_height', 16 );
		$tmpl['categoryboxspace'] 			= $params->get( 'category_box_space', 0 );
		$tmpl['detailwindow']				= $params->get( 'detail_window', 0 );
		$detail_buttons 					= $params->get( 'detail_buttons', 1 );
		$modal_box_overlay_color 			= $params->get( 'modal_box_overlay_color', '#000000' );
		$modal_box_overlay_opacity 			= $params->get( 'modal_box_overlay_opacity', 0.3 );
		$modal_box_border_color 			= $params->get( 'modal_box_border_color', '#6b6b6b' );
		$modal_box_border_width 			= $params->get( 'modal_box_border_width', '2' );
		$tmpl['enablepiclens']				= $params->get( 'enable_piclens', 0 );
		$highslide_class					= $params->get( 'highslide_class', 'rounded-white');
		$highslide_opacity					= $params->get( 'highslide_opacity', 0);
		$highslide_outline_type				= $params->get( 'highslide_outline_type', 'rounded-white');
		$highslide_fullimg					= $params->get( 'highslide_fullimg', 0);
		$highslide_slideshow				= $params->get( 'highslide_slideshow', 1);
		$highslide_close_button				= $params->get( 'highslide_close_button', 0);
		$tmpl['jakslideshowdelay']			= $params->get( 'jak_slideshow_delay', 5);
		$tmpl['jakorientation']				= $params->get( 'jak_orientation', 'none');
		$tmpl['jakdescription']				= $params->get( 'jak_description', 1);
		$tmpl['jakdescriptionheight']		= $params->get( 'jak_description_height', 0);
		$tmpl['categoryimageordering']		= $params->get( 'category_image_ordering', 9 );
		$tmpl['externalcommentsystem'] 		= $params->get( 'external_comment_system', 0 );
		// Possible Categories View in Category View
		$tmpl['categoryimageorderingcv']	= $params->get( 'category_image_ordering_cv', 9 );
		$tmpl['displaycategoriescv'] 		= $params->get( 'display_categories_cv', 0 );
		$display_subcat_page_cv				= $params->get( 'display_subcat_page_cv', 0 );
		$display_back_button_cv 			= $params->get( 'display_back_button_cv', 1 );
		$display_categories_back_button_cv 	= $params->get( 'display_categories_back_button_cv', 1 );
		$tmpl['displayimagecategoriescv'] 	= $params->get( 'display_image_categories_cv', 1 );
		$tmpl['categoriescolumnscv'] 		= $params->get( 'categories_columns_cv', 1 );
		$image_categories_size_cv 			= $params->get( 'image_categories_size_cv', 4 );
		$medium_image_width_cv 				= (int)$params->get( 'medium_image_width', 100 ) + 18;
		$medium_image_height_cv 			= (int)$params->get( 'medium_image_height', 100 ) + 18;
		$small_image_width_cv 				= (int)$params->get( 'small_image_width', 50 ) + 18;
		$small_image_height_cv 				= (int)$params->get( 'small_image_height', 50 ) + 18;
		$tmpl['imagetypecv']				= $image_categories_size_cv;
		$tmpl['overlibimagerate']			= (int)$params->get( 'overlib_image_rate', '' );
		
		
		$tmpl['fb_comment_app_id']			= $params->get( 'fb_comment_app_id', '');
		$tmpl['fb_comment_width']			= (int)$params->get( 'fb_comment_width', '550');
		$tmpl['display_comment_nopup']		= $params->get( 'display_comment_nopup', 0);
		
		$tmpl['picasa_correct_width_m']		= (int)$params->get( 'medium_image_width', 100 );	
		$tmpl['picasa_correct_height_m']	= (int)$params->get( 'medium_image_height', 100 );
		$tmpl['picasa_correct_width_s']		= (int)$params->get( 'small_image_width', 50 );	
		$tmpl['picasa_correct_height_s']	= (int)$params->get( 'small_image_height', 50 );
		$tmpl['picasa_correct_width_l']		= (int)$params->get( 'large_image_width', 640 );	
		$tmpl['picasa_correct_height_l']	= (int)$params->get( 'large_image_height', 480 );
		$tmpl['gallerymetakey'] 			= $params->get( 'gallery_metakey', '' );
		$tmpl['gallerymetadesc'] 			= $params->get( 'gallery_metadesc', '' );
		$tmpl['altvalue']		 			= $params->get( 'alt_value', 1 );	
		$tmpl['divs']						= PhocaGalleryRenderFront::getDivs();
		$catImg = PhocaGalleryImageFront::getCategoriesImageBackground($image_categories_size_cv, $small_image_width_cv, $small_image_height_cv,  $medium_image_height_cv, $medium_image_width_cv);
		
		$tmpl['imagebgcv'] 		= $catImg->image;
		$tmpl['imagewidthcv'] 	= $catImg->width;
		// - - - - - - - - - - - - - - - 
		
		// PARAMS - Background shadow
		if ( $tmpl['displayimageshadow'] != 'none' ) {	
			// IE hack
			$shadowPath = $path->image_abs_front . $tmpl['displayimageshadow'].'.'.$tmpl['formaticon'];
			$shadowSize	= getimagesize($shadowPath);
			if (isset($shadowSize[0]) && isset($shadowSize[0])) {
				$w = (int)$tmpl['imagewidth'] + 18 - (int)$shadowSize[0];
				$h = (int)$tmpl['imageheight'] + 18 - (int)$shadowSize[1];
				if ($w != 0) {$w = $w/2;} // plus or minus should be divided, not null
				if ($h != 0) {$h = $h/2;}
			} else {
				$w = $h = 0;
			}
			$imageBgCSS = 'background: url(\''.JURI::base(true).'/components/com_phocagallery/assets/images/'.$tmpl['displayimageshadow'].'.'.$tmpl['formaticon'].'\') 50% 50% no-repeat;';
			
			$imageBgCSSIE = 'background: url(\''.JURI::base(true).'/components/com_phocagallery/assets/images/'.$tmpl['displayimageshadow'].'.'.$tmpl['formaticon'].'\') '.$w.'px '.$h.'px no-repeat;';
			
		} else {
			$imageBgCSS = 'background: '.$image_background_color .';';
			$imageBgCSSIE = 'background: '.$image_background_color .';';
		}
		
		
		// CSS - - - - - -
		JHTML::stylesheet( 'phocagallery.css', 'components/com_phocagallery/assets/' );
		if ( $libraries['pg-css-ie']->value == 0 ) {
			$document->addCustomTag("<!--[if lt IE 8 ]>\n<link rel=\"stylesheet\" href=\""
			.JURI::base(true)
			."/components/com_phocagallery/assets/phocagalleryieall.css\" type=\"text/css\" />\n<![endif]-->");
			$library->setLibrary('pg-css-ie', 1);
		}
		$document->addCustomTag( PhocaGalleryRenderFront::renderCategoryCSS($font_color,
		$background_color, $border_color, $imageBgCSS, $imageBgCSSIE, $border_color_hover, $background_color_hover,
		$tmpl['olfgcolor'], $tmpl['olbgcolor'], $tmpl['oltfcolor'], $tmpl['olcfcolor'],
		$margin_box, $padding_box, $tmpl['overliboverlayopacity']));
		if ( $libraries['pg-css-ie-hover']->value == 0 ) {
			$document->addCustomTag( PhocaGalleryRenderFront::renderIeHover());
			$library->setLibrary('pg-css-ie-hover', 1);
		}
		// - - - - - -
	
		// Correct Height
		// Description detail height
		if ($display_description_detail == 1) {
			$popup_height	= $popup_height + $description_detail_height;
		}
		
		// Detail buttons in detail view
		if ($detail_buttons != 1) {
			$popup_height	= $popup_height - 45;
		}
		$popup_height_rating = $popup_height;
		if ($tmpl['displayratingimg'] == 1) {
	
			$popup_height_rating	= $popup_height_rating + 35;
		}
		
		// Correct height of description in image box (set null if this will be hidden)
		if ($tmpl['displayimgdescbox'] == 0) {
			$tmpl['imgdescboxheight']	= 0;
		}

		// =======================================================
		// DIFFERENT METHODS OF DISPLAYING THE DETAIL VIEW
		// =======================================================
		
		// MODAL - will be displayed in case e.g. highslide or shadowbox too, because in there are more links 
		JHTML::_('behavior.modal', 'a.modal-button');
		
		// CSS
		$document->addCustomTag( "<style type=\"text/css\"> \n"  
		." #sbox-window {background-color:".$modal_box_border_color.";padding:".$modal_box_border_width."px} \n"
		." #sbox-overlay {background-color:".$modal_box_overlay_color.";} \n"			
		." </style> \n");

		// BUTTON (IMAGE - standard, modal, shadowbox)
		$button = new JObject();
		$button->set('name', 'image');
		
		// BUTTON (ICON - standard, modal, shadowbox)
		$button2 = new JObject();
		$button2->set('name', 'icon');
		
		// BUTTON OTHER (geotagging, downloadlink, ...)
		$buttonOther = new JObject();
		$buttonOther->set('name', 'other');
		
		$tmpl ['highslideonclick']	= '';// for using with highslide
		
		// -------------------------------------------------------
		// STANDARD POPUP
		// -------------------------------------------------------
		
		if ($tmpl['detailwindow'] == 1) {
			
			$button->set('methodname', 'js-button');
			$button->set('options', "window.open(this.href,'win2','width=".$popup_width.",height=".$popup_height.",scrollbars=yes,menubar=no,resizable=yes'); return false;");
			$button->set('optionsrating', "window.open(this.href,'win2','width=".$popup_width.",height=".$popup_height_rating.",scrollbars=yes,menubar=no,resizable=yes'); return false;");
			
			$button2->methodname 		= &$button->methodname;
			$button2->options 			= &$button->options;
			$buttonOther->methodname  	= &$button->methodname;
			$buttonOther->options 		= &$button->options;
			$buttonOther->optionsrating = &$button->optionsrating;
			
		}
		// -------------------------------------------------------
		// MODAL BOX
		// -------------------------------------------------------
		
		else if ($tmpl['detailwindow'] == 0 || $tmpl['detailwindow'] == 2) { 
			
			// Button
			$button->set('modal', true);
			$button->set('methodname', 'modal-button');
			
			$button2->modal 			= &$button->modal;
			$button2->methodname 		= &$button->methodname;
			$buttonOther->modal 		= &$button->modal;
			$buttonOther->methodname  	= &$button->methodname;
			
			// Modal - Image only
			if ($tmpl['detailwindow'] == 2) {
				
				$button->set('options', "{handler: 'image', size: {x: 200, y: 150}, overlayOpacity: ".$modal_box_overlay_opacity."}");
				$button2->options 		= &$button->options;
				$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
				$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			
			// Modal - Iframe 			
			} else {
			
				$button->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
				$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
				
				$button2->options 		= &$button->options;
				$buttonOther->options  	= &$button->options;
			
			}
	
		} 
		
		// -------------------------------------------------------
		// SHADOW BOX
		// -------------------------------------------------------
		
		else if ($tmpl['detailwindow'] == 3) {
		
			$sb_slideshow_delay			= $params->get( 'sb_slideshow_delay', 5 );
			$sb_lang					= $params->get( 'sb_lang', 'en' );
			
			$button->set('methodname', 'shadowbox-button');
			$button->set('options', "shadowbox[PhocaGallery];options={slideshowDelay:".$sb_slideshow_delay."}");
			
			$button2->methodname 		= &$button->methodname;
			$button2->set('options', "shadowbox[PhocaGallery2];options={slideshowDelay:".$sb_slideshow_delay."}");
			
			$buttonOther->set('modal', true);
			$buttonOther->set('methodname', 'modal-button');
			$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			
			
			
			//	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/adapter/shadowbox-mootools.js');
				$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/shadowbox.js');	
			
			if ( $libraries['pg-group-shadowbox']->value == 0 ) {
				$document->addCustomTag('<script type="text/javascript">
Shadowbox.loadSkin("classic", "'.JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/skin");
Shadowbox.loadLanguage("'.$sb_lang.'", "'.JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/lang");
Shadowbox.loadPlayer(["img"], "'.JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/player");
window.addEvent(\'domready\', function(){
           Shadowbox.init()
});
</script>');
				// window.onload = function(){
				// Shadowbox.init();
				$library->setLibrary('pg-group-shadowbox', 1);
			}
		}
		
		// -------------------------------------------------------
		// HIGHSLIDE JS
		// -------------------------------------------------------
		
		else if ($tmpl['detailwindow'] == 4) {
			
			$button->set('methodname', 'highslide');
			$button2->methodname 		= &$button->methodname;
			$buttonOther->methodname 	= &$button->methodname;
			
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-full.js');
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide.css');
			
			if ( $libraries['pg-group-highslide']->value == 0 ) {
				$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJSAll());
				$document->addCustomTag('<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-ie6.css" /><![endif]-->');
				$library->setLibrary('pg-group-highslide', 1);
			}
			
			//$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJS ('',$popup_width, $popup_height_rating, $highslide_outline_type, $highslide_opacity));
			$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJS('', $popup_width, $popup_height_rating, $highslide_slideshow, $highslide_class, $highslide_outline_type, $highslide_opacity, $highslide_close_button));
			$tmpl['highslideonclick'] = 'return hs.htmlExpand(this, phocaZoom )';
		}
		
		// -------------------------------------------------------
		// HIGHSLIDE JS IMAGE ONLY
		// -------------------------------------------------------
		
		else if ($tmpl['detailwindow'] == 5) {
		
			$button->set('methodname', 'highslide');
			$button2->methodname 		= &$button->methodname;
			$buttonOther->methodname 	= &$button->methodname;
			
		
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-full.js');
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide.css');
			
		
			if ( $libraries['pg-group-highslide']->value == 0 ) {		
				$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJSAll());
				$document->addCustomTag('<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-ie6.css" /><![endif]-->');
				$library->setLibrary('pg-group-highslide', 1);
			}
			
			$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJS('', $popup_width, $popup_height_rating, $highslide_slideshow, $highslide_class, $highslide_outline_type, $highslide_opacity, $highslide_close_button));
			$tmpl['highslideonclick2']	= 'return hs.htmlExpand(this, phocaZoom )';
			$tmpl['highslideonclick']	= PhocaGalleryRenderFront::renderHighslideJSImage('', $highslide_class, $highslide_outline_type, $highslide_opacity, $highslide_fullimg);
			
		}
		
		// -------------------------------------------------------
		// JAK LIGHTBOX
		// -------------------------------------------------------
		
		else if ($tmpl['detailwindow'] == 6) {
		
			$button->set('methodname', 'jaklightbox');
			$button2->methodname 		= &$button->methodname;

			
			$buttonOther->set('modal', true);
			$buttonOther->set('methodname', 'modal-button');
			$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
		
		
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/jak_compressed.js');
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox_compressed.js');
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/jak_slideshow.js');
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/window_compressed.js');
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/interpolator_compressed.js');		
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-slideshow.css');
			
			
			$lHeight 		= 472 + (int)$tmpl['jakdescriptionheight'];
			$lcHeight		= 10 + (int)$tmpl['jakdescriptionheight'];
			$customJakTag	= '';
			if ($tmpl['jakorientation'] == 'horizontal') {
				$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-horizontal.css');
			} else if ($tmpl['jakorientation'] == 'vertical'){
				$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-vertical.css');
				$customJakTag .= '.lightBox {height: '.$lHeight.'px;}'
							    .'.lightBox .image-browser-caption { height: '.$lcHeight.'px;}';
			} else  {
				$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-vertical.css');
				$customJakTag .= '.lightBox {height: '.$lHeight.'px;width:800px;}'
							.'.lightBox .image-browser-caption { height: '.$lcHeight.'px;}'
							.'.lightBox .image-browser-thumbs { display:none;}'
							.'.lightBox .image-browser-thumbs div.image-browser-thumb-box { display:none;}';
			}
			
			if ($customJakTag != '') {
				$document->addCustomTag("<style type=\"text/css\">\n". $customJakTag. "\n"."</style>");
			}
			
			if ( $libraries['pg-group-jak']->value == 0 ) {		
				$document->addCustomTag( PhocaGalleryRenderFront::renderJakJs($tmpl['jakslideshowdelay'], $tmpl['jakorientation']));
				$library->setLibrary('pg-group-jak', 1);
			}
			
		}
		
		// -------------------------------------------------------
		// NO POPUP
		// -------------------------------------------------------
		
		else if ($tmpl['detailwindow'] == 7) {
		
			$button->set('methodname', 'no-popup');
			$button2->methodname 		= &$button->methodname;

			
			$buttonOther->set('modal', true);
			$buttonOther->set('methodname', 'no-popup');
			$buttonOther->set('options', "");
			$buttonOther->set('optionsrating', "");
			
		}
		
		// -------------------------------------------------------
		// SLIMBOX
		// -------------------------------------------------------
		
		else if ($tmpl['detailwindow'] == 8) {
		
			$button->set('methodname', 'slimbox');
			$button2->methodname 		= &$button->methodname;
			$button2->methodname 		= &$button->methodname;
			$button2->set('options', "lightbox-images");
			
			$buttonOther->set('modal', true);
			$buttonOther->set('methodname', 'modal-button');
			$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
		
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/slimbox/slimbox.js');
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/slimbox/slimbox.css');

		}
		
		$folderButton = new JObject();
		$folderButton->set('name', 'image');
		$folderButton->set('options', "");					
		// End open window parameters
		// ==================================================================
		
	
		// Information about current category
		$category			= $this->get('category');
		//$total				= $this->get('total');
		
		// PICLENS
		$tmpl['startpiclens'] 	= 0;
		if ($tmpl['enablepiclens'] == 1) {
			$tmpl['startpiclens'] = $params->get( 'start_piclens', 0 );
			// CSS - PicLens START
			$document->addCustomTag(PhocaGalleryRenderFront::renderPicLens($category->id));
		}
		
		// PARAMS - Pagination and subcategories on other sites
		// Subcategories will be displayed only on first page if pagination will be used
		$display_subcat_page = $params->get( 'display_subcat_page', 0 );
		// On the first site subcategories will be displayed allways
		$get['start']	= JRequest::getVar( 'limitstart', '', 'get', 'string' );
		if ($display_subcat_page == 2) {
			$display_subcat_page = 0;// Nowhere
		} else if ($display_subcat_page == 0 && $get['start'] > 0) {
			$display_subcat_page = 0;//in case: second page and param=0
		} else {
			$display_subcat_page = 1;//in case:first page or param==1
		}
		// Categories View in Category View
		if ($display_subcat_page_cv == 2) {
			$display_subcat_page_cv = 0;// Nowhere
		} else if ($display_subcat_page_cv == 0 && $get['start'] > 0) {
			$display_subcat_page_cv = 0;//in case: second page and param=0
		} else {
			$display_subcat_page_cv = 1;//in case:first page or param==1
		}
		// PARAMS - Display Back Buttons
		$display_back_button 			= $params->get( 'display_back_button', 1 );
		$display_categories_back_button = $params->get( 'display_categories_back_button', 1 );
		// PARAMS - Access Category - display category (subcategory folder or backbutton  to not accessible cat
		$display_access_category 		= $params->get( 'display_access_category', 1 );	
		
		// Set page title per category
		if ($tmpl['displaycatnametitle'] == 1) {
			$document->setTitle($params->get( 'page_title') . ' - '. $category->title);
		} else {
			$document->setTitle( $params->get( 'page_title' ));
		}

		// Breadcrumb display:
		// 0 - only menu link
		// 1 - menu link - category name
		// 2 - only category name
		$this->_addBreadCrumbs($category, isset($menu->query['id']) ? $menu->query['id'] : 0, $display_cat_name_breadcrumbs);
		
		// PARAMS - the whole page title with category or without category
		$tmpl['showpagetitle'] = $params->get( 'show_page_title', 1 );
		
		// Define image tag attributes
		if (!empty ($category->image)) {
			$attribs['align'] = '"'.$category->image_position.'"';
			$attribs['hspace'] = '"6"';
			$tmpl['image'] = JHTML::_('image', 'images/stories/'.$category->image, JText::_('Phoca gallery'), $attribs);
		}
		
		// Switch image JS
		$tmpl['basicimage']	= '';
		if ($tmpl['switchimage'] == 1) {
			$imagePathFront		= PhocaGalleryPath::getPath();
			$tmpl['waitimage']	= $imagePathFront->image_rel_front_full . 'icon-switch.gif';
			$tmpl['basicimage']	= $imagePathFront->image_rel_front_full . 'phoca_thumb_l_no_image.' . $tmpl['formaticon'];
			$document->addCustomTag(PhocaGalleryRenderFront::switchImage($tmpl['waitimage']));
			$basicImageSelected = 0; // we have not selected the basic image yet
		}
		
		// Overlib
		$enable_overlib = $params->get( 'enable_overlib', 0 );
		if ((int)$enable_overlib > 0) {
			$document->addScript(JURI::base(true).'/includes/js/overlib_mini.js');
		}
		
		// MODEL
		$model		= &$this->getModel();
		
		// Trash
		$tmpl['trash']				= 0;
		$tmpl['publishunpublish']	= 0;
		$tmpl['approvednotapproved']= 0;// only to see the info
		// USER RIGHT - DELETE - - - - - - - - - - -
		// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
		$rightDisplayDelete = 0;// default is to null (all users cannot upload)
		if (!empty($category)) {
			$rightDisplayDelete = PhocaGalleryAccess::getUserRight('deleteuserid', $category->deleteuserid, 1, $user->get('aid', 0), $user->get('id', 0), 0);
		}
		if ($rightDisplayDelete == 1) {
			$tmpl['trash']				= 1;
			$tmpl['publishunpublish']	= 1;
			$tmpl['approvednotapproved']= 1;// only to see the info
		}
		// - - - - - - - - - - - - - - - - - - - - - 
		// Upload
		$tmpl['displayupload']	= 0;
		// USER RIGHT - UPLOAD - - - - - - - - - - - 
		// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
		$rightDisplayUpload = 0;// default is to null (all users cannot upload)
		if (!empty($category)) {
			$rightDisplayUpload = PhocaGalleryAccess::getUserRight('uploaduserid', $category->uploaduserid, 1, $user->get('aid', 0), $user->get('id', 0), 0);
		}
		if ($rightDisplayUpload == 1) {
			$tmpl['displayupload']	= 1;
			$document->addCustomTag(PhocaGalleryRenderFront::renderOnUploadJS());
			$document->addCustomTag(PhocaGalleryRenderFront::renderDescriptionUploadJS((int)$tmpl['maxuploadchar']));
		}
		// - - - - - - - - - - - - - - - - - - - - - 
		
		// USER RIGHT - ACCESS - - - - - - - - - - - 
		$rightDisplay = 1;//default is set to 1 (all users can see the category)
		if (!empty($category)) {
			$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $category->accessuserid, 0, $user->get('aid', 0), $user->get('id', 0), $display_access_category);
		}
		if ($rightDisplay == 0) {
			
			$mainframe->redirect(JRoute::_($tmpl['pl'], false), JText::_("ALERTNOTAUTH"));
			exit;
		}		
		// - - - - - - - - - - - - - - - - - - - - - 
		
		// 1. GEOTAGGING CATEGORY
		$map['longitude'] 	= '';// will be used for 1. default_geotagging to not display pane and 2. to remove pane (line cca 1554)
		$map['latitude'] 	= '';
		if (isset($category->latitude) && $category->latitude != '' && $category->latitude != 0
			&& isset($category->longitude) && $category->longitude != '' && $category->longitude != 0 ) {
			
			$map['longitude']	= $category->longitude;
			$map['latitude']	= $category->latitude;
			$map['zoom']		= $category->zoom;
			$map['geotitle'] 	= $category->geotitle;
			$map['description'] = $category->description;
			if ($map['geotitle'] == '') {
				$map['geotitle']	= $category->title;
			}	
		} else {
			$tmpl['displayicongeo'] = 0;
		}
		
		// Image next to Category in Categories View in Category View is ordered by Random as default
		phocagalleryimport('phocagallery.ordering.ordering');
		$categoryImageOrdering = PhocaGalleryOrdering::getOrderingString($tmpl['categoryimageordering']);
		$categoryImageOrderingCV = PhocaGalleryOrdering::getOrderingString($tmpl['categoryimageorderingcv']);
		
		// = = = = = = = = = = = = = = = = = = = = 
		// BOXES
		// = = = = = = = = = = = = = = = = = = = =
		
		// Information because of height of box (if they are used not by all images)
		$tmpl['displayiconextlink1box'] = 0;
		$tmpl['displayiconextlink2box'] = 0;
		$tmpl['displayiconvmbox'] 		= 0;
		$tmpl['displayicongeobox'] 		= 0;
		
        $iS 	= 0;
		$iCV 	= 0;
		$items		= array();// Category View
		$itemsCV	= array();// Category List (Categories View) in Category View


		// ----------------------------------------
		// PARENT FOLDERS(I) or Back Button STANDARD
		// ----------------------------------------		
	/*	$menu 	= &JSite::getMenu();
		// Set Back Button to CATEGORIES VIEW
		$itemsLink	= $menu->getItems('link', 'index.php?option=com_phocagallery&view=categories');

		$itemId	= 0;
		if(isset($itemsLink[0])) {
			$itemId = $itemsLink[0]->id;
		}	
		$backLink = 'index.php?option=com_phocagallery&view=categories&Itemid='.$itemId;*/
	   
		$posItemid		= $posItemidNull = $backLinkItemId = false;
		$backLink 		= PhocaGalleryRoute::getCategoriesRoute();
		$posItemidNull 	= strpos($backLink, "Itemid=0");
		$posItemid 		= strpos($backLink, "Itemid=");
		
		if ($posItemidNull === false && $posItemid) {
			$backLinkItemId = 1;
		}
		$parentCategory = $this->get('parentcategory');  

		if ($display_back_button == 1) {
			if (!empty($parentCategory)) {
				
				$items[$iS] = &$parentCategory;
				// USER RIGHT - ACCESS - - - - - - - - - - -
				// Should be the link to parentcategory displayed
				$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $items[$iS]->accessuserid, $items[$iS]->access, $user->get('aid', 0), $user->get('id', 0), $display_access_category);
				
				// Display Key Icon (in case we want to display unaccessable categories in list view)
				$rightDisplayKey  = 1;
				if ($display_access_category == 1) {
					// we simulate that we want not to display unaccessable categories
					// so we get rightDisplayKey = 0 then the key will be displayed
					if (!empty($parentCategory)) {
						$rightDisplayKey = PhocaGalleryAccess::getUserRight ('accessuserid', $items[$iS]->accessuserid, $items[$iS]->access, $user->get('aid', 0), $user->get('id', 0), 0);
					}
				}
				// - - - - - - - - - - - - - - - - - - - - -

				if ($rightDisplay > 0) {
					$items[$iS]->slug			 		= $items[$iS]->id . ':' . $items[$iS]->alias;
					$items[$iS]->item_type				= "parentfolder";
					$items[$iS]->linkthumbnailpath 		= PhocaGalleryImageFront::displayBackFolder('medium', $rightDisplayKey);
					$items[$iS]->extm					= $items[$iS]->linkthumbnailpath;
					$items[$iS]->exts					= $items[$iS]->linkthumbnailpath;
					$items[$iS]->numlinks 				= 0;// We are in category view
					$items[$iS]->link 					= JRoute::_('index.php?option=com_phocagallery&view=category&id='. $items[$iS]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
					$items[$iS]->button 				= &$folderButton;
					$items[$iS]->button->methodname 	= '';
					$items[$iS]->displayicondetail 		= 0;				   
					$items[$iS]->displayicondownload 	= 0;
					$items[$iS]->displayiconfolder 		= 0;
					$items[$iS]->displayname 			= 0;
					$items[$iS]->displayiconvm 			= '';
					$items[$iS]->startpiclens 			= 0;
					$items[$iS]->trash					= 0;
					$items[$iS]->publishunpublish		= 0;
					$items[$iS]->approvednotapproved	= 0;
					$items[$iS]->enable_piclens			= 0;
					$items[$iS]->overlib				= 0;
					$items[$iS]->displayicongeo			= 0;
					$items[$iS]->type					= 0;
					$items[$iS]->camerainfo				= 0;
					$items[$iS]->displayiconextlink1	= 0;
					$items[$iS]->displayiconextlink2	= 0;
					$items[$iS]->displayiconcommentimg	= '';
					$items[$iS]->description			= '';
					$items[$iS]->altvalue				= '';
					$iS++;
				} else {
					// There is no right to see the data but the object exists (because it was loaded from database
					// Destroy it
					unset($items[$iS]);
				}
			} else { // Back button to categories list if it exists
				if ($backLinkItemId != 0 && $display_categories_back_button == 1) {
					$items[$iS] 						= new JObject();
					$items[$iS]->link 					= JRoute::_($backLink);
					$items[$iS]->title					= JTEXT::_('Category List');
					$items[$iS]->item_type 				= "categorieslist";
					$items[$iS]->linkthumbnailpath 		= PhocaGalleryImageFront::displayBackFolder('medium', 1);
					$items[$iS]->extm					= $items[$iS]->linkthumbnailpath;
					$items[$iS]->exts					= $items[$iS]->linkthumbnailpath;
					$items[$iS]->numlinks 				= 0;// We are in category view
					$items[$iS]->button 				= &$folderButton;
					$items[$iS]->button->methodname 	= '';
					$items[$iS]->displayicondetail 		= 0;				   
					$items[$iS]->displayicondownload	= 0;
					$items[$iS]->displayiconfolder 		= 0;
					$items[$iS]->displayname 			= 0;
					$items[$iS]->displayiconvm 			= '';
					$items[$iS]->startpiclens 			= 0;
					$items[$iS]->trash					= 0;
					$items[$iS]->publishunpublish		= 0;
					$items[$iS]->approvednotapproved	= 0;
					$items[$iS]->enable_piclens			= 0;
					$items[$iS]->overlib				= 0;
					$items[$iS]->displayicongeo			= 0;
					$items[$iS]->type					= 0;
					$items[$iS]->camerainfo				= 0;
					$items[$iS]->displayiconextlink1	= 0;
					$items[$iS]->displayiconextlink2	= 0;
					$items[$iS]->displayiconcommentimg	= '';
					$items[$iS]->description			= '';
					$items[$iS]->altvalue				= '';
					$iS++;
				}
			}
		}
		
		
		// ----------------------------------------
		// PARENT FOLDERS(II) or Back Button CATEGORIES VIEW IN CATEGORY VIEW
		// ---------------------------------------- 
		if ($display_back_button_cv == 1 && $tmpl['displaycategoriescv'] == 1) {
			if (!empty($parentCategory)) {
				
				$itemsCV[$iCV] = &$parentCategory;
				// USER RIGHT - ACCESS - - - - - - - - - - -
				// Should be the link to parentcategory displayed
				$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $itemsCV[$iCV]->accessuserid, $itemsCV[$iCV]->access, $user->get('aid', 0), $user->get('id', 0), $display_access_category);
				
				// Display Key Icon (in case we want to display unaccessable categories in list view)
				$rightDisplayKey  = 1;
				if ($display_access_category == 1) {
					// we simulate that we want not to display unaccessable categories
					// so we get rightDisplayKey = 0 then the key will be displayed
					if (!empty($parentCategory)) {
						$rightDisplayKey = PhocaGalleryAccess::getUserRight ('accessuserid', $itemsCV[$iCV]->accessuserid, $itemsCV[$iCV]->access, $user->get('aid', 0), $user->get('id', 0), 0);
					}
				}
				// - - - - - - - - - - - - - - - - - - - - -
				
				if ($rightDisplay > 0) {
					$itemsCV[$iCV]->slug 				= $itemsCV[$iCV]->id.':'.$itemsCV[$iCV]->alias;
					$itemsCV[$iCV]->item_type 			= "parentfoldercv";
					$itemsCV[$iCV]->linkthumbnailpath	= PhocaGalleryImageFront::displayBackFolder('medium', $rightDisplayKey);
					$itemsCV[$iCV]->extm				= $itemsCV[$iCV]->linkthumbnailpath;
					$itemsCV[$iCV]->exts				= $itemsCV[$iCV]->linkthumbnailpath;
					$itemsCV[$iCV]->numlinks 			= 0;// We are in category view
					$itemsCV[$iCV]->link = JRoute::_('index.php?option=com_phocagallery&view=category&id='. $itemsCV[$iCV]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
					$itemsCV[$iCV]->type				= 3;
					$itemsCV[$iCV]->altvalue			= '';
					$iCV++;
				} else {
					// There is no right to see the data but the object exists (because it was loaded from database
					// Destroy it
					unset($itemsCV[$iCV]);
				}
			} else { // Back button to categories list if it exists
				if ($backLinkItemId != 0 && $display_categories_back_button_cv == 1) {
					$itemsCV[$iCV] 						= new JObject();
					$itemsCV[$iCV]->link 				= $backLink;
					$itemsCV[$iCV]->title				= JTEXT::_('Category List');
					$itemsCV[$iCV]->item_type 			= "categorieslistcv";
					$itemsCV[$iCV]->linkthumbnailpath	= PhocaGalleryImageFront::displayBackFolder('medium', 1);
					$itemsCV[$iCV]->extm				= $itemsCV[$iCV]->linkthumbnailpath;
					$itemsCV[$iCV]->exts				= $itemsCV[$iCV]->linkthumbnailpath;
					$itemsCV[$iCV]->numlinks = 0;// We are in category view
					$itemsCV[$iCV]->link 				= JRoute::_( $itemsCV[$iCV]->link );
					$itemsCV[$iCV]->type				= 3;
					$itemsCV[$iCV]->altvalue			= '';
					$iCV++;
				}
			}
		}
		
		
		// ----------------------------------------
		// SUB FOLDERS(1) STANDARD
		// ----------------------------------------
		// Display subcategories on every page
		if ($display_subcat_page == 1) {

			$subCategory = $this->get('subcategory'); 
			$totalSubCat = count($subCategory);
			
			if (!empty($subCategory)) {
				$items[$iS] = &$subCategory;
		  
				for($iSub = 0; $iSub < $totalSubCat; $iSub++) {
					
					$items[$iS] = &$subCategory[$iSub];
					// USER RIGHT - ACCESS - - - - - - - - - - 
					$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $items[$iS]->accessuserid, $items[$iS]->access, $user->get('aid', 0), $user->get('id', 0), $display_access_category);
					
					// Display Key Icon (in case we want to display unaccessable categories in list view)
					$rightDisplayKey  = 1;
					if ($display_access_category == 1) {
						// we simulate that we want not to display unaccessable categories
						// so we get rightDisplayKey = 0 then the key will be displayed
						if (!empty($items[$iS])) {
							$rightDisplayKey = PhocaGalleryAccess::getUserRight('accessuserid', $items[$iS]->accessuserid, $items[$iS]->access, $user->get('aid', 0), $user->get('id', 0), 0);
						}
					}
					// - - - - - - - - - - - - - - - - - - - -
				
					if ($rightDisplay > 0) {
						
						$items[$iS]->slug 					= $items[$iS]->id.':'.$items[$iS]->alias;
						$items[$iS]->item_type 				= "subfolder";
						
						$numlinks 	= $model->getCountItem($items[$iS]->id);//Should be get from main subcategories query
						if (isset($numlinks[0]) && $numlinks[0] > 0) {
							$items[$iS]->numlinks = (int)$numlinks[0];
						} else {
							$items[$iS]->numlinks = 0;
						}
						
						if (isset($items[$iS]->extid) && $items[$iS]->extid != '') {
							
							if ($tmpl['categoryimageordering'] != 10) {
								$imagePic		= PhocaGalleryImageFront::getRandomImageRecursive($items[$iS]->id, $categoryImageOrdering, 1);
								$fileThumbnail	= PhocaGalleryImageFront::displayCategoryExtImgOrFolder($imagePic->exts, $imagePic->extm, 'medium', $rightDisplayKey, 'display_category_icon_image');
							} else {
								$fileThumbnail	= PhocaGalleryImageFront::displayCategoryExtImgOrFolder($items[$iS]->exts,$items[$iS]->extm, 'medium', $rightDisplayKey, 'display_category_icon_image');
								$imagePic->extw = $items[$iS]->extw;
								$imagePic->exth = $items[$iS]->exth;
							}
							// in case category is locked or no extm exists
							$items[$iS]->linkthumbnailpath	= $fileThumbnail->linkthumbnailpath;
							$items[$iS]->extm	= $fileThumbnail->extm;
							$items[$iS]->exts	= $fileThumbnail->exts;
							
							if ($imagePic->extw != '') {
								$extw 				= explode(',',$imagePic->extw);
								$items[$iS]->extw		= $extw[1];
								$items[$iS]->extwswitch	= $extw[0];
							}
							if ($imagePic->exth != '') {
								$exth 				= explode(',',$imagePic->exth);
								$items[$iS]->exth	= $exth[1];
								$items[$iS]->exthswitch	= $exth[0];
							}
							$items[$iS]->extpic		= $fileThumbnail->extpic;
						} else {
							if ($tmpl['categoryimageordering'] != 10) {
								$randomImage 	= PhocaGalleryImageFront::getRandomImageRecursive($items[$iS]->id, $categoryImageOrdering);
								$fileThumbnail 	= PhocaGalleryImageFront::displayCategoryImageOrFolder($randomImage, 'medium', $rightDisplayKey, 'display_category_icon_image');
							} else {
								$fileThumbnail 	= PhocaGalleryImageFront::displayCategoryImageOrFolder($items[$iS]->filename, 'medium', $rightDisplayKey, 'display_category_icon_image');
							}
							
							$items[$iS]->linkthumbnailpath  	= $fileThumbnail->rel;
						}
						$items[$iS]->link 					= JRoute::_('index.php?option=com_phocagallery&view=category&id='. $items[$iS]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
						$items[$iS]->button 				= &$folderButton;
						$items[$iS]->button->methodname 	= '';
						$items[$iS]->displayicondetail 		= 0;				   
						$items[$iS]->displayicondownload 	= 0;
						$items[$iS]->displayiconfolder 		= $tmpl['displayiconfolder'];
						$items[$iS]->displayname 			= $tmpl['displayname'];
						$items[$iS]->displayiconvm 			= '';
						$items[$iS]->startpiclens 			= 0;
						$items[$iS]->trash					= 0;
						$items[$iS]->publishunpublish		= 0;
						$items[$iS]->approvednotapproved	= 0;
						$items[$iS]->enable_piclens			= 0;
						$items[$iS]->overlib				= 0;
						$items[$iS]->displayicongeo			= 0;
						$items[$iS]->type					= 1;
						$items[$iS]->camerainfo				= 0;
						$items[$iS]->displayiconextlink1	= 0;
						$items[$iS]->displayiconextlink2	= 0;
						$items[$iS]->description			= '';
						$items[$iS]->displayiconcommentimg	= '';
						$items[$iS]->altvalue				= '';

						$iS++;
					} else {
						// There is no right to see the data but the object exists (because it was loaded from database
						// Destroy it
						unset($items[$iS]);
					}
				}
			}	
		}
		
		// ----------------------------------------
		// SUB FOLDERS(II) or Back Button CATEGORIES VIEW IN CATEGORY VIEW
		// ----------------------------------------
		//display subcategories on every page
		if ($display_subcat_page_cv == 1 && $tmpl['displaycategoriescv'] == 1) {	
			$subCategory = $this->get('subcategory'); 
			$totalSubCat = count($subCategory);
			
			if (!empty($subCategory)) {
				$itemsCV[$iCV] = &$subCategory;
				
				for($iSub = 0; $iSub < $totalSubCat; $iSub++) {
					
					$itemsCV[$iCV] = &$subCategory[$iSub];
					// USER RIGHT - ACCESS - - - - - - - - - - 
					$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $itemsCV[$iCV]->accessuserid, $itemsCV[$iCV]->access, $user->get('aid', 0), $user->get('id', 0), $display_access_category);
					
					// Display Key Icon (in case we want to display unaccessable categories in list view)
					$rightDisplayKey  = 1;
					if ($display_access_category == 1) {
						// we simulate that we want not to display unaccessable categories
						// so we get rightDisplayKey = 0 then the key will be displayed
						if (!empty($itemsCV[$iCV])) {
							$rightDisplayKey = PhocaGalleryAccess::getUserRight('accessuserid', $itemsCV[$iCV]->accessuserid, $itemsCV[$iCV]->access, $user->get('aid', 0), $user->get('id', 0), 0);
						}
					}
					// - - - - - - - - - - - - - - - - - - - -
				
					if ($rightDisplay > 0) {
					
						$itemsCV[$iCV]->slug 				= $itemsCV[$iCV]->id.':'.$itemsCV[$iCV]->alias;
						$itemsCV[$iCV]->item_type 			= "subfoldercv";
						$itemsCV[$iCV]->link 				= JRoute::_('index.php?option=com_phocagallery&view=category&id='. $itemsCV[$iCV]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
						$itemsCV[$iCV]->type				= 4;
						
						
						$numlinks = $model->getCountItem($itemsCV[$iCV]->id);//Should be get from main subcategories query
						if (isset($numlinks[0]) && $numlinks[0] > 0) {
							$itemsCV[$iCV]->numlinks = (int)$numlinks[0];
						} else {
							$itemsCV[$iCV]->numlinks = 0;
						}
						
						
						if (isset($itemsCV[$iCV]->extid) && $itemsCV[$iCV]->extid != '') {
							if ($tmpl['categoryimageordering'] != 10) {
								$imagePic= PhocaGalleryImageFront::getRandomImageRecursive($itemsCV[$iCV]->id, $categoryImageOrderingCV, 1);
								$fileThumbnail	= PhocaGalleryImageFront::displayCategoryExtImgOrFolder($imagePic->exts, $imagePic->extm, 'medium', $rightDisplayKey, 'display_category_icon_image');
							} else {
								$fileThumbnail	= PhocaGalleryImageFront::displayCategoryExtImgOrFolder($itemsCV[$iCV]->exts,$itemsCV[$iCV]->extm, 'medium', $rightDisplayKey, 'display_category_icon_image');
								$imagePic->extw = $itemsCV[$iCV]->extw;
								$imagePic->exth = $itemsCV[$iCV]->exth;
							}
					
							// in case category is locked or no extm exists
							$itemsCV[$iCV]->linkthumbnailpath	= $fileThumbnail->linkthumbnailpath;
							$itemsCV[$iCV]->extm	= $fileThumbnail->extm;
							$itemsCV[$iCV]->exts	= $fileThumbnail->exts;
							if ($imagePic->extw != '') {
								$extw 				= explode(',',$imagePic->extw);
								$itemsCV[$iCV]->extw= $extw[1];
								$itemsCV[$iCV]->extwswitch	= $extw[0];
							}
							if ($imagePic->exth != '') {
								$exth 				= explode(',',$imagePic->exth);
								$itemsCV[$iCV]->exth= $exth[1];
								$itemsCV[$iCV]->exthswitch	= $exth[0];
							}
							$itemsCV[$iCV]->extpic	= $fileThumbnail->extpic;
						} else {							
							if ($tmpl['categoryimageordering'] != 10) {
								$randomImage 	= PhocaGalleryImageFront::getRandomImageRecursive($itemsCV[$iCV]->id, $categoryImageOrderingCV);
								$fileThumbnail 	= PhocaGalleryImageFront::displayCategoryImageOrFolder($randomImage, 'medium', $rightDisplayKey, 'display_category_icon_image_cv');
							} else {
								$fileThumbnail 	= PhocaGalleryImageFront::displayCategoryImageOrFolder($itemsCV[$iCV]->filename, 'medium', $rightDisplayKey, 'display_category_icon_image_cv');
							}
							$itemsCV[$iCV]->linkthumbnailpath	= $fileThumbnail->rel;
							$itemsCV[$iCV]->altvalue			= '';
							
						}
						$iCV++;
					} else {
						// There is no right to see the data but the object exists (because it was loaded from database
						// Destroy it
						unset($itemsCV[$iCV]);
					}
				}
			}
		}
	
		
		
		// ----------------------------------------
		// IMAGES
		// ----------------------------------------
		// If user has rights to delete or publish or unpublish, unbublished items should be displayed
		if ($rightDisplayDelete == 1) {
			$images	= $model->getData(1);
			$tmpl['pagination']	= &$model->getPagination(1);
		} else {
			$images	= $model->getData(0);
			$tmpl['pagination']	= &$model->getPagination(0);
		}
		
		$totalImg = count($images);
		
		if ($limitStart > 0 ) {
			$tmpl['limitstarturl'] = '&limitstart='.$limitStart;
		} else {
			$tmpl['limitstarturl'] = '';
		}
		
		$tmpl['jakdatajs'] = array();
		$tmpl['displayiconcommentimgbox'] = 0;
		for($iM = 0; $iM < $totalImg; $iM++) {
			
			$items[$iS] 					= $images[$iM] ;
			$items[$iS]->slug 				= $items[$iS]->id.':'.$items[$iS]->alias;
			$items[$iS]->item_type 			= "image";
			
			// Get file thumbnail or No Image
			if ($items[$iS]->extm != '') {
				
				if ($items[$iS]->extw != '') {
					$extw 				= explode(',',$items[$iS]->extw);
					$items[$iS]->extw	= $extw[1];
					$items[$iS]->extwswitch	= $extw[0];
				}
				if ($items[$iS]->exth != '') {
					$exth 				= explode(',',$items[$iS]->exth);
					$items[$iS]->exth	= $exth[1];
					$items[$iS]->exthswitch	= $exth[0];
				}
				$items[$iS]->extpic	= 1;
			} else {
				$items[$iS]->linkthumbnailpath 	= PhocaGalleryImageFront::displayCategoryImageOrNoImage($items[$iS]->filename, 'medium');
			}
			
			if (isset($parentCategory->params)) {
				$items[$iS]->parentcategoryparams = $parentCategory->params;
			}
			
			// Add the first Image as basic image
			if ($tmpl['switchimage'] == 1) {
				if ($basicImageSelected == 0) {
				
					if ((int)$tmpl['switchwidth'] > 0 && (int)$tmpl['switchheight'] > 0 && $tmpl['switchfixedsize'] == 1 ) {
					
						$wHArray	= array( 'id' => 'PhocaGalleryobjectPicture', 'border' =>'0', 'width' => $tmpl['switchwidth'], 'height' => $tmpl['switchheight']);
						$wHString	= ' id="PhocaGalleryobjectPicture"  border="0" width="'. $tmpl['switchwidth'].'" height="'.$tmpl['switchheight'].'"';
					} else {
						$wHArray 	= array( 'id' => 'PhocaGalleryobjectPicture', 'border' =>'0');
						$wHString	= ' id="PhocaGalleryobjectPicture"  border="0"';
					}
				
					if (isset($items[$iS]->extpic) && $items[$iS]->extpic != '') {
						$tmpl['basicimage']	= JHTML::_( 'image', $items[$iS]->extl, '', $wHArray);
					} else {
						$tmpl['basicimage']	= JHTML::_( 'image.site', str_replace('phoca_thumb_m_','phoca_thumb_l_',$items[$iS]->linkthumbnailpath), '', '', '', '', $wHString);
						
					}
					$basicImageSelected = 1;
				}
			}

			$thumbLink	= PhocaGalleryFileThumbnail::getThumbnailName($items[$iS]->filename, 'large');
			$thumbLinkM	= PhocaGalleryFileThumbnail::getThumbnailName($items[$iS]->filename, 'medium');
			$imgLinkOrig= JURI::base(true) . '/' .PhocaGalleryFile::getFileOriginal($items[$iS]->filename, 1);
			if ($tmpl['detailwindow'] == 7) {
				$siteLink 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$category->slug.'&id='. $items[$iS]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
			} else {
				$siteLink 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$category->slug.'&id='. $items[$iS]->slug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
			} 
			$imgLink	= $thumbLink->rel;
			if (isset($items[$iS]->extid) &&  $items[$iS]->extid != '') {
				$imgLink		= $items[$iS]->extl;
				$imgLinkOrig	= $items[$iS]->exto;
			}
			
			// Detail Window
			if ($tmpl['detailwindow'] == 2 ) {
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2		= $imgLink;
				$items[$iS]->linkother	= $imgLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
			
			} else if ( $tmpl['detailwindow'] == 3 ) {
			
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2 		= $imgLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
			
			} else if ( $tmpl['detailwindow'] == 5 ) {
				
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2 		= $siteLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
			} else if ( $tmpl['detailwindow'] == 6 ) {
				
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2 		= $imgLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
				// jak data js
				switch ($tmpl['jakdescription']) {
					case 0:
						$descriptionJakJs = '';
					break;
					
					case 2:
						$descriptionJakJs = PhocaGalleryText::strTrimAll(addslashes( $items[$iS]->description));
					break;
					
					case 3:
						$descriptionJakJs = PhocaGalleryText::strTrimAll(addslashes($items[$iS]->title));
						if ($items[$iS]->description != '') {
							$descriptionJakJs .='<br />' .PhocaGalleryText::strTrimAll(addslashes($items[$iS]->description));
						}
					break;
					
					case 1:
					default:
						$descriptionJakJs = PhocaGalleryText::strTrimAll(addslashes($items[$iS]->title));
					break;
				}
				$items[$iS]->linknr		= $iM;
				$tmpl['jakdatajs'][$iS] = "{alt: '".PhocaGalleryText::strTrimAll(addslashes($items[$iS]->title))."',";
				if ($descriptionJakJs != '') {
					$tmpl['jakdatajs'][$iS] .= "description: '".$descriptionJakJs."',";
				} else {
					$tmpl['jakdatajs'][$iS] .= "description: ' ',";
				}
				
				if(isset($items[$iS]->extid) && $items[$iS]->extid != '') {
					$tmpl['jakdatajs'][$iS] .= "small: {url: '".$items[$iS]->extm."'},"
					."big: {url: '".$items[$iS]->extl."'} }";
				} else {
					$tmpl['jakdatajs'][$iS] .= "small: {url: '".htmlentities(JURI::base(true).'/'.PhocaGalleryText::strTrimAll(addslashes($thumbLinkM->rel)))."'},"
					."big: {url: '".htmlentities(JURI::base(true).'/'.PhocaGalleryText::strTrimAll(addslashes($imgLink)))."'} }";
				}
			} 
			
			// Added Slimbox URL settings
			
			else if ( $tmpl['detailwindow'] == 8 ) {
				
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2 		= $imgLink;
				$items[$iS]->linkother	= $imgLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
			} 
			// End Slimbox URL settings
			
			else {
			
				$items[$iS]->link 		= $siteLink;
				$items[$iS]->link2 		= $siteLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
			}
			
			// Buttons, e.g. shadowbox:
			// button - click on image
			// button2 - click on zoom icon (cannot be the same as click on image because of duplicity of images)
			// buttonOther - other detail window like download, geotagging
			$items[$iS]->button 			= &$button;
			$items[$iS]->button2 			= &$button2;
			$items[$iS]->buttonother 		= &$buttonOther;
			
			$items[$iS]->displayicondetail 	= $tmpl['displayicondetail'];
			$items[$iS]->displayicondownload= $tmpl['displayicondownload'];
			$items[$iS]->displayiconfolder 	= 0;
			$items[$iS]->displayname 		= $tmpl['displayname'];
			$items[$iS]->displayiconvm 		= '';
			$items[$iS]->startpiclens 		= $tmpl['startpiclens'] ;
			$items[$iS]->type				= 2;
			
			// Trash icon
			if ($tmpl['trash'] == 1) {
				$items[$iS]->trash	= 1;
			} else {
				$items[$iS]->trash	= 0;
			}
			
			// Publish Unpublish icon
			if ($tmpl['publishunpublish'] == 1) {
				$items[$iS]->publishunpublish	= 1;
			} else {
				$items[$iS]->publishunpublish	= 0;
			}
			
			// Publish Unpublish icon
			if ($tmpl['approvednotapproved'] == 1) {
				$items[$iS]->approvednotapproved	= 1;
			} else {
				$items[$iS]->approvednotapproved	= 0;
			}
			
			// PICLENS 
			if($tmpl['enablepiclens']) { 
				$items[$iS]->enable_piclens	= 1; 
			} else { 
				$items[$iS]->enable_piclens	= 0; 
			}
			
			// 2. GEOTAGGING IMAGE
			// We have checked the category so if geotagging is enabled
			// and there is no geotagging data for category, then $tmpl['displayicongeo'] = 0;
			// so we need to check it for the image too, we need to set the $tmpl['displayicongeoimage'] for image only
			// we are in loop now
			$tmpl['displayicongeoimagetmp'] = 0;
			if ($tmpl['displayicongeoimage'] == 1) {
				
				$tmpl['displayicongeoimagetmp'] = 1;
				if (isset($items[$iS]->latitude) && $items[$iS]->latitude != '' && $items[$iS]->latitude != 0
					&& isset($items[$iS]->longitude) && $items[$iS]->longitude != '' && $items[$iS]->longitude != 0 ) {
				} else {
					$tmpl['displayicongeoimagetmp'] = 0;
				}
			}
			
			// GEOTAGGING
			if($tmpl['displayicongeo'] == 1 || $tmpl['displayicongeoimagetmp'] == 1) { 
				$items[$iS]->displayicongeo		= 1;
				$tmpl['displayicongeobox']	= 1;// because of height of box			
			} else { 
				$items[$iS]->displayicongeo	= 0; 
			}
			
			// Set it back because of loop
			$tmpl['displayicongeoimagetmp'] = 0;
			
			// CAMERA INFO 
			if($tmpl['displaycamerainfo'] == 1) { 
				$items[$iS]->camerainfo			= 1;
			} else { 
				$items[$iS]->camerainfo			= 0;	 
			}
			
			// EXT LINK
			$items[$iS]->displayiconextlink1	= 0;
			if (isset($items[$iS]->extlink1)) {
				$items[$iS]->extlink1	= explode("|", $items[$iS]->extlink1, 4);
				if (isset($items[$iS]->extlink1[0]) && isset($items[$iS]->extlink1[1])) {
					$items[$iS]->displayiconextlink1		= 1;
					$tmpl['displayiconextlink1box'] = 1;// because of height of box
					if (!isset($items[$iS]->extlink1[2])) {
						$items[$iS]->extlink1[2] = '_self';
					}
					if (!isset($items[$iS]->extlink1[3]) || $items[$iS]->extlink1[3] == 1) {
						$items[$iS]->extlink1[4] = JHTML::_('image', 'components/com_phocagallery/assets/images/icon-extlink1.'.$tmpl['formaticon'], JText::_($items[$iS]->extlink1[1]));
						$items[$iS]->extlink1[5] = '';
					} else {
						$items[$iS]->extlink1[4] = $items[$iS]->extlink1[1];
						$items[$iS]->extlink1[5] = 'style="text-decoration:underline"';
					}
				} else {
					$items[$iS]->displayiconextlink1		= 0;
				}
			}
			
			$items[$iS]->displayiconextlink2		= 0;
			if (isset($items[$iS]->extlink2)) {
				$items[$iS]->extlink2	= explode("|", $items[$iS]->extlink2, 4);
				if (isset($items[$iS]->extlink2[0]) && isset($items[$iS]->extlink2[1])) {
					$items[$iS]->displayiconextlink2		= 1;
					$tmpl['displayiconextlink2box'] = 1;// because of height of box
					if (!isset($items[$iS]->extlink2[2])) {
						$items[$iS]->extlink2[2] = '_self';
					}
					if (!isset($items[$iS]->extlink2[3]) || $items[$iS]->extlink2[3] == 1) {
						$items[$iS]->extlink2[4] = JHTML::_('image', 'components/com_phocagallery/assets/images/icon-extlink2.'.$tmpl['formaticon'], JText::_($items[$iS]->extlink2[1]));
						$items[$iS]->extlink2[5] = '';
					}else {
						$items[$iS]->extlink2[4] = $items[$iS]->extlink2[1];
						$items[$iS]->extlink2[5] = 'style="text-decoration:underline"';
					}
				} else {
					$items[$iS]->displayiconextlink2		= 0;
				}
			}
				
			
			// OVERLIB
			if (!empty($items[$iS]->description)) {
				$divPadding = 'padding:5px;';
			} else {
				$divPadding = 'padding:0px;margin:0px;';
			}
			
			// Resize image in overlib by rate
			$wHOutput = array();
			if (isset($items[$iS]->extpic) && $items[$iS]->extpic != '') {
				if ((int)$tmpl['overlibimagerate'] > 0) {
					$imgSize	= @getimagesize($items[$iS]->extl);
					$wHOutput	= PhocaGalleryImage::getTransformImageArray($imgSize, $tmpl['overlibimagerate']);
				}
				
				$oImg		= JHTML::_( 'image', $items[$iS]->extl, htmlspecialchars( addslashes($items[$iS]->title)), $wHOutput );
			} else {
				if ((int)$tmpl['overlibimagerate'] > 0) {
					$thumbL 	= str_replace ('phoca_thumb_m_','phoca_thumb_l_',$items[$iS]->linkthumbnailpath);
					$imgSize	= @getimagesize($thumbL);
					$wHOutput	= PhocaGalleryImage::getTransformImageArray($imgSize, $tmpl['overlibimagerate']);
				}
				$oImg	= JHTML::_( 'image.site', str_replace ('phoca_thumb_m_','phoca_thumb_l_',$items[$iS]->linkthumbnailpath), '', '', '', $items[$iS]->title, $wHOutput );
			}
			
			if ($enable_overlib == 1) { 
				$items[$iS]->overlib			= 1;
				$items[$iS]->overlib_value 		= " onmouseover=\"return overlib('".htmlspecialchars( addslashes('<div class="pg-overlib"><center>' . $oImg . "</center></div>"))."', CAPTION, '". htmlspecialchars( addslashes($items[$iS]->title))."', BELOW, RIGHT, BGCLASS,'bgPhocaClass', FGCOLOR, '".$tmpl['olfgcolor']."', BGCOLOR, '".$tmpl['olbgcolor']."', TEXTCOLOR, '".$tmpl['oltfcolor']."', CAPCOLOR, '".$tmpl['olcfcolor']."');\""
				. " onmouseout=\"return nd();\" ";
			} else if ($enable_overlib == 2){ 
				$items[$iS]->overlib			= 2;
				$items[$iS]->description		= str_replace("\n", '<br />', $items[$iS]->description);
				$items[$iS]->overlib_value 		= " onmouseover=\"return overlib('".htmlspecialchars( addslashes('<div class="pg-overlib"><div style="'.$divPadding.'">'.$items[$iS]->description.'</div></div>'))."', CAPTION, '". htmlspecialchars( addslashes($items[$iS]->title))."', BELOW, RIGHT, CSSCLASS, TEXTFONTCLASS, 'fontPhocaClass', FGCLASS, 'fgPhocaClass', BGCLASS, 'bgPhocaClass', CAPTIONFONTCLASS,'capfontPhocaClass', CLOSEFONTCLASS, 'capfontclosePhocaClass');\""
				. " onmouseout=\"return nd();\" ";				
			} else if ($enable_overlib == 3){ 
				$items[$iS]->overlib			= 3;
				$items[$iS]->description		= str_replace("\n", '<br />', $items[$iS]->description);
				$items[$iS]->overlib_value 		= " onmouseover=\"return overlib('".PhocaGalleryText::strTrimAll(htmlspecialchars( addslashes( '<div class="pg-overlib"><div style="text-align:center"><center>' . $oImg . '</center></div><div style="'.$divPadding.'">' . $items[$iS]->description . '</div></div>')))."', CAPTION, '". htmlspecialchars( addslashes($items[$iS]->title))."', BELOW, RIGHT, BGCLASS,'bgPhocaClass', FGCLASS,'fgPhocaClass', FGCOLOR, '".$tmpl['olfgcolor']."', BGCOLOR, '".$tmpl['olbgcolor']."', TEXTCOLOR, '".$tmpl['oltfcolor']."', CAPCOLOR, '".$tmpl['olcfcolor']."');\""
				. " onmouseout=\"return nd();\" ";				
			} else { 
				$items[$iS]->overlib			= 0;
				$items[$iS]->overlib_value		= '';				
			}
			
						
			// VirtueMart link 
			if ($tmpl['displayiconvm'] == 1) {
			
				phocagalleryimport('virtuemart.virtuemart');				
				$vmLink	= PhocaGalleryVirtueMart::getVmLink($items[$iS]->vmproductid, $errorMsg);
				if (!$vmLink) {
					$items[$iS]->displayiconvm	= '';
				} else {
					$items[$iS]->displayiconvm	= 1;
					$items[$iS]->vmlink			= $vmLink;
					$tmpl['displayiconvmbox']	= 1;// because of height of box
				}
				
			} else {
				$items[$iS]->displayiconvm = '';
			}
			// End VM Link
			
			// V O T E S - IMAGES
			if ((int)$tmpl['displayratingimg'] == 1) {
				$items[$iS]->votescountimg		= 0;
				$items[$iS]->votesaverageimg	= 0;
				$items[$iS]->voteswidthimg		= 0;
				$votesStatistics	= PhocaGalleryRateImage::getVotesStatistics((int)$items[$iS]->id);
				if (!empty($votesStatistics->count)) {
					$items[$iS]->votescountimg = $votesStatistics->count;
				}
				if (!empty($votesStatistics->average)) {
					$items[$iS]->votesaverageimg = $votesStatistics->average;
					if ($items[$iS]->votesaverageimg > 0) {
						$items[$iS]->votesaverageimg 	= round(((float)$items[$iS]->votesaverageimg / 0.5)) * 0.5;
						$items[$iS]->voteswidthimg		= 16 * $items[$iS]->votesaverageimg;
					} else {
						$items[$iS]->votesaverageimg = (int)0;// not float displaying
					}
					
				}
			}
			
			
			$items[$iS]->displayiconcommentimg	= 0;
			// C O M M E N T S - IMAGES
			if ((int)$tmpl['displaycommentimg'] == 1) {
				$items[$iS]->displayiconcommentimg	= 1;
				$tmpl['displayiconcommentimgbox']	= 1;// because of height of box
				
			}
			
			// ALT VALUE
			$altValue	= PhocaGalleryRenderFront::getAltValue($tmpl['altvalue'], $items[$iS]->title, $items[$iS]->description, $items[$iS]->metadesc);
			$items[$iS]->altvalue				= $altValue;
			
			$iS++;
		}
	
		
		// Upload Form - - - - - - - - - - - - -
		// Set FTP form
		$ftp = !JClientHelper::hasCredentials('ftp');

		// PARAMS - Upload size
		$tmpl['uploadmaxsize'] = $params->get( 'upload_maxsize', 3000000 );
		
		$this->assignRef('session', JFactory::getSession());
		//$this->assignRef('uploadmaxsize', $upload_maxsize);
		// END Upload Form - - - - - - - - - - - -
			
		
		// V O T E S - CATEGORY
		// Only registered (VOTES + COMMENTS)
		$tmpl['notregistered'] 	= true;
		$tmpl['name']		= '';
		if ($user->aid > 0) {
			$tmpl['notregistered'] 	= false;
			$tmpl['name']		= $user->name;
		}	
			
		// VOTES Statistics
		if ((int)$tmpl['displayrating'] == 1) {
			$tmpl['votescount']		= 0;
			$tmpl['votesaverage'] 	= 0;
			$tmpl['voteswidth']		= 0;
			$votesStatistics	= PhocaGalleryRateCategory::getVotesStatistics((int)$id);
			if (!empty($votesStatistics->count)) {
				$tmpl['votescount'] = $votesStatistics->count;
			}
			if (!empty($votesStatistics->average)) {
				$tmpl['votesaverage'] = $votesStatistics->average;
				if ($tmpl['votesaverage'] > 0) {
					$tmpl['votesaverage'] 	= round(((float)$tmpl['votesaverage'] / 0.5)) * 0.5;
					$tmpl['voteswidth']		= 22 * $tmpl['votesaverage'];
				} else {
					$tmpl['votesaverage'] = (int)0;// not float displaying
				}
				
			}
			if ((int)$tmpl['votescount'] > 1) {
				$tmpl['votestext'] = 'votes';
			} else {
				$tmpl['votestext'] = 'vote';
			}
		
			// Already rated?
			$tmpl['alreadyrated']	= PhocaGalleryRateCategory::checkUserVote( (int)$id, (int)$user->id );
		}
		
		

		// COMMENTS
		if ((int)$tmpl['displaycomment'] == 1) {
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/comments.js');
			$document->addCustomTag(PhocaGalleryRenderFront::renderCommentJS((int)$tmpl['maxcommentchar']));
		
			$tmpl['alreadycommented'] 	= PhocaGalleryCommentCategory::checkUserComment( (int)$id, (int)$user->id );
			$commentItem				= PhocaGalleryCommentCategory::displayComment( (int)$id );
	
			$this->assignRef( 'commentitem',		$commentItem);
		}

		
		
		// - - - - - - - - - - - - - - - -
		// TABS
		// - - - - - - - - - - - - - - - - 
		$displayTabs	= 0;
		
		// R A T I N G
		if ((int)$tmpl['displayrating'] == 0) {
			$currentTab['rating'] = -1;	
		} else {
			$currentTab['rating'] = $displayTabs;
			$displayTabs++;
		}
		
		// C O M M E N T S
		if ((int)$tmpl['displaycomment'] == 0) {
			$currentTab['comment'] = -1;
		} else {
			$currentTab['comment'] = $displayTabs;
			$displayTabs++;	
		}
		
		// S T A T I S T I C S
		if ((int)$tmpl['displaycategorystatistics'] == 0) {
			$currentTab['statistics'] = -1;
		} else {
			$currentTab['statistics'] = $displayTabs;
			$displayTabs++;

			
			$tmpl['displaymaincatstat']			= $params->get( 'display_main_cat_stat', 1 );
			$tmpl['displaylastaddedcatstat']	= $params->get( 'display_lastadded_cat_stat', 1 );
			$tmpl['displaymostviewedcatstat']	= $params->get( 'display_mostviewed_cat_stat', 1 );
			$tmpl['countlastaddedcatstat']		= $params->get( 'count_lastadded_cat_stat', 3 );
			$tmpl['countmostviewedcatstat']		= $params->get( 'count_mostviewed_cat_stat', 3 );
			
			
			if ($tmpl['displaymaincatstat'] == 1) {
				$numberImgP		= $model->getCountImages($id, 1);
				$tmpl['numberimgpub'] 	= $numberImgP->countimg;
				$numberImgU		= $model->getCountImages($id, 0);
				$tmpl['numberimgunpub'] = $numberImgU->countimg;
				$categoryViewed	= $model->getHits($id);
				$tmpl['categoryviewed'] = $categoryViewed->catviewed;
			}
			
			// M O S T   V I E W E D   I M A G E S 
			//$tmpl['mostviewedimg'] = array();
			if ($tmpl['displaymostviewedcatstat'] == 1) {
				$mostViewedImages	= $model->getStatisticsImages($id, 'hits', 'DESC', $tmpl['countmostviewedcatstat']);
				for($i = 0; $i <  count($mostViewedImages); $i++) {
					$itemMVI 		=& $mostViewedImages[$i];
					$itemMVI->button 				= &$button;
					$itemMVI->button2 				= &$button2;
					$itemMVI->buttonother 			= &$buttonOther;
					$itemMVI->displayicondetail 	= $tmpl['displayicondetail'];
					$itemMVI->displayname 			= $tmpl['displayname'];
					$itemMVI->type		 			= 2;
					
					$altValue	= PhocaGalleryRenderFront::getAltValue($tmpl['altvalue'], $itemMVI->title, $itemMVI->description, $itemMVI->metadesc);
					$itemMVI->altvalue				= $altValue;
					
					$thumbLink	= PhocaGalleryFileThumbnail::getThumbnailName($itemMVI->filename, 'large');
					$siteLink 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$category->slug.'&id='. $itemMVI->slug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
					$imgLink	= JURI::base(true) . '/'.$thumbLink->rel;
					if ($tmpl['detailwindow'] == 2 || $tmpl['detailwindow'] == 8) {
						$itemMVI->link 		= $imgLink;
					} else {
						$itemMVI->link 		= $siteLink;
					}
					//$tmpl['mostviewedimg'][] = $itemMVI;
					if ($itemMVI->extw != '') {
						$extw 				= explode(',',$itemMVI->extw);
						$itemMVI->extw		= $extw[1];
					}
					if ($itemMVI->exth != '') {
						$exth 				= explode(',',$itemMVI->exth);
						$itemMVI->exth	= $exth[1];
					}
				}
				
				$tmpl['mostviewedimg'] = $mostViewedImages;
			}
			
			// L A S T   A D D E D   I M A G E S
			//$tmpl['lastaddedimg'] = array();
			if ($tmpl['displaylastaddedcatstat'] == 1) {			
				$lastAddedImages	= $model->getStatisticsImages($id, 'date', 'DESC', $tmpl['countlastaddedcatstat']);
				for($i = 0; $i <  count($lastAddedImages); $i++) {
					$itemLAI 		=& $lastAddedImages[$i];
					$itemLAI->link 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$category->slug.'&id='. $itemLAI->slug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
					$itemLAI->button 				= &$button;
					$itemLAI->button2 				= &$button2;
					$itemLAI->buttonother 			= &$buttonOther;
					$itemLAI->displayicondetail 	= $tmpl['displayicondetail'];
					$itemLAI->displayname 			= $tmpl['displayname'];
					$itemLAI->type		 			= 2;
					
					$altValue	= PhocaGalleryRenderFront::getAltValue($tmpl['altvalue'], $itemLAI->title, $itemLAI->description, $itemLAI->metadesc);
					$itemLAI->altvalue				= $altValue;
					
					$thumbLink	= PhocaGalleryFileThumbnail::getThumbnailName($itemLAI->filename, 'large');
					$siteLink 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$category->slug.'&id='. $itemLAI->slug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
					$imgLink	= JURI::base(true) . '/'.$thumbLink->rel;
					if ($tmpl['detailwindow'] == 2 || $tmpl['detailwindow'] == 8) {
						$itemLAI->link 		= $imgLink;
					} else {
						$itemLAI->link 		= $siteLink;
					}
					//$tmpl['lastaddedimg'][] = $itemLAI;
					
					if ($itemLAI->extw != '') {
						$extw 				= explode(',',$itemLAI->extw);
						$itemLAI->extw		= $extw[1];
					}
					if ($itemLAI->exth != '') {
						$exth 				= explode(',',$itemLAI->exth);
						$itemLAI->exth	= $exth[1];
					}
				}
				$tmpl['lastaddedimg'] = $lastAddedImages;
			}
		}
		
		// G E O T A G G I N G
		if ((int)$tmpl['displaycategorygeotagging'] == 0) {
			$currentTab['geotagging'] = -1;
		} else if ( $map['longitude'] == '') {
			$currentTab['geotagging'] = -1;
		} else if ( $map['latitude'] == '') {
			$currentTab['geotagging'] = -1;
		} else {
			$currentTab['geotagging'] = $displayTabs;
			$displayTabs++;	
			
			$tmpl['googlemapsapikey'] 			= $params->get( 'google_maps_api_key', '' );
			$tmpl['categorymapwidth'] 			= $params->get( 'category_map_width', '' );
			$tmpl['categorymapheight'] 			= $params->get( 'category_map_height', 400 );
	
		}
		
		// U P L O A D
		if ((int)$tmpl['displayupload'] == 0) {
			$currentTab['upload'] = -1;
		}else {
			$currentTab['upload'] = $displayTabs;
			$displayTabs++;	
		}
	
		$tmpl['displaytabs']	= $displayTabs;
		$tmpl['currenttab']		= $currentTab;
		
		
		// ACTION
		$tmpl['action']	= $uri->toString();
		$tmpl['action'] = str_replace ('&amp;', '&', $tmpl['action']);// in case mixed amp will be included in the link
		$tmpl['action'] = str_replace ('&', '&amp;', $tmpl['action']);
		
		// ADD STATISTICS
		$model->hit($id);
		
		// ADD JAK DATA CSS style
		if ( $tmpl['detailwindow'] == 6 ) {
			$document->addCustomTag('<script type="text/javascript">'
			. 'var dataJakJs = ['
			. implode($tmpl['jakdatajs'], ',')
			. ']'
			. '</script>');
		}
		
		// Meta data
		if ($category->metakey != '') {
			$mainframe->addMetaTag('keywords', $category->metakey);
		} else if ($tmpl['gallerymetakey'] != '') {
			$mainframe->addMetaTag('keywords', $tmpl['gallerymetakey']);
		}
		if ($category->metadesc != '') {
			$mainframe->addMetaTag('description', $category->metadesc);
		} else if ($tmpl['gallerymetadesc'] != '') {
			$mainframe->addMetaTag('description', $tmpl['gallerymetadesc']);
		}
		
		// ASIGN
		$this->assignRef( 'tmpl',				$tmpl);
		$this->assignRef( 'params' ,			$params);
		$this->assignRef( 'map',				$map);		
		$this->assignRef( 'items' ,				$items);// Category View
		$this->assignRef( 'itemscv' ,			$itemsCV);// Categories View in Category View
		$this->assignRef( 'category' ,			$category);
		$this->assignRef( 'button',				$button );
		$this->assignRef( 'button2',			$button2 );
		$this->assignRef( 'buttonother',		$buttonOther );
		parent::display($tpl);
		echo $tmpl['divs'];
		
	}
	
	/**
	 * Method to add Breadcrubms in Phoca Gallery
	 * @param array $category Object array of Category
	 * @param int $rootId Id of Root Category
	 * @param int $displayStyle Displaying of Breadcrubm - Nothing, Category Name, Menu link with Name
	 * @return string Breadcrumbs
	 */
	function _addBreadCrumbs($category, $rootId, $displayStyle)
	{
	    global $mainframe;
		$i = 0;
	    while (isset($category->id))
	    {
			$crumbList[$i++] = $category;
			if ($category->id == $rootId)
			{
				break;
			}

	        $db =& JFactory::getDBO();
	        $query = 'SELECT *' .
	            ' FROM #__phocagallery_categories AS c' .
	            ' WHERE c.id = '.(int) $category->parent_id.
	            ' AND c.published = 1';
	        $db->setQuery($query);
	        $rows = $db->loadObjectList('id');
			if (!empty($rows))
			{
				$category = $rows[$category->parent_id];
			}
			else
			{
				$category = '';
			}
		//	$category = $rows[$category->parent_id];
	    }

	    $pathway 		=& $mainframe->getPathway();
		$pathWayItems 	= $pathway->getPathWay();
		$lastItemIndex 	= count($pathWayItems) - 1;

	    for ($i--; $i >= 0; $i--)
	    {
			// special handling of the root category
			if ($crumbList[$i]->id == $rootId) 
			{
				switch ($displayStyle) 
				{
					case 0:	// 0 - only menu link
						// do nothing
						break;
					case 1:	// 1 - menu link with category name
						// replace the last item in the breadcrumb (menu link title) with the current value plus the category title
						$pathway->setItemName($lastItemIndex, $pathWayItems[$lastItemIndex]->name . ' - ' . $crumbList[$i]->title);
						break;
					case 2:	// 2 - only category name
						// replace the last item in the breadcrumb (menu link title) with the category title
						$pathway->setItemName($lastItemIndex, $crumbList[$i]->title);
						break;
				}
			} 
			else 
			{
				$pathway->addItem($crumbList[$i]->title, JRoute::_('index.php?option=com_phocagallery&view=category&id='. $crumbList[$i]->id.':'.$crumbList[$i]->alias.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ));
			}
	    }
	}	
}
?>
