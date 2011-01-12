<?php
defined('_JEXEC') or die('Restricted access');
echo '<div id="phocagallery">';
if ($this->tmpl['backbutton'] != '') {
	echo $this->tmpl['backbutton'];
}

echo '<table border="0" style="width:'.$this->tmpl['boxlargewidth'].'px;height:'.$this->tmpl['boxlargeheight'].'px;">'
	.'<tr>'
	.'<td colspan="5" class="pgcenter" align="center" valign="middle">'
	.$this->item->videocode
	.'</td>'
	.'</tr>';
	
// Standard Description
if ($this->tmpl['displaydescriptiondetail'] == 1) {
	echo '<tr>'
	.'<td colspan="6" align="left" valign="top" height="'.$this->tmpl['descriptiondetailheight'].'">'
	.'<div style="font-size:'.$this->tmpl['fontsizedesc'].'px;'
	.'height:'.$this->tmpl['descriptiondetailheight'].'px;padding:0 20px 0 20px;'
	.'color:'. $this->tmpl['fontcolordesc'].'">'
	. $titleDesc . $this->item->description . '</div>'
	.'</td>'
	.'</tr>';
}

if ($this->tmpl['detailbuttons'] == 1){
	echo '<tr>'
	.'<td align="left" width="30%" style="padding-left:48px">'.$this->item->prevbutton.'</td>'
	.'<td align="center"></td>'
	.'<td align="center">'.str_replace("%onclickreload%", $this->tmpl['detailwindowreload'], $this->item->reloadbutton).'</td>';
	if ($this->tmpl['detailwindow'] == 4 || $this->tmpl['detailwindow'] == 5 || $this->tmpl['detailwindow'] == 7) {
	} else {	
		echo '<td align="center">' . str_replace("%onclickclose%", $this->tmpl['detailwindowclose'], $this->item->closebutton). '</td>';
	}
	echo '<td align="right" width="30%" style="padding-right:48px">'.$this->item->nextbutton.'</td>'
	.'</tr>';
}	
echo '</table>';
echo $this->loadTemplate('rating');
if ($this->tmpl['detailwindow'] == 7) {
	echo $this->tmpl['emt'];
}
echo '</div>';	
?>