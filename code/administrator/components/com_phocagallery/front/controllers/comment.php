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
phocagalleryimport('phocagallery.access.access');
phocagalleryimport('phocagallery.comment.comment');
phocagalleryimport('phocagallery.comment.commentimage');
class PhocaGalleryControllerComment extends PhocaGalleryController
{
	
	function display() {
		if ( ! JRequest::getCmd( 'view' ) ) {
			JRequest::setVar('view', 'comment' );
		}
		parent::display();
    }
	
	function comment() {
	
		JRequest::checkToken() or jexit( 'Invalid Token' );
		phocagalleryimport('phocagallery.comment.comment');
		phocagalleryimport('phocagallery.comment.commentimage');
		global $mainframe;
		$user 			=& JFactory::getUser();
		$view 			= JRequest::getVar( 'view', '', 'post', '', 0  );
		$catid 			= JRequest::getVar( 'catid', '', 'post', 'string', 0  );
		$id 			= JRequest::getVar( 'id', '', 'post', 'string', 0  );
		$post['title']	= JRequest::getVar( 'phocagallerycommentstitle', '', 'post', 'string', 0  );
		$post['comment']= JRequest::getVar( 'phocagallerycommentseditor', '', 'post', 'string', 0  );
		$Itemid			= JRequest::getVar( 'Itemid', 0, '', 'int');
		$limitStart		= JRequest::getVar( 'limitstart', 0, '', 'int');
		$tab			= JRequest::getVar( 'tab', 0, '', 'int' );

		
		$params					= &$mainframe->getParams();
		$detailWindow			= $params->get( 'detail_window', 0 );
		$maxCommentChar			= $params->get( 'max_comment_char', 1000 );
		$displayCommentNoPopup	= $params->get( 'display_comment_nopup', 0);
		// Maximum of character, they will be saved in database
		$post['comment']	= substr($post['comment'], 0, (int)$maxCommentChar);
		
		if ($detailWindow == 7 || $displayCommentNoPopup == 1) {
			$tmplCom = '';
		} else {
			$tmplCom = '&tmpl=component';
		}
		
		// Close Tags
		$post['comment'] = PhocaGalleryComment::closeTags($post['comment'], '[u]', '[/u]');
		$post['comment'] = PhocaGalleryComment::closeTags($post['comment'], '[i]', '[/i]');
		$post['comment'] = PhocaGalleryComment::closeTags($post['comment'], '[b]', '[/b]');
		
		
		
		$post['imgid'] 	= (int)$id;
		$post['userid']	= $user->id;
		
		$catidAlias 	= $catid;
		$imgidAlias 	= $id;
		if ($view != 'comment') {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}
		
		$model = $this->getModel('comment');
		
		$checkUserComment	= PhocaGalleryCommentImage::checkUserComment( $post['imgid'], $post['userid'] );
		
		// User has already submitted a comment
		if ($checkUserComment) {
			$msg = JText::_('You have already submitted comment');
		} else {
			// If javascript will not protect the empty form
			$msg 		= '';
			$emptyForm	= 0;
			if ($post['title'] == '') {
				$msg .= JText::_('Error Comment Phoca Gallery - Title') . ' ';
				$emtyForm = 1;
			}
			if ($post['comment'] == '') {
				$msg .= JText::_('Error Comment Phoca Gallery - Comment');
				$emtyForm = 1;
			}
			if ($emptyForm == 0) {
				if ($user->aid > 0 && $user->id > 0) {
					if(!$model->comment($post)) {
					$msg = JText::_('Error Comment Phoca Gallery');
					} else {
					$msg = JText::_('Phoca Gallery Comment Submitted');
					} 
				} else {
					$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login', false), JText::_("NOT AUTHORISED TO DO ACTION"));
					exit;
				}
			}
		}
		
		$this->setRedirect( JRoute::_('index.php?option=com_phocagallery&view=comment&catid='.$catidAlias.'&id='.$imgidAlias.$tmplCom.'&Itemid='. $Itemid, false), $msg );
	}
}
?>