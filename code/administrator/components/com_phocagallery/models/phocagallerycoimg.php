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

class PhocaGalleryCpModelPhocaGalleryCoImg extends JModel
{
	function __construct() {
		parent::__construct();
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id) {
		$this->_id				= $id;
		$this->_data			= null;
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
			$phocagallery = & $this->getTable('phocagallerycommentimgs');
			if(! $phocagallery->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}

	function checkout($uid = null) {
		if ($this->_id) {
			// Make sure we have a user id to checkout the article with
			if (is_null($uid)) {
				$user	=& JFactory::getUser();
				$uid	= $user->get('id');
			}
			// Lets get to it and checkout the thing...
			$phocagallery = & $this->getTable('phocagallerycommentimgs');
			if(!$phocagallery->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}
	

	function store($data) {
			
		//If there is no title and no alias, use filename as title and alias
		if ($data['title'] == '') {
			$data['title'] = '-';
		}
		
		$row =& $this->getTable('phocagallerycommentimgs');

		// Bind the form fields to the Phoca gallery table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Create the timestamp for the date
		if ($row->date =='') {
			$row->date = gmdate('Y-m-d H:i:s');
		}

		// if new item, order last in appropriate group
		if (!$row->id) {
			$where = 'imgid = ' . (int) $row->imgid ;
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
		return true;
	}

	function delete($cid = array()) {
		
		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'DELETE FROM #__phocagallery_img_comments'
				. ' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	function publish($cid = array(), $publish = 1) {
		$user 	=& JFactory::getUser();

		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__phocagallery_img_comments'
				. ' SET published = '.(int) $publish
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
		$row =& $this->getTable('phocagallerycommentimgs');
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->move( $direction, ' imgid = '.(int) $row->imgid.' AND published >= 0 ' )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}


	function saveorder($cid = array(), $order) {
		$row =& $this->getTable('phocagallerycommentimgs');
		$groupings = array();

		// update ordering values
		for( $i=0; $i < count($cid); $i++ )
		{
			$row->load( (int) $cid[$i] );
			// track categories
			$groupings[] = $row->imgid;

			if ($row->ordering != $order[$i])
			{
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
			$row->reorder('imgid = '.(int) $group);
		}

		return true;
	}
	
	function _loadData() {
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = 'SELECT co.*, a.title AS imgtitle, u.username as commentusername, u.name AS commentname, '.
					' a.published AS img_pub'.
					' FROM #__phocagallery_img_comments AS co' .
					' LEFT JOIN #__phocagallery AS a ON a.id = co.imgid' .
					' LEFT JOIN #__users AS u ON u.id = co.userid' .
					' WHERE co.id = '.(int) $this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}
	
	function _initData() {

		if (empty($this->_data)) {
			$phocagallery = new stdClass();
			$phocagallery->id				= 0;
			$phocagallery->imgid			= 0;
			$phocagallery->userid			= 0;
			$phocagallery->date				= null;
			$phocagallery->title			= null;
			$phocagallery->comment			= null;
			$phocagallery->published		= 0;
			$phocagallery->checked_out		= 0;
			$phocagallery->checked_out_time	= 0;
			$phocagallery->ordering			= 0;
			$phocagallery->params			= null;
			$phocagallery->category			= null;
			$this->_data					= $phocagallery;
			return (boolean) $this->_data;
		}
		return true;
	}
}
?>