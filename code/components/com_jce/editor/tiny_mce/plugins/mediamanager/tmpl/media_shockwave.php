<?php
/**
* @version		$Id: media_shockwave.php 199 2011-05-06 16:45:28Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JEXEC' ) or die('ERROR_403');
?>
<fieldset class="media_option" id="shockwave_options"><legend><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_OPTIONS');?></legend>
			
	<table border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td><label for="shockwave_swstretchstyle"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_SWSTRETCHSTYLE');?></label></td>
			<td><select id="shockwave_swstretchstyle">
				<option value="none"><?php echo WFText::_('WF_OPTION_NONE');?></option>
				<option value="meet"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_MEET');?></option>
				<option value="fill"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_FILL');?></option>
				<option value="stage"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_STAGE');?></option>
			</select></td>
	
			<td><label for="shockwave_swvolume"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_VOLUME');?></label></td>
			<td><input type="text" id="shockwave_swvolume" /></td>
		</tr>
	
		<tr>
			<td><label for="shockwave_swstretchhalign"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_SWSTRETCHHALIGN');?></label></td>
			<td><select id="shockwave_swstretchhalign">
				<option value="none"><?php echo WFText::_('WF_OPTION_NONE');?></option>
				<option value="left"><?php echo WFText::_('WF_OPTION_LEFT');?></option>
				<option value="center"><?php echo WFText::_('WF_OPTION_CENTER');?></option>
				<option value="right"><?php echo WFText::_('WF_OPTION_RIGHT');?></option>
			</select></td>
	
			<td><label for="shockwave_swstretchvalign"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_SWSTRETCHVALIGN');?></label></td>
			<td><select id="shockwave_swstretchvalign">
				<option value="none"><?php echo WFText::_('WF_OPTION_NONE');?></option>
				<option value="meet"><?php echo WFText::_('WF_OPTION_TOP');?></option>
				<option value="fill"><?php echo WFText::_('WF_OPTION_CENTER');?></option>
				<option value="stage"><?php echo WFText::_('WF_OPTION_BOTTOM');?></option>
			</select></td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="shockwave_autostart"
						checked="checked" /></td>
					<td><label for="shockwave_autostart"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_AUTOSTART');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="shockwave_sound"
						checked="checked" /></td>
					<td><label for="shockwave_sound"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_SOUND');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="shockwave_swliveconnect" /></td>
					<td><label for="shockwave_swliveconnect"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_LIVECONNECT');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="shockwave_progress"
						checked="checked" /></td>
					<td><label for="shockwave_progress"><?php echo WFText::_('WF_MEDIAMANAGER_SHOCKWAVE_PROGRESS');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
</fieldset>