<?php
/**
 * @package JCE File Manager
 * @copyright Copyright (C) 2005 - 2010 Ryan Demmer. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see licence.txt
 * JCE File Manager is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined('_JEXEC') or die('RESTRICTED');

require_once (WF_EDITOR_LIBRARIES . DS . 'classes' . DS . 'manager.php');


class WFFileManagerPlugin extends WFMediaManager {
	/*
	 * @var string
	 */
	var $_filetypes = 'xml=xml;html=htm,html;text=txt,rtf,pdf;office=doc,docx,ppt,xls;image=gif,jpeg,jpg,png;archive=zip,tar,gz;video=swf,mov,wmv,avi,flv,mp4,ogv,ogg,webm,mpeg,mpg;audio=wav,mp3,ogg,webm,aiff;openoffice=odt,odg,odp,ods,odf';

	function __construct()
	{			
		parent::__construct();

		$request =WFRequest::getInstance();
		$request->setRequest( array($this, 'getFileDetails'));
	}

	/**
	 * Returns a reference to a manager object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $manager =FileManager::getInstance();</pre>
	 *
	 * @access	public
	 * @return	FileManager  The manager object.
	 * @since	1.5
	 */
	function & getInstance()
	{
		static $instance;

		if(!is_object($instance)) {
			$instance = new WFFileManagerPlugin();
		}
		return $instance;
	}

	/**
	 * Display the plugin
	 */
	function display()
	{
		parent::display();

		$document =WFDocument::getInstance();

		$document->addScript( array('filemanager'), 'plugins');
		$document->addStyleSheet( array('filemanager'), 'plugins');

		$document->addScriptDeclaration('FileManager.settings=' . json_encode($this->getSettings()) . ';');

		$tabs =WFTabs::getInstance( array('base_path' => WF_EDITOR_PLUGIN));
		// Add tabs
		$tabs->addTab('file');
		$tabs->addTab('advanced');
	}

	function getIconMap()
	{
		jimport('joomla.filesystem.folder');

		$path 		= $this->getParam('filemanager.icon_path', 'media/jce/icons');
		$format 	= $this->getParam('filemanager.icon_format', '{$name}.png');
		$extensions = $this->getParam('extensions', $this->get('_filetypes'));

		if(strpos($path, 'http') !== false) {
			return $extensions;
		}

		// get extension from format
		$ext = JFile::getExt($format);
		// get all matched icons
		$icons = JFolder::files(JPATH_SITE . DS . $path, '\.' . $ext);

		if($icons) {
			for($i = 0; $i < count($icons); $i++) {
				// convert format to regex equivalent
				$format = str_replace('{$name}', '([a-z0-9]+)', $format);
				// get icon name
				preg_match('#' . $format . '#i', $icons[$i], $matches);

				$icons[$i] = basename($matches[0], '.' . $ext);
			}
		} else {
			$icons = array();
		}
		
		$map = array();
		
		// map through extensions and remove icons that do not exist
		foreach(explode(';', $extensions) as $group) {
			// only if valid extensions group	
			if (substr($group, 0, 1) === '-') {
				continue;	
			}
			
			// get the groups parts eg: image, 'jpg,jpeg,png,gif'			
			$parts 	= explode('=', $group);	
			
			$key 	= $parts[0];
			$values = explode(',', $parts[1]);					
				
			foreach(array_diff($values, $icons) as $item) {
				$map[$item] = $key;
			}
				
			foreach(array_intersect($values, $icons) as $item) {
				$map[$item] = $item;
			}
		}

		return  $map;
	}

	function getFileDetails($file)
	{
		$browser =$this->getBrowser();

		$filesystem =$browser->getFileSystem();
		// get array with folder date and content count eg: array('date'=>'00-00-000', 'folders'=>1, 'files'=>2);
		$details = $filesystem->getFileDetails($file);

		$data = array('size' => WFUtility::formatSize($details['size']), 'date' => WFUtility::formatDate($details['modified'], $this->getParam('filemanager.date_format', '%d/%m/%Y, %H:%M')));

		return $data;
	}

	function getSettings()
	{
		$settings = array(
			'icon_map' 				=> $this->getIconMap(), 
			'icon_path' 			=> $this->getParam('filemanager.icon_path', 'media/jce/icons'), 
			'icon_format' 			=> $this->getParam('filemanager.icon_format', '{$name}.png'), 
			'date_format' 			=> $this->getParam('filemanager.date_format', '%d/%m/%Y, %H:%M'), 
			'text_alert' 			=> $this->getParam('filemanager.text_alert', 1)
		);

		return parent::getSettings($settings);
	}

}
?>
