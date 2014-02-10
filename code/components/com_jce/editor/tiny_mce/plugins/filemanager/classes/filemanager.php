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
// Set flag that this is an extension parent
if (!defined('_WF_EXT')) {
    define('_WF_EXT', 1);
}

wfimport('editor.libraries.classes.manager');
wfimport('editor.libraries.classes.extensions.popups');

class WFFileManagerPlugin extends WFMediaManager {
    /*
     * @var string
     */

    var $_filetypes = 'acrobat=pdf;office=doc,docx,ppt,xls,xlsx;image=gif,jpeg,jpg,png;archive=zip,tar,gz;video=swf,mov,wmv,avi,flv,mp4,ogv,ogg,webm,mpeg,mpg;audio=wav,mp3,ogg,webm,aiff;openoffice=odt,odg,odp,ods,odf';

    public function __construct() {
        parent::__construct();

        $request = WFRequest::getInstance();
        $request->setRequest(array($this, 'getFileDetails'));
        
        $browser = $this->getBrowser();
        $browser->addEvent('onUpload', array($this, 'onUpload'));
    }

    /**
     * Display the plugin
     */
    public function display() {
        parent::display();

        $document = WFDocument::getInstance();

        $tabs = WFTabs::getInstance(array('base_path' => WF_EDITOR_PLUGIN));
        // Add tabs
        $tabs->addTab('file');
        $tabs->addTab('advanced');

        // Load Popups instance
        $popups = WFPopupsExtension::getInstance(array(
            'text' => false,
            'default'   => $this->getParam('filemanager.popups.default', '')
        ));

        $popups->addTemplate('popup');
        $popups->display();
        
        $document->addScript(array('filemanager'), 'plugins');
        $document->addStyleSheet(array('filemanager'), 'plugins');

        $document->addScriptDeclaration('FileManager.settings=' . json_encode($this->getSettings()) . ';');
    }

    protected function getIconMap() {
        jimport('joomla.filesystem.folder');

        $path       = $this->getParam('filemanager.icon_path', 'media/jce/icons');
        $format     = $this->getParam('filemanager.icon_format', '{$name}.png');
        $extensions = $this->getParam('extensions', $this->get('_filetypes'));

        if (strpos($path, 'http') !== false) {
            return $extensions;
        }

        // get extension from format
        $ext = JFile::getExt($format);
        // get all matched icons
        $icons = JFolder::files(JPATH_SITE . '/' . $path, '\.' . $ext);

        if ($icons) {
            for ($i = 0; $i < count($icons); $i++) {
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
        foreach (explode(';', $extensions) as $group) {
            // only if valid extensions group	
            if (substr($group, 0, 1) === '-') {
                continue;
            }

            // remove extensions that are disabled
            $group = preg_replace('#(,)?-([\w]+)#', '', $group);

            // get the groups parts eg: image, 'jpg,jpeg,png,gif'			
            $parts = explode('=', $group);

            $key = $parts[0];
            $values = explode(',', $parts[1]);

            foreach (array_diff($values, $icons) as $item) {
                $map[$item] = $key;
            }

            foreach (array_intersect($values, $icons) as $item) {
                $map[$item] = $item;
            }
        }

        return $map;
    }
    
    public function onUpload($file, $relative = '', $method = '') {
        // get method (with bc check)
        if (empty($method)) {
            $method = JRequest::getWord('method', '');
        }

        // dialog/form upload
        if ($method == 'inline' || $method == 'dragdrop') {
            $result = array(
                'file' => empty($relative) ? substr($file, strlen(JPATH_SITE) + 1) : $relative,
                'name' => basename($file)
            );

            if ($this->getParam('filemanager.googledocs_enable', 1) && $this->getParam('filemanager.googledocs_type', '')) {
                $google = $this->getParam('filemanager.googledocs_type', '');
                
                $result['googledocs'] = 'link';
                
                // add embedded flag
                if ($google == 'embed') {
                    $result['width']    = $this->getParam('filemanager.googledocs_width', '100%');
                    $result['height']   = $this->getParam('filemanager.googledocs_height', '100%');
                    
                    $result['googledocs'] = 'embedded';
                    
                    return $result;
                }
            }
            
            $defaults = $this->getDefaults();
            $features = array();

            // add icon first
            if ($defaults['option_icon_check']) {
                jimport('joomla.filesystem.file');
                $ext    = JFile::getExt(basename($file));
                $map    = $this->getIconMap();
                
                $icon   = str_replace('{$name}', $map[$ext], $this->getParam('filemanager.icon_format', '{$name}.png')); 
                $icon   = $this->getParam('filemanager.icon_path', 'media/jce/icons') . '/' . $icon;

                $features[] = array('node' => 'img', 'attribs' => array('src' => $icon, 'alt' => basename($icon), 'class' => 'wf_file_icon'));
            }
            // add text
            $features[] = array('node' => 'span', 'attribs' => array('class' => 'wf_file_text'), 'html' => basename($file));

            foreach ($defaults as $k => $v) {
                switch ($k) {
                    case 'classes':
                    case 'title':
                    case 'id':
                    case 'direction':
                    case 'hreflang':
                    case 'lang':
                    case 'style':
                    case 'charset':
                    case 'rel':
                    case 'rev':
                    case 'tabindex':
                    case 'accesskey':
                    case 'target':
                        if ($k == 'direction') {
                            $k = 'dir';
                        }
                        
                        if ($k == 'classes') {
                            $k = 'class';
                        }
                        
                        if ($v != '') {
                            $result[$k] = $v;
                        }
                        break;
                    case 'option_size_check':
                        if ($v) {
                            $features[] = array('node' => 'span', 'attribs' => array('class' => 'wf_file_size', 'style' => 'margin-left:5px;'), 'html' => WFUtility::formatSize(filesize($file)));
                        }
                        break;
                    case 'option_date_check':
                        if ($v) {
                            $features[] = array('node' => 'span', 'attribs' => array('class' => 'wf_file_date', 'style' => 'margin-left:5px;'), 'html' => WFUtility::formatDate(filemtime($file), $this->getParam('filemanager.date_format', '%d/%m/%Y, %H:%M')));
                        }
                        break;
                }
            }

            if (!empty($features)) {
                $result['features'] = $features;
            }

            return $result;
        }

        return array();
    }

    public function getFileDetails($file) {
        $browser = $this->getBrowser();

        $filesystem = $browser->getFileSystem();
        // get array with folder date and content count eg: array('date'=>'00-00-000', 'folders'=>1, 'files'=>2);
        $details = $filesystem->getFileDetails($file);

        $data = array('size' => WFUtility::formatSize($details['size']), 'date' => WFUtility::formatDate($details['modified'], $this->getParam('filemanager.date_format', '%d/%m/%Y, %H:%M')));

        return $data;
    }

    public function getSettings($settings = array()) {
        $settings = array(
            'icon_map' => $this->getIconMap(),
            'icon_path' => $this->getParam('filemanager.icon_path', 'media/jce/icons'),
            'icon_format' => $this->getParam('filemanager.icon_format', '{$name}.png'),
            'date_format' => $this->getParam('filemanager.date_format', '%d/%m/%Y, %H:%M'),
            'text_alert' => $this->getParam('filemanager.text_alert', 1),
            'replace_text' => $this->getParam('filemanager.replace_text', 1),
            'googledocs' => array(
                'enable'    => $this->getParam('filemanager.googledocs_enable', 1),
                'type'      => $this->getParam('filemanager.googledocs_type', ''),
                'width'     => $this->getParam('filemanager.googledocs_width', '100%'),
                'height'    => $this->getParam('filemanager.googledocs_height', '100%')
            )
        );

        return parent::getSettings($settings);
    }

}

?>
