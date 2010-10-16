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
 
class PhocaGalleryCpViewPhocaGalleryS extends JView
{

	var $_context 	= 'com_phocagallery.phocagallery';
	
	function display($tpl = null) {
		global $mainframe;
		$uri		=& JFactory::getURI();
		$document	=& JFactory::getDocument();
		$db		    =& JFactory::getDBO();
		$tmpl		= array();
		
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		$document->addCustomTag("<!--[if lt IE 8]>\n<link rel=\"stylesheet\" href=\"../administrator/components/com_phocagallery/assets/phocagalleryieall.css\" type=\"text/css\" />\n<![endif]-->");
		
		$link = 'index.php?option=com_phocagallery&amp;view=phocagalleryd&amp;tmpl=component';
		
		JHTML::_('behavior.modal', 'a.modal-button');

		$params 				= JComponentHelper::getParams('com_phocagallery');
		$admin_modal_box_width 	= $params->get( 'admin_modal_box_width', 680 );
		$admin_modal_box_height = $params->get( 'admin_modal_box_height', 520 );
		
		$tmpl['enablethumbcreation']		= $params->get('enable_thumb_creation', 1 );
		$tmpl['enablethumbcreationstatus'] 	= PhocaGalleryRenderAdmin::renderThumbnailCreationStatus((int)$tmpl['enablethumbcreation']);
	
		// Button
		$button = new JObject();
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_('Image'));
		$button->set('name', 'image');
		$button->set('modalname', 'modal-button');
		$button->set('options', "{handler: 'iframe', size: {x: ".$admin_modal_box_width.", y: ".$admin_modal_box_height."}}");

		//Filter
		//$context			= 'com_phocagallery.phocagallery.list.';
		
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
		
		// build list of categories
		$javascript 	= 'class="inputbox" size="1" onchange="submitform( );"';
		
		$query = 'SELECT a.title AS text, a.id AS value, a.parent_id as parentid'
		. ' FROM #__phocagallery_categories AS a'
	//	. ' WHERE a.published = 1'
		. ' ORDER BY a.ordering';
		$db->setQuery( $query );
		$phocagallerys = $db->loadObjectList();

		$tree = array();
		$text = '';
		$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($phocagallerys, $tree, 0, $text, -1);
		array_unshift($tree, JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -', 'value', 'text'));
		$lists['catid'] = JHTML::_( 'select.genericlist', $tree, 'filter_catid',  $javascript , 'value', 'text', $filter_catid );
		//-----------------------------------------------------------------------
	
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
		JToolBarHelper::title(   JText::_( 'Phoca Gallery Images' ), 'gallery' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::customX('approve', 'approve.png', '', JText::_( 'PHOCAGALLERY_APPROVE' ), true);
		JToolBarHelper::customX('disapprove', 'disapprove.png', '', JText::_( 'PHOCAGALLERY_NOT_APPROVE' ), true);
		JToolBarHelper::deleteList(  JText::_( 'WARNWANTDELLISTEDITEMS' ), 'remove', 'delete');
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::customX('Multiple', 'multiple.png', '', JText::_( 'Multiple Add' ), false);
		
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Custom', '<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert(\''.JText::_('PHOCAGALLERY_WARNING_RECREATE_MAKE_SELECTION').'\');}else{if(confirm(\''.JText::_('PHOCAGALLERY_WARNING_RECREATE_THUMBNAILS').'\')){submitbutton(\'recreate\');}}" class="toolbar"><span class="icon-32-recreate" title="'.JText::_('PHOCAGALLERY_RECREATE_THUMBS').'" type="Custom"></span>'.JText::_('PHOCAGALLERY_RECREATE').'</a>');	
		
		JToolBarHelper::preferences('com_phocagallery', '460');
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
}
?>