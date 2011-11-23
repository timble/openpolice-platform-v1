<?php
/**
* @version		$Id: file.php 199 2011-05-06 16:45:28Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
$document 	= WFDocument::getInstance();
$plugin 	= WFMediaManagerPlugin::getInstance();

defined('_JEXEC') or die('ERROR_403');
?>
    <table border="0" cellpadding="0">
        <tr>
        	<td style="vertical-align:top;width:75%;">
                    <fieldset>
                    <legend><?php echo WFText::_('WF_LABEL_PROPERTIES');?></legend>
                    <table cellpadding="3" cellspacing="0" border="0" style="height:150px;">
                        <tr>
							<td><label for="media_type"><?php echo WFText::_('WF_LABEL_MEDIA_TYPE');?></label></td>
							<td colspan="3"><select id="media_type" onchange="MediaManagerDialog.changeType();">
								<?php echo $plugin->getMediaOptions();?>
							</select></td>
						</tr>
                        <tr>
                        	<td><label for="src" class="hastip" title="<?php echo WFText::_('WF_LABEL_URL_DESC');?>"><?php echo WFText::_('WF_LABEL_URL');?></label></td>
                        	<td colspan="3"><input type="text" id="src" value="" class="required" /></td>
                        </tr>
                        <tr>
                        	<td><label for="width" class="hastip" title="<?php echo WFText::_('WF_LABEL_DIMENSIONS_DESC');?>"><?php echo WFText::_('WF_LABEL_DIMENSIONS');?></label></td>
                       		<td colspan="3">
                                <input type="text" id="width" value="" onchange="MediaManagerDialog.setDimensions('width', 'height');" /> x <input type="text" id="height" value="" onchange="MediaManagerDialog.setDimensions('height', 'width');" />
                                <input type="hidden" id="tmp_width" value=""  />
                                <input type="hidden" id="tmp_height" value="" />
								<input id="constrain" type="checkbox" class="checkbox" checked="checked" /><label for="constrain"><?php echo WFText::_('WF_LABEL_PROPORTIONAL');?></label>
                    		</td>
                    	</tr>
                    	<tr>
                        <td><label for="align" class="hastip" title="<?php echo WFText::_('WF_LABEL_ALIGN_DESC');?>"><?php echo WFText::_('WF_LABEL_ALIGN');?></label></td>
                        <td>
                        	<select id="align" onchange="MediaManagerDialog.updateStyles();">
                        		<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
                        		<option value="left"><?php echo WFText::_('WF_OPTION_ALIGN_LEFT');?></option>
                                <option value="right"><?php echo WFText::_('WF_OPTION_ALIGN_RIGHT');?></option>
                        		<option value="top"><?php echo WFText::_('WF_OPTION_ALIGN_TOP');?></option>
                        		<option value="middle"><?php echo WFText::_('WF_OPTION_ALIGN_MIDDLE');?></option>
                                <option value="bottom"><?php echo WFText::_('WF_OPTION_ALIGN_BOTTOM');?></option>
                        	</select>

                        	<label for="clear" class="hastip" title="<?php echo WFText::_('WF_LABEL_CLEAR_DESC');?>"><?php echo WFText::_('WF_LABEL_CLEAR');?></label>
 
                            <select id="clear" disabled="disabled" onchange="MediaManagerDialog.updateStyles();">
                                <option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
                                <option value="none"><?php echo WFText::_('WF_OPTION_CLEAR_NONE');?></option>
                                <option value="both"><?php echo WFText::_('WF_OPTION_CLEAR_BOTH');?></option>
                                <option value="left"><?php echo WFText::_('WF_OPTION_CLEAR_LEFT');?></option>
                                <option value="right"><?php echo WFText::_('WF_OPTION_CLEAR_RIGHT');?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="margin" class="hastip" title="<?php echo WFText::_('WF_LABEL_MARGIN_DESC');?>"><?php echo WFText::_('WF_LABEL_MARGIN');?></label></td>
                        <td colspan="3">
                        	<label for="margin_top"><?php echo WFText::_('WF_OPTION_TOP');?></label><input type="text" id="margin_top" value="" size="3" maxlength="3" onchange="MediaManagerDialog.setMargins();" />
                        	<label for="margin_right"><?php echo WFText::_('WF_OPTION_RIGHT');?></label><input type="text" id="margin_right" value="" size="3" maxlength="3" onchange="MediaManagerDialog.setMargins();" />
                        	<label for="margin_bottom"><?php echo WFText::_('WF_OPTION_BOTTOM');?></label><input type="text" id="margin_bottom" value="" size="3" maxlength="3" onchange="MediaManagerDialog.setMargins();" />
                        	<label for="margin_left"><?php echo WFText::_('WF_OPTION_LEFT');?></label><input type="text" id="margin_left" value="" size="3" maxlength="3" onchange="MediaManagerDialog.setMargins();" />
                        	<input type="checkbox" class="checkbox" id="margin_check" onclick="MediaManagerDialog.setMargins();"><label><?php echo WFText::_('WF_LABEL_EQUAL');?></label>
                        </td>
                    </tr>
                </table>
                </fieldset>
    	</td>
    	<td style="vertical-align:top;">  
                <fieldset>
                <legend><?php echo WFText::_('WF_LABEL_PREVIEW');?></legend>
                <table cellpadding="3" cellspacing="0" border="0" style="height:150px;">
                    <tr>
                        <td style="vertical-align:top;">
                        	<div class="preview">
                        		<img id="sample" src="<?php echo $document->image('sample.jpg', 'libraries');?>" alt="sample.jpg" />
                        		Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                        	</div>
                        </td>
                    </tr>
                </table>
                </fieldset>
    	</td>
    </tr>
</table>
