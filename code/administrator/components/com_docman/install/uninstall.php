<?php
/**
 * @version		$Id: uninstall.php 961 2009-10-27 15:57:30Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');

function com_uninstall() 
{
	$lang = JFactory::getLanguage();
	$lang->load('com_installer');

    DMInstallHelper::removeFiles();
    DMInstallHelper::deleteFromDb();

    // if there's no more data, we remove the tables
    if( DMInstallHelper::cntDbRecords() == 0 ) {
        DMInstallHelper::removeTables();
    }

    // delete the data folder if it's empty
    if ( DMInstallHelper::cntFiles() == 0 ) {
    	DMInstallHelper::removeDmdocuments();
    }
}