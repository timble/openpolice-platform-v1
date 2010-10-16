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
phocagalleryimport('phocagallery.rate.ratecategory');
class PhocaGalleryCpViewPhocaGalleryCs extends JView
{
	var $_context 	= 'com_phocagallery.phocagalleryc';

	function display($tpl = null) {
		
		global $mainframe;
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();

		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		
		//Filter
		$context			= 'com_phocagallery.phocagalleryc.list.';
		$filter_state		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_state',	'filter_state',	'',	'word' );
		$filter_order		= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );
		$search				= $mainframe->getUserStateFromRequest( $this->_context.'.search', 'search',	'',	'string' );
		$search				= JString::strtolower( $search );
	
		// Get data from the model
		$model		= &$this->getModel();
		$items		= & $this->get( 'Data');
		$tmpl['notapproved'] 	= & $this->get( 'NotApprovedCategory' );
		$tmpl['total'] = count($items);
		$model->setTotal($tmpl['total']);
		$tmpl['pagination'] = &$this->get( 'Pagination' );
		$items 				= array_slice($items,(int)$tmpl['pagination']->limitstart, (int)$tmpl['pagination']->limit);
	
		// build list of categories
		$javascript 	= 'onchange="document.adminForm.submit();"';

		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] 	= $filter_order;

		// search filter
		$lists['search']= $search;

		$tmpl['ordering'] = ($lists['order'] == 'a.ordering');//Ordering allowed ?
		
		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('tmpl',		$tmpl);
		$this->assignRef('request_url',	$uri->toString());

		parent::display($tpl);
		$this->_setToolbar();
	}
	
	function _setToolbar() {
		JToolBarHelper::title( JText::_( 'Phoca Gallery Categories' ), 'category' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::customX('approve', 'approve.png', '', JText::_( 'PHOCAGALLERY_APPROVE' ), true);
		JToolBarHelper::customX('disapprove', 'disapprove.png', '', JText::_( 'PHOCAGALLERY_NOT_APPROVE' ), true);
		JToolBarHelper::deleteList( JText::_( 'WARNWANTDELLISTEDITEMS' ), 'remove', 'delete');
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::customX('PicLens', 'piclens.png', '', JText::_( 'PicLens' ), true);
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
}
?>