<?php
/**
* @version      $Id:koowa.php 251 2008-06-14 10:06:53Z mjaz $
* @category		Koowa
* @package      Koowa_Filter
* @copyright    Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
* @license      GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.koowa.org
*/

/**
 * Ascii filter
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_Filter
 */
class KFilterAscii extends KObject implements KFilterInterface
{
	/**
	 * Validate a variable
	 * 
	 * Returns true if the string only contains US-ASCII
	 *
	 * @param	mixed	Variable to be validated
	 * @return	bool	True when the variable is valid
	 */
	public function validate($var)
	{
		return (preg_match('/(?:[^\x00-\x7F])/', $var) !== 1);
	}
	
	/**
	 * Transliterate all unicode characters to US-ASCII. The string must be 
	 * well-formed UTF8
	 * 
	 * @param	scalar	Variable to be sanitized
	 * @return	scalar
	 */
	public function sanitize($var)
	{
		$string = htmlentities(utf8_decode($var));
		$string = preg_replace(
			array('/&szlig;/','/&(..)lig;/', '/&([aouAOU])uml;/','/&(.)[^;]*;/'),
			array('ss',"$1","$1".'e',"$1"),
			$string);

		return $string;
	}
}