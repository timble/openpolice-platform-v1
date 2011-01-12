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
	$items = array('imageshadow', 'fontcolor', 'bgcolor', 'bgcolorhover', 'imagebgcolor', 'bordercolor', 'bordercolorhover', 'detail','displayname', 'displaydetail', 'displaydownload', 'displaybuttons', 'displaydescription', 'descriptionheight' ,'namefontsize', 'namenumchar', 'enableswitch', 'overlib', 'piclens','float', 'boxspace', 'displayimgrating', 'pluginlink', 'type', 'minboxwidth' );
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
		categoryIdOutput = "|categoryid="+categoryid;
	}
	
	/* Image */
	var imageIdOutput = '';
	len = document.getElementsByName("imageid").length;
	for (i = 0; i <len; i++) {
		if (document.getElementsByName('imageid')[i].checked) {
			imageid = document.getElementsByName('imageid')[i].value;
			if (imageid != '' && parseInt(imageid) > 0) {
				imageIdOutput = "|imageid="+imageid;
			} else {
				imageIdOutput = '';
			}
		}
	}
	
	if (categoryIdOutput != '' &&  parseInt(categoryid) > 0) {
		/*return false;*/
	} else {
		alert("<?php echo JText::_( 'You must select a category', true ); ?>");
		return false;
	}
	if (imageIdOutput != '' &&  parseInt(imageid) > 0) {
		/*return false;*/
	} else {
		alert("<?php echo JText::_( 'You must select an image', true ); ?>");
		return false;
	}
	var tag = "{phocagallery view=category"+categoryIdOutput+imageIdOutput<?php echo $itemsArrayOutput ?>+"}";
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
			<td class="key" align="right" width="20%">
				<label for="title">
					<?php echo JText::_( 'Filter' ); ?>
				</label>
			</td>
			<td width="80%">
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
		</tr>
		<tr>
			<td class="key" align="right" nowrap="nowrap">
			<label for="title" nowrap="nowrap">
				<?php echo JText::_( 'Category' ); ?>
			</label>
			</td>
			<td><?php echo $this->lists['catid']; ?></td>
	</tr>
</table>

<div id="editcell">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="1"><?php echo JText::_( 'NUM' ); ?></th>
				<th width="1"></th>
				<th class="image" width="2" align="center"><?php echo JText::_( 'Image' ); ?></th>
				<th class="title" width="50%"><?php echo JHTML::_('grid.sort',  'Title', 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th width="20%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Filename', 'a.filename', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				
				
				<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'ID', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++) {
				$row 	= &$this->items[$i];

			?>
			<tr class="<?php echo "row$k"; ?>">
				<td><?php echo $this->tmpl['pagination']->getRowOffset( $i ); ?></td>
				<td><input type="radio" name="imageid" value="<?php echo $row->id ?>" /></td>
				<td align="center" valign="middle">
					<div class="phocagallery-box-file">
						<center>
							<div class="phocagallery-box-file-first">
								<div class="phocagallery-box-file-second">
									<div class="phocagallery-box-file-third">
										<center>
										<?php 
										// PICASA
										if (isset($row->extid) && $row->extid !='') {
										
											$resW	= explode(',', $row->extw);
											$resH	= explode(',', $row->exth);
								
											$correctImageRes = PhocaGalleryImage::correctSizeWithRate($resW[2], $resH[2], 50, 50);
											echo JHTML::_( 'image', $row->exts.'?imagesid='.md5(uniqid(time())), '', array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height'])); 
										
										} else if (isset ($row->fileoriginalexist) && $row->fileoriginalexist == 1) {

											$imageRes	= PhocaGalleryImage::getRealImageSize($row->filename, 'small');
											$correctImageRes = PhocaGalleryImage::correctSizeWithRate($imageRes['w'], $imageRes['h'], 50, 50);
											 echo JHTML::_( 'image', $row->linkthumbnailpath.'?imagesid='.md5(uniqid(time())), '', array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']));
										} else {
											echo JHTML::_( 'image.site', 'phoca_thumb_s_no_image.gif', '../administrator/components/com_phocagallery/assets/images/');
										}
										?>
										</center>
									</div>
								</div>
							</div>
						</center>
					</div>
				</td>
						
				<?php echo '<td>'. $row->title.'</td>';
				if (isset($row->extid) && $row->extid !='') {
					echo '<td align="center">'.JText::_('PHOCAGALLERY_PICASA_STORED_FILE').'</td>';
				} else {
					echo '<td>' .$row->filename.'</td>';
				} ?>
				<td align="center"><?php echo $row->id; ?></td>
			</tr>
			<?php
			$k = 1 - $k;
			}
		?>
		</tbody>
		
		<tfoot>
			<tr>
				<td colspan="6"><?php echo $this->tmpl['pagination']->getListFooter(); ?></td>
			</tr>
		</tfoot>
	</table>
</div>


<input type="hidden" name="controller" value="phocagallerylinkimg" />
<input type="hidden" name="type" value="<?php echo $this->tmpl['type']; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<input type="hidden" name="e_name" value="<?php echo $this->tmpl['ename']?>" />
</form>


<form name="adminFormLink" id="adminFormLink">
<table class="admintable" width="100%">
	
	<tr>
		<td class="key" align="right" width="20%"><label for="imagecategories"><?php echo JText::_( 'Image Background Shadow' ); ?></label></td>
		<td width="80%">
			<select name="imageshadow" id="imageshadow">
			<option value=""  selected="selected"><?php echo JText::_( 'Default' )?></option>
			<option value="none" ><?php echo JText::_( 'None' ); ?></option>
			<option value="shadow1" ><?php echo JText::_( 'Shadow1' ); ?></option>
			<option value="shadow2" ><?php echo JText::_( 'Shadow2' ); ?></option>
			<option value="shadow3" ><?php echo JText::_( 'Shadow3' ); ?></option>
			</select>
		</td>
	</tr>

	<?php 
	// Colors
	$itemsColor = array ('fontcolor' => 'Font Color', 'bgcolor' => 'Background Color', 'bgcolorhover' => 'Background Color Hover', 'imagebgcolor' => 'Image Background Color', 'bordercolor' => 'Border Color', 'bordercolorhover' => 'Border Color Hover');
	foreach ($itemsColor as $key => $value) {
		echo '<tr>'
		.'<td class="key" align="right" width="20%"><label for="'.$key.'">'.JText::_($value).'</label></td>'
		.'<td nowrap="nowrap"><input type="text" name="'.$key.'" id="'.$key.'" value="" class="text_area" /><span style="margin-left:10px" onclick="openPicker(\''.$key.'\')"  class="picker_buttons">'. JText::_('Pick color').'</span></td>'
		.'</tr>';
	}
	?>
	
	<tr>
		<td class="key" align="right" width="20%"><label for="detail"><?php echo JText::_( 'Detail Window' ); ?></label></td>
		<td width="80%">
		<select name="detail" id="detail" class="inputbox">
		<option value=""  selected="selected"><?php echo JText::_( 'Default' )?></option>
		<option value="1" ><?php echo JText::_( 'Standard Popup Window' ); ?></option>
		<option value="0" ><?php echo JText::_( 'Modal Popup Box' ); ?></option>
		<option value="2" ><?php echo JText::_( 'Modal Popup Box (Image only)' ); ?></option>
		<option value="3" ><?php echo JText::_( 'Shadowbox' ); ?></option>
		<option value="4" ><?php echo JText::_( 'Highslide' ); ?></option>
		<option value="5" ><?php echo JText::_( 'Highslide (Image Only)' ); ?></option>
		<option value="6" ><?php echo JText::_( 'JAK Lightbox' ); ?></option>
		<option value="8" ><?php echo JText::_( 'Slimbox' ); ?></option>
		<?php /*<option value="7" >No Popup</option>*/ ?>
		</select></td>
	</tr>
	
	<?php
		echo '<tr>'
		.'<td class="key" align="right" width="20%"><label for="pluginlink">'.JText::_('Plugin Link').'</label></td>'
		.'<td nowrap><select name="pluginlink" id="pluginlink" class="inputbox">'
		.'<option value=""  selected="selected">'. JText::_( 'Default' ).'</option>'
		.'<option value="0" >'.JText::_( 'Link to Detail Image' ).'</option>'
		.'<option value="1" >'.JText::_( 'Link to Category' ).'</option>'
		.'<option value="2" >'.JText::_( 'Link to Categories' ).'</option>';
	
		echo '<tr>'
		.'<td class="key" align="right" width="20%"><label for="type">'.JText::_('Plugin Type').'</label></td>'
		.'<td nowrap><select name="type" id="type" class="inputbox">'
		.'<option value=""  selected="selected">'. JText::_( 'Default' ).'</option>'
		.'<option value="0" >'.JText::_( 'Link to Detail Image' ).'</option>'
		.'<option value="1" >'.JText::_( 'Mosaic' ).'</option>'
		.'<option value="2" >'.JText::_( 'Large Image' ).'</option>';
	
	// yes/no
	$itemsYesNo = array ('displayname' => 'Display Name', 'displaydetail' => 'Display Detail Icon', 'displaydownload' => 'Display Download Icon', 'displaybuttons' => 'Display Buttons', 'displaydescription' => 'Display Description Detail', 'displayimgrating' => 'Display Image Rating' );
	foreach ($itemsYesNo as $key => $value) {
		echo '<tr>'
		.'<td class="key" align="right" width="20%"><label for="'.$key.'">'.JText::_($value).'</label></td>'
		.'<td nowrap><select name="'.$key.'" id="'.$key.'" class="inputbox">'
		.'<option value=""  selected="selected">'. JText::_( 'Default' ).'</option>';
		
		if ($key == 'displaydownload') {
			echo '<option value="1" >'. JText::_( 'Show' ).'</option>'
			.'<option value="2" >'.JText::_( 'Show (Direct Download)' ).'</option>'
			.'<option value="0" >'.JText::_( 'Hide' ).'</option>';
		} else {
			echo '<option value="1" >'. JText::_( 'Show' ).'</option>'
			.'<option value="0" >'.JText::_( 'Hide' ).'</option>';
		}
		echo '</select></td>'
		.'</tr>';
	}
	
	
	// Number
	$itemsNumber = array ('descriptionheight' => 'Description Detail Height','namefontsize' => 'Font Size Name', 'namenumchar' => 'Char Length Name', 'boxspace' => 'Category Box Space','minboxwidth' => 'PHOCAGALLERY_MIN_BOX_WIDTH');
	foreach ($itemsNumber as $key => $value) {
		echo '<tr>'
		.'<td class="key" align="right" width="20%"><label for="'.$key.'">'.JText::_($value).'</label></td>'
		.'<td nowrap="nowrap"><input type="text" name="'.$key.'" id="'.$key.'" value="" class="text_area" /></td>'
		.'</tr>';
	}
	
	echo '<tr>'
		.'<td class="key" align="right" width="20%"><label for="enableswitch">'.JText::_('Switch Image').'</label></td>'
		.'<td nowrap><select name="enableswitch" id="enableswitch" class="inputbox">'
		.'<option value=""  selected="selected">'. JText::_( 'Default' ).'</option>'
		.'<option value="1" >'.JText::_( 'Enable' ).'</option>'
		.'<option value="0" >'.JText::_( 'Disable' ).'</option>';
	
	echo '<tr>'
		.'<td class="key" align="right" width="20%"><label for="overlib">'.JText::_('Overlib Effect').'</label></td>'
		.'<td nowrap><select name="overlib" id="overlib" class="inputbox">'
		.'<option value=""  selected="selected">'. JText::_( 'Default' ).'</option>'
		.'<option value="0" >'.JText::_( 'None' ).'</option>'
		.'<option value="1" >'.JText::_( 'Only Image' ).'</option>'
		.'<option value="2" >'.JText::_( 'Only Description' ).'</option>'
		.'<option value="3" >'.JText::_( 'Image and Description' ).'</option>';
	
	echo '<tr>'
		.'<td class="key" align="right" width="20%"><label for="piclens">'.JText::_('Enable Piclens').'</label></td>'
		.'<td nowrap><select name="piclens" id="piclens" class="inputbox">'
		.'<option value=""  selected="selected">'. JText::_( 'Default' ).'</option>'
		.'<option value="0" >'.JText::_( 'No' ).'</option>'
		.'<option value="1" >'.JText::_( 'Yes' ).'</option>'
		.'<option value="2" >'.JText::_( 'Yes (with Start Button)' ).'</option>';
	?>
	
	
	<tr>
		<td class="key" align="right" width="20%"><label for="float"><?php echo JText::_( 'Float Image' ); ?></label></td>
		<td width="80%">
			<select name="float" id="float">
			<option value=""  selected="selected"><?php echo JText::_( 'Default' )?></option>
			<option value="left" ><?php echo JText::_( 'Left' ); ?></option>
			<option value="right" ><?php echo JText::_( 'Right' ); ?></option>
			</select>
		</td>
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