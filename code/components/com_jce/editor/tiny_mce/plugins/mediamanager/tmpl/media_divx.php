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
    <fieldset class="media_option divx">
        <legend><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_OPTIONS');?></legend>

        <table border="0" cellpadding="4" cellspacing="0">
            <tr>
                <td colspan="2">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><input type="checkbox" class="checkbox" id="divx_loop"></td>

                            <td><label for="divx_loop"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_LOOP');?></label></td>
                        </tr>
                    </table>
                </td>

                <td colspan="2">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><input type="checkbox" class="checkbox" id="divx_bannerenabled" checked="checked"></td>

                            <td><label for="divx_bannerenabled"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_BANNERENABLED');?></label></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><input type="checkbox" class="checkbox" id="divx_autoplay" checked="checked"></td>

                            <td><label for="divx_autoplay"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_AUTOPLAY');?></label></td>
                        </tr>
                    </table>
                </td>

                <td colspan="2">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><input type="checkbox" class="checkbox" id="divx_allowcontextmenu" checked="checked"></td>

                            <td><label for="divx_allowcontextmenu"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_ALLOWCONTEXTMENU');?></label></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td><label for="divx_mode"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_MODE');?></label></td>

                <td><select id="divx_mode" onchange="MediaManagerDialog.setControllerHeight('divx');">
                    <option value="null">
                        <?php echo WFText::_('WF_MEDIAMANAGER_DIVX_NULL');?>
                    </option>

                    <option value="zero">
                        <?php echo WFText::_('WF_MEDIAMANAGER_DIVX_ZERO');?>
                    </option>

                    <option value="mini">
                        <?php echo WFText::_('WF_MEDIAMANAGER_DIVX_MINI');?>
                    </option>

                    <option value="large">
                        <?php echo WFText::_('WF_MEDIAMANAGER_DIVX_LARGE');?>
                    </option>

                    <option value="full">
                        <?php echo WFText::_('WF_MEDIAMANAGER_DIVX_FULL');?>
                    </option>
                </select></td>

                <td><label for="divx_bufferingmode"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_BUFFERINGMODE');?></label></td>

                <td><select id="divx_bufferingmode">
                    <option value="null">
                        <?php echo WFText::_('WF_MEDIAMANAGER_DIVX_NULL');?>
                    </option>

                    <option value="auto">
                        <?php echo WFText::_('WF_MEDIAMANAGER_DIVX_AUTO');?>
                    </option>

                    <option value="full">
                        <?php echo WFText::_('WF_MEDIAMANAGER_DIVX_FULL');?>
                    </option>
                </select></td>
            </tr>

            <tr>
                <td><label for="divx_previewmessage"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_PREVIEWMESSAGE');?></label></td>

                <td><input type="text" id="divx_previewmessage"></td>

                <td><label for="divx_movietitle"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_MOVIETITLE');?></label></td>

                <td><input type="text" id="divx_movietitle"></td>
            </tr>

            <tr>
                <td><label for="divx_previewmessagefontsize"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_PREVIEWMESSAGEFONTSIZE');?></label></td>

                <td><input type="text" id="divx_previewmessagefontsize"></td>

                <td><label for="divx_minversion"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_MINVERSION');?></label></td>

                <td><input type="text" id="divx_minversion"></td>
            </tr>

            <tr>
                <td><label for="divx_previewimage"><?php echo WFText::_('WF_MEDIAMANAGER_DIVX_PREVIEWIMAGE');?></label></td>

                <td colspan="3"><input type="text" id="divx_previewimage" class="browser image"></td>
            </tr>
        </table>
		<h6 class="notice">DivX and the associated DivX logos are trademarks of DivX, LLC, a subsidiary of Rovi Corporation</h6>
    </fieldset>