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
defined('_JEXEC') or die('RESTRICTED');
?>
<fieldset class="media_option mediaplayer"><legend><?php echo WFText::_('WF_MEDIAMANAGER_MEDIAPLAYER_HTML5'); ?></legend>

    <table border="0" cellpadding="4" cellspacing="0">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><input type="checkbox" class="checkbox" id="mediaplayer_html5_video_autoplay" /></td>
                        <td><label for="mediaplayer_html5_video_autoplay"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_AUTOPLAY'); ?></label></td>
                    </tr>
                </table>
            </td>

            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><input type="checkbox" class="checkbox" id="mediaplayer_html5_video_controls" checked="checked" /></td>
                        <td><label for="mediaplayer_html5_video_controls"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_CONTROLS'); ?></label></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><input type="checkbox" class="checkbox" id="mediaplayer_html5_video_loop" /></td>
                        <td><label for="mediaplayer_html5_video_loop"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_LOOP'); ?></label></td>
                    </tr>
                </table>
            </td>

            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><input type="checkbox" class="checkbox" id="mediaplayer_html5_video_audio" /></td>
                        <td><label for="mediaplayer_html5_video_audio"><?php echo WFText::_('WF_MEDIAMANAGER_VIDEO_MUTE'); ?></label></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><label for="mediaplayer_html5_video_preload"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_PRELOAD'); ?></label></td>
            <td><select id="mediaplayer_html5_video_preload">
                    <option value=""><?php echo WFText::_('WF_OPTION_AUTO'); ?></option>
                    <option value="none"><?php echo WFText::_('WF_OPTION_NONE'); ?></option>
                    <option value="metadata"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_METADATA'); ?></option>
                </select></td>
        </tr>
        <tr>
            <td><label for="mediaplayer_html5_video_poster"><?php echo WFText::_('WF_MEDIAMANAGER_VIDEO_POSTER'); ?></label></td>
            <td><input type="text" id="mediaplayer_html5_video_poster" class="browser image" /></td>
        </tr>
        <tr>
            <td><label for="mediaplayer_html5_video_source"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_SOURCE'); ?></label></td>
            <td colspan="2"><input type="text" name="mediaplayer_html5_video_source[]"
                                   class="active" onclick="MediaManagerDialog.setSourceFocus(this);" /></td>
        </tr>
        <tr>
            <td><label for="mediaplayer_html5_video_source"><?php echo WFText::_('WF_MEDIAMANAGER_LABEL_SOURCE'); ?></label></td>
            <td colspan="2"><input type="text" name="mediaplayer_html5_video_source[]"
                                   onclick="MediaManagerDialog.setSourceFocus(this);" /></td>
        </tr>
    </table>
</fieldset>