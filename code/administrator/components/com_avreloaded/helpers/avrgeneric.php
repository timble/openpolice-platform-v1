<?php
/**
 * @version		$Id: avrgeneric.php 1027 2008-07-06 22:46:07Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.filesystem.path');
jimport('joomla.plugin.helper');
jimport('joomla.application.component.helper');

class AvrGenericHelper {

    /**
     * Helper function for enqueuing a message, used for PHP4 compatibility
     * (PHP4 cannot cope with constructs like this:
     * JFactory::getApplication()->enqueueMessage(...);
     */
    function qmsg($msg, $type = 'message') {
        $app =& JFactory::getApplication();
        $app->enqueueMessage($msg, $type);
    }

    /**
     * Helper function for addin a script-declaration used for PHP4 compatibility
     * (PHP4 cannot cope with constructs like this:
     * JFactory::getDocument()->addScriptDeclaration(...);
     */
    function addJS($content, $type = 'text/javascript') {
        $doc =& JFactory::getDocument();
        $doc->addScriptDeclaration($content, $type);
    }

    /**
     * Helper function for addin a style-declaration used for PHP4 compatibility
     * (PHP4 cannot cope with constructs like this:
     * JFactory::getDocument()->addStyleDeclaration(...);
     */
    function addCSS($content, $type = 'text/css') {
        $doc =& JFactory::getDocument();
        $doc->addStyleDeclaration($content, $type);
    }

    function getVdir() {
        $mparams =& JComponentHelper::getParams('com_media');
        $mdir = JPATH_ROOT.DS.$mparams->get('image_path', 'images'.DS.'stories');
        $plg =& JPluginHelper::getPlugin('content', 'avreloaded');
        $pparams = new JParameter($plg->params);
        $vdir = $pparams->get('vdir', 'videos');
        if (JString::strpos($vdir, '/') === 0) {
            $vdir = JPATH_ROOT.$vdir;
        } else {
            $vdir = $mdir.DS.$vdir;
        }
        return JPath::clean($vdir);
    }

    function getAdir() {
        $mparams =& JComponentHelper::getParams('com_media');
        $mdir = JPATH_ROOT.DS.$mparams->get('image_path', 'images'.DS.'stories');
        $plg =& JPluginHelper::getPlugin('content', 'avreloaded');
        $pparams = new JParameter($plg->params);
        $adir = $pparams->get('adir', 'audio');
        if (JString::strpos($adir, '/') === 0) {
            $adir = JPATH_ROOT.$adir;
        } else {
            $adir = $mdir.DS.$adir;
        }
        return JPath::clean($adir);
    }

    function rootURI($full = false) {
        // Workaround for an inconsistent behavior of JURI::root():
        // It returns with a trailing slash, when called with default (false),
        // but without a trailing slash if called with true.
        // We return *without* a trailing slash *always*
        return rtrim(JURI::root($full), '/');
    }

    function getVloc($full = false) {
        $mparams =& JComponentHelper::getParams('com_media');
        $mloc = AvrGenericHelper::rootURI($full).'/'.$mparams->get('image_path', 'images'.DS.'stories');
        $plg =& JPluginHelper::getPlugin('content', 'avreloaded');
        $pparams = new JParameter($plg->params);
        $vloc = $pparams->get('vdir', 'videos');
        if (JString::strpos($vloc, '/') === 0) {
            $vloc = AvrGenericHelper::rootURI($full).$vloc;
        } else {
            $vloc = $mloc.'/'.$vloc;
        }
        return $vloc;
    }

    function getAloc($full = false) {
        $mparams =& JComponentHelper::getParams('com_media');
        $mloc = AvrGenericHelper::rootURI($full).'/'.$mparams->get('image_path', 'images'.DS.'stories');
        $plg =& JPluginHelper::getPlugin('content', 'avreloaded');
        $pparams = new JParameter($plg->params);
        $aloc = $pparams->get('adir', 'audio');
        if (JString::strpos($aloc, '/') === 0) {
            $aloc = AvrGenericHelper::rootURI($full).$aloc;
        } else {
            $aloc = $mloc.'/'.$aloc;
        }
        return $aloc;
    }

    /**
     * Helper function for emulating htmlspecialchars_decode
     * on PHP4.
     *
     * @param string The string to decode.
     * @return The decoded string.
     * @access private
     */
    function htsdecode($string) {
        if (function_exists('htmlspecialchars_decode')) {
            return htmlspecialchars_decode($string);
        } else {
            return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
        }
    }
}
