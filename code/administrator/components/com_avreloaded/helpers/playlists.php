<?php
/**
 * @version		$Id: playlists.php 945 2008-06-09 17:28:15Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'playlist.php');

class AvrPlaylistsHelper {

    function &getPlaylists($dir) {
        // Read the videos folder to find playlists
        jimport('joomla.filesystem.folder');
        $candidates = JFolder::files($dir, '\.xml$');
        $rows = array();
        $id = 1;
        foreach ($candidates as $playlist) {
            $helper = new AvrPlaylistHelper($dir.DS.$playlist);
            if ($pl =& $helper->read()) {
                $obj = new stdClass();
                $obj->filename = $playlist;
                $obj->folder = $dir;
                $obj->title = $pl->title;
                $obj->id = $id++;
                $rows[] = $obj;
            }
        }
        return $rows;
    }
}
