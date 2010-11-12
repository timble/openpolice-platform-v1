<?php
/**
 * @version		$Id: avreloaded.php 1036 2008-07-11 12:24:18Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert All rights reserved.
 * @license		GNU/GPLv2
 */
defined('_JEXEC') or die("Direct Access Is Not Allowed");

/**
 * AllVideos Reloaded System Plugin
 *
 * @author     Fritz Elfert
 */
class plgSystemAvReloaded extends JPlugin {

    var $_plgloaded = false;

    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @access	protected
     * @param	object	$subject The object to observe
     * @param 	array   $config  An array that holds the plugin configuration
     */
    function plgSystemAvReloaded(& $subject, $config) {
        parent::__construct($subject, $config);
        $app =& JFactory::getApplication();
        // We want to handle frontend only
        if ($app->getClientId() === 0) {
            // Must load content plugin really early,
            // otherwise it mysteriously fails with fireboard
            if (JPluginHelper::importPlugin ('content', 'avreloaded')) {
                $this->_plgloaded = true;
            }
        }
    }

    /**
     * Adds our flash helper and our javascript
     * @access	public
     */
    function onAfterDispatch() {
        if (!$this->_plgloaded) {
            return;
        }
        $js_swf = 'swfobject.js';
        $js_avr = 'avreloaded.js';
        $js_wmv = 'wmvplayer.js';
        $base = 'plugins/content/avreloaded/';
        $cfg =& JFactory::getConfig();
        $debug = $cfg->getValue('config.debug');
        $konqcheck = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "konqueror");
        // If global debugging is enabled or the browser is konqueror,
        // we use uncompressed JavaScript
        if ($debug || $konqcheck) {
            $js_swf = 'swfobject-uncompressed.js';
            $js_avr = 'avreloaded-uncompressed.js';
            $js_wmv = 'wmvplayer-uncompressed.js';
        }
        JHTML::script('silverlight.js', $base);
        JHTML::script($js_wmv, $base);
        JHTML::script($js_swf, $base);
        JHTML::script($js_avr, $base);
    }

    /**
     * Calls the AllVideos Reloaded content plugin
     * in order to work on any remaining media tags.
     *
     * @access	public
     */
    function onAfterRender() {
        if (!$this->_plgloaded) {
            return;
        }
        $app =& JFactory::getApplication();
        $body = JResponse::getBody();
        // Perform tag replacement, only if not explicitely
        // disabled.
        if (strpos($body, '<!-- AVRSYS_DISABLE -->') > 0) {
            return;
        }
        $doc =& JFactory::getDocument();
        $stylefiles = count($doc->_styleSheets);
        $styledecl = (isset($doc->_style['text/css']))
            ? $doc->_style['text/css'] : '';
        $scrfiles = count($doc->_scripts);
        $oscript = (isset($doc->_script['text/javascript']))
            ? $doc->_script['text/javascript'] : '';
        $newbody = '';
        // Don't perform tag replacement inside of textareas or input elements
        // otherwise we might see videos in the editor and we don't want this.
        // Furthermore, we skip replacement inside <!-- AVRSKIP -->...<!-- /AVRSKIP -->
        $skipre = '#<textarea.*</textarea>|<input\s.*/>|<!--\s+AVRSKIP\s+-->.*<!--\s+/AVRSKIP\s+-->#Uis';
        $bits = preg_split($skipre, $body);
        $matches = null;
        preg_match_all($skipre, $body, $matches);
        foreach ($bits as $i => $bit) {
            $res = $app->triggerEvent('onAvReloadedGetVideo', array($bit));
            // There should be exacty ONE return value in the result, because
            // this is a custom event type!
            if (is_array($res) && (count($res) == 1)) {
                $newbody .= $res[0];
            } else {
                $newbody .= $bit;
            }
            if (isset($matches[0][$i])) {
                $newbody .= $matches[0][$i];
            }
        }
        if ($body != $newbody) {
            $body = $newbody;
            $hadd = $this->_handleHeaderAdditions($doc,
                $stylefiles, $styledecl, $scrfiles, $oscript);
            if (!empty($hadd)) {
                $body = str_replace('</head>', $hadd.'</head>', $body);
            }
            JResponse::setBody($body);
        }
        $this->_handlePopup($body);
    }

    /**
     * Post process body if this is our popup view
     */
    function _handlePopup($body) {
        if (strpos($body, '<!-- AVRSYS_IN_POPUP -->') > 0) {
            // Some templates (e.g. ja_purity) put margins around the doc, but
            // we don't want this in our popup, so remove any css links here.
            $body = preg_replace('#<link[^\>]*?rel="stylesheet"[^\>]*?\>#', '', $body);
            JResponse::setBody($body);
        }
    }

    /**
     * If stles or scripts have beed added by the content plugin,
     * generate the code needed for those additions.
     */
    function _handleHeaderAdditions(&$doc, $stylefiles, $ostyle, $scriptfiles, $oscript) {
        $lnEnd = $doc->_getLineEnd();
        $tab = $doc->_getTab();
        $tagEnd	= ' />';
        $ret = '';
        if (count($doc->_styleSheets) > $stylefiles) {
            $arr = array_slice($doc->_styleSheets, $stylefiles);
            // Generate stylesheet links
            foreach ($arr as $strSrc => $strAttr) {
                $ret .= $tab . '<link rel="stylesheet" href="'.$strSrc.'" type="'.$strAttr['mime'].'"';
                if (!is_null($strAttr['media'])){
                    $ret .= ' media="'.$strAttr['media'].'" ';
                }
                if ($temp = JArrayHelper::toString($strAttr['attribs'])) {
                    $ret .= ' '.$temp;;
                }
                $ret .= $tagEnd.$lnEnd;
            }
        }
        $nstyle = (isset($doc->_style['text/css']))
            ? $doc->_style['text/css'] : '';
        if ($nstyle != $ostyle) {
            if (!empty($ostyle)) {
                $nstyle = str_replace($ostyle, '', $nstyle);
            }
            // Generate stylesheet declarations
            $ret .= $tab.'<style type="text/css">'.$lnEnd;
            // This is for full XHTML support.
            if ($doc->_mime == 'text/html' ) {
                $ret .= $tab.$tab.'<!--'.$lnEnd;
            } else {
                $ret .= $tab.$tab.'<![CDATA['.$lnEnd;
            }
            $ret .= $nstyle . $lnEnd;
            // See above note
            if ($doc->_mime == 'text/html' ) {
                $ret .= $tab.$tab.'-->'.$lnEnd;
            } else {
                $ret .= $tab.$tab.']]>'.$lnEnd;
            }
            $ret .= $tab.'</style>'.$lnEnd;
        }
        if (count($doc->_scripts) > $scriptfiles) {
            $arr = array_slice($doc->_scripts, $scriptfiles);
            // Generate script file links
            foreach ($arr as $strSrc => $strType) {
                $ret .= $tab.'<script type="'.$strType.'" src="'.$strSrc.'"></script>'.$lnEnd;
            }
        }
        $nscript = (isset($doc->_script['text/javascript']))
            ? $doc->_script['text/javascript'] : '';
        if ($nscript != $oscript) {
            if (!empty($oscript)) {
                $nscript = str_replace($oscript, '', $nscript);
            }
            $ret .= $tab.'<script type="text/javascript">'.$lnEnd;
            // This is for full XHTML support.
            if ($doc->_mime != 'text/html' ) {
                $ret .= $tab.$tab.'<![CDATA['.$lnEnd;
            }
            $ret .= $nscript.$lnEnd;
            // See above note
            if ($doc->_mime != 'text/html' ) {
                $ret .= $tab.$tab.'// ]]>'.$lnEnd;
            }
            $ret .= $tab.'</script>'.$lnEnd;
        }
        return $ret;
    }
}

