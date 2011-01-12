<?php defined('_JEXEC') or die('Restricted access');

// Folder
$currentFolder = '';
if (isset($this->state->folder) && $this->state->folder != '') {
	$currentFolder = $this->state->folder;
}

// SEF problem
$isThereQM = false;
$isThereQM = preg_match("/\?/i", $this->tmpl['action']);

if ($isThereQM) {
	$amp = '&amp;';
} else {
	$amp = '?';
}
$isThereTab = false;
$isThereTab = preg_match("/tab=/i", $this->tmpl['action']);

// Java Upload
$action = $this->tmpl['action'] . $amp .'task=javaupload&amp;'. $this->session->getName().'='.$this->session->getId()
.'&amp;'.JUtility::getToken().'=1&amp;controller=category&amp;viewback=category&tab='.$this->tmpl['currenttab']['upload'];
if ($isThereTab) {
	$return = $this->tmpl['action'];
} else {
	$return = $this->tmpl['action']. $amp .'tab='.$this->tmpl['currenttab']['upload'];
}
$archive = JURI::base().'components/com_phocagallery/assets/java/jupload/wjhk.jupload.jar';


?><div id="phocagallery-upload">
	<fieldset>
		<legend><?php
		
		echo JText::_( 'Upload File' ).' [ '. JText::_( 'Max Size' ).':&nbsp;'.$this->tmpl['uploadmaxsizeread'].','
	.' '.JText::_('Max Resolution').':&nbsp;'. $this->tmpl['uploadmaxreswidth'].' x '.$this->tmpl['uploadmaxresheight'].' px ]';
	
	?></legend><?php
		
// JAVA upload
if ($this->tmpl['enablejava'] == 1) {

	?><h2><?php echo JText::_('Java Upload'); ?></h2>
	<!--[if !IE]> -->
	<object classid="java:wjhk.jupload2.JUploadApplet" type="application/x-java-applet" archive="<?php echo $archive;?>" height="<?php echo $this->tmpl['javaboxheight'] ?>" width="<?php echo $this->tmpl['javaboxwidth'] ?>" >
	<param name="archive" value="<?php echo $archive;?>" />
	<param name="postURL" value="<?php echo $action;?>"/>
	<param name="afterUploadURL" value="<?php echo $return;?>"/>
	<param name="allowedFileExtensions" value="jpg/gif/png/" />		            
	<param name="uploadPolicy" value="PictureUploadPolicy" />            
	<param name="nbFilesPerRequest" value="1" />
	<param name="maxPicHeight" value="<?php echo $this->tmpl['javaresizeheight'] ?>" />
	<param name="maxPicWidth" value="<?php echo $this->tmpl['javaresizewidth'] ?>" />
	<param name="maxFileSize" value="<?php echo $this->tmpl['uploadmaxsize']; ?>" />			
	<param name="pictureTransmitMetadata" value="true" />		
	<param name="showLogWindow" value="false" />	
	<param name="showStatusBar" value="false" />
	<param name="pictureCompressionQuality" value="1" />
	<param name="lookAndFeel"  value="system"/> 	
	<!--<![endif]-->
	<object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93" codebase="http://java.sun.com/update/1.5.0/jinstall-1_5_0-windows-i586.cab" height="<?php echo $this->tmpl['javaboxheight'] ?>" width="<?php echo $this->tmpl['javaboxwidth'] ?>" >
	<param name="code" value="wjhk.jupload2.JUploadApplet" />
	<param name="archive" value="<?php echo $archive;?>" />
	<param name="postURL" value="<?php echo $action;?>"/>
	<param name="afterUploadURL" value="<?php echo $return;?>"/>
	<param name="allowedFileExtensions" value="jpg/gif/png" />		            
	<param name="uploadPolicy" value="PictureUploadPolicy" />            
	<param name="nbFilesPerRequest" value="1" />
	<param name="maxPicHeight" value="<?php echo $this->tmpl['javaresizeheight'] ?>" />
	<param name="maxPicWidth" value="<?php echo $this->tmpl['javaresizewidth'] ?>" />
	<param name="maxFileSize" value="<?php echo $this->tmpl['uploadmaxsize']; ?>" />			
	<param name="pictureTransmitMetadata" value="true" />		
	<param name="showLogWindow" value="false" />	
	<param name="showStatusBar" value="false" />
	<param name="pictureCompressionQuality" value="1" />
	<param name="lookAndFeel"  value="system"/> 
	<div style="color:#cc0000">Java 1.5 or higher plugin required.</div>
	</object> 
	<!--[if !IE]> -->
	</object>
	<!--<![endif]-->
	<div style="font-size:1px;height:1px;margin:0px;padding:0px;border-bottom:1px solid #ccc;margin-top:10px">&nbsp;</div>
	<h2><?php echo JText::_('Single File Upload'); ?></h2>

<?php } // end java upload ?>
	
<form onsubmit="return OnUploadSubmitPG();" action="<?php echo $this->tmpl['action'] . $amp ?>task=upload&amp;<?php echo $this->session->getName().'='.$this->session->getId(); ?>&amp;<?php echo JUtility::getToken();?>=1&amp;viewback=category" name="phocagalleryuploadform" id="phocagallery-upload-form" method="post" enctype="multipart/form-data">
	
<table>
	<tr>
		<td><?php echo JText::_('Filename');?>:</td>
		<td>
		<input type="file" id="file-upload" name="Filedata" />
		<input type="submit" id="file-upload-submit" value="<?php echo JText::_('Start Upload'); ?>"/>
		<span id="upload-clear"></span>
		</td>
	</tr>

	<tr>
		<td><?php echo JText::_( 'Image Title' ); ?>:</td>
			<td>
				<input type="text" id="phocagallery-upload-title" name="phocagalleryuploadtitle" value=""  maxlength="255" class="comment-input" /></td>
		</tr>
		
		<tr>
			<td><?php echo JText::_( 'Description' ); ?>:</td>
			<td><textarea id="phocagallery-upload-description" name="phocagalleryuploaddescription" onkeyup="countCharsUpload();" cols="30" rows="10" class="comment-input"></textarea></td>
		</tr>
			
		<tr>
			<td>&nbsp;</td>
			<td><?php echo JText::_('Characters written');?> <input name="phocagalleryuploadcountin" value="0" readonly="readonly" class="comment-input2" /> <?php echo JText::_('and left for description');?> <input name="phocagalleryuploadcountleft" value="<?php echo $this->tmpl['maxuploadchar'];?>" readonly="readonly" class="comment-input2" />
			</td>
		</tr>
</table>	
<input type="hidden" name="controller" value="category" />
<input type="hidden" name="tab" value="<?php echo $this->tmpl['currenttab']['upload'];?>" />
</form>

<div id="loading-label" style="text-align:center"><?php echo JHTML::_('image', 'components/com_phocagallery/assets/images/icon-switch.gif', '') . '  '.JText::_('Loading'); ?></div>

</fieldset>
</div>
