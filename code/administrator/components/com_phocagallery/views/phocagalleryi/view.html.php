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
defined( '_JEXEC' ) or die();
jimport( 'joomla.client.helper' );
jimport( 'joomla.application.component.view' );
jimport( 'joomla.html.pane' );

class PhocaGalleryCpViewPhocagalleryI extends JView
{
	function display($tpl = null) {
		global $mainframe;

		$document	= &JFactory::getDocument();
		$params 	= &JComponentHelper::getParams( 'com_phocagallery' );
		
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );

		$document->addCustomTag("<!--[if lt IE 8]>\n<link rel=\"stylesheet\" href=\"../administrator/components/com_phocagallery/assets/phocagalleryieall.css\" type=\"text/css\" />\n<![endif]-->");
		
		/*$tmpl['large_image_width']	= $params->get( 'large_image_width', 640 );
		$tmpl['large_image_height']	= $params->get( 'large_image_height', 480 );
		$tmpl['javaresizewidth'] 	= $params->get( 'java_resize_width', -1 );
		$tmpl['javaresizeheight'] 	= $params->get( 'java_resize_height', -1 );
		$tmpl['tab'] 				= JRequest::getVar('tab', 0, '', 'int');
		
		$tmpl['uploadmaxsize'] 		= $params->get( 'upload_maxsize', 3145728 );
		$tmpl['uploadmaxsizeread'] 	= PhocaGalleryFile::getFileSizeReadable($tmpl['uploadmaxsize']);
		$tmpl['uploadmaxreswidth'] 	= $params->get( 'upload_maxres_width', 3072 );
		$tmpl['uploadmaxresheight'] = $params->get( 'upload_maxres_height', 2304 );
		$tmpl['enablejavaadmin'] 	= $params->get( 'enable_java_admin', 1 );*/
		// Do not allow cache
		JResponse::allowCache(false);

		$path 	= PhocaGalleryPath::getPath();
		
		$this->assign('path_orig_rel', $path->image_abs);
		$this->assignRef('images', $this->get('images'));
		$this->assignRef('folders', $this->get('folders'));
		$this->assignRef('state', $this->get('state'));
		
		/*// Upload Form ------------------------------------
		JHTML::_('behavior.mootools');
		$document->addStyleSheet('components/com_phocagallery/assets/upload/mediamanager.css');

		// Set FTP form
		$ftp = !JClientHelper::hasCredentials('ftp');
		

		//TABS
		$tmpl['displaytabs']	= 0;
		
		// UPLOAD
		$tmpl['currenttab']['upload'] = $tmpl['displaytabs'];
		$tmpl['displaytabs']++;
		
		// JAVA UPLOAD
		if($tmpl['enablejavaadmin']  == 1) {
			$tmpl['currenttab']['javaupload'] = $tmpl['displaytabs'];
			$tmpl['displaytabs']++;	
		}

		// FLASH UPLOAD
		$tmpl['currenttab']['flashupload'] = $tmpl['displaytabs'];

		// Set flash uploader if ftp password and login exists (will be not problems)
		$state			= $this->get('state');
		$refreshSite 	= 'index.php?option=com_phocagallery&view=phocagalleryi&tmpl=component&tab='.$tmpl['displaytabs'].'&folder='.$state->folder;
		if (!$ftp) {
			phocagalleryimport('phocagallery.upload.upload');
			PhocaGalleryFileUpload::uploader('file-upload', array('onAllComplete' => 'function(){ window.location.href="'.$refreshSite.'"; }'));
		}
		$tmpl['displaytabs']++;	
		
		$this->assignRef('session', JFactory::getSession());
		$this->assign('tmpl', $tmpl);
		$this->assign('require_ftp', $ftp);*/

		parent::display($tpl);
		echo JHTML::_('behavior.keepalive');
	}

	function setFolder($index = 0) {
		if (isset($this->folders[$index])) {
			$this->_tmp_folder = &$this->folders[$index];
		} else {
			$this->_tmp_folder = new JObject;
		}
	}

	function setImage($index = 0) {
		if (isset($this->images[$index])) {
			$this->_tmp_img = &$this->images[$index];
		} else {
			$this->_tmp_img = new JObject;
		}
	}
}
?>