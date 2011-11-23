<?php
/**
* @version		$Id: media_video.php 199 2011-05-06 16:45:28Z happy_noodle_boy $
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
<fieldset class="media_option" id="video_options"><legend><?php echo WFText::_('WF_MEDIAMANAGER_VIDEO_OPTIONS');?></legend>
			
	<table border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="video_autoplay" /></td>
					<td><label for="video_autoplay"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_AUTOPLAY');?></label></td>
				</tr>
			</table>
			</td>
	
			<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="video_controls" checked="checked" /></td>
					<td><label for="video_controls"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_CONTROLS');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="video_loop" /></td>
					<td><label for="video_loop"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_LOOP');?></label></td>
				</tr>
			</table>
			</td>
	
			<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="checkbox" class="checkbox" id="video_audio" /></td>
					<td><label for="video_audio"><?php echo WFText::_('WF_MEDIAMANAGER_VIDEO_MUTE');?></label></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td><label for="video_preload"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_PRELOAD');?></label></td>
			<td><select id="video_preload">
				<option value=""><?php echo WFText::_('WF_OPTION_AUTO');?></option>
				<option value="none"><?php echo WFText::_('WF_OPTION_NONE');?></option>
				<option value="metadata"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_METADATA');?></option>
			</select></td>
		</tr>
		<tr>
			<td><label for="video_poster"><?php echo WFText::_('WF_MEDIAMANAGER_VIDEO_POSTER');?></label></td>
			<td><input type="text" id="video_poster" class="browser image" /></td>
		</tr>
		<tr>
			<td><label for="video_source"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_SOURCE');?></label></td>
			<td colspan="2"><input type="text" name="video_source[]"
				class="active" onclick="MediaManagerDialog.setSourceFocus(this);" /></td>
		</tr>
		<tr>
			<td><label for="video_source"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_SOURCE');?></label></td>
			<td colspan="2"><input type="text" name="video_source[]"
				onclick="MediaManagerDialog.setSourceFocus(this);" /></td>
		</tr>
		<tr>
			<td><label for="video_fallback"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_FALLBACK');?></label></td>
			<td><input type="text" id="video_fallback"
				onclick="MediaManagerDialog.setSourceFocus(this);" /></td>
			<td>(mp4, flv)</td>
		</tr>
	</table>
</fieldset>