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
jimport('joomla.application.component.controller');
jimport('joomla.client.helper');

class PhocaGalleryCpControllerPhocaGalleryt extends PhocaGalleryCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'themeinstall'  , 	'themeinstall' );	
		$this->registerTask( 'bgimagesmall'  , 	'bgimagesmall' );
		$this->registerTask( 'bgimagemedium'  , 	'bgimagemedium' );	
	}

	function themeinstall() {

		JRequest::checkToken() or die( 'Invalid Token' );
		$post	= JRequest::get('post');
		
		$theme = array();
		
		if (isset($post['theme_component'])) {
			$theme['component'] = 1;
		}
		if (isset($post['theme_categories'])) {
			$theme['categories'] = 1;
		}
		if (isset($post['theme_category'])) {
			$theme['category'] 	= 1;
		}
		
		if (!empty($theme)) {
		
			$ftp =& JClientHelper::setCredentialsFromRequest('ftp');
		
			
			$model	= &$this->getModel( 'phocagalleryt' );

			if ($model->install($theme)) {
				$cache = &JFactory::getCache('mod_menu');
				$cache->clean();
				$msg = JText::_('New Theme Installed');
			}
		} else {
			$msg = JText::_('Select Application Area');
		}
		
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryt', $msg );
	}

	function cancel() {
		$this->setRedirect( 'index.php?option=com_phocagallery' );
	}
	
	function bgimagesmall() {
		JRequest::checkToken() or die( 'Invalid Token' );
		$post				= JRequest::get('post');
		$data['image']	= 'shadow3';
		$data['iw']		= $post['siw'];
		$data['ih']		= $post['sih'];
		$data['sbgc']	= $post['ssbgc'];
		$data['ibgc']	= $post['sibgc'];
		$data['ibrdc']	= $post['sibrdc'];
		$data['iec']	= $post['siec'];
		$data['ie']		= $post['sie'];

		phocagalleryimport('phocagallery.image.imagebgimage');
		$errorMsg = '';		
		$bgImage = PhocaGalleryImageBgImage::createBgImage($data, $errorMsg);
	
		if ($bgImage) {
			$msg = JText::_('PHOCAGALLERY_BG_IMAGE_CHANGED');
		} else {
			$msg = JText::_('PHOCAGALLERY_BG_IMAGE_CHANGE_ERROR');
			if($errorMsg != '') {
				$msg .= '<br />' . $errorMsg;
			}
		}
		
		$linkSuffix = '&siw='.$post['siw'].'&sih='.$post['sih'].'&ssbgc='.str_replace('#','',$post['ssbgc']).'&sibgc='.str_replace('#','',$post['sibgc']).'&sibrdc='.str_replace('#','',$post['sibrdc']).'&sie='.$post['sie'].'&siec='.str_replace('#','',$post['siec']);
		
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryt'.$linkSuffix , $msg );
	}
	
	function bgimagemedium() {
		JRequest::checkToken() or die( 'Invalid Token' );
		$post				= JRequest::get('post');
		$data['image']	= 'shadow1';
		$data['iw']		= $post['miw'];
		$data['ih']		= $post['mih'];
		$data['sbgc']	= $post['msbgc'];
		$data['ibgc']	= $post['mibgc'];
		$data['ibrdc']	= $post['mibrdc'];
		$data['iec']	= $post['miec'];
		$data['ie']		= $post['mie'];

		phocagalleryimport('phocagallery.image.imagebgimage');
		$errorMsg = '';		
		$bgImage = PhocaGalleryImageBgImage::createBgImage($data, $errorMsg);
	
		if ($bgImage) {
			$msg = JText::_('PHOCAGALLERY_BG_IMAGE_CHANGED');
		} else {
			$msg = JText::_('PHOCAGALLERY_BG_IMAGE_CHANGE_ERROR');
			if($errorMsg != '') {
				$msg .= '<br />' . $errorMsg;
			}
		}
		
		$linkSuffix = '&miw='.$post['miw'].'&mih='.$post['mih'].'&msbgc='.str_replace('#','',$post['msbgc']).'&mibgc='.str_replace('#','',$post['mibgc']).'&mibrdc='.str_replace('#','',$post['mibrdc']).'&mie='.$post['mie'].'&miec='.str_replace('#','',$post['miec']);
		
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryt'.$linkSuffix , $msg );
	}
}
?>
