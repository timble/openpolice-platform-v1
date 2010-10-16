<?php

/**
*
* $Id:Savant2_Plugin_document.php 81 2007-02-14 16:19:06Z mjaz $
* @author Johan Janssens <johan.janssens@users.sourceforge.net>
* @package Savant2
* @license http://www.gnu.org/copyleft/lesser.html LGPL
*
*/

require_once dirname(__FILE__) . DS.'Plugin.php';

class Savant2_Plugin_document extends Savant2_Plugin {

	function plugin($id)
	{
		global $_DOCMAN;

		if(!$id) {
			return;
		}

		require_once($_DOCMAN->getPath('classes', 'model'));
		$doc = new DOCMAN_Document($id);

		$item = new StdClass();
       	$item->links = &$doc->getLinkObject();
       	$item->paths = &$doc->getPathObject();
        $item->data  = &$doc->getDataObject();

		return $item;
	}

}
