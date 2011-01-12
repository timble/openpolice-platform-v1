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

class PhocaGalleryCpControllerPhocaGalleryCoImg extends PhocaGalleryCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'add'  , 	'edit' );
	}
		
	function edit() {
		JRequest::setVar( 'view', 'phocagallerycoimg' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );

		parent::display();
		$model = $this->getModel( 'phocagallerycoimg' );
		$model->checkout();
	}
	
	function save() {
		$post					= JRequest::get('post');
		$cid					= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] 			= (int) $cid[0];
		$post['comment']		= JRequest::getVar( 'comment', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		$model = $this->getModel( 'phocagallerycoimg' );

		if ($model->store($post)) {
			$msg = JText::_( 'PHOCAGALLERY_COMMENT_SAVED' );
		} else {
			$msg = JText::_( 'PHOCAGALLERY_COMMENT_SAVE_ERROR' );
		}

		$model->checkin();
		$link = 'index.php?option=com_phocagallery&view=phocagallerycoimgs';
		$this->setRedirect($link, $msg);
	}

	function remove() {
		
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel( 'phocagallerycoimg' );
		if(!$model->delete($cid)) {
			$msg = JText::_( 'PHOCAGALLERY_COMMENT_DELETE_ERROR' );
		} else {
			$msg = JText::_( 'PHOCAGALLERY_COMMENT_DELETED' );
		}
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycoimgs', $msg );
	}

	function publish() {

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('phocagallerycoimg');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycoimgs' );
	}

	function unpublish() {

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('phocagallerycoimg');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycoimgs' );
	}

	function cancel() {

		$model = $this->getModel( 'phocagallerycoimg' );
		$model->checkin();
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycoimgs' );
	}

	function orderup() {
		$model = $this->getModel( 'phocagallerycoimg' );
		$model->move(-1);
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycoimgs' );
	}

	function orderdown() {
		$model = $this->getModel( 'phocagallerycoimg' );
		$model->move(1);
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycoimgs' );
	}

	function saveorder() {
		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel( 'phocagallerycoimg' );
		$model->saveorder($cid, $order);
		$msg = JText::_( 'New ordering saved' );
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycoimgs', $msg );
	}
}
?>
