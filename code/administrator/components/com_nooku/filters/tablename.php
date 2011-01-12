<?php
/**
 * @version		$Id: tablename.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Tablename filter
 * 
 * Not meant for table names in general, only for specific nooku use. 
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Filters
 */
class NookuFilterTablename extends KObject implements KFilterInterface
{
	/**
	 * Validate a variable
	 *
	 * @param	mixed	Variable to be validated
	 * @return	bool	True when the variable is valid
	 */
	public function validate($var)
	{
		if(strlen($var) > 64) {
			return false;
		}
		
		// TODO do a proper filter for tablenames in nooku
	   	return KFactory::get('lib.koowa.filter.cmd')->validate($var);
	}
	
	/**
	 * Sanitize a variable
	 *
	 * @param	mixed	Variable to be sanitized
	 * @return	string
	 */
	public function sanitize($var)
	{
		// TODO do a proper filter for tablenames in nooku
    	return substr(KFactory::get('lib.koowa.filter.cmd')->sanitize($var), 0, 64);
	}
}