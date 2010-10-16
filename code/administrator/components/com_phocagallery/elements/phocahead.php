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
defined('_JEXEC') or die();

class JElementPhocaHead extends JElement
{
	var	$_name = 'PhocaHead';

	function fetchTooltip($label, $description, &$node, $control_name, $name) {
		$phocaImage	= ( $node->attributes('phocaimage') ? $node->attributes('phocaimage') : '' );
		if($phocaImage != ''){
			return JHTML::_('image.site',  $phocaImage, '/components/com_phocagallery/assets/images/', NULL, NULL, '' );
		} else {
			return '&nbsp;';
		}
	}

	function fetchElement($name, $value, &$node, $control_name)
	{
		if ($value) {
			return '<p style="background: #CCE6FF;color: #0069CC;padding:5px"><strong>' . JText::_($value) . '</strong></p>';
		} else {
			return '<hr />';
		}
	}
}
?>