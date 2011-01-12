<?php
defined('_JEXEC') or die('Restricted access');
$user 	=& JFactory::getUser();

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'a.ordering');

JHTML::_('behavior.tooltip');
?>
<script type="text/javascript">
//<![CDATA[
function insertLink() {
	
	<?php
	$items = array('width', 'height', 'delay', 'image', 'pgslink', 'imageordering' );
	$itemsArrayOutput = '';
	foreach ($items as $key => $value) {
		
		echo 'var '.$value.' = document.getElementById("'.$value.'").value;'."\n"
			.'if ('.$value.' != \'\') {'. "\n"
			.''.$value.' = "|'.$value.'="+'.$value.';'."\n"
			.'}';
		$itemsArrayOutput .= '+'.$value;
	}
	?>
	
	/* Category */
	var categoryid = document.getElementById("filter_catid").value;
	var categoryIdOutput = '';
	if (categoryid != '') {
		categoryIdOutput = "id="+categoryid;
	}
	
	
	if (categoryIdOutput != '' &&  parseInt(categoryid) > 0) {
		/*return false;*/
	} else {
		alert("<?php echo JText::_( 'You must select a category', true ); ?>");
		return false;
	}
	
	var tag = "{pgslideshow "+categoryIdOutput<?php echo $itemsArrayOutput ?>+"}";
	window.parent.jInsertEditorText(tag, '<?php echo $this->tmpl['ename']; ?>');
	window.parent.document.getElementById('sbox-window').close();
}
//]]>
</script>
<div id="phocagallery-links">
<fieldset class="adminform">
<legend><?php echo JText::_( 'Image' ); ?></legend>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm">

<table class="admintable" width="100%">
		
		<tr>
			<td class="key" align="right" nowrap="nowrap" width="30%" >
			<label for="title" nowrap="nowrap" >
				<?php echo JText::_( 'Category' ); ?>
			</label>
			</td width="70%">
			<td><?php echo $this->lists['catid']; ?></td>
	</tr>
</table>


<input type="hidden" name="controller" value="phocagallerylinkimg" />
<input type="hidden" name="type" value="<?php echo (int)$this->tmpl['type']; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<input type="hidden" name="e_name" value="<?php echo $this->tmpl['ename']?>" />
</form>



<form name="adminFormLink" id="adminFormLink">
<table class="admintable" width="100%">
	<?php
	// Number
	$itemsNumber = array ('width' => array('Slideshow Width', 640),'height' => array('Slideshow Height',480), 'delay' => array('Delay',3000));
	foreach ($itemsNumber as $key => $value) {
		echo '<tr>'
		.'<td class="key" align="right" width="30%"><label for="'.$key.'">'.JText::_($value[0]).'</label></td>'
		.'<td nowrap="nowrap"><input type="text" name="'.$key.'" id="'.$key.'" value="'.$value[1].'" class="text_area" /></td>'
		.'</tr>';
	}
	
	echo '<tr>'
		.'<td class="key" align="right" width="30%"><label for="image">'.JText::_('Image').'</label></td>'
		.'<td nowrap><select name="image" id="image" class="inputbox">'
		.'<option value="L"  selected="selected">'. JText::_( 'Large' ).'</option>'
		.'<option value="M" >'.JText::_( 'Medium' ).'</option>'
		.'<option value="S" >'.JText::_( 'Small' ).'</option>'
		.'<option value="O" >'.JText::_( 'Original' ).'</option>'
		.'</select></td></tr>';
	
	echo '<tr>'
		.'<td class="key" align="right" width="30%"><label for="pgslink">'.JText::_('Slideshow Link').'</label></td>'
		.'<td nowrap><select name="pgslink" id="pgslink" class="inputbox">'
		.'<option value=""  selected="selected">'. JText::_( 'Default' ).'</option>'
		.'<option value="1" >'.JText::_( 'Link to Category' ).'</option>'
		.'<option value="2" >'.JText::_( 'Link to Categories' ).'</option>'
		.'</select></td></tr>';
	?>	
		<tr>
		<td class="key" align="right" width="30%"><label for="imageordering"><?php echo JText::_( 'Image Ordering' ); ?></label></td>
		<td><select name="imageordering" id="imageordering" class="inputbox">
			<option value="" selected="selected"><?php echo JText::_('Default')?></option>
			<option value="1"><?php echo JText::_('Ordering ASC')?></option>
			<option value="2"><?php echo JText::_('Ordering DESC')?></option>
			<option value="3"><?php echo JText::_('Title ASC')?></option>
			<option value="4"><?php echo JText::_('Title DESC')?></option>
			<option value="5"><?php echo JText::_('Date ASC')?></option>
			<option value="6"><?php echo JText::_('Date DESC')?></option>
			<option value="7"><?php echo JText::_('Id ASC')?></option>
			<option value="8"><?php echo JText::_('Id DESC')?></option>
			<option value="9"><?php echo JText::_('Random')?></option>
		</select></td>
</tr>
		
	<tr>
		<td>&nbsp;</td>
		<td align="right"><button onclick="insertLink();return false;"><?php echo JText::_( 'Insert Code' ); ?></button></td>
	</tr>
</table>
</form>

</fieldset>
<div style="text-align:right;margin:20px 5px;"><span class="icon-16-edb-back"><a style="text-decoration:underline" href="<?php echo $this->tmpl['backlink'];?>"><?php echo JText::_('Back')?></a></span></div>
</div>