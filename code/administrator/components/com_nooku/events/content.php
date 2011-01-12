<?php
/**
 * @version		$Id: content.php 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

Koowa::import('admin::com.nooku.events.default');

/**
 * Content Event Handler
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category    Nooku
 * @package     Nooku_Administrator
 * @subpackage  Events
 */
class NookuEventContent extends NookuEventDefault 
{		
	public function onDatabaseBeforeInsert(ArrayObject $args) 
	{	
		if(parent::onDatabaseBeforeInsert($args) !== false)
		{
			//Get the metadata information
			$args['data']['metakey']  = KInput::get('metadata_keywords', 'post', 'raw', 'string');
			$args['data']['metadesc'] = KInput::get('metadata_description', 'post', 'raw', 'string');
			
			//Append '-copy' to the alias to prevent duplicate aliases when copying items
			if(KInput::get('task', 'post', 'cmd') == 'copysave') {
				$args['data']['alias'] = $args['data']['alias'].'-copy';
			}
		}
	}
	
	public function onDatabaseBeforeUpdate(ArrayObject $args) 
	{
		if(!array_key_exists('alias', $args['data'])) {
			return false;
		}
		
		if(parent::onDatabaseBeforeUpdate($args) !== false) 
		{
			//Get the metadata information
			$args['data']['metakey']  = KInput::get('metadata_keywords', 'post', 'raw', 'string');
			$args['data']['metadesc'] = KInput::get('metadata_description', 'post', 'raw', 'string');
		}
	}
	
	public function onDatabaseAfterInsert(ArrayObject $args) 
	{
		$language = KFactory::get('admin::com.nooku.model.nooku')->getLanguage();
		
		if($args['table'] == 'nooku_nodes' && $args['data']['iso_code'] == $language) {
			KInput::set('row_id', $args['data']['row_id'], 'post');
		}
	}
	
	public function onApplicationBeforeRedirect(ArrayObject $args) 
	{
		if(in_array(KInput::get('task', 'post', 'cmd'), array('save', 'apply'))) 
		{
			$controller = KFactory::get('admin::com.nooku.controller.metadata');
			$controller->execute('save');
		}
	}
	
	public function onApplicationAfterDispatch(ArrayObject $args)
	{
		parent::onApplicationAfterDispatch($args);
		
		if(in_array(KInput::get('task', array('get', 'post'), 'cmd'), array('edit', 'add'))) 
		{
			$doc = KFactory::get('lib.joomla.document');
			$doc->addScript( Nooku::getUrl('js').'ajax.metadata.content.js');
		}
	}
	
	public function onApplicationAfterRender(ArrayObject $args)
	{
		parent::onApplicationAfterRender($args);
		
		// only insert the js when editing a menu item
		if( in_array(KInput::get('task', array('get', 'post'), 'cmd'), array('edit', 'add'))) 
		{
			$buffer = JResponse::getBody();
    		$buffer = str_replace('new Accordion', 'document.accordion = new Accordion', $buffer);
			JResponse::setBody($buffer);
		}
	}
}