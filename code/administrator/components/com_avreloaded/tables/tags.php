<?php
/**
 * @version		$Id: tags.php 980 2008-06-23 18:54:52Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


/**
 * Tags Table class
 *
 */
class TableTags extends JTable
{
    /**
     * Primary Key
     *
     * @var int
     */
    var $id = null;

    /**
     * @var int
     */
    var $version = 0;

    /**
     * @var int
     */
    var $player_id = null;

    /**
     * @var int
     */
    var $ripper_id = null;

    /**
     * @var int
     */
    var $local = null;

    /**
     * @var int
     */
    var $plist = null;

    /**
     * @var string
     */
    var $postreplace = '';

    /**
     * @var string
     */
    var $name = '';

    /**
     * @var string
     */
    var $description = '';

    /**
     * @var string
     */
    var $sampleregex = '';

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function TableTags(& $db) {
        parent::__construct('#__avr_tags', 'id', $db);
    }
}
