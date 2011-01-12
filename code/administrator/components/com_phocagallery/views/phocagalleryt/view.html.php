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
jimport( 'joomla.application.component.view' );
jimport('joomla.client.helper');
phocagalleryimport('phocagallery.image.image');
class PhocaGalleryCpViewPhocaGalleryT extends JView
{

	function display($tpl = null) {
		global $mainframe;
		$document			= &JFactory::getDocument();
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		// Color Picker
		JHTML::stylesheet( 'picker.css', 'administrator/components/com_phocagallery/assets/jcp/' );
		$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jcp/picker.js');
		
		$ftp	=& JClientHelper::setCredentialsFromRequest('ftp');
		
		$themeName	= '';
		if($this->themeName()) {
			$themeName = $this->themeName();
		}
		
		$this->assignRef('themename', $themeName);
		$this->assignRef('ftp', $ftp);
		
		// Background Image
		$params = JComponentHelper::getParams('com_phocagallery');
		
		$tmpl['formaticon'] = PhocaGalleryImage::getFormatIcon();
		// Small
		$tmpl['siw']		= $params->get('small_image_width', 50 );
		$tmpl['sih']		= $params->get('small_image_height', 50 );
		
		//After creating an image (post with data);
		$tmpl['ssbgc']			= JRequest::getVar( 'ssbgc', '', '', 'string' );
		$tmpl['sibgc']			= JRequest::getVar( 'sibgc', '', '', 'string' );
		$tmpl['sibrdc']			= JRequest::getVar( 'sibrdc', '', '', 'string' );
		$tmpl['sie']			= JRequest::getVar( 'sie', '', '', 'int' );
		$tmpl['siec']			= JRequest::getVar( 'siec', '', '', 'string' );
		$siw					= JRequest::getVar( 'siw', '', '', 'int' );
		$sih					= JRequest::getVar( 'sih', '', '', 'int' );
			
		if($tmpl['ssbgc'] != '') 	{$tmpl['ssbgc'] = '#'.$tmpl['ssbgc'];}
		if($tmpl['sibgc'] != '') 	{$tmpl['sibgc'] = '#'.$tmpl['sibgc'];}
		if($tmpl['sibrdc'] != '') 	{$tmpl['sibrdc'] = '#'.$tmpl['sibrdc'];}
		if($tmpl['siec'] != '') 	{$tmpl['siec'] = '#'.$tmpl['siec'];}
		if ((int)$siw > 0) 			{$tmpl['siw'] = (int)$siw;}
		if ((int)$sih > 0) 			{$tmpl['sih'] = (int)$sih;}
		
		// Medium
		$tmpl['miw']		= $params->get('medium_image_width', 100 );
		$tmpl['mih']		= $params->get('medium_image_height', 100 );
		
		//After creating an image (post with data);
		$tmpl['msbgc']			= JRequest::getVar( 'msbgc', '', '', 'string' );
		$tmpl['mibgc']			= JRequest::getVar( 'mibgc', '', '', 'string' );
		$tmpl['mibrdc']			= JRequest::getVar( 'mibrdc', '', '', 'string' );
		$tmpl['mie']			= JRequest::getVar( 'mie', '', '', 'int' );
		$tmpl['miec']			= JRequest::getVar( 'miec', '', '', 'string' );
		$miw					= JRequest::getVar( 'miw', '', '', 'int' );
		$mih					= JRequest::getVar( 'mih', '', '', 'int' );
			
		if($tmpl['msbgc'] != '') 	{$tmpl['msbgc'] = '#'.$tmpl['msbgc'];}
		if($tmpl['mibgc'] != '') 	{$tmpl['mibgc'] = '#'.$tmpl['mibgc'];}
		if($tmpl['mibrdc'] != '') 	{$tmpl['mibrdc'] = '#'.$tmpl['mibrdc'];}
		if($tmpl['miec'] != '') 	{$tmpl['miec'] = '#'.$tmpl['miec'];}
		if ((int)$miw > 0) 			{$tmpl['miw'] = (int)$miw;}
		if ((int)$mih > 0) 			{$tmpl['mih'] = (int)$mih;}
			

		
		$this->assignRef('tmpl', $tmpl);
		parent::display($tpl);
		$this->_setToolbar();
	}
	
	function _setToolbar() {
		JToolBarHelper::title(   JText::_( 'Phoca Gallery Themes' ), 'theme' );
		JToolBarHelper::cancel( 'cancel', 'Close' );
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
	
	function themeName() {
		// Get an array of all the xml files from teh installation directory
		$path		= PhocaGalleryPath::getPath();
		$xmlFiles 	= JFolder::files($path->image_abs, '.xml$', 1, true);
		
		// If at least one xml file exists
		if (count($xmlFiles) > 0) {
			foreach ($xmlFiles as $file)
			{
				// Is it a valid joomla installation manifest file?
				$manifest = $this->_isManifest($file);				
				if(!is_null($manifest->document->children())) {
					foreach ($manifest->document->children() as $key => $value)
					{
						if ($value->_name == 'name') {
							return $value->_data;
						}
					}
				}
				return false;
			}
			return false;
		} else {
			return false;
		}
	}
	
	function &_isManifest($file) {
		// Initialize variables
		$null	= null;
		$xml	=& JFactory::getXMLParser('Simple');

		// If we cannot load the xml file return null
		if (!$xml->loadFile($file)) {
			// Free up xml parser memory and return null
			unset ($xml);
			return $null;
		}
		
		$root =& $xml->document;
		if (!is_object($root) || ($root->name() != 'install' )) {
			// Free up xml parser memory and return null
			unset ($xml);
			return $null;
		}
		return $xml;
	}
}
?>
