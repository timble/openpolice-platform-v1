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
<fieldset class="media_option windowsmedia"><legend><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_OPTIONS');?></legend>	
	
	<table border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="windowsmedia_autostart" checked="checked" /></td>
					<td><label for="windowsmedia_autostart"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_AUTOSTART');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="windowsmedia_enabled" /></td>
					<td><label for="windowsmedia_enabled"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_ENABLED');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="windowsmedia_enablecontextmenu" checked="checked" /></td>
					<td><label for="windowsmedia_enablecontextmenu"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_MENU');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="windowsmedia_fullscreen" /></td>
					<td><label for="windowsmedia_fullscreen"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_FULLSCREEN');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="windowsmedia_invokeurls" checked="checked" /></td>
					<td><label for="windowsmedia_invokeurls"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_INVOKEURLS');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="windowsmedia_mute" /></td>
					<td><label for="windowsmedia_mute"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_MUTE');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="windowsmedia_stretchtofit" /></td>
					<td><label for="windowsmedia_stretchtofit"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_STRETCHTOFIT');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="windowsmedia_windowlessvideo" /></td>
					<td><label for="windowsmedia_windowlessvideo"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_WINDOWLESSVIDEO');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td><label for="windowsmedia_balance"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_BALANCE');?></label></td>
			<td><input type="text" id="windowsmedia_balance" /></td>
	
			<td><label for="windowsmedia_baseurl"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_BASEURL');?></label></td>
			<td><input type="text" id="windowsmedia_baseurl" /></td>
		</tr>
	
		<tr>
			<td><label for="windowsmedia_captioningid"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_CAPTIONINGID');?></label></td>
			<td><input type="text" id="windowsmedia_captioningid" /></td>
	
			<td><label for="windowsmedia_currentmarker"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_CURRENTMARKER');?></label></td>
			<td><input type="text" id="windowsmedia_currentmarker" /></td>
		</tr>
	
		<tr>
			<td><label for="windowsmedia_currentposition"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_CURRENTPOSITION');?></label></td>
			<td><input type="text" id="windowsmedia_currentposition" /></td>
	
			<td><label for="windowsmedia_defaultframe"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_DEFAULTFRAME');?></label></td>
			<td><input type="text" id="windowsmedia_defaultframe" /></td>
		</tr>
	
		<tr>
			<td><label for="windowsmedia_playcount"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_PLAYCOUNT');?></label></td>
			<td><input type="text" id="windowsmedia_playcount" /></td>
	
			<td><label for="windowsmedia_rate"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_RATE');?></label></td>
			<td><input type="text" id="windowsmedia_rate" /></td>
		</tr>
	
		<tr>
			<td><label for="windowsmedia_uimode"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_UIMODE');?></label></td>
			<td><input type="text" id="windowsmedia_uimode" /></td>
	
			<td><label for="windowsmedia_volume"><?php echo WFText::_('WF_MEDIAMANAGER_WINDOWSMEDIA_VOLUME');?></label></td>
			<td><input type="text" id="windowsmedia_volume" /></td>
		</tr>
	
	</table>

	<h6 class="notice">Windows Media is either a registered trademark or trademark of Microsoft Corporation in the United States and/or other countries.</h6>
</fieldset>