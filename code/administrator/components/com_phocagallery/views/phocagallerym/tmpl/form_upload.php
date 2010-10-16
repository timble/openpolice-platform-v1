<?php 
defined('_JEXEC') or die('Restricted access');
$currentFolder = '';
if (isset($this->state->folder) && $this->state->folder != '') {
 $currentFolder = $this->state->folder;
}

?><div id="phocagallery-upload">
	<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>

	
	<form action="<?php echo JURI::base(); ?>index.php?option=com_phocagallery&controller=phocagalleryu&amp;task=upload&amp;<?php echo $this->session->getName().'='.$this->session->getId(); ?>&amp;<?php echo JUtility::getToken();?>=1&amp;viewback=phocagallerym&amp;folder=<?php echo $currentFolder?>" id="uploadForm" method="post" enctype="multipart/form-data">
	<?php 
	/*$action = JURI::base().'index.php?option=com_phocagallery&controller=phocagalleryu&amp;task=javaupload&amp;'.$this->session->getName().'='.$this->session->getId().'&amp;'. JUtility::getToken().'=1&amp;viewback=phocagallerym&amp;folder='. $currentFolder;
	
	<form action="<?php echo $action;?>" id="uploadForm" method="post" enctype="multipart/form-data">
*/?>
<!-- File Upload Form -->
<?php
if ($this->require_ftp) {
	echo PhocaGalleryFileUpload::renderFTPaccess();
}  ?>
<fieldset>
	<legend><?php 
	echo JText::_( 'Upload File' ).' [ '. JText::_( 'Max Size' ).':&nbsp;'.$this->tmpl['uploadmaxsizeread'].','
	.' '.JText::_('Max Resolution').':&nbsp;'. $this->tmpl['uploadmaxreswidth'].' x '.$this->tmpl['uploadmaxresheight'].' px ]';
?></legend>		
	
	<fieldset class="actions">
		<input type="file" id="sfile-upload" name="Filedata" />
		<input type="submit" id="sfile-upload-submit" value="<?php echo JText::_('Start Upload'); ?>"/>
	</fieldset>
</fieldset>
	<input type="hidden" name="return-url" value="<?php echo base64_encode('index.php?option=com_phocagallery&view=phocagallerym&layout=form&tab='.$this->tmpl['currenttab']['upload']); ?>" />
	<input type="hidden" name="tab" value="<?php echo $this->tmpl['currenttab']['upload']; ?>" />
</form>

<?php 
echo PhocaGalleryFileUpload::renderCreateFolder($this->session->getName(), $this->session->getId(), $currentFolder, 'phocagallerym' );
?>
</div>