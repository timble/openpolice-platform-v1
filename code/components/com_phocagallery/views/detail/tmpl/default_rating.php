<?php defined('_JEXEC') or die('Restricted access');
$amp = PhocaGalleryUtils::setQuestionmarkOrAmp($this->tmpl['action']);

if ((int)$this->tmpl['displayratingimg'] == 1) {
	// Leave message for already voted images
	$vote = JRequest::getVar('vote', 0, '', 'int');
	if ($vote == 1) {
		$voteMsg = JText::_('PHOCA GALLERY IMAGE RATED');
	} else {
		$voteMsg = JText::_('You have already rated this image');
	}

	echo '<table style="text-align:left" border="0">'
		.'<tr>'
		.'<td><strong>' . JText::_('Rating'). '</strong>: ' . $this->tmpl['votesaverageimg'] .' / '.$this->tmpl['votescountimg'] . ' ' . JText::_($this->tmpl['votestextimg']). '&nbsp;&nbsp;</td>';
		
	if ($this->tmpl['alreadyratedimg']) {
		echo '<td style="text-align:left"><ul class="star-rating">'
			.'<li class="current-rating" style="width:'.$this->tmpl['voteswidthimg'].'px"></li>'
			.'<li><span class="star1"></span></li>';

		for ($i = 2;$i < 6;$i++) {
			echo '<li><span class="stars'.$i.'"></span></li>';
		}
		echo '</ul></td>'
			.'<td style="text-align:left" colspan="4">&nbsp;&nbsp;'.$voteMsg.'</td></tr>';
			
	} else if ($this->tmpl['notregisteredimg']) {

		echo '<td style="text-align:left"><ul class="star-rating">'
			.'<li class="current-rating" style="width:'.$this->tmpl['voteswidthimg'].'px"></li>'
			.'<li><span class="star1"></span></li>';

		for ($i = 2;$i < 6;$i++) {
			echo '<li><span class="stars'.$i.'"></span></li>';
		}
		echo '</ul></td>'
			.'<td style="text-align:left" colspan="4">&nbsp;&nbsp;'.JText::_('Only registered and logged in user can rate this image').'</td></tr>';
			
	} else {
		
		echo '<td style="text-align:left"><ul class="star-rating">'
			.'<li class="current-rating" style="width:'.$this->tmpl['voteswidthimg'].'px"></li>'
			.'<li><a href="'.$this->tmpl['action'].$amp.'controller=detail&task=rate&rating=1" title="1 '. JText::_('star out of').' 5" class="star1">1</a></li>';
		
		for ($i = 2;$i < 6;$i++) {
			echo '<li><a href="'.$this->tmpl['action'].$amp.'controller=detail&task=rate&rating='.$i.'" title="'.$i.' '. JText::_('star out of').' 5" class="stars'.$i.'">'.$i.'</a></li>';
		}
		echo '</ul></td></tr>';
	}
	echo '</table>';
}
?>
