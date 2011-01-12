<?php

/**
*
* $Id:Savant2_Plugin_overlib.php 81 2007-02-14 16:19:06Z mjaz $
* @author Johan Janssens <johan.janssens@users.sourceforge.net>
* @package Savant2
* @license http://www.gnu.org/copyleft/lesser.html LGPL
*
*/

require_once dirname(__FILE__) . DS.'Plugin.php';

class Savant2_Plugin_overlib extends Savant2_Plugin
{
    /**
    * Output necessary overlib tags
    *
    * @access public
    * @return string
    */

    function plugin()
    {
        ob_start();
        JHTML::_('behavior.tooltip');
        return ob_get_clean();
    }
}

