<?php defined('_JEXEC') or die('Restricted access');?>

<form action="index.php" method="post" name="adminForm">
<table class="adminform">
	<tr>
		<td width="55%" valign="top">
			<div id="cpanel">
	<?php
	$link = 'index.php?option=com_phocagallery&view=phocagallerys';
	echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-gal.png', JText::_( 'Images' ) );
	
	$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
	echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-cat.png', JText::_( 'Categories' ) );
	
	$link = 'index.php?option=com_phocagallery&view=phocagalleryt';
	echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-theme.png', JText::_( 'Themes' ) );
	
	$link = 'index.php?option=com_phocagallery&view=phocagalleryra';
	echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-vote.png', JText::_( 'Category Rating' ) );
	
	$link = 'index.php?option=com_phocagallery&view=phocagalleryraimg';
	echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-vote-img.png', JText::_( 'Image Rating' ) );
	
	$link = 'index.php?option=com_phocagallery&view=phocagallerycos';
	echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-comment.png', JText::_( 'PHOCAGALLERY_CATEGORY_COMMENTS' ) );
	$link = 'index.php?option=com_phocagallery&view=phocagallerycoimgs';
	echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-comment-img.png', JText::_( 'PHOCAGALLERY_IMAGE_COMMENTS' ) );
	
	$link = 'index.php?option=com_phocagallery&view=phocagalleryusers';
	echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-users.png', JText::_( 'PHOCAGALLERY_USERS' ) );
	
	//$link = 'index.php?option=com_phocagallery&view=phocagalleryucs';
	//echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-users-cat.png', JText::_( 'Users Categories' ) );
	
	$link = 'index.php?option=com_phocagallery&view=phocagalleryin';
	echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-info.png', JText::_( 'Info' ) );
	?>
			
			<div style="clear:both">&nbsp;</div>
			<p>&nbsp;</p>
			<div style="text-align:center;padding:0;margin:0;border:0">
				<iframe style="padding:0;margin:0;border:0" src="http://www.phoca.cz/adv/phocagallery" noresize="noresize" frameborder="0" border="0" cellspacing="0" scrolling="no" width="500" marginwidth="0" marginheight="0" height="125">
				<a href="http://www.phoca.cz/adv/phocagallery" target="_blank">Phoca Gallery</a>
				</iframe> 
			</div>
			
			
			</div>
		</td>
		
		<td width="45%" valign="top">
			<div style="border:1px solid #ccc;background:#fff;margin:15px;padding:15px">
			<div style="float:right;margin:10px;">
				<?php echo JHTML::_('image.site',  'logo-phoca.png', '/components/com_phocagallery/assets/images/', NULL, NULL, 'Phoca.cz' );?>
			</div>
			
			<h3><?php echo JText::_('Version');?></h3>
			<p><?php echo $this->version ;?></p>

			<h3><?php echo JText::_('Copyright');?></h3>
			<p>© 2007 - <?php echo date("Y"); ?> Jan Pavelka<br />
			<a href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></p>

			<h3><?php echo JText::_('License');?></h3>
			<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>
			<p>&nbsp;</p>
			
			<p><strong><?php echo JText::_('SHADOW BOX LICENSE HEAD');?></strong></p>
			<p class="license"><?php echo JText::_('SHADOW BOX LICENSE');?></p>
			<p><a href="http://mjijackson.com/shadowbox/" target="_blank">Shadowbox.js</a> by <a target="_blank" href="http://www.mjijackson.com">Michael J. I. Jackson</a><br />
			<a target="_blank" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-Noncommercial-Share Alike</a></p>
			

			
			<p><strong><?php echo JText::_('HIGHSLIDE LICENSE HEAD');?></strong></p>
			<p class="license"><?php echo JText::_('HIGHSLIDE LICENSE');?></p>
			<p><a href="http://highslide.com/" target="_blank">Highslide JS</a> by <a target="_blank" href="http://highslide.com/">Torstein Hønsi</a><br />
			<a target="_blank" href="http://creativecommons.org/licenses/by-nc/2.5/">Creative Commons Attribution-NonCommercial 2.5  License</a></p>
			
			<p>Google™, Google Maps™, Google Picasa™ and YouTube Broadcast Yourself™ are registered trademarks of Google Inc.</p>
			
			<div id="pg-update"><a href="http://www.phoca.cz/version/index.php?phocagallery=<?php echo $this->version ;?>" target="_blank"><?php echo JText::_('Check for update'); ?></a></div>
			
			
			</div>
		</td>
	</tr>
</table>

<input type="hidden" name="option" value="com_phocagallery" />
<input type="hidden" name="view" value="phocagallerycp" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>