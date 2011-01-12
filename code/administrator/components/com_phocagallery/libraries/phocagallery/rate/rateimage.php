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

class PhocaGalleryRateImage
{
	function updateVoteStatistics( $imgid ) {
		
		$db =& JFactory::getDBO();
		
		// Get AVG and COUNT
		$query = 'SELECT COUNT(vs.id) AS count, AVG(vs.rating) AS average'
				.' FROM #__phocagallery_img_votes AS vs'
			    .' WHERE vs.imgid = '.(int) $imgid;
		//		.' AND vs.published = 1';
		$db->setQuery($query, 0, 1);
		$votesStatistics = $db->loadObject();
		// if no count, set the average to 0
		if($votesStatistics->count == 0) {
			$votesStatistics->count = (int)0;
			$votesStatistics->average = (float)0;
		}
		
		if (isset($votesStatistics->count) && isset($votesStatistics->average)) {
			// Insert or update
			$query = 'SELECT vs.id AS id'
					.' FROM #__phocagallery_img_votes_statistics AS vs'
				    .' WHERE vs.imgid = '.(int) $imgid;
			$db->setQuery($query, 0, 1);
			$votesStatisticsId = $db->loadObject();
		
			// Yes, there is id (UPDATE) x No, there isn't (INSERT)
			if (!empty($votesStatisticsId->id)) {
			
				$query = 'UPDATE #__phocagallery_img_votes_statistics'
					.' SET count = ' .(int)$votesStatistics->count
					.' , average = ' .(float)$votesStatistics->average
				    .' WHERE imgid = '.(int) $imgid;
				$db->setQuery($query);
				
				if (!$db->query()) {
					$this->setError('Database Error Voting 1');
					return false;
				}
			
			} else {
			
				$query = 'INSERT into #__phocagallery_img_votes_statistics'
					.' (id, imgid, count, average)'
				    .' VALUES (null, '.(int)$imgid
					.' , '.(int)$votesStatistics->count
					.' , '.(float)$votesStatistics->average
					.')';
				$db->setQuery($query);
				
				if (!$db->query()) {
					$this->setError('Database Error Voting 2');
					return false;
				}
			
			}
		} else {
			return false;
		}
		return true;
	}
	
	function getVotesStatistics($id) {
	
		$db =& JFactory::getDBO();
		$query = 'SELECT vs.count AS count, vs.average AS average'
				.' FROM #__phocagallery_img_votes_statistics AS vs'
			    .' WHERE vs.imgid = '.(int) $id;
		$db->setQuery($query, 0, 1);
		$votesStatistics = $db->loadObject();
			
		return $votesStatistics;
	}
	
	function checkUserVote($imgid, $userid) {
		
		$db =& JFactory::getDBO();
		$query = 'SELECT v.id AS id'
			    .' FROM #__phocagallery_img_votes AS v'
			    .' WHERE v.imgid = '. (int)$imgid 
				.' AND v.userid = '. (int)$userid;
		$db->setQuery($query, 0, 1);
		$checkUserVote = $db->loadObject();
		if ($checkUserVote) {
			return true;
		}
		return false;
	}
}
?>