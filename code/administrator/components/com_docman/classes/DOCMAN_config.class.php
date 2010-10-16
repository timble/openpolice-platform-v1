<?php
/**
 * @version		$Id: DOCMAN_config.class.php 1112 2010-01-11 15:39:31Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

class DOCMAN_Config 
{
	
    /**
    * *
    *
    * @var string The path to the configuaration file
    */
    var $_path = null;

    /**
    * *
    *
    * @var string The name of the configuaration class
    */
    var $_name = null;

    /**
    * *
    *
    * @var object An object of configuration variables
    */
    var $_config = null;

    function DOCMAN_Config($name, $path)
    {
        $this->_path = $path;
        $this->_name = $name;
        $this->_loadConfig();
    }

    /**
    *
    * @param string $ The name of the variable
    * @return mixed The value of the configuration variable or null if not found
    */
    function getCfg($varname , $default = null)
    {
        if (isset($this->_config->$varname)) {
            return $this->_config->$varname;
        } else {
            if (! is_null($default)) {
                $this->_config->$varname = $default;
            }
            return $default;
        }
    }

    /**
    *
    * @param string $ The name of the variable
    * @param string $ The new value of the variable
    * @return bool True if succeeded, otherwise false.
    */
    function setCfg($varname, $value, $create = false)
    {
        if ($create || isset($this->_config->$varname)) {
            $this->_config->$varname = $value;
            return true;
        } else {
            return false;
        }
    }

    /**
    * Loads the configuration file and creates a new class
    */
    function _loadConfig()
    {
        if (file_exists($this->_path)) {
            require_once($this->_path);
            if( class_exists($this->_name)) {
                $this->_config = new $this->_name();
            } else {
            	$this->_config = new StdClass();
            }
        } else {
            $this->_config = new StdClass();
        }
    }

    /**
    * Saves the configuration object
    */
    function saveConfig()
    {
        $my = JFactory::getUser();

        $this->check();

        $config = "<?php\n";
        $config .= "if(defined('_" . $this->_name . "')) {\nreturn true;\n} else { \ndefine('_" . $this->_name . "',1); \n\n";
        $config .= "class " . $this->_name . "\n{\n";

        $vars = get_object_vars($this->_config);
        ksort($vars);
        foreach($vars as $key => $value) {
            $config .= 'var $' . $key . ' = ' . var_export($value , true) . ";\n" ;
        }

        $config .= "}\n}";


        if ($fp = @fopen($this->_path, "w")) {
            if( fputs($fp, $config) !== false AND fclose($fp) !==false) {
                return true;
            }
        }

        return false;
    }

    function check()
    {
        /**
         * Handle single and double quotes
         */
    	$search  = array( "\'", '\"' );
        $replace = array( "'", '"' );

        $vars = get_object_vars($this->_config);
        foreach( $vars as $key=>$var ) {
            $this->_config->$key = str_replace( $search, $replace, $var );
        }


        return true;
    }
}