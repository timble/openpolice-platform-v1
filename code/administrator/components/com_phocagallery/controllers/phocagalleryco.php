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

class PhocaGalleryCpControllerPhocaGalleryCo extends PhocaGalleryCpController
{
	function __construct() {
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}
		
	function edit() {
		JRequest::setVar( 'view', 'phocagalleryco' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );

		parent::display();

		// Checkin the Phoca gallery
		$model = $this->getModel( 'phocagalleryco' );
		$model->checkout();
	}
	

	function save() {
		
		$post					= JRequest::get('post');
		$cid					= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] 			= (int) $cid[0];
		
		$post['comment']		= JRequest::getVar( 'comment', '', 'post', 'string', JREQUEST_ALLOWRAW );
		

		$model = $this->getModel( 'phocagalleryco' );

		if ($model->store($post)) {
			$msg = JText::_( 'Phoca Gallery Comment Saved' );
		} else {
			$msg = JText::_( 'Error Saving Phoca Gallery Comment' );
		}

		$model->checkin();
		$link = 'index.php?option=com_phocagallery&view=phocagallerycos';
		$this->setRedirect($link, $msg);
	}

	function remove() {
		
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel( 'phocagalleryco' );
		if(!$model->delete($cid)) {
			$msg = JText::_( 'Error Deleting Phoca Gallery Comment' );
		} else {
			$msg = JText::_( 'Phoca Gallery Comment Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycos', $msg );
	}

	function publish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('phocagalleryco');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycos' );
	}

	function unpublish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('phocagalleryco');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycos' );
	}

	function cancel() {
		$model = $this->getModel( 'phocagalleryco' );
		$model->checkin();

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycos' );
	}

	function orderup() {
		$model = $this->getModel( 'phocagalleryco' );
		$model->move(-1);

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycos' );
	}

	function orderdown() {
		$model = $this->getModel( 'phocagalleryco' );
		$model->move(1);

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycos' );
	}

	function saveorder() {
		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel( 'phocagalleryco' );
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycos', $msg );
	}
}
?>
