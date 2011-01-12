<?php

/**
* Sets the page title.
*
* $Id:Savant2_Plugin_pagetitle.php 81 2007-02-14 16:19:06Z mjaz $
* @author Johan Janssens <johan.janssens@users.sourceforge.net>
* @package Savant2
* @license http://www.gnu.org/copyleft/lesser.html LGPL
*
*/

require_once dirname(__FILE__) . DS.'Plugin.php';

class Savant2_Plugin_pagetitle extends Savant2_Plugin
{
    /**
    * Sets the page title.
    *
    * @access public
    * @return string
    */

    function plugin($title)
    {
        $mainframe = JFactory::getApplication();
        $mainframe->setPageTitle($title);
        return;
    }
}
