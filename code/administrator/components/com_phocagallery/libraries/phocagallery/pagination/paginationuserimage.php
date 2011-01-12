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

jimport('joomla.html.pagination');
class PhocaGalleryPaginationUserImage extends JPagination
{
	var $_tabId;
	
	function setTab($tabId) {
		$this->_tabId = (int)$tabId;
	}
	
	function _buildDataObject()
	{
		$tabLink = '';
		if ((int)$this->_tabId > 0) {
			$tabLink = '&tab='.(int)$this->_tabId;
		}
		
		// Initialize variables
		$data = new stdClass();

		$data->all	= new JPaginationObject(JText::_('View All'));
		if (!$this->_viewall) {
			$data->all->base	= '0';
			$data->all->link	= JRoute::_($tabLink."&limitstartimage=");
		}

		// Set the start and previous data objects
		$data->start	= new JPaginationObject(JText::_('Start'));
		$data->previous	= new JPaginationObject(JText::_('Prev'));

		if ($this->get('pages.current') > 1)
		{
			$page = ($this->get('pages.current') -2) * $this->limit;

			$page = $page == 0 ? '' : $page; //set the empty for removal from route

			$data->start->base	= '0';
			$data->start->link	= JRoute::_($tabLink."&limitstartimage=");
			$data->previous->base	= $page;
			$data->previous->link	= JRoute::_($tabLink."&limitstartimage=".$page);
		}

		// Set the next and end data objects
		$data->next	= new JPaginationObject(JText::_('Next'));
		$data->end	= new JPaginationObject(JText::_('End'));

		if ($this->get('pages.current') < $this->get('pages.total'))
		{
			$next = $this->get('pages.current') * $this->limit;
			$end  = ($this->get('pages.total') -1) * $this->limit;

			$data->next->base	= $next;
			$data->next->link	= JRoute::_($tabLink."&limitstartimage=".$next);
			$data->end->base	= $end;
			$data->end->link	= JRoute::_($tabLink."&limitstartimage=".$end);
		}

		$data->pages = array();
		$stop = $this->get('pages.stop');
		for ($i = $this->get('pages.start'); $i <= $stop; $i ++)
		{
			$offset = ($i -1) * $this->limit;

			$offset = $offset == 0 ? '' : $offset;  //set the empty for removal from route

			$data->pages[$i] = new JPaginationObject($i);
			if ($i != $this->get('pages.current') || $this->_viewall)
			{
				$data->pages[$i]->base	= $offset;
				$data->pages[$i]->link	= JRoute::_($tabLink."&limitstartimage=".$offset);
			}
		}
		return $data;
	}
	
	function getLimitBox()
	{
		global $mainframe;

		// Initialize variables
		$limits = array ();

		// Make the option list
		for ($i = 5; $i <= 30; $i += 5) {
			$limits[] = JHTML::_('select.option', "$i");
		}
		$limits[] = JHTML::_('select.option', '50');
		$limits[] = JHTML::_('select.option', '100');
		$limits[] = JHTML::_('select.option', '0', JText::_('all'));

		$selected = $this->_viewall ? 0 : $this->limit;

		// Build the select list
		if ($mainframe->isAdmin()) {
			$html = JHTML::_('select.genericlist',  $limits, 'limitimage', 'class="inputbox" size="1" onchange="submitform();"', 'value', 'text', $selected);
		} else {
			$html = JHTML::_('select.genericlist',  $limits, 'limitimage', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $selected);
		}
		return $html;
	}
	
	function orderUpIcon($i, $condition = true, $task = '#', $alt = 'Move Up', $enabled = true) {
		
		$formatIcon = PhocaGalleryImage::getFormatIcon();
		$alt = JText::_($alt);
		

		$html = '&nbsp;';
		if (($i > 0 || ($i + $this->limitstart > 0)) && $condition)
		{
			if($enabled) {
				$html	= '<a href="'.$task.'" title="'.$alt.'">';
				$html	.= '   <img src="'.JURI::base(true).'/components/com_phocagallery/assets/images/icon-uparrow.'.$formatIcon.'" width="16" height="16" border="0" alt="'.$alt.'" />';
				$html	.= '</a>';
			} else {
				$html	= '<img src="'.JURI::base(true).'/components/com_phocagallery/assets/images/icon-uparrow0.'.$formatIcon.'" width="16" height="16" border="0" alt="'.$alt.'" />';
			}
		}

		return $html;
	}


	function orderDownIcon($i, $n, $condition = true, $task = '#', $alt = 'Move Down', $enabled = true){
		$formatIcon = PhocaGalleryImage::getFormatIcon();
		$alt = JText::_($alt);

		$html = '&nbsp;';
		if (($i < $n -1 || $i + $this->limitstart < $this->total - 1) && $condition)
		{
			if($enabled) {
				$html	= '<a href="'.$task.'" title="'.$alt.'">';
				$html	.= '  <img src="'.JURI::base(true).'/components/com_phocagallery/assets/images/icon-downarrow.'.$formatIcon.'" width="16" height="16" border="0" alt="'.$alt.'" />';
				$html	.= '</a>';
			} else {
				$html	= '<img src="'.JURI::base(true).'/components/com_phocagallery/assets/images/icon-downarrow0.'.$formatIcon.'" width="16" height="16" border="0" alt="'.$alt.'" />';
			}
		}

		return $html;
	}
}
?>