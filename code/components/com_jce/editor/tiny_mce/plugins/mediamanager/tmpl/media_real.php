<?php
/**
* @version		$Id: media_real.php 199 2011-05-06 16:45:28Z happy_noodle_boy $
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
<fieldset class="media_option" id="real_options"><legend><?php echo WFText::_('WF_MEDIAMANAGER_REAL_OPTIONS');?></legend>
			
	<table border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="real_autostart" /></td>
					<td><label for="real_autostart"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_AUTOSTART');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="real_loop" /></td>
					<td><label for="real_loop"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_LOOP');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="real_autogotourl"
						checked="checked" /></td>
					<td><label for="real_autogotourl"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_AUTOGOTOURL');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="real_center" /></td>
					<td><label for="real_center"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_CENTER');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="real_imagestatus"
						checked="checked" /></td>
					<td><label for="real_imagestatus"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_IMAGESTATUS');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="real_maintainaspect" /></td>
					<td><label for="real_maintainaspect"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_MAINTAINASPECT');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="real_nojava" /></td>
					<td><label for="real_nojava"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_NOJAVA');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="real_prefetch" /></td>
					<td><label for="real_prefetch"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_PREFETCH');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="real_shuffle" /></td>
					<td><label for="real_shuffle"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_SHUFFLE');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">&nbsp;</td>
		</tr>
	
		<tr>
			<td><label for="real_console"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_CONSOLE');?></label></td>
			<td><input type="text" id="real_console" /></td>
	
			<td><label for="real_controls"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_CONTROLS');?></label></td>
			<td><input type="text" id="real_controls" /></td>
		</tr>
	
		<tr>
			<td><label for="real_numloop"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_NUMLOOP');?></label></td>
			<td><input type="text" id="real_numloop" /></td>
	
			<td><label for="real_scriptcallbacks"><?php echo WFText::_('WF_MEDIAMANAGER_REAL_SCRIPTCALLBACKS');?></label></td>
			<td><input type="text" id="real_scriptcallbacks" /></td>
		</tr>
	</table>
	<h6 class="notice">RealNetworks, Real, the Real logo, RealPlayer, and the RealPlayer logo are trademarks or registered trademarks of RealNetworks, Inc.</h6>
</fieldset>