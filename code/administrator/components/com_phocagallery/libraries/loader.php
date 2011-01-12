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
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
if (! class_exists('JLoader')) {
    require_once( JPATH_LIBRARIES.DS.'loader.php');
}

class PhocaGalleryLoader extends JLoader
{
	function import( $filePath, $base = null, $key = 'libraries.' ) {
		static $paths;

		if (!isset($paths)) {
			$paths = array();
		}

		$keyPath = $key ? $key . $filePath : $filePath;
		

		if (!isset($paths[$keyPath]))
		{
			if ( ! $base ) {
				$base =  JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'libraries';
			}

			$parts = explode( '.', $filePath );

			$classname = array_pop( $parts );
			
			
			switch($classname)
			{
				case 'helper' :
					$classname = ucfirst(array_pop( $parts )).ucfirst($classname);
					break;

				default :
					$classname = ucfirst($classname);
					break;
			}

			$path  = str_replace( '.', DS, $filePath );
			

			if (strpos($filePath, 'phocagallery') === 0)
			{
				$classname	= 'PhocaGallery'.$classname;
				$classes	= JLoader::register($classname, $base.DS.$path.'.php');
				$rs			= isset($classes[strtolower($classname)]);
			}
			else
			{
				/*
				 * If it is not in the joomla namespace then we have no idea if
				 * it uses our pattern for class names/files so just include.
				 */
				$rs   = include($base.DS.$path.'.php');
			}

			$paths[$keyPath] = $rs;
		}

		return $paths[$keyPath];
	}
}

function phocagalleryimport($path) {
	return PhocaGalleryLoader::import($path);
}
