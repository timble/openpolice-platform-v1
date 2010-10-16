<?php
/**
 * DOCman 1.5.x - Joomla! Document Manager
 * @version $Id: dmtestplugin.php 1012 2009-12-05 14:43:24Z mathias $
 * @package dmtestplugin
 * @author Mathias Verraes
 * @copyright (C) 2003-2007 The DOCman Development Team
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.eu/ Official website
 **/
defined('_JEXEC') or die('Restricted access');

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import library dependencies
jimport('joomla.event.plugin');


class plgDocmanDmtestplugin extends JPlugin
{
    protected $handle;


   /**
    * Constructor
    *
    * For php4 compatability we must not use the __constructor as a constructor for
    * plugins because func_get_args ( void ) returns a copy of all passed arguments
    * NOT references.  This causes problems with cross-referencing necessary for the
    * observer design pattern.
    */
    function plgDocmanDmtestplugin(& $subject, $config) 
    {
            parent::__construct($subject, $config);

            // load plugin parameters
            $this->_plugin = & JPluginHelper::getPlugin( 'docman', 'dmtestplugin' );
            $this->_params = new JParameter( $this->_plugin->params );

            // file handle
            $this->handle = fopen(dirname(__FILE__).DS.'dmtestplugin.log', 'a');

            // uri
            jimport('joomla.environment.uri');
            $uri = JURI::getInstance()->toString();

            // write some data
            $this->write("Constructed dmtestplugin\n".date('c')."\n$uri\n");
    }

    /**
    * Plugin method with the same name as the event will be called automatically.
    */
    function onBeforeEditDocument() 
    {   
        $this->write("onBeforeEditDocument\n");
        return true;
    }
    
    function onFetchDocument() 
    {
        $this->write("onFetchDocument\n");
        return true;
    }
    
    function onAfterEditDocument()
    {
        $this->write("onAfterEditDocument\n");
        return true;
    }
    
    function onLogDelete()
    {
        $this->write("onLogDelete\n");
        return true;
    }
    
    function onLog()
    {
        $this->write("onLog\n");
        return true;
    }
    
    function onBeforeDownload()
    {
        $this->write("onBeforeDownload\n");
        return true;
    }
    
    function onAfterDownload()
    {
        $this->write("onAfterDownload\n");
        return true;
    }
    
    function onBeforeUpload()
    {
        $this->write("onBeforeUpload\n");
        return true;
    }
    
    function onAfterUpload()
    {
        $this->write("onAfterUpload\n");
        return true;
    }
    
    function onFetchButtons($doc)
    {
        global $_DOCMAN;
        $this->write("onFetchButtons\n");

        $params = new DMmosParameters('popup=1');
        $button =  new DOCMAN_Button('testbutton', 'Test Button', 'http://www.google.com', $params);
        return array($button);
    }

    protected function write($string){
    	fwrite($this->handle, $string);
    }

    public function __destruct() 
    {
        $this->write("Destructed dmtestplugin\n\n");
    	fclose($this->handle);
    }
}