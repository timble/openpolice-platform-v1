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
<fieldset><legend><?php echo WFText::_('WF_LABEL_ATTRIBUTES');?></legend>
<table border="0" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<td><label for="id" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_ID_DESC');?>"><?php echo WFText::_('WF_LABEL_ID');?></label></td>
		<td><input type="text" id="id" /></td>
	</tr>
	<tr>
		<td><label for="name" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_NAME_DESC');?>"><?php echo WFText::_('WF_LABEL_NAME');?></label></td>
		<td><input type="text" id="name" /></td>
	</tr>
	<tr>
		<td><label for="style" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_STYLE_DESC');?>"><?php echo WFText::_('WF_LABEL_STYLE');?></label></td>
		<td><input id="style" type="text" value="" /></td>
	</tr>
	<tr>
		<td><label for="classes" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_CLASSES_DESC');?>"><?php echo WFText::_('WF_LABEL_CLASSES');?></label></td>
		<td><input id="classes" type="text" value="" /></td>
	</tr>
	<tr>
		<td><label for="classlist" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_CLASS_LIST_DESC');?>"><?php echo WFText::_('WF_LABEL_CLASS_LIST');?></label></td>
		<td><select id="classlist"
			onchange="MediaManagerDialog.setClasses(this.value);">
			<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
		</select></td>
	</tr>
	<tr>
		<td><label for="bgcolor" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_BGCOLOR_DESC');?>"><?php echo WFText::_('WF_LABEL_BGCOLOR');?></label></td>
		<td>
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td><input id="bgcolor" type="text" value="" size="9"
					onchange="TinyMCE_Utils.updateColor('bgcolor');MediaManagerDialog.updateStyles();"
					class="colour" /></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td><label for="border" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_BORDER_DESC');?>"><?php echo WFText::_('WF_LABEL_BORDER');?></label></td>
		<td colspan="3"><input type="checkbox" class="checkbox" id="border"
			onclick="MediaManagerDialog.setBorder();"> <label for="border_width"
			class="hastip"
			title="<?php echo WFText::_('WF_LABEL_BORDER_WIDTH_DESC');?>"><?php echo WFText::_('WF_LABEL_WIDTH');?></label>
		<select id="border_width"
			onchange="MediaManagerDialog.updateStyles();"
			class="mceEditableSelect" data-pattern="[0-9]+">
			<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="thin"><?php echo WFText::_('WF_OPTION_BORDER_THIN');?></option>
			<option value="medium"><?php echo WFText::_('WF_OPTION_BORDER_MEDIUM');?></option>
			<option value="thick"><?php echo WFText::_('WF_OPTION_BORDER_THICK');?></option>
		</select> <label for="border_style" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_BORDER_STYLE_DESC');?>"><?php echo WFText::_('WF_LABEL_STYLE');?></label>
		<select id="border_style"
			onchange="MediaManagerDialog.updateStyles();">
			<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
			<option value="none"><?php echo WFText::_('WF_OPTION_BORDER_NONE');?></option>
			<option value="solid"><?php echo WFText::_('WF_OPTION_BORDER_SOLID');?></option>
			<option value="dashed"><?php echo WFText::_('WF_OPTION_BORDER_DASHED');?></option>
			<option value="dotted"><?php echo WFText::_('WF_OPTION_BORDER_DOTTED');?></option>
			<option value="double"><?php echo WFText::_('WF_OPTION_BORDER_DOUBLE');?></option>
			<option value="groove"><?php echo WFText::_('WF_OPTION_BORDER_GROOVE');?></option>
			<option value="inset"><?php echo WFText::_('WF_OPTION_BORDER_INSET');?></option>
			<option value="outset"><?php echo WFText::_('WF_OPTION_BORDER_OUTSET');?></option>
			<option value="ridge"><?php echo WFText::_('WF_OPTION_BORDER_RIDGE');?></option>
		</select> <label for="border_color" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_BORDER_COLOR_DESC');?>"><?php echo WFText::_('WF_LABEL_COLOR');?></label>
		<input id="border_color" class="color" type="text" value="#000000" onchange="MediaManagerDialog.updateStyles();" />
		</td>
	</tr>
	<tr>
		<td><label for="controller_height" class="hastip"
			title="<?php echo WFText::_('WF_LABEL_CONTROLLER_HEIGHT_DESC');?>"><?php echo WFText::_('WF_LABEL_CONTROLLER_HEIGHT');?></label></td>
		<td><input type="text" id="controller_height" value="" pattern="[0-9]+" /></td>
	</tr>
</table>
</fieldset>
