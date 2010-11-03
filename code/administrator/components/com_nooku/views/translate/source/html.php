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
 * Nooku Translate Source HTML View
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewSource extends KViewHtml
{
	public function display($tpl = null)
	{
		$model = KFactory::get('admin::com.nooku.model.articles');
		$original = $model->getSourceArticle();

		if (JString::strlen($original->fulltext) > 1) {
			$text = $original->introtext . "<hr id=\"system-readmore\" />" . $original->fulltext;
		} else {
			$text = $original->introtext;
		}

		$this->assign('text' , $text);
		
		// Display the layout
		parent::display($tpl);
	}

}