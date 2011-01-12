<?php
/**
 * @version     $Id: grouped.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package     Koowa_Chart
 * @subpackage  Google
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.koowa.org
 */

/**
 * Google Chart Bar Grouped
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_Chart
 * @subpackage  Google
 * @version     1.0
 */
class KChartGoogleBarGrouped extends KChartGoogle
{

    // BarGroupedHorizontal' => 'bhg', 'BarGroupedVertical' => 'bvg'
    protected $_type    = 'bvg';

    /**
     * Set to horizontal
     *
     * @return this
     */
    public function setHorizontal()
    {
        $this->_type = 'bhg';
        return $this;
    }

    /**
     * Set to vertical (default)
     *
     * @return this
     */
    public function setVertical()
    {
        $this->type = 'bvg';
        return $this;
    }

}