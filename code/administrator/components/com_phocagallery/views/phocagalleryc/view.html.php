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
phocagalleryimport('phocagallery.access.access');
phocagalleryimport('phocagallery.rate.ratecategory');
class PhocaGalleryCpViewPhocaGalleryC extends JView
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

		$paramsC = JComponentHelper::getParams('com_phocagallery');
		$tmpl['enablepicasaloading'] = $paramsC->get( 'enable_picasa_loading', 1 );		
		
		JHTML::_('behavior.calendar');
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		
		//Data from model
		$items	=& $this->get('Data');
	
		//Image button
		$link = 'index.php?option=com_phocagallery&amp;view=phocagalleryf&amp;tmpl=component';
		JHTML::_('behavior.modal', 'a.modal-button');
		$button = new JObject();
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_( 'Folder' ));
		$button->set('name', 'image');
		$button->set('modalname', 'modal-button');
		$button->set('options', "{handler: 'iframe', size: {x: 620, y: 400}}");
		
		$lists 	= array();		
		$isNew	= ((int)$items->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'Phoca Gallery Categories' ), $items->title );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}

		// Edit or Create?
		if (!$isNew) {
			$model->checkout( $user->get('id') );
		} else {
			// initialise new record
			$items->approved 		= 1;
			$items->published 		= 1;
			$items->order 			= 0;
			$items->access			= 0;
		}

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, title AS text'
			. ' FROM #__phocagallery_categories'
			. ' ORDER BY ordering';
		$lists['ordering'] 			= JHTML::_('list.specificordering',  $items, $items->id, $query, false );
		// build the html select list
		$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $items->published );
		$lists['approved'] 			= JHTML::_('select.booleanlist',  'approved', 'class="inputbox"', $items->approved );
		
		$active =  ( $items->image_position ? $items->image_position : 'left' );
		$lists['image_position'] 	= JHTML::_('list.positions',  'image_position', $active, NULL, 0, 0 );
		// Imagelist
		$lists['image'] 			= JHTML::_('list.images',  'image', $items->image );
		// build the html select list for the group access
		$lists['access'] 			= JHTML::_('list.accesslevel',  $items );
		
		// All selected users
		
		// Create a multiple selectbox
		$lists['accessusers'] 	= PhocaGalleryAccess::usersList('accessuserid[]',$items->accessuserid,1, NULL,'name',0 );
		$lists['uploadusers'] 	= PhocaGalleryAccess::usersList('uploaduserid[]',$items->uploaduserid,1, NULL,'name',0 );
		$lists['deleteusers'] 	= PhocaGalleryAccess::usersList('deleteuserid[]',$items->deleteuserid,1, NULL,'name',0 );
		$lists['owner'] 		= PhocaGalleryAccess::usersListOwner('ownerid',$items->owner_id,1, NULL,'name',0 );
		
		// - - - - - - - - - - - - - - - 
		// Build the list of categories
		$query = 'SELECT a.title AS text, a.id AS value, a.parent_id as parentid'
		. ' FROM #__phocagallery_categories AS a'
	//	. ' WHERE a.published = 1'
		. ' ORDER BY a.ordering';
		$db->setQuery( $query );
		$itemss = $db->loadObjectList();
		
		// New or Edit
		if (!$isNew) {
			$itemsId = $items->id;
		} else {
			$itemsId = -1;
		}
		$tree = array();
		$text = '';
		$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($itemss, $tree, 0, $text, $itemsId);
		array_unshift($tree, JHTML::_('select.option', '0', '- '.JText::_('Select Parent Category').' -', 'value', 'text'));
		
		//list categories
		$lists['parentid'] = JHTML::_( 'select.genericlist', $tree, 'parentid',  '', 'value', 'text', $items->parent_id);
		// - - - - - - - - - - - - - - - 
		
		// Clean gallery data
		jimport('joomla.filter.output');
		JFilterOutput::objectHTMLSafe( $items, ENT_QUOTES, 'description' );


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
		
		$linkGeo = 'index.php?option=com_phocagallery&amp;view=phocagalleryg&amp;tmpl=component&amp;lat='.$latitudeLink.'&amp;lng='.$longitudeLink.'&amp;zoom='.$zoomLink;
		JHTML::_('behavior.modal', 'a.modal-button');
		$buttonGeo = new JObject();
		$buttonGeo->set('modal', true);
		$buttonGeo->set('link', $linkGeo);
		$buttonGeo->set('text', JText::_( 'coordinates' ));
		$buttonGeo->set('name', 'image');
		$buttonGeo->set('modalname', 'modal-button');
		$buttonGeo->set('options', "{handler: 'iframe', size: {x: 640, y: 560}}");
		// - - - - - - - - - - - - - - - - - - - - - 
		
		
		$this->assignRef('editor', $editor);
		$this->assignRef('lists', $lists);
		$this->assignRef('items', $items);
		$this->assignRef('button', $button);
		$this->assignRef('buttongeo', $buttonGeo);		
		$this->assignRef('tmpl', $tmpl);
		$this->assignRef('request_url',	$uri->toString());

		parent::display($tpl);
		$this->_setToolbar($isNew, $paramsC);
	}
	
	function _setToolbar($isNew, $params) {
		
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Phoca Gallery Category' ).': <small><small>[ ' . $text.' ]</small></small>' , 'category');
		JToolBarHelper::save();
		JToolBarHelper::apply();
		
		$enable_picasa_loading = $params->get( 'enable_picasa_loading', 1 );	
		if($enable_picasa_loading == 1){
			JToolBarHelper::customX('loadextimg', 'loadext.png', '', JText::_( 'PHOCAGALLERY_LOAD_EXT_IMAGES' ), false);
		}

		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
}
?>
