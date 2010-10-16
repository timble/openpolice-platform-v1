<?php

/**
* Outputs a tooltip.
*
* $Id:Savant2_Plugin_tooltip.php 81 2007-02-14 16:19:06Z mjaz $
* @author Johan Janssens <johan.janssens@users.sourceforge.net>
* @package Savant2
* @license http://www.gnu.org/copyleft/lesser.html LGPL
*
*/

require_once dirname(__FILE__) .DS. 'Plugin.php';

class Savant2_Plugin_tooltip extends Savant2_Plugin
{
    /**
    * Output a tooltip
    *
    * @access public
    * @return string
    */

    function plugin($id, $title, $tooltip, $icon)
    {
        // Strip javascript
        $tooltip = preg_replace( '@<script[^>]*?>.*?</script>@si', '',  $tooltip );

        //Strip all whitespace around <TAGS>.
        $tooltip = preg_replace("/(\s+)?(\<.+\>)(\s+)?/", "$2",  $tooltip);

        // remove any \r's from windows
		$tooltip = str_replace ("\r", "", $tooltip);

		// replace remaining \n's with <br />
		$tooltip = str_replace ("\n", "<br /> ", $tooltip);

      	$image  = JURI::root(true).'/includes/js/ThemeOffice/tooltip.png';
       	$text   = '<img src="'. $image .'" border="0" alt="'. JText::_( 'Tooltip' ) .'"/>';
       	$style = 'style="text-decoration: none; color: #333;"';
        echo '<span class="editlinktip hasTip" title="'.$title.$tooltip.'" '. $style .'>'. $text .'</span>';
    }
}

