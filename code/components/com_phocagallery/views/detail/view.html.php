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
phocagalleryimport( 'phocagallery.image.image');
phocagalleryimport( 'phocagallery.image.imagefront');
phocagalleryimport( 'phocagallery.file.filethumbnail');
phocagalleryimport( 'phocagallery.rate.rateimage');
phocagalleryimport( 'phocagallery.picasa.picasa');

class PhocaGalleryViewDetail extends JView
{
	function display($tpl = null) {

		global $mainframe;
		$document			= &JFactory::getDocument();
		$params				= &$mainframe->getParams();
		$user				= &JFactory::getUser();
		$var['slideshow']	= JRequest::getVar('phocaslideshow', 0, '', 'int');
		$var['download'] 	= JRequest::getVar('phocadownload', 0, '', 'int');
		$uri 				= &JFactory::getURI();
		$tmpl['action']		= $uri->toString();
		$tmpl['action'] = str_replace ('&amp;', '&', $tmpl['action']);// in case mixed amp will be included in the link
		$tmpl['action'] = str_replace ('&', '&amp;', $tmpl['action']);


		// Information from the plugin - window is displayed after plugin action
		$get				= array();
		$get['detail']		= JRequest::getVar( 'detail', '', 'get', 'string');
		$get['buttons']		= JRequest::getVar( 'buttons', '', 'get', 'string' );
		$get['ratingimg']	= JRequest::getVar( 'ratingimg', '', 'get', 'string' );

		$tmpl['picasa_correct_width_l']		= (int)$params->get( 'large_image_width', 640 );
		$tmpl['picasa_correct_height_l']	= (int)$params->get( 'large_image_height', 480 );

		$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/phocagallery.css');

		// Plugin information
		$tmpl['detailwindow']	= $params->get( 'detail_window', 0 );
		if (isset($get['detail']) && $get['detail'] != '') {
			$tmpl['detailwindow'] 		= $get['detail'];
		}

		// Plugin information
		$tmpl['detailbuttons']	= $params->get( 'detail_buttons', 1 );
		if (isset($get['buttons']) && $get['buttons'] != '') {
			$tmpl['detailbuttons'] = $get['buttons'];
		}

		// Standard popup window
		if ($tmpl['detailwindow'] == 1) {
			$tmpl['detailwindowclose']	= 'window.close();';
			$tmpl['detailwindowreload']	= 'window.location.reload(true);';
		// Highslide
		} else if ($tmpl['detailwindow'] == 4 || $tmpl['detailwindow'] == 5) {
			$tmpl['detailwindowclose']	= 'return false;';
			$tmpl['detailwindowreload']	= 'window.location.reload(true);';
		// No Popup
		} else if ($tmpl['detailwindow'] == 7) {
			$tmpl['detailwindowclose']	= '';
			$tmpl['detailwindowreload']	= '';
		// Modal Box
		} else {
			$tmpl['detailwindowclose']	= 'window.parent.document.getElementById(\'sbox-window\').close();';
			$tmpl['detailwindowreload']	= 'window.location.reload(true);';
		}
		$tmpl['externalcommentsystem'] 			= $params->get( 'external_comment_system', 0 );
		$tmpl['displaydescriptiondetail']		= $params->get( 'display_description_detail', 0 );
		$tmpl['displaytitleindescription']		= $params->get( 'display_title_description', 0 );
		$tmpl['descriptiondetailheight']		= $params->get( 'description_detail_height', 16 );
		$tmpl['fontsizedesc'] 					= $params->get( 'font_size_desc', 11 );
		$tmpl['fontcolordesc'] 					= $params->get( 'font_color_desc', '#333333' );
		$tmpl['fontb'] 							= PhocaGalleryRenderInfo::getPhocaIc((int)$params->get( 'display_phoca_info', 1 ));
		$tmpl['detailwindowbackgroundcolor']	= $params->get( 'detail_window_background_color', '#ffffff' );
		$tmpl['descriptionlightboxfontcolor']	= $params->get( 'description_lightbox_font_color', '#ffffff' );
		$tmpl['descriptionlightboxbgcolor']		= $params->get( 'description_lightbox_bg_color', '#000000' );
		$tmpl['descriptionlightboxfontsize']	= $params->get( 'description_lightbox_font_size', 12 );
		$tmpl['displayratingimg']				= $params->get( 'display_rating_img', 0 );
		$tmpl['displayicondownload'] 			= $params->get( 'display_icon_download', 0 );
		$tmpl['externalcommentsystem'] 			= $params->get( 'external_comment_system', 0 );
		$tmpl['emt'] 							= PhocaGalleryRenderFront::getString();
		$tmpl['largewidth'] 					= $params->get( 'large_image_width', 640 );
		$tmpl['largeheight'] 					= $params->get( 'large_image_height', 480 );
		$tmpl['boxlargewidth'] 					= $params->get( 'front_modal_box_width', 680 );
		$tmpl['boxlargeheight'] 				= $params->get( 'front_modal_box_height', 560 );
		$tmpl['slideshowdelay'] 				= $params->get( 'slideshow_delay', 3000 );
		$tmpl['slideshowpause'] 				= $params->get( 'slideshow_pause', 0 );
		$tmpl['slideshowrandom'] 				= $params->get( 'slideshow_random', 0 );
		$tmpl['gallerymetakey'] 				= $params->get( 'gallery_metakey', '' );
		$tmpl['gallerymetadesc'] 				= $params->get( 'gallery_metadesc', '' );
		$tmpl['altvalue']		 				= $params->get( 'alt_value', 1 );
		// Download from the detail view which is not in the popupbox
		if ($var['download'] == 2 ){
			$tmpl['displayicondownload'] = 2;
		}

		// Plugin Information
		if (isset($get['ratingimg']) && $get['ratingimg'] != '') {
			$tmpl['displayratingimg'] = $get['ratingimg'];
		}

		// No Scrollbar in Detail View
		if ($tmpl['detailwindow'] == 7) {

		} else {
			$document->addCustomTag( "<style type=\"text/css\"> \n"
				." html,body, .contentpane{overflow:hidden;background:".$tmpl['detailwindowbackgroundcolor'].";} \n"
				." center, table {background:".$tmpl['detailwindowbackgroundcolor'].";} \n"
				." #sbox-window {background-color:#fff;padding:5px} \n"
				." </style> \n");
		}


		// Model
		$model	= &$this->getModel();
		$item	= $model->getData();

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
		phocagalleryimport('phocagallery.render.renderdetailbutton'); // Javascript Slideshow buttons
		$detailButton 			= new PhocaGalleryRenderDetailButton();
		$item->reloadbutton		= $detailButton->getReload($item->catslug, $item->slug);
		$item->closebutton		= $detailButton->getClose($item->catslug, $item->slug);
		$item->closetext		= $detailButton->getCloseText($item->catslug, $item->slug);
		$item->nextbutton		= $detailButton->getNext((int)$item->catid, (int)$item->id, (int)$item->ordering);
		$item->prevbutton		= $detailButton->getPrevious((int)$item->catid, (int)$item->id, (int)$item->ordering);
		$slideshowData			= $detailButton->getJsSlideshow((int)$item->catid, (int)$item->id, (int)$var['slideshow'], $item->catslug, $item->slug);
		$item->slideshowbutton	= $slideshowData['icons'];
		$item->slideshowfiles	= $slideshowData['files'];
		$item->slideshow		= $var['slideshow'];
		$item->download			= $var['download'];

		// ALT VALUE
		$altValue	= PhocaGalleryRenderFront::getAltValue($tmpl['altvalue'], $item->title, $item->description, $item->metadesc);
		$item->altvalue			= $altValue;

		// Get file thumbnail or No Image
		$item->filenameno		= $item->filename;
		$item->filename			= PhocaGalleryFile::getTitleFromFile($item->filename, 1);
		$item->filesize			= PhocaGalleryFile::getFileSize($item->filenameno);
		$realImageSize	= '';
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

		// Add Statistics
		$model->hit(JRequest::getVar( 'id', '', '', 'int' ));

		// R A T I N G
		// Only registered (VOTES + COMMENTS)
		$tmpl['notregisteredimg'] 	= true;
		$tmpl['usernameimg']		= '';
		if ($user->aid > 0) {
			$tmpl['notregisteredimg'] 	= false;
			$tmpl['usernameimg']		= $user->name;
		}

		// VOTES Statistics Img
		if ((int)$tmpl['displayratingimg'] == 1) {
			$tmpl['votescountimg']		= 0;
			$tmpl['votesaverageimg'] 	= 0;
			$tmpl['voteswidthimg']		= 0;
			$votesStatistics	= PhocaGalleryRateImage::getVotesStatistics((int)$item->id);
			if (!empty($votesStatistics->count)) {
				$tmpl['votescountimg'] = $votesStatistics->count;
			}
			if (!empty($votesStatistics->average)) {
				$tmpl['votesaverageimg'] = $votesStatistics->average;
				if ($tmpl['votesaverageimg'] > 0) {
					$tmpl['votesaverageimg'] 	= round(((float)$tmpl['votesaverageimg'] / 0.5)) * 0.5;
					$tmpl['voteswidthimg']		= 22 * $tmpl['votesaverageimg'];
				} else {
					$tmpl['votesaverageimg'] = (int)0;// not float displaying
				}
			}
			if ((int)$tmpl['votescountimg'] > 1) {
				$tmpl['votestextimg'] = 'votes';
			} else {
				$tmpl['votestextimg'] = 'vote';
			}

			// Already rated?
			$tmpl['alreadyratedimg']	= PhocaGalleryRateImage::checkUserVote( (int)$item->id, (int)$user->id );
		}

		// Back button
		$tmpl['backbutton'] = '';
		if ($tmpl['detailwindow'] == 7) {
			phocagalleryimport('phocagallery.image.image');
			$formatIcon = &PhocaGalleryImage::getFormatIcon();
			$tmpl['backbutton'] = '<div><a href="'.JRoute::_('index.php?option=com_phocagallery&view=category&id='. $item->catslug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')).'"'
				.' title="'.JText::_( 'Back to category' ).'">'
				. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-up-images.' . $formatIcon, JText::_( 'Back to category' )).'</a></div>';

		}

		// Meta data
		if ($item->metakey != '') {
			$mainframe->addMetaTag('keywords', $item->metakey);
		} else if ($tmpl['gallerymetakey'] != '') {
			$mainframe->addMetaTag('keywords', $tmpl['gallerymetakey']);
		}
		if ($item->metadesc != '') {
			$mainframe->addMetaTag('description', $item->metadesc);
		} else if ($tmpl['gallerymetadesc'] != '') {
			$mainframe->addMetaTag('description', $tmpl['gallerymetadesc']);
		}

		// ASIGN
		$this->assignRef( 'tmpl', $tmpl );
		$this->assignRef( 'item', $item );

		if (isset($item->videocode) && $item->videocode != '') {
			parent::display('video');
		} else {
			parent::display('slideshowjs');
			if ($item->slideshow == 1) {
				parent::display('slideshow');
			} else if ($item->download > 0) {

				if ($tmpl['displayicondownload'] == 2) {
					$backLink = 'index.php?option=com_phocagallery&view=category&id='. $item->catslug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int');
					phocagalleryimport('phocagallery.file.filedownload');
					if (isset($item->exto) && $item->exto != '') {
						PhocaGalleryFileDownload::download($item, $backLink, 1);
					} else {
						PhocaGalleryFileDownload::download($item, $backLink);
					}
					exit;
				} else {
					parent::display('download');
				}
			} else {
				parent::display($tpl);
			}
		}
	}
}
