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
 * Nooku Translator HTML View
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Views
 */
class NookuViewTranslate extends KViewHtml
{
	public function display($tpl = null)
	{
		$model 		= KFactory::get('admin::com.nooku.model.articles');
		$nooku 		= KFactory::get('admin::com.nooku.model.nooku');

		$article 	= $model->getArticle();
		$id 		= $model->getState('id');
		
		if (JString::strlen($article->fulltext) > 1) {
			$text = $article->introtext . "<hr id=\"system-readmore\" />" . $article->fulltext;
		} else {
			$text = $article->introtext;
		}

		// for the lang switcher
		$languages 		= $nooku->getLanguages();
		$target_lang    = $languages[$nooku->getLanguage()];
		$source_lang 	= $nooku->getPrimaryLanguage();
		$source_url 	= 'index.php?option=com_nooku&view=translate.source&tmpl=component&id='.$id.'&source_lang='.$source_lang->iso_code;

		// Assign to template
		$this->assign('text', 			$text);
		$this->assign('languages', 		$languages);
		$this->assign('target_lang', 	$target_lang);
		$this->assign('source_lang',   	$source_lang);
		$this->assign('source_url', 	$source_url);
		$this->assign('id', 			$id);
		
		// Display the layout
		parent::display($tpl);
	}

}