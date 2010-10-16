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

class PhocaGalleryRenderAdmin
{
	function renderExternalLink($extLink) {
	
		$extLinkArray	= explode("|", $extLink, 4);
		if (!isset($extLinkArray[0])) {$extLinkArray[0] = '';}
		if (!isset($extLinkArray[1])) {$extLinkArray[1] = '';}
		if (!isset($extLinkArray[2])) {$extLinkArray[2] = '_self';}
		if (!isset($extLinkArray[3])) {$extLinkArray[3] = 1;}
	
		return $extLinkArray;
	}
	
	function quickIconButton( $link, $image, $text ) {
		
		$lang	= &JFactory::getLanguage();
		$button = '';
		if ($lang->isRTL()) {
			$button .= '<div style="float:right;">';
		} else {
			$button .= '<div style="float:left;">';
		}
		$button .=	'<div class="icon">'
				   .'<a href="'.$link.'">'
				   .JHTML::_('image.site',  $image, '/components/com_phocagallery/assets/images/', NULL, NULL, $text )
				   .'<span>'.$text.'</span></a>'
				   .'</div>';
		$button .= '</div>';

		return $button;
	}
	
	function renderThumbnailCreationStatus($status = 1, $onlyImage = 0) {
		switch ($status) {
			case 0:
				$statusData = array('disabled', 'false');
			break;
			case 1:
			default:
				$statusData = array('enabled', 'true');
			break;
		}
		
		if ($onlyImage == 1) {
			return JHTML::_('image.site',  'icon-16-'.$statusData[1].'.png', '/components/com_phocagallery/assets/images/', NULL, NULL, $statusData[0] );
		} else {
			return '<span class="hasTip" title="'.JText::_('Thumbnail Creation is ' . $statusData[0]) . '::'.JText::_('Thumbnail Creation Status Info').'">'.JText::_('Thumbnail Creation Status') . ': '. JHTML::_('image.site',  'icon-16-'.$statusData[1].'.png', '/components/com_phocagallery/assets/images/', NULL, NULL, $statusData[0] ) . '</span>';
		}
	}
	
	function CategoryTreeOption($data, $tree, $id=0, $text='', $currentId) {		

		foreach ($data as $key) {	
			$show_text =  $text . $key->text;
			
			if ($key->parentid == $id && $currentId != $id && $currentId != $key->value) {
				$tree[$key->value] 			= new JObject();
				$tree[$key->value]->text 	= $show_text;
				$tree[$key->value]->value 	= $key->value;
				$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($data, $tree, $key->value, $show_text . " &raquo; ", $currentId );	
			}	
		}
		return($tree);
	}
	
	function approved( &$row, $i, $imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='' )
	{
		$img 	= $row->approved ? $imgY : $imgX;
		$task 	= $row->approved ? 'disapprove' : 'approve';
		$alt 	= $row->approved ? JText::_( 'Approved' ) : JText::_( 'Not Approved' );
		$action = $row->approved ? JText::_( 'Disapprove Item' ) : JText::_( 'Approve item' );

		$href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $prefix.$task .'\')" title="'. $action .'">
		<img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>'
		;

		return $href;
	}
}
?>