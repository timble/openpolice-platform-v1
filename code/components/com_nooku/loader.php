<?php
/**
 * @version     $Id: loader.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Site
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * Register NookuLoader::loadClass() with SPL.
 */
spl_autoload_register(array('NookuLoader', 'loadClass'));

/**
 * Nooku Class Loader
 * 
 * Is capable of autoloading Nooku component classes based on a camelcased
 * classname that represents the directory structure.
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category	Nooku
 * @package     Nooku_Site
 */
class NookuLoader
{
	/**
     * Load the file for a class
     *
     * @param   string  $class  The class that will be loaded
     * @return  boolean True on success
     */
    public static function loadClass( $class )
    {   	
    	// pre-empt further searching for the named class or interface.
		// do not use autoload, because this method is registered with
		// spl_autoload already.
		if (class_exists($class, false) || interface_exists($class, false)) {
			return;
		}

		// if class start with a 'Nooku' it is a Nooku class.
		// create the path and register it with the loader.
		switch(substr($class, 0, 5))
		{
			case 'Nooku' :
			{
				$word  = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', substr_replace($class, '', 0, 5)));
				$parts = explode('_', $word);
				
				if(count($parts) > 1) {
					$path = KInflector::pluralize(array_shift($parts)).DS.implode(DS, $parts);
				} else {
					$path = $word;
				}
				
				if(is_file(dirname(__FILE__).DS.$path.'.php')) {
					KLoader::register($class,  dirname(__FILE__).DS.$path.'.php');
				} 
					
			} break;
		}

		$classes = KLoader::register();
        if(array_key_exists( strtolower($class), $classes)) {
            include($classes[strtolower($class)]);
            return true;
        }

        return false;
    }
}