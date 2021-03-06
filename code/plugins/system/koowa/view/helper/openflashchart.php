<?php
/**
 * @version     $Id:openflashchart.php 251 2008-06-14 10:06:53Z mjaz $
 * @category	Koowa
 * @package     Koowa_View
 * @subpackage 	Helper
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomlatools.org
 */

/**
 * Open Flash Chart HTML helper
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_View
 * @subpackage 	Helper
 */
class KViewHelperOpenflashchart
{
    /**
     * Renders the <object> tag for Open Flash Chart
     *
     * @param string	Data Url
     * @param string	Unique ID
     * @param string	SWF file url
     * @param string	Width (px, %)
     * @param string	Height (px, %)
     * @param string	Background color
     * @param string	Attributes for the surrounding <div>
     */
    public static function swfobject( $dataUrl, $id, $swfUrl = null, $width = '100%', $height = '450px', $bgcolor = '#FFFFFF', $divAttr = '')
    {
    	$swfUrl = $swfUrl ? $swfUrl : Koowa::getURL('media').'swf/open-flash-chart.swf';
		return KChartOpenflashchart::renderSwfobject( $dataUrl, $id, $swfUrl, $width, $height, $bgcolor, $divAttr);
    }

}