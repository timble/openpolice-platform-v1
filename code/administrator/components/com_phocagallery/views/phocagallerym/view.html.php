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
jimport('joomla.client.helper');
jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');
phocagalleryimport('phocagallery.upload.upload');

class PhocaGalleryCpViewPhocaGalleryM extends JView
{
	function display($tpl = null) {
		global $mainframe;
		
		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		parent::display($tpl);
	}

	function _displayForm($tpl) {
		global $mainframe, $option;

		$db		        = &JFactory::getDBO();
		$uri 			= &JFactory::getURI();
		$phocagallery	= &$this->get('Data');//Data from model	
		$document		= &JFactory::getDocument();
		$params 		= &JComponentHelper::getParams( 'com_phocagallery' );
		$lists 			= array();
		$tmpl			= array();
		$params 		= JComponentHelper::getParams('com_phocagallery');
		
		$tmpl['enablethumbcreation']		= $params->get('enable_thumb_creation', 1 );
		$tmpl['enablethumbcreationstatus'] 	= PhocaGalleryRenderAdmin::renderThumbnailCreationStatus((int)$tmpl['enablethumbcreation']);		
		JHTML::stylesheet( 'phocagallery.css', 'administrator/components/com_phocagallery/assets/' );
		
		$tmpl['large_image_width']	= $params->get( 'large_image_width', 640 );
		$tmpl['large_image_height']	= $params->get( 'large_image_height', 480 );
		$tmpl['javaresizewidth'] 	= $params->get( 'java_resize_width', -1 );
		$tmpl['javaresizeheight'] 	= $params->get( 'java_resize_height', -1 );
		$tmpl['javaboxwidth'] 		= $params->get( 'java_box_width', 480 );
		$tmpl['javaboxheight'] 		= $params->get( 'java_box_height', 480 );
		
		$tmpl['uploadmaxsize'] 		= $params->get( 'upload_maxsize', 3145728 );
		$tmpl['uploadmaxsizeread'] 	= PhocaGalleryFile::getFileSizeReadable($tmpl['uploadmaxsize']);
		$tmpl['uploadmaxreswidth'] 	= $params->get( 'upload_maxres_width', 3072 );
		$tmpl['uploadmaxresheight'] = $params->get( 'upload_maxres_height', 2304 );
		$tmpl['enablejavaadmin'] 	= $params->get( 'enable_java_admin', 1 );

		
		$phocagallery->published 	= 1;
		$phocagallery->order 		= 0;
		$phocagallery->catid 		= JRequest::getVar('catid', 0, 'post', 'int' );
		$tmpl['tab'] 				= JRequest::getVar('tab', 0, '', 'int');
		$phocagallery->id			= 0;

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, title AS text'
			. ' FROM #__phocagallery'
			. ' WHERE catid = ' . (int) $phocagallery->catid
			. ' ORDER BY ordering';
		
		$lists['ordering'] 	= JHTML::_('list.specificordering',  $phocagallery, $phocagallery->id, $query, false );
		
		// - - - - - - - - - - - - - - 
		//build the list of categories
		$query = 'SELECT a.title AS text, a.id AS value, a.parent_id as parentid'
		. ' FROM #__phocagallery_categories AS a'
	//	. ' WHERE a.published = 1'
		. ' ORDER BY a.ordering';
		$db->setQuery( $query );
		$phocagallerys = $db->loadObjectList();

		$tree = array();
		$text = '';
		$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($phocagallerys, $tree, 0, $text, -1);
		array_unshift($tree, JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -', 'value', 'text'));
		// list categories
		$lists['catid'] = JHTML::_( 'select.genericlist', $tree, 'catid',  '', 'value', 'text', $phocagallery->catid);
		// - - - - - - - - - - - - - - 
	
		// build the html select list
		$lists['published'] 	= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $phocagallery->published );

		//clean gallery data
		jimport('joomla.filter.output');
		JFilterOutput::objectHTMLSafe( $phocagallery, ENT_QUOTES, 'description' );
		
		$this->assignRef('lists', $lists);
		$this->assignRef('phocagallery', $phocagallery);
		$this->assignRef('button', $button);
		$this->assignRef('request_url',	$uri->toString());

		// - - - - - - - - - - - - -
		/*image manager*/
		JResponse::allowCache(false);// Do not allow cache
		$path 	= PhocaGalleryPath::getPath();
		
		// Upload Form - - - - - - - - - - - -
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
		$refreshSite 	= 'index.php?option=com_phocagallery&view=phocagallerym&layout=form&hidemainmenu=1&tab='.$tmpl['displaytabs'].'&folder='.$state->folder;
		if (!$ftp) {
			phocagalleryimport('phocagallery.upload.upload');
			PhocaGalleryFileUpload::uploader('file-upload', array('onAllComplete' => 'function(){ window.location.href="'.$refreshSite.'"; }'));
		}
		$tmpl['displaytabs']++;	
		
		$this->assignRef('session', JFactory::getSession());
		$this->assign('require_ftp', $ftp);
		$this->assignRef('path_orig_rel', $path->image_abs);
		$this->assignRef('images', $this->get('images'));
		$this->assignRef('folders', $this->get('folders'));
		$this->assignRef('state', $this->get('state'));
		$this->assignRef('tmpl', $tmpl);

		parent::display($tpl);
		$this->_setToolbar();
		echo JHTML::_('behavior.keepalive');
	}
	
	function _setToolbar() {
		JToolBarHelper::title( JText::_( 'Phoca gallery' ).': <small><small>[ ' . JText::_( 'Multiple Add' ).' ]</small></small>' );
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
}
?>
