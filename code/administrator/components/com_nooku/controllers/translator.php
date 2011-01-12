<?php
/**
 * @version		$Id: translator.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Controllers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */


/**
 * Nooku Translator Controller
 *
 * @author      Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Controllers
 */
class NookuControllerTranslator extends NookuController
{
		
	/*
	 * Overridden enable function
	 * 
	 * @throws KControlleException
	 */
	public function enable()
	{
		KSecurityToken::check() or die('Invalid token or time-out, please try again');
		
		$cid 	= KInput::get('cid', 'post', 'array.ints');

		$enable = $this->getTask() == 'enable' ? 1 : 0;

		if (count( $cid ) < 1) {
			throw new KControllerException(JText::sprintf( 'Select a item to %s', JText::_($this->getTask()), true ) );
		}

		KFactory::get('admin::com.nooku.model.translators')->enable($enable, $cid);

		$this->setRedirect('view=translators');
	}
}
