<?php
/**
 * @version		$Id: flags.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Flags model
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 */
class NookuModelFlags
{	
	public function getList()
	{
		if(!isset($this->_list))
		{
			jimport( 'joomla.filesystem.folder' );
			$iso = KFactory::get('admin::com.nooku.model.isocountries');
	
			$flagsdir	= Nooku::getPath('flags');
			$flagsurl 	= Nooku::getUrl('flags');
	
			$files = JFolder::files($flagsdir, '(.*)\.png');
			foreach ( $files as $file ) 
			{
				$code = basename($file, '.png');
				$country = $iso->getCountry($code);
				$this->_list[$code] = $country ? $country : $code;
			}
			asort($this->_list);
		}

		return $this->_list;
	}
}