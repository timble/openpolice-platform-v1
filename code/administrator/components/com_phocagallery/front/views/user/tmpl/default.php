<?php defined('_JEXEC') or die('Restricted access'); 

$heading = '';
if ($this->params->get( 'page_title' ) != '') {
	$heading .= $this->params->get( 'page_title' );
}

if ($this->tmpl['showpagetitle'] != 0) {
	if ( $heading != '') {
	    echo '<div class="componentheading'.$this->params->get( 'pageclass_sfx' ).'">'
	        .$heading
			.'</div>';
	} 
}
$tab = 0;
switch ($this->tmpl['tab']) {
	case 'up':
		$tab = 1;
	break;
	
	case 'cc':
	default:
		$tab = 0;
	break;
}

echo '<div>&nbsp;</div>';

if ($this->tmpl['displaytabs'] > 0) {
	echo '<div id="phocagallery-pane">';
	$pane =& JPane::getInstance('Tabs', array('startOffset'=> $this->tmpl['tab']));
	echo $pane->startPane( 'pane' );


	echo $pane->startPanel( JHTML::_( 'image.site', $this->tmpl['pi'].'icon-user.'.$this->tmpl['fi'],'', '', '', '', '') . '&nbsp;'.JText::_('PHOCAGALLERY_USER'), 'user' );
	echo $this->loadTemplate('user');
	echo $pane->endPanel();
	
	
	echo $pane->startPanel( JHTML::_( 'image.site', $this->tmpl['pi'].'icon-folder-small.'.$this->tmpl['fi'],'', '', '', '', '') . '&nbsp;'.$this->tmpl['categorycreateoredithead'], 'category' );
	echo $this->loadTemplate('category');
	echo $pane->endPanel();

	echo $pane->startPanel( JHTML::_( 'image.site', $this->tmpl['pi'].'icon-subcategories.'.$this->tmpl['fi'],'', '', '', '', '') . '&nbsp;'.JText::_('PHOCAGALLERY_SUBCATEGORIES'), 'subcategories' );
	echo $this->loadTemplate('subcategories');
	echo $pane->endPanel();

	echo $pane->startPanel( JHTML::_( 'image.site', $this->tmpl['pi'].'icon-images.'.$this->tmpl['fi'],'', '', '', '', '') . '&nbsp;'.JText::_('PHOCAGALLERY_IMAGES'), 'images' );
	echo $this->loadTemplate('images');
	echo $pane->endPanel();


	echo $pane->endPane();
	echo '</div>';
}
echo '<div>&nbsp;</div>';
echo $this->tmpl['om'];
?>
