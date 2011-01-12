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
class PhocaGalleryCpControllerPhocaGalleryc extends PhocaGalleryCpController
{
	function __construct() {
		
		parent::__construct();
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply'  , 'save' );
		$this->registerTask( 'accesspublic', 'accessMenu');
		$this->registerTask( 'accessregistered', 'accessMenu');
		$this->registerTask( 'accessspecial', 'accessMenu');
		$this->registerTask( 'PicLens', 'piclens');
		$this->registerTask( 'approve', 'approve');
		$this->registerTask( 'disapprove', 'disapprove');
		$this->registerTask( 'loadextimg', 'save'); // Save but with loading images
	}
	
	function edit() {
		
		JRequest::setVar( 'view', 'phocagalleryc' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1 );

		parent::display();

		$model = $this->getModel( 'phocagalleryc' );
		$model->checkout();
	}

	function save() {
		$post					= JRequest::get('post');
		$cid					= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['description']	= JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$post['parent_id']		= JRequest::getVar( 'parentid', '', 'post', 'int' );
		$post['approved']		= JRequest::getVar( 'approved', '', 'post', 'int' );
		$post['owner_id']		= JRequest::getVar( 'ownerid', '', 'post', 'int' );
		$post['id'] 			= (int) $cid[0];

		// DEFAULT VALUES FOR Rights in FRONTEND
		// ACCESS -  0: all users can see the category (registered or not registered)
		//             if registered or not registered it will be set in ACCESS LEVEL not here)
		//			   if -1 - user was not selected so every registered or special users can see category
		// UPLOAD - -2: nobody can upload or add images in front (if 0 - every users can do it)
		// DELETE - -2: nobody can upload or add images in front (if 0 - every users can do it)
		$accessUserId	= JRequest::getVar( 'accessuserid', array(0 => 0), 'post', 'array' );
		$uploadUserId	= JRequest::getVar( 'uploaduserid', array(0 => -2), 'post', 'array' );
		$deleteUserId	= JRequest::getVar( 'deleteuserid', array(0 => -2), 'post', 'array' );
	/*	$userFolder		= JRequest::getVar( 'userfolder', '', 'post', 'string' );
		$longitude		= JRequest::getVar( 'longitude', '', 'post', 'string' );
		$latitude		= JRequest::getVar( 'latitude', '', 'post', 'string' );
		$zoom			= JRequest::getVar( 'zoom', '', 'post', 'string' );
		$geotitle		= JRequest::getVar( 'geotitle', '', 'post', 'string' );*/
		
		// Set all registered users if not selected, but 'registered' in access selected
		if (isset($post['access']) && (int)$post['access'] > 0 && (int)$accessUserId[0] == 0) {		
			$accessUserId[0]	= -1;
		}
		$post['accessuserid'] = implode(',',$accessUserId);
		$post['uploaduserid'] = implode(',',$uploadUserId);
		$post['deleteuserid'] = implode(',',$deleteUserId);
		
		$model = $this->getModel( 'phocagalleryc' );
		
		// Owner can have only one main category - check it 
		$errorMsgOwner		= '';
		$ownerMainCategory	= $model->getOwnerMainCategory($post['owner_id'], $post['id'], $post['parent_id'], $errorMsgOwner);
		
		if($errorMsgOwner != '') {
			
			$post['owner_id'] = 0;
		}
		
		$paramsC = JComponentHelper::getParams('com_phocagallery');
		$picasa_load_pagination = $paramsC->get( 'picasa_load_pagination', 20 );
		
		switch ( JRequest::getCmd('task') )
		{
			case 'loadextimg':
				
				// First get Album ID from PICASA
				// Second save this ID to Category
				// Third save images with ID of category
				
				$errorMsgA = $errorMsgI = $msg = '';
				//FIRST
				
				if (isset($_GET['picstart'])) {
					// Category is saved - use this id and don't save it again
					$post['exta']	= JRequest::getVar( 'picalbum', '', 'get'  );
					$post['extu']	= JRequest::getVar( 'picuser', '', 'get'  );
					$post['extauth']= JRequest::getVar( 'picauth', '', 'get'  );
				}
				
				$album = $model->picasaalbum($post['extu'], $post['extauth'], $post['exta'], $errorMsgA);
				
				if (!$album) {
					if($errorMsgA != '') {
						if ($msg != '') {$msg .= '<br />';}
						$msg .= $errorMsgA;
					}
				} else {
					$post['extid'] = $album['id'];
				}
				
				// SECOND
				
				if (isset($_GET['picstart'])) {
					// Category is saved - use this id and don't save it again
					$cid			= JRequest::getVar( 'cid', array(0), 'get', 'array' );
					$id				= (int) $cid[0];
				} else {
					$id	= $model->store($post);//you get id and you store the table data
				}
				
				if ($id && $id > 0) {
					if ($msg != '') {$msg .= '<br />';}
					$msg .= JText::_( 'Changes to Phoca Gallery Categories Saved' );
					
					// THIRD
					if ($album && (int)$album['id'] > 0) {
					
						// PAGINATION
						$start	= JRequest::getVar( 'picstart', 1, 'get', 'int' );
						$max	= $picasa_load_pagination;
						$pagination	= '&start-index='.(int)$start.'&max-results='.(int)$max;
						$picImg = $model->picasaimages($post['extu'],$post['extauth'], $album['id'], $id, $pagination, $errorMsgI);
						
						if (!$picImg) {
							if($errorMsgI != '') {
								if ($msg != '') {$msg .= '<br />';}
								$msg .= $errorMsgI;
							}
						} else {
						
							if (isset($album['num']) && (int)$album['num'] > 0) {
								$newStart 	= (int)$start + (int)$max;
								$newStartIf	= (int)$newStart - 1;
								
								// Sec - - - - 
								$loop		= (int)$album['num'] / (int)$max;
								$maxCount	= (int)$max;
								// - - - - - - 
								if ((int)$loop > 50 || $maxCount < 20) {
									if ($msg != '') {$msg .= '<br />';}
									$msg .= JText::_( 'PHOCAGALLERY_PICASA_IMAGE_NOT_ALL_LOADED' );
								} else {
									if ((int)$album['num'] > (int)$newStartIf) {
										
										$refreshUrl	= 'index.php?option=com_phocagallery&controller=phocagalleryc&cid[]='.$id.'&task=loadextimg&picalbum='.$post['exta'].'&picuser='.$post['extu'].'&picauth='.$post['extauth'].'&picstart='.(int)$newStart;
										$countImg	= $newStartIf + $max;
										if ($countImg > $album['num']) {
											$countImg = $album['num'];
										}
										$countInfo 	= '<div><b>'.$newStart. '</b> - <b>'. $countImg . '</b> ' .JText::_('PHOCAGALLERY_FROM'). ' <b>' . $album['num'].'</b></div>';
										PhocaGalleryPicasa::renderProcessPage($id, $refreshUrl, $countInfo);
										exit;
									}
								}
							}
							
							if ($msg != '') {$msg .= '<br />';}
							$msg .= JText::_( 'PHOCAGALLERY_PICASA_IMAGE_LOADED' );
						}
					}
					
					
					
				} else {
					$msg = JText::_( 'Error Saving Phoca Gallery Categories' );
					$id		= $post['id'];
				}
				
				$this->setRedirect( 'index.php?option=com_phocagallery&controller=phocagalleryc&task=edit&cid[]='. $id, $msg . $errorMsgOwner );
			break;
				
			
			break;
			case 'apply':
				$id	= $model->store($post);//you get id and you store the table data
				if ($id && $id > 0) {
					

					// -----------------------------------------------------------
					// Set owner of category by Administrator in administration
					if (isset($post['owner_id'])) {
						$data['userid']		= $post['owner_id'];
						//$data['catid']		= $id;
						$data['avatar']		= '';
						$data['userid']		= (int)$post['owner_id'];
						$data['published']	= 1;
						$data['approved']	= 0;
						// is there some item in phocagallery_user about this user
						if (isset($data['userid']) && (int)$data['userid'] > 0) {
							$dataOwnerCategory	= $model->getOwnerCategoryData($data['userid']);
							if ($dataOwnerCategory) {
								// Owner is set in user table
								$userCategoryId 	= $model->storeOwnerCategory($dataOwnerCategory);
							} else {
								// Owner is not set in user table
								$userCategoryId 	= $model->storeOwnerCategory($data);
							}
						
							if (!$userCategoryId) {
								$msg = JText::_( 'Error Saving Phoca Gallery Categories' ) . ' - ' . JText('Author');
								$this->setRedirect( 'index.php?option=com_phocagallery&controller=phocagalleryc&task=edit&cid[]='. $id, $msg );
							}
						}
					}
					// -----------------------------------------------------------
					
					
					$msg = JText::_( 'Changes to Phoca Gallery Categories Saved' );
					//$id		= $model->store($post);
				} else {
					$msg = JText::_( 'Error Saving Phoca Gallery Categories' );
					$id		= $post['id'];
				}
				$this->setRedirect( 'index.php?option=com_phocagallery&controller=phocagalleryc&task=edit&cid[]='. $id, $msg . $errorMsgOwner );
				break;

			case 'save':
			default:
				$id	= $model->store($post);//you get id and you store the table data
				if ($id && $id > 0) {
					
					// Set owner of category by Administrator in administration
					if (isset($post['owner_id'])) {
						$data['userid']		= $post['owner_id'];
						//$data['catid']		= $id;
						$data['avatar']		= '';
						$data['userid']		= (int)$post['owner_id'];
						$data['published']	= 1;
						$data['approved']	= 0;
						// is there some item in phocagallery_user about this user
						if (isset($data['userid']) && (int)$data['userid'] > 0) {
							$dataOwnerCategory	= $model->getOwnerCategoryData($data['userid']);
							if ($dataOwnerCategory) {
								// Owner is set in user table
								$userCategoryId 	= $model->storeOwnerCategory($dataOwnerCategory);
							} else {
								// Owner is not set in user table
								$userCategoryId 	= $model->storeOwnerCategory($data);
							}
						
							if (!$userCategoryId) {
								$msg = JText::_( 'Error Saving Phoca Gallery Categories' ) . ' - ' . JText('Owner');
								$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycs', $msg );
							}	
						}
					}
					// -----------------------------------------------------------
					
					$msg = JText::_( 'Phoca Gallery Categories Saved' );
				} else {
					$msg = JText::_( 'Error Saving Phoca Gallery Categories' );
				}
				$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycs', $msg. $errorMsgOwner );
				break;
		}
		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
	}
	
	function accessMenu() {
		$post			= JRequest::get('post');
		$cid			= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$access			= $post['task'];
		
		switch ($access) {
			case 'accessregistered':
			$access_id= 1;
			break;

			case 'accessspecial':
			$access_id= 2;
			break;
			
			case 'accesspublic':
			default:
			$access_id= 0;
			break;
		}
		
		$model = $this->getModel( 'phocagalleryc' );

		$model->accessmenu($cid[0],$access_id);
		$model->checkin();
		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		$this->setRedirect($link, $msg);
	}

	function remove() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		
		
		$model = $this->getModel( 'phocagalleryc' );
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			$msg = JText::_( 'Error Deleting Phoca Gallery Categories' );
		} else {
			$msg = JText::_( 'Phoca Gallery Categories Deleted' );
		}

		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		$this->setRedirect( $link, $msg );
	}

	function publish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('phocagalleryc');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		$this->setRedirect($link);
	}

	function unpublish() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('phocagalleryc');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		$this->setRedirect($link);
	}
	
	function approve() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to approve' ) );
		}

		$model = $this->getModel('phocagalleryc');
		if(!$model->approve($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycs' );
	}

	function disapprove() {
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to disapprove' ) );
		}

		$model = $this->getModel('phocagalleryc');
		if(!$model->approve($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagallerycs' );
	}

	function cancel() {
		$model = $this->getModel( 'phocagalleryc' );
		$model->checkin();

		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		$this->setRedirect( $link );
	}

	function orderup() {
		$model = $this->getModel( 'phocagalleryc' );
		$model->move(-1);

		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		$this->setRedirect( $link );
	}

	function orderdown() {
		$model = $this->getModel( 'phocagalleryc' );
		$model->move(1);

		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		$this->setRedirect( $link );
	}

	function saveorder() {
		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel( 'phocagalleryc' );
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		$this->setRedirect( $link, $msg  );
	}
	
	function piclens() {
		$cids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );	
		
		$model = $this->getModel( 'phocagalleryc' );
		
		if(!$model->piclens($cids))
		{
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
			$msg = JText::_( 'Error Creating PicLens RSS File(s)' );
		}
		else {
			$msg = JText::_( 'PicLens RSS File(s) created' );
		}
		
		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		$this->setRedirect( $link, $msg  );
	}
}
?>
