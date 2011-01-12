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
jimport( 'joomla.application.component.view' );
 
class phocaGalleryCpViewphocaGalleryLinks extends JView
{
	function display($tpl = null) {
		global $mainframe;
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		
		$eName	= JRequest::getVar('e_name');
		$eName	= preg_replace( '#[^A-Z0-9\-\_\[\]]#i', '', $eName );
		
		$tmpl['categories']		= 'index.php?option=com_phocagallery&amp;view=phocagallerylinkcats&amp;tmpl=component&amp;e_name='.$eName;
		//$tmpl['category']		= 'index.php?option=com_phocagallery&amp;view=phocagallerylinkcat&amp;tmpl=component&amp;e_name='.$eName;
		$tmpl['images']			= 'index.php?option=com_phocagallery&amp;view=phocagallerylinkimg&amp;type=2&amp;tmpl=component&amp;e_name='.$eName;
		$tmpl['image']			= 'index.php?option=com_phocagallery&amp;view=phocagallerylinkimg&amp;type=1&amp;tmpl=component&amp;e_name='.$eName;
		$tmpl['switchimage']	= 'index.php?option=com_phocagallery&amp;view=phocagallerylinkimg&amp;type=3&amp;tmpl=component&amp;e_name='.$eName;
		$tmpl['slideshow']		= 'index.php?option=com_phocagallery&amp;view=phocagallerylinkimg&amp;type=4&amp;tmpl=component&amp;e_name='.$eName;
		
		$this->assignRef('tmpl',	$tmpl);
		parent::display($tpl);
	}
}
?>