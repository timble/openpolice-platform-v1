<?php
/**
 * @version   	$Id:koowa.php 251 2008-06-14 10:06:53Z mjaz $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 */

/**
 * Editlink filter, format "index.php?"
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Filters
 */
class NookuFilterEditlink extends KObject implements KFilterInterface
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
		return substr($var, 0, 10) == 'index.php?'
				&& strpos($var, 'option=com_') !== false
				&& false !== filter_var('http://dummy.com/'.$var, FILTER_VALIDATE_URL);
	}
	
	/**
	 * Sanitize a variable
	 *
	 * @param	mixed	Variable to be sanitized
	 * @return	string
	 */
	public function sanitize($var)
	{
		// the trick with dummy.com is a bit ugly, but it's easier to have php do all the hard work :-)
		$var =  substr(filter_var('http://dummy.com/'.$var, FILTER_SANITIZE_URL), 17);		
		if(substr($var, 0, 10) != 'index.php?' || strpos($var, 'option=com_') === false ) {
			// ntohing we can do if we don't have these essential elements
			return null;
		}
		return $var;
	}
}

