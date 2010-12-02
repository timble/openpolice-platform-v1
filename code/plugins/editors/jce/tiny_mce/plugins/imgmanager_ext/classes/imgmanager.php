<?php
/**
* @version		$Id: imgmanager.php 85 2010-10-06 $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2010 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'manager.php' );
require_once(dirname( __FILE__ ).DS.'processor.php');

class ImageManager extends Manager {
	/*
	* @var string
	*/
	var $_ext = 'image=jpg,jpeg,gif,png';
	/*
	*  @var boolean
	*/
	var $_cache = true;
	/*
	*  @var boolean
	*/
	var $_gd = true;
	/*
	*  @var boolean
	*/
	var $_edit = true;
	/**
	* @access	protected
	*/
	function __construct(){
		$this->addEvent( 'onGetItems', 'onGetItems' );
		$this->addEvent( 'onUpload', 'onUpload' );
		$this->addEvent( 'onFileDelete', 'onFileDelete' );

		// Call parent
		parent::__construct();

		// Set the file type map from parameters
		$this->setFileTypes( $this->getPluginParam('imgmanager_ext_extensions', 'image=jpg,jpeg,gif,png') );
		// Init plugin
		$this->init();
		// Get cache directory
		$cache = $this->getCacheDirectory();
		// Check cache directory
		if( !is_dir( $cache ) || ( !is_writable( $cache ) && !$this->isFtp() ) ){
			$this->addAlert( 'alert', JText::_( 'No Cache' ),  JText::_( 'No Cache Desc' ) );
			$this->_edit = false;
		}
		// Check GD
		if( !function_exists( 'gd_info' ) && !$this->getPluginParam('imgmanager_ext_use_imagemagick', 0) ){
			$this->addAlert( 'alert', JText::_( 'No GD' ), JText::_( 'No GD Desc' ) );
			$this->_edit = false;
		}

		if ($this->_edit) {
			$this->setXHR(array($this, 'getCacheThumb'));
		}

		if (JRequest::getCmd('action') == 'thumbnail') {
			$file = JRequest::getVar('img');
			if ($file && preg_match('/\.(jpg|jpeg|png|gif|tiff|bmp)$/i', $file)) {
				return $this->createCacheThumb($file);
			}
		}
	}
	/**
	 * Returns a reference to a editor object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $browser = &JCE::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JCE  The editor object.
	 * @since	1.5
	 */
	function &getInstance(){
		static $instance;

		if ( !is_object( $instance ) ){
			$instance = new ImageManager();
		}
		return $instance;
	}

	function canEdit(){
		return $this->_edit ? 1 : 0;
	}
	function isFtp(){
		// Initialize variables
		jimport('joomla.client.helper');
		$FTPOptions = JClientHelper::getCredentials('ftp');

		return $FTPOptions['enabled'] == 1;
	}

	function getProcessorConfig()
	{
		return array(
			'ftp' 				=> $this->isFTP(),
			'use_imagemagick'	=> $this->getPluginParam('imgmanager_ext_use_imagemagick', 0),
			'cache'				=> $this->getCacheDirectory(),
			'engine'			=> $this->getPluginParam('imgmanager_ext_engine', 'phpthumb')
		);
	}

	/**
	 * Manipulate file and folder list
	 *
	 * @param	file/folder array reference
	 * @param	mode variable list/images
	 * @since	1.5
	 */
	function onGetItems( &$result, $mode ){
		$files 	= $result['files'];
		$nfiles = array();

		jimport('joomla.filesystem.file');

		foreach( $files as $file ){
			$thumbnail 	= $this->getThumbnail( $file['id'] );
			$classes 	= !$thumbnail || $thumbnail == $file['id']? '' : ' thumbnail';
			$preview	= '';

			$cid = JRequest::getInt('cid');

			if ($mode == 'images') {
				$preview = $this->getCacheThumb(rawurldecode($file['id']), 50, 50, 'list');
			}

			$nfiles[] 	= array(
				'name'		=>	$file['name'],
				'id'		=>	$file['id'],
				'classes'	=>	$file['classes'] . $classes,
				'preview'	=>  $preview
			);
		}
		$result['files'] = $nfiles;
	}
	function onUpload( $file ){
		$params = $this->getPluginParams();
		// Resize
		$resize		= JRequest::getVar( 'upload-resize', 	$params->get( 'imgmanager_ext_force_resize', '0') );
		// Rotate
		$rotate 	= JRequest::getVar( 'upload-rotate', 	$params->get( 'imgmanager_ext_force_rotate', '0') );
		// Thumbnail
		$thumbnail 	= JRequest::getVar( 'upload-thumbnail', $params->get( 'imgmanager_ext_force_thumbnail', '0') );

		if( $resize ){
			$rw 	= JRequest::getVar( 'upload-resize-width', 			$params->get( 'imgmanager_ext_resize_width', '640') );
			$rh 	= JRequest::getVar( 'upload-resize-height', 		$params->get( 'imgmanager_ext_resize_height', '480') );
			$rwt	= JRequest::getVar( 'upload-resize-width-type', 	$params->get( 'imgmanager_ext_resize_width_type', 'px') );
			$rht	= JRequest::getVar( 'upload-resize-height-type', 	$params->get( 'imgmanager_ext_resize_width_type', 'px') );
			$rq		= JRequest::getVar( 'upload-resize-quality', 		$params->get( 'imgmanager_ext_resize_quality', '80') );

			if( !$this->resize( $file, '', $rw, $rh, $rwt, $rq ) ){
				$this->_result['error'] = JText::_('Resize Error');
			}
		}
		if( $rotate ){
			$ra	= JRequest::getVar( 'upload-rotate-angle', $params->get( 'imgmanager_ext_rotate_angle', '90') );
			if( !$this->rotate( $file, $ra ) ){
				$this->_result['error'] = JText::_('Rotate Error');
			}
		}
		if( $thumbnail ){
				$ts 	= JRequest::getVar( 'upload-thumbnail-size', 		$params->get( 'imgmanager_ext_thumbnail_size', '150') );
				$tst 	= JRequest::getVar( 'upload-thumbnail-size-type', 	$params->get( 'imgmanager_ext_thumbnail_size_type', 'px') );
				$tq 	= JRequest::getVar( 'upload-thumbnail-quality', 	$params->get( 'imgmanager_ext_thumbnail_quality', '80') );
				$tm 	= JRequest::getVar( 'upload-thumbnail-mode', 		$params->get( 'imgmanager_ext_thumbnail_mode', '0') );
				// Make relative
				$file = str_replace( $this->getBaseDir(), '', $file );
				$result = $this->createThumbnail( $file, $ts, $tst, $tq, $tm );
		}
		return $this->returnResult();
	}
	function onFileDelete( $file ){
		if( file_exists( Utils::makePath( $this->getBaseDir(), $this->getThumbPath( $file ) ) ) ){
			return $this->deleteThumbnail( $file );
		}
	}
	function getFileDetails( $file ){
		global $mainframe;
		jimport('joomla.filesystem.file');

		// get details from parent class
		$details 	= parent::getFileDetails($file);
		$path 		= Utils::makePath($this->getBaseDir(), rawurldecode($file));
		$url 		= Utils::makePath($this->getBaseUrl(), rawurldecode($file));

		if (file_exists( $path )) {
			if ( $this->canEdit()) {
				// Create thumbnail
				$preview_thumb = $this->getCacheThumb(rawurldecode($file), 100, 100, 'preview');
				// If success, make path

				if ($preview_thumb ) {
					if (isset($details['preview'])) {
						$details['preview'] = array(
							'src' 		=> Utils::makePath(JURI::root(true), $preview_thumb),
							'width'		=> 100,
							'height'	=> 100
						);
					}

				}
				$thumbnail = $this->getThumbnail($file);
				if ($thumbnail) {
					$trigger = ($thumbnail == $file) ? '' : 'thumb-delete';
				} else {
					$trigger = 'thumb-create';
				}
			} else {
				$trigger = '';
			}
			$details['trigger'] = array($trigger);
		}
		return $details;
	}
	/**
	 * Get the dimensions of an image
	 * @return array Dimensions as array
	 * @param object $file Relative path to image
	 */
	function getDimensions($file)
	{
		$path = Utils::makePath($this->getBaseDir(), rawurldecode($file));
		$h = array(
			'width'		=>	'',
			'height'	=>	''
		);
		if (file_exists($path)) {
			$dim = @getimagesize($path);
			$h = array(
				'width'		=>	$dim[0],
				'height'	=>	$dim[1]
			);
		}
		return $h;
	}
	function getThumbnailDimensions( $file ){
		return $this->getDimensions( $this->getThumbPath( $file ) );
	}
	function getCacheDirectory(){
		global $mainframe;

		jimport('joomla.filesystem.folder');

		$cache 	= $mainframe->getCfg('tmp_path');
		$dir 	= $this->getPluginParam( 'imgmanager_ext_cache', $cache );

		if( @strpos( JPath::clean( $dir ), JPATH_ROOT ) === false ){
			$dir = Utils::makePath( JPATH_ROOT, $dir );
		}

		if( !is_dir( $dir ) ){
			if( $this->folderCreate( $dir ) ){
				return $dir;
			}
		}
		//return $dir;
		return JPATH_ROOT.'/cache';
	}

	function cleanCacheDir(){
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$params = $this->getPluginParams();

		$this->cache_max_size 	= intval( $params->get( 'imgmanager_ext_cache_size', 10 ) ) * 1024 * 1024;
		$this->cache_max_age 	= intval( $params->get( 'imgmanager_ext_cache_age', 30 ) ) * 86400;
		$this->cache_max_files 	= intval( $params->get( 'imgmanager_ext_cache_files', 0 ) );

		if( $this->cache_max_age > 0 || $this->cache_max_size > 0 || $this->cache_max_files > 0 ){
			$path	= $this->getCacheDirectory();
			$files 	= JFolder::files( $path, '^(jce_thumb_cache)([^\.]+)\.(jpg|jpeg|gif|png)$' );
			$num 	= count( $files );
			$size 	= 0;
			$cutofftime = time() - 3600;

			if( $num ){
				foreach( $files as $file ){
					$file = Utils::makePath( $path, $file );
					if( is_file( $file ) ){
						$ftime = @fileatime( $file );
						$fsize = @filesize( $file );
						if( $fsize == 0 && $ftime < $cutofftime ){
							@JFile::delete( $file );
						}
						if( $this->cache_max_files > 0 ){
							if( $num > $this->cache_max_files ){
								@JFile::delete( $file );
								$num--;
							}
						}
						if( $this->cache_max_age > 0 ){
							if( $ftime < ( time() - $this->cache_max_age ) ){
								@JFile::delete( $file );
							}
						}
						if( $this->cache_max_files > 0 ){
							if( ( $size + $fsize ) > $this->cache_max_size ){
								@JFile::delete( $file );
							}
						}
					}
				}
			}
		}
		return true;
	}

	function toRelative($file)
	{
		return Utils::makePath(str_replace(JPATH_ROOT.DS, '', dirname(JPath::clean($file))), basename($file));
	}

	function redirectThumb($file)
	{
		if (is_file($file)) {
			$data = @getimagesize($file);

			header("Content-length: " . filesize($file));
			header("Content-type: " . $data['mime']);
			header("Location: " . $this->toRelative($file));
		}
	}

	function getCacheThumbPath($file, $width, $height)
	{
		jimport('joomla.filesystem.file');

		$mtime = @filemtime($file);
        $thumb = 'jce_thumb_cache_'.md5(basename(JFile::stripExt($file)).$mtime.$width.$height).'.'.JFile::getExt($file);
        $thumb = Utils::makePath($this->getCacheDirectory(), $thumb);

        return $thumb;
	}

	function outputImage($file)
	{
		$data = @getimagesize($file);

	    header("Content-length: " . filesize($file));
		header("Content-type: " . $data['mime']);
	    ob_clean();
	    flush();

	    @readfile($file);
	    exit;
	}

	function createCacheThumb($src)
	{
		$app =& JFactory::getApplication();

		//if (strpos($src, $this->getBaseDir()) === false) {
            $src = Utils::makePath($this->getBaseDir(), $src);
        //}

        // default for list thumbnails
        $width 		= 50;
        $height 	= 50;
        $quality 	= 50;
        $crop 		= true;

 		if (JRequest::getWord('type', 'preview') == 'preview') {
 			$width 	= 100;
 			$height = 100;
 			$crop	= false;
 		}

        // get the thumbnail path
		$thumb 		= $this->getCacheThumbPath($src, $width, $height);

		$config 	= $this->getProcessorConfig();
		$processor 	=& ImageProcessor::getInstance($config);

		if ($processor->resize($src, $thumb, $width, $height, $quality, $crop)) {
			if (file_exists($thumb)) {
				return $this->outputImage($thumb);
			}
		}

		if (file_exists($src)) {
			// output to src file
			return $this->outputImage($src);
		}
	}

	function getCacheThumb($src, $width, $height, $type = 'preview')
    {
    	jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $app =& JFactory::getApplication();

        $this->cleanCacheDir();

        if (strpos($src, $this->getBaseDir()) === false) {
            $file = Utils::makePath($this->getBaseDir(), $src);
        } else {
        	$file = $src;
        }

    	$data = @getimagesize($file);

		if (($data[0] < $width && $data[1] < $height)) {
			return $this->toRelative($file);
		}

		$thumb = $this->getCacheThumbPath($file, $width, $height);

		if (file_exists($thumb)) {
			return $this->toRelative($thumb);
		}

		$cid = JRequest::getInt('cid');
		return 'index.php?option=com_jce&task=plugin&plugin=imgmanager_ext&file=imgmanager&action=thumbnail&cid='.$cid.'&img='.rawurlencode($src).'&type='.$type;
    }

	function cleanCacheThumb($src){
		jimport('joomla.filesystem.file');

		foreach(array(100, 50) as $dimension) {
			$thumb = $this->getCacheThumbPath($src, $dimension, $dimension);
			if (JFile::exists($thumb)) {
				@JFile::delete($thumb);
			}
		}
	}
	/**
	 * PHPThumb Resize function for resizing and thumbnailing
	 * @param string $src Fullpath of the source file
	 * @param string $dest Fullpath of the destination file if any
	 * @param string $width Width to resize to.
	 * @param string $height Height to resize to.
	 * @param string $quality Quality of resizing.
	 */
	function resize( $src, $dest='', $width, $height, $type, $quality, $rm='' ){
		if( !$this->canEdit() ){
			return false;
		}
		jimport('joomla.filesystem.path');

		if( !$dest  ) $dest = $src;

		if( $type == 'pct' ){
			$dim = @getimagesize( $src );
			$width 	= $dim[0] * $width / 100;
			$height = $dim[1] * $height / 100;
		}
		$config = $this->getProcessorConfig();
		$processor =& ImageProcessor::getInstance($config);
		return $processor->resize($src, $dest, $width, $height, $quality, $rm);
	}
	/**
	 * Check for the thumbnail for a given file
	 * @param string $relative The relative path of the file
	 * @return The thumbnail URL or false if none.
	 */
	function getThumbnail( $relative ){
		$params = $this->getPluginParams();

		$path 	= Utils::makePath( $this->getBaseDir(), $relative );
		$dim 	= @getimagesize( $path );

		$dir 		= Utils::makePath( str_replace( "\\", "/", dirname( $relative ) ), $params->get( 'imgmanager_ext_thumbnail_folder', 'thumbnails') );
		$thumbnail 	= Utils::makePath( $dir, $this->getThumbName( $relative ) );

		// Image is a thumbnail
		if( strpos( $relative, $params->get( 'imgmanager_ext_thumbnail_prefix', 'thumb_' ) ) ){
			return $relative;
		}
		//the original image is smaller than thumbnails,
		//so just return the url to the original image.
		if ( $dim[0] <= $params->get( 'imgmanager_ext_thumbnail_size', '150' ) && $dim[1] <= $params->get('imgmanager_ext_thumbnail_size', '150' ) ){
			return $relative;
		}
		//check for thumbnails, if exists return the thumbnail url
		if( file_exists( Utils::makePath( $this->getBaseDir(), $thumbnail ) ) ){
		   return $thumbnail;
		}
		return false;
	}
	function getThumbnails( $files ){
		jimport('joomla.filesystem.file');
		$thumbnails = array();
		foreach( $files as $file ){
			$thumbnails[$file['name']] = $this->getCacheThumb( Utils::makePath( $this->getBaseDir(), $file['url'] ), true, 50, 50, JFile::getExt( $file['name'] ), 50 );
		}
		return $thumbnails;
	}
	function getThumbPath( $file ){
		return Utils::makePath( $this->getThumbDir( $file, false ), $this->getThumbName( $file ) );
	}
	/**
	 * For a given image file, get the respective thumbnail filename
	 * no file existence check is done.
	 * @param string $file the full path to the image file
	 * @return string of the thumbnail file
	 */
	function getThumbName( $file ){
		return $this->getPluginParam( 'imgmanager_ext_thumbnail_prefix', 'thumb_' ) . basename( $file );
	}
	function getThumbDir( $file, $create ){
		$dir = Utils::makePath( str_replace( "\\", "/", dirname( $file ) ), $this->getPluginParam('imgmanager_ext_thumbnail_folder', 'thumbnails') );
		if( $create ){
			$dir = Utils::makePath( $this->getBaseDir(), $dir );
			if( !is_dir( $dir ) ){
				$this->folderCreate( $dir );
			}
		}
		return $dir;
	}
	function transformImage( $file, $rs, $rsw, $rsh, $rst, $rsq, $ro, $roa ){
		$file = Utils::makePath( $this->getBaseDir(), rawurldecode( $file ) );

		if( $rs ){
			if( !$this->resize( $file, '', $rsw, $rsh, $rst, intval( $rsq ) ) ){
				$this->_result['error'] = JText::_('Resize Error');
			}
		}
		if( $ro ){
			if( !$this->rotate( $file, $roa ) ){
				$this->_result['error'] = JText::_('Rotate Error');
			}
		}
		return $this->returnResult();
	}
	function rotate($file, $angle){
		$config = $this->getProcessorConfig();
		$processor =& ImageProcessor::getInstance($config);
		return $processor->rotate($file, $angle);
	}
	/**
	 * Create a thumbnail
	 * @param string $file relative path of the image
	 * @param string $width thumbnail width
	 * @param string $height thumbnail height
	 * @param string $quality thumbnail quality (%)
	 * @param string $mode thumbnail mode
	 */
	function createThumbnail( $file, $size, $type, $quality, $mode ){
		$path 	= Utils::makePath( $this->getBaseDir(), $file );
		$thumb 	= Utils::makePath( $this->getThumbDir( $file, true ), $this->getThumbName( $file ) );

		if( !$this->resize( $path, $thumb, $size, $size, $type, intval( $quality ), $mode ) ){
			$this->_result['error'] = JText::_('Thumbnail Error');
		}
		return $this->returnResult();
	}
	function deleteThumbnail( $file ){
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');

		$thumbnail 	= Utils::makePath( $this->getBaseDir(), $this->getThumbPath( $file ) );
		$dir 		= Utils::makePath( $this->getBaseDir(), $this->getThumbDir( $file, false ) );
		if( !JFile::delete( $thumbnail ) ){
			$this->_result['error'] = JText::_('Thumbnail Delete Error');
		}else{
			if( !Utils::countFiles( $dir ) && !Utils::countDirs( $dir ) ){
				if( !JFolder::delete( $dir ) ){
					$this->_result['error'] = JText::_('Thumbnail Folder Delete Error');
				}else{
					$this->_result['text'] 	= true;
				}
			}
		}
		return $this->returnResult();
	}
}
?>