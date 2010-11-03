<?php
/**
 * @version		$Id: ajax.php 1121 2010-05-26 16:53:49Z johan $
 * @package		Nooku
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku MetadataView
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @package		Nooku
 * @subpackage	Administrator
 * @version		1.0
 */
class NookuViewMetadata extends KViewAjax
{
	public function display($tpl = null)
	{
		$model		= KFactory::get('admin::com.nooku.model.metadata');
		$this->assign('metadata', $model->getItem());
		
		parent::display($tpl);
	}

}