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

class PhocaGalleryCpControllerPhocaGallerym extends PhocaGalleryCpController
{
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}

	function save()
	{
		$post			= JRequest::get('post');
		$cid			= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] 	= (int) $cid[0];
		

		$model = $this->getModel( 'phocagallerym' );

		if ($model->store($post)) {
			$msg = JText::_( 'Phoca Gallery Saved Multiple' );
		} else {
			$msg = JText::_( 'Error Saving Phoca gallery' );
		}
		
		// Check the table in so it can be edited.... we are done with it anyway
	//	$model->checkin();
		$link = 'index.php?option=com_phocagallery&view=phocagallerys';
		$this->setRedirect($link, $msg);
	}
	
	function edit()
	{
		JRequest::setVar( 'view', 'phocagallery' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );

		parent::display();

		// Checkin the Phoca gallery
		$model = $this->getModel( 'phocagallery' );
		$model->checkout();
	}
	
	function cancel()
	{
		// Checkin the Phoca Gallery
		$model = $this->getModel( 'phocagallery' );
		$model->checkin();

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerys' );
	}
}
?>
