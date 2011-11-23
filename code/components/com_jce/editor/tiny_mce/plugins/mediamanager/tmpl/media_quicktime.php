<?php
/**
* @version		$Id: media_quicktime.php 199 2011-05-06 16:45:28Z happy_noodle_boy $
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
<fieldset class="media_option" id="quicktime_options"><legend><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_OPTIONS');?></legend>
	<table border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="quicktime_loop" /></td>
					<td><label for="quicktime_loop"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_LOOP');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="quicktime_autoplay" /></td>
					<td><label for="quicktime_autoplay"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_AUTOPLAY');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="quicktime_cache" /></td>
					<td><label for="quicktime_cache"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_CACHE');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="quicktime_controller" checked="checked" /></td>
					<td><label for="quicktime_controller"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_CONTROLLER');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="quicktime_correction" /></td>
					<td><label for="quicktime_correction"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_CORRECTION');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="quicktime_enablejavascript" /></td>
					<td><label for="quicktime_enablejavascript"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_ENABLEJAVASCRIPT');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="quicktime_kioskmode" /></td>
					<td><label for="quicktime_kioskmode"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_KIOSKMODE');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="quicktime_autohref" /></td>
					<td><label for="quicktime_autohref"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_AUTOHREF');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="quicktime_playeveryframe" /></td>
					<td><label for="quicktime_playeveryframe"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_PLAYEVERYFRAME');?></label></td>
				</tr>
			</table>
			</td>
	
			<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox"
						id="quicktime_targetcache" /></td>
					<td><label for="quicktime_targetcache"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_TARGETCACHE');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
	
		<tr>
			<td><label for="quicktime_scale"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_SCALE');?></label></td>
			<td><select id="quicktime_scale" class="mceEditableSelect">
				<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
				<option value="tofit"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_TOFIT');?></option>
				<option value="aspect"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_ASPECT');?></option>
			
			</select></td>
	
			<td colspan="2">&nbsp;</td>
		</tr>
	
		<tr>
			<td><label for="quicktime_starttime"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_STARTTIME');?></label></td>
			<td><input type="text" id="quicktime_starttime" /></td>
	
			<td><label for="quicktime_endtime"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_ENDTIME');?></label></td>
			<td><input type="text" id="quicktime_endtime" /></td>
		</tr>
	
		<tr>
			<td><label for="quicktime_target"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_TARGET');?></label></td>
			<td><input type="text" id="quicktime_target" /></td>
	
			<td><label for="quicktime_href"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_HREF');?></label></td>
			<td><input type="text" id="quicktime_href" /></td>
		</tr>
	
		<tr>
			<td><label for="quicktime_qtsrcchokespeed"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_QTSRCCHOKESPEED');?></label></td>
			<td><input type="text" id="quicktime_qtsrcchokespeed" /></td>
	
			<td><label for="quicktime_volume"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_VOLUME');?></label></td>
			<td><input type="text" id="quicktime_volume" /></td>
		</tr>
	
		<tr>
			<td><label for="quicktime_qtsrc"><?php echo WFText::_('WF_MEDIAMANAGER_QUICKTIME_QTSRC');?></label></td>
			<td colspan="4">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><input type="text" id="quicktime_qtsrc" /></td>
					<td id="qtsrcfilebrowsercontainer">&nbsp;</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	<h6 class="notice">QuickTime® is a trademark of Apple Inc., registered in the U.S. and other countries.</h6>
</fieldset>