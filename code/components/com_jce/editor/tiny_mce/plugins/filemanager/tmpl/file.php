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
<fieldset><legend><?php echo WFText::_('WF_LABEL_LINK'); ?></legend>
    <table>
        <tr>
            <td><label for="href" class="hastip"
                       title="<?php echo WFText::_('WF_LABEL_URL_DESC'); ?>"><?php echo WFText::_('WF_LABEL_URL'); ?></label></td>
            <td><input type="text" id="href" value="" class="required" /></td>
        </tr>
        <tr>
            <td><label for="target" class="hastip"
                       title="<?php echo WFText::_('WF_LABEL_TARGET_DESC'); ?>"><?php echo WFText::_('WF_LABEL_TARGET'); ?></label></td>
            <td><select id="target">
                    <option value=""><?php echo WFText::_('WF_OPTION_NOT_SET'); ?></option>
                    <option value="_self"><?php echo WFText::_('WF_OPTION_TARGET_SELF'); ?></option>
                    <option value="_blank"><?php echo WFText::_('WF_OPTION_TARGET_BLANK'); ?></option>
                    <option value="_parent"><?php echo WFText::_('WF_OPTION_TARGET_PARENT'); ?></option>
                    <option value="_top"><?php echo WFText::_('WF_OPTION_TARGET_TOP'); ?></option>
                </select></td>
        </tr>
    </table>
</fieldset>
<fieldset><legend><?php echo WFText::_('WF_LABEL_OPTIONS'); ?></legend>
    <div id="options_enabled">
        <table>
            <tr>
                <td><label for="text" class="hastip"
                           title="<?php echo WFText::_('WF_FILEMANAGER_TEXT_DESC'); ?>"><?php echo WFText::_('WF_LABEL_TEXT'); ?></label></td>
                <td colspan="3"><input id="text" type="text" value="" class="required" /></td>
            </tr>
            <tr>
                <td><label for="title" class="hastip"
                           title="<?php echo WFText::_('WF_LABEL_TITLE_DESC'); ?>"><?php echo WFText::_('WF_LABEL_TITLE'); ?></label></td>
                <td colspan="3"><input id="title" type="text" value="" /></td>
            </tr>
            <tr>
                <td><label class="hastip"
                           title="<?php echo WFText::_('WF_FILEMANAGER_LAYOUT_DESC'); ?>"><?php echo WFText::_('WF_FILEMANAGER_LAYOUT'); ?></label></td>
                <td colspan="3">
                    <ul id="options_list">
                        <li id="option_icon" data-type="icon">
                            <label class="label"><?php echo WFText::_('WF_FILEMANAGER_LAYOUT_ICON'); ?></label>
                            <input type="checkbox" id="option_icon_check" />
                        </li>
                        <li id="option_text" data-type="text">
                            <label class="label"><?php echo WFText::_('WF_FILEMANAGER_LAYOUT_TEXT'); ?></label>
                            <input type="checkbox" id="option_text_check" checked="checked" disabled="disabled" />
                        </li>
                        <li id="option_size" data-type="size">
                            <label class="label"><?php echo WFText::_('WF_FILEMANAGER_LAYOUT_SIZE'); ?></label>
                            <input type="text" value="" />
                            <input type="checkbox" id="option_size_check" />
                            <span role="button" class="option_reload" title="<?php echo WFText::_('WF_FILEMANAGER_LAYOUT_RELOAD'); ?>"></span>
                        </li>
                        <li id="option_date" data-type="date">
                            <label class="label"><?php echo WFText::_('WF_FILEMANAGER_LAYOUT_DATE'); ?></label>
                            <input type="text" value="" />
                            <input type="checkbox" id="option_date_check" />
                            <span role="button" class="option_reload" title="<?php echo WFText::_('WF_FILEMANAGER_LAYOUT_RELOAD'); ?>"></span>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td><label for="date_class" class="hastip"
                           title="<?php echo WFText::_('WF_FILEMANAGER_DATE_CLASS_DESC'); ?>"><?php echo WFText::_('WF_FILEMANAGER_DATE_CLASS'); ?></label></td>
                <td colspan="3"><select id="date_class" class="editable">
                        <option value=""><?php echo WFText::_('WF_OPTION_NOT_SET'); ?></option>
                    </select>
                    <label for="size_class" class="hastip"
                           title="<?php echo WFText::_('WF_FILEMANAGER_SIZE_CLASS_DESC'); ?>"><?php echo WFText::_('WF_FILEMANAGER_SIZE_CLASS'); ?></label>
                    <select id="size_class" class="editable">
                        <option value=""><?php echo WFText::_('WF_OPTION_NOT_SET'); ?></option>
                    </select>
            </tr>
        </table>
    </div>
    <div id="options_disabled"><?php echo WFText::_('WF_FILEMANAGER_OPTIONS_DISABLED'); ?></div>
    <div class="googledocs">
        <table>
            <tr>
                <td>
                    <label for="googledocs_type" class="hastip"
                           title="<?php echo WFText::_('WF_FILEMANAGER_GOOGLEDOCS_DESC'); ?>"><?php echo WFText::_('WF_FILEMANAGER_GOOGLEDOCS'); ?></label>
                </td>
                <td>
                    <select id="googledocs_type">
                        <option value=""><?php echo WFText::_('WF_OPTION_NOT_SET'); ?></option>
                        <option value="link"><?php echo WFText::_('WF_FILEMANAGER_GOOGLEDOCS_LINK'); ?></option>
                        <option value="embed"><?php echo WFText::_('WF_FILEMANAGER_GOOGLEDOCS_EMBED'); ?></option>
                    </select>
                    <input type="checkbox" id="googledocs_ssl" />
                    <label for="googledocs_ssl" class="hastip" title="<?php echo WFText::_('WF_FILEMANAGER_GOOGLEDOCS_SSL_DESC'); ?>">
                        <?php echo WFText::_('WF_FILEMANAGER_GOOGLEDOCS_SSL'); ?>
                    </label>

                    <label for="googledocs_width" class="hastip" title="<?php echo WFText::_('WF_LABEL_DIMENSIONS_DESC'); ?>">
                        <?php echo WFText::_('WF_LABEL_DIMENSIONS'); ?>
                    </label>

                    <input type="text" id="googledocs_width" value="" onchange="FileManager.setDimensions('googledocs_width', 'googledocs_height');" />
                    <select id="googledocs_width_unit" onchange="FileManager.setDimensionUnit('googledocs_width', 'googledocs_height');">
                        <option value="">px</option>
                        <option value="%">%</option>
                    </select>
                    x
                    <input type="text" id="googledocs_height" value="" onchange="FileManager.setDimensions('googledocs_height', 'googledocs_width');" />
                    <select id="googledocs_height_unit" onchange="FileManager.setDimensionUnit('googledocs_height', 'googledocs_width');">
                        <option value="">px</option>
                        <option value="%">%</option>
                    </select>
                    <input id="constrain" type="checkbox" class="checkbox" checked="checked" />
                    <label for="constrain">
                        <?php echo WFText::_('WF_LABEL_PROPORTIONAL'); ?>
                    </label>
                </td>
            </tr>
        </table>
    </div>
</fieldset>