<?php defined('_JEXEC') or die('Restricted access');
echo '<div id="phocagallery">';
if ($this->tmpl['backbutton'] != '') {
	echo $this->tmpl['backbutton'];
}

echo '<center style="padding-top:10px">'
	.'<table border="0" width="100%">'
	.'<tr>'
	.'<td colspan="6" align="center" valign="middle" height="'.$this->tmpl['largeheight'].'"'
	.' style="height:'.$this->tmpl['largeheight'].'px" >'
	.'<div id="image-box" style="width:'.$this->item->realimagewidth.'px;margin: auto;padding: 0;">'
	.'<a href="#" onclick="'.$this->tmpl['detailwindowclose'].'">'.$this->item->linkimage.'</a>';
			
$titleDesc = '';
if ($this->tmpl['displaytitleindescription'] == 1) {
	$titleDesc .= $this->item->title;
	if ($this->item->description != '' && $titleDesc != '') {
		$titleDesc .= ' - ';
	}
}
			
// Lightbox Description
if ($this->tmpl['displaydescriptiondetail'] == 2 && (!empty($this->item->description) || !empty($titleDesc))){

	echo '<div id="description-msg" style="background:'.$this->tmpl['descriptionlightboxbgcolor'].'">'
    .'<div id="description-text" style="background:'.$this->tmpl['descriptionlightboxbgcolor']
	.';color:'.$this->tmpl['descriptionlightboxfontcolor']
	.';font-size:'.$this->tmpl['descriptionlightboxfontsize'].'px">'
	//. $titleDesc . $this->item->description.'</div></div>';
	.(JHTML::_('content.prepare', $titleDesc . $this->item->description)).'</div></div>';
}

echo '</div>'
	 .'</td>'
	 .'</tr>';
	
// Standard Description
if ($this->tmpl['displaydescriptiondetail'] == 1) {
	echo '<tr>'
	.'<td colspan="6" align="left" valign="top" height="'.$this->tmpl['descriptiondetailheight'].'">'
	.'<div style="font-size:'.$this->tmpl['fontsizedesc'].'px;'
	.'height:'.$this->tmpl['descriptiondetailheight'].'px;padding:0 20px 0 20px;'
	.'color:'. $this->tmpl['fontcolordesc'].'">'
	//. $titleDesc . $this->item->description . '</div>'
	.(JHTML::_('content.prepare', $titleDesc . $this->item->description)). '</div>'
	.'</td>'
	.'</tr>';
}

if ($this->tmpl['detailbuttons'] == 1){
	echo '<tr>'
	.'<td align="left" width="30%" style="padding-left:48px">'.$this->item->prevbutton.'</td>'
	.'<td align="center">'.$this->item->slideshowbutton.'</td>'
	.'<td align="center">'.str_replace("%onclickreload%", $this->tmpl['detailwindowreload'], $this->item->reloadbutton).'</td>';
	if ($this->tmpl['detailwindow'] == 4 || $this->tmpl['detailwindow'] == 5 || $this->tmpl['detailwindow'] == 7) {
	} else {	
		echo '<td align="center">' . str_replace("%onclickclose%", $this->tmpl['detailwindowclose'], $this->item->closebutton). '</td>';
	}
	echo '<td align="right" width="30%" style="padding-right:48px">'.$this->item->nextbutton.'</td>'
	.'</tr>';
}

echo '</table></center>';
echo $this->loadTemplate('rating');
if ($this->tmpl['detailwindow'] == 7) {

	if (JComponentHelper::isEnabled('com_jcomments', true) && $this->tmpl['externalcommentsystem'] == 1) {
		include_once(JPATH_BASE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php');
		echo JComments::showComments(  $this->item->id, 'com_phocagallery_images', JText::_('PHOCAGALLERY_IMAGE') .' '. $this->item->title);
	}


	echo $this->tmpl['emt'];
}
echo '</div>';
?>