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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class PhocaGalleryCpControllerPhocaGalleryUser extends PhocaGalleryCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'approve', 'approve');
		$this->registerTask( 'disapprove', 'disapprove');
		$this->registerTask( 'approveall', 'approveall');		
	}
	
	
	function remove() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel( 'phocagalleryuser' );
		if(!$model->delete($cid)) {
			$msg = JText::_( 'PHOCAGALLERY_DELETE_AVATAR_ERROR' );
		} else {
			$msg = JText::_( 'PHOCAGALLERY_AVATAR_DELETED' );
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryusers', $msg );
	}
	
	
	function publish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('phocagalleryuser');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryusers' );
	}

	function unpublish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('phocagalleryuser');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryusers' );
	}
	
	function approve() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to approve' ) );
		}

		$model = $this->getModel('phocagalleryuser');
		if(!$model->approve($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryusers' );
	}
	
	function approveall() {

		$model = $this->getModel('phocagalleryuser');
		if(!$model->approveall()) {
			$msg = JText::_( 'PHOCAGALLERY_APPROVE_ALL_ERROR' );
		} else {
			$msg = JText::_( 'PHOCAGALLERY_ALL_APPROVED' );
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryusers' , $msg);
	}

	function disapprove() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to disapprove' ) );
		}

		$model = $this->getModel('phocagalleryuser');
		if(!$model->approve($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryusers' );
	}


	function orderup() {
		$model = $this->getModel( 'phocagalleryuser' );
		$model->move(-1);
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryusers' );
	}

	function orderdown() {
		$model = $this->getModel( 'phocagalleryuser' );
		$model->move(1);
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryusers' );
	}

	function saveorder() {
		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel( 'phocagalleryuser' );
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryusers', $msg );
	}
}
?>
