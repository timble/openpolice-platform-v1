<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.folder' );

function com_install() {
	
	$folder[0][0]	=	'images' . DS . 'phocagallery' . DS ;
	$folder[0][1]	= 	JPATH_ROOT . DS .  $folder[0][0];
	$folder[1][0]	=	'images' . DS . 'phocagallery' . DS . 'avatars' . DS;
	$folder[1][1]	= 	JPATH_ROOT . DS .  $folder[1][0];
	
	$message = '';
	$error	 = array();
	foreach ($folder as $key => $value)
	{
		if (!JFolder::exists( $value[1]))
		{
			if (JFolder::create( $value[1], 0755 ))
			{
				@JFile::write($value[1].DS."index.html", "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>");
			//	@JFile::write($value[1].DS.".htaccess", "deny from all");
				$message .= '<p><b><span style="color:#009933">Folder</span> ' . $value[0] 
						   .' <span style="color:#009933">created!</span></b></p>';
				$error[] = 0;
			}	 
			else
			{
				$message .= '<p><b><span style="color:#CC0033">Folder</span> ' . $value[0]
						   .' <span style="color:#CC0033">creation failed!</span></b> Please create it manually.</p>';
				$error[] = 1;
			}
		}
		else//Folder exist
		{
			$message .= '<p><b><span style="color:#009933">Folder</span> ' . $value[0] 
						   .' <span style="color:#009933">exists!</span></b></p>';
			$error[] = 0;
		}
	}
	
	$message .= '<p>Please select if you want to Install or Upgrade Phoca Gallery component. Click Install for new Phoca Gallery installation. If you click on Install and some previous Phoca Gallery version is installed on your system, all Phoca Gallery data stored in database will be lost. If you click on Uprade, previous Phoca Gallery data stored in database will be not removed. Disable Debug System parameter if enabled before installing or upgrading.</p>';
	

	?>
	<div style="padding:20px;border:1px solid #b36b00;background:#fff">
		<a style="text-decoration:underline" href="http://www.phoca.cz/" target="_blank"><?php
			echo  JHTML::_('image.site', 'icon-phoca-logo.png', 'components/com_phocagallery/assets/images/', NULL, NULL, 'Phoca.cz');
		?></a>
		<div style="position:relative;float:right;">
			<?php echo  JHTML::_('image.site', 'logo-phoca.png', 'components/com_phocagallery/assets/images/', NULL, NULL, 'Phoca.cz');?>
		</div>
		<p>&nbsp;</p>
		<?php echo $message; ?>
		<div style="clear:both">&nbsp;</div>
		<div style="text-align:center"><center><table border="0" cellpadding="20" cellspacing="20">
			<tr>
				<td align="center" valign="middle">
					<a href="index.php?option=com_phocagallery&amp;controller=phocagalleryinstall&amp;task=install"><?php
					echo JHTML::_('image.site',  'install.png', '/components/com_phocagallery/assets/images/', NULL, NULL, 'Install' );
					?></a>
				</td>
				
				<td align="center" valign="middle">
					<a href="index.php?option=com_phocagallery&amp;controller=phocagalleryinstall&amp;task=upgrade"><?php
					echo JHTML::_('image.site',  'upgrade.png', '/components/com_phocagallery/assets/images/', NULL, NULL, 'Upgrade' );
					?></a>
				</td>
			</tr>
		</table></center></div>
		
		<p>&nbsp;</p><p>&nbsp;</p>
		<p>
		<a href="http://www.phoca.cz/phocagallery/" target="_blank">Phoca Gallery Main Site</a><br />
		<a href="http://www.phoca.cz/documentation/" target="_blank">Phoca Gallery User Manual</a><br />
		<a href="http://www.phoca.cz/forum/" target="_blank">Phoca Gallery Forum</a><br />
		</p>
		
		<p>&nbsp;</p>
		<p><center><a style="text-decoration:underline" href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></center></p>		
<?php	
}
?>