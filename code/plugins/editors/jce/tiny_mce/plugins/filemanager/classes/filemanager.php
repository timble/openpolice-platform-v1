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

defined( '_JEXEC' ) or die( 'Restricted access' );
// Set as an extension parent
define( '_JCE_EXT', 1 );
/**
 * fileManager Class.
 * @author $Author: Ryan Demmer
 */
class FileManager extends Manager{
	/* 
	* @var string
	*/
	var $_ext = 'xml=xml;html=htm,html;word=doc,docx;powerpoint=ppt;excel=xls;text=txt,rtf;image=gif,jpeg,jpg,png;acrobat=pdf;archive=zip,tar,gz;flash=swf;winrar=rar;quicktime=mov,mp4,qt;windowsmedia=wmv,asx,asf,avi;audio=wav,mp3,aiff;openoffice=odt,odg,odp,ods,odf';	
	/**
	* @access	protected
	*/
	var $_method = 'filemanager';
	
	function __construct(){	
		parent::__construct();
		
		// Set the file type map from parameters
		$this->setFileTypes( $this->getPluginParam( 'filemanager_extensions', $this->_ext ) );
		// Init plugin
		$this->init();
	}
	/**
	 * Returns a reference to a manager object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $manager = &FileManager::getInstance();</pre>
	 *
	 * @access	public
	 * @return	FileManager  The manager object.
	 * @since	1.5
	 */
	function &getInstance(){
		static $instance;

		if ( !is_object( $instance ) ){
			$instance = new FileManager();
		}
		return $instance;
	}
    
	function getFileDetails( $file ){
		jimport( 'joomla.filesystem.file' );
		clearstatcache();
		
		$path 	= Utils::makePath( $this->getBaseDir(), utf8_decode( rawurldecode( $file ) ) );
		$url 	= Utils::makePath( $this->getBaseUrl(), rawurldecode( $file ) );
		
		$date 	= Utils::formatDate( @filemtime( $path ) );
		$size 	= Utils::formatSize( @filesize( $path ) );
		
		$h = array(
			'size'		=>	$size, 
			'modified'	=>	$date
		);
		
		if( preg_match( '/\.(jpeg|jpg|gif|png)/i', $file ) ){	
			$dim 	= @getimagesize( $path );
			$pw 	= ( $dim[0] >= 100 ) ? 100 : $dim[0];
			$ph 	= ( $pw / $dim[0] ) * $dim[1];
			
			if( $ph > 80 ){
				$ph = 80;
				$pw = ( $ph / $dim[1] ) * $dim[0];
			}
			$width		= $dim[0];
			$height		= $dim[1]; 
			
			$h = array(
				'dimensions'=>	$width. ' x ' .$height,
				'size'		=>	$size, 
				'modified'	=>	$date,
				'preview'		=>	array(
					'src'		=>	$url,
					'width'		=>	round( $pw ),
					'height'	=>	round( $ph )
				)
			);
		}
		return $h;
	}
	function getProperties( $file ){
		clearstatcache();
		
		$path 	= Utils::makePath( $this->getBaseDir(), utf8_decode( rawurldecode( $file ) ) );
		
		$date 	= Utils::formatDate( @filemtime( $path ), $this->getPluginParam('filemanager_date_format', '%d/%m/%Y, %H:%M') );
		$size 	= Utils::formatSize( @filesize( $path ) );
		
		$h = array( 
			'size'		=>	$size, 
			'date'		=>	$date
		);
		return $h;
	}
	function getIconMap(){
		jimport('joomla.filesystem.folder');
		
		$path 		= $this->getIconPath();
		$prefix 	= $this->getIconPrefix();
		$extensions = $this->getPluginParam( 'filemanager_extensions', $this->_ext );
		
		if (strpos($path, 'http') !== false) {
			return $extensions;
		}
		
		$icons = JFolder::files(JPATH_SITE.DS.$path, '\.(gif)');
		
		for ($i = 0; $i < count($icons); $i++) {
			// remove prefix
			$icons[$i] = str_replace($prefix . '.gif', '', $icons[$i]);
		}
		
		$map = explode(',', $this->listFileTypes($extensions));		
		return implode(',', array_intersect($map, $icons));
	}
	function getIconPath(){
		return $this->getPluginParam( 'filemanager_extensions_path', 'plugins/editors/jce/tiny_mce/plugins/filemanager/img/ext' );
	}
	function getIconPrefix(){
		return $this->getPluginParam( 'filemanager_extensions_prefix', '_small' );
	}
	function getViewable(){
		return $this->getPluginParam( 'filemanager_extensions_viewable', 'html,htm,doc,docx,ppt,rtf,xls,txt,gif,jpeg,jpg,png,pdf,swf,mov,mpeg,mpg,avi,asf,asx,dcr,flv,wmv,wav,mp3' );
	}
	function getUploadDefaults() {
		$defaults = array(
			'method'	=>	$this->getEditorParam('editor_upload_method', 'html'),
			'conflict'	=>	$this->getSharedParam('upload_conflict', 'overwrite|unique'),
			'size'		=>	preg_replace('/[^0-9]/', '', $this->getSharedParam('max_size', 1024)),
			'types'		=>	$this->mapUploadFileTypes()
		);
		
		$ret = '';
		
		foreach ($defaults as $k => $v) {
			$v = is_numeric($v) || preg_match('/\[[^\]*]\]|\{[^\}]*\}/', $v) ? $v : "'".$v."'";
			$ret .= "'".$k."':".$v.",";
		}
		return preg_replace('/,?$/', '', $ret);
	}
	
	function getSettings()
	{
		$params	= $this->getPluginParams();
		
		$settings = array(
			'actions'	=>  $this->json_decode($this->getActions()),
			'buttons'	=>  $this->json_decode($this->getButtons()),
			'lang'		=>  $this->getLanguage(),
			'alerts'	=>  $this->json_decode($this->getAlerts()),
			'upload'	=> array(
				'method'	=> 	$this->getEditorParam('editor_upload_method', 'flash'),
				'conflict'	=> 	$this->getSharedParam('upload_conflict', 'overwrite|unique'),
				'size'		=>  $this->getSharedParam('max_size', '1024'),
				'types'		=>  $this->json_decode($this->mapUploadFileTypes()),
			),
			'tree'	=> 	$this->getEditorParam('editor_folder_tree', '1'),
			// Plugin parameters
			'params'	=> array (
				'base'			=> $this->getBase(),
				'icon_map'		=> $this->getIconMap(),
				'icon_path' 	=> $this->getIconPath(),
				'icon_prefix' 	=> $this->getIconPrefix(),
				'viewable'		=> $this->getViewable()
			) 
		);
		
		return $this->json_encode($settings);
	}
}
?>
