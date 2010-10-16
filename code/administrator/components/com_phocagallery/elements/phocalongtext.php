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
defined('JPATH_BASE') or die();

class JElementPhocaLongText extends JElement
{
	var	$_name 			= 'PhocaLongText';
	var $_phocaParams 	= null;

	function fetchElement($name, $value, &$node, $control_name)
	{
		$document	= &JFactory::getDocument();
		$option 	= JRequest::getCmd('option');
		
		$globalValue = &$this->_getPhocaParameter( $name );	

		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"' );
        /*
         * Required to avoid a cycle of encoding &
         * html_entity_decode was used in place of htmlspecialchars_decode because
         * htmlspecialchars_decode is not compatible with PHP 4
         */
        $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);

		// MENU - Set default value to "" because of saving "" value into the menu link ( use global = "")
		if ($option == "com_menus") {
			$defaultValue	= $node->attributes('default');
			if ($value == $defaultValue) {
				$value = '';
			}
		}
		
		$html ='<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' />';		
		
		// MENU - Display the global value
		if ($option == "com_menus") {
			$html .='<br /><span>[ </span><input type="text"  value="'. $globalValue .'" style="width:15em;border:1px solid #fff;background:#fff;margin-top:3px;" /><span> ]</span>'; 
		}
	return $html;
	}
	
	function _setPhocaParams(){
	
		$component 		= 'com_phocagallery';
		$table 			=& JTable::getInstance('component');
		$table->loadByOption( $component );
		$phocaParams 		= new JParameter( $table->params );
		$this->_phocaParams	= $phocaParams;
	}

	function _getPhocaParameter( $name ){
	
		// Don't call sql query by every param item (it will be loaded only one time)
		if (!$this->_phocaParams) {
			$params = &$this->_setPhocaParams();
		}
		$globalValue 	= &$this->_phocaParams->get( $name, '' );	
		return $globalValue;
	}
}
?>