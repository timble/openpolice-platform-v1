<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
jimport( 'joomla.filesystem.file' ); 
class PhocaGalleryCpViewPhocaGalleryUsers extends JView
{

	var $_context 	= 'com_phocagallery.phocagalleryuser';
	
	function display($tpl = null) {
		global $mainframe;
		$uri		=& JFactory::getURI();
		$document	=& JFactory::getDocument();
		$db		    =& JFactory::getDBO();
		$tmpl		= array();
		
		$path 					= PhocaGalleryPath::getPath();
		$tmpl['avatarpathabs']	= $path->avatar_abs . DS .'thumbs'.DS.'phoca_thumb_s_';
		$tmpl['avatarpathrel']	= $path->avatar_rel . 'thumbs/phoca_thumb_s_';
		$tmpl['avtrpathrel']	= $path->avatar_rel;
		
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		$document->addCustomTag("<!--[if lt IE 8]>\n<link rel=\"stylesheet\" href=\"../administrator/components/com_phocagallery/assets/phocagalleryieall.css\" type=\"text/css\" />\n<![endif]-->");
		
		
		
		JHTML::_('behavior.modal', 'a.modal-button');

		$params 				= JComponentHelper::getParams('com_phocagallery');
		$admin_modal_box_width 	= $params->get( 'admin_modal_box_width', 680 );
		$admin_modal_box_height = $params->get( 'admin_modal_box_height', 520 );
		
	
		// Button
		$button = new JObject();
		$button->set('modal', true);
		//$button->set('link', $link);
		$button->set('text', JText::_('Image'));
		$button->set('name', 'image');
		$button->set('modalname', 'modal-button');
		$button->set('options', "{handler: 'image', size: {x: 200, y: 150}}");

		//Filter		
		$filter_state		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_state',	'filter_state', '',	'word' );
		$filter_catid		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_catid',	'filter_catid',	0, 'int' );
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );
		$search				= $mainframe->getUserStateFromRequest( $this->_context.'.search', 'search', '',	'string' );
		$search				= JString::strtolower( $search );

		// Get data from the model
		$items					= & $this->get( 'Data');
		$total					= & $this->get( 'Total');
		$tmpl['pagination'] 	= & $this->get( 'Pagination' );
		$tmpl['notapproved'] 	= & $this->get( 'NotApprovedImage' );
		

	
		// state filter
		$lists['state']		= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] 	= $filter_order;

		// search filter
		$lists['search']	= $search;
		
		$this->assignRef('tmpl',		$tmpl);
		$this->assignRef('button',		$button);
		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('request_url',	$uri->toString());
		
		parent::display($tpl);
		$this->_setToolbar();
	}
	
	function _setToolbar() {
		JToolBarHelper::title(   JText::_( 'PHOCAGALLERY_PG_USERS' ), 'users' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::customX('approve', 'approve.png', '', JText::_( 'PHOCAGALLERY_APPROVE' ), true);
		JToolBarHelper::customX('disapprove', 'disapprove.png', '', JText::_( 'PHOCAGALLERY_NOT_APPROVE' ), true);
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Custom', '<a href="#" onclick="javascript:if(confirm(\''.addslashes(JText::_('PHOCAGALLERY_WARNING_AUTHORIZE_ALL')).'\')){submitbutton(\'approveall\');}" class="toolbar"><span class="icon-32-authorizeall" title="'.JText::_('PHOCAGALLERY_APPROVE_ALL').'" type="Custom"></span>'.JText::_('PHOCAGALLERY_APPROVE_ALL').'</a>');	
		JToolBarHelper::deleteList(  JText::_( 'PHOCAGALLERY_WARNDELETEAVATAR' ), 'remove', 'delete');
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
}
?>