<?php defined('_JEXEC') or die('Restricted access'); ?>

<div class="phocagallery-box-file-i">
	<center>
		<div class="phocagallery-box-file-first-i">
			<div class="phocagallery-box-file-second">
				<div class="phocagallery-box-file-third">
					<center>
					<a href="index.php?option=com_phocagallery&amp;view=phocagalleryf&amp;tmpl=component&amp;folder=<?php echo $this->_tmp_folder->path_with_name_relative_no; ?>"><?php echo JHTML::_( 'image.administrator', 'components/com_phocagallery/assets/images/icon-folder-images.gif', ''); ?></a>
					</center>
				</div>
			</div>
		</div>
	</center>
	
	<div class="name"><a href="index.php?option=com_phocagallery&amp;view=phocagalleryf&amp;tmpl=component&amp;folder=<?php echo $this->_tmp_folder->path_with_name_relative_no; ?>"><span><?php echo PhocagalleryText::WordDelete($this->_tmp_folder->name,15); ?></span></a></div>
		<div class="detail" style="text-align:right">
			<a href="#" onclick="window.top.document.forms.adminForm.elements.userfolder.value = '<?php echo $this->_tmp_folder->path_with_name_relative_no; ?>';window.parent.document.getElementById('sbox-window').close();"><img src="../administrator/components/com_phocagallery/assets/images/icon-insert.gif" alt="<?php echo JText::_('Insert folder') ?>" title="<?php echo JText::_('Insert folder') ?>" /></a>
		</div>
	<div style="clear:both"></div>
</div>
