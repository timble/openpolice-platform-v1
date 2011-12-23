<?php defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.file' );
$image['width'] = $image['height'] = 100;

if (JFile::exists( $this->_tmp_img->linkthumbnailpathabs )) {
	list($width, $height) = GetImageSize( $this->_tmp_img->linkthumbnailpathabs );
	$image = PhocaGalleryImage::correctSizeWithRate($width, $height);
}

?><div class="phocagallery-box-file-i">
	<center>
		<div class="phocagallery-box-file-first-i">
			<div class="phocagallery-box-file-second">
				<div class="phocagallery-box-file-third">
					<center>
					<a href="#" onclick="window.top.document.forms.adminForm.elements.filename.value = '<?php echo $this->_tmp_img->nameno; ?>';window.parent.document.getElementById('sbox-window').close();">
	<?php
	
	$imageRes	= PhocaGalleryImage::getRealImageSize($this->_tmp_img->nameno, 'medium');
	$correctImageRes = PhocaGalleryImage::correctSizeWithRate($imageRes['w'], $imageRes['h'], 100, 100);
	echo JHTML::_( 'image', JURI::root(false, '').substr($this->_tmp_img->linkthumbnailpath, 1), null, array('width' => $image['width'], 'height' => $image['height']), '', null); ?></a>
					</center>
				</div>
			</div>
		</div>
	</center>
	
	<div class="name"><?php echo $this->_tmp_img->name; ?></div>
		<div class="detail" style="text-align:right">
			<a href="#" onclick="window.top.document.forms.adminForm.elements.filename.value = '<?php echo $this->_tmp_img->nameno; ?>';window.parent.document.getElementById('sbox-window').close();"><img src="../administrator/components/com_phocagallery/assets/images/icon-insert.gif" alt="<?php echo JText::_('Insert image') ?>" title="<?php echo JText::_('Insert image') ?>" /></a>
		</div>
	<div style="clear:both"></div>
</div>
