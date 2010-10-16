<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');


// External link
$extlink = 0;
if (isset($this->items->extid) && $this->items->extid != '') {
	$extlink = 1;
}
 
?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}

	if (form.catid.value == "0"){
		alert( "<?php echo JText::_( 'You must select a category', true ); ?>" );
	} 
	
	<?php if ($extlink == 0) {
	?>
	else if (form.filename.value == ""){
		alert( "<?php echo JText::_( 'You must select a filename', true ); ?>" );
	} 
	<?php
	}
	?>
	else {
		submitform( pressbutton );
	}
}
</script>
<style type="text/css">
table.paramlist td.paramlist_key {
	width: 92px;
	text-align: left;
	height: 30px;
}
</style>

<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm">
<div class="col50"><div style="text-align:right"><?php echo $this->tmpl['enablethumbcreationstatus']; ?></div>
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="title">
					<?php echo JText::_( 'Name' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<input class="text_area" type="text" name="title" id="title" size="32" maxlength="250" value="<?php echo $this->items->title;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="alias">
					<?php echo JText::_( 'Alias' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="250" value="<?php echo $this->items->alias;?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key">
				<?php echo JText::_( 'Published' ); ?>:
			</td>
			<td colspan="2">
				<?php echo $this->lists['published']; ?>
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key">
				<?php echo JText::_( 'PHOCAGALLERY_APPROVED' ); ?>:
			</td>
			<td colspan="2">
				<?php echo $this->lists['approved']; ?>
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key">
				<label for="catid">
					<?php echo JText::_( 'Category' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<?php echo $this->lists['catid']; ?>
			</td>
		</tr>
		<tr>
			<td valign="middle" align="right" class="key">
				<label for="filename">
					<?php echo JText::_( 'Filename' ); ?>:
				</label>
			</td>
			<td valign="middle">
				<input class="text_area" type="text" name="filename" id="filename" value="<?php echo $this->items->filename; ?>" size="32" maxlength="250" />
			</td>
			<td align="left" valign="middle">
				<div class="button2-left" style="display:inline">
					<div class="<?php echo $this->button->name; ?>">
						<a class="<?php echo $this->button->modalname; ?>" title="<?php echo $this->button->text; ?>" href="<?php echo $this->button->link; ?>" rel="<?php echo $this->button->options; ?>"  ><?php echo $this->button->text; ?></a>
					</div>
				</div>
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key">
				<label for="date">
					<?php echo JText::_( 'Date' ); ?>:
				</label>
			</td>
			<td colspan="2" valign="middle">
				<?php echo JHTML::_('calendar', $this->items->date, 'date', 'date', "%Y-%m-%d", array('class'=>'inputbox', 'size'=>'32',  'maxlength'=>'45')); ?>
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key">
				<label for="ordering">
					<?php echo JText::_( 'Ordering' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<?php echo $this->lists['ordering']; ?>
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key">
				<label for="vmproductid">
					<?php echo JText::_( 'VM Product Id' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="vmproductid" name="vmproductid" id="vmproductid" size="32" maxlength="10" value="<?php echo $this->items->vmproductid ?>" />
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key">
				<label for="videocode">
					<?php echo JText::_( 'Video Code' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<textarea cols="46" rows="4" id="videocode" name="videocode"><?php echo $this->items->videocode ?></textarea>
			</td>
		</tr>
		
		
		<tr>
				<td valign="middle" align="right" class="key">
					<label for="longitude">
						<?php echo JText::_( 'Longitude' ); ?>:
					</label>
				</td>
				<td valign="middle">
					<input class="text_area" type="text" name="longitude" id="longitude" value="<?php echo $this->items->longitude; ?>" size="32" maxlength="250" />
				</td>
				<td align="left" valign="middle">
					<div class="button2-left" style="display:inline">
						<div class="<?php echo $this->buttongeo->name; ?>">
							<a class="<?php echo $this->buttongeo->modalname; ?>" title="<?php echo $this->buttongeo->text; ?>" href="<?php echo $this->buttongeo->link; ?>" rel="<?php echo $this->buttongeo->options; ?>"  ><?php echo $this->buttongeo->text; ?></a>
						</div>
					</div>
				</td>
			</tr>
			
			<tr>
				<td valign="middle" align="right" class="key">
					<label for="latitude">
						<?php echo JText::_( 'Latitude' ); ?>:
					</label>
				</td>
				<td valign="middle">
					<input class="text_area" type="text" name="latitude" id="latitude" value="<?php echo $this->items->latitude; ?>" size="32" maxlength="250" />
				</td>
			</tr>
			
			<tr>
				<td valign="middle" align="right" class="key">
					<label for="zoom">
						<?php echo JText::_( 'Geotagging Zoom' ); ?>:
					</label>
				</td>
				<td valign="middle">
					<input class="text_area" type="text" name="zoom" id="zoom" value="<?php echo $this->items->zoom; ?>" size="32" maxlength="250" />
				</td>
			</tr>
			
			<tr>
				<td valign="middle" align="right" class="key">
					<label for="geotitle">
						<?php echo JText::_( 'Geotagging Title' ); ?>:
					</label>
				</td>
				<td valign="middle">
					<input class="text_area" type="text" name="geotitle" id="geotitle" value="<?php echo $this->items->geotitle; ?>" size="32" maxlength="250" />
				</td>
			</tr>
		
		<tr>
			<td class="key">
				<label for="title" width="100">
					<?php echo JText::_( 'Hits' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<input class="text_area" type="text" name="hits" id="hits" value="<?php echo $this->items->hits; ?>" size="15" maxlength="11" title="<?php echo JText::_( 'Hits' ); ?>" />
			</td>
		</tr>
		
		<tr>
			<td valign="middle" align="right" class="key"></td>
			<td valign="middle"><hr /></td>
		</tr>
		<tr>
			<td valign="middle" align="right" class="key">
				<label for="extlink1">
					<?php echo JText::_( 'External Link 1' ); ?>:
				</label>
			</td>
			<td valign="middle">
				<input class="text_area" type="text" name="extlink1" id="extlink1" value="<?php echo $this->tmpl['extlink1'][0]; ?>" size="32" maxlength="250" />
			</td>
		</tr>
		<tr>
			<td valign="middle" align="right" class="key"><?php echo JText::_( 'Title' ); ?>:</td>
			<td valign="middle">
				<input class="text_area" type="text" name="extlinkname1" id="extlinkname1" value="<?php echo $this->tmpl['extlink1'][1]; ?>" size="32" maxlength="250" />
			</td>
		</tr>
		
		<tr>
			<td valign="middle" align="right" class="key"><?php echo JText::_( 'Target' ); ?>:</td>
			<td valign="middle">
				
				<select id="targetlist1" name="targetlist1">
				<option value="_self" <?php if ($this->tmpl['extlink1'][2] == '_self') { echo 'selected="selected"';} ?>><?php echo JText::_( 'Open in this window/frame (_self)')?></option>
				<option value="_blank"  <?php if ($this->tmpl['extlink1'][2] == '_blank') { echo 'selected="selected"';} ?>><?php echo JText::_( 'Open in new window (_blank)')?></option>
				<option value="_parent"  <?php if ($this->tmpl['extlink1'][2] == '_parent') { echo 'selected="selected"';} ?>><?php echo JText::_( 'Open in parent window/frame (_parent)')?></option>
				<option value="_top"  <?php if ($this->tmpl['extlink1'][2] == '_top') { echo 'selected="selected"';} ?>><?php echo JText::_( 'Open in top frame (replaces all frames) (_top)')?></option>
				</select>
				
			</td>
		</tr>
		
		<tr>
			<td valign="middle" align="right" class="key"><?php echo JText::_( 'Display' ); ?>:</td>
			<td valign="middle">
				<select id="displaylist1" name="displaylist1">
				<option value="0" <?php if ((int)$this->tmpl['extlink1'][3] == 0) { echo 'selected="selected"';} ?>><?php echo JText::_( 'Title')?></option>
				<option value="1" <?php if ((int)$this->tmpl['extlink1'][3] == 1) { echo 'selected="selected"';} ?>><?php echo JText::_( 'Icon')?></option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td valign="middle" align="right" class="key"></td>
			<td valign="middle"><hr /></td>
		</tr>
		<tr>
			<td valign="middle" align="right" class="key">
				<label for="extlink2">
					<?php echo JText::_( 'External Link 2' ); ?>:
				</label>
			</td>
			<td valign="middle">
				<input class="text_area" type="text" name="extlink2" id="extlink2" value="<?php echo $this->tmpl['extlink2'][0]; ?>" size="32" maxlength="250" />
			</td>
		</tr>
		<tr>
			<td valign="middle" align="right" class="key"><?php echo JText::_( 'Title' ); ?>:</td>
			<td valign="middle">
				<input class="text_area" type="text" name="extlinkname2" id="extlinkname2" value="<?php echo $this->tmpl['extlink2'][1]; ?>" size="32" maxlength="250" />
			</td>
		</tr>
		
		<tr>
			<td valign="middle" align="right" class="key"><?php echo JText::_( 'Target' ); ?>:</td>
			<td valign="middle">
				
				<select id="targetlist2" name="targetlist2">
				<option value="_self" <?php if ($this->tmpl['extlink2'][2] == '_self') { echo 'selected="selected"';} ?>><?php echo JText::_( 'Open in this window/frame (_self)')?></option>
				<option value="_blank"  <?php if ($this->tmpl['extlink2'][2] == '_blank') { echo 'selected="selected"';} ?>><?php echo JText::_( 'Open in new window (_blank)')?></option>
				<option value="_parent"  <?php if ($this->tmpl['extlink2'][2] == '_parent') { echo 'selected="selected"';} ?>><?php echo JText::_( 'Open in parent window/frame (_parent)')?></option>
				<option value="_top"  <?php if ($this->tmpl['extlink2'][2] == '_top') { echo 'selected="selected"';} ?>><?php echo JText::_( 'Open in top frame (replaces all frames) (_top)')?></option>
				</select>
				
			</td>
		</tr>
		
		<tr>
			<td valign="middle" align="right" class="key"><?php echo JText::_( 'Display' ); ?>:</td>
			<td valign="middle">
				<select id="displaylist2" name="displaylist2">
				<option value="0" <?php if ((int)$this->tmpl['extlink2'][3] == 0) { echo 'selected="selected"';} ?>><?php echo JText::_( 'Title')?></option>
				<option value="1" <?php if ((int)$this->tmpl['extlink2'][3] == 1) { echo 'selected="selected"';} ?>><?php echo JText::_( 'Icon')?></option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td valign="middle" align="right" class="key">
				<label for="metadesc">
					<?php echo JText::_( 'PHOCAGALLERY_METADESC' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<textarea cols="46" rows="4" id="metadesc" name="metadesc"><?php echo $this->items->metadesc; ?></textarea>
			</td>
		</tr>
		
			<tr>
			<td valign="middle" align="right" class="key">
				<label for="metakey">
					<?php echo JText::_( 'PHOCAGALLERY_METAKEY' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<textarea cols="46" rows="4" id="metakey" name="metakey"><?php echo $this->items->metakey; ?></textarea>
			</td>
		</tr>
		
	</table>
	</fieldset>
	
	<fieldset class="adminform">
				<legend><?php echo JText::_( 'Description' ); ?></legend>

				<table class="admintable">
			<?php /*		<tr>
						<td valign="top" colspan="3">
							<textarea cols="60" rows="3" id="description" name="description"><?php echo $this->items->description ?></textarea>
						</td>
					</tr>*/ ?>
					
					<tr>
						<td valign="top" colspan="3">
							<?php
							// parameters : areaname, content, width, height, cols, rows, show xtd buttons
							echo $this->editor->display( 'description',  $this->items->description, '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;
							?>
						</td>
					</tr>
					
					</table>
			</fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="cid[]" value="<?php echo $this->items->id; ?>" />
<input type="hidden" name="extlinkimage" value="<?php echo $extlink; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="phocagallery" />
</form>
