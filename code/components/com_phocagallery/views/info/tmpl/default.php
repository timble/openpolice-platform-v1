<?php defined('_JEXEC') or die('Restricted access');
if ($this->tmpl['backbutton'] != '') {
	echo $this->tmpl['backbutton'];
}
echo '<div id="phocaexif" >'
.'<h2>'.JText::_('EXIF Information').':</h2>'
.'<table style="width:90%">'
.$this->infooutput
.'</table>'
.'</div>';
if ($this->tmpl['detailwindow'] == 7) {
	echo $this->tmpl['stm'];
}
