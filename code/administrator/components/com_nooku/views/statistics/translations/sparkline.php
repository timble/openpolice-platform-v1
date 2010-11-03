<?php
/**
 * @version     $Id: sparkline.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * Nooku Translations Sparkline View
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewTranslations extends KViewSparkline
{
    public function display($tpl = null)
    {
        $nooku = KFactory::get('admin::com.nooku.model.nooku');
        $model = KFactory::get('admin::com.nooku.model.translations');

        // Get data
        $stats          = $model->getStats();
		$iso_code 		= KInput::get('iso_code', 'get', 'lang');
		
        // Requested table
        $table_name     = KInput::get('table_name', 'get', KFactory::tmp('admin::com.nooku.filter.tablename'));

        // Utilities
        $color          = new NookuConfigColor();

        // get the chart
        $c              = $this->getChart('bar');

        $c->setColor('red', $color->get('red'));
        $c->setColor('blue', $color->get('blue'));
        $c->setColor('yellow', $color->get('yellow'));
        $c->setColor('green', $color->get('green'));
        $c->SetBarWidth(5);
        $c->SetBarSpacing(1);

        $c->setData(0, $stats['MISSING'][$iso_code], 'red');
        $c->setData(1, $stats['OUTDATED'][$iso_code], 'yellow');
        $c->setData(2, $stats['COMPLETED'][$iso_code], 'green');
        $c->setData(3, $stats['ORIGINAL'][$iso_code], 'blue');

        return parent::display();
    }
}