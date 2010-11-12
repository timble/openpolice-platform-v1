<?php
/*
 * $Id: avreloaded.php.in 1054 2008-07-21 20:50:17Z Fritz Elfert $
 *
 * AllVideos Reloaded for Joomla! 1.5
 *
 * Author: Fritz Elfert
 * Copyright 2007 by Fritz Elfert
 *
 * Inspired by and partially based on:
 *
 *   The "AllVideos" Plugin for Joomla 1.0.x - Version 2.4
 *   Authors: Fotis Evangelou - George Chouliaras
 *   Copyright (c) 2006 JoomlaWorks.gr - http://www.joomlaworks.gr
 */

defined('_JEXEC') or die("Direct Access Is Not Allowed");
jimport('joomla.plugin.plugin');

class plgContentAvreloaded extends JPlugin {

    var $_version = '1.2.4';
    var $_rev = '$Revision: 1054 $';
    // Our standard header
    var $_beg = "<!-- AllVideos Reloaded Plugin (%s) starts here\n-->!!WARN_JS!!<%s id=\"@DIVID@\"%s class=\"%s\">!!WARN_FL1!!</%s>";
    // Our standard trailer
    var $_end = "!!WARN_FL2!!<!--\nAllVideos Reloaded Plugin (%s) ends here -->";
    // The height of the builtin player's controls
    var $_ctrlheight = 20;
    // "Web" color names as specified by HTML 4.01
    var $_w3colors = array(
        'aqua'    => 0x00ffff,
        'black'   => 0,
        'blue'    => 0xff,
        'fuchsia' => 0xff00ff,
        'green'   => 0x8000,
        'grey'    => 0x808080,
        'lime'    => 0xff00,
        'maroon'  => 0x800000,
        'navy'    => 0x80,
        'olive'   => 0x808000,
        'purple'  => 0x800080,
        'red'     => 0xff0000,
        'silver'  => 0xc0c0c0,
        'teal'    => 0x8080,
        'white'   => 0xffffff,
        'yellow'  => 0xffff00,
    );
    // Our include directory
    var $_rdir = null;
    // Our resource location URI
    var $_rloc = null;
    // Our resource location URI (relative)
    var $_rlocr = null;
    // Our local media location
    var $_mloc = null;
    // Our version tag
    var $_vtag = null;
    // DB-Support? (com_avreloaded available and enabled) available
    var $_dbok = 0;
    // Last assigned divid
    var $_last_divid = null;

    ///// Content plugin API interface starts here

    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @param object $subject The object to observe
     * @param object $params  The object that holds the plugin parameters
     * @param int    $special Used internally
     * @since 1.5
     */
    function plgContentAvreloaded(& $subject, $params, $special = 0) {
        parent::__construct($subject, $params);
        $this->_init();
    }

    /**
     * Main prepare content method
     * Method is called by the view
     *
     * @param       object          The article object.  Note $article->text
     *                              is also available
     * @param       object          The article params
     * @param       int             The 'page' number
     */
    function onPrepareContent(&$article, &$params, $limitstart=0) {
        $article->text = $this->_doSubstitution($article->text);
    }

    ///// Content plugin API interface ends here

    ///// Alternative API: Call by value, returning the result.
    ///// For use in custom modules.
    function onAvReloadedGetVideo($string) {
        return $this->_doSubstitution($string);
    }
    ///// Alternative API ends here

    ///// Alternative API: Call by value, returning the result and assigned ID.
    ///// For use in custom modules.
    function onAvReloadedGetVideoAndID($string) {
        $code = $this->_doSubstitution($string);
        return array($code, $this->_last_divid);
    }
    ///// Alternative API ends here

    function _getWARN_JS() {
        static $strj;
        if ($strj) {
            return $strj;
        }
        $wjs1 = JText::_('WARN_JAVASCRIPT');
        if ($wjs1 == 'WARN_JAVASCRIPT') {
            // Fallback if no translation is available.
            $wjs1 = 'JavaScript is disabled!';
        }
        $wjs2 = JText::_('WARN_JAVASCRIPT2');
        if ($wjs2 == 'WARN_JAVASCRIPT2') {
            // Fallback if no translation is available.
            $wjs2 = 'To display this content, you need a JavaScript capable browser.';
        }
        $strj = '<ins><noscript><div style="background-color:red;color:white;width:160px">'.
            '<strong>'.$wjs1.'</strong><br/>'.$wjs2.'</div></noscript></ins>';
        return $strj;
    }

    function &_getWARN_FLASH() {
        static $ret = null;
        if ($ret) {
            return $ret;
        }
        $msg = JText::_('WARN_FLASH', true);
        if ($msg == 'WARN_FLASH') {
            // Fallback if no translation is available.
            $msg = 'Adobe Flash Player not installed or older than %s!';
        }
        $alt = JText::_('WARN_FLASH_ALT', true);
        if ($alt == 'WARN_FLASH_ALT') {
            // Fallback if no translation is available.
            $alt = 'Get Adobe Flash Player here';
        }
        $str =
            '<ins><div id="warnflash%s" '.
            'style="background-color:red;color:white;width:160px;visibility:hidden">'.
            '<strong>'.$msg.'</strong><br/><a href="http://www.adobe.com/go/getflashplayer" '.
            'onclick="window.open(this.href);return false;" '.
            'onkeypress="window.open(this.href);return false;">'.
            '<img src="'.$this->_rloc.'160x41_Get_Flash_Player.jpg" alt="'.$alt.'" style="border:0" />'.
            '</a></div></ins>';
        $ret = array($str, '<script type="text/javascript">window.addEvent("domready",function(){var s = "warnflash%s"; if ($(s)){$(s).setOpacity(1);}});</script>');
        return $ret;
    }

    /**
     * Local initialization
     */
    function _init() {
        // Joomla's plugin-installer does not handle separate language files for
        // backend and frontend if installing a plugin (kind of silly, as it works
        // with components). Instead, it installs the language files always into the
        // JPATH_ADMINISTRATOR/languages. Therefore we have to specify this path
        // explicitely.
        JPlugin::loadLanguage('plg_content_avreloaded', JPATH_ADMINISTRATOR);
        $mparams =& JComponentHelper::getParams('com_media');
        $this->_mloc = JURI::root().'/'.$mparams->get('image_path', 'images/stories').'/';
        $this->_rdir = JPATH_PLUGINS.DS.'content'.DS.'avreloaded'.DS;
        $this->_rlocr = 'plugins/content/avreloaded/';
        $this->_rloc = JURI::root(true).'/'.$this->_rlocr;
        // Workaround for "double-slash" prob
        $this->_mloc = preg_replace('#([^:])//#','\\1/', $this->_mloc);
        $this->_rloc = str_replace("//","/", $this->_rloc);
        $this->_rlocr = str_replace("//","/", $this->_rlocr);
        $this->_rdir = str_replace(DS.DS,DS,$this->_rdir);

        $this->_vtag = 'v'.$this->_version.'.'.preg_replace('#\D#', '', $this->_rev);

        $tags = null;
        // Check for our corresponding component which owns the db tables.
        if (JComponentHelper::isEnabled('com_avreloaded', true)) {
            $db = &JFactory::getDBO();
            $query = 'SELECT name,player_id,ripper_id,postreplace FROM #__avr_tags';
            @$db->setQuery($query);
            @$db->query();
            @$tags = $db->loadObjectList();
            $this->_dbok = is_array($tags);
        }
        if (!is_array($tags)) {
            JError::raiseError(500, JText::_('ERR_TAGS'));
        }
        $this->tags = $tags;
    }

    /**
     * Helper function for adjusting local URLs.
     *
     * @param loc The location to adjust.
     * @return The adjusted location
     * @access private
     */
    function _adjustLoc($loc, $isUrl = 1) {
        if (empty($loc))
            return '';
        if (JString::strpos($loc, '/') === 0) {
            return $loc;
        }
        if ($isUrl) {
            if (JString::strpos($loc, 'http://') === 0) {
                return $loc;
            }
            if (JString::strpos($loc, 'https://') === 0) {
                return $loc;
            }
        }
        return $this->_mloc.$loc;
    }

    /**
     * Helper function for emulating htmlspecialchars_decode
     * on PHP4.
     *
     * @param string The string to decode.
     * @return The decoded string.
     * @access private
     */
    function _htsdecode($string) {
        if (function_exists('htmlspecialchars_decode')) {
            return htmlspecialchars_decode($string);
        } else {
            return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
        }
    }

    /**
     * The actual work horse of the plugin. Here the text gets scanned for known
     * tags and then these tags get replaced by the necessary code to embed the
     * video player.
     *
     * @param text The article text to be scanned/replaced
     * @return The text, with all known tags replaced.
     * @access private
     */
    function _doSubstitution($text) {
        if (!$this->_dbok) {
            return $text;
        }
        // Get the plugin parameters
        $plugin = &JPluginHelper::getPlugin('content', 'avreloaded');
        $params = new JParameter($plugin->params);
        $cfg = array();

        $cache_on               = $params->get('ripcache', 1);
        $cache_time             = $params->get('cache_time', 3600);
        // general
        $cfg['rloc']            = $this->_rloc;
        $cfg['alt']             = $params->get('alt', '');
        if ($cfg['alt'] == '') unset($cfg['alt']);
        $cfg['avcss']           = $params->get('avcss', 'allvideos');
        $cfg['tmargin']         = $params->get('tmargin', 8);
        $cfg['bmargin']         = $params->get('bmargin', 8);
        $cfg['valign']          = $params->get('valign', 'center');
        $cfg['width']           = $params->get('width', 400);
        $cfg['height']          = $params->get('height', 320);
        $cfg['vloc']            = $this->_adjustLoc($params->get('vdir', 'videos').'/', 0);
        $cfg['wmode']           = $params->get('wmode', 'window');
        $cfg['bgcolor']         = $this->_fmtColor($params->get('bgcolor', '#FFFFFF'), '#');
        $cfg['legacy']          = $params->get('legacy', '0');
        $cfg['autostart']       = $this->_fmtBool($params->get('autostart', '0'));
        $cfg['usefullscreen']   = $this->_fmtBool($params->get('usefullscreen', '0'));
        $cfg['showdigits']      = $this->_fmtBool($params->get('showdigits', '1'));
        $cfg['showicons']       = $this->_fmtBool($params->get('showicons', '1'));
        $cfg['showstop']        = $this->_fmtBool($params->get('showstop', '0'));
        $cfg['showdownload']    = $this->_fmtBool($params->get('showdownload', '0'));
        $cfg['shownav']         = $this->_fmtBool($params->get('shownav', '1'));
        $cfg['showeq']          = $this->_fmtBool($params->get('showeq', '0'));
        $cfg['enablejs']        = $this->_fmtBool($params->get('enablejs', '0'));
        $cfg['searchbar']       = $this->_fmtBool($params->get('searchbar', '0'));
        $cfg['pbgcolor']        = $this->_fmtColor($params->get('pbgcolor', '#FFFFFF'), '0x');
        $cfg['pfgcolor']        = $this->_fmtColor($params->get('pfgcolor', '#000000'), '0x');
        $cfg['phicolor']        = $this->_fmtColor($params->get('phicolor', '#000000'), '0x');
        $cfg['psccolor']        = $this->_fmtColor($params->get('psccolor', '#000000'), '0x');
        $cfg['logo']            = $params->get('logo', '-1');
        $cfg['logo']            = $this->_adjustLoc(($cfg['logo'] == '-1') ? '' : $cfg['logo'], 1);
        if ($cfg['logo'] == '') unset($cfg['logo']);
        $cfg['searchlink']      = $params->get('searchlink', '');
        if ($cfg['searchlink'] == '') unset($cfg['searchlink']);
        $cfg['screenmode']      = $params->get('screenmode', 'default');
        $cfg['plsize']          = $params->get('plsize', 30);
        $cfg['stretch']         = $params->get('stretch', 0);
        $cfg['flashver']        = $params->get('flashver', '9.0.115');
        switch ($cfg['stretch']) {
        case 0:
            $cfg['stretch'] = 'false';
            break;
        case 1:
            $cfg['stretch'] = 'true';
            break;
        case 2:
            $cfg['stretch'] = 'fit';
            break;
        case 3:
            $cfg['stretch'] = 'none';
            break;
        }
        // iFilm - Metacafe - GameTrailers only
        $cfg['cwidth']          = $params->get('width', 400);
        $cfg['cheight']         = $params->get('height', 320);  
        // audio only
        $cfg['awidth']          = $params->get('awidth', 300);
        $cfg['aheight']         = $params->get('aheight', 20);
        $cfg['aloc']            = $this->_adjustLoc($params->get('adir', 'audio').'/', 0);
        $cfg['site']            = JURI::root(false);
        $cfg['linkfromdisplay'] = 'false';
        $cfg['linktarget']      = '_blank';
        $cfg['menu']            = $this->_fmtBool(1);
        // youtube special
        $cfg['ytrel']           = $this->_fmtBool(0);
        $cfg['ytegm']           = $this->_fmtBool(0);
        $cfg['ytloop']          = $this->_fmtBool(0);
        $cfg['ytborder']        = $this->_fmtBool(0);
        // popup related
        $cfg['popup']           = $this->_fmtBool(0);
        // prepend and append code
        $vstyle = '';
        $container = 'span';
        if ($cfg['legacy']) {
            $container = 'div';
            $vstyle = ' style="clear:both; text-align: '.$cfg['valign'].'; margin-top: '.
                $cfg['tmargin'].'px; margin-bottom: '.$cfg['bmargin'].'px;"';
        }
        $start = sprintf($this->_beg, $this->_vtag, $container, $vstyle, $cfg['avcss'], $container);
        $end = sprintf($this->_end, $this->_vtag);
        $needswfo = 0;
        $needsl = 0;
        $needavr = 0;

        static $divid;
        if (!isset($divid)) {
            $divid = 0;
        }

        foreach ($this->tags as $tag) {
            $key = $tag->name;
            // Speedup non-matching case
            if (strpos($text, '{'.$key) !== false) {
                // The actual regex stuff
                $re = '#{'.$key.'(\s+[a-z]+\s*=\s*(?:"|&quot;)[^}]*(?:"|&quot;))*}([^{]+){/'.$key.'}#m';
                if (preg_match_all($re, $text, $matches, PREG_PATTERN_ORDER) > 0) {
                    // load the matching player
                    $db = &JFactory::getDBO();
                    $query = 'SELECT code,minw,minh FROM #__avr_player where id = ' . $tag->player_id;
                    @$db->setQuery($query);
                    @$db->query();
                    @$player = $db->loadObject();
                    if ($player == null) {
                        // The tag/preset referenced a nonexistent player
                        JError::raiseError(500, JText::_('ERR_FORMAT'), $fn);
                    }
                    $needavr = 1;
                    $avp = null;
                    $avpcfg = $cfg;
                    if ($tag->postreplace != '') {
                        $avp = unserialize($tag->postreplace);
                        if (!is_array($avp)) {
                            JError::raiseError(500, JText::_('ERR_FORMAT'), $fn);
                        }
                        foreach ($avp as $old => $new) {
                            // If old matches exactly one @...@ and
                            // new does not contain any @...@, we delay replacement
                            // and set a cfg var instead.
                            $omatch = null;
                            if (preg_match('#^@([A-Z]+)@$#', $old, $omatch) &&
                                (preg_match('#@[A-Z]+@#', $new) == 0)) {
                                    $ckey = strtolower($omatch[1]);
                                    $avpcfg[$ckey] = $new;
                                } else {
                                    $player->code = str_replace($old, $new, $player->code);
                                }
                        }
                    }

                    // The actual replacement of tags
                    $i = 0;
                    foreach ($matches[0] as $match) {
                        $parms = JString::trim($this->_htsdecode($matches[1][$i]));
                        // tplr is a reference first
                        $tplr = &$player->code;
                        $tcfg = $avpcfg;
                        $tstart = $start;
                        $tend = $end;
                        $tcfg['divid'] = 'avreloaded'.$divid++;
                        if (JString::strlen($parms)) {
                            // If individual parameters are specified,
                            // make tplr a deep copy ..
                            $tplr = $player->code;
                            $this->_parseParams($parms, $tcfg, $tstart, $tend);
                        }

                        $vcode = $matches[2][$i];
                        // If a ripper is defined, execute it
                        if ($tag->ripper_id != 0) {
                            $robj = null;
                            $query = 'SELECT * FROM #__avr_ripper where id = ' . $tag->ripper_id;
                            @$db->setQuery($query);
                            @$db->query();
                            @$robj = $db->loadObject();
                            if (is_object($robj)) {
                                $cache =& JFactory::getCache('plg_content_avreloaded');
                                $cache->setCaching($cache_on);
                                $cache->setLifeTime($cache_time);
                                $tmp = $tcfg;
                                $robj->url = $this->_buildCode($vcode, $tmp, $robj->url);
                                // save old code, in case it's needed as well
                                $tcfg['ocode'] = $vcode;
                                $rres =& $cache->call('plgContentAvreloaded::_ripper', $robj);
                                $vcode = $rres[0];
                                if (empty($vcode)) {
                                    // invalidate cache, if ripper has failed.
                                } else {
                                    for ($r = 1; $r < count($rres); $r++) {
                                        $tcfg['rres'.chr(96+$r)] = $rres[$r];
                                    }
                                }
                            } else {
                                // The tag/preset referenced a nonexistent ripper
                                JError::raiseError(500, JText::_('ERR_FORMAT'), $fn);
                            }
                        }
                        // Minimum size requirement of express install is now handled by
                        // swfobject lib.
                        $tcfg['xpinst'] = "'".$this->_rloc."expressinstall.swf'";
                        $code = $tstart.$tplr.$tend;
                        // Check for size constraint of player
                        if (($player->minw > 0) && ($tcfg['width'] < $player->minw)) {
                            $tcfg['width'] = $player->minw;
                        }
                        if (($player->minh > 0) && ($tcfg['height'] < $player->minh)) {
                            $tcfg['height'] = $player->minh;
                        }
                        $code = $this->_buildCode($vcode, $tcfg, $code);
                        $altcontent = '';
                        $altset = isset($tcfg['alt']);
                        if ($altset) {
                            $altcontent = $tcfg['alt'];
                        }

                        // Generate alternate content (JavaScript warning and Flash warning)
                        if (is_int(strpos($code, 'swfobject.'))) {
                            $needswfo = 1;
                            if ($altset) {
                                $code = str_replace('!!WARN_JS!!', '', $code);
                                $code = str_replace('!!WARN_FL1!!', $altcontent, $code);
                                $code = str_replace('!!WARN_FL2!!', '', $code);
                            } else {
                                $code = str_replace('!!WARN_JS!!', $this->_getWARN_JS(), $code);
                                $wfa =& $this->_getWARN_FLASH();
                                $code = str_replace('!!WARN_FL1!!', sprintf($wfa[0],
                                    $tcfg['divid'], $tcfg['flashver']), $code);
                                $code = str_replace('!!WARN_FL2!!', sprintf($wfa[1],
                                    $tcfg['divid']), $code);
                            }
                        } else if (is_int(strpos($code, 'jeroenwijering.'))) {
                            $needsl = 1;
                            if ($altset) {
                                $code = str_replace('!!WARN_JS!!', '', $code);
                            } else {
                                $code = str_replace('!!WARN_JS!!', $this->_getWARN_JS(), $code);
                            }
                            $code = str_replace('!!WARN_FL1!!', '', $code);
                            $code = str_replace('!!WARN_FL2!!', '', $code);
                        } else {
                            $code = str_replace('!!WARN_JS!!', '', $code);
                            $code = str_replace('!!WARN_FL1!!', $altcontent, $code);
                            $code = str_replace('!!WARN_FL2!!', '', $code);
                        }

                        if ($this->_fmtBool($tcfg['popup']) == 'true')  {
                            // If this is going to be a popup, store it in the DB
                            // and create an empty (and therefore invisible) span
                            // which contains all necessary parameters for invoking
                            // it via the component's popup view
                            $code = $this->_renderToDB($code, $tcfg, $db);
                        }
                        $this->_last_divid = $tcfg['divid'];
                        $text = str_replace($match, $code, $text );
                        $i++;
                    }
                }
            }
        }
        $js_swf = 'swfobject.js';
        $js_avr = 'avreloaded.js';
        $js_wmv = 'wmvplayer.js';
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
        if ($needsl) {
            JHTML::script('silverlight.js', $this->_rlocr);
            JHTML::script($js_wmv, $this->_rlocr);
        }
        if ($needswfo) {
            JHTML::script($js_swf, $this->_rlocr);
        }
        // Handle special hardcoded tags (avrpopup, avrbutton)
        $ret = $this->_handleSpecial($text, $needavr);
        if ($needavr) {
            JHTML::script($js_avr, $this->_rlocr);
        }
        return $ret;
    }

    function _handleSpecial($text, &$needavr) {
        $special = array('avrpopup', 'avrbutton');
        foreach ($special as $key) {
            // Speedup non-matching case
            if (strpos($text, '{'.$key) !== false) {
                // The actual regex stuff
                $re = '#{'.$key.'(\s+[a-z]+\s*=\s*(?:"|&quot;)[^}]*(?:"|&quot;))*}([^{]+){/'.$key.'}#m';
                if (preg_match_all($re, $text, $matches, PREG_PATTERN_ORDER) > 0) {
                    $i = 0;
                    $code = '';
                    $needavr = 1;
                    switch ($key) {
                    case 'avrpopup':
                        $code = '<a href="#" onclick="AvrPopup(event, \'@ID@\', \'@TYPE@\');">@CODE@</a>';
                        break;
                    case 'avrbutton':
                        $code = '<!-- AVRBUTTON -->';
                        break;
                    }
                    foreach ($matches[0] as $match) {
                        $parms = JString::trim($this->_htsdecode($matches[1][$i]));
                        $vcode = $matches[2][$i];
                        $tcfg = array('screenmode' => '');
                        if (JString::strlen($parms)) {
                            $dummy1 = "";
                            $dummy2 = "";
                            $this->_parseParams($parms, $tcfg, $dummy1, $dummy2);
                        }
                        $repl = $this->_buildCode($vcode, $tcfg, $code);
                        $text = str_replace($match, $repl, $text);
                        $i++;
                    }
                }
            }
        }
        return $text;
    }

    function _renderToDB($code, $cfg, $db) {
        $menus =& JSite::getMenu();
        $amenu =& $menus->getActive();
        $itemid = $amenu->id;
        $w = $cfg['width'];
        $h = $cfg['height'];
        $divid = $cfg['divid'];
        $query = "REPLACE INTO #__avr_popup VALUES($itemid,'".
            $divid."','".$db->getEscaped($code)."',".
            $w.','.$h.',NOW())';
        @$db->setQuery($query);
        @$db->query();
        $url = 'index.php?option=com_avreloaded&view=popup&Itemid='.$itemid.'&divid='.$divid;
        $code =
            '<span id="avrpopup_'.$divid.'" title="{'.
            'handler:\'iframe\',size:{x:'.$w.',y:'.$h.'},'.
            'url:'."'".urlencode($url).'\'}"></span>';
        JHTML::script('modal.js');
        JHTML::stylesheet('modal.css');
        JHTML::stylesheet('avrmodal.css', 'plugins/content/avreloaded/');
        $doc =& JFactory::getDocument();
        $doc->addScriptDeclaration(
            "window.addEvent('domready', function(){SqueezeBox.initialize({});});");
        return $code;
    }

    /**
     * Parse a string, containing multiple parameters, each in the form
     * key="value" and assign them to an assoziative array.
     *
     * @param parms
     * @param cfg
     * @param start
     * @param end
     *
     * @access private
     */
    function _parseParams($parms, &$cfg, &$start, &$end) {
        $legacy_override = 0;
        $style_override = '';
        if (preg_match_all('#\s*([a-z]+)\s*=\s*"([^}"]*)"\s*#', $parms, $matches)) {
            $i = 0;
            foreach ($matches[1] as $key) {
                switch ($key) {
                case 'img':
                    $cfg[$key] = $this->_adjustLoc($matches[2][$i], 1);
                    break;
                case 'bgcolor':
                    $cfg[$key] = $this->_fmtColor($matches[2][$i], '#');
                    break;
                case 'pbgcolor':
                case 'pfgcolor':
                case 'phicolor':
                case 'psccolor':
                    $cfg[$key] = $this->_fmtColor($matches[2][$i], '0x');
                    break;
                case 'autostart':
                case 'usefullscreen':
                case 'showdigits':
                case 'showicons':
                case 'showstop':
                case 'showdownload':
                case 'shownav':
                case 'showeq':
                case 'searchbar':
                    $cfg[$key] = $this->_fmtBool($matches[2][$i]);
                    break;
                case 'style':
                    $style_override = $matches[2][$i];
                    break;
                case 'legacy':
                    $legacy_override = 1;
                    $cfg[$key] = $this->_fmtBool($matches[2][$i]);
                    break;
                default:
                    $cfg[$key] = $matches[2][$i];
                    break;
                }
                $i++;
            }
            $container = 'span';
            if ($legacy_override) {
                if ($cfg['legacy'] == 'true') {
                    $container = 'div';
                    if ($style_override) {
                        $style = ' style="'.$style_override.'"';
                    } else {
                        $style = ' style="clear:both; text-align: '.$cfg['valign'].'; margin-top: '.
                            $cfg['tmargin'].'px; margin-bottom: '.$cfg['bmargin'].'px;"';
                    }
                }
                $start = sprintf($this->_beg, $this->_vtag, $container, $style, $cfg['avcss'], $container);
                $end = sprintf($this->_end, $this->_vtag);
            } else {
                if ($style_override) {
                    $start = sprintf($this->_beg, $this->_vtag, $container,
                        ' style="'.$style_override.'"', $cfg['avcss'], $container);
                }
            }
        }
    }

    /**
     * Replace variables in a player template
     * For every @NAME@ tag, lookup the lowercaes NAME in 
     * the supplied config array and - if found - replace it by the stored
     * value. Furthermode, If a sequence @IF(NAME)@..content..@/IF@ is
     * found, replace that sequence with an empty string, if the variable
     * specified by lowercase NAME is unset or not 'true'. Similar, if
     * @IFS(NAME)@..content..@/IFS@ is found, replace that sequence with
     * an empty string, if the variable specified by lowercase NAME is unset.
     *
     * @param code The content of the element's tag.
     * @param cfg  The current config to be used.
     * @param pltmpl The player template to be used.
     *
     * @return string The player template with all matching patterns replaced.
     *
     * @access private
     */
    function _buildCode($code, $cfg, $pltmpl) {
        $matches = null;
        if ((!isset($cfg['displayheight'])) && (!isset($cfg['displaywidth']))) {
            // If the user has overridden displayheight or displaywidth already
            // from within the tag, don't touch it!
            switch ($cfg['screenmode']) {
            case 'coverlay':
                $cfg['displayheight'] = $cfg['height'];
                break;
            case 'plbottom':
                $cfg['displayheight'] = $cfg['height'] - ($this->_ctrlheight + $cfg['plsize']);
                break;
            case 'plright':
                $cfg['displaywidth'] = $cfg['width'] - $cfg['plsize'];
                break;
            case 'floatcplright':
                $cfg['displayheight'] = $cfg['height'];
                $cfg['displaywidth'] = $cfg['width'] - $cfg['plsize'];
                break;
            }
        }
        // First handle conditionals ...
        if (preg_match_all('#@IF\((!?[A-Z]+)\)@(.+)@/IF@#sU', $pltmpl, $matches, PREG_PATTERN_ORDER)) {
            $i = 0;
            foreach ($matches[0] as $match) {
                $key = strtolower($matches[1][$i]);
                $neg = (strpos($key, '!') === 0);
                if ($neg) {
                    $key = ltrim($key, '!');
                }
                $inner = '';
                if ($neg xor ((isset($cfg[$key])) && ($this->_fmtBool($cfg[$key]) == 'true'))) {
                    $inner = $matches[2][$i];
                }
                $pltmpl = str_replace($match, $inner, $pltmpl);
                $i++;
            }
        }
        if (preg_match_all('#@IFS\((!?[A-Z]+)\)@(.+)@/IFS@#sU', $pltmpl, $matches, PREG_PATTERN_ORDER)) {
            $i = 0;
            foreach ($matches[0] as $match) {
                $key = strtolower($matches[1][$i]);
                $neg = (strpos($key, '!') === 0);
                if ($neg) {
                    $key = ltrim($key, '!');
                }
                $inner = '';
                if ($neg xor (isset($cfg[$key]))) {
                    $inner = $matches[2][$i];
                }
                $pltmpl = str_replace($match, $inner, $pltmpl);
                $i++;
            }
        }
        // ... then handle regular replacements
        if (preg_match_all('#@([A-Z]+(?:![dy])?)@#', $pltmpl, $matches, PREG_PATTERN_ORDER)) {
            $i = 0;
            foreach ($matches[0] as $match) {
                $key = strtolower($matches[1][$i]);
                $boolfmtoverride = null;
                if (strpos($key, '!d')) {
                    $boolfmtoverride = 'ds';
                    $key = str_replace('!d', '', $key);
                }
                if (strpos($key, '!y')) {
                    $boolfmtoverride = 'yn';
                    $key = str_replace('!y', '', $key);
                }
                if (isset($cfg[$key])) {
                    $val = $cfg[$key];
                    if ($boolfmtoverride) {
                        $val = $this->_fmtBool($val, $boolfmtoverride);
                    }
                    $pltmpl = str_replace($match, $val, $pltmpl);
                }
                $i++;
            }
        }
        return str_replace('@CODE@', $code, $pltmpl);
    }

    /**
     * Format a boolean value
     *
     * @param value The input to be formatted.
     *                Possible input formats:
     *                  - A numeric (int or string) (0 == false, !0 == true)
     *                  - A string in the form 'true' or 'false'
     * @param fmt   The desired output format:
     *                'bs'  return a string 'true' or 'false'
     *                'ds'  return a string '1' or '0'
     *                'yn'  return a string 'yes' or 'no'
     *
     * @return string
     * @access private
     */
    function _fmtBool($value, $fmt = 'bs') {
        if (is_numeric($value)) {
            $value = ((1 + $value) != 1);
        }
        if (is_string($value)) {
            $value = (strtolower($value) == 'true');
        }
        switch ($fmt) {
        case 'bs':
            // return boolean string
            return ($value) ? 'true' : 'false';
            break;
        case 'ds':
            // return decimal string
            return ($value) ? '1' : '0';
            break;
        case 'yn':
            // return yes/no string
            return ($value) ? 'yes' : 'no';
            break;
        }
    }

    /**
     * Retrieves the version of the CURL extension, if any.
     */
    function _curl_version() {
        if (is_array($curl = curl_version())) {
            $curl = $curl['version'];
        } elseif (substr($curl, 0, 5) == 'curl/') {
            $curl = substr($curl, 5, strcspn($curl, "\x09\x0A\x0B\x0C\x0D", 5));
        } elseif (substr($curl, 0, 8) == 'libcurl/') {
            $curl = substr($curl, 8, strcspn($curl, "\x09\x0A\x0B\x0C\x0D", 8));
        } else {
            $curl = 0;
        }
        return $curl;
    }

    /**
     * Quotes a regex (puts delimiters around it).
     */
    function _quoteRegex($rx) {
        for ($i = 1; $i < 256; $i++) {
            $c = chr($i);
            if (strpos($rx, $c) === false) {
                return $c.$rx.$c;
            }
        }
        return null;
    }

    /**
     * Retrieves the real url of a media resource.
     * First, the content of a given url is fetched, then
     * this content is matched against a given regex in order
     * to retrieve a fragment which contains the actual media
     * url.
     *
     * @param robj A ripper parameter object.
     *
     * @return An array, containing the extracted media URL at index 0,
     *         followed by an arbitrary number of additional backreferences.
     * @access private
     */
    function &_ripper(&$robj) {
        $url = str_replace(' ', '%20', $robj->url);
        $ret = array('');
        $resp = '';
        if (function_exists('curl_init')) {
            // We preferably use cURL, because that supports
            // a proxy out of the box. In your apache config,
            // simply set the environment variable http_proxy
            // to host:port in order to use it.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_USERAGENT, 'AllVideos Reloaded');
            if (!ini_get('open_basedir') &&
                !ini_get('safe_mode') &&
                version_compare(plgContentAvreloaded::_curl_version(), '7.15.2', '>='))
            {
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            }
            $proxy = getenv('http_proxy');
            if ($proxy !== false) {
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
            }
            if (!($resp = curl_exec($ch)))
                $resp = '';
            curl_close($ch);
        } else if (ini_get('allow_url_fopen') == '1') {
            // try fallback to file_get_contents
            $resp = @file_get_contents($url);
        }
        if (strlen($resp)) {
            if ($robj->flags & 1) {
                $resp = urldecode($resp);
            }
            $resp = plgContentAvreloaded::_htsdecode($resp);
            $regex = plgContentAvreloaded::_quoteRegex($robj->regex);
            if (empty($regex)) {
                plgContentAvreloaded::_err(JText::sprintf('ERR_MATCH_URL',
                    htmlspecialchars($url),
                    htmlspecialchars($resp),
                    htmlspecialchars($robj->regex)));
                return $ret;
            }
            if (preg_match($regex, $resp, $matches)) {
                array_shift($matches);
                if (count($matches) < 1) {
                    plgContentAvreloaded::_err(JText::sprintf('ERR_MATCH_URL',
                        htmlspecialchars($url),
                        htmlspecialchars($resp),
                        htmlspecialchars($robj->regex)));
                    return $ret;
                }
                if ($robj->cindex > 0) {
                    $i = $robj->cindex;
                    if ($i >= count($matches)) {
                        plgContentAvreloaded::_err(JText_('ERR_MATCH_INDEX'));
                        return $ret;
                    }
                    $code = $matches[$i];
                    $a1 = array_slice($matches, 0, $i);
                    $a2 = array_slice($matches, $i + 1);
                    $matches = array($code);
                    $matches = array_merge($matches, $a1, $a2);
                }
                return $matches;
            }
            plgContentAvreloaded::_err(JText::sprintf('ERR_MATCH_URL',
                htmlspecialchars($url),
                htmlspecialchars($resp),
                htmlspecialchars($robj->regex)));
        } else
            plgContentAvreloaded::_err(JText::sprintf('ERR_FETCH_URL',
                htmlspecialchars($url)));
        return $ret;
    }

    /**
     * Displays an error message inline
     */
    function _err($msg) {
        global $mainframe;
        $mainframe->enqueueMessage($msg, 'error');
    }

    /**
     * Format a color value.
     *
     * @param  clr The color value to be formatted.
     *               Possible input formats:
     *                 - an int color value
     *                 - a string in '0xxxx' notation (like in javascript)
     *                 - a string in #RRGGBB notation (HTML, CSS)
     *                 - a string in #RGB notation (CSS)
     *                 - a string in rgb(r,g,b) notation (CSS)
     *                 - a string with a color name
     * @param  fmt The output color format:
     *               '0x'  return a string in '0xxx' notation
     *               '#'   return a string in #RRGGBB notation
     *               'rgb' return a string in rgb(r,g,b) notation
     *
     * @return string
     * @access private
     */
    function _fmtColor($clr, $fmt = '0x') {
        $iclr = -1;
        if (is_int($clr)) {
            if ($clr <= 0xFFFFFF)
                $iclr = $clr;
        }
        if (is_string($clr)) {
            $match = null;
            $clr = trim($clr);
            // #xxx css notation and #xxxxxx html/css notation
            if (preg_match('/^#([\da-f]{3,6})$/i', $clr, $match)) {
                switch (strlen($match[1])) {
                case 3:
                    $iclr = intval(sprintf('%s%s%s%s%s%s',
                        $match[1][0], $match[1][0],
                        $match[1][1], $match[1][1],
                        $match[1][2], $match[1][2]), 16);
                    break;
                case 6:
                    $iclr = intval($match[1], 16);
                    break;
                }
            }
            // 0x... javascript notation
            if (($iclr == -1) && preg_match('/^0x([0-9a-f]{1,6})$/i', $clr, $match)) {
                $iclr = intval($match[1], 16);
            }
            // rgb(d,d,d) css notation
            if (($iclr == -1) && preg_match('/^rgb\s*\(\s*([-+]?\d+)\s*,\s*([-+]?\d+)\s*,\s*([-+]?\d+)\s*\)/', $clr, $match)) {
                $r = intval($match[1]); if ($r < 0) $r = 0; if ($r > 255) $r = 255;
                $g = intval($match[2]); if ($g < 0) $g = 0; if ($g > 255) $g = 255;
                $b = intval($match[3]); if ($b < 0) $b = 0; if ($b > 255) $b = 255;
                $iclr = ($r << 16) | ($g << 8) | $b;
            }
            // html 4.01 color names
            if ($iclr == -1) {
                $cn = strtolower($clr);
                if (isset($this->_w3colors[$cn])) {
                    $iclr = $this->_w3colors[$cn];
                }
            }
            if ($iclr == -1) {
                $this->_err(JText::sprintf('ERR_COLORVAL', htmlspecialchars($clr)));
                return '';
            }
            switch ($fmt) {
            case '0x':
                return sprintf("0x%06X", $iclr);
            case '#':
                return sprintf("#%06X", $iclr);
            case 'rgb':
                return sprintf("rgb(%d,%d,%d)", $iclr >> 16, ($iclr >> 8) & 0xff, $iclr & 0xff);
            default:
                JError::raiseError(500, JText::_('ERR_COLORFMT'), $fmt);
            }
        }
    }

}

