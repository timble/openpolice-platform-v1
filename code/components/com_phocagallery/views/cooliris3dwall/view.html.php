<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die();
jimport( 'joomla.application.component.view' );
class PhocaGalleryViewCooliris3DWall extends JView
{
	function display($tpl = null) {
		
		global $mainframe;
		$document			= &JFactory::getDocument();
		$uri 				= &JFactory::getURI();
		$menus				= &JSite::getMenu();
		$menu				= $menus->getActive();
		$params				= &$mainframe->getParams();
		$tmpl['path']		= &PhocaGalleryPath::getPath();

		$model				= &$this->getModel();

		// PARAMS
		$tmpl['displaycatnametitle'] 		= $params->get( 'display_cat_name_title', 1 );
		$display_cat_name_breadcrumbs 		= $params->get( 'display_cat_name_breadcrumbs', 1 );
		$tmpl['showpagetitle'] 				= $params->get( 'show_page_title', 1 );
		$tmpl['cooliris3d_wall_width']		= $params->get( 'cooliris3d_wall_width', 600 );
		$tmpl['cooliris3d_wall_height']		= $params->get( 'cooliris3d_wall_height', 370 );
		$tmpl['gallerymetakey'] 			= $params->get( 'gallery_metakey', '' );
		$tmpl['gallerymetadesc'] 			= $params->get( 'gallery_metadesc', '' );
		$tmpl['nm'] 						= PhocaGalleryRenderFront::getString();
		
		if ($tmpl['gallerymetakey'] != '') {
			$mainframe->addMetaTag('keywords', $tmpl['gallerymetakey']);
		}
		if ($tmpl['gallerymetadesc'] != '') {
			$mainframe->addMetaTag('description', $tmpl['gallerymetadesc']);
		}
		
		$idCategory							= $params->get( 'categoryid', 0 );
		
		if ((int)$idCategory > 0) {
			$category	= $model->getCategory($idCategory);
			// Define image tag attributes
			if (!empty ($category->image)) {
				$attribs['align'] = '"'.$category->image_position.'"';
				$attribs['hspace'] = '"6"';
				$tmpl['image'] = JHTML::_('image', 'images/stories/'.$category->image, JText::_('Phoca gallery'), $attribs);
			}
			
			$this->_addBreadCrumbs($category, isset($menu->query['id']) ? $menu->query['id'] : 0, $display_cat_name_breadcrumbs);

			// ASIGN
			$tmpl['display_category']		= 1;
			$this->assignRef( 'tmpl',		$tmpl);
			$this->assignRef( 'category',	$category);
			$this->assignRef( 'params' ,	$params);
		} else {
			$tmpl['display_category']		= 0;
			$this->assignRef( 'tmpl',		$tmpl);
		}
			parent::display($tpl);
	}
	
	/**
	 * Method to add Breadcrubms in Phoca Gallery
	 * @param array $category Object array of Category
	 * @param int $rootId Id of Root Category
	 * @param int $displayStyle Displaying of Breadcrubm - Nothing, Category Name, Menu link with Name
	 * @return string Breadcrumbs
	 */
	function _addBreadCrumbs($category, $rootId, $displayStyle) {
	    global $mainframe;
	
	    $pathway 		=& $mainframe->getPathway();
		$pathWayItems 	= $pathway->getPathWay();
		$lastItemIndex 	= count($pathWayItems) - 1;
		switch ($displayStyle)  {
			case 0:	// 0 - only menu link
				// do nothing
				break;
			case 1:	// 1 - menu link with category name
				// replace the last item in the breadcrumb (menu link title) with the current value plus the category title
				$pathway->setItemName($lastItemIndex, $pathWayItems[$lastItemIndex]->name . ' - ' . $category->title);
				break;
			case 2:	// 2 - only category name
				// replace the last item in the breadcrumb (menu link title) with the category title
				$pathway->setItemName($lastItemIndex, $category->title);
				break;
		}
	}	
}
?>
