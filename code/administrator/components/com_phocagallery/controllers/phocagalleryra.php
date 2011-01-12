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

class PhocaGalleryCpControllerPhocaGalleryRa extends PhocaGalleryCpController
{
	function __construct() {
		parent::__construct();
	}
	
	

	function remove() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel( 'phocagalleryra' );
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			$msg = JText::_( 'Error Deleting Phoca Gallery Rating' );
		}
		else {
			$msg = JText::_( 'Phoca Gallery Rating Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryra', $msg );
	}


	function cancel()
	{
		$model = $this->getModel( 'phocagallery' );
		$model->checkin();

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys' );
	}

}
?>
