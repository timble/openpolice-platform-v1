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
 * Nooku Translations Openflashchart View
 *
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewTranslations extends KViewOpenflashchart
{
    public function display($tpl = null)
    {
  		$model = KFactory::get('admin::com.nooku.model.translations');

  		$this->assign('data'      , $model->getStats());
		$this->assign('languages' , KFactory::get('admin::com.nooku.model.nooku')->getLanguages());
		$this->assign('color'     , new NookuConfigColor());
		$this->assign('table_name', KInput::get('table_name', 'get', KFactory::tmp('admin::com.nooku.filter.tablename')));

        parent::display($tpl);
    }
}
