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

class PhocaGalleryCpViewPhocaGallery extends JView
{
	function display($tpl = null) {
		global $mainframe;
		
		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		parent::display($tpl);
	}

	function _displayForm($tpl) {
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();
		$editor =& JFactory::getEditor();
		$tmpl	= array();
		
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		
		$params = JComponentHelper::getParams('com_phocagallery');
		
		$tmpl['enablethumbcreation']		= $params->get('enable_thumb_creation', 1 );
		$tmpl['enablethumbcreationstatus'] 	= PhocaGalleryRenderAdmin::renderThumbnailCreationStatus((int)$tmpl['enablethumbcreation']);

		JHTML::_('behavior.calendar');
		
		//Data from model
		$items	=& $this->get('Data');
		
		//Image button
		$link = 'index.php?option=com_phocagallery&amp;view=phocagalleryi&amp;tmpl=component';
		JHTML::_('behavior.modal', 'a.modal-button');
		$button = new JObject();
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_( 'Image' ));
		$button->set('name', 'image');
		$button->set('modalname', 'modal-button');
		$button->set('options', "{handler: 'iframe', size: {x: 760, y: 520}}");
		
		
		$lists 	= array();		
		$isNew	= ($items->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'Phoca gallery' ), $items->title );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}
		

		// Edit or Create?
		if (!$isNew) {
			$model->checkout( $user->get('id') );
		} else {
			// initialise new record
			$items->approved 	= 1;
			$items->published 	= 1;
			$items->order 		= 0;
			$items->catid 		= JRequest::getVar( 'catid', 0, 'post', 'int' );
		}

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, title AS text'
			. ' FROM #__phocagallery'
			. ' WHERE catid = ' . (int) $items->catid
			. ' ORDER BY ordering';
		$lists['ordering'] 			= JHTML::_('list.specificordering',  $items, $items->id, $query, false );

		// - - - - - - - - - - - - - - -
		// Build the list of categories
		$query = 'SELECT a.title AS text, a.id AS value, a.parent_id as parentid'
		. ' FROM #__phocagallery_categories AS a'
	//	. ' WHERE a.published = 1'
		. ' ORDER BY a.ordering';
		$db->setQuery( $query );
		$itemss = $db->loadObjectList();

		$tree = array();
		$text = '';
		$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($itemss, $tree, 0, $text, -1);
		array_unshift($tree, JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -', 'value', 'text'));
		
		//list categories
		$lists['catid'] = JHTML::_( 'select.genericlist', $tree, 'catid',  '', 'value', 'text', $items->catid);
		// - - - - - - - - - - - - - - -
		
		// Build the html select list
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $items->published );
		$lists['approved'] = JHTML::_('select.booleanlist',  'approved', 'class="inputbox"', $items->approved );

		// Link To GeoMap - Geo Button - - - - - -
		$longitudeLink = '14.429919719696045';
		if (isset($items->longitude) && $items->longitude != '' && $items->longitude != 0) {
			$longitudeLink = $items->longitude;
		}
		
		$latitudeLink = '50.079623358200884';
		if (isset($items->latitude) && $items->latitude != '' && $items->latitude != 0) {
			$latitudeLink = $items->latitude;
		} 
		
		$zoomLink = 2;
		if (isset($items->zoom) && $items->zoom != '' && $items->zoom != 0) {
			$zoomLink = $items->zoom;
		}
		
		//Get button
		$linkg = 'index.php?option=com_phocagallery&amp;view=phocagalleryg&amp;tmpl=component&amp;lat='.$latitudeLink.'&amp;lng='.$longitudeLink.'&amp;zoom='.$zoomLink;
		JHTML::_('behavior.modal', 'a.modal-button');
		$buttonGeo = new JObject();
		$buttonGeo->set('modal', true);
		$buttonGeo->set('link', $linkg);
		$buttonGeo->set('text', JText::_( 'coordinates' ));
		$buttonGeo->set('name', 'image');
		$buttonGeo->set('modalname', 'modal-button');
		$buttonGeo->set('options', "{handler: 'iframe', size: {x: 640, y: 560}}");
		// - - - - - - - - - - - - - - - - 
		
		
		phocagalleryimport('phocagallery.render.renderadmin');
		$tmpl['extlink1'] = PhocaGalleryRenderAdmin::renderExternalLink($items->extlink1);
		$tmpl['extlink2'] = PhocaGalleryRenderAdmin::renderExternalLink($items->extlink2);
		
		//clean gallery data
		jimport('joomla.filter.output');
		JFilterOutput::objectHTMLSafe( $items, ENT_QUOTES, 'description' );
		
		$this->assignRef('editor', $editor);
		$this->assignRef('tmpl', $tmpl);
		$this->assignRef('lists', $lists);
		$this->assignRef('items', $items);
		$this->assignRef('button', $button);
		$this->assignRef('buttongeo', $buttonGeo);
		$this->assignRef('request_url',	$uri->toString());

		parent::display($tpl);
		$this->_setToolbar($isNew);
	}
	
	function _setToolbar($isNew) {
		
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Phoca Gallery Image' ).': <small><small>[ ' . $text.' ]</small></small>', 'gallery' );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
}
?>
