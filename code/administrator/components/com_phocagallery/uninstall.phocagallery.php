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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.filesystem.folder' );

function com_uninstall() {
	echo '<p><b><span style="color:#009933">Folder</span> ' . 'images' . DS . 'phocagallery' . DS .' <span style="color:#009933">still exists!</span></b> Please delete it manually, if you want.</p>';
}
?>