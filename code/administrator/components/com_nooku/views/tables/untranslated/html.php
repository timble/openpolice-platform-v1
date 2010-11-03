<?php
/**
 * @version		$Id: html.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Untranslated Tables HTML View
 *
 * @author		Mathais Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewUntranslated extends KViewHtml
{
	public function display($tpl = null)
	{
		$model = KFactory::get('admin::com.nooku.model.tables');

		$this->assignRef('tables', 	$model->getUntranslatedTables());
		
		// Display the layout
		parent::display($tpl);
	}

}
