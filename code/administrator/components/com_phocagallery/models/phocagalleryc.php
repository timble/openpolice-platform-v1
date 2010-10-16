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
jimport('joomla.application.component.model');
phocagalleryimport('phocagallery.utils.utils');
phocagalleryimport('phocagallery.picasa.picasa');

class PhocaGalleryCpModelPhocaGalleryC extends JModel
{
	var $_XMLFile;
	var $_id;
	var $_data;
	
	function __construct() {
		parent::__construct();
		$cid = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$cid[0]);
	}

	function setId($id) {
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData() {
		if ($this->_loadData()) {
		} else {
			$this->_initData();
		}
		return $this->_data;
	}
	
	function isCheckedOut( $uid=0 ) {
		if ($this->_loadData()) {
			if ($uid) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		}
	}

	function checkin() {
		if ($this->_id) {
			$table = & $this->getTable();
			if(! $table->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}

	function checkout($uid = null) {
		if ($this->_id) {
			if (is_null($uid)) {
				$user	=& JFactory::getUser();
				$uid	= $user->get('id');
			}
			$table = & $this->getTable();
			if(!$table->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}
	
	function store($data) {
		
		if ($data['alias'] == '') {
			$data['alias'] = $data['title'];
		}
		$data['alias'] = PhocaGalleryText::getAliasName($data['alias']);
		
		$row =& $this->getTable();
		
		// Bind the form fields to the table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->date) {
			$row->date = gmdate('Y-m-d H:i:s');
		}
		
		// if new item, order last in appropriate group
		if (!$row->id) {
			$where = 'parent_id = ' . (int) $row->parent_id ;
			$row->ordering = $row->getNextOrder( $where );
		}

		// Make sure the table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $row->id;
	}
	
	
	/*
	 * AUTHOR - OWNER
	 * Get information about owner's category
	 */
	function getOwnerMainCategory($userId, $categoryId, $parentId, &$errorMsgOwner) {
		
		$db =& JFactory::getDBO();
		
		// It is new subcategory, check if parent category has the same owner
		// If not don't assing the owner
		if ($parentId > 0) {
		
			$query = 'SELECT cc.id, cc.owner_id'
			. ' FROM #__phocagallery_categories AS cc'
			. ' WHERE cc.id = '.(int)$parentId;
			$db->setQuery( $query );
			$parentCatOwnerId = $db->loadObject();
			
			if (isset($parentCatOwnerId->owner_id) ) {
				if (($userId < 1) || $userId == $parentCatOwnerId->owner_id) {
					return true;
				} else {
					$errorMsgOwner .= '<br />'. JText::_('PHOCAGALLERY_PARENT_CATEGORY_NOT_ASSIGNED_TO_SAME_USER');
					return false;
				}
			}
		} else {
		
			// It is not subcategory
			// If there is owner for other root category, don't assign it
			$query = 'SELECT cc.id, cc.title'
				. ' FROM #__phocagallery_categories AS cc'
				. ' WHERE cc.owner_id = '.(int)$userId
				. ' AND cc.id <> '.(int)$categoryId // Check other categories
				. ' AND cc.owner_id > 0' // Ignore -1
				. ' AND cc.parent_id = 0';// TODO
			
			$db->setQuery( $query );
			$ownerMainCategoryId = $db->loadObject();
			if (isset($ownerMainCategoryId->title)) {
				$errorMsgOwner .= '<br />'. JText::_('PHOCAGALLERY_SELECTED_USER_CAN_BE_ASSIGNED_TO_ONE_MAIN_CATEGORY_ONLY')
								.'<br />'. JText::_('PHOCAGALLERY_USER_ASSIGNED_TO_CATEGORY') . ': ' . $ownerMainCategoryId->title;
				return false;
			}
		}

		return true;
	}
	
	function accessmenu($id, $access) {
		global $mainframe;
		$row =& $this->getTable();
		if (!$row->load($id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		$row->id = $id;
		$row->access = $access;

		if ( !$row->check() ) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if ( !$row->store() ) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	}

	function delete($cid = array()) {
		global $mainframe;
		$db =& JFactory::getDBO();
		
		$result = false;
		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			
			// FIRST - if there are subcategories - - - - - 	
			$query = 'SELECT c.id, c.name, c.title, COUNT( s.parent_id ) AS numcat'
			. ' FROM #__phocagallery_categories AS c'
			. ' LEFT JOIN #__phocagallery_categories AS s ON s.parent_id = c.id'
			. ' WHERE c.id IN ( '.$cids.' )'
			. ' GROUP BY c.id'
			;
			$db->setQuery( $query );
				
			if (!($rows2 = $db->loadObjectList())) {
				JError::raiseError( 500, $db->stderr('Load Data Problem') );
				return false;
			}

			// Add new CID without categories which have subcategories (we don't delete categories with subcat)
			$err_cat = array();
			$cid 	 = array();
			foreach ($rows2 as $row) {
				if ($row->numcat == 0) {
					$cid[] = (int) $row->id;
				} else {
					$err_cat[] = $row->title;
				}
			}
			// - - - - - - - - - - - - - - -
			
			// Images with new cid - - - - -
			if (count( $cid )) {
				JArrayHelper::toInteger($cid);
				$cids = implode( ',', $cid );
			
				// Select id's from phocagallery tables. If the category has some images, don't delete it
				$query = 'SELECT c.id, c.name, c.title, COUNT( s.catid ) AS numcat'
				. ' FROM #__phocagallery_categories AS c'
				. ' LEFT JOIN #__phocagallery AS s ON s.catid = c.id'
				. ' WHERE c.id IN ( '.$cids.' )'
				. ' GROUP BY c.id';
			
				$db->setQuery( $query );

				if (!($rows = $db->loadObjectList())) {
					JError::raiseError( 500, $db->stderr('Load Data Problem') );
					return false;
				}
				
				$err_img = array();
				$cid 	 = array();
				foreach ($rows as $row) {
					if ($row->numcat == 0) {
						$cid[] = (int) $row->id;
					} else {
						$err_img[] = $row->title;
					}
				}
				
				if (count( $cid )) {
					$cids = implode( ',', $cid );
					$query = 'DELETE FROM #__phocagallery_categories'
					. ' WHERE id IN ( '.$cids.' )';
					$db->setQuery( $query );
					if (!$db->query()) {
						$this->setError($this->_db->getErrorMsg());
						return false;
					}
					
					// Delete items in phocagallery_user_category
				/*	$query = 'DELETE FROM #__phocagallery_user_category'
					. ' WHERE catid IN ( '.$cids.' )';
					$db->setQuery( $query );
					if (!$db->query()) {
						$this->setError($this->_db->getErrorMsg());
						return false;
					}*/
				}
			}
			
			// There are some images in the category - don't delete it
			$msg = '';
			if (count( $err_cat ) || count( $err_img )) {
				if (count( $err_cat )) {
					$cids_cat = implode( ", ", $err_cat );
					$msg .= JText::sprintf( 'WARNNOTREMOVEDRECORDS PHOCA GALLERY CAT', $cids_cat );
				}
				
				if (count( $err_img )) {
					$cids_img = implode( ", ", $err_img );
					$msg .= JText::sprintf( 'WARNNOTREMOVEDRECORDS PHOCA GALLERY', $cids_img );
				}
				$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
				$mainframe->redirect($link, $msg);
			}
		}
		return true;
	}

	function publish($cid = array(), $publish = 1) {
		
		$user 	=& JFactory::getUser();
		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__phocagallery_categories'
				. ' SET published = '.(int) $publish
				. ' WHERE id IN ( '.$cids.' )'
				. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )';
				
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}
	
	function approve($cid = array(), $approved = 1) {
		$user 	=& JFactory::getUser();

		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__phocagallery_categories'
				. ' SET approved = '.(int) $approved
				. ' WHERE id IN ( '.$cids.' )'
				. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )'
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	function move($direction) {
		$row =& $this->getTable();
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->move( $direction, ' parent_id = '.(int) $row->parent_id.' AND published >= 0 ' )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	
	function saveorder($cid = array(), $order){
		$row 		=& $this->getTable();
		$groupings 	= array();

		// $catid is null -  update ordering values
		for( $i=0; $i < count($cid); $i++ ) {
			$row->load( (int) $cid[$i] );
			$groupings[] = $row->parent_id; // track categories

			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder('parent_id = '.(int) $group);
		}
		return true;
	}
	
	function _loadData() {
		if (empty($this->_data)) {		
			$query = 'SELECT p.*'	
					.' FROM #__phocagallery_categories AS p'
					//.' LEFT JOIN #__phocagallery_user_category AS uc ON uc.catid = p.id'
					.' WHERE p.id = '.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}
	
	function _initData() {
		if (empty($this->_data)) {
			$table = new stdClass();
			$table->id				= 0;
			$table->parent_id		= 0;
			$table->owner_id		= 0;
			$table->title			= null;
			$table->name			= null;
			$table->alias			= null;
			$table->image			= null;
			$table->section        	= null;
			$table->image_position	= null;
			$table->description		= null;
			$table->date			= null;
			$table->published		= 0;
			$table->approved		= 0;
			$table->checked_out		= 0;
			$table->checked_out_time= 0;
			$table->editor			= null;
			$table->ordering		= 0;
			$table->access			= 0;
			$table->hits			= 0;
			$table->count			= 0;
			$table->params			= null;
			$table->metakey				= null;
			$table->metadesc			= null;
			$table->userid			= 0;
			$table->accessuserid	= null;
			$table->uploaduserid	= null;
			$table->deleteuserid	= null;
			$table->userfolder		= null;
			$table->latitude		= null;
			$table->longitude		= null;
			$table->zoom			= null;
			$table->geotitle		= null;
			$table->extid			= null;
			$table->exta			= null;
			$table->extu			= null;
			$table->extauth			= null;
			$this->_data			= $table;
			return (boolean) $this->_data;
		}
		return true;
	}

	
	function piclens($cids) {
		$db 		=& JFactory::getDBO();
		$path 		= PhocaGalleryPath::getPath();
		$piclensImg = $path->image_rel_front.'icon-phocagallery.png';
		$paramsC= JComponentHelper::getParams('com_phocagallery') ;
		jimport('joomla.filesystem.file');
		
		// PARAMS
		// original 0, thumbnail 1
		$piclens_image 	= $paramsC->get( 'piclens_image', 1);
		
		if (JFolder::exists($path->image_abs)) {  
			
			foreach ($cids as $kcid =>$vcid) {
				$this->setXMLFile();
				
				if (!$this->_XMLFile) {
					$this->setError( 'Could not create XML builder' );
					return false;
				}
						
				if (!$node = $this->_XMLFile->createElement( 'rss' )) {
					$this->setError( 'Could not create node!' );
					return false;
				}
				
				$node->setAttribute( 'xmlns:media', 'http://search.yahoo.com/mrss' );
				$node->setAttribute( 'xmlns:atom', 'http://www.w3.org/2005/Atom' );
				$node->setAttribute( 'version', '2.0' );
				
				$this->_XMLFile->setDocumentElement( $node );
				
				if (!$root =& $this->_XMLFile->documentElement) {
					$this->setError( 'Could not obtain root element!' );
					return false;
				}
			
				$channel =& $this->_XMLFile->createElement( 'channel' );
				$atomIcon=& $this->_XMLFile->createElement( 'atom:icon' );
				$atomIcon->setText( JURI::root() . $piclensImg );
				$channel->appendChild( $atomIcon );	
				
				$query = 'SELECT a.id, a.title, a.filename, a.description, a.extid, a.extl, a.exto'
				. ' FROM #__phocagallery AS a'
				. ' WHERE a.catid = '.(int)$vcid
				. ' AND a.published = 1'
				. ' ORDER BY a.catid, a.ordering';
				
				$db->setQuery($query);
				$rows = $db->loadObjectList();
				
				foreach ($rows as $krow => $vrow) {
					$file 		= PhocaGalleryFileThumbnail::getOrCreateThumbnail($vrow->filename, '');	
					$thumbFile	= str_replace( "administrator", "",  $file['thumb_name_l_no_rel']);
					$origFile	= str_replace( "administrator", "",  $file['name_original_rel']);					

					
					$item=& $this->_XMLFile->createElement( 'item' );
					$item->appendChild( $this->_buildXMLElement( 'title', $vrow->title ) );

					
					if ($vrow->extid != '') {
						$item->appendChild( $this->_buildXMLElement( 'link', $vrow->extl  ));
					} else {
						$item->appendChild( $this->_buildXMLElement( 'link', JURI::root().$thumbFile ) );
					}
					
					//$item->appendChild( $this->_buildXMLElement( 'media:description', $vrow->description  ) );
					$item->appendChild( $this->_buildXMLElement( 'description', JFilterOutput::cleanText(strip_tags($vrow->description ))));
					$thumbnail=& $this->_XMLFile->createElement( 'media:thumbnail' );
					
					if ($vrow->extid != '') {
						$thumbnail->setAttribute( 'url', $vrow->extl );
						$content=& $this->_XMLFile->createElement( 'media:content' );
						if ($piclens_image == 1) {
							$content->setAttribute( 'url', $vrow->extl );
						} else {
							$content->setAttribute( 'url', $vrow->exto );
						}
					} else {
						$thumbnail->setAttribute( 'url', JURI::root().$thumbFile );
						$content=& $this->_XMLFile->createElement( 'media:content' );
						if ($piclens_image == 1) {
							$content->setAttribute( 'url', JURI::root().$thumbFile );
						} else {
							$content->setAttribute( 'url', JURI::root().$origFile );
						}
					}

					$item->appendChild( $thumbnail );
					$item->appendChild( $content );
					
					$guid=& $this->_XMLFile->createElement( 'guid' );
					if ($vrow->extid != '') {
						$guid->setText( $vcid .'-phocagallerypiclenscode-'.$vrow->extid );
					} else {
						$guid->setText( $vcid .'-phocagallerypiclenscode-'.$vrow->filename );
					}
					$guid->setAttribute( 'isPermaLink', "false" );
					$item->appendChild( $guid );
					
					$channel->appendChild( $this->_buildXMLElement(  'title', 'Phoca Gallery' ));
					$channel->appendChild( $this->_buildXMLElement( 'link', 'http://www.phoca.cz/' ));
					$channel->appendChild( $this->_buildXMLElement( 'description', 'Phoca Gallery' ));
					
					$channel->appendChild( $item );
				}

				$root->appendChild( $channel );	 
			
				$this->_XMLFile->setXMLDeclaration( '<?xml version="1.0" encoding="utf-8" standalone="yes"?>' );
				
				//echo $this->_XMLFile->toNormalizedString( true );exit;
				// saveXML_utf8 doesn't save setXMLDeclaration
				/*if (!$this->_XMLFile->saveXML( $path->image_abs . DS . $vcid.'.rss', true )) {
					$this->setError( 'Could not save XML file!' );
					return false;
				}*/
				ob_start();
				echo $this->_XMLFile->toNormalizedString(false, true);
				$xmlToWrite = ob_get_contents();
				ob_end_clean();
				if(!JFile::write( $path->image_abs . DS . $vcid.'.rss', $xmlToWrite)) {
					$this->setError( 'Could not save XML file!' );
					return false;
				}
			}
			return true;
		} else {
			$this->setError( 'Phoca Gallery image folder not exists' );
		}
	}
	
	function setXMLFile() {
		$this->_XMLFile =& JFactory::getXMLParser();
	}
	
	function &_buildXMLElement( $elementName, $text ) {
		$node = $this->_XMLFile->createElement( $elementName );
		$node->setText( $text );
		return $node;
	}
	
	function picasaalbum($user, $authkey, $album, &$errorMsg) {
		
		$paramsC = JComponentHelper::getParams('com_phocagallery');
		$enable_picasa_loading = $paramsC->get( 'enable_picasa_loading', 1 );	
		if($enable_picasa_loading == 0){
			$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_ENABLED');
			return false;
		}
		
		//Check the file_get_contents and JSON and cURL
		
		/*if(!function_exists("curl_init")){
			$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_CURL');
			return false;
		}
		
		if(!PhocaGalleryUtils::iniGetBool('allow_url_fopen')){
			$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_FOPEN');
			return false;
		}*/
		
		if(!function_exists("json_decode")){
			$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_JSON');
			return false;
		}
	
		// PUBLIC OR UNLISTED ALBUM
		if ($authkey == ''){
			// PUBLIC ALBUM
			$userAddress 	= 'http://picasaweb.google.com/data/feed/api/user/'.htmlentities($user).'?kind=album&access=public&alt=json';
			$dataUser 		= PhocaGalleryPicasa::loadDataByAddress($userAddress, 'user', $errorMsg);
			
			if($dataUser == '') {
				$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_USER');
				return false;
			}
			
			$dataUser 		= json_decode($dataUser);
			$albumInfo 		= false;
			$OgphotoId 		= 'gphoto$id';
			$OgphotoName 	= 'gphoto$name';
			$OgphotoNum 	= 'gphoto$numphotos';
			$Ot				= '$t';
			
			if (isset($dataUser->feed->entry) && count($dataUser->feed->entry) > 0) {
				foreach ($dataUser->feed->entry as $key => $value) {
					
					if ($album == $value->{$OgphotoName}->{$Ot}) {
						$albumInfo['id'] 	= $value->{$OgphotoId}->{$Ot};
						$albumInfo['num'] 	= $value->{$OgphotoNum}->{$Ot};
						return $albumInfo;
					}
				}
				// Album not found
				$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_ALBUM');
				return false;
			} else {
				$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_USER');
				return false;
			}
		} else {
			// UNLISTED ALBUM
			$userAddress 	= 'http://picasaweb.google.com/data/feed/api/user/'.htmlentities($user).'/album/'.htmlentities($album).'?authkey='.htmlentities($authkey).'&alt=json';
			$dataUser		= PhocaGalleryPicasa::loadDataByAddress($userAddress, 'user', $errorMsg);
			if($dataUser == '') {
				$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_ALBUM');
				return false;
			}
			
			$dataUser 		= json_decode($dataUser);
			$albumInfo 		= false;
			$OgphotoId 		= 'gphoto$id';
			$OgphotoName 	= 'gphoto$name';
			$OgphotoNum 	= 'gphoto$numphotos';
			$Ot				= '$t';
		
			if (isset($dataUser->feed->entry) && count($dataUser->feed->entry) > 0) {
			
				if ($album == $dataUser->feed->{$OgphotoName}->{$Ot}) {
					$albumInfo['id'] 	=$dataUser->feed->{$OgphotoId}->{$Ot};
					$albumInfo['num'] 	= $dataUser->feed->{$OgphotoNum}->{$Ot};
					return $albumInfo;
				}
				
				// Album not found
				$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_ALBUM');
				return false;
			} else {
				$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_USER');
				return false;
			}
		}

	}
	
	function picasaimages($user, $authkey, $albumId, $catid, $pagination, &$errorMsg) {
	
		// Large image - is taken as original
		// Medium - can be taken as original (if Picasat thumbs are too small or as thumbnail)
		// Small - is taken as thumbnail
		
		// In getSize we decide if the mediumT will be 0 or 1
		// mediumT = 1 - thumbnail, mediumT = 0 - original
		$mediumT = 0;
		phocagalleryimport('phocagallery.picasa.picasa');
		$size = PhocaGalleryPicasa::getSize($mediumT);
		
		$Ot				= '$t';
		$OgeorssWhere	= 'georss$where';
		$OgmlPoint 		= 'gml$Point';
		$OgmlPos 		= 'gml$pos';
		$OmediaGroup	= 'media$group';
		$OmediaContent	= 'media$content';
		$OmediaThumbnail= 'media$thumbnail';
		$OgphotoId 		= 'gphoto$id';
		$OgphotoName 	= 'gphoto$name';
		$Ot				= '$t';
		
		// LARGE AND SMALL( AND MEDIUM) - will be the same everywhere so we take them in one
		if ($authkey == ''){
			$albumAddressLSM	= 'http://picasaweb.google.com/data/feed/api/user/'.htmlentities($user).'/albumid/'.$albumId.'?alt=json&kind=photo'.$size['lsm'].$pagination;
		} else {
			$albumAddressLSM	= 'http://picasaweb.google.com/data/feed/api/user/'.htmlentities($user).'/albumid/'.$albumId.'?alt=json&kind=photo'.$size['lsm'].$pagination.'&authkey='.htmlentities($authkey);
		}
		$dataAlbumLSM 		= PhocaGalleryPicasa::loadDataByAddress($albumAddressLSM, 'album', $errorMsg);
	
		if(!$dataAlbumLSM) {
			//$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_IMAGE');
			return false;
		}
		$dataAlbumLSM 	= json_decode($dataAlbumLSM);
		
		$dataImg = array();
		
	
		// LARGE AND SMALL (AND MEDIUM)
		if (isset($dataAlbumLSM->feed->entry) && count($dataAlbumLSM->feed->entry) > 0) {
			$i = 0;
			foreach ($dataAlbumLSM->feed->entry as $key => $value) {
				
				$row->date = gmdate('Y-m-d H:i:s');
				$dataImg[$i]['extid']			= $value->{$OgphotoId}->{$Ot};
				$dataImg[$i]['title']			= $value->title->{$Ot};
				$dataImg[$i]['description']	= $value->summary->{$Ot};
				$dataImg[$i]['extl']			= $value->content->src;
				$dataImg[$i]['exto']			= str_replace('/s'.$size['ls'].'/', '/', $value->content->src);
				$dataImg[$i]['exts']			= $value->{$OmediaGroup}->{$OmediaThumbnail}[0]->url;
				if ($mediumT == 1) {
					$dataImg[$i]['extm']		= $value->{$OmediaGroup}->{$OmediaThumbnail}[1]->url;
				}
				$dataImg[$i]['date']			= substr(str_replace('T', ' ',$value->updated->{$Ot}), 0, 19);
				/*if (isset($value->{$OgeorssWhere}->{$OgmlPoint}->{$OgmlPos}->{$Ot})) {
					$dataImg[$i]['latitude']	= substr($value->{$OgeorssWhere}->{$OgmlPoint}->{$OgmlPos}->{$Ot}, 0, 10);
					$dataImg[$i]['longitude']	= substr($value->{$OgeorssWhere}->{$OgmlPoint}->{$OgmlPos}->{$Ot}, 11, 10);
					$dataImg[$i]['zoom']		= 10;
					//$data['geotitle']	= $data['title'];
				}*/
				
				if (isset($value->{$OgeorssWhere}->{$OgmlPoint}->{$OgmlPos}->{$Ot})) {
					//$dataImg[$i]['latitude']    = substr($value->{$OgeorssWhere}->{$OgmlPoint}->{$OgmlPos}->{$Ot}, 0, 10);
					//$dataImg[$i]['longitude']    = substr($value->{$OgeorssWhere}->{$OgmlPoint}->{$OgmlPos}->{$Ot}, 11, 10);
					$geoArray = explode (' ', $value->{$OgeorssWhere}->{$OgmlPoint}->{$OgmlPos}->{$Ot});
					if (isset($geoArray[0])) {
						$dataImg[$i]['latitude'] = $geoArray[0];
					}
					if (isset($geoArray[1])) {
						$dataImg[$i]['longitude'] = $geoArray[1];
					}
					$dataImg[$i]['zoom']        = 10;
					//$data['geotitle']    = $data['title'];
				} 
				
				
				// Large
				$dataImg[$i]['extw'][0]				= $value->{$OmediaGroup}->{$OmediaContent}[0]->width;
				$dataImg[$i]['exth'][0]				= $value->{$OmediaGroup}->{$OmediaContent}[0]->height;
				
				if ($mediumT == 1) {
					// Medium
					$dataImg[$i]['extw'][1]				= $value->{$OmediaGroup}->{$OmediaThumbnail}[1]->width;
					$dataImg[$i]['exth'][1]				= $value->{$OmediaGroup}->{$OmediaThumbnail}[1]->height;
				}
				// Small
				$dataImg[$i]['extw'][2]				= $value->{$OmediaGroup}->{$OmediaThumbnail}[0]->width;
				$dataImg[$i]['exth'][2]				= $value->{$OmediaGroup}->{$OmediaThumbnail}[0]->height;
				
				// Complete the width and height here as all data large, small, medium are available
				// ksort is not needed here if $mediumT == 1 (medium is taken as thumbnail)
				if ($mediumT == 1) {
					$dataImg[$i]['extw']	= implode( ',', $dataImg[$i]['extw']);
					$dataImg[$i]['exth']	= implode( ',', $dataImg[$i]['exth']);
				}
				
				$dataImg[$i]['published']	= 1;
				$dataImg[$i]['approved']	= 1;
				$dataImg[$i]['catid']		= $catid;
				$i++;
			}
		}

		// Only in case the medium image cannot be taken from Picasa thumbnails
		// MEDIUM
		if ($mediumT == 0) {
			if ($authkey == ''){
				$albumAddressM	= 'http://picasaweb.google.com/data/feed/api/user/'.htmlentities($user).'/albumid/'.$albumId.'?alt=json&kind=photo'.$size['m'].$pagination;
			} else {
				$albumAddressM	= 'http://picasaweb.google.com/data/feed/api/user/'.htmlentities($user).'/albumid/'.$albumId.'?alt=json&kind=photo'.$size['m'].$pagination.'&authkey='.htmlentities($authkey);
			}
			$dataAlbumM 		= PhocaGalleryPicasa::loadDataByAddress($albumAddressM, 'album', $errorMsg);
			if($dataAlbumM == '') {
				$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_IMAGE');
				return false;
			}
			$dataAlbumM 	= json_decode($dataAlbumM);
			if (isset($dataAlbumM->feed->entry) && count($dataAlbumM->feed->entry) > 0) {
				$i = 0;
				foreach ($dataAlbumM->feed->entry as $key => $value) {

					
					$dataImg[$i]['extm']				= $value->content->src;
					// Medium
					$dataImg[$i]['extw'][1]				= $value->{$OmediaGroup}->{$OmediaContent}[0]->width;
					$dataImg[$i]['exth'][1]				= $value->{$OmediaGroup}->{$OmediaContent}[0]->height;
					
					// Complete the width and height here as NOT all data large, small, medium are available
					// ksort is needed here if $mediumT == 0 (medium is NOT taken as thumbnail)
					ksort($dataImg[$i]['extw']);
					ksort($dataImg[$i]['exth']);
					$dataImg[$i]['extw']	= implode( ',', $dataImg[$i]['extw']);
					$dataImg[$i]['exth']	= implode( ',', $dataImg[$i]['exth']);
					
					$i++;
				}
			}
		}
	
		if(count($dataImg) > 0) {
		
			if($this->storeimage($dataImg, $catid)) {
				return true;
			} else {
				$errorMsg = JText::_('PHOCAGALLERY_PICASA_IMAGE_SAVE_ERROR');
				return false;
			}
		} else {
			return false;
			$errorMsg = JText::_('PHOCAGALLERY_PICASA_NOT_LOADED_IMAGE');
		}
	}
	
	function storeimage($dataImg = array(), $catid) {
	
		if (count( $dataImg )) {
			
			// Before it remove all images so they can be updated
			// But not if pagination is used - pagination in progress
			if (!isset($_GET['picstart'])) {
				$query = "DELETE FROM #__phocagallery"
				. " WHERE catid = ".(int)$catid
				. " AND extid IS NOT NULL";
				$this->_db->setQuery( $query );
			}
			
		
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			
			$i = 0;
			
			foreach($dataImg as $data) {
				
				if (!isset($data['title']) || (isset($data['title']) && $data['title'] == '')) {
					$data['title'] = 'External Image '.$i;
				}
				
				if (!isset($data['alias']) || (isset($data['alias']) && $data['alias'] == '')) {
					$data['alias'] = $data['title'];
				}
				$data['alias'] 	= PhocaGalleryText::getAliasName($data['alias']);
				
				$data['catid']	= (int)$catid;
				
				$row =& $this->getTable('phocagallery');
				
				/*
				if(isset($data['id']) && $data['id'] > 0) {
					if (!$row->load($data['id'])) {
						$this->setError($this->_db->getErrorMsg());
						return false;
					}
				}*/

				// Bind the form fields to the Phoca gallery table
				if (!$row->bind($data)) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}

				// Create the timestamp for the date
				if (!$row->date) {
					$row->date = gmdate('Y-m-d H:i:s');
				}

				// if new item, order last in appropriate group
				if (!$row->id) {
					$where = 'catid = ' . (int) $row->catid ;
					$row->ordering = $row->getNextOrder( $where );
				}

				// Make sure the Phoca gallery table is valid
				if (!$row->check()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}

				// Store the Phoca gallery table to the database
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
				$i++;
			}
			return true;
		} else {
			return false;
		}
	
	}
	
	/*
	 * Owner
	 * Store information about Owner (if administrator add a category to some Owner)
	 */
	function storeOwnerCategory($data) {
		
		$row =& $this->getTable('phocagalleryuser');
		
		// Bind the form fields to the table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// if new item, order last in appropriate group
		if (!$row->id) {
		
			$row->ordering = $row->getNextOrder( );
		}
		
		
		// Make sure the table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $row->id;
	}
	
	/*
	 * Owner
	 * Get information about author's category
	 */
	function getOwnerCategoryData($userId) {

		$query = 'SELECT uc.*'
			. ' FROM #__phocagallery_user AS uc'
			. ' WHERE uc.userid = '.(int)$userId;
		
		$this->_db->setQuery( $query );
		$userCategoryData = $this->_db->loadObject();
		if (isset($userCategoryData->id)) {
			return $userCategoryData;
		}
		return false;
	}
}
?>