<?php
/**
 * @version		$Id: DOCMAN_button.class.php 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once($_DOCMAN->getPath('classes', 'params'));

/**
 * @abstract
 */
class DOCMAN_Button extends JObject {
    /**
     * @abstract string
     */
	var $name;

    /**
     * @abstract string
     */
    var $text;

    /**
     * @abstract string
     */
    var $link;

    /**
     * @abstract DMmosParameters Object
     */
    var $params;

    /**
     * @constructor
     */
    function __construct($name, $text, $link = '#', $params = null) 
    {
    	$this->name = $name;
        $this->text = $text;
        $this->link = $link;
        
        if(!is_object($params)) {
        	$this->params = new DMmosParameters('');
        } else {
        	$this->params = & $params;
        }
    }
}