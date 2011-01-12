<?php
/**
 * @version     $Id: defines.php 1144 2010-07-27 15:52:03Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * Nooku class
 *
 * Provides constants and metadata for Nooku such as version info
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @version     1.0
 */
class Nooku
{
    /**
     * Nooku version
     */
    const _VERSION = '0.6.8';

    /**
     * URL to the help screen
     */
    const HELP_URL          = 'http://docs.google.com/View?docid=dgpjh4fj_5cqs8whcd';

    /**
     * Nooku Node: Status = unknown
     */
    const STATUS_UNKNOWN    =  0;

    /**
     * Nooku Node: Status = completed
     */
    const STATUS_COMPLETED  =  1;

    /**
     * Nooku Node: Status = missing
     */
    const STATUS_MISSING    =  2;

    /**
     * Nooku Node: Status = outdated
     */
    const STATUS_OUTDATED   =  3;

    /**
     * Nooku Node: Status = pending
     */
    const STATUS_PENDING    =  4;

    /**
     * Get the version of Nooku
     */
    public static function getVersion()
    {
        return self::_VERSION;
    }

	/**
     * Get the URL to the folder containing all media assets
     *
     * @param string	$type	The type of URL to return, default 'media'
     * @return 	string	URL
     */
    public static function getURL($type = 'media')
    {
    	$url = '';

    	switch($type)
    	{
    		case 'media' :
    			$url = JURI::root(true).'/media/com_nooku/';
    			break;
    		case 'css' :
    			$url = JURI::root(true).'/media/com_nooku/css/';
    			break;
    		case 'images' :
    			$url = JURI::root(true).'/media/com_nooku/images/';
    			break;
    		case 'flags' :
    			$url = JURI::root(true).'/media/com_nooku/images/flags/';
    			break;
    		case 'js' :
    			$url = JURI::root(true).'/media/com_nooku/js/';
    			break;
    	}

    	return $url;
    }

	/**
     * Get the path to the folder containing all media assets
     *
     * @param 	string	$type	The type of path to return, default 'media'
     * @return 	string	Path
     */
    public static function getPath($type = 'media')
    {
    	$path = '';

    	switch($type)
    	{
    		case 'media' :
    			$path = JPATH_SITE.DS.'media'.DS.'com_nooku';
    			break;
    		case 'css' :
    			$path = JPATH_SITE.DS.'media'.DS.'com_nooku'.DS.'css';
    			break;
    		case 'images' :
    			$path = JPATH_SITE.DS.'media'.DS.'com_nooku'.DS.'images';
    			break;
    		case 'flags' :
    			$path = JPATH_SITE.DS.'media'.DS.'com_nooku'.DS.'images'.DS.'flags';
    			break;
    		case 'js' :
    			$path = JPATH_SITE.DS.'media'.DS.'com_nooku'.DS.'js';
    			break;
    	}

    	return $path;
    }
}