<?php defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); 
$editor =& JFactory::getEditor();
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.title.value == ""){
			alert( "<?php echo JText::_( 'You must select a title', true ); ?>" );
		} else {
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
<div class="col50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="title">
					<?php echo JText::_( 'Title' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<input class="text_area" type="text" name="title" id="title" size="32" maxlength="250" value="<?php echo $this->phocagallery->title;?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="title">
					<?php echo JText::_( 'User' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<?php echo $this->phocagallery->commentname .' ('. $this->phocagallery->commentusername .')';?>
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="title">
					<?php echo JText::_( 'Date' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<?php echo JHTML::_('date',  $this->phocagallery->date, JText::_('DATE_FORMAT_LC2') ); ?>
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
				<label for="catid">
					<?php echo JText::_( 'Image' ); ?>:
				</label>
			</td>
			<td colspan="2">
				<?php echo $this->phocagallery->imgtitle; ?>
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
	</fieldset>
	
	<fieldset class="adminform">
				<legend><?php echo JText::_( 'PHOCAGALLERY_COMMENT' ); ?></legend>

				<table class="admintable">
					
					<tr>
						<td valign="top" colspan="3">
							<?php
							// parameters : areaname, content, width, height, cols, rows, show xtd buttons
							echo $this->editor->display( 'comment',  $this->phocagallery->comment, '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;
							?>
						</td>
					</tr>
					
					</table>
			</fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="cid[]" value="<?php echo $this->phocagallery->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="phocagallerycoimg" />
</form>
