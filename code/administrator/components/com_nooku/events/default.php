<?php
/**
 * @version		$Id: default.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

/**
 * Node Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 */
abstract class NookuEventDefault extends KEventHandler 
{	
	protected $_validationMsg;
	
	protected $_table;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
        parent::__construct();
		$this->_table = $this->getClassName('suffix');
	}
	
	public function getValidationMsg()
	{
		return $this->_validationMsg;
	}
	
	public function onDatabaseBeforeInsert(ArrayObject $args) 
	{
		if(substr($args['table'], -strlen($this->_table)) != $this->_table) {
			return false;
		}
		
		if(KInput::get('task', array('get', 'post'), 'cmd') != 'copysave') 
		{
			$args['data']['id'] = 0;
		
			//Validate the alias information if it exists
			if(!$this->onValidateForm($args['data'])) {
				$this->displayMessage(JText::_('Alias already exists'));
			}
		};
	}
	
	public function onDatabaseBeforeUpdate(ArrayObject $args) 
	{
		if(substr($args['table'], -strlen($this->_table)) != $this->_table) {
			return false;
		}
		
		if(in_array(KInput::get('task', array('get', 'post'), 'cmd'), array('edit', 'add'))) 
		{
			//Get the id of the item that is being updated
			$args['data']['id'] = KFactory::tmp('lib.koowa.filter.int')->sanitize($args['where']);
		
			//Validate the alias information if it exists
			if(!$this->onValidateForm($args['data'])) {
				$this->displayMessage(JText::_('Alias already exists'));
			}
		}
	}
	
	public function onApplicationAfterDispatch(ArrayObject $args)
	{
		if(in_array(KInput::get('task', array('get', 'post'), 'cmd'), array('edit', 'add'))) 
		{
			$doc = KFactory::get('lib.joomla.document');
			$doc->addScript( Koowa::getUrl('js').'koowa.js');
			$doc->addScript( Nooku::getUrl('js').'ajax.form.js');
		}
	}
	
	public function onApplicationAfterRender(ArrayObject $args)
	{
		
	}

	public function onValidateForm($args)
	{
		if(!isset($args['title'])) {
			return true;
		}
		
		//Sanitize the alias
		$sanitize = empty($args['alias']) ? $args['title'] : $args['alias'];
		$args['alias'] = KFactory::tmp('lib.koowa.filter.ascii')->sanitize($sanitize);
		
		//Alias can't start with a number, as that will be interpreted as an id
		if(is_numeric(substr($args['alias'], 0, 1))) 
		{
			$this->_validationMsg = "Aliases can't start with a number";
			return false;
		}		

		//Check if the alias can be found
		$section = isset($args['section']) ? $args['section'] : '';
		$result  = KFactory::get('admin::com.nooku.table.nodes')
			->findByAlias($args['alias'], $this->_table, $section)->id;
			
		//Check if we have a duplicate alias
		if(!is_null($result) && $args['id'] != (int) $result) {
			$this->_validationMsg = "The alias already exists, please choose a different one";
			return false;
		}
		
		return true;
	}
	
	public function displayMessage($msg)
	{
		KFactory::get('lib.joomla.application')->redirect(
			KInput::get('HTTP_REFERER', 'server', 'internalurl'),
			$msg, 'notice'
		);
	}
}