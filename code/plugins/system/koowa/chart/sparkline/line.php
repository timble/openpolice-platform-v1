<?php
/**
 * @version     $Id: line.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package     Koowa_Chart
 * @subpackage  Sparkline
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.koowa.org
 */

Koowa::import('lib.koowa.chart.renderer.sparkline.Sparkline_Line');

/**
 * Sparkline Line
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_Chart
 * @subpackage  Sparkline
 */
class KChartSparklineLine extends KChartSparkline
{
    /**
     * Get an instance of a SparklineLine object, always creating it
     *
     * @param	array	Configuration array
     * @return	object	KChartSparklineBar proxy object
     */
    static public function getInstance($config = array())
    {
        if(!isset($config['catch_errors']))
        {
        	$config['catch_errors'] = true;
        }
        $obj = new Sparkline_Line($config['catch_errors']);
        $obj->SetDebugLevel(DEBUG_NONE);
        return new KChartSparklineLine($obj);
    }

    /**
     * Renders the sparkline
     *
     * @param	int	width
     * @param	int height
     * @throws KChartException
     */
    public function render($width, $height)
    {

        $c = $this->getObject();
        if($this->getResample())
        {
        	$c->renderResampled($width, $height);
        } else
        {
        	$c->render($width, $height);
        }
        
        if($c->isError()) {
            throw new KChartException(array_pop($c->getError()));
        }
        
        $c->output();

        KFactory::get('lib.joomla.application')->close();
    }

}