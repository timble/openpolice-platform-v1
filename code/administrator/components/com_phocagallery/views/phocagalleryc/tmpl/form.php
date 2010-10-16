<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>

<script language="javascript" type="text/javascript">
function submitbutton(pressbutton, parent_id) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	
	if (pressbutton == 'loadextimg') {
		if ( form.extu.value == "" ) {
			alert("<?php echo JText::_( 'PHOCAGALLERY_PICASA_SET_USER', true ); ?>");
			return;
		} if ( form.exta.value == "" ) {
			alert("<?php echo JText::_( 'PHOCAGALLERY_PICASA_SET_ALBUM', true ); ?>");
			return;
		} if ( form.title.value == "" ) {
			alert("<?php echo JText::_( 'Category must have a title', true ); ?>");
			return;
		} else {
			document.getElementById('loading-ext-img').style.display='block';
			<?php
			echo $this->editor->save( 'description' ) ; ?>
			submitform(pressbutton);
		}
	} else {
	
		if ( form.title.value == "" ) {
			alert("<?php echo JText::_( 'Category must have a title', true ); ?>");
		} else {
			<?php
			echo $this->editor->save( 'description' ) ; ?>
			submitform(pressbutton);
		}
	}
}
</script>

<form action="index.php" method="post" name="adminForm">

<div class="col60">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

			<table class="admintable">
			<tr>
				<td class="key">
					<label for="title" width="100">
						<?php echo JText::_( 'Title' ); ?>:
					</label>
				</td>
				<td colspan="2">
					<input class="text_area" type="text" name="title" id="title" value="<?php echo $this->items->title; ?>" size="50" maxlength="255" title="<?php echo JText::_( 'A long name to be displayed in headings' ); ?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<label for="alias">
						<?php echo JText::_( 'Alias' ); ?>:
					</label>
				</td>
				<td colspan="2">
					<input class="text_area" type="text" name="alias" id="alias" value="<?php echo $this->items->alias; ?>" size="50" maxlength="255" title="<?php echo JText::_( 'A short name to appear in menus' ); ?>" />
				</td>
			</tr>
			
			<tr>
				<td valign="top" align="right" class="key">
					<label for="parentid">
						<?php echo JText::_( 'Parent Category' ); ?>:
					</label>
				</td>
				<td colspan="2">
					<?php echo $this->lists['parentid']; ?>
				</td>
			</tr>
			
			<tr>
				<td width="120" class="key">
					<?php echo JText::_( 'Published' ); ?>:
				</td>
				<td>
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
				<td class="key">
					<label for="ordering">
						<?php echo JText::_( 'Ordering' ); ?>:
					</label>
				</td>
				<td colspan="2">
					<?php echo $this->lists['ordering']; ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<label for="access">
						<?php echo JText::_( 'Access Level' ); ?>:
					</label>
				</td>
				<td>
					<?php echo $this->lists['access']; ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<label for="access">
						<?php echo JText::_( 'Access Rights' ); ?>:
					</label>
				</td>
				<td>
					<?php echo $this->lists['accessusers']; ?>
				</td>
			</tr>
			
			<tr>
				<td valign="top" class="key">
					<label for="access">
						<?php echo JText::_( 'Upload and Add Rights' ); ?>:
					</label>
				</td>
				<td>
					<?php echo $this->lists['uploadusers']; ?>
				</td>
			</tr>
			
			<tr>
				<td valign="top" class="key">
					<label for="access">
						<?php echo JText::_( 'Delete and Publish Rights' ); ?>:
					</label>
				</td>
				<td>
					<?php echo $this->lists['deleteusers']; ?>
				</td>
			</tr>
			
			<tr>
				<td valign="top" class="key">
					<label for="access">
						<?php echo JText::_( 'Owner' ); ?>:
					</label>
				</td>
				<td>
					<?php echo $this->lists['owner']; ?>
				</td>
			</tr>
			
			<tr>
				<td valign="middle" align="right" class="key">
					<label for="userfolder">
						<?php echo JText::_( 'Owner Folder' ); ?>:
					</label>
				</td>
				<td valign="middle">
					<input class="text_area" type="text" name="userfolder" id="userfolder" value="<?php echo $this->items->userfolder; ?>" size="32" maxlength="250" />
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
				<td class="key">
					<label for="image">
						<?php echo JText::_( 'Image' ); ?>:
					</label>
				</td>
				<td>
					<?php echo $this->lists['image']; ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<label for="image_position">
						<?php echo JText::_( 'Image Position' ); ?>:
					</label>
				</td>
				<td>
					<?php echo $this->lists['image_position']; ?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
				<script language="javascript" type="text/javascript">
				if (document.forms.adminForm.image.options.value!=''){
					jsimg='../images/stories/' + getSelectedValue( 'adminForm', 'image' );
				} else {
					jsimg='../images/M_images/blank.png';
				}
				document.write('<img src=' + jsimg + ' name="imagelib" width="80" height="80" border="2" alt="<?php echo JText::_( 'Preview', true ); ?>" />');
				</script>
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
	
	<?php
	if ($this->tmpl['enablepicasaloading'] == 1) {
	
	?><fieldset class="adminform">
		<legend><?php echo JText::_( 'PHOCAGALLERY_PICASA_SETTINGS' ); ?></legend>

		<table class="admintable">
			<tr>
				<td valign="middle" align="right" class="key">
					<label for="extu">
						<?php echo JText::_( 'PHOCAGALLERY_PICASA_USER' ); ?>:
					</label>
				</td>
				<td valign="middle">
					<input class="text_area" type="text" name="extu" id="extu" value="<?php echo $this->items->extu; ?>" size="32" maxlength="250" />
				</td>
			</tr>
			
			<tr>
				<td valign="middle" align="right" class="key">
					<label for="exta">
						<?php echo JText::_( 'PHOCAGALLERY_PICASA_ALBUM_NAME' ); ?>:
					</label>
				</td>
				<td valign="middle">
					<input class="text_area" type="text" name="exta" id="exta" value="<?php echo $this->items->exta; ?>" size="32" maxlength="250" />
				</td>
			</tr>			
 			<tr>
 				<td valign="middle" align="right" class="key">
 					<label for="extauth">
 						<?php echo JText::_( 'PHOCAGALLERY_PICASA_AUTH_KEY' ); ?>:
 					</label>
 				</td>
 				<td valign="middle">
 					<input class="text_area" type="text" name="extauth" id="extauth" value="<?php echo $this->items->extauth; ?>" size="32" maxlength="250" />
 				</td>
			</tr>
			</table>
			<input type="hidden" name="extid" value="<?php echo $this->items->extid; ?>" />
	</fieldset><?php
	}
	?>

</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_phocagallery" />
<input type="hidden" name="cid[]" value="<?php echo $this->items->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="phocagalleryc" />
</form>


<div id="loading-ext-img"><div class="loading"><center><?php echo JHTML::_('image.site',  'icon-loading.gif', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_('Loading') ) . '  '. JText::_('PHOCAGALLERY_PICASA_LOADING_DATA'); ?></center></div></div>

	
