<?php
/**
 * @version		$Id: player.php 980 2008-06-23 18:54:52Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


/**
 * Player Table class
 */
class TablePlayer extends JTable
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
    var $minw = 0;

    /**
     * @var int
     */
    var $minh = 0;

    /**
     * @var int
     */
    var $isjw = 0;

    /**
     * @var string
     */
    var $name = '';

    /**
     * @var string
     */
    var $code = '';

    /**
     * @var string
     */
    var $description = '';

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function TablePlayer(& $db) {
        parent::__construct('#__avr_player', 'id', $db);
    }
}
