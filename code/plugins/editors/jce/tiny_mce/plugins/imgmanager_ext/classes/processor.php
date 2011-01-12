<?php
/**
* @version		$Id: processor.php 85 2010-10-06 $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2010 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die('Restricted access');

class ImageProcessor extends JObject 
{
	/**
	* @access	protected
	*/
	
	function __construct($config = array())
	{
		// Call parent
		parent::__construct($config);
		
		$this->setProperties($config);
	}
	
	/**
	 * Returns a reference to a ImageProcessor object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $process = &ImageProcessor::getInstance();</pre>
	 *
	 * @access	public
	 * @return	ImageProcessor  The ImageProcessor object.
	 * @since	1.5
	 */
	
	function &getInstance($config = array())
	{
		static $instance;
	
		if (!is_object($instance)) {
			$instance = new ImageProcessor($config);
		}
		return $instance;
	}
	
	function getPhpThumb(){			
		require_once(dirname( __FILE__ ).DS.'phpthumb'.DS.'phpthumb.class.php');
		
		$phpthumb = new phpThumb();
	
		$phpthumb->setParameter('config_document_root', 				JPATH_SITE );	
		$phpthumb->setParameter('config_use_imagemagick', 				$this->get('use_imagemagick', 0));
		$phpthumb->setParameter('config_prefer_imagemagick', 			$this->get('use_imagemagick', 0));
		$phpthumb->setParameter('config_use_exif_thumbnail_for_speed', 	true);
		$phpthumb->setParameter('config_max_source_pixels', 			8640000);
		$phpthumb->setParameter('config_temp_directory', 				$this->get('cache'));
		$phpthumb->setParameter('config_cache_directory', 				$this->get('cache'));
		$phpthumb->setParameter('config_error_silent_die_on_error', 	true);
		$phpthumb->setParameter('config_error_die_on_source_failure', 	true);

		return $phpthumb;
	}

    function resize($src, $dest, $width, $height, $quality, $method) 
    {
    	jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');
        
        $engine = $this->get('engine', 'phpthumb');

        if ($engine == 'wideimage') {
        	require_once(dirname( __FILE__ ).DS.'wideimage'.DS.'WideImage.php');
        	
        	$ext = strtolower(JFile::getExt($src));
        	$src = @JFile::read($src);
        
	        if ($src) {
	        	$image = @WideImage::loadFromString($src);
		
				if ($method) {
					$result = $image->resize($width, $height, 'outside')->crop('center', 'center', $width, $height);
				} else {
					$result = $image->resize($width, $height);
				}		
	
				switch ($ext) {
					case 'jpg':
					case 'jpeg':
						$quality = intval($quality);
						if ($this->get('ftp', 0)) {
				        	@JFile::write($thumb, $result->output($ext, $quality));
				        } else {
				        	$result->saveToFile($dest, $quality);
				       	}
						break;
					default:
						if ($this->get('ftp', 0)) {
				        	@JFile::write($thumb, $result->output($ext));
				        } else {
				        	$result->saveToFile($dest);
				       	}				       	
						break;	
				}

		       	unset($image);
		       	unset($result);
	        }
        } else {
        	$phpthumb = $this->getPhpThumb();
					
			$phpthumb->src = $src;
			
			$phpthumb->w 	= $width;
			$phpthumb->h 	= $height;
			$phpthumb->q 	= $quality;
			$phpthumb->f 	= JFile::getExt($src);	
	
			$phpthumb->zc 	= $method;
			$phpthumb->aoe 	= !$method;
			
	        if (@$phpthumb->GenerateThumbnail()) {
				if ($this->get('ftp', 0) && $phpthumb->RenderOutput()) {
					@JFile::write($dest, $phpthumb->outputImageData);
				} else {
					@$phpthumb->RenderToFile($dest);
				}
			}
			unset($phpthumb);
        }
        
    	if (file_exists($dest)) {
			@JPath::setPermissions($dest);
			return $dest;
		}
		
		return false;
    }
	function rotate($file, $angle){
		jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');
        
		$engine = $this->get('engine', 'phpthumb');
        
        if ($engine == 'wideimage') {
			require_once(dirname( __FILE__ ).DS.'wideimage'.DS.'WideImage.php');
			
			$ext = strtolower(JFile::getExt($src));
        	$file = @JFile::read($file);
			
			$image = @WideImage::loadFromString($file);
		
			switch ($angle) {
				case '-90':
				case '180':
				case '90':
					$result = @$image->rotate($angle * -1);
					break;
				case 'vertical':
					$result = @$image->flip();
					break;
				case 'horizontal':
					$result = @$image->mirror();
					break;
			}
			unset($image);
			
			if ($this->get('ftp', 0)) {
	        	return @JFile::write($file, $result->output($ext));
	        } else {
	        	return $result->saveToFile($file);
	       	}
        } else {
	        $phpthumb 		= $this->getPhpThumb();	
			$phpthumb->src 	= $file;
			
			switch ($angle) {
				case '-90':
				case '180':
				case '90':
					$phpthumb->ra = $angle;
					break;
				case 'vertical':
					$phpthumb->fltr[] = 'flip|y';
					break;
				case 'horizontal':
					$phpthumb->fltr[]= 'flip|x';
					break;
			}
			
	        if (@$phpthumb->GenerateThumbnail()) {
				if ($this->get('ftp', 0) && $phpthumb->RenderOutput()) {
					@JFile::write( $file, $phpthumb->outputImageData);
				} else {
					@$phpthumb->RenderToFile($file);
				}
				if (file_exists($file)){
					@JPath::setPermissions($file);
					return $file;
				}
			}
			
			unset($phpthumb);
        }

		return false;
	}
}