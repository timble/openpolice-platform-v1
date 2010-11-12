<?php
/**
 * @version		$Id: ripper.php 980 2008-06-23 18:54:52Z Fritz Elfert $
 * @copyright	Copyright (C) 2008 Fritz Elfert. All rights reserved.
 * @license		GNU/GPLv2
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


/**
 * Player Table class
 *
 */
class TableRipper extends JTable
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
    var $cindex = null;

    /**
     * @var int
     */
    var $flags = null;

    /**
     * @var string
     */
    var $name = '';

    /**
     * @var string
     */
    var $url = '';

    /**
     * @var string
     */
    var $regex = '';

    /**
     * @var string
     */
    var $description = '';

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function TableRipper(& $db) {
        parent::__construct('#__avr_ripper', 'id', $db);
    }
}
