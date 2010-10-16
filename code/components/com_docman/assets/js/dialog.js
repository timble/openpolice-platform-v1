/**
 * @version		$Id: dialog.js 1121 2010-01-14 20:17:39Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 *				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */

function _doclink_init() {
  __dlg_init();

  var args = window.parent.dialogArguments;

  if(args.f_size) {
  		var obj = document.getElementById("f_size");
		obj.value = args.f_size;
  }
  if(args.f_date) {
  		var obj = document.getElementById("f_date");
		obj.value = args.f_date;
  }
  if(args.f_icon) {
  		var obj = document.getElementById("f_icon");
		obj.value = args.f_icon;
  }
  if(args.f_cid) {
  		var obj = document.getElementById("f_cid");
		obj.value = args.f_cid;
  }
  if(args.f_pid) {
  		var obj = document.getElementById("f_pid");
		obj.value = args.f_pid;
  }
  if(args.f_url) {
  		var obj = document.getElementById("f_url");
		obj.value = args.f_url;
  }
  if(args.f_caption) {
  		var obj = document.getElementById("f_caption");
		obj.value = args.f_caption;
  }
  if(args.f_addsize) {
  		var obj = document.getElementById("f_addsize");
		obj.checked = parseBool(args.f_addsize);
  }
  if(args.f_adddate) {
  		var obj = document.getElementById("f_adddate");
		obj.checked = parseBool(args.f_adddate);
  }
  if(args.f_addicon) {
  		var obj = document.getElementById("f_addicon");
		obj.checked = parseBool(args.f_addicon);
  }

  if (args.f_cid) {
  listview.setListView(args.f_cid);
    if (args.f_pid) {
  setListCtrl(args.f_pid, args.f_cid);
    }
  }

  var cList = document.getElementById("listctrl");
  if(cList != null) {
  	cList.focus();

  }
};

function _doclink_onok() {
var required = {
	"f_url"		: 'ENTER URL',
	"f_caption"	: 'ENTER CAPTION'
};

	// check for required fields
	for (var i in required) {
    	var el = document.getElementById(i);
		if (!el.value) {
    		alert(required[i]);
			el.focus();
			return false;
		}
	}

	// Build html
	var tag = '<a class="doclink" href="' + $("f_url").value + '">';

	if ($("f_addicon").checked) {
		tag += '<img border="0" src="' + $("f_icon").value + '" alt="icon" />&nbsp;';
	}
	tag += $("f_caption").value;
	if ($("f_addsize").checked || $("f_adddate").checked) tag += ' (<span class="small">';
	if ($("f_addsize").checked) tag += $("f_size").value;
	if ($("f_adddate").checked) tag += ' ' + $("f_date").value;
	if ($("f_addsize").checked || $("f_adddate").checked) tag += '</span>)';
	tag += '</a>';

	// insert html in editor
	window.parent.jInsertEditorText(tag, editor);
	window.parent.document.getElementById('sbox-window').close();
	return true;
};


function onchangeListCtrl(objDir) 	{
	var re = /\s*([0-9]+)\s*:\s*([0-9]+)\s*/;
	if (objDir.value.match(re)) {
		var parid = parseInt(RegExp.$1);
		var catid = parseInt(RegExp.$2);
	}

	listview.setListView(catid);
	changeDialogStatus('load');
}

function changeListCtrl(direction)	{

	if(direction == 'up')	{

		var obj   = document.getElementById("listctrl");
		var index = obj.selectedIndex;

		if(obj.options[index].text != '/') {

			parseValue(obj.options[index].value);
			var parid = parseInt(RegExp.$1);
			var catid = parseInt(RegExp.$2);

			i = 0;

			if(catid != 0)	{
				do {
					i++; //advance
					parseValue(obj.options[index - i].value);
					var catid = parseInt(RegExp.$2);
				} while (catid != parid)

				index = obj.selectedIndex - i;
			}
			else
				index = 0;

			obj.selectedIndex = index
			onchangeListCtrl (obj);
		}
	}
}

function parseValue(value)
{
	var re = /\s*([0-9]+)\s*:\s*([0-9]+)\s*/;
	if (value.match(re)) {
		return true
	}

	return false;
}

function setListCtrl(catid, subid)	{
	var objDir = document.getElementById("listctrl");
	objDir.value = catid + ':' + subid;
	changeDialogStatus('load');
}

function setFields(name, url, cid, icon, size, date)	{
	var objURL = document.getElementById("f_url");
	objURL.value = url;
	var objCap = document.getElementById("f_caption");
	objCap.value = name;
	var objIcon = document.getElementById("f_icon");
	objIcon.value = icon;
	var objSize = document.getElementById("f_size");
	objSize.value = size;
	var objDate = document.getElementById("f_date");
	objDate.value = date;
	var objCid = document.getElementById("f_cid");
	objCid.value = cid;

	var obj   = document.getElementById("listctrl");
	var index = obj.selectedIndex;

	parseValue(obj.options[index].value);
	var pid = parseInt(RegExp.$1);
	var cid = parseInt(RegExp.$2);

	var objPid = document.getElementById("f_pid");
	objPid.value = pid;
}

function changeDialogStatus(state) {
	var statusText = null;
	if(state == 'load') {
		statusText = 'Loading files...';
	}

	if(statusText != null) {
		var obj = document.getElementById("loadingStatus");
		if (obj != null && obj.innerHTML != null)
			obj.innerHTML = statusText;
	}

	showHideLayer("loading")
}

function showHideLayer(id) {
	var obj = document.getElementById(id);
	if(obj.style.visibility == 'hidden' || obj.style.visibility == 'hide'){
		obj.style.visibility = 'visible';
	}else{
		obj.style.visibility = 'hidden';
	}
}

window.onload = _doclink_init;