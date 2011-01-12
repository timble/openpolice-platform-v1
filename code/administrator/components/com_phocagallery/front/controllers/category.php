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
phocagalleryimport('phocagallery.rate.ratecategory');
phocagalleryimport('phocagallery.comment.comment');
phocagalleryimport('phocagallery.comment.commentcategory');
phocagalleryimport('phocagallery.upload.uploadfront');
class PhocaGalleryControllerCategory extends PhocaGalleryController
{
	
	function display() {
		if ( ! JRequest::getCmd( 'view' ) ) {
			JRequest::setVar('view', 'category' );
		}
		parent::display();
    }

	function remove() {
		global $mainframe;
		$user 		= &JFactory::getUser();
		$view 		= JRequest::getVar( 'view', '', 'get', '', JREQUEST_NOTRIM  );
		$id 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$catid 		= JRequest::getVar( 'catid', '', 'get', 'string', JREQUEST_NOTRIM  );
		$Itemid		= JRequest::getVar( 'Itemid', 0, '', 'int');
		$limitStart	= JRequest::getVar( 'limitstart', 0, '', 'int');
		
		$model = $this->getModel('category');
		
		// Get catid of an id in case catid will be not send (SEF)
		$catidAlias = $catid; // because of JRoute redirect
		if ($id > 0 && $catid == '') {
			$catidObject 		= $model->getCategoryIdFromImageId($id);
			$catid 				= (int)$catidObject->catid;
			$catidAliasObject 	= $model->getCategoryAlias($catid);
			if ($catidAliasObject->alias !='') {
				$catidAlias		= $catid . ':' . $catidAliasObject->alias;
			}
		}
		
		// USER RIGHT - DELETE - - - - - - - - -
		// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
		$rightDisplayDelete = 0;
		
		$catAccess	= PhocaGalleryAccess::getCategoryAccess((int)$catid);
		if (!empty($catAccess)) {
			$rightDisplayDelete = PhocaGalleryAccess::getUserRight('deleteuserid', $catAccess->deleteuserid, 2, 2, $user->get('id', 0), 0);
		}
		// - - - - - - - - - - - - - - - - - - - 	
		
		if ($view != 'category') {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}
		
		if ((int)$id  < 1) {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false)  );
		}
		
		if ($rightDisplayDelete == 1) {
			if(!$model->delete((int)$id)) {
			$msg = JText::_('Error Deleting Phoca gallery');
			} else {
			$msg = JText::_('Phoca gallery Deleted');
			} 
		} else {
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login', false), JText::_("NOT AUTHORISED TO DO ACTION"));
			exit;
		}

		$countItem = $model->getCountItem((int)$catid, $rightDisplayDelete);
		if ($countItem) {
			if ((int)$countItem[0] == $limitStart) {
				$limitStart = 0;
			}
		} else {
			$limitStart = 0;
		}
		
		if ($limitStart > 0) {
			$limitStartUrl	= '&limitstart='.$limitStart;	
		} else {
			$limitStartUrl	= '';
		}
		$this->setRedirect( JRoute::_('index.php?option=com_phocagallery&view=category&id='.$catidAlias.'&Itemid='. $Itemid . $limitStartUrl, false), $msg );
	}

	function publish() {
		global $mainframe;
	
		$user 		=& JFactory::getUser();
		$view 		= JRequest::getVar( 'view', '', 'get', '', JREQUEST_NOTRIM  );
		$id 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$catid 		= JRequest::getVar( 'catid', '', 'get', 'string', JREQUEST_NOTRIM  );
		$Itemid		= JRequest::getVar( 'Itemid', 0, '', 'int');
		$limitStart	= JRequest::getVar( 'limitstart', 0, '', 'int');
		
		$model = $this->getModel('category');
		
		// Get catid of an id in case catid will be not send (SEF)
		$catidAlias = $catid; // because of JRoute redirect
		if ($id > 0 && $catid == '') {
		$catidObject 		= $model->getCategoryIdFromImageId($id);
			$catid 				= (int)$catidObject->catid;
			$catidAliasObject 	= $model->getCategoryAlias($catid);
			if ($catidAliasObject->alias !='') {
				$catidAlias		= $catid . ':' . $catidAliasObject->alias;
			}
		}
		
		// USER RIGHT - DELETE - - - - - - 
		// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
		$rightDisplayDelete = 0;
		
		$catAccess	= PhocaGalleryAccess::getCategoryAccess((int)$catid);
		if (!empty($catAccess)) {
			$rightDisplayDelete = PhocaGalleryAccess::getUserRight('deleteuserid', $catAccess->deleteuserid, 2, 2, $user->get('id', 0), 0);
		}
		// - - - - - - - - - - - - - - - - -
		
		if ($view != 'category') {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}
		
		if ((int)$id  < 1) {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}
		
		if ($rightDisplayDelete == 1) {
			if(!$model->publish((int)$id, 1)) {
			$msg = JText::_('ERROR PUBLISHING PHOCA GALLERY');
			} else {
			$msg = JText::_('PHOCA GALLERY PUBLISHED');
			} 
		} else {
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login', false), JText::_("NOT AUTHORISED TO DO ACTION"));
			exit;
		}

		if ($limitStart > 0) {
			$limitStartUrl	= '&limitstart='.$limitStart;	
		} else {
			$limitStartUrl	= '';
		}
		$this->setRedirect( JRoute::_('index.php?option=com_phocagallery&view=category&id='.$catidAlias.'&Itemid='. $Itemid . $limitStartUrl, false), $msg );
	}

	function unpublish() {
		global $mainframe;
		$user 		=& JFactory::getUser();
		$view 		= JRequest::getVar( 'view', '', 'get', '', JREQUEST_NOTRIM  );
		$id 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$catid 		= JRequest::getVar( 'catid', '', 'get', 'string', JREQUEST_NOTRIM  );
		$Itemid		= JRequest::getVar( 'Itemid', 0, '', 'int');
		$limitStart	= JRequest::getVar( 'limitstart', 0, '', 'int');

		$model = $this->getModel('category');
		
		// Get catid of an id in case catid will be not send (SEF)
		$catidAlias = $catid; // because of JRoute redirect
		if ($id > 0 && $catid == '') {
			$catidObject 		= $model->getCategoryIdFromImageId($id);
			$catid 				= (int)$catidObject->catid;
			$catidAliasObject 	= $model->getCategoryAlias($catid);
			if ($catidAliasObject->alias !='') {
				$catidAlias		= $catid . ':' . $catidAliasObject->alias;
			}
		}

		// USER RIGHT - DELETE - - - - - - - - - - 
		// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
		$rightDisplayDelete = 0;
		
		$catAccess	= PhocaGalleryAccess::getCategoryAccess((int)$catid);
		if (!empty($catAccess)) {
			$rightDisplayDelete = PhocaGalleryAccess::getUserRight('deleteuserid', $catAccess->deleteuserid, 2, 2, $user->get('id', 0), 0);
		}
		// - - - - - - - - - - - - - - - - - - - 
		
		if ($view != 'category') {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}
		
		if ((int)$id  < 1) {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}

		if ($rightDisplayDelete == 1) {
			if(!$model->publish((int)$id, 0)) {
				$msg = JText::_('ERROR UNPUBLISHING PHOCA GALLERY');
			} else {
				$msg = JText::_('PHOCA GALLERY UNPUBLISHED');
			}
		} else {
			$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login', false), JText::_("NOT AUTHORISED TO DO ACTION"));
			exit;
		}

		if ($limitStart > 0) {
			$limitStartUrl	= '&limitstart='.$limitStart;	
		} else {
			$limitStartUrl	= '';
		}
		$this->setRedirect( JRoute::_('index.php?option=com_phocagallery&view=category&id='.$catidAlias.'&Itemid='. $Itemid . $limitStartUrl, false), $msg );
	}
	
	/*
	 * Java Upload
	 */
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
	
	/*
	 * Upload
	 */
	function upload() {			    
		global $mainframe;		
		$errUploadMsg	= '';	
	    $redirectUrl 	= '';
		$fileArray 		= JRequest::getVar( 'Filedata', '', 'files', 'array' );
		$this->_singleFileUpload($errUploadMsg, $fileArray, $redirectUrl);
		$mainframe->redirect($redirectUrl, $errUploadMsg);
		exit;	
	}


	

	function _singleFileUpload(&$errUploadMsg, $file, &$redirectUrl) {
		global $mainframe;
		JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );

		jimport('joomla.client.helper');
		$ftp 		=& JClientHelper::setCredentialsFromRequest('ftp');
		$user 		=& JFactory::getUser();
		$path		= PhocaGalleryPath::getPath();
		$folder		= JRequest::getVar( 'folder', '', '', 'path' );
		$tab		= JRequest::getVar( 'tab', 0, '', 'int' );
		$format		= JRequest::getVar( 'format', 'html', '', 'cmd');
		$return		= JRequest::getVar( 'return-url', null, 'post', 'base64' );
		$viewBack	= JRequest::getVar( 'viewback', '', '', '' );
		$view 		= JRequest::getVar( 'view', '', 'get', '', JREQUEST_NOTRIM  );
		$catid 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		//$catid 	= JRequest::getVar( 'catid', '', 'post', 'string', JREQUEST_NOTRIM  );
		$Itemid		= JRequest::getVar( 'Itemid', 0, '', 'int');
		$limitStart	= JRequest::getVar( 'limitstart', 0, '', 'int');
		$paramsC 	= JComponentHelper::getParams('com_phocagallery') ;
		
		$catidAlias	= $catid;// for return
		// Set the limistart (TODO)
		if ($limitStart > 0) {
			$limitStartUrl	= '&limitstart='.$limitStart;	
		} else {
			$limitStartUrl	= '';
		}
		
		$return			= JRoute::_('index.php?option=com_phocagallery&view=category&id='.$catidAlias.'&tab='.$tab.'&Itemid='.$Itemid.$limitStartUrl, false);
		$redirectUrl 	= $return;
		$model 			= $this->getModel('category');
		
		// USER RIGHT - UPLOAD - - - - - - - - - - -
		// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
		$rightDisplayUpload	= 0;
		
		$catAccess	= PhocaGalleryAccess::getCategoryAccess((int)$catid);
		if (!empty($catAccess)) {
			$rightDisplayUpload = PhocaGalleryAccess::getUserRight('uploaduserid', $catAccess->uploaduserid, 2, 2, $user->get('id', 0), 0);
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
					PhocaGalleryControllerCategory::save((int)$catid, $file['name'], $return, $succeeded, $errUploadMsg, false);
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
			$redirectUrl = JRoute::_('index.php?option=com_user&view=login', false);
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
		
		
		$model = $this->getModel( 'category' );
		
		if ($model->store($post, $return)) {
			$succeeded = true;
			$errSaveMsg = JText::_( 'Phoca gallery Saved' );
		} else {
			$succeeded = false;
			$errSaveMsg = JText::_( 'Error Saving Phoca gallery' );
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
	
	
	function rate() {
		global $mainframe;
		
		$user 		=& JFactory::getUser();
		$view 		= JRequest::getVar( 'view', '', 'get', '', JREQUEST_NOTRIM  );
		//$id 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$catid 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$rating		= JRequest::getVar( 'rating', '', 'get', 'string', JREQUEST_NOTRIM  );
		$Itemid		= JRequest::getVar( 'Itemid', 0, '', 'int');
		$limitStart	= JRequest::getVar( 'limitstart', 0, '', 'int');
		$tab		= JRequest::getVar( 'tab', 0, '', 'int' );
	
		
		$post['catid'] 	= (int)$catid;
		$post['userid']	= $user->id;
		$post['rating']	= (int)$rating;
	
		$catidAlias 	= $catid; //Itemid
		if ($view != 'category') {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}
		
		
		$model = $this->getModel('category');
		
		$checkUserVote	= PhocaGalleryRateCategory::checkUserVote( $post['catid'], $post['userid'] );
		
		// User has already rated this category
		if ($checkUserVote) {
			$msg = JText::_('You have already rated this category');
		} else {
			if ($post['rating']  < 1 && $post['rating'] > 5) {
				$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false)  );
			}
			
			if ($user->aid > 0 && $user->id > 0) {
				if(!$model->rate($post)) {
				$msg = JText::_('Error Rating Phoca Gallery');
				} else {
				$msg = JText::_('Phoca Gallery Rated');
				} 
			} else {
				$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login', false), JText::_("NOT AUTHORISED TO DO ACTION"));
				exit;
			}
		}

		// Limit Start
		$countItem = $model->getCountItem((int)$catid);
		if ($countItem) {
			if ((int)$countItem[0] == $limitStart) {
				$limitStart = 0;
			}
		} else {
			$limitStart = 0;
		}
		
		if ($limitStart > 0) {
			$limitStartUrl	= '&limitstart='.$limitStart;	
		} else {
			$limitStartUrl	= '';
		}
		
		
		$this->setRedirect( JRoute::_('index.php?option=com_phocagallery&view=category&id='.$catidAlias.'&tab='.$tab.'&Itemid='. $Itemid . $limitStartUrl, false), $msg );
	}
	
	function comment() {
	
		JRequest::checkToken() or jexit( 'Invalid Token' );
		phocagalleryimport('phocagallery.comment.comment');
		phocagalleryimport('phocagallery.comment.commentcategory');
		global $mainframe;
		$user 			=& JFactory::getUser();
		$view 			= JRequest::getVar( 'view', '', 'post', '', 0  );
		$catid 			= JRequest::getVar( 'catid', '', 'post', 'string', 0  );
		$post['title']	= JRequest::getVar( 'phocagallerycommentstitle', '', 'post', 'string', 0  );
		$post['comment']= JRequest::getVar( 'phocagallerycommentseditor', '', 'post', 'string', 0  );
		$Itemid			= JRequest::getVar( 'Itemid', 0, '', 'int');
		$limitStart		= JRequest::getVar( 'limitstart', 0, '', 'int');
		$tab			= JRequest::getVar( 'tab', 0, '', 'int' );

		$paramsC 		= JComponentHelper::getParams('com_phocagallery') ;
		$maxCommentChar	= $paramsC->get( 'max_comment_char', 1000 );
		// Maximum of character, they will be saved in database
		$post['comment']	= substr($post['comment'], 0, (int)$maxCommentChar);
		
		// Close Tags
		$post['comment'] = PhocaGalleryComment::closeTags($post['comment'], '[u]', '[/u]');
		$post['comment'] = PhocaGalleryComment::closeTags($post['comment'], '[i]', '[/i]');
		$post['comment'] = PhocaGalleryComment::closeTags($post['comment'], '[b]', '[/b]');
		
		
		$post['catid'] 	= (int)$catid;
		$post['userid']	= $user->id;
		
		$catidAlias 	= $catid; //Itemid
		if ($view != 'category') {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}
		
		$model = $this->getModel('category');
		
		$checkUserComment	= PhocaGalleryCommentCategory::checkUserComment( $post['catid'], $post['userid'] );
		
		// User has already submitted a comment
		if ($checkUserComment) {
			$msg = JText::_('You have already submitted comment');
		} else {
			// If javascript will not protect the empty form
			$msg 		= '';
			$emptyForm	= 0;
			if ($post['title'] == '') {
				$msg .= JText::_('Error Comment Phoca Gallery - Title') . ' ';
				$emtyForm = 1;
			}
			if ($post['comment'] == '') {
				$msg .= JText::_('Error Comment Phoca Gallery - Comment');
				$emtyForm = 1;
			}
			if ($emptyForm == 0) {
				if ($user->aid > 0 && $user->id > 0) {
					if(!$model->comment($post)) {
					$msg = JText::_('Error Comment Phoca Gallery');
					} else {
					$msg = JText::_('Phoca Gallery Comment Submitted');
					} 
				} else {
					$mainframe->redirect(JRoute::_('index.php?option=com_user&view=login', false), JText::_("NOT AUTHORISED TO DO ACTION"));
					exit;
				}
			}
		}
		
		// Limit Start
		$countItem = $model->getCountItem((int)$catid);
		if ($countItem) {
			if ((int)$countItem[0] == $limitStart) {
				$limitStart = 0;
			}
		} else {
			$limitStart = 0;
		}
		
		if ($limitStart > 0) {
			$limitStartUrl	= '&limitstart='.$limitStart;	
		} else {
			$limitStartUrl	= '';
		}
		
		$this->setRedirect( JRoute::_('index.php?option=com_phocagallery&view=category&id='.$catidAlias.'&tab='.$tab.'&Itemid='. $Itemid . $limitStartUrl, false), $msg );
	}


}
?>