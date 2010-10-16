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

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TablePhocaGallery extends JTable
{

	var $id 				= null;
	var $catid 				= null;
	var $sid 				= null;
	var $title 				= null;
	var $alias 				= null;
	var $filename 			= null;
	var $description 		= null;
	var $date 				= null;
	var $hits 				= null;
	var $latitude			= null;
	var $longitude			= null;
	var $zoom				= null;
	var $geotitle			= null;
	var $videocode			= null;
	var $vmproductid		= null;
	var $imgorigsize		= null;
	var $published 			= null;
	var $approved 			= 0;
	var $checked_out 		= 0;
	var $checked_out_time 	= 0;
	var $ordering 			= null;
	var $params 			= null;
	var $metakey 			= null;
	var $metadesc 			= null;
	var $extlink1	 		= null;
	var $extlink2			= null;
	var $extid				= null;
	var $extl				= null;
	var $extm				= null;
	var $exts				= null;
	var $exto				= null;
	var $extw				= null;
	var $exth				= null;

	function __construct(& $db) {
		parent::__construct('#__phocagallery', 'id', $db);
	}
}
?>