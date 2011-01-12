<?php
defined('_JEXEC') or die('Restricted access');
phocagalleryimport('phocagallery.render.rendermap');
?>
<!-- <div><a>www.phoca.cz - Begin Categories -->
<?php
if ( $this->params->def( 'show_page_title', 1 ) ) {
   echo '<div class="componentheading'.$this->params->get( 'pageclass_sfx' ).'">'.$this->params->get('page_title').'</div>';
} 
echo '<div id="phocagallery">';
if ($this->tmplGeo['categorieslng'] == '' || $this->tmplGeo['categorieslat'] == '') {
	echo '<p>' . JText::_('Google Maps Error Front') . '</p>';
} else {
	echo '<script src="http://www.google.com/jsapi" type="text/javascript"></script>';
	echo '<noscript>'.JText::_('GOOGLE MAP ENABLE JAVASCRIPT').'</noscript>';
	echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';
	echo '<div align="center" style="margin:0;padding:0;margin-top:10px;">';
	
	$cmw = '';
	if ((int)$this->tmplGeo['categoriesmapwidth'] > 0) {
		$cmw = 'width:'.$this->tmplGeo['categoriesmapwidth'].'px;';
	}
	echo '<div id="phocaMap" style="margin:0;padding:0;'. $cmw. 'height:'.$this->tmplGeo['categoriesmapheight'].'px">';
	echo '</div></div>';
	
	?><script type='text/javascript'>//<![CDATA[
	google.load("maps", "3.x", {"other_params":"sensor=false"}); <?php 
	$map	= new PhocaGalleryRenderMap();
	echo $map->createMap('phocaMap', 'mapPhocaMap', 'phocaLatLng', 'phocaOptions','tstPhocaMap', 'tstIntPhocaMap');
	echo $map->cancelEventF();
	echo $map->checkMapF();
	echo $map->startMapF();
		echo $map->setLatLng( $this->tmplGeo['categorieslat'], $this->tmplGeo['categorieslng'] );
		echo $map->startOptions();
		echo $map->setZoomOpt($this->tmplGeo['categorieszoom']).','."\n";
		echo $map->setCenterOpt().','."\n";
		echo $map->setTypeControlOpt().','."\n";
		echo $map->setNavigationControlOpt().','."\n";
		echo $map->setScaleControlOpt(1).','."\n";
		echo $map->setScrollWheelOpt(1).','."\n";
		echo $map->setDisableDoubleClickZoomOpt(0).','."\n";
		echo $map->setMapTypeOpt()."\n";
		echo $map->endOptions();
		echo $map->setMap();

		foreach ($this->categories as $category) {

			if ((isset($category->longitude) && $category->longitude != '' && $category->longitude != 0)
				&& (isset($category->latitude) && $category->latitude != '' && $category->latitude != 0)) {
				
				if ($category->geotitle == '') {
					$category->geotitle = $category->title;
				}
				if (isset($category->extid) && $category->extid != '') {
					$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($category->extw, $category->exth, $this->tmpl['picasa_correct_width'], $this->tmpl['picasa_correct_height']);
					$imgLink = JHTML::_( 'image', $category->linkthumbnailpath, str_replace('&raquo;', '-',$category->title), array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']), '', '', 'style="border:0"');
				} else {
					$imgLink = JHTML::_( 'image.site', $category->linkthumbnailpath, '', '', '', $category->geotitle );
				}
				$text = '<div style="text-align:left">'
				.'<table border="0" cellspacing="5" cellpadding="5">'
				.'<tr>'
				.'<td align="left" colspan="2"><b><a href="'.$category->link.'">'. $category->geotitle.'</a></b></td>'
				.'</tr>'
				.'<tr>'
				.'<td valign="top" align="left"><a href="'.$category->link.'">'. $imgLink . '</a></td>'
				.'<td valign="top" align="left">'. PhocaGalleryText::strTrimAll(addslashes($category->description)).'</td>'
				.'</tr></table></div>';
				
				// Markers
				$iconOutput = $map->setMarkerIcon(0);
				echo $iconOutput['js'];
				echo $map->setMarker($category->id, $category->geotitle, $category->description,$category->latitude, $category->longitude, $iconOutput['icon'], $text );
					
				echo $map->setListener();
			}
		}
		
	echo $map->endMapF();
	echo $map->setInitializeF();
	?>//]]></script><?php
}
echo '<div>&nbsp;</div><div>' . $this->tmpl['phoac'].'</div></div>';
?>
<!-- End Categories </a></div> -->