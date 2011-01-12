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

class TablePhocaGalleryUser extends JTable
{

	var $id 				= null;
	var $userid 			= null;
	var $avatar 			= null;
	var $published 			= null;
	var $approved 			= 0;
	var $checked_out 		= 0;
	var $checked_out_time 	= 0;
	var $ordering 			= null;
	var $params 			= null;

	function __construct(& $db) {
		parent::__construct('#__phocagallery_user', 'id', $db);
	}
}
?>