<?php
/**
 * @version		$Id: DOCMAN_theme.class.php 1266 2010-02-21 11:59:15Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
* Savant2 needs the PATH_SEPARATOR
*/

if (!defined('PATH_SEPARATOR')) {
    define('PATH_SEPARATOR', substr(PHP_OS, 0, 3) == 'WIN' ? ';' : ':');
}

/**
* Permission constants.
*/

define('DM_TPL_NOT_LOGGED_IN', -1);
define('DM_TPL_NOT_AUTHORIZED', 0);
define('DM_TPL_AUTHORIZED', 1);

$savant_path = $_DOCMAN->getPath('contrib', 'savant2');
include_once($savant_path . "Savant2.php");

class DOCMAN_Theme extends Savant2
{
    /** @var string The name of the active theme */
    var $name = null;

    /** @var string The absolute theme path  */
    var $path = null;

     /** @var object An object of configuartion variables  */
    var $theme = null;

    function DOCMAN_theme()
    {
        global $_DOCMAN, $savant_path;

        $this->name = $_DOCMAN->getCfg('icon_theme');
        if(!$this->name) {
        	throw new Exception('Theme name not found');
        }
        $this->path = $_DOCMAN->getPath('themes', $this->name);

        $conf = array();
        $conf['template_path'] = $this->path . "templates".DS;
        $conf['resource_path'] = $savant_path . "Savant2".DS;

        parent::Savant2($conf);

        //set the theme variables
		$this->_setConfig();

		//set the language
		$this->_setLanguage();

    }

    function _setConfig()
    {
    	global $_DOCMAN;

    	// Get the configuartion object
    	require_once $this->path.'themeConfig.php';

        $this->setError('docman');

        $theme = new StdClass();
        $theme->conf = new themeConfig();
        $theme->name = $this->name;
    	if(!$this->name) {
        	throw new Exception('Theme name not found');
        }
        $theme->path = $_DOCMAN->getPath('themes', $this->name, 1);
        $theme->icon = DOCMAN_Utils::pathIcon(null, 1);
        $theme->png  = DOCMAN_Utils::supportPng();

        $this->theme = &$theme;
    }

    function _setLanguage()
    {
    	$mainframe = JFactory::getApplication();
    	$lang =& JFactory::getLanguage();
		$lang =$lang->getBackwardLang();

		// Get the right language if it exists
		if (file_exists($this->path.'language'.DS.$lang.'.php')) {
    		include_once ($this->path.'language'.DS.$lang.'.php');
		} else {
    		include_once ($this->path.'language'.DS.'english.php');
		}
    }

}