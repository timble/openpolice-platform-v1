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
defined('_JEXEC') or die('Restricted access');

class TablePhocaGalleryc extends JTable {

	var $id 				= null;
	var $parent_id 			= null;
	var $owner_id 			= null;
	var $title 				= null;
	var $name 				= null;
	var $alias 				= null;
	var $image	 			= null;
	var $section 			= null;
	var $image_position		= null;
	var $description		= null;
	var $date				= null;
	var $published			= null;
	var $approved			= 0;
	var $checked_out 		= 0;
	var $checked_out_time 	= 0;
	var $editor				= null;
	var $ordering 			= null;
	var $access				= null;
	var $hits				= null;
	var $count 				= null;
	var $accessuserid		= null;
	var $uploaduserid		= null;
	var $deleteuserid		= null;
	var $userfolder			= null;
	var $latitude			= null;
	var $longitude			= null;
	var $zoom				= null;
	var $geotitle			= null;
	var $params 			= null;
	var $metakey 			= null;
	var $metadesc 			= null;
	var $extid				= null;
	var $exta				= null;
	var $extu				= null;
	var $extauth			= null;

	function __construct(& $db) {
		parent::__construct('#__phocagallery_categories', 'id', $db);
	}
}
?>