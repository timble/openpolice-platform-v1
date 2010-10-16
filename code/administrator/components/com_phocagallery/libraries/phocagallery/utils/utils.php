<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class PhocaGalleryUtils
{
	
	function htmlToRgb($clr) {
		if ($clr[0] == '#') {
			$clr = substr($clr, 1);
		}
		
		if (strlen($clr) == 6) {
			list($r, $g, $b) = array($clr[0].$clr[1],$clr[2].$clr[3],$clr[4].$clr[5]);
		} else if (strlen($clr) == 3) {
			list($r, $g, $b) = array($clr[0].$clr[0], $clr[1].$clr[1], $clr[2].$clr[2]);
		} else {
			$r = $g = $b = 255;
		}

		$color[0] = hexdec($r);
		$color[1] = hexdec($g);
		$color[2] = hexdec($b);

		return $color;
	}
	
	/*
	 * Source: http://php.net/manual/en/function.ini-get.php
	 */
	function iniGetBool($a) {
		$b = ini_get($a);
		switch (strtolower($b)) {
			case 'on':
			case 'yes':
			case 'true':
			return 'assert.active' !== $a;

			case 'stdout':
			case 'stderr':
			return 'display_errors' === $a;

			default:
			return (bool) (int) $b;
		}
	}
	
	function setQuestionmarkOrAmp($url) {
		$isThereQMR = false;
		$isThereQMR = preg_match("/\?/i", $url);
		if ($isThereQMR) {
			return '&amp;';
		} else {
			return '?';
		}
	}
}
?>