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
 * Command filter.
 *
 * A 'command' is a string containing only the characters [A-Za-z0-9.-_]. Used 
 * for names of views, controllers, etc 
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_Filter
 */
class KFilterCmd extends KObject implements KFilterInterface
{
	/**
	 * Validate a variable
	 *
	 * @param	mixed	Variable to be validated
	 * @return	bool	True when the variable is valid
	 */
	public function validate($var)
	{
		$var = trim($var);
	   	$pattern = '/^[A-Za-z0-9.\-_]*$/';
    	return (is_string($var) && (preg_match($pattern, $var)) == 1);
	}
	
	/**
	 * Sanitize a variable
	 *
	 * @param	mixed	Variable to be sanitized
	 * @return	string
	 */
	public function sanitize($var)
	{
		$var = trim($var);
		$pattern 	= '/[^A-Za-z0-9.\-_]*/';
    	return preg_replace($pattern, '', $var);
	}
}