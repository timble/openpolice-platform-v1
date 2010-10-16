<?php

/**
* Outputs a tooltip.
*
* $Id: Savant2_Plugin_calendar.php 1262 2010-02-17 19:27:28Z mathias $
* @author Johan Janssens <johan.janssens@users.sourceforge.net>
* @package Savant2
* @license http://www.gnu.org/copyleft/lesser.html LGPL
*
*/

require_once dirname(__FILE__) . DS.'Plugin.php';

class Savant2_Plugin_calendar extends Savant2_Plugin
{
    function plugin()
    {
        DOCMAN_Compat::calendarJS();
    }
}

