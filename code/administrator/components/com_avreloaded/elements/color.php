<?php
/**
 * @version		$Id: color.php 1031 2008-07-07 22:32:15Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_avreloaded'.DS.'helpers'.DS.'avrgeneric.php');

/**
 * Renders a color element with a mooRainbow color picker attached.
 *
 * @author Fritz Elfert <fritz@fritz-elfert.de>
 */

class JElementColor extends JElement
{
    /**
     * Element name
     *
     * @access	protected
     * @var		string
     */
    var	$_name = 'Color';

    function fetchElement($name, $value, &$node, $control_name) {
        static $once;

        $assets = 'administrator/components/com_avreloaded/assets/';
        $assetsuri = JURI::root().'administrator/components/com_avreloaded/assets/';
        $js_mor = 'mooRainbow.js';
        $cfg =& JFactory::getConfig();
        $debug = $cfg->getValue('config.debug');
        $konqcheck = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "konqueror");
        // If global debugging is enabled or the browser is konqueror,
        // we use uncompressed JavaScript
        if ($debug || $konqcheck) {
            $js_mor = 'mooRainbow-uncompressed.js';
        }
        JHTML::script($js_mor, $assets);
        JHTML::stylesheet('mooRainbow.css', $assets);
        if (!$once) {
            $once = true;
            $js = "window.addEvent('domready', function() {\n".
                "    var r = new MooRainbow('none', {align:'tl',okLabel:'".JText::_('LBL_SELECT', true).
                "',wheel:true,imgPath:'".$assetsuri."'});\n".
                "    $$('.rainbow').each(function(el) {\n".
                "        el.setStyle('cursor', 'pointer');\n".
                "        el.addEvent('click', function(e) { new Event(e).stop(); r.reAttachAndShow(el); }.bind(r));\n".
                "    });\n".
                "});\n";
            $style = '.moor-cursor{background-image:url('.$assetsuri.'moor_cursor.gif);} '. 
                '.moor-arrows{background-image:url('.$assetsuri.'moor_arrows.gif);} '; 
            AvrGenericHelper::addJS($js);
            AvrGenericHelper::addCSS($style);
        }
        $size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
        $class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"' );
        /*
         * Required to avoid a cycle of encoding &
         * html_entity_decode was used in place of htmlspecialchars_decode because
         * htmlspecialchars_decode is not compatible with PHP 4
         */
        $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);
        $elem = '<div>'.
            '<img src="'.$assetsuri.'rainbow.png" class="rainbow" '.
            'style="vertical-align:middle;margin-right:5px;" rel="'.$control_name.$name.
            '" alt="" /><input type="text" name="'.
            $control_name.'['.$name.']" id="'.$control_name.$name.
            '" value="'.$value.'" '.$class.' '.$size.' /></div>';
        return $elem;
    }
}
