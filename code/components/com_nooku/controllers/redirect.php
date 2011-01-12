<?php
/**
 * @version		$Id: redirect.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Controllers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Redirect Controller
 *
 * Used to redirect to external URL's
 * 
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Controllers
 */
class NookuControllerRedirect extends KControllerAbstract
{
	public function display($tpl = null)
	{
		$menu   = JSite::getMenu();
		$params = $menu->getParams($menu->getActive()->id);
		
		$url	= KFactory::tmp('lib.koowa.filter.url')->sanitize($params->get('url'));
		KFactory::get('lib.joomla.application')->redirect($url);
	}
}
