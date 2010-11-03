<?php
/**
 * @version		$Id: ajax.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package		Koowa_View
 * @subpackage 	Ajax
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.koowa.org
 */

/**
 * Ajax View Class
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category	Koowa
 * @package		Koowa_View
 * @subpackage 	Ajax
 */
class KViewAjax extends KViewAbstract 
{ 
	public function __construct($options = array())
	{
		$options = $this->_initialize($options);
		
		// add a rule to the template for KSecurityToken
		KTemplateDefault::addRules(array(KFactory::get('lib.koowa.template.rule.token')));
		
		// Set a base path for use by the view
		$this->assign('baseurl', $options['base_url']);
		
		parent::__construct($options);
	}
}
