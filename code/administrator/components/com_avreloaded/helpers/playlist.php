<?php
/**
 * @version		$Id: playlist.php 1027 2008-07-06 22:46:07Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'avrxml.php');

class AvrPlaylistHelper extends JObject {

    var $_filename = null;

    var $_lasterror = null;

    function AvrPlaylistHelper($filename) {
        $this->_filename = $filename;
    }

    function _getXMLdata(&$track, $path) {
        $tmp =& $track->getElementByPath($path);
        if (is_a($tmp, 'JSimpleXMLElement')) {
            return $tmp->data();
        }
        return null;
    }

    function _getXMLattrData(&$track, $path, $attrname, $attrval) {
        foreach ($track->children() as $tmp) {
            if ($tmp->attributes($attrname) == $attrval) {
                return $tmp->data();
            }
        }
        return null;
    }

    function _getXMLattrValue(&$track, $path, $attrname, $attrval, $valuename) {
        foreach ($track->children() as $tmp) {
            if ($tmp->attributes($attrname) == $attrval) {
                return $tmp->attributes($valuename);
            }
        }
        return null;
    }

    function _getXMLattr(&$track, $path, $attrname) {
        $tmp =& $track->getElementByPath($path);
        if (is_a($tmp, 'JSimpleXMLElement')) {
            return $tmp->attributes($attrname);
        }
        return null;
    }

    function _getPlaylistFormat(&$doc) {
        if (is_a($doc, 'JSimpleXMLElement')) {
            if (('playlist' == $doc->name()) &&
                (!is_int($doc->attributes('version'))) &&
                (1 == (int)$doc->attributes('version')))
            {
                return 1;
            }
            if (('rss' == $doc->name()) &&
                (is_numeric($doc->attributes('version'))) &&
                (2 == (int)$doc->attributes('version')))
            {
                return 2;
            }
            if (('asx' == $doc->name()) &&
                (is_numeric($doc->attributes('version'))) &&
                (3 == (int)$doc->attributes('version')))
            {
                return 3;
            }
        }
        return 0;
    }

    function _errorHandler($code, $str) {
        $this->_lasterror = preg_replace('#\s+\[\<a\s+href=.*\]#', '', $str);
    }

    function _encodeNbsp($str) {
        return str_replace(chr(0xc2).chr(0xa0), '&nbsp;', $str);
    }

    function _decodeNbsp($str) {
        return str_replace('&nbsp;', chr(0xc2).chr(0xa0), $str);
    }

    function getLastError() {
        return $this->_lasterror;
    }

    function &read() {
        $ret = null;
        $xml = new AvrXML();
        set_error_handler(array($this, '_errorHandler'));
        if (!@$xml->loadFile($this->_filename)) {
            restore_error_handler();
            unset($xml);
            return $ret;
        }
        restore_error_handler();
        $format = $this->_getPlaylistFormat($xml->document);
        $idx = 1;
        switch ($format) {
        case 1:
            // XSPF
            $list =& $xml->document->getElementByPath('/tracklist');
            if (is_a($list, 'JSimpleXMLElement')) {
                $ret = new stdClass();
                $ret->items = array();
                $ret->filename = $this->_filename;
                $ret->title = null;
                foreach ($list->children() as $track) {
                    $entry = new stdClass();
                    $entry->index = $idx++;
                    $entry->file = $this->_getXMLdata($track, '/location');
                    $entry->image = $this->_getXMLdata($track, '/image');
                    $entry->id = $this->_getXMLdata($track, '/identifier');
                    $entry->link = $this->_getXMLdata($track, '/info');
                    $entry->title = $this->_encodeNbsp($this->_getXMLdata($track, '/title'));
                    $entry->author = $this->_encodeNbsp($this->_getXMLdata($track, '/creator'));
                    $entry->category = $this->_encodeNbsp($this->_getXMLdata($track, '/album'));
                    $entry->type = $this->_getXMLattrData($track, '/meta', 'rel', 'type');
                    $entry->captions = $this->_getXMLattrData($track, '/meta', 'rel', 'captions');
                    $entry->audio = $this->_getXMLattrData($track, '/meta', 'rel', 'audio');
                    array_push($ret->items, $entry);
                }
                $doc = $xml->document;
                $ret->title = $this->_getXMLdata($doc, '/title');
                $ret->creator = $this->_getXMLdata($doc, '/creator');
                $ret->annotation = $this->_getXMLdata($doc, '/annotation');
                $ret->info = $this->_getXMLdata($doc, '/info');
                $ret->location = $this->_getXMLdata($doc, '/location');
                $ret->date = $this->_getXMLdata($doc, '/date');
                $ret->license = $this->_getXMLdata($doc, '/license');
                $ret->date = $this->_getXMLdata($doc, '/date');
                $ret->image = $this->_getXMLdata($doc, '/image');
                $ret->attribution = null;
                $node = $this->_getXMLdata($doc, '/attribution');
                if (is_a($node, 'JSimpleXMLElement')) {
                    $alinks = $node->children();
                    if (count($alinks) > 1) {
                        $ret->attribution = array();
                        foreach ($alinks as $alink) {
                            $ret->attribution[] = $this->_getXMLdata($alink, '/');
                        }
                    } else {
                        $ret->attribution = $this->_getXMLdata($alinks[0], '/');
                    }
                }
            }
            break;
        case 2:
            // RSS
            $list =& $xml->document->getElementByPath('/channel');
            if (is_a($list, 'JSimpleXMLElement')) {
                $ret = new stdClass();
                $ret->title = null;
                $ret->items = array();
                foreach ($list->children() as $track) {
                    if ($track->name() == 'item') {
                        $entry = new stdClass();
                        $entry->index = $idx++;
                        $entry->file = $this->_getXMLattr($track, '/media:content', 'url');
                        if (empty($entry->file)) {
                            $entry->file = $this->_getXMLattr($track, '/enclosure', 'url');
                        }
                        $entry->image = $this->_getXMLattr($track, '/media:thumbnail', 'url');
                        $entry->id = $this->_getXMLdata($track, '/guid');
                        $entry->link = $this->_getXMLdata($track, '/link');
                        $entry->title = $this->_getXMLdata($track, '/title');
                        $entry->author = $this->_getXMLdata($track, '/author');
                        if (empty($entry->author)) {
                            $entry->author = $this->_getXMLattrData($track, '/media:credit', 'role', 'author');
                        }
                        $entry->type = $this->_getXMLattr($track, '/media:content', 'type');
                        if (empty($entry->type)) {
                            $entry->type = $this->_getXMLattr($track, '/enclosure', 'type');
                        }
                        $entry->captions = null;
                        $entry->audio = null;
                        array_push($ret->items, $entry);
                    }
                }
            }
            break;
        case 3:
            // ASX
            $list =& $xml->document;
            if (is_a($list, 'JSimpleXMLElement')) {
                $ret = new stdClass();
                $ret->title = null;
                $ret->items = array();
                foreach ($list->children() as $track) {
                    if ($track->name() == 'entry') {
                        $entry = new stdClass();
                        $entry->index = $idx++;
                        $entry->file = $this->_getXMLattr($track, '/ref', 'href');
                        $entry->image = $this->_getXMLattrValue($track, '/param', 'name', 'image', 'value');
                        $entry->id = $this->_getXMLattrValue($track, '/param', 'name', 'id', 'value');
                        $entry->link = $this->_getXMLattr($track, '/moreinfo', 'href');
                        $entry->title = $this->_getXMLdata($track, '/title');
                        $entry->author = $this->_getXMLdata($track, '/author');
                        $entry->type = $this->_getXMLattrValue($track, '/param', 'name', 'type', 'value');
                        $entry->captions = $this->_getXMLattrValue($track, '/param', 'name', 'captions', 'value');
                        $entry->audio = $this->_getXMLattrValue($track, '/param', 'name', 'audio', 'value');
                        array_push($ret->items, $entry);
                    }
                }
            }
            break;
        default:
            $this->_lasterror = 'Invalid format';
            break;
        }
        unset($xml);
        return $ret;
    }

    function write(&$list) {
        $ret = false;
        if (is_object($list)) {
            if (is_array($list->items)) {
                $xml = new AvrXMLElement('playlist', array('version' => 1, 'xmlns' => 'http://xspf.org/ns/0/'));
                if (!empty($list->filename)) {
                    $this->_filename = $list->filename;
                }
                if (!empty($list->title)) {
                    $c =& $xml->addChild('title');
                    $c->setData($list->title);
                }
                if (!empty($list->annotation)) {
                    $c =& $xml->addChild('annotation');
                    $c->setData($list->annotation);
                }
                if (!empty($list->creator)) {
                    $c =& $xml->addChild('creator');
                    $c->setData($list->creator);
                }
                if (!empty($list->info)) {
                    $c =& $xml->addChild('info');
                    $c->setData($list->info);
                }
                if (!empty($list->location)) {
                    $c =& $xml->addChild('location');
                    $c->setData($list->location);
                }
                if (!empty($list->date)) {
                    $c =& $xml->addChild('date');
                    $c->setData($list->date);
                }
                if (!empty($list->license)) {
                    $c =& $xml->addChild('license');
                    $c->setData($list->license);
                }
                if (!empty($list->image)) {
                    $c =& $xml->addChild('image');
                    $c->setData($list->image);
                }
                if (!empty($list->attribution)) {
                    $node =& $xml->addChild('attribution');
                    if (is_array($list->attribution)) {
                        foreach ($list->attribution as $alink) {
                            $c =& $node->addChild('location');
                            $c->setData($alink);
                        }
                    } else {
                        $c =& $node->addChild('location');
                        $c->setData($list->attribution);
                    }
                }
                $c =& $xml->addChild('meta', array('rel' => 'generator'));
                $c->setData('AllVideos Reloaded');
                $c =& $xml->addChild('meta', array('rel' => 'generatorurl'));
                $c->setData('http://allvideos.fritz-elfert.de');
                $node =& $xml->addChild('tracklist');
                foreach ($list->items as $track) {
                    if (is_object($track)) {
                        $tnode =& $node->addChild('track');
                        if (!empty($track->file)) {
                            $c =& $tnode->addChild('location');
                            $c->setData($track->file);
                        }
                        if (!empty($track->image)) {
                            $c =& $tnode->addChild('image');
                            $c->setData($track->image);
                        }
                        if (!empty($track->id)) {
                            $c =& $tnode->addChild('identifier');
                            $c->setData($track->id);
                        }
                        if (!empty($track->link)) {
                            $c =& $tnode->addChild('info');
                            $c->setData($track->link);
                        }
                        if (!empty($track->title)) {
                            $c =& $tnode->addChild('title');
                            $c->setData($track->title);
                        }
                        if (!empty($track->author)) {
                            $c =& $tnode->addChild('creator');
                            $c->setData($track->author);
                        }
                        if (!empty($track->category)) {
                            $c =& $tnode->addChild('creator');
                            $c->setData($track->category);
                        }
                        if (!empty($track->type)) {
                            $c =& $tnode->addChild('meta', array('rel' => 'type'));
                            $c->setData($track->type);
                        }
                        if (!empty($track->captions)) {
                            $c =& $tnode->addChild('meta', array('rel' => 'captions'));
                            $c->setData($track->captions);
                        }
                        if (!empty($track->audio)) {
                            $c =& $tnode->addChild('meta', array('rel' => 'audio'));
                            $c->setData($track->audio);
                        }
                    }
                }
                set_error_handler(array($this, '_errorHandler'));
                if (@file_put_contents($this->_filename, ltrim($xml->toString())."\n") !== false) {
                    $ret = true;
                }
                restore_error_handler();
                unset($xml);
            }
        }
        return $ret;
    }

    function delete() {
        return true;
    }
}
