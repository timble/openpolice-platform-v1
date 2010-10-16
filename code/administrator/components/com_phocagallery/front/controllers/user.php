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
defined('_JEXEC') or die();
phocagalleryimport('phocagallery.access.access');
jimport( 'joomla.filesystem.file' );
phocagalleryimport('phocagallery.file.file');
phocagalleryimport('phocagallery.file.fileupload');
phocagalleryimport('phocagallery.file.filefolder');
phocagalleryimport('phocagallery.file.filethumbnail');
phocagalleryimport('phocagallery.comment.comment');
phocagalleryimport('phocagallery.comment.commentcategory');
phocagalleryimport('phocagallery.upload.uploadfront');
class PhocaGalleryControllerUser extends PhocaGalleryController
{
	var $_user 				= null;
	var $_view 				= 'user';
	var $_tab				= 0;
	var $_limitstartsubcat 	= 0;
	var $_limitstartimage	= 0;
	var $_itemid			= 0;
	var $_loginurl;
	var $_loginstr;
	var $_url;
	
	function __construct() {
		parent::__construct();

		global $mainframe;
		$paramsC = JComponentHelper::getParams('com_phocagallery') ;		
		// UCP is disabled (security reasons)
		$enable_user_cp	= $paramsC->get( 'enable_user_cp', 0 );
		if ($enable_user_cp == 0) {
			$mainframe->redirect( JURI::base(true), JText::_("User Control Panel is disabled") );
			exit;
		}
		
		// Category
		$this->registerTask( 'createcategory', 'createcategory' );//
		
		// Subcategory
		$this->registerTask( 'createsubcategory', 'createsubcategory' );//
		$this->registerTask( 'editsubcategory', 'editsubcategory' );//
		
		$this->registerTask( 'publishsubcat', 'publishsubcat' );//
		$this->registerTask( 'unpublishsubcat', 'unpublishsubcat' );//
		$this->registerTask( 'orderupsubcat', 'ordersubcat' );//
		$this->registerTask( 'orderdownsubcat', 'ordersubcat' );//
		$this->registerTask( 'saveordersubcat', 'saveordersubcat' );//
		$this->registerTask( 'removesubcat', 'removesubcat' );//
		
		// Image
		$this->registerTask( 'upload', 'upload' );//
		$this->registerTask( 'javaupload', 'javaupload' );//
		$this->registerTask( 'uploadavatar', 'uploadavatar' );//
		$this->registerTask( 'editimage', 'editimage' );
		
		$this->registerTask( 'publishimage', 'publishimage' );//
		$this->registerTask( 'unpublishimage', 'unpublishimage' );//
		$this->registerTask( 'orderupimage', 'orderimage' );//
		$this->registerTask( 'orderdownimage', 'orderimage' );//
		$this->registerTask( 'saveorderimage', 'saveorderimage' );//
		$this->registerTask( 'removeimage', 'removeimage' );//
		
		// Get variables
		$this->_user 				=& JFactory::getUser();
		$this->_view 				= JRequest::getVar( 'view', '', '', 'string', JREQUEST_NOTRIM  );
		$this->_tab 				= JRequest::getVar( 'tab', '', '', 'int', JREQUEST_NOTRIM  );
		$this->_limitstartsubcat 	= JRequest::getVar( 'limitstartsubcat', '', '', 'int', JREQUEST_NOTRIM  );
		$this->_limitstartimage 	= JRequest::getVar( 'limitstartimage', '', '', 'int', JREQUEST_NOTRIM  );
		$this->_itemid				= JRequest::getVar( 'Itemid', 0, '', 'int' );
		
		$this->_loginurl			= JRoute::_('index.php?option=com_user&view=login', false);
		$this->_loginstr			= JText::_("NOT AUTHORISED TO DO ACTION");
		$this->_url					= 'index.php?option=com_phocagallery&view=user&tab='.$this->_tab.'&Itemid='. $this->_itemid;
		
	}

	function display() {
		if ( ! JRequest::getCmd( 'view' ) ) {
			JRequest::setVar('view', 'user' );
		}
		parent::display();
    }
	
	/*
	 * Handle limitstart (images/subcategories - we are in tab view so both need to be solved at once)
	 */
	function getLimitStartUrl($id = 0, $type = 'subcat', $catid = 0) {
		
		$model 					= $this->getModel('user');
		$limitStartUrl			= new JObject();
		$limitStartUrl->subcat	= '&limitstartsubcat='.$this->_limitstartsubcat;
		$limitStartUrl->image	= '&limitstartsubcat='.$this->_limitstartimage;
		
		if ((int)$id > 0 || (int)$catid > 0) {
			if ($type == 'subcat') {
				$countItem 	= $model->getCountItemSubCat((int)$id, $this->_user->id, (int)$catid);	
				
				if ($countItem && (int)$countItem[0] == (int)$this->_limitstartsubcat) {
					$this->_limitstartsubcat = 0;
				}
			} else if ($type == 'image') {
				$countItem 	= $model->getCountItemImage((int)$id, $this->_user->id,(int)$catid);
				if ($countItem && (int)$countItem[0] == (int)$this->_limitstartimage) {
					$this->_limitstartimage = 0;
				}
			}
		}
		
		if ((int)$this->_limitstartsubcat > 0) {
			$limitStartUrl->subcat	= '&limitstartsubcat='.$this->_limitstartsubcat;	
		} else {
			$limitStartUrl->subcat = '';
		}
		if ((int)$this->_limitstartimage > 0) {
			$limitStartUrl->image	= '&limitstartimage='.$this->_limitstartimage;	
		} else {
			$limitStartUrl->image = '';
		}
	 
		return $limitStartUrl;
	}
	
	// = = = = = = = = = =  
	//
	// CATEGORY
	//
	// = = = = = = = = = =
	function createcategory() {
	
		global $mainframe;
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$task 						= JRequest::getVar( 'task', '', 'post', 'string', 0 );
		$post['title']				= JRequest::getVar( 'categoryname', '', 'post', 'string', 0  );
		$post['description']		= JRequest::getVar( 'phocagallerycreatecatdescription', '', 'post', 'string', 0  );
		$paramsC 					= JComponentHelper::getParams('com_phocagallery') ;
		$maxCreateCatChar			= $paramsC->get( 'max_create_cat_char', 1000 );
		$enableUserCatApprove 		= (int)$paramsC->get( 'enable_usercat_approve', 0 );
		$post['description']		= substr($post['description'], 0, (int)$maxCreateCatChar);
		$post['alias'] 				= PhocaGalleryText::getAliasName($post['title']);
		$post['approved']			= 0;
		if ($enableUserCatApprove == 0) {
			$post['approved']	= 1;
		}
		
		// user is logged in
		if ($this->_user->aid > 0 && $this->_user->id > 0) {
			if ($post['title'] != '') {
				$model 				= $this->getModel('user');
				// Owner can have only one main category - check it 
				$ownerMainCategory	= $model->getOwnerMainCategory($this->_user->id);
				// User has no category, he (she) can create one
				if (!$ownerMainCategory) {
					// - - - - - 
					// NEW
					// - - - - - 
					$msg = '';
					// Create an user folder on the server 
					$this->_userFolder	= PhocaGalleryText::getAliasName($this->_user->username) .'-'.substr($post['alias'], 0, 10) .'-'. substr(md5(uniqid(time())), 0, 4);
					$errorMsg	= '';
					$createdFolder = PhocaGalleryFileFolder::createFolder($this->_userFolder, $errorMsg);
					if ($errorMsg != '') {
						$msg = JText::_('Error Folder Creating'). ': ' . JText::_($errorMsg);
					}
					// -----------------------------------
					
					// Folder Created, all right
					if ($msg == '') {
						// Set default values
						$post['access'] 		= 0;
						//$post['access'] 		= 1;
						$post['parent_id'] 		= 0;
						$post['image_position']	= 'left';
						$post['published']		= 1;
						$post['accessuserid']	= '-1';
						$post['uploaduserid']	= $this->_user->id;
						$post['deleteuserid']	= $this->_user->id;
						$post['userfolder']		= $this->_userFolder;
						$post['owner_id']		= $this->_user->id;

						// Create new category
						$id	= $model->store($post);
						if ($id && $id > 0) {
							$msg = JText::_( 'PHOCAGALLERY_CATEGORY_SAVED' );
							
							$errUploadMsg = '';
							$succeeded = '';
							PhocaGalleryControllerUser::saveUser('', $succeeded, $errUploadMsg);
							//$msg .= '<br />' . $errUploadMsg;
							
						} else {
							$msg = JText::_( 'PHOCAGALLERY_CATEGORY_SAVE_ERROR' );
						}
					}
				} else {
					if ($post['title'] != '') {
						// - - - - - 
						// EDIT
						// - - - - -
						$post['id']	= $ownerMainCategory->id;
						$id			= $model->store($post);
						if ($id && $id > 0) {
							$msg = JText::_( 'PHOCAGALLERY_CATEGORY_EDITED' );
						} else {
							$msg = JText::_( 'PHOCAGALLERY_CATEGORY_EDIT_ERROR' );
						}
					}
				}
			} else {
				$msg = JText::_( 'PHOCAGALLERY_CATEGORY_CREATE_ERROR_TITLE' );
			}
			$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
		} else {
			global $mainframe;
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
	}
	
	 
	// = = = = = = = = = = 
	//
	// SUBCATEGORY
	//
	// = = = = = = = = = =
	function publishsubcat() {
		$id 				= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$model 				= $this->getModel('user');
		$isOwnerCategory 	= $model->isOwnerCategory((int)$this->_user->id, (int)$id);
		
		if ($isOwnerCategory) {
			if(!$model->publishsubcat((int)$id, 1)) {
			$msg = JText::_('PHOCAGALLERY_CATEGORY_PUBLISH_ERROR');
			} else {
			$msg = JText::_('PHOCAGALLERY_CATEGORY_PUBLISHED');
			} 
		} else {
			global $mainframe;
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		$limitStartUrl = $this->getLimitStartUrl((int)$id, 'subcat');
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
	}
	
	function unpublishsubcat() {
		$id 				= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$model 				= $this->getModel('user');
		$isOwnerCategory 	= $model->isOwnerCategory((int)$this->_user->id, (int)$id);
		
		if ($isOwnerCategory) {
			if(!$model->publishsubcat((int)$id, 0)) {
			$msg = JText::_('PHOCAGALLERY_CATEGORY_UNPUBLISH_ERROR');
			} else {
			$msg = JText::_('PHOCAGALLERY_CATEGORY_UNPUBLISHED');
			} 
		} else {
			global $mainframe;
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		$limitStartUrl = $this->getLimitStartUrl((int)$id, 'subcat');
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
	}

	function ordersubcat() {
		$id 				= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$task 				= JRequest::getVar( 'task', '', 'get', 'string', 0 );
		$model 				= $this->getModel( 'user' );
		$isOwnerCategory 	= $model->isOwnerCategory((int)$this->_user->id, (int)$id);
		
		if ($isOwnerCategory) {
			if ($task == 'orderupsubcat') {
				$model->movesubcat(-1, (int)$id);
			} else if ($task == 'orderdownsubcat') {
				$model->movesubcat(1, (int)$id);
			}
		} else {
			global $mainframe;
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		$limitStartUrl = $this->getLimitStartUrl((int)$id, 'subcat');
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false) );
	}
	
	function saveordersubcat() {
		$cid 			= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 			= JRequest::getVar( 'order', array(), 'post', 'array' );
		$model 			= $this->getModel( 'user' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model->saveordersubcat($cid, $order);
		$msg = JText::_( 'New ordering saved' );
		
		$limitStartUrl = $this->getLimitStartUrl(0, 'subcat');
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
	}

	function removesubcat() {	
		$id 				= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$model 				= $this->getModel('user');
		$isOwnerCategory 	= $model->isOwnerCategory((int)$this->_user->id, (int)$id);
		$isOwnerAndParentCategory 	= $model->isOwnerCategorySubCat((int)$this->_user->id, (int)$id);
		$errorMsg = '';
		
		if ($isOwnerCategory) {
			if(!$model->delete((int)$id, $errorMsg)) {
			$msg = JText::_('PHOCAGALLERY_CATEGORY_DELETE_ERROR');
			} else {
			$msg = JText::_('PHOCAGALLERY_CATEGORY_DELETED');
			} 
		} else {
			global $mainframe;
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		if ($errorMsg != '') {
			$msg .= '<br />'.$errorMsg;
		}
		
		
		$limitStartUrl = $this->getLimitStartUrl(0, 'subcat', (int)$isOwnerAndParentCategory );
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
	}
	
	function createsubcategory() {

		JRequest::checkToken() or jexit( 'Invalid Token' );
		$task 						= JRequest::getVar( 'task', '', 'post', 'string', 0 );
		$post['title']				= JRequest::getVar( 'subcategoryname', '', 'post', 'string', 0  );
		$post['description']		= JRequest::getVar( 'phocagallerycreatesubcatdescription', '', 'post', 'string', 0  );
		$post['parent_id']			= JRequest::getVar( 'parentcategoryid', 0, 'post', 'int' );
		$paramsC 					= JComponentHelper::getParams('com_phocagallery') ;
		$maxCreateCatChar			= $paramsC->get( 'max_create_cat_char', 1000 );
		$enableUserSubCatApprove	= $paramsC->get( 'enable_usersubcat_approve', 0 );
		$post['description']		= substr($post['description'], 0, (int)$maxCreateCatChar);
		$post['alias'] 				= PhocaGalleryText::getAliasName($post['title']);
		$model 						= $this->getModel('user');
		$userSubCatCount			= $paramsC->get( 'user_subcat_count', 5 );
		$post['approved']			= 0;
		if ($enableUserSubCatApprove == 0) {
			$post['approved']	= 1;
		}
		
		global $mainframe;
		// USER IS NOT LOGGED
		if ($this->_user->aid < 1 && $this->_user->id < 1) {
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		
		
		if ((int)$post['parent_id'] < 1) {
			$msg = JText::_( 'PHOCAGALLERY_PARENT_CATEGORY_NOT_SELECTED' );
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
			exit;
		}
		
		$isOwnerCategory 			= $model->isOwnerCategory($this->_user->id, (int)$post['parent_id']);
		$limitStartUrl 				= $this->getLimitStartUrl(0, 'subcat', (int)$isOwnerCategory );
		if(!$isOwnerCategory) {
			$msg = JText::_( 'PHOCAGALLERY_PARENT_CATEGORY_NOT_ASSIGNED_TO_USER' );
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
			exit;
		}
		
		$subCatCount = $model->getCountUserSubCat($this->_user->id);
		$subCatCount = (int)$subCatCount + 1;
		if ((int)$subCatCount > (int)$userSubCatCount) {
			$msg = JText::_( 'PHOCAGALLERY_MAX_SUBCAT_COUNT_REACHED' );
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
			exit;
		}
		
		$ownerMainCategory	= $model->getOwnerMainCategory($this->_user->id);
		if (!$ownerMainCategory) {
			$msg = JText::_('PHOCAGALLERY_MAIN_CATEGORY_NOT_CREATED');
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
		}

		if ($post['title'] != '') {
			$post['access'] 		= 0;
			$post['image_position']	= 'left';
			$post['published']		= 1;
			$post['accessuserid']	= '-1';
			$post['uploaduserid']	= $this->_user->id;
			$post['deleteuserid']	= $this->_user->id;
			$post['userfolder']		= $ownerMainCategory->userfolder;
			$post['owner_id']		= $this->_user->id;
			$id						= $model->store($post);
			if ($id && $id > 0) {
				$msg = JText::_( 'PHOCAGALLERY_CATEGORY_CREATED' );
			} else {
				$msg = JText::_( 'PHOCAGALLERY_CATEGORY_ERROR_CREATE' );
			}
		} else {
			$msg = JText::_( 'PHOCAGALLERY_CATEGORY_CREATE_ERROR_TITLE' );
		}	
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
	}
	
	function editsubcategory() {

		JRequest::checkToken() or jexit( 'Invalid Token' );
		$task 						= JRequest::getVar( 'task', '', 'post', 'string', 0 );
		$post['title']				= JRequest::getVar( 'subcategoryname', '', 'post', 'string', 0  );
		$post['description']		= JRequest::getVar( 'phocagallerycreatesubcatdescription', '', 'post', 'string', 0  );
		//$post['parent_id']			= JRequest::getVar( 'parentcategoryid', 0, 'post', 'int' );
		$post['id']					= JRequest::getVar( 'id', 0, 'post', 'int' );
		$paramsC 					= JComponentHelper::getParams('com_phocagallery') ;
		$maxCreateCatChar			= $paramsC->get( 'max_create_cat_char', 1000 );
		$post['description']		= substr($post['description'], 0, (int)$maxCreateCatChar);
		$post['alias'] 				= PhocaGalleryText::getAliasName($post['title']);
		$model 						= $this->getModel('user');
		
		
		global $mainframe;
		// USER IS NOT LOGGED
		if ($this->_user->aid < 1 && $this->_user->id < 1) {
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		$isOwnerCategory = $model->isOwnerCategory($this->_user->id, (int)$post['id']);
		if(!$isOwnerCategory) {
			$msg = JText::_( 'PHOCAGALLERY_PARENT_CATEGORY_NOT_ASSIGNED_TO_USER' );
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
			exit;
		}
		
		if ((int)$post['id'] < 1) {
			$msg = JText::_( 'PHOCAGALLERY_PARENT_CATEGORY_NOT_SELECTED' );
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
			exit;
		}
		
		$ownerMainCategory	= $model->getOwnerMainCategory($this->_user->id);
		if (!$ownerMainCategory) {
			$msg = JText::_('PHOCAGALLERY_MAIN_CATEGORY_NOT_CREATED');
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
		}

		if ($post['title'] != '') {

			$id	= $model->store($post);
			if ($id && $id > 0) {
				$msg = JText::_( 'PHOCAGALLERY_CATEGORY_EDITED' );
			} else {
				$msg = JText::_( 'PHOCAGALLERY_CATEGORY_EDIT_ERROR' );
			}
		} else {
			$msg = JText::_( 'PHOCAGALLERY_CATEGORY_EDIT_ERROR_TITLE' );
		}	
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
	}
	
	// = = = = = = = = = = 
	//
	// USER - Upload Avatar
	//
	// = = = = = = = = = =

	function uploadavatar() {			    
		global $mainframe;		
		$errUploadMsg	= '';	
	    $redirectUrl 	= '';
		$fileArray 		= JRequest::getVar( 'Filedata', '', 'files', 'array' );
		$this->_singleFileUploadAvatar($errUploadMsg, $fileArray, $redirectUrl);
		$mainframe->redirect($redirectUrl, $errUploadMsg);
		exit;	
	}
	
	function _singleFileUploadAvatar(&$errUploadMsg, $file, &$redirectUrl) {
		global $mainframe;
		JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );
		jimport('joomla.client.helper');
		$ftp 		= &JClientHelper::setCredentialsFromRequest('ftp');
		$path		= PhocaGalleryPath::getPath();
		$format		= JRequest::getVar( 'format', 'html', '', 'cmd');
		$return		= JRequest::getVar( 'return-url', null, 'post', 'base64' );
		$viewBack	= JRequest::getVar( 'viewback', '', '', '' );
		$view 		= JRequest::getVar( 'view', '', 'get', '', JREQUEST_NOTRIM  );
		$paramsC 	= JComponentHelper::getParams('com_phocagallery') ;
		
		$limitStartUrl 	= $this->getLimitStartUrl(0, 'subcat');
		$return			= JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false);
		
		$enableUploadAvatar = (int)$paramsC->get( 'enable_upload_avatar', 1 );
		if ($enableUploadAvatar != 1) {
			$errUploadMsg = JText::_('PHOCAGALLERY_NOT_ABLE_UPLOAD_AVATAR');
			$redirectUrl = $return;
			return false;
		}
		
		
		if (isset($file['name'])) {
			$fileAvatar = md5(uniqid(time())) . '.' . JFile::getExt($file['name']);
			$filepath 	= JPath::clean($path->avatar_abs . DS . $fileAvatar);

			if (!PhocaGalleryFileUpload::canUpload( $file, $errUploadMsg )) {
				if ($errUploadMsg == 'WARNFILETOOLARGE') {
						$errUploadMsg 	= JText::_($errUploadMsg) . ' ('.PhocaGalleryFile::getFileSizeReadable($file['size']).')';
					} else if ($errUploadMsg == 'WARNFILETOOLARGERESOLUTION') {
						$imgSize		= PhocaGalleryImage::getImageSize($file['tmp_name']);
						$errUploadMsg 	= JText::_($errUploadMsg) . ' ('.(int)$imgSize[0].' x '.(int)$imgSize[1].' px)';
					} else {
						$errUploadMsg 	= JText::_($errUploadMsg);
					}
					$redirectUrl 	= $return;
					return false;
			}

			if (!JFile::upload($file['tmp_name'], $filepath)) {
				$errUploadMsg = JText::_("Unable to upload file");
				$redirectUrl = $return;
				return false;
			} else {
				$redirectUrl 	= $return;
				//Create thumbnail small, medium, large (Delete previous before)
				PhocaGalleryFileThumbnail::deleteFileThumbnail ('avatars/'.$fileAvatar, 1,1,1);
				$returnFrontMessage = PhocaGalleryFileThumbnail::getOrCreateThumbnail('avatars/'.$fileAvatar, $return, 1, 1, 1, 1);
				if ($returnFrontMessage != 'Success') {
					$errUploadMsg = JText::_('PHOCAGALLERY_THUMBNAIL_AVATAR_NOT_CREATED');
					return false;
				}
				
				// Saving file name into database with relative path
				$succeeded 		= false;
				PhocaGalleryControllerUser::saveUser($fileAvatar, $succeeded, $errUploadMsg);
				$redirectUrl 	= $return;
				return $succeeded;
			}
		} else {				
			$errUploadMsg = JText::_("WARNFILETYPE");	
			$redirectUrl = $return;				
			return false;
		}
		return false;		
	}
	
	function saveUser($fileAvatar, &$succeeded, &$errSaveMsg) {
		
		$paramsC 	= JComponentHelper::getParams('com_phocagallery') ;
		
		$post['avatar']			= $fileAvatar;
		$post['userid']			= (int)$this->_user->id;
		$post['published']		= 1;
		$post['approved']		= 0;
		$enableAvatarApprove = (int)$paramsC->get( 'enable_avatar_approve', 0 );
		if ($enableAvatarApprove == 0) {
			$post['approved']	= 1;
		}

		$model = $this->getModel( 'user' );
		
		$userAvatar = $model->getUserAvatar($post['userid']);
		if($userAvatar) {
			$post['id']				= $userAvatar->id;
			if (isset($userAvatar->avatar) && $userAvatar->avatar != '' && $fileAvatar == '') {
				// No new avatar - set the old one
				$post['avatar']		= $userAvatar->avatar;
			} else if (isset($userAvatar->avatar) && $userAvatar->avatar != '' && $fileAvatar != '') {
				// New avatar loaded - try to delete the old one from harddisc (server)
				$model->removeAvatarFromDisc($userAvatar->avatar);
			}
			$post['published']		= $userAvatar->published;
			$post['approved']		= $userAvatar->approved;
		}
		
		if ($model->storeuser($post)) {
			$succeeded = true;
			$errSaveMsg = JText::_( 'PHOCAGALLERY_AVATAR_SAVED' );
		} else {
			$succeeded = false;
			$errSaveMsg = JText::_( 'PHOCAGALLERY_AVATAR_SAVE_ERROR' );
		}
		
		return $succeeded;
	}
	
	
	// = = = = = = = = = = 
	//
	// IMAGE
	//
	// = = = = = = = = = =
	

	function upload() {			
		global $mainframe;		
		$errUploadMsg	= '';	
	    $redirectUrl 	= '';
		$fileArray 		= JRequest::getVar( 'Filedata', '', 'files', 'array' );
		$this->_singleFileUpload($errUploadMsg, $fileArray, $redirectUrl);
		$mainframe->redirect($redirectUrl, $errUploadMsg);
		exit;	
	}
	
	function javaupload() {			    
		global $mainframe;
		JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );
		$errUploadMsg	= '';
		$redirectUrl 	= '';		

		if (!$this->_realJavaUpload($errUploadMsg, $redirectUrl)	) {		
			exit( 'ERROR: '.$errUploadMsg);		
		} else {		
			exit( 'SUCCESS');
		}
	}
	
	function _realJavaUpload(&$errUploadMsg, &$redirectUrl) {		
		global $mainframe;
		JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );		
		foreach ($_FILES as $file => $fileArray) {
			echo('File key: '. $file . "\n");
			foreach ($fileArray as $item=>$val) {
				echo(' Data received: ' . $item.'=>'.$val . "\n");
			}
			if (!$this->_singleFileUpload($errUploadMsg, $fileArray, $redirectUrl)) {
				$errUploadMsg = JText::_($errUploadMsg);
				return false;
			}
		}
		return true;
	}
	
	function _singleFileUpload(&$errUploadMsg, $file, &$redirectUrl) {
	
		global $mainframe;
		JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );
		jimport('joomla.client.helper');
		$ftp 		=& JClientHelper::setCredentialsFromRequest('ftp');
		$path		= PhocaGalleryPath::getPath();
		$folder		= JRequest::getVar( 'folder', '', '', 'path' );
		$format		= JRequest::getVar( 'format', 'html', '', 'cmd');
		$return		= JRequest::getVar( 'return-url', null, 'post', 'base64' );
		$viewBack	= JRequest::getVar( 'viewback', '', 'post', 'string' );
		$catid 		= JRequest::getVar( 'catid', '', '', 'int'  );
		$paramsC 	= JComponentHelper::getParams('com_phocagallery') ;
		$limitStartUrl 	= $this->getLimitStartUrl(0, 'subcat');
		$return			= JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false);

		
		if ((int)$catid < 1) {
			$errUploadMsg	= JText::_("Please select Category");			
			$redirectUrl	= JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false);
			return false;
		}
		
		// Get user catid, we are not in the category, so we must find the catid
		$model 				= $this->getModel('user');
		$isOwnerCategory 	= $model->isOwnerCategory($this->_user->id, $catid);

		
		if (!$isOwnerCategory) {
			$errUploadMsg	= JText::_("NOT AUTHORISED TO DO ACTION");			
			$redirectUrl	= $this->_loginurl;
			return false;
		}
		
		if ((int)$catid < 1) {
			$errUploadMsg 	= JText::_( 'PHOCAGALLERY_CATEGORY_CREATE_ERROR') . ' '. JText::_('PHOCAGALLERY_CATEGORY_NOT_SELECTED' );
			$redirectUrl	= JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false);
			return false;
		}
		
		// USER RIGHT - UPLOAD - - - - - - - - - - -
		// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
		$rightDisplayUpload	= 0;
		
		$catAccess	= PhocaGalleryAccess::getCategoryAccess((int)$catid);
		if (!empty($catAccess)) {
			$rightDisplayUpload = PhocaGalleryAccess::getUserRight('uploaduserid', $catAccess->uploaduserid, 2, 2, $this->_user->get('id', 0), 0);
		}
		// - - - - - - - - - - - - - - - - - - - - - -	
		// USER RIGHT - FOLDER - - - - - - - - - - - - 		
		$rightFolder = '';
		if (isset($catAccess->userfolder)) {
			$rightFolder = $catAccess->userfolder;
		}
		// - - - - - - - - - - - - - - - - - - - - - -	

		
		
		if ($rightDisplayUpload == 1) {
			if ($rightFolder == '') {
				$errUploadMsg = JText::_("User Folder Not Defined");
				$redirectUrl = $return;
				return false;
			}
			if (!JFolder::exists($path->image_abs . $rightFolder . DS)) {
				$errUploadMsg = JText::_("Defined User Folder Does Not Exist");
				$redirectUrl = $return;
				return false;
			}
		
			// Check the size of all images by users
			$maxUserImageSize 	= (int)$paramsC->get( 'user_images_max_size', 20971520 );
			$allFileSize	= PhocaGalleryUploadFront::getSizeAllOriginalImages($file, $this->_user->id);

			if ($maxUserImageSize > 0 && (int) $allFileSize > $maxUserImageSize) {
				$errUploadMsg = JText::_('PHOCAGALLERY_WARNUSERIMAGESTOOLARGE');	
				$redirectUrl = $return;
				return false;
			}

			// Make the filename safe
			if (isset($file['name'])) {
				$file['name']	= JFile::makeSafe($file['name']);
			}
			
			if (isset($file['name'])) {
				$filepath = JPath::clean($path->image_abs.$rightFolder.DS.$file['name']);
				if (!PhocaGalleryFileUpload::canUpload( $file, $errUploadMsg )) {
				
					if ($errUploadMsg == 'WARNFILETOOLARGE') {
						$errUploadMsg 	= JText::_($errUploadMsg) . ' ('.PhocaGalleryFile::getFileSizeReadable($file['size']).')';
					} else if ($errUploadMsg == 'PHOCAGALLERY_WARNFILETOOLARGERESOLUTION') {
						$imgSize		= PhocaGalleryImage::getImageSize($file['tmp_name']);
						$errUploadMsg 	= JText::_($errUploadMsg) . ' ('.(int)$imgSize[0].' x '.(int)$imgSize[1].' px)';
					} else {
						$errUploadMsg 	= JText::_($errUploadMsg);
					}
					$redirectUrl 	= $return;
					return false;
				}

				if (JFile::exists($filepath)) {
					$errUploadMsg = JText::_("File already exists");
					$redirectUrl = $return;
					return false;
				}

				if (!JFile::upload($file['tmp_name'], $filepath)) {
					$errUploadMsg = JText::_("Unable to upload file");
					$redirectUrl = $return;
					return false;
				} else {
					// Saving file name into database with relative path
					$file['name']	= $rightFolder . '/' . $file['name'];
					$succeeded 		= false;
					PhocaGalleryControllerUser::save((int)$catid, $file['name'], $return, $succeeded, $errUploadMsg, false);
					$redirectUrl 	= $return;
					return $succeeded;
				}
			} else {				
				$errUploadMsg = JText::_("WARNFILETYPE");	
				$redirectUrl = $return;				
				return false;
			}
		} else {			
			$errUploadMsg = JText::_("NOT AUTHORISED TO DO ACTION");			
			$redirectUrl = $this->_loginurl;
			return false;
		}
		return false;
	}
	
	
	function save($catid, $filename, $return, &$succeeded, &$errSaveMsg, $redirect=true) {
		
		global $mainframe;
		
		$post['filename']		= $filename;
		$post['title']			= JRequest::getVar( 'phocagalleryuploadtitle', '', 'post', 'string', 0 );
		$post['description']	= JRequest::getVar( 'phocagalleryuploaddescription', '', 'post', 'string', 0 );
		$post['catid']			= $catid;
		$post['published']		= 1;
		
		$paramsC 				= JComponentHelper::getParams('com_phocagallery') ;
		$maxUploadChar			= $paramsC->get( 'max_upload_char', 1000 );
		$post['description']	= substr($post['description'], 0, (int)$maxUploadChar);
		$enableUserImageApprove = (int)$paramsC->get( 'enable_userimage_approve', 0 );
		
		$post['approved']			= 0;
		if ($enableUserImageApprove == 0) {
			$post['approved']	= 1;
		}
		
		$model = $this->getModel( 'user' );
		
		if ($model->storeimage($post, $return)) {
			$succeeded = true;
			$errSaveMsg = JText::_( 'PHOCAGALLERY_IMAGE_SAVED' );
		} else {
			$succeeded = false;
			$errSaveMsg = JText::_( 'PHOCAGALLERY_IMAGE_SAVE_ERROR' );
		}
		
		if ($redirect) {
	
			$mainframe->redirect($return, $errSaveMsg);
			exit;
		}
		
		if ($succeeded) {
			return true;
		} else {
			return false;
		}
	}
	
	function publishimage() {
		$id 				= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$model 				= $this->getModel('user');
		$isOwnerCategory 	= $model->isOwnerCategoryImage((int)$this->_user->id, (int)$id);
		
		if ($isOwnerCategory) {
			if(!$model->publishimage((int)$id, 1)) {
			$msg = JText::_('PHOCAGALLERY_IMAGE_PUBLISH_ERROR');
			} else {
			$msg = JText::_('PHOCAGALLERY_IMAGE_PUBLISHEd');
			} 
		} else {
			global $mainframe;
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		$limitStartUrl = $this->getLimitStartUrl((int)$id, 'image');
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
	}
	
	function unpublishimage() {
		$id 				= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$model 				= $this->getModel('user');
		$isOwnerCategory 	= $model->isOwnerCategoryImage((int)$this->_user->id, (int)$id);
		
		if ($isOwnerCategory) {
			if(!$model->publishimage((int)$id, 0)) {
			$msg = JText::_('PHOCAGALLERY_IMAGE_UNPUBLISH_ERROR');
			} else {
			$msg = JText::_('PHOCAGALLERY_IMAGE_UNPUBLISHED');
			} 
		} else {
			global $mainframe;
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		$limitStartUrl = $this->getLimitStartUrl((int)$id, 'image');
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
	}

	function orderimage() {
		$id 				= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$task 				= JRequest::getVar( 'task', '', 'get', 'string', 0 );
		$model 				= $this->getModel( 'user' );
		$isOwnerCategory 	= $model->isOwnerCategoryImage((int)$this->_user->id, (int)$id);
		
		if ($isOwnerCategory) {
			if ($task == 'orderupimage') {
				$model->moveimage(-1, (int)$id);
			} else if ($task == 'orderdownimage') {
				$model->moveimage(1, (int)$id);
			}
		} else {
			global $mainframe;
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		
		$limitStartUrl = $this->getLimitStartUrl(0, 'image');
		
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false) );
	}
	
	function saveorderimage() {
		$cid 			= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 			= JRequest::getVar( 'order', array(), 'post', 'array' );
		$model 			= $this->getModel( 'user' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model->saveorderimage($cid, $order);
		$msg = JText::_( 'New ordering saved' );
		
		$limitStartUrl = $this->getLimitStartUrl(0, 'image');
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
	}

	function removeimage() {	
		$id 				= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$model 				= $this->getModel('user');
		$isOwnerCategory 	= $model->isOwnerCategoryImage((int)$this->_user->id, (int)$id);
		$errorMsg = '';
		
		if ($isOwnerCategory) {
			
			// USER RIGHT - DELETE - - - - - - - - -
			// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
			$rightDisplayDelete = 0;
			
			$catAccess	= PhocaGalleryAccess::getCategoryAccess((int)$isOwnerCategory);
			if (!empty($catAccess)) {
				$rightDisplayDelete = PhocaGalleryAccess::getUserRight('deleteuserid', $catAccess->deleteuserid, 2, 2, $this->_user->get('id', 0), 0);
			}
			// - - - - - - - - - - - - - - - - - - - 	
			
			if(!$model->deleteimage((int)$id, $errorMsg)) {
				$msg = JText::_('PHOCAGALLERY_IMAGE_DELETE_ERROR');
			} else {
				$msg = JText::_('PHOCAGALLERY_IMAGE_DELETED');
			}
		} else {
			global $mainframe;
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		$limitStartUrl = $this->getLimitStartUrl(0, 'image', (int)$isOwnerCategory);
		
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
	}


	
	function editimage() {

		JRequest::checkToken() or jexit( 'Invalid Token' );
		$task 						= JRequest::getVar( 'task', '', 'post', 'string', 0 );
		$post['title']				= JRequest::getVar( 'imagename', '', 'post', 'string', 0  );
		$post['description']		= JRequest::getVar( 'phocagalleryuploaddescription', '', 'post', 'string', 0  );
		$post['id']					= JRequest::getVar( 'id', 0, 'post', 'int' );
		$paramsC 					= JComponentHelper::getParams('com_phocagallery') ;
		$maxCreateCatChar			= $paramsC->get( 'max_create_cat_char', 1000 );
		$post['description']		= substr($post['description'], 0, (int)$maxCreateCatChar);
		$post['alias'] 				= PhocaGalleryText::getAliasName($post['title']);
		$model 						= $this->getModel('user');
		
		
		global $mainframe;
		// USER IS NOT LOGGED
		if ($this->_user->aid < 1 && $this->_user->id < 1) {
			$mainframe->redirect($this->_loginurl, $this->_loginstr);
			exit;
		}
		
		$isOwnerCategory = $model->isOwnerCategoryImage($this->_user->id, (int)$post['id']);
		if(!$isOwnerCategory) {
			$msg = JText::_( 'PHOCAGALLERY_PARENT_CATEGORY_NOT_ASSIGNED_TO_USER' );
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
			exit;
		}
		
		if ((int)$post['id'] < 1) {
			$msg = JText::_( 'PHOCAGALLERY_PARENT_CATEGORY_NOT_SELECTED' );
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
			exit;
		}
		
		$ownerMainCategory	= $model->getOwnerMainCategory($this->_user->id);
		if (!$ownerMainCategory) {
			$msg = JText::_('PHOCAGALLERY_MAIN_CATEGORY_NOT_CREATED');
			$mainframe->redirect(JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg);
		}

		if ($post['title'] != '') {
			$id	= $model->storeimage($post, '', 1);
			if ($id && $id > 0) {
				$msg = JText::_( 'PHOCAGALLERY_IMAGE_EDITED' );
			} else {
				$msg = JText::_( 'PHOCAGALLERY_IMAGE_ERROR_EDIT' );
			}
		} else {
			$msg = JText::_( 'PHOCAGALLERY_IMAGE_EDIT_ERROR_TITLE' );
		}	
		$this->setRedirect( JRoute::_($this->_url. $limitStartUrl->subcat . $limitStartUrl->image, false), $msg );
	}
}
?>