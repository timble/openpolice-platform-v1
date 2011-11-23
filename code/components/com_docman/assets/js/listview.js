/**
 * @version		$Id: listview.js 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */

var st, st1, st2; //sortable tables identifiers

//Initialise listview
function _listview_init()	{

	if(document.getElementById("tableItems") != null)	{
		st = new SortableTable(
			document.getElementById("tableItems"),
			["None", "CaseInsensitiveString", "Number", "Number", "None"]
		);
	}
}

function onclickFolder(parid, catid, name, url, icon)	{
	window.parent.setFields(name, url, catid, icon, '', '');
	window.parent.setListCtrl(parid, catid);
}

function onclickItem(name, id, cid, ext, size, time)	{
	window.parent.setFields(name, id, cid, ext, size, time);
}

function setListView(catid) {
	location.href = location.pathname + "/index.php?option=com_docman&task=doclink-listview&catid="+catid;
}

window.onload = _listview_init
//always hide the loading status
window.parent.changeDialogStatus('load');