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
phocagalleryimport('phocagallery.comment.comment');
phocagalleryimport('phocagallery.comment.commentimage');
phocagalleryimport( 'phocagallery.picasa.picasa');
class PhocaGalleryViewComment extends JView
{
	function display($tpl = null) {
		global $mainframe;
		$tmpl = array();
		
		$document	= & JFactory::getDocument();		
		$params		= &$mainframe->getParams();
		$user 		= &JFactory::getUser();
		$uri 		= &JFactory::getURI();
		
		// PLUGIN WINDOW - we get information from plugin
		$get				= '';
		$get['comment']		= JRequest::getVar( 'comment', '', 'get', 'string' );
		$tmpl['id']			= JRequest::getVar('id', 0, '', 'int');
		$tmpl['catid'] 		= JRequest::getVar('catid', '', 'get', 'string');
		
		$tmpl['maxcommentchar']			= $params->get( 'max_comment_char', 1000 );
		$tmpl['displaycommentimg']		= $params->get( 'display_comment_img', 0 );
		$tmpl['detailwindowbackgroundcolor']= $params->get( 'detail_window_background_color', '#ffffff' );
		$tmpl['formaticon']				= &PhocaGalleryImage::getFormatIcon();
		$tmpl['commentwidth']			= $params->get( 'comment_width', 500 );
		$tmpl['externalcommentsystem'] 	= $params->get( 'external_comment_system', 0 );
		$tmpl['gallerymetakey'] 		= $params->get( 'gallery_metakey', '' );
		$tmpl['gallerymetadesc'] 		= $params->get( 'gallery_metadesc', '' );
		$tmpl['altvalue']		 		= $params->get( 'alt_value', 1 );
		$tmpl['largewidth'] 			= $params->get( 'large_image_width', 640 );
		$tmpl['largeheight'] 			= $params->get( 'large_image_height', 480 );
		$tmpl['picasa_correct_width_l']	= (int)$params->get( 'large_image_width', 640 );	
		$tmpl['picasa_correct_height_l']= (int)$params->get( 'large_image_height', 480 );
		
		$tmpl['fb_comment_app_id']			= $params->get( 'fb_comment_app_id', '');
		$tmpl['fb_comment_width']			= (int)$params->get( 'fb_comment_width', '550');
		$tmpl['display_comment_nopup']		= $params->get( 'display_comment_nopup', 0);
		
		if ($tmpl['gallerymetakey'] != '') {
			$mainframe->addMetaTag('keywords', $tmpl['gallerymetakey']);
		}
		if ($tmpl['gallerymetadesc'] != '') {
			$mainframe->addMetaTag('description', $tmpl['gallerymetadesc']);
		}
		
		// START CSS
		$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/phocagallery.css');
		
		// PARAMS - Open window parameters - modal popup box or standard popup window
		$detail_window = $params->get( 'detail_window', 0 );
		$tmpl['df'] = PhocaGalleryRenderFront::getString();
		
		// Plugin information
		if (isset($get['comment']) && $get['comment'] != '') {
			$detail_window = $get['comment'];
		}
		
		
		// Only registered (VOTES + COMMENTS)
		$tmpl['notregistered'] 	= true;
		$tmpl['name']		= '';
		if ($user->aid > 0) {
			$tmpl['notregistered'] 	= false;
			$tmpl['name']		= $user->name;
		}
		
		$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/comments.js');
		$document->addCustomTag(PhocaGalleryRenderFront::renderCommentJS((int)$tmpl['maxcommentchar']));
		
		$tmpl['alreadycommented'] 	= PhocaGalleryCommentImage::checkUserComment( (int)$tmpl['id'], (int)$user->id );
		$commentItem				= PhocaGalleryCommentImage::displayComment( (int)$tmpl['id'] );
	
		

		
		// PARAMS - Display Description in Detail window - set the font color
		$tmpl['detailwindowbackgroundcolor']= $params->get( 'detail_window_background_color', '#ffffff' );
		$tmpl['detailwindow']			 	= $params->get( 'detail_window', 0 );
		$description_lightbox_font_color 	= $params->get( 'description_lightbox_font_color', '#ffffff' );
		$description_lightbox_bg_color 		= $params->get( 'description_lightbox_bg_color', '#000000' );
		$description_lightbox_font_size 	= $params->get( 'description_lightbox_font_size', 12 );

		// NO SCROLLBAR IN DETAIL WINDOW
		$document->addCustomTag( "<style type=\"text/css\"> \n" 
			." html,body, .contentpane{background:".$tmpl['detailwindowbackgroundcolor'].";} \n" 
			." center, table {background:".$tmpl['detailwindowbackgroundcolor'].";} \n" 
			." #sbox-window {background-color:#fff;padding:5px} \n" 
			." </style> \n");
		
		$model	= &$this->getModel();
		$item	= $model->getData();
		$tmpl['imgtitle']	=	$item->title;
		
		// Back button
		$tmpl['backbutton'] = '';
		if ($tmpl['detailwindow'] == 7 || $tmpl['display_comment_nopup']) {
		
			// Display Image
			// Access check - don't display the image if you have no access to this image (if user add own url)
			// USER RIGHT - ACCESS - - - - - - - - - - 
			$rightDisplay	= 0;
			if (!empty($item)) {
				$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $item->cataccessuserid, $item->cataccess, $user->get('aid', 0), $user->get('id', 0), 0);
			}
		
			if ($rightDisplay == 0) {
				$tmpl['pl']		= 'index.php?option=com_user&view=login&return='.base64_encode($uri->toString());
				$mainframe->redirect(JRoute::_($tmpl['pl'], false), JText::_("ALERTNOTAUTH"));
				exit;
			}
			// - - - - - - - - - - - - - - - - - - - - 
		
			phocagalleryimport('phocagallery.image.image');
			$tmpl['backbutton'] = '<div><a href="'.JRoute::_('index.php?option=com_phocagallery&view=category&id='. $tmpl['catid'].'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')).'"'
				.' title="'.JText::_( 'Back to category' ).'">'
				. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-up-images.' . $tmpl['formaticon'], JText::_( 'Back to category' )).'</a></div>';
				
			// Get file thumbnail or No Image
			$item->filenameno		= $item->filename;
			$item->filename			= PhocaGalleryFile::getTitleFromFile($item->filename, 1);
			$item->filesize			= PhocaGalleryFile::getFileSize($item->filenameno);
			$altValue				= PhocaGalleryRenderFront::getAltValue($tmpl['altvalue'], $item->title, $item->description, $item->metadesc);
			$item->altvalue			= $altValue;
			$realImageSize			= '';
			if (isset($item->extid) && $item->extid != '') {
				$item->extl			=	$item->extl;
				$item->exto			=	$item->exto;
				$realImageSize 		= PhocaGalleryImage::getRealImageSize($item->extl, '', 1);
				$item->imagesize 	= PhocaGalleryImage::getImageSize($item->exto, 1, 1);
				if ($item->extw != '') {
					$extw 		= explode(',',$item->extw);
					$item->extw	= $extw[0];
				}
				$correctImageRes 		= PhocaGalleryPicasa::correctSizeWithRate($item->extw, $item->exth, $tmpl['picasa_correct_width_l'], $tmpl['picasa_correct_height_l']);
				$item->linkimage		= JHTML::_( 'image', $item->extl, $item->altvalue, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']));
				$item->realimagewidth 	= $correctImageRes['width'];
				$item->realimageheight	= $correctImageRes['height'];
				
			} else {
				$item->linkthumbnailpath	= PhocaGalleryImageFront::displayCategoryImageOrNoImage($item->filenameno, 'large');
				$item->linkimage			= JHTML::_( 'image.site', $item->linkthumbnailpath, '', '', '', $item->altvalue);
				$realImageSize 				= PhocaGalleryImage::getRealImageSize ($item->filenameno);
				$item->imagesize			= PhocaGalleryImage::getImageSize($item->filenameno, 1);
				if (isset($realImageSize['w']) && isset($realImageSize['h'])) {
					$item->realimagewidth		= $realImageSize['w'];
					$item->realimageheight		= $realImageSize['h'];
				} else {
					$item->realimagewidth	 	= $tmpl['largewidth'];
					$item->realimageheight		= $tmpl['largeheight'];
				}
			}
			
			$this->assignRef( 'item', $item );
		}
		
		// ACTION
		$tmpl['action']	= $uri->toString();
		$tmpl['action'] = str_replace ('&amp;', '&', $tmpl['action']);// in case mixed amp will be included in the link
		$tmpl['action'] = str_replace ('&', '&amp;', $tmpl['action']);
		
		// ASIGN
		$this->assignRef( 'tmpl', $tmpl );
		$this->assignRef( 'commentitem',$commentItem);
		parent::display($tpl);
	}
}
