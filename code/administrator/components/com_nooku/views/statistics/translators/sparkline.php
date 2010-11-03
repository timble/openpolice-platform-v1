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
 * Nooku Translators Sparkline View
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewTranslators extends KViewSparkline
{
    /*
     * Display the view
     * 
     * @throws KViewException
     */
	public function display($tpl = null)
    {
        $nooku = KFactory::get('admin::com.nooku.model.nooku');
        $model = KFactory::get('admin::com.nooku.model.translators');

        // Get data from model
        $stats          = $model->getStats();
        $dates          = $model->getDates();

        // Get translators
        $translators    = $nooku->getTranslators();

        // Get the languages
        //$primary       = $nooku->getPrimaryLanguage();
        $languages      = $nooku->getLanguages();
        //unset($languages[$primary->iso_code]); // we don't display the primary lang in our chart

        // Request
        $table_name = KInput::get('table_name', 'get', KFactory::tmp('admin::com.nooku.filter.tablename'));
		$user_id    = KInput::get('user_id', 'get', 'int');
        if(!$user_id) {
            throw new KViewException('user_id is required in '.JURI::getInstance()->toString());
        }

        // Utilities
        $color  = new NookuConfigColor();
        
        // get the chart
        $c      = $this->getChart('line');
         
        // Data
        $i = 1;
        foreach($stats[$user_id]->count as $value) {
            $c->setData($i++, $value);
        }

        // Layout
        $c->SetLineSize(5);

        // The Sparkline lib always draws in black, this hack lets us use other colors
        $c->setColor('black', $color->get('blue'));

        parent::display();
    }
}
