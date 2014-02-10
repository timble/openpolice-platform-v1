<?php

/**
 * @package   	JCE
 * @copyright 	Copyright (c) 2009-2013 Ryan Demmer. All rights reserved.
 * @license   	GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined('_JEXEC') or die('RESTRICTED');

if (!defined('_WF_EXT')) {
    define('_WF_EXT', 1);
}

wfimport('editor.libraries.classes.manager');
wfimport('editor.libraries.classes.extensions.aggregator');
wfimport('editor.libraries.classes.extensions.mediaplayer');
wfimport('editor.libraries.classes.extensions.popups');

/**
 * MediaManager Class.
 * @author $Author: Ryan Demmer
 */
class WFMediaManagerPlugin extends WFMediaManager {
    /*
     * @var string
     */

    var $_filetypes = 'windowsmedia=avi,wmv,wm,asf,asx,wmx,wvx;quicktime=mov,qt,mpg,mpeg,m4a;flash=swf;shockwave=dcr;real=rm,ra,ram;divx=divx;video=mp4,ogv,ogg,webm;audio=mp3,ogg;silverlight=xap';
    
    /**
     * @access	protected
     */
    public function __construct() {
        // call parent
        parent::__construct();

        // get the mediaplayer extension
        $mediaplayer = $this->getMediaPlayer();

        $request = WFRequest::getInstance();

        // Setup plugin XHR callback functions 
        $request->setRequest(array($this, 'getDimensions'));
        $request->setRequest(array($this, 'getFileDetails'));
    }

    /**
     * Display the plugin
     */
    public function display() {
        parent::display();

        $document = WFDocument::getInstance();

        $document->addScript(array('mediamanager'), 'plugins');
        $document->addStyleSheet(array('mediamanager'), 'plugins');

        $settings = $this->getSettings();

        $document->addScriptDeclaration('MediaManagerDialog.settings=' . json_encode($settings) . ';');

        $tabs = WFTabs::getInstance(array('base_path' => WF_EDITOR_PLUGIN));

        // Add tabs
        $tabs->addTab('file', 1, array('plugin' => $this));
        $tabs->addTab('media', $this->getParam('tabs_media', 1), array('plugin' => $this));
        $tabs->addTab('advanced', $this->getParam('tabs_advanced', 1));

        // Load Popups instance
        $popups = WFPopupsExtension::getInstance(array(
            // map src value to popup link href
            'map' => array('href' => 'src'),
            'default'   => $this->getParam('mediamanager.popups.default', '')
                ));

        $popups->display();

        // Load Media Player instance
        $mediaplayer = $this->getMediaPlayer();
        $mediaplayer->display();

        // Load video aggregators (Youtube, Vimeo etc)
        $this->loadAggregators();
    }

    protected function getID3Instance() {
        static $id3;
        if (!is_object($id3)) {
            if (!class_exists('getID3')) {
                $app = JFactory::getApplication();                
                // set tmp directory
                define('GETID3_TEMP_DIR', $app->getCfg('tmp_path'));

                require_once( dirname(__FILE__) . '/getid3/getid3.php' );
            }
            $id3 = new getID3();
        }
        return $id3;
    }

    protected function id3Data($path) {
        jimport('joomla.filesystem.file');
        clearstatcache();

        $meta = array('x' => '100', 'y' => '100', 'time' => '');

        $ext = JFile::getExt($path);

        /* if( $ext == 'flv' ){
          require_once( dirname( __FILE__ ) . '/flvinfo/flvinfo.php' );

          $info = new FlvInfo();

          $flv = @$info->getMeta( $path );

          $meta['x'] 		= isset( $flv['width'] ) 	? round( $flv['width'] ) 	: 0;
          $meta['y'] 		= isset( $flv['height'] ) 	? round( $flv['height'] ) 	: 0;
          $meta['time'] 	= isset( $flv['duration'] ) ? $flv['duration'] 			: 0;

          return $meta;
          } */

        // Initialize getID3 engine
        $id3 = $this->getID3Instance();
        // Get information from the file
        $fileinfo = @$id3->analyze($path);
        getid3_lib::CopyTagsToComments($fileinfo);

        // Output results
        if (isset($fileinfo['video'])) {
            $meta['x'] = isset($fileinfo['video']['resolution_x']) ? round($fileinfo['video']['resolution_x']) : 100;
            $meta['y'] = isset($fileinfo['video']['resolution_y']) ? round($fileinfo['video']['resolution_y']) : 100;
        }

        if (isset($fileinfo['playtime_string'])) {
            $meta['time'] = $fileinfo['playtime_string'];
        }

        if ($ext == 'swf' && $meta['x'] == '') {
            $size = @getimagesize($path);
            $meta['x'] = round($size[0]);
            $meta['y'] = round($size[1]);
        }
        if ($ext == 'wmv' && $meta['x'] == '') {
            $meta['x'] = round($fileinfo['asf']['video_media']['2']['image_width']);
            $meta['y'] = round(( $fileinfo['asf']['video_media']['2']['image_height'] ) + 60);
        }
        return $meta;
    }

    public function getFileDetails($file) {
        $browser = $this->getBrowser();
        $filesystem = $browser->getFileSystem();

        $data = array(
            'width' => '',
            'height' => '',
            'duration' => '--:--'
        );

        if ($filesystem->get('local')) {
            $path = WFUtility::makePath($filesystem->getBaseDir(), rawurldecode($file));

            if (preg_match('/\.(xml)/i', $file)) {
                $width = 160;
                $height = 120;
                $time = '--:--';
            } else {
                $meta = $this->id3Data($path);
                $width = preg_match('/[^0-9]/', $meta['x']) ? '' : $meta['x'];
                $height = preg_match('/[^0-9]/', $meta['y']) ? '' : $meta['y'];
                $time = preg_match('/([0-9]+):([0-9]+)/', $meta['time']) ? $meta['time'] : '--:--';
            }

            $data = array(
                'width' => $width,
                'height' => $height,
                'duration' => $time
            );
        }

        return $data;
    }

    public function getDimensions($file) {
        $browser = $this->getBrowser();
        $filesystem = $browser->getFileSystem();

        $width = '';
        $height = '';

        if ($filesystem->get('local')) {
            $path   = WFUtility::makePath($filesystem->getBaseDir(), rawurldecode($file));
            $ext    = JFile::getExt($path);

            switch($ext) {
                case 'mp3':
                    $width  = 200;
                    $height = 16;
                    break;
                case 'swf':
                    $data = @getimagesize($path);
                    
                    if ($data) {
                        $width  = $data[0];
                        $height = $data[1];
                    }
                    
                    break;
                default:
                    $meta = $this->id3Data($path);
                    
                    $width  = preg_match('/[^0-9]/', $meta['x']) ? '' : $meta['x'];
                    $height = preg_match('/[^0-9]/', $meta['y']) ? '' : $meta['y'];
                    
                    break;
            }
        }

        return array(
            'width' => $width,
            'height' => $height
        );
    }

    /**
     * Get a list of media extensions
     *
     * @access public
     * @param boolean	Map the extensions to media type
     * @return string	Extension list or type map
     */
    protected function getMediaTypes($map = false) {
        $extensions = $this->getParam('extensions', $this->get('_filetypes'));

        if ($map) {
            return $extensions;
        } else {
            $this->listFileTypes($extensions);
        }
    }

    protected function setMediaOption($name, $value) {
        $options = $this->get('_media_options');

        $options[$name] = $value;

        $this->set('_media_options', $options);
    }

    public function getMediaOptions() {
        $browser = $this->getBrowser();
        $list = $this->getParam('extensions', $this->get('_filetypes'));

        $options = '';

        if ($list) {
            foreach (explode(';', $list) as $type) {
                $kv = explode('=', $type);

                if (substr($kv[0], 0, 1) === '-') {
                    continue;
                }

                $options .= '<option value="' . $kv[0] . '">' . WFText::_('WF_MEDIAMANAGER_' . strtoupper($kv[0]) . '_TITLE') . '</option>' . "\n";
            }

            foreach ($this->get('_media_options') as $k => $v) {
                $options .= '<option value="' . $k . '">' . WFText::_($v, ucfirst($k)) . '</option>' . "\n";
            }
        }

        return $options;
    }

    protected function getViewable() {
        return $this->get('filetypes');
    }

    protected function getMediaPlayer() {
        static $mediaplayer;

        if (!is_object($mediaplayer)) {
            $mediaplayer = WFMediaPlayerExtension::getInstance($this->getParam('mediaplayer.name', 'jceplayer'));

            if ($mediaplayer->isEnabled()) {
                // get mediaplayer file types
                $types = $mediaplayer->getParam('extensions');

                if ($types) {
                    $browser = $this->getBrowser();
                    $browser->addFileTypes(array('mediaplayer' => $types));
                }

                $this->setMediaOption('mediaplayer', $mediaplayer->getTitle());
            }
        }

        return $mediaplayer;
    }

    /**
     * 
     * @return 
     */
    public function getMediaPlayerTemplate() {
        $tpl = '';

        $mediaplayer    = $this->getMediaPlayer();

        if ($mediaplayer->isEnabled()) {
            $tpl .= '<fieldset class="media_option mediaplayer"><legend>' . WFText::_($mediaplayer->getTitle()) . '</legend>';            
            $tpl .= $mediaplayer->loadTemplate();            
            $tpl .= '</fieldset>';
        }

        return $tpl;
    }

    protected function loadAggregators() {
        $extension = WFAggregatorExtension::getInstance(array('format' => 'video'));
        $extension->display();

        foreach ($extension->getAggregators() as $aggregator) {
            // set the Media Type option
            $this->setMediaOption($aggregator->getName(), $aggregator->getTitle());
        }
    }

    /**
     * 
     * @return 
     */
    public function getAggregatorTemplate() {
        $tpl = '';

        $extension = WFAggregatorExtension::getInstance();

        foreach ($extension->getAggregators() as $aggregator) {
            $tpl .= '<fieldset class="media_option ' . $aggregator->getName() . '" id="' . $aggregator->getName() . '_options" style="display:none;"><legend>' . WFText::_($aggregator->getTitle()) . '</legend>';
            $tpl .= $extension->loadTemplate($aggregator->getName());
            $tpl .= '</fieldset>';
        }

        return $tpl;
    }

    public function getSettings() {
        $params = $this->getParams();

        $settings = array(
            // Plugin parameters
            'media_types' => $this->get('filetypes', $this->get('_filetypes')),
            'defaults' => $this->getDefaults()
        );

        return parent::getSettings($settings);
    }

}

?>