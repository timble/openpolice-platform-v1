<?php
/**
 * @version		$Id: default.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package		Koowa_View
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.koowa.org
 */

 /**
 * Default template stream wrapper
 * 
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category	Koowa
 * @package		Koowa_Template
 */
 
class KTemplateDefault extends KTemplateAbstract
{
   /**
     * Register the stream wrapper 
     * 
     * Function prevents from registering the wrapper twice
     */
	public static function register()
	{	
		if (!in_array('tmpl', stream_get_wrappers())) {
			stream_wrapper_register('tmpl', __CLASS__);
		}
    } 
}