<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
?>
<script type="text/javascript">
function insertLink() {
	var imagecategories = document.getElementById("imagecategories").value;
	if (imagecategories != '') {
		imagecategories = "|imagecategories="+imagecategories;
	}
	var imagecategoriessize = document.getElementById("imagecategoriessize").value;
	if (imagecategoriessize != '') {
		imagecategoriessize = "|imagecategoriessize="+imagecategoriessize;
	}
	
	var hideCategoriesOutput = '';
	hidecategories = getSelectedData();

	if (hidecategories != '') {
		hideCategoriesOutput = "|hidecategories="+hidecategories;
	}

	var tag = "{phocagallery view=categories"+imagecategories+imagecategoriessize+hideCategoriesOutput+"}";

	window.parent.jInsertEditorText(tag, '<?php echo $this->tmpl['ename']; ?>');
	window.parent.document.getElementById('sbox-window').close();
	return false;
}

function getSelectedData(array) {
	var selected = new Array();
	var dataSelect = document.forms["adminFormLink"].elements["hidecategories"];
	
	for(j = 0; j < dataSelect.options.length; j++){
		if (dataSelect.options[j].selected) {
			selected.push(dataSelect.options[j].value); }
	}
	if (array != 'true') {
		return selected.toString();
	} else {
		return selected;
	} 
}
</script>
<div id="phocagallery-links">
<fieldset class="adminform">
<legend><?php echo JText::_( 'Categories' ); ?></legend>
<form name="adminFormLink" id="adminFormLink">
<table class="admintable" width="100%">
	<tr>
		<td class="key" align="right" width="30%">
			<label for="imagecategories">
				<?php echo JText::_( 'Display Images' ); ?>
			</label>
		</td>
		<td width="70%">
			<select name="imagecategories" id="imagecategories">
			<option value="0" ><?php echo JText::_( 'No' ); ?></option>
			<option value="1" selected="selected"><?php echo JText::_( 'Yes' ); ?></option>
			</select>
		</td>
	</tr>
	<tr >
		<td class="key" align="right">
			<label for="imagecategoriessize">
				<?php echo JText::_( 'Image Size' ); ?>
			</label>
		</td>
		<td>
			<select name="imagecategoriessize" id="imagecategoriessize">
			<option value="0" selected="selected"><?php echo JText::_( 'Small' ); ?></option>
			<option value="1"><?php echo JText::_( 'Medium' ); ?></option>
			<option value="2"><?php echo JText::_( 'Small Folder Icon' ); ?></option>
			<option value="3"><?php echo JText::_( 'Medium Folder Icon' ); ?></option>
			<option value="4"><?php echo JText::_( 'Small with Shadow' ); ?></option>
			<option value="5"><?php echo JText::_( 'Medium with Shadow' ); ?></option>
			<option value="6"><?php echo JText::_( 'Small Folder Icon with Shadow' ); ?></option>
			<option value="7"><?php echo JText::_( 'Medium Folder Icon with Shadow' ); ?></option>
			</select>
		</td>
	</tr>
	
	
	<tr >
		<td class="key" align="right">
			<label for="hidecategories">
				<?php echo JText::_( 'Hide Categories' ); ?>
			</label>
		</td>
		<td>
		<?php echo $this->categoriesoutput;?>
		</td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td align="right"><button onclick="insertLink();"><?php echo JText::_( 'Insert Code' ); ?></button></td>
	</tr>
</table>
</form>

</fieldset>
<div style="text-align:right;margin:20px 5px;"><span class="icon-16-edb-back"><a style="text-decoration:underline" href="<?php echo $this->tmpl['backlink'];?>"><?php echo JText::_('Back')?></a></span></div>
</div>