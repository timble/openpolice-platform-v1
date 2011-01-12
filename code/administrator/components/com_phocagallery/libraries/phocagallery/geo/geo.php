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
defined( '_JEXEC' ) or die( 'Restricted access' );

class PhocaGalleryGeo
{
	/*
	 * Geotagging
	 * If no lat or lng will be set by image, it will be automatically set by category
	 */
	function findLatLngFromCategory($categories) {
		$output['lat'] = '';
		$output['lng'] = '';
		foreach ($categories as $category) {
			if (isset($category->latitude) && isset($category->longitude)) {
				if ($category->latitude != '' && $category->latitude != '') {
					$output['lat'] = $category->latitude;
				}
				if ($category->longitude != '' && $category->longitude != '') {
					$output['lng'] = $category->longitude;
				}

				if ($output['lat'] != '' && $output['lng'] != '') {
					return $output;
				}
			} 
		}
		// If nothing will be found, paste some lng, lat
		$output['lat'] = 50.079623358200884;
		$output['lng'] = 14.429919719696045;
		return $output;
	}
}
?>