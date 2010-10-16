<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php echo $this->loadTemplate('up'); ?>
<?php if (count($this->images) > 0 || count($this->folders) > 0) { ?>
<div>
		<?php for ($i=0,$n=count($this->folders); $i<$n; $i++) :
			$this->setFolder($i);
			echo $this->loadTemplate('folder');
		endfor; ?>

		<?php for ($i=0,$n=count($this->images); $i<$n; $i++) :
			$this->setImage($i);
			echo $this->loadTemplate('image');
		endfor; ?>

</div>
<?php } else { ?>
<div>
	<center style="clear:both;font-size:large;font-weight:bold;color:#b3b3b3;font-family: Helvetica, sans-serif;">
		<?php echo JText::_( 'There is no image folder' ); ?>
	</center>
</div>
<?php } ?>

<div style="clear:both">
<div style="border-bottom:1px solid #cccccc;margin-bottom: 10px">&nbsp;</div>

<?php
if ($this->tmpl['displaytabs'] > 0) {

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
?>
