// Based on htmlArea3 popup.js
// htmlArea v3.0 - Copyright (c) 2003-2004 interactivetools.com, inc.
// This copyright notice MUST stay intact for use (see license.txt).
// Portions (c) dynarch.com, 2003-2004

function __dlg_init(bottom) {
	var body = document.body;
	var body_height = 0;

	if(!Browser.is_ie) {
		window.dialogArguments = window.parent.DLDialog._arguments;
		window.addEventListener("unload", __dlg_onclose, true);
	} else {
		//do nothing
	}
};

function __dlg_translate(i18n) {
	var types = ["span", "option", "td", "button", "div"];
	for (var type in types) {
		var spans = document.getElementsByTagName(types[type]);
		for (var i = spans.length; --i >= 0;) {
			var span = spans[i];
			if (span.firstChild && span.firstChild.data) {
				var txt = i18n[span.firstChild.data];
				if (txt)
					span.firstChild.data = txt;
			}
		}
	}
	var txt = i18n[document.title];
	if (txt)
		document.title = txt;
};

// closes the dialog and passes the return info upper.
function __dlg_onclose() {
	if(!Browser.is_ie) {
		window.parent.DLDialog._return(null);
	}
	else {
		window.returnValue = '';
	}
};

function __dlg_close(val) {
	if(!Browser.is_ie) {
		window.parent.DLDialog._return(val);
	}
	else {
		window.returnValue = val;
	}
	window.close();
};

function __dlg_close_on_esc(ev) {
	ev || (ev = window.event);
	if (ev.keyCode == 27) {
		window.close();
		return false;
	}
	return true;
};

function comboSelectValue(c, val) {
	var ops = c.getElementsByTagName("option");
	for (var i = ops.length; --i >= 0;) {
		var op = ops[i];
		op.selected = (op.value == val);
	}
	c.value = val;
};
