<?php

defined('_JEXEC') or die('Restricted access');

function com_install() {
    global $mainframe;
	
	jimport('joomla.filesystem.folder');
	// Initialize variables
	jimport('joomla.client.helper');
	$FTPOptions = JClientHelper::getCredentials('ftp');
	
	$language =& JFactory::getLanguage();		
	$language->load( 'com_jce_imgmanager_ext', JPATH_SITE );
	
	$cache = $mainframe->getCfg('tmp_path');
	
	// Check for tmp folder
	if( !JFolder::exists( $cache ) ){
		// Create if does not exist
		if( !JFolder::create( $cache ) ){
			$mainframe->enqueueMessage( JText::_('NO CACHE DESC'), 'error' );
		}
	}
	// Check if folder exists and is writable or the FTP layer is enabled	
	if( JFolder::exists( $cache ) && ( is_writable( $cache ) || $FTPOptions['enabled'] == 1 ) ){
		$mainframe->enqueueMessage( JText::_('CACHE DESC') );
	}else{
		$mainframe->enqueueMessage( JText::_('NO CACHE DESC'), 'error' );
	}
	// Check for GD
	if( !function_exists( 'gd_info' ) ){
		$mainframe->enqueueMessage( JText::_('NO GD DESC'), 'error' );
	}else{
		$info = gd_info();
		$mainframe->enqueueMessage( JText::_('GD DESC') . ' - ' . $info['GD Version'] );
	}
}