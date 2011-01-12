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
	$items = array('switchheight', 'switchwidth', 'switchfixedsize' );
	$itemsArrayOutput = '';
	foreach ($items as $key => $value) {
		
		echo 'var '.$value.' = document.getElementById("'.$value.'").value;'."\n"
			.'if ('.$value.' != \'\') {'. "\n"
			.''.$value.' = "|'.$value.'="+'.$value.';'."\n"
			.'}';
		$itemsArrayOutput .= '+'.$value;
	}
	?>
	
	/* Image */
	var imageIdOutput = '';
	len = document.getElementsByName("imageid").length;
	for (i = 0; i <len; i++) {
		if (document.getElementsByName('imageid')[i].checked) {
			imageid = document.getElementsByName('imageid')[i].value;
			if (imageid != '' && parseInt(imageid) > 0) {
				imageIdOutput = "|basicimageid="+imageid;
			} else {
				imageIdOutput = '';
			}
		}
	}
	
	if (imageIdOutput != '' &&  parseInt(imageid) > 0) {
		/*return false;*/
	} else {
		alert("<?php echo JText::_( 'You must select an image', true ); ?>");
		return false;
	}
	var tag = "{phocagallery view=switchimage"+imageIdOutput<?php echo $itemsArrayOutput ?>+"}";
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
			<td class="key" align="right" width="30%">
				<label for="title">
					<?php echo JText::_( 'Filter' ); ?>
				</label>
			</td>
			<td width="70%">
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
				<th width="5px"><?php echo JText::_( 'NUM' ); ?></th>
				<th width="5px"></th>
				<th class="image" width="60" align="center"><?php echo JText::_( 'Image' ); ?></th>
				<th class="title" width="40%"><?php echo JHTML::_('grid.sort',  'Title', 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th width="30%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'Filename', 'a.filename', $this->lists['order_Dir'], $this->lists['order'] ); ?>
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
	
	<?php
	
	// Number
	$itemsNumber = array ('switchheight' => array('Switch Image Height', 480),'switchwidth' => array('Switch Image Width', 640));
	foreach ($itemsNumber as $key => $value) {
		echo '<tr>'
		.'<td class="key" align="right" width="30%"><label for="'.$key.'">'.JText::_($value[0]).'</label></td>'
		.'<td nowrap="nowrap"><input type="text" name="'.$key.'" id="'.$key.'" value="'.$value[1].'" class="text_area" /></td>'
		.'</tr>';
	}
	
	echo '<tr>'
		.'<td class="key" align="right" width="30%"><label for="switchfixedsize">'.JText::_('Switch Fixed Size').'</label></td>'
		.'<td nowrap><select name="pgslink" id="switchfixedsize" class="inputbox">'
		.'<option value="0"  selected="selected">'. JText::_( 'No' ).'</option>'
		.'<option value="1" >'.JText::_( 'Yes' ).'</option>'
		.'</select></td></tr>';
	
	?>

	
	<tr>
		<td>&nbsp;</td>
		<td align="right"><button onclick="insertLink();return false;"><?php echo JText::_( 'Insert Code' ); ?></button></td>
	</tr>
</table>
</form>

</fieldset>
<div style="text-align:right;margin:20px 5px;"><span class="icon-16-edb-back"><a style="text-decoration:underline" href="<?php echo $this->tmpl['backlink'];?>"><?php echo JText::_('Back')?></a></span></div>
</div>