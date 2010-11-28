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

class PhocaGalleryRenderDetailButton
{
	var $_formaticon	= null;

	//php5
	/*function __construct() {
		$this->_setFormatIcon();
	}*/
	//php4
	function PhocaGalleryRenderDetailButton() {
		$this->_setFormatIcon();
	}

	function _setFormatIcon() {

		if (empty($this->_formaticon)) {
			phocagalleryimport('phocagallery.image.image');
			$this->_formaticon = &PhocaGalleryImage::getFormatIcon();
		}
		return true;

	}

	/*
	* Get the next button in Gallery - in opened window
	*/
	function getNext ($catid, $id, $ordering)  {

		global $mainframe;
		$db 			= &JFactory::getDBO();
		$params			= &$mainframe->getParams();
		$detailWindow	= $params->get( 'detail_window', 0 );
		if ($detailWindow == 7) {
			$tmplCom = '';
		} else {
			$tmplCom = '&tmpl=component';
		}

		//Select all ids from db_gallery - we search for next_id (!!! next_id can be id without file
		//in the server. If the next id has no file in the server we must go from next_id to next next_id
		$query = 'SELECT a.id, filename as filename,'
				.' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as catslug,'
				.' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug'
				.' FROM #__phocagallery AS a'
				.' LEFT JOIN #__phocagallery_categories AS c ON c.id = a.catid'
				.' WHERE a.catid = ' . (int)$catid
				.' AND a.ordering > '.(int)$ordering
				.' AND a.published = 1'
				.' ORDER BY a.ordering ASC';
		$db->setQuery($query);
		$nextAll = $db->loadObjectList();

		$next = JHTML::_('image', 'components/com_phocagallery/assets/images/icon-next-grey.' . $this->_formaticon, JText::_( 'Next image' ));//non-active button will be displayed as default, we will see if we find active link
		foreach ($nextAll as $key => $value) {

			// Is there some next id, if not end this and return grey link
			if (isset($value->id) && $value->id > 0) {

				$next = '<a href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='. $value->catslug.'&id='.$value->slug.$tmplCom.'&Itemid='. JRequest::getVar('Itemid', 1, 'get', 'int')).'"'
				.' title="'.JText::_( 'Next image' ).'" id="next" onclick="disableBackAndNext()" >'
				. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-next.' . $this->_formaticon, JText::_( 'Next image' )).'</a>';
				break;// end it, we must need not to find next ordering

			} else {
				$next = JHTML::_('image', 'components/com_phocagallery/assets/images/icon-next-grey.' . $this->_formaticon, JText::_( 'Next image' ));
				break;// end it, we must need not to find next ordering
			}
		}
		return $next;
	}

	  /*
	* Get the prev button in Gallery - in openwindow
	*/
	function getPrevious ($catid, $id, $ordering) {

		global $mainframe;
		$db 			= &JFactory::getDBO();
		$params			= &$mainframe->getParams();
		$detailWindow	= $params->get( 'detail_window', 0 );
		if ($detailWindow == 7) {
			$tmplCom = '';
		} else {
			$tmplCom = '&tmpl=component';
		}

		//Select all ids from db_gallery - we search for next_id (!!! next_id can be id without file
		//in the server. If the next id has no file in the server we must go from next_id to next next_id
		$query = 'SELECT a.id, filename as filename,'
				.' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as catslug,'
				.' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug'
				.' FROM #__phocagallery AS a'
				.' LEFT JOIN #__phocagallery_categories AS c ON c.id = a.catid'
				.' WHERE a.catid = ' . (int)$catid
				.' AND a.ordering < '.(int)$ordering
				.' AND a.published = 1'
				.' ORDER BY a.ordering DESC';
		$db->setQuery($query);
		$prevAll = $db->loadObjectList();

		$prev = JHTML::_('image', 'components/com_phocagallery/assets/images/icon-prev-grey.' . $this->_formaticon, JText::_( 'Previous image' ));//non-active button will be displayed as default, we will see if we find active link
		foreach ($prevAll as $key => $value) {

			// Is there some next id, if not end this and return grey link
			if (isset($value->id) && $value->id > 0) {

				$prev = '<a href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='. $value->catslug.'&id='.$value->slug.$tmplCom.'&Itemid='. JRequest::getVar('Itemid', 1, 'get', 'int')).'"'
				.' title="'.JText::_( 'Previous image' ).'" id="prev" onclick="disableBackAndPrev()" >'
				.JHTML::_('image', 'components/com_phocagallery/assets/images/icon-prev.' . $this->_formaticon, JText::_( 'Previous image' )).'</a>';
				break;// end it, we must need not to find next ordering

			} else {
				$prev = JHTML::_('image', 'components/com_phocagallery/assets/images/icon-next-grey.' . $this->_formaticon, JText::_( 'Next image' ));
				break;// end it, we must need not to find next ordering
			}
		}
		return $prev;
	}

	function getReload($catidSlug, $idSlug) {

		global $mainframe;
		$params			= &$mainframe->getParams();
		$detailWindow	= $params->get( 'detail_window', 0 );
		if ($detailWindow == 7) {
			$tmplCom = '';
		} else {
			$tmplCom = '&tmpl=component';
		}

		$reload =  '<a href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$catidSlug.'&id='.$idSlug.$tmplCom.'&Itemid='. JRequest::getVar('Itemid', 1, 'get', 'int')).'" onclick="%onclickreload%" title="'.JText::_( 'Refresh' ).'" >'.JHTML::_('image', 'components/com_phocagallery/assets/images/icon-reload.' . $this->_formaticon, JText::_( 'Refresh' )).'</a>';

		return $reload;
	}

	function getClose($catidSlug, $idSlug) {
		global $mainframe;
		$params			= &$mainframe->getParams();
		$detailWindow	= $params->get( 'detail_window', 0 );
		if ($detailWindow == 7) {
			return '';
		}

		$close =  '<a href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$catidSlug.'&id='.$idSlug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 1, 'get', 'int')).'" onclick="%onclickclose%" title="'.JText::_( 'Close window').'" >'. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-exit.' . $this->_formaticon, JText::_( 'Close window' )).'</a>';

		return $close;
	}

	function getCloseText($catidSlug, $idSlug) {
		global $mainframe;
		$params			= &$mainframe->getParams();
		$detailWindow	= $params->get( 'detail_window', 0 );
		if ($detailWindow == 7) {
			return '';
		}
		$close =  '<a style="text-decoration:underline" href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$catidSlug.'&id='.$idSlug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 1, 'get', 'int')).'" onclick="%onclickclose%" title="'.JText::_( 'Close window').'" >'. JText::_( 'Close window' ).'</a>';

		return $close;
	}

	/*
	* Get Slideshow  - 1. data for javascript, 2. data for displaying buttons
	*/
	function getJsSlideshow($catid, $id, $slideshow = 0, $catidSlug, $idSlug) {

		jimport('joomla.filesystem.file');
		phocagalleryimport('phocagallery.file.filethumbnail');
		global $mainframe;
		$db 				= &JFactory::getDBO();
		$params				= &$mainframe->getParams();
		$image_ordering		= $params->get( 'image_ordering', 1 );
		$imageOrdering 		= PhocaGalleryOrdering::getOrderingString($image_ordering);
		$detailWindow		= $params->get( 'detail_window', 0 );
		if ($detailWindow == 7) {
			$tmplCom = '';
		} else {
			$tmplCom = '&tmpl=component';
		}

		// 1. GET DATA FOR JAVASCRIPT
		$jsSlideshowData['files'] = '';

		$votes	= ' ORDER BY a.';
			switch ($imageOrdering) {
			  case 'count ASC':
				$votes	= ' ORDER BY r.';
				break;
			  case 'count DESC':
				$votes	= ' ORDER BY r.';
				break;
			  case 'average ASC':
				$votes	= ' ORDER BY r.';
				break;
			  case 'average DESC':
				$votes	= ' ORDER BY r.';
				break;
			  default:
				$votes	= ' ORDER BY a.';
			}

		//Get filename of all photos
		/*$query = 'SELECT a.filename, a.extl, r.count as count, r.average as average'
		.' FROM #__phocagallery as a'
		.' LEFT JOIN #__phocagallery_img_votes_statistics AS r ON r.imgid = a.id'
		.' WHERE a.catid='.(int) $catid
		.' AND a.published = 1 AND a.approved = 1'
		.$votes.$imageOrdering;*/

		$query = 'SELECT a.filename, a.extl'
		.' FROM #__phocagallery as a'
		.' WHERE a.catid='.(int) $catid
		.' AND a.published = 1 AND a.approved = 1'
		.' ORDER by a.ordering';

		$db->setQuery($query);
		$filenameAll = $db->loadObjectList();
		$countImg = 0;
		if (!empty($filenameAll)) {

			foreach ($filenameAll as $key => $value) {

				if (isset($value->extl) && $value->extl != '') {
					$jsSlideshowData['files'] .= 'fadeimages['.$countImg.']=["'. $value->extl .'", "", ""];'."\n";
				} else {
					$fileThumbnail 	= PhocaGalleryFileThumbnail::getThumbnailName($value->filename, 'large');
					$imgLink		= JURI::root(false, '').$fileThumbnail->rel;
					if (JFile::exists($fileThumbnail->abs)) {
						$jsSlideshowData['files'] .= 'fadeimages['.$countImg.']=["'. $imgLink .'", "", ""];'."\n"; ;
					} else {
						$fileThumbnail = JURI::base(true).'/' . "components/com_phocagallery/assets/images/phoca_thumb_l_no_image." . $this->_formaticon;
						$jsSlideshowData['files'] .= 'fadeimages['.$countImg.']=["'.$fileThumbnail.'", "", ""];'."\n"; ;
					}
				}


				$countImg++;
			}
		}

		// 2. GET DATA FOR DISPLAYING SLIDESHOW BUTTONS
		//We can display slideshow option if there is more than one foto
		//But in database there can be more photos - more rows but if file is in db but it doesn't exist, we don't count it
		//$countImg = SQLQuery::selectOne($mdb2, "SELECT COUNT(*) FROM $db_gallery WHERE siteid=$id");
		if ($countImg > 1) {
			//Data from GET['slideshow']
			if ($slideshow==1) {

				$jsSlideshowData['icons'] = '<a href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$catidSlug.'&id='.$idSlug.$tmplCom.'&phocaslideshow=0'.'&Itemid='. JRequest::getVar('Itemid', 1, 'get', 'int')).'" title="'.JText::_( 'Stop slideshow' ).'" >'
				.JHTML::_('image', 'components/com_phocagallery/assets/images/icon-stop.' . $this->_formaticon, JText::_( 'Stop slideshow' )).'</a>'
				.'</td><td align="center">'//.'&nbsp;'
				.JHTML::_('image', 'components/com_phocagallery/assets/images/icon-play-grey.' . $this->_formaticon, JText::_( 'Start slideshow' ));
			} else {
				$jsSlideshowData['icons'] = JHTML::_('image', 'components/com_phocagallery/assets/images/icon-stop-grey.' . $this->_formaticon, JText::_( 'Stop slideshow' ))
				.'</td><td align="center">'//.'&nbsp;'
				.'<a href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$catidSlug.'&id='.$idSlug.'&phocaslideshow=1'.$tmplCom.'&Itemid='. JRequest::getVar('Itemid', 1, 'get', 'int')).'" title="'.JText::_( 'Start slideshow' ).'">'
				. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-play.' . $this->_formaticon, JText::_( 'Start slideshow' )).'</a>';
			}
		} else {
			$jsSlideshowData['icons'] = '';
		}

		return $jsSlideshowData;//files (javascript) and icons (buttons)
	}

}
?>