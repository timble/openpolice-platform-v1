<?php defined('_JEXEC') or die('Restricted access');

echo '<div id="phocagallery-upload">'.$this->tmpl['iepx'];

if ($this->tmpl['displayupload'] == 1) {
	if ($this->tmpl['categorypublished'] == 0) {
		echo '<p>'.JText::_('Your category is unpublished').'</p>';
	} else if ($this->tmpl['task'] == 'editimg' && $this->tmpl['imageedit']) {

?><fieldset>
<legend><?php echo JText::_('PHOCAGALLERY_EDIT'); ?></legend>
<form action="<?php echo $this->tmpl['action'];?>" name="phocagalleryuploadform" id="phocagallery-upload-form" method="post" >	
<table>	
	<tr>
		<td><?php echo JText::_('PHOCAGALLERY_TITLE');?>:</td>
		<td><input type="text" id="imagename" name="imagename" maxlength="255" class="comment-input" value="<?php echo $this->tmpl['imageedit']->title ?>" /></td>
	</tr>
	
	<tr>
		<td><?php echo JText::_( 'PHOCAGALLERY_DESCRIPTION' ); ?>:</td>
		<td><textarea id="phocagallery-upload-description" name="phocagalleryuploaddescription" onkeyup="countCharsUpload();" cols="30" rows="10" class="comment-input"><?php echo $this->tmpl['imageedit']->description; ?></textarea></td>
	</tr>
				
	<tr>
		<td>&nbsp;</td>
		<td><?php echo JText::_('Characters written');?> <input name="phocagalleryuploadcountin" value="0" readonly="readonly" class="comment-input2" /> <?php echo JText::_('and left for description');?> <input name="phocagalleryuploadcountleft" value="<?php echo $this->tmpl['maxcreatecatchar'];?>" readonly="readonly" class="comment-input2" />
		</td>
	</tr>
				
	<tr>
		<td>&nbsp;</td>
		<td align="right"><input type="button" onclick="window.location='<?php echo JRoute::_($this->tmpl['pp'].$this->tmpl['psi']);?>'" id="phocagalleryimagecancel" value="<?php echo JText::_('PHOCAGALLERY_CANCEL'); ?>"/> <input type="submit" onclick="return(checkCreateImageForm());" id="phocagalleryimagesubmit" value="<?php echo JText::_('PHOCAGALLERY_EDIT'); ?>"/></td>
	</tr>
</table>

<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="task" value="editimage"/>
<input type="hidden" name="controller" value="user" />
<input type="hidden" name="view" value="user"/>
<input type="hidden" name="tab" value="<?php echo $this->tmpl['currenttab']['images'];?>" />
<input type="hidden" name="limitstartsubcat" value="<?php echo $this->tmpl['subcategorypagination']->limitstart;?>" />
<input type="hidden" name="limitstartimage" value="<?php echo $this->tmpl['imagepagination']->limitstart;?>" />
<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid', 0, '', 'int') ?>"/>
<input type="hidden" name="id" value="<?php echo $this->tmpl['imageedit']->id ?>"/>
<input type="hidden" name="parentcategoryid" value="<?php echo $this->tmpl['parentcategoryid'] ?>"/>
<input type="hidden" name="filter_order_image" value="<?php echo $this->listsimage['order']; ?>" />
<input type="hidden" name="filter_order_Dir_image" value="" />
</form>
</fieldset><?php
	} else {


?><fieldset>
<legend><?php echo JText::_( 'Images' ); ?></legend>
<form action="<?php echo $this->tmpl['action'];?>" method="post" name="phocagalleryimageform">
<table>
	<tr>
		<td align="left" width="100%"><?php echo JText::_( 'Filter' ); ?>:
		<input type="text" name="phocagalleryimagesearch" id="phocagalleryimagesearch" value="<?php echo $this->listsimage['search'];?>" onchange="document.phocagalleryimageform.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('phocagalleryimagesearch').value='';document.phocagalleryimageform.submit();"><?php echo JText::_( 'Reset' ); ?></button></td>
		<td nowrap="nowrap"><?php echo $this->listsimage['catid']; echo $this->listsimage['state'];?></td>
	</tr>
</table>
		
<table class="adminlist">
<thead>
	<tr>
	<th width="5"><?php echo JText::_( 'NUM' ); ?></th>
	<th class="image" width="3%" align="center"><?php echo JText::_( 'Image' ); ?></th>
	<th class="title" width="15%"><?php echo JHTML::_('grid.sort',  JText::_('PHOCAGALLERY_TITLE'), 'a.title', $this->listsimage['order_Dir'], $this->listsimage['order'], 'image'); ?></th>
	<th width="3%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  JText::_('PHOCAGALLERY_PUBLISHED'), 'a.published', $this->listsimage['order_Dir'], $this->listsimage['order'], 'image' ); ?></th>
	<th width="3%" nowrap="nowrap"><?php echo JText::_('Delete'); ?></th>
	<th width="3%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  JText::_('PHOCAGALLERY_APPROVED'), 'a.approved', $this->listsimage['order_Dir'], $this->listsimage['order'], 'image' ); ?></th>
	<th width="80" nowrap="nowrap" align="center">
	
	<?php echo JHTML::_('grid.sort',  JTExt::_('PHOCAGALLERY_ORDER'), 'a.ordering', $this->listsimage['order_Dir'], $this->listsimage['order'],'image' );
	$image = '<img src="'.JURI::base(true).'/'.$this->tmpl['pi'].'icon-filesave.'.$this->tmpl['fi'].'" width="16" height="16" border="0" alt="'.JText::_( 'PHOCAGALLERY_SAVE_ORDER' ).'" />';
	$task = 'saveordersubcat';
	$href = '<a href="javascript:saveorderimage()" title="'.JText::_( 'PHOCAGALLERY_SAVE_ORDER' ).'">'.$image.'</a>';
	echo $href;
	?>
	<th width="3%" nowrap="nowrap"><?php echo JHTML::_('grid.sort', JText::_( 'PHOCAGALLERY_CATEGORY' ), 'a.catid', $this->listsimage['order_Dir'], $this->listsimage['order'], 'image' ); ?></th>
	
	<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'ID', 'a.id', $this->listsimage['order_Dir'], $this->listsimage['order'] , 'image'); ?></th>
	</tr>
</thead>
			
<tbody><?php
$k 		= 0;
$i 		= 0;
$n 		= count( $this->tmpl['imageitems'] );
$rows 	= &$this->tmpl['imageitems'];

if (is_array($rows)) {
	foreach ($rows as $row) {
		$linkEdit 	= JRoute::_( $this->tmpl['pp'].'&task=editimg&id='. $row->slug.$this->tmpl['psi'] );

	?><tr class="<?php echo "row$k"; ?>">
	<td>
		<input type="hidden" id="cb<?php echo $k ?>" name="cid[]" value="<?php echo $row->id ?>" />
		<?php 
		echo $this->tmpl['imagepagination']->getRowOffset( $i );?>
	</td>
	<td align="center" valign="middle">
	<?php
	$row->linkthumbnailpath = PhocaGalleryImageFront::displayCategoryImageOrNoImage($row->filename, 'small');
	$imageRes	= PhocaGalleryImage::getRealImageSize($row->filename, 'small');
	$correctImageRes = PhocaGalleryImage::correctSizeWithRate($imageRes['w'], $imageRes['h'], 50, 50);
	echo JHTML::_( 'image', $row->linkthumbnailpath.'?imagesid='.md5(uniqid(time())),'', array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']));
	?>
	</td>

	<td><a href="<?php echo $linkEdit; ?>" title="<?php echo JText::_( 'PHOCAGALLERY_EDIT_CATEGORY' ); ?>"><?php echo $row->title; ?></a></td>
	<?php 

	// Publish Unpublish
	echo '<td align="center">';
	if ($row->published == 1) {
		echo ' <a title="'.JText::_('PHOCAGALLERY_UNPUBLISH').'" href="'. JRoute::_($this->tmpl['pp'].'&id='.$row->slug.'&task=unpublishimage'. $this->tmpl['psi']).'">';
		echo JHTML::_('image', $this->tmpl['pi'].'icon-publish.'.$this->tmpl['fi'], JText::_('PHOCAGALLERY_UNPUBLISH')).'</a>';
	}
	if ($row->published == 0) {
		echo ' <a title="'.JText::_('PHOCAGALLERY_PUBLISH').'" href="'. JRoute::_($this->tmpl['pp'].'&id='.$row->slug.'&task=publishimage'.$this->tmpl['psi']).'">';
		echo JHTML::_('image', $this->tmpl['pi'].'icon-unpublish.'.$this->tmpl['fi'], JText::_('PHOCAGALLERY_PUBLISH')).'</a>';		
	}
	echo '</td>';
	
	// Remove
	echo '<td align="center">';
	echo ' <a onclick="return confirm(\''.JText::_('WARNWANTDELLISTEDITEMS').'\')" title="'.JText::_('Delete').'" href="'. JRoute::_($this->tmpl['pp'].'&id='.$row->slug.'&task=removeimage'.$this->tmpl['psi'] ).'">';
	echo JHTML::_('image',  $this->tmpl['pi'].'icon-trash.'.$this->tmpl['fi'], JText::_('PHOCAGALLERY_DELETE')).'</a>';
	echo '</td>';
	
	// Approved
	echo '<td align="center">';
	if ($row->approved == 1) {
		echo JHTML::_('image', $this->tmpl['pi'].'icon-publish.'.$this->tmpl['fi'], JText::_('Approved'));
	} else {	
		echo JHTML::_('image', $this->tmpl['pi'].'icon-unpublish.'.$this->tmpl['fi'], JText::_('Not Approved'));	
	}
	echo '</td>';
	
	$linkUp 	= JRoute::_($this->tmpl['pp'].'&id='.$row->slug.'&task=orderupimage'.$this->tmpl['psi']);
	$linkDown 	= JRoute::_($this->tmpl['pp'].'&id='.$row->slug.'&task=orderdownimage'.$this->tmpl['psi']);

	echo '<td class="order" align="right">'
	.'<span>'. $this->tmpl['imagepagination']->orderUpIcon( $i, ($row->catid == @$this->tmpl['imageitems'][$i-1]->catid), $linkUp, 'Move Up', $this->tmpl['imageordering']).'</span> ' 
	.'<span>'. $this->tmpl['imagepagination']->orderDownIcon( $i, $n, ($row->catid == @$this->tmpl['imageitems'][$i+1]->catid), $linkDown, 'Move Down', $this->tmpl['imageordering'] ).'</span> ';
	
	$disabled = $this->tmpl['imageordering'] ?  '' : 'disabled="disabled"';
	echo '<input type="text" name="order[]" size="5" value="'. $row->ordering.'" '. $disabled.' class="text_area" style="text-align: center" />';
	echo '</td>';
	
	echo '<td align="center">'. $row->category .'</td>';
	echo '<td align="center">'. $row->id .'</td>'
	.'</tr>';

		$k = 1 - $k;
		$i++;
	}
}
?></tbody>
<tfoot>
	<tr>
	<td colspan="9" class="footer"><?php 
	
$this->tmpl['imagepagination']->setTab($this->tmpl['currenttab']['images']);
if (count($this->tmpl['imageitems'])) {
	echo '<div class="pgcenter">';
	echo '<div class="pginline">'
		.JText::_('Display Num') .'&nbsp;'
		.$this->tmpl['imagepagination']->getLimitBox()
		.'</div>';
	echo '<div style="margin:0 10px 0 10px;display:inline;" class="sectiontablefooter'.$this->params->get( 'pageclass_sfx' ).'" >'
		.$this->tmpl['imagepagination']->getPagesLinks()
		.'</div>'
		.'<div style="margin:0 10px 0 10px;display:inline;" class="pagecounter">'
		.$this->tmpl['imagepagination']->getPagesCounter()
		.'</div>';
	echo '</div>';
}

?></td>
	</tr>
</tfoot>
</table>


<?php echo JHTML::_( 'form.token' ); ?>

<input type="hidden" name="controller" value="user" />
<input type="hidden" name="task" value=""/>
<input type="hidden" name="view" value="user"/>
<input type="hidden" name="tab" value="<?php echo $this->tmpl['currenttab']['images'];?>" />
<input type="hidden" name="limitstartsubcat" value="<?php echo $this->tmpl['subcategorypagination']->limitstart;?>" />
<input type="hidden" name="limitstartimage" value="<?php echo $this->tmpl['imagepagination']->limitstart;?>" />
<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid', 0, '', 'int') ?>"/>
<input type="hidden" name="catid" value="<?php echo $this->tmpl['catidimage'] ?>"/>
<input type="hidden" name="filter_order_image" value="<?php echo $this->listsimage['order']; ?>" />
<input type="hidden" name="filter_order_Dir_image" value="" />

</form>
</fieldset>
<?php

// Upload		
$currentFolder = '';
if (isset($this->state->folder) && $this->state->folder != '') {
	$currentFolder = $this->state->folder;
}
?><fieldset>
<legend><?php 
	echo JText::_( 'PHOCAGALLERY_UPLOAD_IMAGE' ).' [ '. JText::_( 'PHOCAGALLERY_MAX_SIZE' ).':&nbsp;'.$this->tmpl['uploadmaxsizeread'].','
	.' '.JText::_('PHOCAGALLERY_MAX_RESOLUTION').':&nbsp;'. $this->tmpl['uploadmaxreswidth'].' x '.$this->tmpl['uploadmaxresheight'].' px ]';
?></legend>	<?php
		
		// JAVA upload
		if ($this->tmpl['enablejava'] == 1) {
			// Java Upload
			// WE WILL USE CATEGORY MODEL AND COTROLLER controller=category
			
			$action = $this->tmpl['actionamp'].'task=javaupload&amp;'. $this->session->getName().'='.$this->session->getId()
			.'&amp;'.JUtility::getToken().'=1&amp;controller=user&amp;viewback=user&tab='.$this->tmpl['currenttab']['images']. '&catid='.$this->tmpl['catidimage'];
			if ($this->tmpl['istheretab']) {
				$return = $this->tmpl['action'];
			} else {
				$return = $this->tmpl['actionamp'] .'tab='.$this->tmpl['currenttab']['images'];
			}
			$archive = JURI::base().'components/com_phocagallery/assets/java/jupload/wjhk.jupload.jar';
			?><p><strong><?php echo JText::_('Java Upload'); ?></strong></p>
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
			<p><strong><?php echo JText::_('Single File Upload'); ?></strong></p>
		
		<?php } // end java upload ?>
				
				
<form onsubmit="return OnUploadSubmitPG();" action="<?php echo $this->tmpl['actionamp'] ?>task=upload&amp;<?php echo $this->session->getName().'='.$this->session->getId(); ?>&amp;<?php echo JUtility::getToken();?>=1" name="phocagalleryuploadform" id="phocagallery-upload-form" method="post" enctype="multipart/form-data">
<table>
	<tr>
		<td><strong><?php echo JText::_('PHOCAGALLERY_FILENAME');?>:</strong></td><td>
			<input type="file" id="file-upload" name="Filedata" />
			<input type="submit" id="file-upload-submit" value="<?php echo JText::_('Start Upload'); ?>"/>
			<span id="upload-clear"></span></td>
		</tr>
					
		<tr>
			<td><strong><?php echo JText::_( 'PHOCAGALLERY_IMAGE_TITLE' ); ?>:</strong></td>
			<td><input type="text" id="phocagallery-upload-title" name="phocagalleryuploadtitle" value=""  maxlength="255" class="comment-input" /></td>
		</tr>
		<tr>
			<td><strong><?php echo JText::_( 'PHOCAGALLERY_DESCRIPTION' ); ?>:</strong></td>
			<td><textarea id="phocagallery-upload-description" name="phocagalleryuploaddescription" onkeyup="countCharsUpload();" cols="30" rows="10" class="comment-input"></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo JText::_('Characters written');?> <input name="phocagalleryuploadcountin" value="0" readonly="readonly" class="comment-input2" /> <?php echo JText::_('and left for description');?> <input name="phocagalleryuploadcountleft" value="<?php echo $this->tmpl['maxuploadchar'];?>" readonly="readonly" class="comment-input2" />
			</td>
		</tr>
	</table>
	
	<ul class="upload-queue" id="upload-queue"><li style="display: none" ></li></ul>

	<input type="hidden" name="controller" value="user" />
	<input type="hidden" name="viewback" value="user" />
	<input type="hidden" name="view" value="user"/>
	<input type="hidden" name="tab" value="<?php echo $this->tmpl['currenttab']['images'];?>" />
	<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid', 0, '', 'int') ?>"/>
	<input type="hidden" name="filter_order_image" value="<?php echo $this->listsimage['order']; ?>" />
	<input type="hidden" name="filter_order_Dir_image" value="" />
	<input type="hidden" name="catid" value="<?php echo $this->tmpl['catidimage'] ?>"/>
</form>
<div id="loading-label" style="text-align:center"><?php echo JHTML::_('image', $this->tmpl['pi'].'icon-switch.gif', '') . '  '. JText::_('Loading'); ?></div>
</fieldset>
	<?php
	}
} else {
	echo '<div>'.JText::_('PHOCAGALLERY_NO_CATEGORY_TO_UPLOAD_IMAGES').'</div>';
	echo '<div>'.JText::_('PHOCAGALLERY_NO_CATEGORY_TO_UPLOAD_IMAGES_ADMIN').'</div>';
}
echo '</div>';
?>
