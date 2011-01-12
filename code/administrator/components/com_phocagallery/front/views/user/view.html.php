<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die();
jimport( 'joomla.client.helper' );
jimport( 'joomla.application.component.view' );
jimport( 'joomla.html.pane' );
phocagalleryimport('phocagallery.file.fileupoload');
phocagalleryimport('phocagallery.avatar.avatar');
phocagalleryimport('phocagallery.render.renderadmin');
//phocagalleryimport('phocagallery.pagination.paginationuser');

class PhocaGalleryViewUser extends JView
{
	var $_context_subcat		= 'com_phocagallery.phocagalleryusersubcat';
	var $_context_image			= 'com_phocagallery.phocagalleryuserimage';

	function display($tpl = null) {
		
		global $mainframe;
		$document			= &JFactory::getDocument();
		$uri 				= &JFactory::getURI();
		$menus				= &JSite::getMenu();
		$menu				= $menus->getActive();
		$params				= &$mainframe->getParams();
		$user 				= &JFactory::getUser();
		$path				= PhocaGalleryPath::getPath();
	
		$tmpl['fi'] 	= PhocaGalleryImage::getFormatIcon();
		$tmpl['pi']		= 'components/com_phocagallery/assets/images/';
		$tmpl['pp']		= 'index.php?option=com_phocagallery&view=user&controller=user';
		$tmpl['pl']		= 'index.php?option=com_user&view=login&return='.base64_encode($tmpl['pp'].'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int'));
		// LIBRARY
		$library 							= &PhocaGalleryLibrary::getLibrary();
		$libraries['pg-css-ie'] 			= $library->getLibrary('pg-css-ie');
		
		// Only registered users
		if ($user->aid == 0) {
			$mainframe->redirect(JRoute::_($tmpl['pl'], false), JText::_("ALERTNOTAUTH"));
			exit;
		}
		
		$tmpl['gallerymetakey'] 		= $params->get( 'gallery_metakey', '' );
		$tmpl['gallerymetadesc'] 		= $params->get( 'gallery_metadesc', '' );
		if ($tmpl['gallerymetakey'] != '') {
			$mainframe->addMetaTag('keywords', $tmpl['gallerymetakey']);
		}
		if ($tmpl['gallerymetadesc'] != '') {
			$mainframe->addMetaTag('description', $tmpl['gallerymetadesc']);
		}
		
		// CSS, JS
		JHTML::stylesheet( 'phocagallery.css', 'components/com_phocagallery/assets/' );
		if ( $libraries['pg-css-ie']->value == 0 ) {
			$document->addCustomTag("<!--[if lt IE 8]>\n<link rel=\"stylesheet\" href=\""
			.JURI::base(true)
			."/components/com_phocagallery/assets/phocagalleryieall.css\" type=\"text/css\" />\n<![endif]-->");
			$library->setLibrary('pg-css-ie', 1);
		}
		
		// = = = = = = = = = = = 
		// PANE
		// = = = = = = = = = = =
		// - - - - - - - - - - 
		// ALL TABS
		// - - - - - - - - - -
		// UCP is disabled (security reasons)
		if ((int)$params->get( 'enable_user_cp', 0 ) == 0) {
			$mainframe->redirect(JURI::base(true), JText::_("User Control Panel is disabled"));
			exit;
		}
		
		$tmpl['tab'] 				= JRequest::getVar('tab', 0, '', 'string');
		$tmpl['maxuploadchar']		= $params->get( 'max_upload_char', 1000 );
		$tmpl['maxcreatecatchar']	= $params->get( 'max_create_cat_char', 1000 );
		$tmpl['dp'] 				= PhocaGalleryRenderInfo::getPhocaIc((int)$params->get( 'display_phoca_info', 1 ));
		$tmpl['showpagetitle'] 		= $params->get( 'show_page_title', 1 );
		$tmpl['enablejava']			= $params->get( 'enable_java', 0 );
		$tmpl['javaresizewidth'] 	= $params->get( 'java_resize_width', -1 );
		$tmpl['javaresizeheight'] 	= $params->get( 'java_resize_height', -1 );
		$tmpl['javaboxwidth'] 		= $params->get( 'java_box_width', 480 );
		$tmpl['javaboxheight'] 		= $params->get( 'java_box_height', 480 );
		$tmpl['enableuploadavatar'] = $params->get( 'enable_upload_avatar', 1 );
		$tmpl['uploadmaxsize'] 		= $params->get( 'upload_maxsize', 3145728 );
		$tmpl['uploadmaxsizeread'] 	= PhocaGalleryFile::getFileSizeReadable($tmpl['uploadmaxsize']);
		$tmpl['uploadmaxreswidth'] 	= $params->get( 'upload_maxres_width', 3072 );
		$tmpl['uploadmaxresheight'] = $params->get( 'upload_maxres_height', 2304 );
		$tmpl['usersubcatcount']	= $params->get( 'user_subcat_count', 5 );
		$tmpl['userimagesmaxspace']	= $params->get( 'user_images_max_size', 20971520 );
		$tmpl['om'] = PhocaGalleryRenderFront::getString();
		$tmpl['iepx']				= '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';
	
		//Subcateogry
		$tmpl['parentid']			= JRequest::getVar('parentcategoryid', 0, 'post', 'int');
		
		$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/comments.js');
		$document->addCustomTag(PhocaGalleryRenderFront::renderOnUploadJS());
		$document->addCustomTag(PhocaGalleryRenderFront::renderDescriptionCreateCatJS((int)$tmpl['maxcreatecatchar']));
		$document->addCustomTag(PhocaGalleryRenderFront::userTabOrdering());// SubCategory + Image
		$document->addCustomTag(PhocaGalleryRenderFront::renderDescriptionCreateSubCatJS((int)$tmpl['maxcreatecatchar']));
		$document->addCustomTag(PhocaGalleryRenderFront::saveOrderUserJS());
		
		$model 						= $this->getModel('user');
		$ownerMainCategory			= $model->getOwnerMainCategory($user->id);
		
		// Upload Form - - - - - - - - - - - - - - - 
		$ftp = !JClientHelper::hasCredentials('ftp');// Set FTP form
		$this->assignRef('session', JFactory::getSession());
		// END Upload Form - - - - - - - - - - - - - 
		
		// EDIT - subcategory, image
		$tmpl['task'] 				= JRequest::getVar( 'task', '', 'get', 'string', 0 );
		$id 						= JRequest::getVar( 'id', '', 'get', 'string', 0 );
		$idAlias					= $id;
		
		
		// - - - - - - - - - - - 
		// USER (AVATAR)
		// - - - - - - - - - - -
		
		$tmpl['user'] 				= $user->name;
		$tmpl['username']			= $user->username;
		$tmpl['useravatarimg']		= JHTML::_('image', $tmpl['pi'].'phoca_thumb_m_no_image.'. $tmpl['fi'], '');
		$tmpl['useravatarapproved'] = 0;
		$userAvatar					= $model->getUserAvatar($user->id);
		
		if ($userAvatar) {
			$pathAvatarAbs	= $path->avatar_abs  .'thumbs'.DS.'phoca_thumb_m_'. $userAvatar->avatar;
			$pathAvatarRel	= $path->avatar_rel . 'thumbs/phoca_thumb_m_'. $userAvatar->avatar;
			if (JFile::exists($pathAvatarAbs)){
				$tmpl['useravatarimg']	= '<img src="'.JURI::base(true) . '/' . $pathAvatarRel.'?imagesid='.md5(uniqid(time())).'" alt="" />';
				$tmpl['useravatarapproved']	= 	$userAvatar->approved;
			}
		}
		
		if ($ownerMainCategory) {
			$tmpl['usermaincategory'] =  $ownerMainCategory->title;
		} else {	
			$tmpl['usermaincategory'] =  JHTML::_('image',$tmpl['pi'].'icon-unpublish.'.$tmpl['fi'], JText::_('PHOCAGALLERY_NOT_CREATED')) 
			.' ('.JText::_('PHOCAGALLERY_NOT_CREATED').')';
		}
		$tmpl['usersubcategory'] 		= $model->getCountUserSubCat($user->id);
		$tmpl['usersubcategoryleft']	= (int)$tmpl['usersubcatcount'] - (int)$tmpl['usersubcategory'];
		if ((int)$tmpl['usersubcategoryleft'] < 0) {$tmpl['usersubcategoryleft'] = 0;}
		$tmpl['userimages']				= $model->getCountUserImage($user->id);
		$tmpl['userimagesspace']		= $model->getSumUserImage($user->id);
		$tmpl['userimagesspaceleft']	= (int)$tmpl['userimagesmaxspace'] - (int)$tmpl['userimagesspace'];
		if ((int)$tmpl['userimagesspaceleft'] < 0) {$tmpl['userimagesspaceleft'] = 0;}
		$tmpl['userimagesspace']		= PhocaGalleryFile::getFileSizeReadable($tmpl['userimagesspace']);
		$tmpl['userimagesspaceleft']	= PhocaGalleryFile::getFileSizeReadable($tmpl['userimagesspaceleft']);
		$tmpl['userimagesmaxspace']		= PhocaGalleryFile::getFileSizeReadable($tmpl['userimagesmaxspace']);
		
		
		// - - - - - - - - - - - 
		// MAIN CATEGORY
		// - - - - - - - - - - -
		$ownerMainCategory 	= $model->getOwnerMainCategory($user->id);
		if (!empty($ownerMainCategory->id)) {
			if ((int)$ownerMainCategory->published == 1) {
				$tmpl['categorycreateoredithead']	= JText::_('PHOCAGALLERY_MAIN_CATEGORY');
				$tmpl['categorycreateoredit']		= JText::_('PHOCAGALLERY_EDIT');		
				$tmpl['categorytitle']				= $ownerMainCategory->title;
				$tmpl['categoryapproved']			= $ownerMainCategory->approved;
				$tmpl['categorydescription']		= $ownerMainCategory->description;
				$tmpl['categorypublished']			= 1;
			} else {
				$tmpl['categorypublished']			= 0;
			}
		} else {
			$tmpl['categorycreateoredithead']	= JText::_('PHOCAGALLERY_MAIN_CATEGORY');
			$tmpl['categorycreateoredit']		= JText::_('PHOCAGALLERY_CREATE');
			$tmpl['categorytitle']				= '';
			$tmpl['categorydescription']		= '';
			$tmpl['categoryapproved']			= '';
			$tmpl['categorypublished']			= -1;
		}
		
		
		// - - - - - - - - - - - 
		// SUBCATEGORY
		// - - - - - - - - - - -

		
		if (!empty($ownerMainCategory->id)) {
		
			// EDIT
			$tmpl['categorysubcatedit'] = $model->getCategory((int)$id, $user->id);
			$tmpl['displaysubcategory'] = 1;
			
			// Get All Data - Subcategories
			$tmpl['subcategoryitems'] 		= $model->getDataSubcat($user->id);
			$tmpl['subcategorytotal'] 		= count($tmpl['subcategoryitems']);
			$model->setTotalSubCat($tmpl['subcategorytotal']);
			$tmpl['subcategorypagination'] 	= $model->getPaginationSubCat($user->id);
			$tmpl['subcategoryitems'] 		= array_slice($tmpl['subcategoryitems'],(int)$tmpl['subcategorypagination']->limitstart, (int)$tmpl['subcategorypagination']->limit);

			$filter_state_subcat	= $mainframe->getUserStateFromRequest( $this->_context_subcat.'.filter_state',	'filter_state_subcat', '',	'word' );
			$filter_catid_subcat	= $mainframe->getUserStateFromRequest( $this->_context_subcat.'.filter_catid',	'filter_catid_subcat',	0, 'int' );
			$filter_order_subcat	= $mainframe->getUserStateFromRequest( $this->_context_subcat.'.filter_order',	'filter_order_subcat',	'a.ordering', 'cmd' );
			$filter_order_Dir_subcat= $mainframe->getUserStateFromRequest( $this->_context_subcat.'.filter_order_Dir',	'filter_order_Dir_subcat',	'',	'word' );
			$search_subcat			= $mainframe->getUserStateFromRequest( $this->_context_subcat.'.search', 'phocagallerysubcatsearch', '',	'string' );
			$search_subcat			= JString::strtolower( $search_subcat );
			
			$categories 				= $model->getCategoryList($user->id);
			if (!empty($categories)) {
				$javascript 	= 'class="inputbox" size="1" onchange="document.phocagallerysubcatform.submit();"';
				$tree = array();
				$text = '';
				$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($categories, $tree,0, $text, -1);
				
				array_unshift($tree, JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -', 'value', 'text'));
				$lists_subcat['catid'] = JHTML::_( 'select.genericlist', $tree, 'filter_catid_subcat',  $javascript , 'value', 'text', $filter_catid_subcat );
			}
			
			$tmpl['parentcategoryid']	= $filter_catid_subcat;

			// state filter
			//$lists['state']		= JHTML::_('grid.state',  $filter_state );
			$state_subcat[] 		= JHTML::_('select.option',  '', '- '. JText::_( 'Select State' ) .' -' );
			$state_subcat[] 		= JHTML::_('select.option',  'P', JText::_( 'Published' ) );
			$state_subcat[] 		= JHTML::_('select.option',  'U', JText::_( 'Unpublished') );
			$lists_subcat['state']	= JHTML::_('select.genericlist',   $state_subcat, 'filter_state_subcat', 'class="inputbox" size="1" onchange="document.phocagallerysubcatform.submit();"', 'value', 'text', $filter_state_subcat );

			// table ordering
			$lists_subcat['order_Dir'] 	= $filter_order_Dir_subcat;
			$lists_subcat['order'] 		= $filter_order_subcat;

			$tmpl['subcategoryordering'] = ($lists_subcat['order'] == 'a.ordering');//Ordering allowed ?
			
			// search filter
			$lists_subcat['search']		= $search_subcat;
		} else {
			$tmpl['displaysubcategory'] = 0;
		}
		
		// - - - - - - - - - - - 
		// IMAGES
		// - - - - - - - - - - -
		if (!empty($ownerMainCategory->id)) {
			$catAccess		= PhocaGalleryAccess::getCategoryAccess((int)$ownerMainCategory->id);
			
			// EDIT
			$tmpl['imageedit'] 			= $model->getImage((int)$id, $user->id);
			
			$tmpl['imageitems'] 		= $model->getDataImage($user->id);
			$tmpl['imagetotal'] 		= $model->getTotalImage($user->id);
			$tmpl['imagepagination'] 	= $model->getPaginationImage($user->id);
			
			$filter_state_image	= $mainframe->getUserStateFromRequest( $this->_context_image.'.filter_state',	'filter_state_image', '',	'word' );
			$filter_catid_image	= $mainframe->getUserStateFromRequest( $this->_context_image.'.filter_catid',	'filter_catid_image',	0, 'int' );
			$filter_order_image	= $mainframe->getUserStateFromRequest( $this->_context_image.'.filter_order',	'filter_order_image',	'a.ordering', 'cmd' );
			$filter_order_Dir_image= $mainframe->getUserStateFromRequest( $this->_context_image.'.filter_order_Dir',	'filter_order_Dir_image',	'',	'word' );
			$search_image			= $mainframe->getUserStateFromRequest( $this->_context_image.'.search', 'phocagalleryimagesearch', '',	'string' );
			$search_image			= JString::strtolower( $search_image );
			
			$categoriesImage 		= $model->getCategoryList($user->id);
			if (!empty($categoriesImage)) {
				$javascript 	= 'class="inputbox" size="1" onchange="document.phocagalleryimageform.submit();"';
				$tree = array();
				$text = '';
				$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($categoriesImage, $tree,0, $text, -1);
				
				array_unshift($tree, JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -', 'value', 'text'));
				$lists_image['catid'] = JHTML::_( 'select.genericlist', $tree, 'filter_catid_image',  $javascript , 'value', 'text', $filter_catid_image );
			}
			
			// state filter
			$state_image[] 		= JHTML::_('select.option',  '', '- '. JText::_( 'Select State' ) .' -' );
			$state_image[] 		= JHTML::_('select.option',  'P', JText::_( 'Published' ) );
			$state_image[] 		= JHTML::_('select.option',  'U', JText::_( 'Unpublished') );
			$lists_image['state']	= JHTML::_('select.genericlist',   $state_image, 'filter_state_image', 'class="inputbox" size="1" onchange="document.phocagalleryimageform.submit();"', 'value', 'text', $filter_state_image );

			// table ordering
			$lists_image['order_Dir'] 	= $filter_order_Dir_image;
			$lists_image['order'] 		= $filter_order_image;

			$tmpl['imageordering']		= ($lists_image['order'] == 'a.ordering');//Ordering allowed ?
			
			// search filter
			$lists_image['search']		= $search_image;
			$tmpl['catidimage']			= $filter_catid_image;
			
			// Upload
			$tmpl['displayupload']	= 0;
			// USER RIGHT - UPLOAD - - - - - - - - - - -
			// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
			$rightDisplayUpload = 0;// default is to null (all users cannot upload)
			if (!empty($catAccess)) {
				$rightDisplayUpload = PhocaGalleryAccess::getUserRight('uploaduserid', $catAccess->uploaduserid, 1, $user->get('aid', 0), $user->get('id', 0), 0);
			}
			if ($rightDisplayUpload == 1) {
				$tmpl['displayupload']	= 1;
				$document->addCustomTag(PhocaGalleryRenderFront::renderDescriptionUploadJS((int)$tmpl['maxuploadchar']));
			}
			// - - - - - - - - - - - - - - - - - - - - - 
			
			// USER RIGHT - ACCESS - - - - - - - - - - - 
			$rightDisplay = 1;//default is set to 1 (all users can see the category)
			if (!empty($catAccess)) {
				$rightDisplay = PhocaGalleryAccess::getUserRight ('accessuserid', $catAccess->accessuserid, 0, $user->get('aid', 0), $user->get('id', 0), 1);
			}
			if ($rightDisplay == 0) {
				
				$mainframe->redirect(JRoute::_($tmpl['pl'], false), JText::_("ALERTNOTAUTH"));
				exit;
			}		
			// - - - - - - - - - - - - - - - - - - - - - 
		} else {
			$tmpl['displayupload'] = 0;
		}

		$tmpl['usertab'] 			= 1;
		$tmpl['createcategory'] 	= 1;
		$tmpl['createsubcategory'] 	= 1;
		$tmpl['images'] 			= 1;
		
		// Tabs
		$displayTabs	= 0;
		
		if ((int)$tmpl['usertab'] == 0) {
			$currentTab['user'] = -1;
		} else {
			$currentTab['user'] = $displayTabs;
			$displayTabs++;	
		}
		
		if ((int)$tmpl['createcategory'] == 0) {
			$currentTab['createcategory'] = -1;
		} else {
			$currentTab['createcategory'] = $displayTabs;
			$displayTabs++;	
		}
		
		if ((int)$tmpl['createsubcategory'] == 0) {
			$currentTab['createsubcategory'] = -1;
		} else {
			$currentTab['createsubcategory'] = $displayTabs;
			$displayTabs++;	
		}
		
		
		if ((int)$tmpl['displayupload'] == 0) {
			$currentTab['images'] = -1;
		}else {
			$currentTab['images'] = $displayTabs;
			$displayTabs++;	
		}
	
		$tmpl['displaytabs']	= $displayTabs;
		$tmpl['currenttab']		= $currentTab;

		
		// ACTION
		$tmpl['action']	= $uri->toString();
		// SEF problem
		$isThereQM = false;
		$isThereQM = preg_match("/\?/i", $tmpl['action']);
		if ($isThereQM) {
			$amp = '&amp;';
		} else {
			$amp = '?';
		}
		$tmpl['actionamp']	=	$tmpl['action'] . $amp;
		$tmpl['istheretab'] = false;
		$tmpl['istheretab'] = preg_match("/tab=/i", $tmpl['action']);
		
		if (!empty($ownerMainCategory->id)) {
			$tmpl['ps']	= '&tab='. $tmpl['currenttab']['createsubcategory']
					. '&limitstartsubcat='.$tmpl['subcategorypagination']->limitstart
					. '&limitstartimage='.$tmpl['imagepagination']->limitstart;
		} else {
			$tmpl['ps']	= '&tab='. $tmpl['currenttab']['createsubcategory'];
		}
		
		if (!empty($ownerMainCategory->id)) {
			$tmpl['psi']	= '&tab='. $tmpl['currenttab']['images']
					. '&limitstartsubcat='.$tmpl['subcategorypagination']->limitstart
					. '&limitstartimage='.$tmpl['imagepagination']->limitstart;
		} else {
			$tmpl['psi']	= '&tab='. $tmpl['currenttab']['images'];
		}
		
		// ASIGN
		$this->assignRef( 'listssubcat',	$lists_subcat);
		$this->assignRef( 'listsimage',		$lists_image);
		$this->assignRef( 'tmpl', $tmpl);
		$this->assignRef( 'params', $params);
		$this->assignRef( 'session', JFactory::getSession());
		parent::display($tpl);
	}
}
?>
