<?php
/**
* @package      JCE Media Manager
* @copyright 	Copyright (C) 2005 - 2010 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license 		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see licence.txt
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JEXEC' ) or die('ERROR_403');
	foreach (array('shockwave', 'divx', 'flash', 'quicktime', 'real', 'windowsmedia', 'audio', 'video', 'mediaplayer', 'aggregator') as $tpl) {
		echo $this->loadTemplate($tpl);
	}
?>