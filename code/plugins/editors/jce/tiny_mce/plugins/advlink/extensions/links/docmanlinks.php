<?php
/**
* @package JCE Docman Links
* @copyright Copyright (C) 2005 - 2010 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see licence.txt
* JCE Docman Links is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JCE_EXT' ) or die( 'Restricted access' );
// Core function	
function docmanlinks( &$advlink ){
	// Joomla! file and folder processing functions
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	
	$items = array();
	if( JFile::exists( JPATH_ADMINISTRATOR . DS. 'components' .DS. 'com_docman' .DS. 'docman.class.php') ){	
		// Base path for corelinks files
		$path = dirname( __FILE__ ) .DS. 'docmanlinks';	
			
		// Get all files
		$files = JFolder::files( $path, '\.(php)$' );
		
		// For AdvLink link plugins
		if( isset( $files ) ){
			foreach( $files as $file ){
				$items[] = array(
					'name'		=> JFile::stripExt( $file ),
					'path' 		=> $path,
					'file' 		=> $file
				);
			}
		}
	}
	return $items;
}	
?>
