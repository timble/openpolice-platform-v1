<?php
/**
 * @version		$Id: metadata.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Controllers
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Metadata Controller
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Site
 * @subpackage  Controllers
 */
class NookuControllerMetadata extends KControllerPage
{	
	public function save() 
	{
		//KSecurityToken::check() or die('Invalid token or time-out, please try again');
	
		$item = KFactory::get('admin::com.nooku.model.metadata')->getItem();
		
 		$item->description 	 = KInput::get('metadesc', 'post', 'raw', 'string');
 		$item->keywords 	 = KInput::get('metakey',  'post', 'raw', 'string');
 			
 		$item->save();
	}
}