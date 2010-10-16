<?php 
defined('_JEXEC') or die('Restricted access');
$currentFolder = '';
if (isset($this->state->folder) && $this->state->folder != '') {
 $currentFolder = $this->state->folder;
}

if ($this->require_ftp) {
	echo PhocaGalleryFileUpload::renderFTPaccess();
}
$action = JURI::base().'index.php?option=com_phocagallery&controller=phocagalleryu&amp;task=javaupload&amp;'.$this->session->getName().'='.$this->session->getId().'&amp;'. JUtility::getToken().'=1&amp;viewback=phocagalleryi&amp;tmpl=component&amp;folder='. $currentFolder;
$return = 'index.php?option=com_phocagallery&view=phocagalleryi&tmpl=component&folder='. $currentFolder.'&tab='.$this->tmpl['currenttab']['javaupload'];
$archive = str_replace('administrator/', '', JURI::base()).'components/com_phocagallery/assets/java/jupload/wjhk.jupload.jar';
?><div id="phocagallery-javaupload">
<fieldset>
<legend><?php 
	echo JText::_( 'Upload File' ).' [ '. JText::_( 'Max Size' ).':&nbsp;'.$this->tmpl['uploadmaxsizeread'].','
	.' '.JText::_('Max Resolution').':&nbsp;'. $this->tmpl['uploadmaxreswidth'].' x '.$this->tmpl['uploadmaxresheight'].' px ]';
?></legend>	
<!--[if !IE]> -->
<object classid="java:wjhk.jupload2.JUploadApplet" type="application/x-java-applet" archive="<?php echo $archive;?>" height="480" width="640" >
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
<object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93" codebase="http://java.sun.com/update/1.5.0/jinstall-1_5_0-windows-i586.cab" height="480" width="640" > 
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
</fieldset>
<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>
	
<?php
echo PhocaGalleryFileUpload::renderCreateFolder($this->session->getName(), $this->session->getId(), $currentFolder, 'phocagalleryi' );
?>
</div>