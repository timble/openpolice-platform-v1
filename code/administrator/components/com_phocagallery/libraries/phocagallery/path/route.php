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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.helper');

class PhocaGalleryRoute
{
	function getCategoriesRoute() {
		$needles = array(
			'categories' => ''
		);
		
		// Current Itemid on the site
		// Can be a categories Itemid or category Itemid
		//$itemIdSite = JRequest::getVar('Itemid', 0, '', 'int')
		
		$link = 'index.php?option=com_phocagallery&view=categories';

		if($item = PhocaGalleryRoute::_findItem($needles, 1)) {
			if(isset($item->query['layout'])) {
				$link .= '&layout='.$item->query['layout'];
			}
			if (isset($item->id)) {
				$link .= '&Itemid='.$item->id;
			}
		};

		return $link;
	}
	
	function getCategoryRoute($catid, $catidAlias = '') {
		$needles = array(
			'category' => (int) $catid,
			'categories' => ''
		);
		
		if ($catidAlias != '') {
			$catid = $catid . ':' . $catidAlias;
		}

		//Create the link
		$link = 'index.php?option=com_phocagallery&view=category&id='. $catid;

		if($item = PhocaGalleryRoute::_findItem($needles)) {
			if(isset($item->query['layout'])) {
				$link .= '&layout='.$item->query['layout'];
			}
			if(isset($item->id)) {
				$link .= '&Itemid='.$item->id;
			}
		};

		return $link;
	}
	


	function getImageRoute($id, $catid = 0, $idAlias = '', $catidAlias = '', $type = 'detail', $suffix = '')
	{
		$needles = array(
			'detail'  => (int) $id,
			'category' => (int) $catid,
			'categories' => ''
		);
		
		
		if ($idAlias != '') {
			$id = $id . ':' . $idAlias;
		}
		if ($catidAlias != '') {
			$catid = $catid . ':' . $catidAlias;
		}
		
		//Create the link
		
		switch ($type)
		{
			case 'detail';
				$link = 'index.php?option=com_phocagallery&view=detail&catid='. $catid .'&id='. $id;
				break;
			default;
				$link = '';
		}

		if ($item = PhocaGalleryRoute::_findItem($needles)) {
			if (isset($item->id)) {
				$link .= '&Itemid='.$item->id;
			}
		}
		
		if ($suffix != '') {
			$link .= '&'.$suffix;
		}

		return $link;
	}

	function _findItem($needles, $notCheckId = 0) {
		$component 		= &JComponentHelper::getComponent('com_phocagallery');
		$menus			= &JApplication::getMenu('site', array());
		$items			= $menus->getItems('componentid', $component->id);
		$currentItemId 	= JRequest::getVar('Itemid', 0, '', 'int');
		
		if(!$items) {
			return JRequest::getVar('Itemid', 0, '', 'int');
		}
		
		$match = null;
		foreach($needles as $needle => $id) {
			
			if ($notCheckId == 0) {

				// Try to find the same Itemid like the current site has
				// The itemid of current site can be itemid of other view
				// In such case and in case no itemid will be found
				// try to find some other itemid
				// Example: categories view - if not found: currentItemid is not
				//          found in categories view, try to find some other
				//          categories view itemid (by backlinks e.g.)
				$sameIdFound = 0;
				foreach($items as $item) {
					if ((int)$currentItemId > 0) {
						if ((@$item->query['view'] == $needle) && (@$item->query['id'] == $id) && ($currentItemId == $item->id)) {
						$match = $item;
						$sameIdFound = 1;
						break;
						}
					}
				}	
				// Continue searching of other itemid
				if ($sameIdFound == 0) {
					foreach($items as $item) {
						if ((@$item->query['view'] == $needle) && (@$item->query['id'] == $id)) {
							$match = $item;
							break;
						}
					}
				}
			} else {
				$sameIdFound = 0;
				foreach($items as $item) {
					if ((int)$currentItemId > 0) {
						if ((@$item->query['view'] == $needle) && ($currentItemId == $item->id)) {
						$match = $item;
						$sameIdFound = 1;
						break;
						}
					}
				}
				if ($sameIdFound == 0) {
					foreach($items as $item) {
						if (@$item->query['view'] == $needle) {
							$match = $item;
							break;
						}
					}
				}
			}

			if(isset($match)) {
				break;
			}
		}

		return $match;
	}
}
?>
