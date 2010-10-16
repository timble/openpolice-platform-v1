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
jimport( 'joomla.application.component.view' );
phocagalleryimport('phocagallery.render.renderinfo');
phocagalleryimport('phocagallery.utils.utils');

class PhocaGalleryCpViewPhocaGalleryIn extends JView
{
	function display($tpl = null) {
		global $mainframe;
		$tmpl		= array();
		$params 	= JComponentHelper::getParams('com_phocagallery');
		
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		
		$tmpl['version'] 					= PhocaGalleryRenderInfo::getPhocaVersion();
		$tmpl['enablethumbcreation']		= $params->get('enable_thumb_creation', 1 );
		$tmpl['paginationthumbnailcreation']= $params->get('pagination_thumbnail_creation', 0 );
		$tmpl['cleanthumbnails']			= $params->get('clean_thumbnails', 0 );
		$tmpl['enablethumbcreationstatus'] 	= PhocaGalleryRenderAdmin::renderThumbnailCreationStatus((int)$tmpl['enablethumbcreation'], 1);
		
		//Main Function support
		
	//	echo '<table border="1" cellpadding="5" cellspacing="5" style="border:1px solid #ccc;border-collapse:collapse">';
		
		$function = array('getImageSize','imageCreateFromJPEG', 'imageCreateFromPNG', 'imageCreateFromGIF', 'imageRotate', 'imageCreateTruecolor', 'imageCopyResampled', 'imageFill', 'imageColorTransparent', 'imageColorAllocate', 'exif_read_data');
		$fOutput = '';
		foreach ($function as $key => $value) {
			
			if (function_exists($value)) {
				$bgStyle 	= 'style="background:#ccffcc"';
				$icon		= 'true';
				$iconText	= JText::_('Enabled');
			} else {
				$bgStyle = 'style="background:#ffcccc"';
				$icon		= 'false';
				$iconText	= JText::_('Disabled');
			}
			
			$fOutput .= '<tr '.$bgStyle.'><td>'.JText::_('Function') .' '. $value.'</td>';
			$fOutput .=  '<td align="center">'.JHTML::_('image.site',  'icon-16-true.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_('Enabled') ).'</td>';
			$fOutput .=  '<td align="center">'. JHTML::_('image.site',  'icon-16-'.$icon.'.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_($iconText)).'</td></tr>';
			
		}
		
		// PICASA
		$fOutput .= '<tr><td align="left"><b>'. JText::_('PHOCAGALLERY_PICASA_SUPPORT').'</b></td></tr>';
		
		if(!PhocaGalleryUtils::iniGetBool('allow_url_fopen')){
			$bgStyle = 'style="background:#ffcccc"';
			$icon		= 'false';
			$iconText	= JText::_('Disabled');
		} else {
			$bgStyle 	= 'style="background:#ccffcc"';
			$icon		= 'true';
			$iconText	= JText::_('Enabled');
		}
		
		$fOutput .= '<tr '.$bgStyle.'><td>'.JText::_('PHOCAGALLERY_PHP_SETTINGS_PARAM') .' allow_url_fopen ('.JText::_('Needs not to be enabled if cURL functions are enabled') .')</td>';
		$fOutput .=  '<td align="center">'.JHTML::_('image.site',  'icon-16-true.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_('Enabled') ).'</td>';
		$fOutput .=  '<td align="center">'. JHTML::_('image.site',  'icon-16-'.$icon.'.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_($iconText)).'</td></tr>';
	
	
		if(function_exists("curl_init")){
			$bgStyle 	= 'style="background:#ccffcc"';
			$icon		= 'true';
			$iconText	= JText::_('Enabled');
		} else {
			$bgStyle = 'style="background:#ffcccc"';
			$icon		= 'false';
			$iconText	= JText::_('Disabled');
		}

		$fOutput .= '<tr '.$bgStyle.'><td>'.JText::_('Function') .' cURL ('.JText::_('Needs not to be enabled if allow_url_fopen is enabled') .')</td>';
		$fOutput .=  '<td align="center">'.JHTML::_('image.site',  'icon-16-true.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_('Enabled') ).'</td>';
		$fOutput .=  '<td align="center">'. JHTML::_('image.site',  'icon-16-'.$icon.'.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_($iconText)).'</td></tr>';
		
		$fOutput .= '<tr '.$bgStyle.'><td>'.JText::_('Function') .' json_decode</td>';
		$fOutput .=  '<td align="center">'.JHTML::_('image.site',  'icon-16-true.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_('Enabled') ).'</td>';
		$fOutput .=  '<td align="center">'. JHTML::_('image.site',  'icon-16-'.$icon.'.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_($iconText)).'</td></tr>';
		

		$this->assignRef('tmpl',	$tmpl);
		$this->assignRef('foutput',	$fOutput);
		
		parent::display($tpl);
		$this->_setToolbar();
	}
	
	function _setToolbar() {
		JToolBarHelper::title( JText::_( 'Phoca Gallery Info' ), 'info' );
		JToolBarHelper::cancel( 'cancel', 'Close' );
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
}
?>
