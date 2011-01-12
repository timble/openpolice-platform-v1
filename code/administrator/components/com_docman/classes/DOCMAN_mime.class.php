<?php
/**
 * @version		$Id: DOCMAN_mime.class.php 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

/**
* The MIME_Magic:: class provides an interface to determine a
* MIME type for various content, if it provided with different
* levels of information.
*/

class DOCMAN_MIME_Magic 
{
    /**
    * Returns a copy of the MIME extension map.
    *
    * @access private
    * @return array The MIME extension map.
    */
    function &_getMimeExtensionMap()
    {
        static $mime_extension_map;

        if (!isset($mime_extension_map)) {
            require dirname(__FILE__) . DS.'mime.mapping.php';
        }

        return $mime_extension_map;
    }

    /**
    * Returns a copy of the MIME magic file.
    *
    * @access private
    * @return array The MIME magic file.
    */
    function &_getMimeMagicFile()
    {
        static $mime_magic;

        if (!isset($mime_magic)) {
            require dirname(__FILE__) . DS.'mime.magic.php';
        }

        return $mime_magic;
    }

    /**
    * Attempt to convert a file extension to a MIME type
    *
    * If we cannot map the file extension to a specific type, then
    * we fall back to a custom MIME handler 'x-extension/$ext'
    *
    * @access public
    * @param string $ext The file extension to be mapped to a MIME type.
    * @return string The MIME type of the file extension.
    */
    function extToMIME($ext)
    {
        if (empty($ext)) {
            return 'application/octet-stream';
        } else {
            $ext = strtolower($ext);
            $map = &DOCMAN_MIME_Magic::_getMimeExtensionMap();
            $pos = 0;
            while (!isset($map[$ext]) && $pos !== false) {
                $pos = strpos($ext, '.');
                if ($pos !== false) {
                    $ext = substr($ext, $pos + 1);
                }
            }

            if (isset($map[$ext])) {
                return $map[$ext];
            } else {
                return 'x-extension/' . $ext;
            }
        }
    }

    /**
    * Attempt to convert a filename to a MIME type, based on the
    * global Horde and application specific config files.
    *
    * @access public
    * @param string $filename The filename to be mapped to a MIME type.
    * @param optional $ boolean $unknown  How should unknown extensions be handled?
    *                                    If true, will return 'x-extension/xtd' types.
    *                                    If false, will return 'application/octet-stream'.
    * @return string The MIME type of the filename.
    */
    function filenameToMIME($filename, $unknown = true)
    {
        $pos = strlen($filename) + 1;
        $type = '';

        $map = &DOCMAN_MIME_Magic::_getMimeExtensionMap();
        for ($i = 0;
            $i <= $map['__MAXPERIOD__'] &&
            strrpos(substr($filename, 0, $pos - 1), '.') !== false;
            $i++) {
            $pos = strrpos(substr($filename, 0, $pos - 1), '.') + 1;
        }
        $type = DOCMAN_MIME_Magic::extToMIME(substr($filename, $pos));

        if (empty($type) ||
                (!$unknown && (strpos($type, 'x-extension') !== false))) {
            return 'application/octet-stream';
        } else {
            return $type;
        }
    }

    /**
    * Attempt to convert a MIME type to a file extension
    *
    * If we cannot map the type to a file extension, we return false.
    *
    * @access public
    * @param string $type The MIME type to be mapped to a file extension.
    * @return string The file extension of the MIME type.
    */
    function MIMEToExt($type)
    {
        if (empty($type)) {
            return false;
        }

        $key = array_search($type, DOCMAN_MIME_Magic::_getMimeExtensionMap());
        if ($key === false) {
            list($major, $minor) = explode('/', $type);
            if ($major == 'x-extension') {
                return $minor;
            }
            if (strpos($minor, 'x-') === 0) {
                return substr($minor, 2);
            }
            return false;
        } else {
            return $key;
        }
    }

    /**
    * Uses variants of the UNIX "file" command to attempt to determine the
    * MIME type of an unknown file.
    *
    * @access public
    * @param string $path The path to the file to analyze.
    * @return string The MIME type of the file.  Returns false if either
    *                  the file type isn't recognized or the file command is
    *                  not available.
    */
    function analyzeFile($path)
    {
        /* If the PHP Mimetype extension is available, use that. */
        if (Util::extensionExists('fileinfo')) {
            $res = finfo_open(FILEINFO_MIME);
            $type = finfo_file($res, $path);
            finfo_close($res);
            return $type;
        } else {
            /* Use a built-in magic file. */
            $mime_magic = &DOCMAN_MIME_Magic::_getMimeMagicFile();
            if (!($fp = @fopen($path, 'rb'))) {
                return false;
            }
            foreach ($mime_magic as $offset => $odata) {
                foreach ($odata as $length => $ldata) {
                    @fseek($fp, $offset, SEEK_SET);
                    $lookup = @fread($fp, $length);
                    if (!empty($ldata[$lookup])) {
                        fclose($fp);
                        return $ldata[$lookup];
                    }
                }
            }
            fclose($fp);
        }

        return false;
    }

    /**
    * Uses variants of the UNIX "file" command to attempt to determine the
    * MIME type of an unknown byte stream.
    *
    * @access public
    * @param string $data The file data to analyze.
    * @return string The MIME type of the file.  Returns false if either
    *                  the file type isn't recognized or the file command is
    *                  not available.
    */
    function analyzeData($data)
    {
        /* Use a built-in magic file. */
        $mime_magic = &DOCMAN_MIME_Magic::_getMimeMagicFile();
        foreach ($mime_magic as $offset => $odata) {
            foreach ($odata as $length => $ldata) {
                $lookup = substr($data, $offset, $length);
                if (!empty($ldata[$lookup])) {
                    return $ldata[$lookup];
                }
            }
        }

        return false;
    }
}