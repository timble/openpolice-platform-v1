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
jimport( 'joomla.application.component.view');

class PhocaGalleryCpViewPhocagalleryG extends JView
{
	function display($tpl = null) {
		global $mainframe;

		$params 	= &JComponentHelper::getParams( 'com_phocagallery' );
		$google_maps_api_key = $params->get( 'google_maps_api_key', '' );
		$document	= & JFactory::getDocument();
		$latitude	= JRequest::getVar( 'lat', '50.079623358200884', 'get', 'string' );
		$longitude	= JRequest::getVar( 'lng', '14.429919719696045', 'get', 'string' );
		$zoom		= JRequest::getVar( 'zoom', '2', 'get', 'string' );

		$this->assignRef('zoom', $zoom);
		$this->assignRef('longitude', $longitude);
		$this->assignRef('latitude', $latitude);
		$this->assignRef('googlemapsapikey', $google_maps_api_key);

		parent::display($tpl);
	}
}
?>