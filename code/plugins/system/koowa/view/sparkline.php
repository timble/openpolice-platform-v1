<?php
/**
 * @version     $Id: sparkline.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package     Koowa_View
 * @subpackage  Sparkline
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.koowa.org
 */

/**
 * View Sparkline Class
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_View
 * @subpackage  Sparkline
 * @uses 		KChartSparkline
 */
class KViewSparkline extends KViewAbstract
{
    /**
     * KChartSparkline object
     *
     * @var object
     */
    protected $_chart;

    public function display($tpl = null)
    {
        $width      = KInput::get('w', 'get', 'int', null, 80);
        $height     = KInput::get('h', 'get', 'int', null, 20);

        return $this->getChart()->render($width, $height);
    }

    /**
     * Get the chart object
     *
     * @param	string Type of the chart [line|bar]
     * @return	Chart object
     */
    public function getChart($type = 'line')
    {
    	if(!isset($this->_chart)) {
        	$this->_chart = KChartSparkline::getInstance($type);
        }
        return $this->_chart;
    }
}