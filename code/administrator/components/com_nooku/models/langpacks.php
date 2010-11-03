<?php
/**
 * @version		$Id: langpacks.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Language Packs Model
 *
 * @author		Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Administrator
 * @subpackage  Models
 */
class NookuModelLangpacks extends KModelAbstract
{
	/**
	 * Get a list of langpack info
	 *
	 * @return array
	 */
	public function getList() 
	{
		if(!isset($this->_list))
		{
			$basedir 	= JLanguage::getLanguagePath(JPATH_SITE);
			$dirs		= JFolder::folders($basedir, '.', false, false, array('.svn', 'CVS', 'pdf_fonts'));
			
			$this->_list = array();
			foreach($dirs as $dir) 
			{
				foreach(JFolder::files($basedir.DS.$dir, '^([-_A-Za-z]*)\.xml$') as $file)
				{
					if($data = $this->_parseXml($basedir.DS.$dir.DS.$file)) 
					{
						$this->_list[$dir] = $data;
						break;
					}
				}			
			}
		}

		return $this->_list;	
	}
	
	/**
	 * Get a list of langpacks that haven't been added to the nooku languages table yet
	 *
	 * @return	array
	 */
	public function getUnused()
	{
		$langs = KFactory::get('admin::com.nooku.model.languages')->getList();
		$list = $this->getList();

		foreach(KHelperArray::getColumn($langs->toArray(), 'iso_code') as $iso_code) {
			if(isset($list[$iso_code])) {
				unset($list[$iso_code]);
			}
		}
		return $list;
	}
	
	/**
	 * Get language information from an XML langpack file
	 *
	 * @param 	string 	XML filename
	 * @return 	array	Named array of language info or false when $file is not 
	 * a langpack
	 */
	protected function _parseXml($file)
	{
		$xml = new SimpleXMLElement(file_get_contents($file));
		$result = false;

		if ('metafile' == $xml->getName()) 
		{
			$result = new stdClass;
			$result->name		= (string) $xml->name[0];
			$result->iso_code 	= (string) $xml->tag[0];
		}

		unset($xml); // save some mem
		return $result;
	}
	
}