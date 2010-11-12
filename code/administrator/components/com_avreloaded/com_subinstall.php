<?php
/**
 * @version		$Id: com_subinstall.php 1068 2009-05-02 17:07:10Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Include the actual subinstaller class
require_once dirname(__FILE__).'/subinstall.php';

/**
 * API entry point. Called from main installer.
 */
function com_install() {
    $si = new SubInstaller();
    $ret = $si->install();
    if ($ret) {
        // Install success. Joomla's module installer
        // creates an additional module instance during
        // upgrade. This seems to confuse users, so
        // let's remove that now.
        $minst =& JInstaller::getInstance();
        $db =& $minst->getDBO();
        $query = "SELECT COUNT(id) as n FROM #__modules WHERE module = 'mod_avreloaded'";
        $db->setQuery($query);
        $db->query();
        $n = $db->loadResult();
        if ($n > 1) {
            $query = "SELECT id FROM #__modules WHERE module = 'mod_avreloaded'".
                " AND title = 'AllVideos Reloaded' and published = 0 ORDER BY id DESC LIMIT 1";
            $db->setQuery($query);
            $db->query();
            $m = $db->loadResult();
            if ($m) {
                $query = 'DELETE FROM #__modules_menu WHERE moduleid = '.(int)$m;
                $db->setQuery($query);
                $db->query();
                $query = 'DELETE FROM #__modules WHERE id = '.(int)$m;
                $db->setQuery($query);
                $db->query();
            }
        }
    }
    $assets = JURI::root().'/administrator/components/com_avreloaded/assets/';
    $assetspath = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_avreloaded'.DS.'assets'.DS;
    $lang =& JFactory::getLanguage();
    $welcome = $assetspath.$lang->getTag().'.welcome.html';
    if (!file_exists($welcome)) {
        $welcome = $assetspath.'en-GB.welcome.html';
    }
    echo '<table width="100%"><tr><td><img src="'.$assets.'avreloaded-logo.png" alt="" /></td>'.
        '<td>'.file_get_contents($welcome).'</td></tr></table>';

    // Workaround for a silly behavior of Joomla's extension installer which issues warnings for
    // every skipped language file. Support experience showed that this scares off most newbies making
    // them think that the install went wrong.
    // We collect these messages and replace them by a single informational message.
    $app =& JFactory::getApplication();
    $name = JText::_($app->getName());
    $warnregex = JText::sprintf('INSTALLER LANG NOT INSTALLED',
        '([a-z][a-z]-[A-Z][A-Z]\..*?\.ini)', $name, '([a-z][a-z]-[A-Z][A-Z])');
    $oqueue =& $app->getMessageQueue();
    $nqueue = array();
    $lskipped = '';
    foreach ($oqueue as $msg) {
        if ($msg['type'] == 'notice') {
            $matches = array();
            if (preg_match('#'.$warnregex.'#', $msg['message'], $matches)) {
                if (count($matches) == 3) {
                    $ltag = $matches[2];
                    // failing to install en-GB is still serious
                    if ($ltag != 'en-GB') {
                        if (strpos($lskipped, $ltag) === false) {
                            if (!empty($lskipped)) {
                                $lskipped .= ', ';
                            }
                            $lskipped .= "'".$ltag."'";
                        }
                        continue;
                    }
                }
            }
        }
        $nqueue[] = $msg;
    }
    $app->_messageQueue = $nqueue;
    if (!empty($lskipped)) {
        $lskipped = preg_replace('#,( [^,]+)$#',' and$1', $lskipped);
        $app->enqueueMessage('Note: Language files for the languages '.$lskipped.' have been skipped.');
    }
}

/**
 * API entry point. Called from main installer.
 */
function com_uninstall() {
    $si = new SubInstaller();
    return $si->uninstall();
}
