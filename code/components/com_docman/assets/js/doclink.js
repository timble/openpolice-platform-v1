/**
 * @version		$Id: doclink.js 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */

//load some scripts
(function() {

})();

//DocLink prototype
function DOCLink(config) {

	this.dom = document.getElementById ? 1 : 0;

	if (this.dom && config) {

		//reference to this object
		var self = this;

		// global reference to this object
		this._gRef = "DocLink_";
		eval(this._gRef+"=this");

		//public members
		this.config 		= config;

		//this.addLoadEvent("onLoad");
		this.initInstance();
	}
};

//Config
DOCLink.config = function()	{
	this.version = "1.5";

	//baseURL included in the iframe document
	this.baseURL = document.baseURI || document.URL;
	if (this.baseURL && this.baseURL.match(/(.*)\/([^\/]+)/))
		this.baseURL = RegExp.$1 + "/";

	//includeURL
	this.includeURL = '/';

	//language
	this.lang  = 'en';
}

//Event
DOCLink.prototype.addEvent = function(el, evname, args)
{
	var self = this;

	if (Browser.is_ie) {
		el.attachEvent("on" + evname, onEvent);
	} else {
		el.addEventListener(evname, onEvent, true);
	}

	function onEvent(e) {
		e = e||window.event;
		return self["on"+evname](e, args);
	}
};

//Need to be reworked -> use global object id in add/remove event
DOCLink.prototype.removeEvent = function(el, evname) {
	if (Browser.is_ie) {
		el.detachEvent("on" + evname, testing);
	} else {
		el.removeEventListener(evname, testing, true);
	}
};

DOCLink.prototype.addLoadEvent = function(evname, args) {
  var self = this;
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload =  function () {
	 	self[evname](args);
	}
  } else {
    window.onload = function() {
      oldonload();
      self[evname](args);
    }
  }
}

//Event handlers
DOCLink.prototype.onLoad = function(args) {
	this.initInstance(args);
}

DOCLink.prototype.onclick = function(event, args) {
	this.createDialog(args, null);
	return false;
}

//Public functions (ovverride if necesary)
DOCLink.prototype.initInstance = function() 					 {
	this._initialise();
}

DOCLink.prototype.createDialog = function(editor, args)    {
	this._showDialog(editor, args);
}

DOCLink.prototype.addButton   = function(editor) { }
DOCLink.prototype.addEvents   = function(editor) { }

DOCLink.prototype.insertContent = function(editor, content) {
	//Override if necessary
	var editor_frame = document.getElementById(editor);
	var contentWindow = editor_frame.contentWindow;

	if (Browser.is_ie) {
			var sel = this._getSelection(contentWindow);
			var range = this._createRange(sel, contentWindow);
			range.pasteHTML(content.outerHTML);
	} else {
		// insert the table
		this._insertNodeAtSelection(content, contentWindow);
	}
}

//private functions
DOCLink.prototype._initialise = function() {
	this._loadScripts();
}

DOCLink.prototype._loadScripts = function ()
{
	var scripts = DOCLink.scripts = [
			this.config.includeURL + "dlutils.js",
			this.config.includeURL + "dldialog.js",
			this.config.includeURL + "lang/" + this.config.lang + ".js"
		];
	var head = document.getElementsByTagName("head")[0];
	for (var i = 0; i < scripts.length; ++i) {
		var script = document.createElement("script");
		script.src = scripts[i];
		head.appendChild(script);
	}
}

DOCLink.prototype._showDialog = function(editor, arguments)
{
	var doclink = this;

	var args = arguments ?	arguments.toMap() : new Map();
	args['i18n'] = DOCLink.I18N;

	var features = new Map();
	features['width']   = 630;
	features['height']  = Browser.is_ie ? 520 : 465;
	features['resizable']  = 'no';
	features['scrollbars'] = 'no';
	features['modal']      = 'yes';
	features['dependable'] = 'yes';
	features['center']     = 'yes';

	var param = this._popupDialog(this.config.includeURL + 'popups/dialog.php', function (param)
	{
		if (!param) {	// user must have pressed Cancel
			return false;
		}

		var alink = document.createElement("a");
		alink.setAttribute("class", "doclink");
		//alink.setAttribute("onclick", "parent.doclink.createDialog('"+editor+"', '"+param.toString()+"')");
		var caption = "";
		if (param["f_addicon"]) {
			var img = document.createElement("img");
			img.src = param["f_icon"];
			img.alt = "icon";
			alink.appendChild(img);
			caption = '<img border="0" src="' + param["f_icon"] + '" alt="icon" />&nbsp;';
		}
		caption = caption + param["f_caption"];
		if (param["f_addsize"] || param["f_adddate"]) caption = caption + ' (<span class="small">';
		if (param["f_addsize"])caption = caption + param["f_size"];
		if (param["f_adddate"])caption = caption + ' ' + param["f_date"];
		if (param["f_addsize"] || param["f_adddate"]) caption = caption + '</span>)';
		alink.href = param["f_url"];
		alink.innerHTML = caption;

		doclink.insertContent(editor, alink);
	},  args, features);

	//return true;
};

DOCLink.prototype._popupDialog = function(url, action, arguments, features) {
	DLDialog(url, action, arguments, features);
};

DOCLink.prototype._insertNodeAtSelection = function(toBeInserted, contentWindow)
{
	var sel = this._getSelection(contentWindow);
	var range = this._createRange(sel, contentWindow);

	// remove the current selection
	sel.removeAllRanges();
	range.deleteContents();
	var node = range.startContainer;
	var pos = range.startOffset;
	switch (node.nodeType) {
		case 3: // Node.TEXT_NODE
		// we have to split it at the caret position.
		if (toBeInserted.nodeType == 3) {
			// do optimized insertion
			node.insertData(pos, toBeInserted.data);
			range = this._createRange();
			range.setEnd(node, pos + toBeInserted.length);
			range.setStart(node, pos + toBeInserted.length);
			sel.addRange(range);
		} else {
			node = node.splitText(pos);
			var selnode = toBeInserted;
			if (toBeInserted.nodeType == 11 /* Node.DOCUMENT_FRAGMENT_NODE */) {
				selnode = selnode.firstChild;
			}
			node.parentNode.insertBefore(toBeInserted, node);
			//this.selectNodeContents(selnode);
		}
		break;
		   case 1: // Node.ELEMENT_NODE
		var selnode = toBeInserted;
		if (toBeInserted.nodeType == 11 /* Node.DOCUMENT_FRAGMENT_NODE */) {
			selnode = selnode.firstChild;
		}
		node.insertBefore(toBeInserted, node.childNodes[pos]);
		//this.selectNodeContents(selnode);
		break;
	}
};

// returns the current selection object
DOCLink.prototype._getSelection = function(contentWindow) {
	if (Browser.is_ie) {
		return contentWindow.document.selection;
	} else {
		return contentWindow.getSelection();
	}
};

// returns a range for the current selection
DOCLink.prototype._createRange = function(sel, contentWindow) {
	if (Browser.is_ie) {
		return sel.createRange();
	} else {
		if (typeof sel != "undefined") {
			try {
				return sel.getRangeAt(0);
			} catch(e) {
				return contentWindow.document.createRange();
			}
		} else {
			return contentWindow.document.createRange();
		}
	}
};