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

class PhocaGalleryCpControllerPhocaGallery extends PhocaGalleryCpController
{
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply'  , 'save' );
		$this->registerTask( 'thumbs'  , 'thumbs' );
		$this->registerTask( 'multiple'  , 'multiple' );
		$this->registerTask( 'install'  , 'install' );
		$this->registerTask( 'upgrade'  , 'upgrade' );
		$this->registerTask( 'disablethumbs' , 'disablethumbs');
		$this->registerTask( 'rotate'  , 	'rotate' );
		$this->registerTask( 'deletethumbs'  , 	'deletethumbs' );
		$this->registerTask( 'recreate'  , 	'recreate' );
		$this->registerTask( 'approve', 'approve');
		$this->registerTask( 'disapprove', 'disapprove');
		
		
	}
	
	function deletethumbs()
	{
		$cid	= JRequest::getVar( 'cid', array(0), 'get', 'array' );
		
		$model	= &$this->getModel( 'phocagallery' );
		if ($model->deletethumbs($cid[0])) {
			$msg = JText::_( 'Phoca Gallery Image Thumbnail Deleted' );
		} else {
			$msg = JText::_( 'Error Deleting Phoca Gallery Image Thumbnail' );
		}
		
		
		$link = 'index.php?option=com_phocagallery&view=phocagallerys';
		$this->setRedirect($link, $msg);
	}
	
	function rotate() {
		$cid	= JRequest::getVar( 'cid', array(0), 'get', 'array' );
		$angle	= JRequest::getVar( 'angle', 90, 'get', 'int' );
		$model	= &$this->getModel( 'phocagallery' );
		
		$errorMsg 		= '';
		$rotateReturn 	= $model->rotate($cid[0], $angle, $errorMsg);
		
		if (!$rotateReturn) {
			$msg = JText::_( 'Error Rotating Phoca Gallery Image' ) . ': ' . $errorMsg;
		} else {
			$msg = JText::_( 'Phoca Gallery Image Rotated' );
		}
		
		$link = 'index.php?option=com_phocagallery&view=phocagallerys';
		$this->setRedirect($link, $msg);
	}

	
	/*
	 *if thumbnails are created - show message after creating thumbnails - show that files was saved in database
	 */
	function thumbs() {
		$msg = JText::_( 'Phoca gallery Saved Multiple' );
		$link = 'index.php?option=com_phocagallery&view=phocagallerys';
		$this->setRedirect($link, $msg);
	}
	
	function disablethumbs() {
		
		$model	= &$this->getModel( 'phocagallery' );
		if ($model->disableThumbs()) {
			$msg = JText::_('Phoca Gallery Disabled Thumbs Succes');
		} else {
			$msg = JText::_('Phoca Gallery Disabled Thumbs Error');
		}
		$link = 'index.php?option=com_phocagallery&view=phocagallerys';
		$this->setRedirect($link, $msg);
	}
	
	
	function multiple() {
		JRequest::setVar( 'view', 'phocagallerym' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );
		parent::display();
	}
		
	function edit() {
		JRequest::setVar( 'view', 'phocagallery' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );
		parent::display();
		// Checkin the Phoca gallery
		$model = $this->getModel( 'phocagallery' );
		$model->checkout();
	}

	function save() {
		$post					= JRequest::get('post');
		$cid					= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] 			= (int) $cid[0];
		$post['description']	= JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post['videocode']		= JRequest::getVar( 'videocode', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$extlink1				= JRequest::getVar( 'extlink1', '', 'post', 'string' );
		$extlinkname1			= JRequest::getVar( 'extlinkname1', '', 'post', 'string' );
		$targetlist1			= JRequest::getVar( 'targetlist1', '_self', 'post', 'string' );
		$displaylist1			= JRequest::getVar( 'displaylist1', 1, 'post', 'int' );
		$extlink2				= JRequest::getVar( 'extlink2', '', 'post', 'string' );
		$extlinkname2			= JRequest::getVar( 'extlinkname2', '', 'post', 'string' );
		$targetlist2			= JRequest::getVar( 'targetlist2', '_self', 'post', 'string' );
		$displaylist2			= JRequest::getVar( 'displaylist2', 1, 'post', 'int' );
	
		if ($extlink1 != '') {
			$extlink1			= str_replace('http://','', $extlink1);
			$post['extlink1'] 	= $extlink1 . '|'.$extlinkname1.'|'.$targetlist1.'|'.$displaylist1;
		}
		if ($extlink2 != '') {
			$extlink2			= str_replace('http://','', $extlink2);
			$post['extlink2'] 	= $extlink2 . '|'.$extlinkname2.'|'.$targetlist2.'|'.$displaylist2;
		}
	
		$model = $this->getModel( 'phocagallery' );
		
		$errorMsg = '';
		switch ( JRequest::getCmd('task') ) {
			case 'apply':
				$id	= $model->store($post, $errorMsg);//you get id and you store the table data
				if ($id && $id > 0) {
					$msg = JText::_( 'Changes to Phoca Gallery Saved' );
				} else {
					$msg = JText::_( 'Error Saving Phoca gallery' );
					$id		= $post['id'];
				}
				if ($errorMsg != '') {
					$msg .= '<br />'. $errorMsg;
				}
				
				$this->setRedirect( 'index.php?option=com_phocagallery&controller=phocagallery&task=edit&cid[]='. $id, $msg );
				break;

			case 'save':
			default:
				$id	= $model->store($post, $errorMsg);//you get id and you store the table data
				if ($id && $id > 0) {
					$msg = JText::_( 'Phoca Gallery Saved' );
				} else {
					$msg = JText::_( 'Phoca gallery Saved' );
				}
				if ($errorMsg != '') {
					$msg .= '<br />'. $errorMsg;
				}
				$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys', $msg );
				break;
		}
		$model->checkin();
	}

	function remove() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel( 'phocagallery' );
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			$msg = JText::_( 'Error Deleting Phoca gallery' );
		}
		else {
			$msg = JText::_( 'Phoca gallery Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys', $msg );
	}
	
	function recreate() {
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to recreate' ) );
		}

		$model = $this->getModel( 'phocagallery' );
		if(!$model->recreate($cid)) {
			$msg = JText::_( 'PHOCAGALLERY_THUMB_RECREATE_ERROR' );
		} else {
			$msg = JText::_( 'PHOCAGALLERY_THUMB_RECREATED' );
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys', $msg );
	}

	function publish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('phocagallery');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys' );
	}

	function unpublish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('phocagallery');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys' );
	}
	
	function approve() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to approve' ) );
		}

		$model = $this->getModel('phocagallery');
		if(!$model->approve($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys' );
	}

	function disapprove() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to disapprove' ) );
		}

		$model = $this->getModel('phocagallery');
		if(!$model->approve($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys' );
	}

	function cancel() {
		$model = $this->getModel( 'phocagallery' );
		$model->checkin();
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys' );
	}

	function orderup() {
		$model = $this->getModel( 'phocagallery' );
		$model->move(-1);
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys' );
	}

	function orderdown() {
		$model = $this->getModel( 'phocagallery' );
		$model->move(1);
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys' );
	}

	function saveorder() {
		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel( 'phocagallery' );
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys', $msg );
	}
}
?>
