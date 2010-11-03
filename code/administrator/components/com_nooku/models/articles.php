<?php
/**
 * @version		$Id: articles.php 1121 2010-05-26 16:53:49Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Nooku Articles Model
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 */
class NookuModelArticles extends KModelTable
{
	public function __construct(array $options = array())
	{
		parent::__construct($options);
		$this->setTable('admin::com.nooku.table.articles');	
	}
	
	public function getArticle() 
	{
		$item = $this->getItem();
		return $item;
	}
	
	public function getSourceArticle()
	{
		$source_lang	= $this->getState('source_lang');
		
		$nooku   = KFactory::get('admin::com.nooku.model.nooku');
		$db  	 = KFactory::get('lib.joomla.database');
		$primary = $nooku->getPrimaryLanguage();
		
		$table = ($primary->iso_code != $source_lang) ? strtolower($source_lang).'_content' : 'content';
	
		$lang  = $db->setActiveLanguage();
		
		$query = $db->getQuery();
		$query->select();
		$query->from($table);
		$query->where('id', '=', (int)$this->getState('id'));
	
		$db->select($query);
		$db->setActiveLanguage($lang);

		return $db->loadObject();
	}
	
    public function getDefaultState()
    {
        $state = parent::getDefaultState(); 
        $state['source_lang'] = KInput::get('source_lang', 'get', 'lang');
        return $state;
    }
}
