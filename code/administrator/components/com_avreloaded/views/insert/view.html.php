<?php
/**
 * @version		$Id: view.html.php 980 2008-06-23 18:54:52Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
jimport('joomla.plugin.plugin');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrgeneric.php');

/**
 * Insert View
 */
class AvReloadedViewInsert extends JView
{
    /**
     * display method of Insert view
     * @return void
     **/
    function display($tpl = null) {
        $plg =& JPluginHelper::getPlugin('content', 'avreloaded');
        $pp = new JParameter($plg->params);
        $app =& JFactory::getApplication();
        $doc =& JFactory::getDocument();
        $doc->addStyleSheet(JURI::root(true).'/administrator/templates/khepri/css/general.css');
        $doc->addStyleSheet(JURI::root(true).'/administrator/templates/khepri/css/component.css');
        $js_ins = 'popup-insert.js';
        $cfg =& JFactory::getConfig();
        $debug = $cfg->getValue('config.debug');
        $konqcheck = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "konqueror");
        // If global debugging is enabled or the browser is konqueror,
        // we use uncompressed JavaScript
        if ($debug || $konqcheck) {
            $js_ins = 'popup-insert-uncompressed.js';
        }
        JHTML::script($js_ins, 'administrator/components/com_avreloaded/assets/');
        JHTML::_('behavior.tooltip');
        jimport('joomla.html.pane');
        $pane =& JPane::getInstance('Tabs', array('startOffset' => JRequest::getInt('local',0)));
        $data =& $this->_getProvider($pp, $app);
        $data['mselector'] = $this->_getLocalMedia('mloc', $data['mloc']);
        $doc->addScriptDeclaration($data['js']);
        $this->assignRef('data', $data);
        $this->assignRef('pane', $pane);
        $this->assignRef('v', $this);
        parent::display($tpl);
    }

    function lbl($fieldname) {
        $dtext = JText::_('AVR_DSC_'.JString::strtoupper($fieldname));
        $ltext = JText::_('AVR_LBL_'.JString::strtoupper($fieldname));
        echo '<label for="'.$fieldname.'">'.JHTML::_('tooltip', $dtext, $ltext, null, $ltext).':</label>';
    }

    function &_getPreview($code, &$app) {
        $ret = array();
        $ret['havepv'] = 0;
        $ret['mediacode'] = '';
        if (!empty($code)) {
            if (JPluginHelper::importPlugin('content', 'avreloaded')) {
                $res = $app->triggerEvent('onAvReloadedGetVideo', array($code));
                if (is_array($res) && (count($res) == 1)) {
                    if ($res[0] == $code) {
                        // output is unchanged, so this is a syntax error
                        // or unsupported tag.
                        $ret['mediacode'] = '<span style="color:red"><b>'.
                            JText::_('AVR_ERR_PREVIEW_UNSUPPORTED').'</b></span>';
                    } else {
                        $ret['mediacode'] = $res[0];
                        $ret['havepv'] = (!empty($res[0]));
                    }
                }
            } else {
                $ret['mediacode'] = '<span style="color:red"><b>'.
                    JText::_('AVR_ERR_PREVIEW_NOTLOADED').'</b></span>';
            }
        }
        return $ret;
    }

    function &_getProvider(&$params, &$app) {
        $w = $params->get('width', 400);
        $h = $params->get('height', 320);
        $ret['playlist'] = JRequest::getInt('playlist', 0);
        $ret['noplists'] = JRequest::getInt('noplists', 0);
        $ret['e_name'] = htmlspecialchars(JRequest::getVar('e_name', ''));
        $ret['width'] = htmlspecialchars(JRequest::getVar('width', $w));
        $ret['lwidth'] = htmlspecialchars(JRequest::getVar('lwidth', $w));
        $ret['height'] = htmlspecialchars(JRequest::getVar('height', $h));
        $ret['lheight'] = htmlspecialchars(JRequest::getVar('lheight', $h));
        $ret['tagid'] = htmlspecialchars(JRequest::getVar('tagid', ''));
        $ret['ltagid'] = htmlspecialchars(JRequest::getVar('ltagid', ''));
        $ret['local'] = JRequest::getInt('local', 0);
        $mtag = JRequest::getVar('mtag', '');
        $lmtag = JRequest::getVar('lmtag', '');
        $ret['mtag'] = htmlspecialchars($mtag);
        $ret['lmtag'] = htmlspecialchars($lmtag);
        $ret['url'] = htmlspecialchars(JRequest::getVar('url', ''));
        $ret['mloc'] = htmlspecialchars(JRequest::getVar('mloc', ''));
        $psel = JRequest::getVar('provider', '');
        $lpsel = JRequest::getVar('lprovider', '');
        $ret['mediacode'] = '';
        $havepv = 0;
        if ($ret['local']) {
            $res =& $this->_getPreview($lmtag, $app);
            $ret['mediacode'] = $res['mediacode'];
            $havepv = $res['havepv'];
        } else {
            $res =& $this->_getPreview($mtag, $app);
            $ret['mediacode'] = $res['mediacode'];
            $havepv = $res['havepv'];
        }
        $db =& JFactory::getDBO();
        $playlist = JRequest::getInt('playlist', 0);
        $jw_where = ($playlist) ? ' AND #__avr_tags.plist = 1 ' : '';
        $query = 'SELECT #__avr_tags.id,#__avr_tags.name,#__avr_tags.description,sampleregex,isjw,local '.
            'FROM #__avr_tags,#__avr_player '.
            'WHERE #__avr_player.id = player_id '.$jw_where.
            'ORDER by description, name';
        $db->setQuery($query);
        $opts = array();
        $lopts = array();
        $js = "// <![CDATA[\nvar avri = null;\n".
            "window.addEvent('domready', function(){\n".
            "  avri = new AvReloadedInsert();\n".
            "  var tags = new Array(\n";
        $ljs = "  var ltags = new Array(\n";
        $cnt = 0;
        $lcnt = 0;
        foreach ($db->loadObjectList() as $p) {
            $ds = empty($p->description) ? $p->name : $p->description;
            $rx = empty($p->sampleregex) ? "null"
                : ("/".$p->sampleregex."/");
            if ($p->local == 1) {
                $nl = ($lcnt) ? ",\n" : '';
                $ljs .= $nl.'    {val:'.$p->id.',jw:'.$p->isjw.",tag:'".$p->name."',rx:".$rx.'}';
                $lopts[] = JHTML::_('select.option', $p->id, $ds);
                $lcnt++;
            } else {
                $nl = ($cnt) ? ",\n" : '';
                $opts[] = JHTML::_('select.option', $p->id, $ds);
                $js .= $nl.'    {val:'.$p->id.',jw:'.$p->isjw.",tag:'".$p->name."',rx:".$rx.'}';
                $cnt++;
            }
        }
        $nl = ($lcnt) ? "\n" : '';
        $ljs .= $nl."  );\n  ";
        $nl = ($cnt) ? "\n" : '';
        $js .= $nl."  );\n  ".$ljs."avri.init(tags,ltags,".$w.",".$h.",".$havepv.");\n});\n// ]]>\n";
        $ret['provider'] = JHTML::_('select.genericlist', $opts, 'provider',
            'class="inputbox" size="1" onchange="avri.buildTag(0);"',
            'value', 'text', $psel);
        $ret['lprovider'] = JHTML::_('select.genericlist', $lopts, 'lprovider',
            'class="inputbox" size="1" onchange="avri.buildTag(1);"',
            'value', 'text', $lpsel);
        $ret['js'] = $js;
        return $ret;
    }

    /**
     * Build the select list to choose local media
     */
    function _getLocalMedia($name, $active = null) {
        $adir = AvrGenericHelper::getAdir();
        $vdir = AvrGenericHelper::getVdir();
        $js = 'onchange="return avri.matchLOC(this.value);"';

        jimport('joomla.filesystem.folder');
        $media = array(JHTML::_('select.option',  '', '- '.JText::_('AVR_SELECT_MEDIA').' -'));
        $playlist = JRequest::getInt('playlist', 0);
        $noplists = JRequest::getInt('noplists', 0);
        if ($noplists) {
            $filter = ($playlist) ? '\.(3gp|flv|m4v|rbs|swf)$' :
                '\.(3gp|avi|divx|flv|m4v|mov|mp4|mpg|mpeg|ram|rbs|rm|swf|wmv)$';
        } else {
            $filter = ($playlist) ? '\.(3gp|flv|m4v|rbs|swf|xml)$' :
                '\.(3gp|avi|divx|flv|m4v|mov|mp4|mpg|mpeg|ram|rbs|rm|swf|wmv|xml)$';
        }
        $si = JString::strlen($vdir) + 1;
        foreach (JFolder::files($vdir, $filter, true, true) as $file) {
            $media[] = JHTML::_('select.option', JString::substr($file, $si));
        }
        $filter = ($playlist) ? '\.mp3$' : '\.(mp3|ram|rm|wma)$';
        $si = JString::strlen($adir) + 1;
        foreach (JFolder::files($adir, $filter, true, true) as $file) {
            $media[] = JHTML::_('select.option', JString::substr($file, $si));
        }
        return JHTML::_('select.genericlist', $media, $name,
            'class="inputbox" size="1" '.$js, 'value', 'text', $active);
    }
}
