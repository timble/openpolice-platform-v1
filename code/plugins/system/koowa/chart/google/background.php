<?php
/**
 * @version     $Id: background.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package     Koowa_Chart
 * @subpackage  Google
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.koowa.org
 */

/**
 * Google Chart Background
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_Chart
 * @subpackage  Google
 * @version     1.0
 */
class KChartGoogleBackground extends KObject
{
    public $colors = array('ffffff');
    public $fillType = 0;
    protected $fillTypes = array ('s', 'lg', 'ls');
    public $isChart = false;
    public function toArray()
    {
        $retArray = array();
        if($this->isChart)
            array_push($retArray, 'c');
        else
            array_push($retArray, 'bg');
        array_push($retArray,$this->fillTypes[$this->fillType]);
        array_push($retArray,$this->colors[0]);
        return $retArray;
    }
}