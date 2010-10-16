<?php
defined('_JEXEC') or die('Restricted access');
phocagalleryimport('phocagallery.render.rendermap');
echo '<script src="http://www.google.com/jsapi" type="text/javascript"></script>';
echo '<noscript>'.JText::_('GOOGLE MAP ENABLE JAVASCRIPT').'</noscript>';
echo '<div align="center" style="margin:0;padding:0">';
echo '<div id="phocaMap" style="margin:0;padding:0;width:620px;height:540px"></div></div>';

?><script type='text/javascript'>//<![CDATA[
google.load("maps", "3.x", {"other_params":"sensor=false"}); <?php 
$map	= new PhocaGalleryRenderMap();
echo $map->createMap('phocaMap', 'mapPhocaMap', 'phocaLatLng', 'phocaOptions','tstPhocaMap', 'tstIntPhocaMap');
echo $map->cancelEventF();
echo $map->checkMapF();


echo $map->startMapF();
	echo $map->setLatLng( $this->latitude, $this->longitude );
	echo $map->startOptions();
	echo $map->setZoomOpt($this->zoom).','."\n";
	echo $map->setCenterOpt().','."\n";
	echo $map->setTypeControlOpt().','."\n";
	echo $map->setNavigationControlOpt().','."\n";
	echo $map->setScaleControlOpt(1).','."\n";
	echo $map->setScrollWheelOpt(1).','."\n";
	echo $map->setDisableDoubleClickZoomOpt(0).','."\n";
	echo $map->setMapTypeOpt()."\n";
	echo $map->endOptions();
	echo $map->setMap();
	echo $map->exportZoom($this->zoom, 'window.top.document.forms.adminForm.elements.zoom');
	echo $map->exportMarker(1, $this->latitude, $this->longitude, 'window.top.document.forms.adminForm.elements.latitude', 'window.top.document.forms.adminForm.elements.longitude');
	echo $map->setListener();
echo $map->endMapF();
echo $map->setInitializeF();
?>//]]></script>
