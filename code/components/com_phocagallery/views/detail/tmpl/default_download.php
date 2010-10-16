<?php defined('_JEXEC') or die('Restricted access');

$title			= $this->item->filename;
$imgLink		= JHTML::_( 'image.site', $this->item->filenameno, 'images/phocagallery/');
if (isset($this->item->extid) && $this->item->extid != '') {
	$title		= $this->item->title;
	$imgLink	= JHTML::_( 'image', $this->item->exto, '');
}

if ($this->tmpl['backbutton'] != '') {
	echo $this->tmpl['backbutton'];

	echo '<div id="download-box"><div style="overflow:scroll;width:'.$this->tmpl['boxlargewidth'].'px;height:'.$this->tmpl['boxlargeheight'].'px;margin:0px;padding:0px;">' . $imgLink . '</div>';
	echo '<div id="download-msg-nopopup"><div>'
		.'<table width="360">'
		.'<tr><td align="left">' . JText::_('Image Name') . ': </td><td>'.$title.'</td></tr>'
		.'<tr><td align="left">' . JText::_('Image Format') . ': </td><td>'.$this->item->imagesize.'</td></tr>'
		.'<tr><td align="left">' . JText::_('Image Size') . ': </td><td>'.$this->item->filesize.'</td></tr>';
				
	echo '<tr><td align="left"><a title="'. JText::_('Image Download').'" href="'. JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$this->item->catslug.'&id='.$this->item->slug.'&phocadownload=2'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'">'.JText::_('Image Download').'</a></td><td>&nbsp;</td>';

	echo '</table>';
	echo '</div></div>';
	
	
} else {

	echo '<div id="download-box"><div style="overflow:scroll;width:'.$this->tmpl['boxlargewidth'].'px;height:'.$this->tmpl['boxlargeheight'].'px;margin:0px;padding:0px;">' . $imgLink. '</div>';
	echo '<div id="download-msg"><div>'
		.'<table width="360">'
		.'<tr><td align="left">' . JText::_('Image Name') . ': </td><td>'.$title.'</td></tr>'
		.'<tr><td align="left">' . JText::_('Image Format') . ': </td><td>'.$this->item->imagesize.'</td></tr>'
		.'<tr><td align="left">' . JText::_('Image Size') . ': </td><td>'.$this->item->filesize.'</td></tr>'
		.'<tr><td colspan="2" align="left"><small>' . JText::_('Download Image') . '</small></td></tr>';
		
		if ($this->tmpl['detailwindow'] == 4 || $this->tmpl['detailwindow'] == 5 || $this->tmpl['detailwindow'] == 7) {
		} else {
			echo '<tr><td>&nbsp;</td><td align="right">'.str_replace("%onclickclose%", $this->tmpl['detailwindowclose'], $this->item->closetext).'</td></tr>';
		}
	echo '</table>';
	echo '</div></div>';
}
if ($this->tmpl['detailwindow'] == 7) {
	echo $this->tmpl['emt'];
}
?>