<?php
/**
 * @version		$Id: contact.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

Koowa::import('admin::com.nooku.events.default');

/**
 * Contact Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 */
class NookuEventContact extends NookuEventDefault 
{	
	public function __construct()
	{
        parent::__construct();
		$this->_table = 'contact_details';
	}
}