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

class PhocaGalleryVirtueMart
{
	function getVmLink($id, &$errorMsg) {
	
		$dbO =& JFactory::getDBO();

		if (is_file( JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php')) {
			require_once( JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php' );
		} else {
			$errorMsg = 'VirtueMart Parser Not Found';
			return false;
		}
		if (is_file( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart.cfg.php')) {
			require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart.cfg.php' );
		} else {
			$errorMsg = 'VirtueMart Cfg Not Found';
			return false;
		}
		if (VM_TABLEPREFIX && FLYPAGE) {
			$vmPrefixC 		= VM_TABLEPREFIX;
			$flyPageC		= FLYPAGE;
			$checkStockC	= CHECK_STOCK;
			$showOutStockC	= PSHOP_SHOW_OUT_OF_STOCK_PRODUCTS;
		} else {
			$errorMsg = 'VirtueMart Constants Not Found';
			return false;
		}

		if( $checkStockC && $showOutStockC != "1") {
		    $checkStockSql = " AND product_in_stock > 0 \n";
	    } else {
			$checkStockSql = '';
		}
		
		// We check publish adn if the product is on the stock (if the check is enabled in VM)
		$query = 'SELECT product_publish' .
			' FROM #__'.$vmPrefixC.'_product'.
			' WHERE product_id = '.(int) $id.
			$checkStockSql;
	
		$dbO->setQuery($query);
		$publish = $dbO->loadObject();
	
		if (isset($publish->product_publish) && $publish->product_publish == 'Y') {
			$query = 'SELECT category_id' .
			' FROM #__'.$vmPrefixC.'_product_category_xref'.
			' WHERE product_id = '.(int) $id;
	
			$dbO->setQuery($query);
			$categoryId = $dbO->loadObject();
		
			if (isset($categoryId->category_id)) {
			
				$flypage 	= PhocaGalleryVirtueMart::_getVmFlypage($vmPrefixC, $flyPageC, $categoryId->category_id);
				$itemId		= PhocaGalleryVirtueMart::_getVmItemid();
				$vmLink 	= 'index.php?option=com_virtuemart&page=shop.product_details&flypage='.$flypage.'&product_id='.$id.'&Itemid='.$itemId;
				return $vmLink;
			} else {
				$errorMsg = 'VirtueMart Category Not Found';
				return false;
			}
		
		} else {
			$errorMsg = 'VirtueMart Product Not Found';
			return false;
		}
	}
	
	function _getVmFlypage($vmPrefixC, $flyPageC, $category_id) {
		
		$dbO =& JFactory::getDBO();
		$query = 'SELECT category_flypage' .
			' FROM #__'.$vmPrefixC.'_category'.
			' WHERE category_id = '.(int) $category_id;
		$dbO->setQuery($query);
		$flypage = $dbO->loadObject();
		
		if (!isset($flypage->category_flypage) || (isset($flypage->category_flypage) && $flypage->category_flypage =='')) {
			// We don't have flypage, so we try the parent_id
			$query = 'SELECT category_parent_id' .
			' FROM #__'.$vmPrefixC.'_category_xref'.
			' WHERE category_child_id = '.(int) $category_id;
			$dbO->setQuery($query);
			$parentId = $dbO->loadObject();
			if (isset($parentId->category_parent_id) && $parentId->category_parent_id > 0) {
				//recursive function to find the last parent_id
				$flypageR = PhocaGalleryVirtueMart::_getVmFlypage($vmPrefixC, $flyPageC, $parentId->category_parent_id);
			} else {
				// we still don't have the
				// the constant from VM config				
				$flypageR = $flyPageC; 
			}
			return $flypageR;
			
		} else {
			
			return $flypage->category_flypage;
		}
	}
	
	function _getVmItemid() {
		// Set Itemid id, exists this link in Menu?
		$menu 	= &JSite::getMenu();
		$itemVM	= $menu->getItems('link', 'index.php?option=com_virtuemart');
		

		if(isset($itemVM[0])) {
			$itemId = $itemVM[0]->id;
		} else {
			$itemId = 0;
		}
	
		return $itemId;
	}
}