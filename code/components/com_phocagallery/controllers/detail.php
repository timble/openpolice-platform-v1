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
phocagalleryimport('phocagallery.access.access');
phocagalleryimport('phocagallery.rate.rateimage');
class PhocaGalleryControllerDetail extends PhocaGalleryController
{
	
	function display() {
		if ( ! JRequest::getCmd( 'view' ) ) {
			JRequest::setVar('view', 'detail' );
		}
		parent::display();
    }

	function rate() {
		global $mainframe;
		$params			= &$mainframe->getParams();
		$detailWindow	= $params->get( 'detail_window', 0 );
		
		$user 		=& JFactory::getUser();
		$view 		= JRequest::getVar( 'view', '', 'get', '', JREQUEST_NOTRIM  );
		//$id 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$imgid 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$catid 		= JRequest::getVar( 'catid', '', 'get', 'string', JREQUEST_NOTRIM  );
		$rating		= JRequest::getVar( 'rating', '', 'get', 'string', JREQUEST_NOTRIM  );
		$Itemid		= JRequest::getVar( 'Itemid', 0, '', 'int');
	
		if ($detailWindow == 7) {
			$tmplCom = '';
		} else {
			$tmplCom = '&tmpl=component';
		}
		
		$post['imgid'] 		= (int)$imgid;
		$post['userid']		= $user->id;
		$post['rating']		= (int)$rating;

		$imgIdAlias 	= $imgid;
		$catIdAlias 	= $catid;		//Itemid
		if ($view != 'detail') {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}
		
		$model = $this->getModel('detail');
		
		$checkUserVote	= PhocaGalleryRateImage::checkUserVote( $post['imgid'], $post['userid'] );
		
		// User has already rated this category
		if ($checkUserVote) {
			$msg = JText::_('You have already rated this image');
		} else {
			if ($post['rating']  < 1 && $post['rating'] > 5) {
				$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false)  );
			}
			
			if ($user->aid > 0 && $user->id > 0) {
				if(!$model->rate($post)) {
				$msg = JText::_('Error Rating Phoca Gallery Image');
				} else {
				$msg = JText::_('Phoca Gallery Image Rated');
				} 
			} else {
				$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login', false), JText::_("NOT AUTHORISED TO DO ACTION"));
				exit;
			}
		}
		// Do not display System Message in Detail Window as there are no scrollbars, so other items will be not displayed
		// we send infor about already rated via get and this get will be worked in view (detail - default.php) - vote=1
		$msg = '';
		
		$this->setRedirect( JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$catIdAlias.'&id='.$imgIdAlias.$tmplCom.'&vote=1&Itemid='. $Itemid, false), $msg );
	}
}
?>