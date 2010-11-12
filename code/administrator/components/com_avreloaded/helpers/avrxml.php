<?php
/**
* @version		$Id: avrxml.php 965 2008-06-15 14:31:10Z Fritz Elfert $
* @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
* @license		GNU/GPLv2
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.utilities.simplexml');

/**
 * A slightly enhanced version of JSimpleXML which allows
 * to have colons in element names
 */
class AvrXML extends JSimpleXML {

    var $_efname = null;

     /**
      * Constructor.
      *                   
      * @access protected
      */
    function __construct($options = null) {
        parent::__construct($options);
    }

	 /**
	 * Interprets an XML file into an object
	 *
	 * This function will convert the well-formed XML document in the file specified by filename
	 * to an object  of class JSimpleXMLElement. If any errors occur during file access or
	 * interpretation, the function returns FALSE.
	 *
	 * @param string  Path to xml file containing a well-formed XML document
	 * @param string  currently ignored
	 * @return boolean True if successful, false if file empty
	 */
	function loadFile($path, $classname = null) {
		//Check to see of the path exists
		if (!file_exists($path)) {
			return false;
		}
		//Get the XML document loaded into a variable
		$xml = trim(file_get_contents($path));
		if ($xml == '') {
			return false;
		} else {
            $xml =
                "<!DOCTYPE playlist [\n".
                "<!ENTITY nbsp \"&#xA0;\">\n".
                "]>\n".
                $xml;
            $this->_efname = basename($path);
			$this->_parse($xml);
			return true;
		}
	}

	/**
	 * Handles an XML parsing error
	 *
	 * @access protected
	 * @param int $code XML Error Code
	 * @param int $line Line on which the error happened
	 * @param int $col Column on which the error happened
	 */
	function _handleError($code, $line, $col)
    {
        $fn = $this->_efname;
        if (null == $fn) {
            $fn = 'internal stream';
        }
        JError::raiseWarning('SOME_ERROR_CODE', 'XML Parsing Error in '.$fn.
            ' at '.$line.':'.$col.'. Error '.$code.': '.xml_error_string($code));
	}

	/**
	 * Handler function for the start of a tag
	 *
	 * @access protected
	 * @param resource $parser
	 * @param string $name
	 * @param array $attrs
	 */
	function _startElement($parser, $name, $attrs = array()) {
        parent::_startElement($parser, str_replace(':', '_0x3a', $name), $attrs);
    }

	/**
	 * Handler function for the character data within a tag
	 *
	 * @access protected
	 * @param resource $parser
	 * @param string $data
	 */
	function _characterData($parser, $data) {
		//Get the reference to the current parent object
		$tag = $this->_getStackLocation();
		//Assign data to it
		eval('$this->'.$tag.'->_data .= "$data";');
	}
}

class AvrXMLElement extends JSimpleXMLElement {
	/**
	 * Constructor, sets up all the default values
	 *
	 * @param string $name
	 * @param array $attrs
	 * @param int $parents
	 * @return JSimpleXMLElement
	 */
	function __construct($name, $attrs = array(), $level = 0)
	{
        parent::__construct($name, $attrs, $level);
	}

	/**
	 * Get the name of the element
	 *
	 * @access public
	 * @return string
	 */
	function name() {
        return str_replace('_0x3a', ':', $this->_name);
	}

	/**
	 * Get an element in the document by / separated path
	 *
	 * @param	string	$path	The / separated path to the element
	 * @return	object	JSimpleXMLElement
	 */
    function &getElementByPath($path) {
        return parent::getElementByPath(str_replace(':', '_0x3a', $path));
    }

	/**
	 * Return a well-formed XML string based on SimpleXML element
	 *
	 * @return string
	 */
    function toString($whitespace=true) {
        $ret = str_replace('_0x3a', ':', parent::toString($whitespace));
        $ret = str_replace("\xC2\xA0", '&nbsp;', $ret);
        // Workaround for a bug in JW Media Player
        return str_replace(array('<tracklist>','</tracklist>'),
            array('<trackList>','</trackList>'), $ret);
    }
}
