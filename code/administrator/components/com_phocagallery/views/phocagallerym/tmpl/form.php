<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		/*if (form.title.value == ""){
			alert( "<?php echo JText::_( 'Gallery item must have a title', true ); ?>" );
		} else*/ if (document.adminForm.boxchecked.value==0) {
			alert( "<?php echo JText::_( 'You must select a filename or folder', true ); ?>" );
		} else 
		{
		    var f = document.adminForm;
			var nSelectedImages = 0;
			var nSelectedFolders = 0;
			var i=0;
			cb = eval( 'f.cb' + i );
			while (cb)
			{
				if (cb.checked == false) {
					// Do nothing
				}
				else if (cb.name == "cid[]") {
					nSelectedImages++;
				}
				else
				{
					nSelectedFolders++;
				}
				// Get next
				i++;
				cb = eval( 'f.cb' + i );
			}
			if (form.catid.value == "0" && nSelectedImages > 0){
				alert( "<?php echo JText::_( 'Images selected: You must select also a category', true ); ?>" );
			} else {
				submitform( pressbutton );
			}
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
			<td valign="top" align="right" class="key">
				<?php echo JText::_( 'Published' ); ?>:
			</td>
			<td colspan="2">
				<?php echo $this->lists['published']; ?>
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
			<td valign="top" align="right" class="key">
				<label for="ordering">
					<?php echo JText::_( 'Ordering' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<?php echo $this->lists['ordering']; ?>
			</td>
		</tr>
	</table>
		
		
		<?php /*images manager*/ ?>
	<div id="editcell">
		<table  class="adminlist">
		
		<thead>
			<tr>
				<th width="5">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->images)+count($this->folders); ?>);" /></th>
				<th width="20">&nbsp;</th>
				<th width="95%"><?php echo JText::_( 'Filename' ); ?></th>
			</tr>
		</thead>
		
		<tbody>
			
			<?php //UP ?>
			<tr>
				<td>&nbsp;</td>
				<td><a href="index.php?option=com_phocagallery&amp;view=phocagallerym&amp;layout=form&amp;hidemainmenu=1&amp;folder=<?php echo $this->state->parent; ?>" ><?php echo JHTML::_( 'image.administrator', 'components/com_phocagallery/assets/images/icon-up-small.gif', ''); ?></a></td>
				<td><a href="index.php?option=com_phocagallery&amp;view=phocagallerym&amp;layout=form&amp;hidemainmenu=1&amp;folder=<?php echo $this->state->parent; ?>" >..</a>
				</td>
			</tr>
				
			<?php 
			if (count($this->images) > 0 || count($this->folders) > 0) {
				//FOLDERS
				for ($i=0,$n=count($this->folders); $i<$n; $i++) :
				$checked 	= JHTML::_('grid.id', $i, $this->folders[$i]->path_with_name_relative_no, 0, 'foldercid' );
				?>
				<tr>
					<td><?php echo $checked; ?></td>
					<td>
					<a href="<?php echo JRoute::_( 'index.php?option=com_phocagallery&view=phocagallerym&layout=form&hidemainmenu=1&folder='.$this->folders[$i]->path_with_name_relative_no ); ?>"><?php echo JHTML::_( 'image.administrator', 'components/com_phocagallery/assets/images/icon-folder-small.gif', ''); ?></a></span>
					</td>
					<td><a href="<?php echo JRoute::_( 'index.php?option=com_phocagallery&view=phocagallerym&layout=form&hidemainmenu=1&folder='.$this->folders[$i]->path_with_name_relative_no ); ?>"><span><?php echo $this->folders[$i]->name; ?></span></a>
					</td>
				</tr>
				<?php endfor;
				
				//IMAGES
				for ($i=0,$n=count($this->images); $i<$n; $i++) :
				$row 		= &$this->images[$i];
				$checked 	= JHTML::_('grid.id', $i+count($this->folders), $this->images[$i]->nameno );
				//$checked	= '<input type="checkbox" name="cid[]" value="'.$i.'" />';
				?>
				<tr>
					<td><?php echo $checked; ?></td>
					<td><p><?php echo JHTML::_( 'image.administrator', 'components/com_phocagallery/assets/images/icon-image-small.gif', ''); ?></p></td>
					<td><p><?php echo  $this->images[$i]->nameno; ?></p></td>
				</tr>
				<?php endfor; 
			}
			else
			{ ?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><?php echo JText::_( 'There is no image folder' ); ?></td>
				</tr>			
			<?php
			} ?>
		</tbody>
		</table>
	</div>
	</fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="phocagallerym" />
<input type="hidden" name="boxchecked" value="0" />
</form>



<div style="clear:both"></div>



<?php
/*
$currentFolder = '';
if (isset($this->state->folder) && $this->state->folder != '') {
 $currentFolder = $this->state->folder;
}*/

/*if ($this->tmpl['displaytabs'] > 0) {
	echo '<div id="phocagallery-pane">';
	$pane =& JPane::getInstance('Tabs', array('startOffset'=> $this->tmpl['tab']));
	echo $pane->startPane( 'pane' );

	echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/icon-16-upload.png','', '', '', '', '') . '&nbsp;'.JText::_('Upload'), 'votes' );
	echo $this->loadTemplate('upload');
	echo $pane->endPanel();

	if($this->tmpl['enablejavaadmin']  == 1) {
		echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/icon-16-upload-java.png','', '', '', '', '') . '&nbsp;'.JText::_('Java Upload'), 'votes' );
		echo $this->loadTemplate('javaupload');
		echo $pane->endPanel();
	}


	echo $pane->startPanel( JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/icon-16-upload-flash.png','', '', '', '', '') . '&nbsp;'.JText::_('Flash Upload'), 'votes' );
	echo $this->loadTemplate('flashupload');
	echo $pane->endPanel();

	echo $pane->endPane();
	echo '</div>';// end phocagallery-pane
}
?>*/


