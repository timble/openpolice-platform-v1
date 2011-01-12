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
jimport('joomla.html.pane');
phocagalleryimport('phocagallery.render.renderinfo');

class PhocaGalleryCpViewPhocaGallerycp extends JView
{
	function display($tpl = null) {
		
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		
		global $mainframe;
		$uri		=& JFactory::getURI();
		$document	=& JFactory::getDocument();
		$db		    =& JFactory::getDBO();

		JHTML::_('behavior.tooltip');
		$version = PhocaGalleryRenderInfo::getPhocaVersion();
		$this->assignRef('version',	$version);
		
		parent::display($tpl);
		$this->_setToolbar();
	}
	
	function _setToolbar() {
		JToolBarHelper::title( JText::_( 'Phoca Gallery Control Panel' ), 'phoca' );
		JToolBarHelper::preferences('com_phocagallery', '460');
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
}
?>