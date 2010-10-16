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
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view');

class PhocaGalleryCpViewPhocagalleryF extends JView
{
	function display($tpl = null) {
		global $mainframe;

		$params = &JComponentHelper::getParams( 'com_phocagallery' );
		
		// Do not allow cache
		JResponse::allowCache(false);
		
		$document		= & JFactory::getDocument();
		$document->addStyleSheet('../administrator/components/com_phocagallery/assets/phocagallery.css');
		$document->addStyleSheet('../administrator/templates/system/css/system.css');

		$document->addCustomTag("<!--[if lt IE 8]>\n<link rel=\"stylesheet\" href=\"../administrator/components/com_phocagallery/assets/phocagalleryieall.css\" type=\"text/css\" />\n<![endif]-->");

		$path 			= PhocaGalleryPath::getPath();
		$this->assignRef('session', JFactory::getSession());
		$this->assign('path_orig_rel', $path->image_rel);
		$this->assignRef('folders', $this->get('folders'));
		$this->assignRef('state', $this->get('state'));


		parent::display($tpl);
	}

	function setFolder($index = 0) {
		if (isset($this->folders[$index])) {
			$this->_tmp_folder = &$this->folders[$index];
		} else {
			$this->_tmp_folder = new JObject;
		}
	}
}
?>