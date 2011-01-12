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
		</td>
	</tr>
</table>

<input type="hidden" name="option" value="com_phocagallery" />
<input type="hidden" name="view" value="phocagallerycp" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>