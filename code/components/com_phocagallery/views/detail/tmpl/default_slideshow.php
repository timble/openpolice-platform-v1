<?php defined('_JEXEC') or die('Restricted access');
echo '<div id="phocagallery">';
if ($this->tmpl['backbutton'] != '') {
	echo $this->tmpl['backbutton'];
}

echo '<center style="padding-top:10px;">'
.'<table border="0" width="100%">'
.'<tr>'
.'<td colspan="6" align="center" valign="middle" height="'.$this->tmpl['largeheight'].'"'
.' style="height:'.$this->tmpl['largeheight'].'px" >';

echo '<div id="image-box" style="width:'. $this->tmpl['largewidth'].'px;">'

//.'<a href="#" onclick="'.$this->tmpl['detailwindowclose'].'">'.$this->item->linkimage.'</a>';
.'<script type="text/javascript" style="padding:0;margin:0;">';			
if ( $this->tmpl['slideshowrandom'] == 1 ) {
	echo 'new fadeshow(fadeimages, '.$this->tmpl['largewidth'] .', '. $this->tmpl['largeheight'] .', 0, '. $this->tmpl['slideshowdelay'] .', '. $this->tmpl['slideshowpause'] .', \'R\')';		
} else {						
	echo 'new fadeshow(fadeimages, '.$this->tmpl['largewidth'] .', '. $this->tmpl['largeheight'] .', 0, '. $this->tmpl['slideshowdelay'] .', '. $this->tmpl['slideshowpause'] .')';		
}
echo '</script>';

echo '</div>';
echo '</td>'
.'</tr>';
		
echo '<tr>'
.'<td align="left" width="30%" style="padding-left:48px">'. $this->item->prevbutton .'</td>'
.'<td align="center">'. $this->item->slideshowbutton .'</td>'
.'<td align="center">'. str_replace("%onclickreload%", $this->tmpl['detailwindowreload'], $this->item->reloadbutton).'</td>';
if ($this->tmpl['detailwindow'] == 4 || $this->tmpl['detailwindow'] == 5 || $this->tmpl['detailwindow'] == 7) {
} else {
	echo '<td align="center">'. str_replace("%onclickclose%", $this->tmpl['detailwindowclose'], $this->item->closebutton).'</td>';
}
echo '<td align="right" width="30%" style="padding-right:48px">'. $this->item->nextbutton .'</td>'
.'</tr>'
.'</table>'
.'</center>';

if ($this->tmpl['detailwindow'] == 7) {
	echo $this->tmpl['emt'];
}
echo '</div>';