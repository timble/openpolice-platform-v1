<?php

/**
 * @package   	JCE
 * @copyright 	Copyright (c) 2009-2013 Ryan Demmer. All rights reserved.
 * @license   	GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined( '_JEXEC' ) or die('RESTRICTED');
?>
<fieldset class="media_option flash"><legend><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_OPTIONS');?></legend>
	<table border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td><label for="flash_quality"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_QUALITY');?></label></td>
			<td><select id="flash_quality">
				<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
				<option value="high"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_HIGH');?></option>
				<option value="low"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_LOW');?></option>
				<option value="autolow"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_AUTOLOW');?></option>
				<option value="autohigh"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_AUTOHIGH');?></option>
				<option value="best"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_BEST');?></option>
			</select></td>
	
			<td><label for="flash_scale"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_SCALE');?></label></td>
			<td><select id="flash_scale">
				<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
				<option value="showall"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_SHOWALL');?></option>
				<option value="noborder"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_NOBORDER');?></option>
				<option value="exactfit"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_EXACTFIT');?></option>
			</select></td>
		</tr>
	
		<tr>
			<td><label for="flash_wmode"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_WMODE');?></label></td>
			<td><select id="flash_wmode">
				<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
				<option value="window"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_WINDOW');?></option>
				<option value="opaque"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_OPAQUE');?></option>
				<option value="transparent" selected="selected"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_TRANSPARENT');?></option>
			</select></td>
	
			<td><label for="flash_salign"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_SALIGN');?></label></td>
			<td><select id="flash_salign">
				<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
				<option value="l"><?php echo WFText::_('WF_OPTION_LEFT');?></option>
				<option value="t"><?php echo WFText::_('WF_OPTION_TOP');?></option>
				<option value="r"><?php echo WFText::_('WF_OPTION_RIGHT');?>t</option>
				<option value="b"><?php echo WFText::_('WF_OPTION_BOTTOM');?></option>
				<option value="tl"><?php echo WFText::_('WF_OPTION_TOP_LEFT');?></option>
				<option value="tr"><?php echo WFText::_('WF_OPTION_TOP_RIGHT');?></option>
				<option value="bl"><?php echo WFText::_('WF_OPTION_BOTTOM_LEFT');?></option>
				<option value="br"><?php echo WFText::_('WF_OPTION_BOTTOM_RIGHT');?></option>
			</select></td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="flash_play"
						checked="checked" /></td>
					<td><label for="flash_play"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_PLAY');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="flash_loop"
						checked="checked" /></td>
					<td><label for="flash_loop"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_LOOP');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="flash_menu"
						checked="checked" /></td>
					<td><label for="flash_menu"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_MENU');?></label></td>
				</tr>
			</table>
			</td>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="flash_swliveconnect" /></td>
					<td><label for="flash_swliveconnect"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_LIVECONNECT');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="4">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="flash_allowfullscreen" /></td>
					<td><label for="flash_allowfullscreen"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_ALLOWFULLSCREEN');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	
	<table>
		<tr>
			<td><label for="flash_base"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_BASE');?></label></td>
			<td><input type="text" id="flash_base" /></td>
		</tr>
	
		<tr>
			<td><label for="flash_flashVars"><?php echo WFText::_('WF_MEDIAMANAGER_FLASH_FLASHVARS');?></label></td>
			<td><textarea id="flash_flashvars" rows="3"></textarea></td>
		</tr>
	</table>
	<h6 class="notice">Adobe and Flash are either registered trademarks or trademarks 
	of Adobe Systems Incorporated in the United States and/or other 
	countries.</h6>
</fieldset>