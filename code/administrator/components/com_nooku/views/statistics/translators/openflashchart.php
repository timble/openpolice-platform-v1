<?php
/**
 * @version     $Id: openflashchart.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */


/**
 * Nooku Translators Openflashchart View
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewTranslators extends KViewOpenflashchart
{
    public function display($tpl = null)
    {
    	$nooku = KFactory::get('admin::com.nooku.model.nooku');
    	$model = KFactory::get('admin::com.nooku.model.translators');

    	$this->assign('data'        , $model->getStats());
		$this->assign('dates'       , $model->getDates());
		$this->assign('languages'   , $nooku->getLanguages());
		$this->assign('translators' , $nooku->getTranslators());
		$this->assign('color'       , new NookuConfigColor());
		$this->assign('table_name'  , KInput::get('table_name', 'get', KFactory::tmp('admin::com.nooku.filter.tablename')));

        parent::display($tpl);
    }

    protected function _formatDates($dates)
    {
        $result = array();
        $d = new KDate();
    	foreach($dates as $date)
        {
        	$d->setDate($date);
            $result[] = $d->format('%b %e');
        }
        return $result;
    }
}