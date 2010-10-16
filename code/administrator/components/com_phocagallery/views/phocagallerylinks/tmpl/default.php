<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');

echo '<div id="phocagallery-links">'
.'<fieldset class="adminform">'
.'<legend>'.JText::_( 'Select Type' ).'</legend>'
.'<ul>'
.'<li class="icon-16-edb-categories"><a href="'.$this->tmpl['categories'].'">'.JText::_('Categories').'</a></li>'
//.'<li class="icon-16-edb-category"><a href="'.$this->tmpl['category'].'">'.JText::_('Category').'</a></li>'
.'<li class="icon-16-edb-images"><a href="'.$this->tmpl['images'].'">'.JText::_('Images').'</a></li>'
.'<li class="icon-16-edb-image"><a href="'.$this->tmpl['image'].'">'.JText::_('Image').'</a></li>'
.'<li class="icon-16-edb-switchimage"><a href="'.$this->tmpl['switchimage'].'">'.JText::_('Switch Image').'</a></li>'
.'<li class="icon-16-edb-slideshow"><a href="'.$this->tmpl['slideshow'].'">'.JText::_('Slideshow').'</a></li>'
.'</ul>'
.'</div>'
.'</fieldset>'
.'</div>';
?>