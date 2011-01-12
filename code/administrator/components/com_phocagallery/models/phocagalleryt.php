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
jimport('joomla.application.component.model');
jimport( 'joomla.installer.installer' );
jimport('joomla.installer.helper');
jimport('joomla.filesystem.folder');


class PhocaGalleryCpModelPhocaGalleryT extends JModel
{	
	var $_paths 	= array();
	var $_manifest 	= null;

	function __construct(){
		parent::__construct();
	}
	
	function install($theme) {
		global $mainframe;
		$package = $this->_getPackageFromUpload();
	
		if (!$package) {
			JError::raiseWarning(1, JText::_('Unable to find install package'));
			$this->deleteTempFiles();
			return false;
		}
		
		if ($package['dir'] && JFolder::exists($package['dir'])) {
			$this->setPath('source', $package['dir']);
		} else {
			JError::raiseWarning(1, JText::_('Install path does not exist'));
			$this->deleteTempFiles();
			return false;
		}

		// We need to find the installation manifest file
		if (!$this->_findManifest()) {
			JError::raiseWarning(1, JText::_('Unable to find required information in install package'));
			$this->deleteTempFiles();
			return false;
		}
		
		// Files - copy files in manifest
		foreach ($this->_manifest->document->children() as $child)
		{
			if (is_a($child, 'JSimpleXMLElement') && $child->name() == 'files') {
				if ($this->parseFiles($child) === false) {
					JError::raiseWarning(1, JText::_('Unable to find required information in install package'));
					$this->deleteTempFiles();
					return false;
				}
			}
		}
		
		// File - copy the xml file
		$copyFile 		= array();
		$path['src']	= $this->getPath( 'manifest' ); // XML file will be copied too
		$path['dest']	= JPATH_SITE.DS.'components'.DS.'com_phocagallery'.DS.'assets'.DS.'images'.DS. basename($this->getPath('manifest')); 
		$copyFile[] 	= $path;
		$this->copyFiles($copyFile);
		
		$this->deleteTempFiles();
		
		
		// -------------------
		// Themes
		// -------------------
		// Params -  Get new themes params
		$paramsThemes = &$this->getParamsThemes();
		
		// -------------------
		// Component
		// -------------------
		if (isset($theme['component']) && $theme['component'] == 1 )
		{
			
			$paramsComponentArray = '';
			// Params - Get component params
			//	$paramsComponent = $this->getParams();
			$paramsComponent		= JComponentHelper::getParams('com_phocagallery') ;
			$paramsComponentArray 	= $paramsComponent->_registry['_default']['data'];
			
			// if empty object, php doesn't say it...
			$isArray = 0;
			foreach ($paramsComponentArray as $isKey => $isValue) {
				$isArray = 1;
			}
			
			// If no params are saved, we add only Themes params
			if ($isArray == 1) {
				// We get the params values from database and add new values ( no lose the other params)
				$newParamsComponent = '';
				foreach ($paramsComponentArray as $keyC => $valueC)
				{
					$newParamsComponent['params'][$keyC] = $valueC;
					foreach ($paramsThemes as $keyT => $valueT)
					{
						if ($valueT['name'] == $keyC)
						{
							$newParamsComponent['params'][$keyC] = $valueT['value'];
						}
						
					}
				}
			} else {
				$newParamsComponent = '';
				foreach ($paramsThemes as $keyT => $valueT)
				{
					$newParamsComponent['params'][$valueT['name']] = $valueT['value'];
				}
			}
			
			$table =& JTable::getInstance( 'component' );
			$table->loadByOption( 'com_phocagallery' );

			if (!$table->bind($newParamsComponent)) {
				JError::raiseWarning( 500, 'Not a valid component' );
				return false;
			}
				
			// pre-save checks
			if (!$table->check()) {
				JError::raiseWarning( 500, $table->getError('Check Problem') );
				return false;
			}

			// save the changes
			if (!$table->store()) {
				JError::raiseWarning( 500, $table->getError('Store Problem') );
				return false;
			}
		}
		
		// -------------------
		// Menu Categories
		// -------------------
		if (isset($theme['categories']) && $theme['categories'] == 1 )
		{
			$menus		=& JApplication::getMenu('site');
			$db 		=& JFactory::getDBO();
			$itemsCat	= $menus->getItems('link', 'index.php?option=com_phocagallery&view=categories');
			
			if (!empty($itemsCat)) {
				foreach($itemsCat as $keyIT => $valueIT)
				{
					$paramsCategoriesArray  = '';
					$query = 'SELECT m.params'
					. ' FROM #__menu AS m'
					. ' WHERE m.id = '.(int) $valueIT->id;
				
					$db->setQuery( $query );
					$paramsCategoriesObject = $db->loadObjectList();
					$paramsCategories 		= new JParameter( $paramsCategoriesObject[0]->params );
					$paramsCategoriesArray 	= $paramsCategories->_registry['_default']['data'];
					
					// if empty object, php doesn't say it...
					$isArray = 0;
					foreach ($paramsCategoriesArray as $isKey => $isValue) {
						$isArray = 1;
					}
					
					// If no params are saved, we add only Themes params
					if ($isArray == 1) {
						// We get the params values from database and add new values ( no lose the other params)
						$newParamsMenuCategories = '';
						foreach ($paramsCategoriesArray as $keyS => $valueS)
						{
							$newParamsMenuCategories['params'][$keyS] = $valueS;
							foreach ($paramsThemes as $keyT2 => $valueT2)
							{
								if ($valueT2['name'] == $keyS)
								{
									$newParamsMenuCategories['params'][$keyS] = $valueT2['value'];
								}
								
							}
						}
					} else {
						$newParamsMenuCategories = '';
						foreach ($paramsThemes as $keyT2 => $valueT2)
						{
							$newParamsMenuCategories['params'][$valueT2['name']] = $valueT2['value'];
						}
					}
					
					
					$table =& JTable::getInstance( 'menu' );
					
					if (!$table->load((int) $valueIT->id)) {
						JError::raiseWarning( 500, 'Not a valid table' );
						return false;
					}
					
					if (!$table->bind($newParamsMenuCategories)) {
						JError::raiseWarning( 500, 'Not a valid table' );
						return false;
					}
						
					// pre-save checks
					if (!$table->check()) {
						JError::raiseWarning( 500, $table->getError('Check Problem') );
						return false;
					}

					// save the changes
					if (!$table->store()) {
						JError::raiseWarning( 500, $table->getError('Store Problem') );
						return false;
					}
						
				}
			}
		}
		
		// -------------------
		// Menu Category
		// -------------------
		if (isset($theme['category']) && $theme['category'] == 1 )
		{
		
			$menus		=& JApplication::getMenu('site');
			$db 		=& JFactory::getDBO();
			
			// Select all categories to get possible menu links
			$query = 'SELECT c.id'
					. ' FROM #__phocagallery_categories AS c';
			
			$db->setQuery( $query );
			$categoriesId = $db->loadObjectList();
			
			// We get id from Phoca Gallery categories and try to find menu links from these categories
			if (!empty ($categoriesId)) {
				foreach($categoriesId as $keyI => $valueI)
				{
					$itemsCat	= $menus->getItems('link', 'index.php?option=com_phocagallery&view=category&id='.(int)$valueI->id);
					if (!empty ($itemsCat)) {
						foreach($itemsCat as $keyIT2 => $valueIT2)
						{
							$paramsCategoryArray = '';
							$query = 'SELECT m.params'
							. ' FROM #__menu AS m'
							. ' WHERE m.id = '.(int) $valueIT2->id;
					
							$db->setQuery( $query );
							$paramsCategoryObject = $db->loadObjectList();
							$paramsCategory 		= new JParameter( $paramsCategoryObject[0]->params );
							$paramsCategoryArray 	= $paramsCategory->_registry['_default']['data'];
							
							// if empty object, php doesn't say it...
							$isArray = 0;
							foreach ($paramsCategoryArray as $isKey => $isValue) {
								$isArray = 1;
							}
							
							// If no params are saved, we add only Themes params
							if ($isArray == 1) {
								// We get the params values from database and add new values ( no lose the other params)
								$newParamsMenuCategory = '';
								foreach ($paramsCategoryArray as $keyY => $valueY)
								{
									$newParamsMenuCategory['params'][$keyY] = $valueY;
									foreach ($paramsThemes as $keyT3 => $valueT3)
									{
										if ($valueT3['name'] == $keyY)
										{
											$newParamsMenuCategory['params'][$keyY] = $valueT3['value'];
										}
										
									}
								}
							} else {
								$newParamsMenuCategory = '';
								foreach ($paramsThemes as $keyT3 => $valueT3)
								{
									$newParamsMenuCategory['params'][$valueT3['name']] = $valueT3['value'];
								}
							}
							
							
							$table =& JTable::getInstance( 'menu' );
							
							if (!$table->load((int) $valueIT2->id)) {
								JError::raiseWarning( 500, 'Not a valid table' );
								return false;
							}
							
							if (!$table->bind($newParamsMenuCategory)) {
								JError::raiseWarning( 500, 'Not a valid table' );
								return false;
							}
								
							// pre-save checks
							if (!$table->check()) {
								JError::raiseWarning( 500, $table->getError('Check Problem') );
								return false;
							}

							// save the changes
							if (!$table->store()) {
								JError::raiseWarning( 500, $table->getError('Store Problem') );
								return false;
							}	
						}
					}
				}
			}
		}
		return true;
	}
	
	function _getPackageFromUpload()
	{
		// Get the uploaded file information
		$userfile = JRequest::getVar('install_package', null, 'files', 'array' );

		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads')) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('WARNINSTALLFILE'));
			return false;
		}

		// Make sure that zlib is loaded so that the package can be unpacked
		if (!extension_loaded('zlib')) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('WARNINSTALLZLIB'));
			return false;
		}

		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile) ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('No file selected'));
			return false;
		}

		// Check if there was a problem uploading the file.
		if ( $userfile['error'] || $userfile['size'] < 1 ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('WARNINSTALLUPLOADERROR'));
			return false;
		}

		// Build the appropriate paths
		$config 	=& JFactory::getConfig();
		$tmp_dest 	= $config->getValue('config.tmp_path').DS.$userfile['name'];
		$tmp_src	= $userfile['tmp_name'];

		// Move uploaded file
		jimport('joomla.filesystem.file');
		$uploaded = JFile::upload($tmp_src, $tmp_dest);

		// Unpack the downloaded package file
		$package = JInstallerHelper::unpack($tmp_dest);
		$this->_manifest =& $manifest;
		
		$this->setPath('packagefile', $package['packagefile']);
		$this->setPath('extractdir', $package['extractdir']);
		
		return $package;
	}
	
	function getPath($name, $default=null)
	{
		return (!empty($this->_paths[$name])) ? $this->_paths[$name] : $default;
	}
	
	function setPath($name, $value)
	{
		$this->_paths[$name] = $value;
		
	}
	
	function _findManifest()
	{
		// Get an array of all the xml files from teh installation directory
		$xmlfiles = JFolder::files($this->getPath('source'), '.xml$', 1, true);
		
		// If at least one xml file exists
		if (count($xmlfiles) > 0) {
			foreach ($xmlfiles as $file)
			{
				// Is it a valid joomla installation manifest file?
				$manifest = $this->_isManifest($file);
				if (!is_null($manifest)) {
				
					// If the root method attribute is set to phocagallerytheme
					$root =& $manifest->document;
					if ($root->attributes('method') != 'phocagallerytheme') {
						JError::raiseWarning(1, JText::_('No Phoca Gallery Theme File'));
						return false;
					}

					// Set the manifest object and path
					$this->_manifest =& $manifest;
					$this->setPath('manifest', $file);

					// Set the installation source path to that of the manifest file
					$this->setPath('source', dirname($file));
					
					return true;
				}
			}

			// None of the xml files found were valid install files
			JError::raiseWarning(1, JText::_('ERRORNOTFINDJOOMLAXMLSETUPFILE'));
			return false;
		} else {
			// No xml files were found in the install folder
			JError::raiseWarning(1, JText::_('ERRORXMLSETUP'));
			return false;
		}
	}
	
	function &_isManifest($file)
	{
		// Initialize variables
		$null	= null;
		$xml	=& JFactory::getXMLParser('Simple');

		// If we cannot load the xml file return null
		if (!$xml->loadFile($file)) {
			// Free up xml parser memory and return null
			unset ($xml);
			return $null;
		}

		/*
		 * Check for a valid XML root tag.
		 * @todo: Remove backwards compatability in a future version
		 * Should be 'install', but for backward compatability we will accept 'mosinstall'.
		 */
		$root =& $xml->document;
		if (!is_object($root) || ($root->name() != 'install' )) {
			// Free up xml parser memory and return null
			unset ($xml);
			return $null;
		}

		// Valid manifest file return the object
		return $xml;
	}
	
	
	function parseFiles($element, $cid=0)
	{
		// Initialize variables
		$copyfiles = array ();

		if (!is_a($element, 'JSimpleXMLElement') || !count($element->children())) {
			// Either the tag does not exist or has no children therefore we return zero files processed.
			return 0;
		}
		
		// Get the array of file nodes to process
		$files = $element->children();
		if (count($files) == 0) {
			// No files to process
			return 0;
		}

		$source 	 = $this->getPath('source');
		$destination = JPATH_SITE.DS.'components'.DS.'com_phocagallery'.DS.'assets'.DS.'images';
		// Process each file in the $files array (children of $tagName).
		
		foreach ($files as $file)
		{
			$path['src']	= $source.DS.$file->data();
			$path['dest']	= $destination.DS.$file->data();

			// Add the file to the copyfiles array
			$copyfiles[] = $path;
		}
		return $this->copyFiles($copyfiles);
	}
	
	function copyFiles($files)
	{
		if (is_array($files) && count($files) > 0)
		{
			foreach ($files as $file)
			{
				// Get the source and destination paths
				$filesource	= JPath::clean($file['src']);
				$filedest	= JPath::clean($file['dest']);

				if (!file_exists($filesource)) {
					JError::raiseWarning(1, JText::sprintf('File does not exist', $filesource));
					return false;
				} else {
					if (!(JFile::copy($filesource, $filedest))) {
						JError::raiseWarning(1, JText::sprintf('Failed to copy file to', $filesource, $filedest));
						return false;
					}					
				}
			}
		} else {

			JError::raiseWarning(1, JText::sprintf('Problem while installation'));
			return false;
		}
		
		return count($files);
	}
	
	function getParamsThemes()
	{
		// Get the manifest document root element
		$root = & $this->_manifest->document;
		

		// Get the element of the tag names
		$element =& $root->getElementByPath('params');
		if (!is_a($element, 'JSimpleXMLElement') || !count($element->children())) {
			// Either the tag does not exist or has no children therefore we return zero files processed.
			return null;
		}

		// Get the array of parameter nodes to process
		$params = $element->children();
		if (count($params) == 0) {
			// No params to process
			return null;
		}

		// Process each parameter in the $params array.
		$paramsArray = array();
		$i=0;
		foreach ($params as $param) {
			if (!$name = $param->attributes('name')) {
				continue;
			}
			if (!$value = $param->attributes('default')) {
				continue;
			}

			$paramsArray[$i]['name'] = $name;
			$paramsArray[$i]['value'] = $value;
			$i++;
		}
		return $paramsArray;
	}
	
	function &getParams()
	{
		static $instance;
		if ($instance == null)
		{
			$table =& JTable::getInstance('component');
			$table->loadByOption( 'com_phocagallery' );

			$path	= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'config.xml';

			if (file_exists( $path )) {
				$instance = new JParameter( $table->params, $path );
			} else {
				$instance = new JParameter( $table->params );
			}
		}
		return $instance;
	}
	
	function deleteTempFiles () {
		// Delete Temp files
		$path = $this->getPath('source');
		if (is_dir($path)) {
			$val = JFolder::delete($path);
		} else if (is_file($path)) {
			$val = JFile::delete($path);
		}
		$packageFile = $this->getPath('packagefile');
		if (is_file($packageFile)) {
			$val = JFile::delete($packageFile);
		}
		$extractDir = $this->getPath('extractdir');
		if (is_dir($extractDir)) {
			$val = JFolder::delete($extractDir);
		}
	}
}
?>