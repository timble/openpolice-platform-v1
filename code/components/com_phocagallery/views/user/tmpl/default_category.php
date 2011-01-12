<?php defined('_JEXEC') or die('Restricted access');

echo '<div id="phocagallery-category-creating">'.$this->tmpl['iepx'];

if ($this->tmpl['categorypublished'] == 0) {
	echo '<p>'.JText::_('Your category is unpublished').'</p>';
} else {

if ($this->tmpl['categorytitle'] != '') {
	?><fieldset>
	<legend><?php echo JText::_('PHOCAGALLERY_MAIN_CATEGORY'); ?></legend>
	<table>
		<tr>
			<td><strong><?php echo JText::_('PHOCAGALLERY_CATEGORY');?>:</strong></td>
			<td><?php echo $this->tmpl['categorytitle'] ;?></td>
		</tr>
		<tr>
			<td><strong><?php echo JText::_('PHOCAGALLERY_DESCRIPTION');?>:</strong></td>
			<td><?php echo $this->tmpl['categorydescription'] ;?></td>
		</tr>
		<tr>
			<td><strong><?php echo JText::_('PHOCAGALLERY_APPROVED');?>:</strong></td>
			<td><?php
			if ($this->tmpl['categoryapproved'] == 1) {
				echo JHTML::_('image', $this->tmpl['pi'].'icon-publish.'.$this->tmpl['fi'], JText::_('PHOCAGALLERY_APPROVED'));
			} else {	
				echo JHTML::_('image', $this->tmpl['pi'].'icon-unpublish.'.$this->tmpl['fi'], JText::_('PHOCAGALLERY_NOT_APPROVED'));	
			}
		?></td>
		</tr>
	</table>
	</fieldset><?php
}
?><fieldset>
	<legend><?php echo $this->tmpl['categorycreateoredit']; ?></legend>
	<form action="<?php echo $this->tmpl['action'];?>" name="phocagallerycreatecatform" id="phocagallery-create-cat-form" method="post" >
	<table>
		<tr>
			<td><strong><?php echo JText::_('PHOCAGALLERY_CATEGORY');?>:</strong></td>
			<td><input type="text" id="categoryname" name="categoryname" maxlength="255" class="comment-input" value="<?php echo $this->tmpl['categorytitle'] ;?>" /></td>
		</tr>
		
		<tr>
			<td><strong><?php echo JText::_( 'PHOCAGALLERY_DESCRIPTION' ); ?>:</strong></td>
			<td><textarea id="phocagallery-create-cat-description" name="phocagallerycreatecatdescription" onkeyup="countCharsCreateCat();" cols="30" rows="10" class="comment-input"><?php echo $this->tmpl['categorydescription'] ;?></textarea></td>
		</tr>
				
		<tr>
			<td>&nbsp;</td>
			<td><?php echo JText::_('Characters written');?> <input name="phocagallerycreatecatcountin" value="0" readonly="readonly" class="comment-input2" /> <?php echo JText::_('and left for description');?> <input name="phocagallerycreatecatcountleft" value="<?php echo $this->tmpl['maxcreatecatchar'];?>" readonly="readonly" class="comment-input2" />
			</td>
		</tr>
				
		<tr>
			<td>&nbsp;</td>
			<td align="right"><input type="submit" onclick="return(checkCreateCatForm());" id="phocagallerycreatecatsubmit" value="<?php echo $this->tmpl['categorycreateoredit']; ?>"/>
			</td>
		</tr>
	</table>

	<?php echo JHTML::_( 'form.token' ); ?>
	<input type="hidden" name="task" value="createcategory"/>
	<input type="hidden" name="controller" value="user" />
	<input type="hidden" name="view" value="user"/>
	<input type="hidden" name="tab" value="<?php echo $this->tmpl['currenttab']['createcategory'];?>" />
	<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid', 0, '', 'int') ?>"/>
	</form>

</fieldset><?php
}
echo '</div>';
?>	
