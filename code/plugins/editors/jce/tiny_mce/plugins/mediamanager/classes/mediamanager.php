<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Set as an extension parent
define( '_JCE_EXT', 1 );
/**
 * MediaManager Class.
 * @author $Author: Ryan Demmer
 */ 
class MediaManager extends Manager {
        /* 
		* @var string
		*/
		var $_ext 	= 'windowsmedia=avi,wmv,wm,asf,asx,wmx,wvx;quicktime=mov,qt,mpg,mp3,mp4,mpeg;flash=swf,flv,xml;shockwave=dcr;real=rm,ra,ram;divx=divx';
		/**
		* @access	protected
		*/
		function __construct(){
			parent::__construct();
			
			// Set the file type map from parameters
			$this->setFileTypes( $this->getPluginParam('mediamanager_extensions', $this->_ext) );
			// Init plugin
			$this->init();		
		}
		/**
		 * Returns a reference to a manager object
		 *
		 * This method must be invoked as:
		 * 		<pre>  $manager = &MediaManager::getInstance();</pre>
		 *
		 * @access	public
		 * @return	MediaManager  The manager object.
		 * @since	1.5
		 */
		function &getInstance(){
			static $instance;
	
			if ( !is_object( $instance ) ){
				$instance = new MediaManager();
			}
			return $instance;
		}
		function &getID3Instance(){
			static $id3;	
			if ( !is_object( $id3 ) ){
				if( !class_exists( 'getID3' ) ){
					require_once( dirname( __FILE__ ) . '/getid3/getid3.php' );
				}
				$id3 = new getID3();
			}
			return $id3;
		}
		function id3Data( $path ){
			jimport( 'joomla.filesystem.file' );			
            clearstatcache();
            
            $meta = array('x'=>'100', 'y'=>'100', 'time'=>'');
			
			$ext = JFile::getExt( $path );
			
			if( $ext == 'flv' ){
				require_once( dirname( __FILE__ ) . '/flvinfo/flvinfo.php' );
				
				$info = new FlvInfo();
				
				$flv = @$info->getMeta( $path );
				
				$meta['x'] 		= isset( $flv['width'] ) 	? round( $flv['width'] ) 	: 0;
				$meta['y'] 		= isset( $flv['height'] ) 	? round( $flv['height'] ) 	: 0;
				$meta['time'] 	= isset( $flv['duration'] ) ? $flv['duration'] 			: 0;
				
				return $meta;
			}
			
			// Initialize getID3 engine
			$id3 =& $this->getID3Instance(); 
			// Get information from the file
			$fileinfo = @$id3->analyze( $path );
			getid3_lib::CopyTagsToComments( $fileinfo );

			// Output results
			if( isset( $fileinfo['video'] ) ){
				$meta['x'] 		= round( $fileinfo['video']['resolution_x'] );
				$meta['y'] 		= round( $fileinfo['video']['resolution_y'] );
			}
			if( isset( $fileinfo['playtime_string'] ) ){
				$meta['time'] 	= $fileinfo['playtime_string'];
			}

			if( $ext == 'swf' && $meta['x'] == '' ){
				$size = @getimagesize( $path );
				$meta['x'] = round( $size[0] );
				$meta['y'] = round( $size[1] );
			}
			if( $ext == 'wmv' && $meta['x'] == '' ){
				$meta['x'] = round( $fileinfo['asf']['video_media']['2']['image_width'] );
				$meta['y'] = round( ( $fileinfo['asf']['video_media']['2']['image_height'] ) + 60 );
			}
			return $meta;
        }
		function getFileDetails( $file ){
			jimport( 'joomla.filesystem.file' );
			clearstatcache();
			
			$path 	= Utils::makePath( $this->getBaseDir(), rawurldecode( $file ) );
			$date 	= Utils::formatDate( @filemtime( $path ) );
            $size 	= Utils::formatSize( @filesize( $path ) );
			
			if( preg_match( '/\.(xml)/i', $file ) ){
				$width 	= 160;
				$height = 120;
				$time 	= '--:--';
			}else{
				$meta 	= $this->id3Data( $path );
				$width 	= preg_match( '/[^0-9]/', $meta['x'] ) ? '' : $meta['x'];
				$height = preg_match( '/[^0-9]/', $meta['y'] ) ? '' : $meta['y'];
            	$time 	= preg_match( '/([0-9]+):([0-9]+)/', $meta['time'] ) ? $meta['time'] : '--:--';
			}
			
			$h = array( 
				'dimensions'=>	$width. ' x ' .$height,
				'size'		=>	$size, 
				'modified'	=>	$date,
				'duration'	=>	$time
			);
			return $h;
		}
		function getDimensions( $file ){		
			jimport( 'joomla.filesystem.file' );
			
			$path 	= Utils::makePath( $this->getBaseDir(), rawurldecode( $file ) );
			$ext 	= JFile::getExt( $path );
			$meta 	= $this->id3Data( $path );
			
			$width 	= preg_match( '/[^0-9]/', $meta['x'] ) ? '' : $meta['x'];
			$height = preg_match( '/[^0-9]/', $meta['y'] ) ? '' : $meta['y'];
			
			if ($ext == 'mp3') {
				$width 	= 200;
				$height = 16;
			}
			
			$h = array( 
				'extension'	=>	$ext,
				'width'		=>	$width,
				'height'	=>	$height
			);
			return $h;
		}
		/**
		 * Get a list of media extensions
		 *
		 * @access public
		 * @param boolean	Map the extensions to media type
		 * @return string	Extension list or type map
		*/
		function getMediaTypes( $map=false ){			
			$extensions = $this->getPluginParam( 'mediamanager_extensions', $this->_ext );
			
			if( $map ){
				return $extensions;	
			}else{
				$this->listFileTypes( $extensions );
			}			  
		}
		function getViewable(){
			return $this->_filetypes;
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
					'base'				=> $this->getBase(),
					'media_types'		=> $this->getFileTypes(),
					'flv_player_path'	=> $this->getPluginParam( 'mediamanager_flvplayer_path', 'plugins/editors/jce/tiny_mce/plugins/mediamanager/swf' ),
					'flv_player'		=> $this->getPluginParam( 'mediamanager_flvplayer', 'flvplayer.swf' ),
					'defaults' => array(	
						'align'			=> $params->get( 'mediamanager_align', 'default' ),
						'border'		=> $params->get( 'mediamanager_border', '0' ),
						'border_width'	=> $params->get( 'mediamanager_border_width', 'default' ),
						'border_style'	=> $params->get( 'mediamanager_border_style', 'default' ),
						'border_color'	=> $params->get( 'mediamanager_border_color', '' ),
						'margin_top'	=> $params->get( 'mediamanager_margin_top', 'default' ),
						'margin_right'	=> $params->get( 'mediamanager_margin_right', 'default' ),
						'margin_bottom'	=> $params->get( 'mediamanager_margin_bottom', 'default' ),
						'margin_left'	=> $params->get( 'mediamanager_margin_left', 'default' )
					)
				) 
			);
			
			return $this->json_encode($settings);
		}
}
?>