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

 defined('_JEXEC') or die('Restricted access');
jimport('joomla.filter.input');

class TablePhocaGalleryImgVotesStatistics extends JTable
{
	var $id 				= null;
	var $imgid	 			= null;
	var $count 				= null;
	var $average			= null;

	function __construct(& $db) {
		parent::__construct('#__phocagallery_img_votes_statistics', 'id', $db);
	}
}
?>