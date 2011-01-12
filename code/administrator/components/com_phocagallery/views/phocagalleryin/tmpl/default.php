<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>

<form action="index.php" method="post" name="adminForm">
<div style="float:right;margin:10px;">
	<?php
	echo JHTML::_('image.site',  'logo-phoca.png', '/components/com_phocagallery/assets/images/', NULL, NULL, 'Phoca.cz' )
	?>
</div>

<?php echo  JHTML::_('image', 'components/com_phocagallery/assets/images/icon-phoca-logo.png', 'Phoca.cz');?>

<h3><?php echo JText::_('Information');?></h3>
<p><?php echo JText::_('These are the recommended settings for Phoca Gallery')?></p>
<table cellpadding="5" cellspacing="1">
<tr><td></td><td align="center"><?php echo JText::_('Recommended');?></td><td align="center"><?php echo JText::_('Actual');?></td></tr>

<?php if ($this->tmpl['enablethumbcreation'] == 1) {
	$bgStyle = 'style="background:#ffcccc"';
} else {
	$bgStyle = 'style="background:#ccffcc"';
}?>
<tr <?php echo $bgStyle;?> >
	<td><?php echo JText::_('Enable Thumbnails Creation');?></td>
	<td align="center"><?php echo JHTML::_('image.site',  'icon-16-false.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_('Disabled') ) ?></td>
	<td align="center"><?php echo $this->tmpl['enablethumbcreationstatus']; ?></td>
</tr>
<tr><td colspan="3"><?php echo JText::_('Enable Thumbnails Creation Info DESC');?></td></tr>


<?php if ($this->tmpl['paginationthumbnailcreation'] == 1) {
	$bgStyle 	= 'style="background:#ccffcc"';
	$icon		= 'true';
	$iconText	= JText::_('Enabled');
} else {
	$bgStyle 	= 'style="background:#ffcccc"';
	$icon		= 'false';
	$iconText	= JText::_('Disabled');
}?>
<tr <?php echo $bgStyle;?> >
	<td><?php echo JText::_('Pagination Thumbnail Creation');?></td>
	<td align="center"><?php echo JHTML::_('image.site',  'icon-16-true.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_('Enabled') ) ?></td>
	<td align="center"><?php echo JHTML::_('image.site',  'icon-16-'.$icon.'.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_($iconText) ) ?></td>
</tr>
<tr><td colspan="3"><?php echo JText::_('Pagination Thumbnail Creation Info DESC');?></td></tr>

<?php if ($this->tmpl['cleanthumbnails'] == 1) {
	$bgStyle = 'style="background:#ffcccc"';
	$icon		= 'true';
	$iconText	= JText::_('Enabled');

} else {
	$bgStyle = 'style="background:#ccffcc"';
	$icon		= 'false';
	$iconText	= JText::_('Disabled');
}?>
<tr <?php echo $bgStyle;?> >
	<td><?php echo JText::_('Clean Thumbnails');?></td>
	<td align="center"><?php echo JHTML::_('image.site',  'icon-16-false.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_('Disabled') ) ?></td>
	<td align="center"><?php echo JHTML::_('image.site',  'icon-16-'.$icon.'.png', '/components/com_phocagallery/assets/images/', NULL, NULL, JText::_($iconText) ) ?></td>
</tr>
<tr><td colspan="3"><?php echo JText::_('Clean Thumbnails Info DESC');?></td></tr>

<?php echo $this->foutput; ?>
</table>

<h3><?php echo JText::_('Help');?></h3>

<p>
<a href="http://www.phoca.cz/phocagallery/" target="_blank">Phoca Gallery Main Site</a><br />
<a href="http://www.phoca.cz/documentation/" target="_blank">Phoca Gallery User Manual</a><br />
<a href="http://www.phoca.cz/forum/" target="_blank">Phoca Gallery Forum</a><br />
</p>

<h3><?php echo JText::_('Version');?></h3>
<p><?php echo $this->tmpl['version'] ;?></p>

<h3><?php echo JText::_('Copyright');?></h3>
<p>© 2007 - <?php echo date("Y"); ?> Jan Pavelka<br />
<a href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></p>

<h3><?php echo JText::_('License');?></h3>
<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>



<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_phocagallery" />
<input type="hidden" name="controller" value="phocagalleryin" />
</form>
<p>&nbsp;</p>

<div style="border-top:1px solid #c2c2c2"></div>
<div id="pg-update" ><a href="http://www.phoca.cz/version/index.php?phocagallery=<?php echo $this->tmpl['version'] ;?>" target="_blank"><?php echo JText::_('Check for update'); ?></a></div>
