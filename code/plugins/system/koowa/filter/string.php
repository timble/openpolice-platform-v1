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
 * String filter
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_Filter
 */
class KFilterString extends KObject implements KFilterInterface
{
	/**
	 * Validate a variable
	 * 
	 * NOTE: This should always be a simple yes/no question (is $var valid?), so 
	 * only true or false should be returned.
	 *
	 * @param	mixed	Variable to be validated
	 * @return	bool	True when the variable is valid
	 */
	public function validate($var)
	{
		$options = array('tag_method' => false, 'attribute_method' => false);
		$html = KFactory::tmp('lib.koowa.filter.html', $options);
		
		return $html->validate($var);
	}
	
	/**
	 * Sanitize a variable
	 *
	 * @param	mixed	Variable to be sanitized
	 * @return	string
	 */
	public function sanitize($var)
	{
		$options = array('tag_method' => false, 'attribute_method' => false);
		$html = KFactory::tmp('lib.koowa.filter.html', $options);
		
		return (string) $html->sanitize($var);
	}
}

