<?php defined('_JEXEC') or die('Restricted access'); ?>
<table border="0" width="100%">
	<tr>
		<td align="center" valign="middle" height="486"><?php
			if (isset($this->file->extid) && $this->file->extid !='') {				
				$resW	= explode(',', $this->file->extw);
				$resH	= explode(',', $this->file->exth);

				$correctImageRes = PhocaGalleryImage::correctSizeWithRate($resW[0], $resH[0], 640, 480);
				echo '<a href="#" onclick="window.parent.document.getElementById(\'sbox-window\').close();">'. JHTML::_('image', $this->file->extl .'?imagesid='.md5(uniqid(time())), '').'</a>';
		
			} else if ($this->file->linkthumbnailpath=='') {
				echo '<center style="font-size:large;font-weight:bold;color:#b3b3b3;font-family: Helvetica, sans-serif;">'. JText::_( 'Filename does not exist' ).'</center>';
			} else {
				echo '<a href="#" onclick="window.parent.document.getElementById(\'sbox-window\').close();">'. JHTML::_('image', $this->file->linkthumbnailpath .'?imagesid='.md5(uniqid(time())), '').'</a>';
			}
			?>
		</td>
	</tr>
</table>
