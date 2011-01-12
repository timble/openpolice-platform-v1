// Based on htmlArea3 dialog.js
// htmlArea v3.0 - Copyright (c) 2003-2004 interactivetools.com, inc.
// This copyright notice MUST stay intact for use
// Portions (c) dynarch.com, 2003-2004

// should be a function, the return handler of the currently opened dialog.
DLDialog._return = null;

// constant, the currently opened dialog
DLDialog._modal = null;

// the dialog will read it's args from this variable
DLDialog._arguments = null;

// the dialog will read it's args from this variable
DLDialog._features = null;

function DLDialog(url, action, arguments, features) 
{
	if (typeof arguments == "undefined") {
		arguments = window;	// pass this window object by default
	}
	
	DLDialog._arguments = arguments;
	DLDialog._features = features;
	
	//open dialog
	if(Browser.is_ie)
		DLDialog._ieOpenDialog(url, action, features['modal'], features);
	else
		DLDialog._geckoOpenModal(url, action, features['modal'], features);
};

DLDialog._geckoOpenModal = function(url, action, modal, features) {

	//center dialog
	if(features.center == 'yes') {
		var x = (screen.availWidth -  features.width ) / 2;
		var y = (screen.availHeight - features.height) / 2;
	
		features.screenX = x;
		features.screenY = y;
	}
	
	//convert to string
	sfeatures = features.toString();
	var dlg = window.open(url, "hadialog", sfeatures);
	
	DLDialog._modal = dlg;

	// capture some window's events
	function capwin(w) {
		DLDialog._addEvent(w, "click", DLDialog._parentEvent);
		DLDialog._addEvent(w, "mousedown", DLDialog._parentEvent);
		DLDialog._addEvent(w, "focus", DLDialog._parentEvent);
	};
	// release the captured events
	function relwin(w) {
		DLDialog._removeEvent(w, "click", DLDialog._parentEvent);
		DLDialog._removeEvent(w, "mousedown", DLDialog._parentEvent);
		DLDialog._removeEvent(w, "focus", DLDialog._parentEvent);
	};
	capwin(window);
	// capture other frames
	for (var i = 0; i < window.frames.length; capwin(window.frames[i++]));
	// make up a function to be called when the Dialog ends.
	DLDialog._return = function (val) {
		//release capture
		relwin(window);
		if(action && val) {
			action(val);
		}
		// capture other frames
		for (var i = 0; i < window.frames.length; relwin(window.frames[i++]));
		DLDialog._modal = null;
	};
};

DLDialog._ieOpenDialog = function(url, action, modal, features) {
	
	features.width  = features.width  + 'px';
	features.height = features.height + 'px';
	
	//convert to string
	sfeatures = features.toString();

	sfeatures = sfeatures.replace(/\,/gi, ';')
	sfeatures = sfeatures.replace(/\=/gi, ':')
	sfeatures = sfeatures.replace(/scrollbars/gi, 'scroll')
	sfeatures = sfeatures.replace(/left/gi, 'dialogLeft')
	sfeatures = sfeatures.replace(/top/gi, 'dialogTop')
	sfeatures = sfeatures.replace(/width/gi, 'dialogWidth')
	sfeatures = sfeatures.replace(/height/gi, 'dialogHeight')
	if ((sfeatures.search('scroll')) == -1) {
		sfeatures += ";scroll:no"
	}
	if (sfeatures.search('status') == -1) {
		sfeatures += ";status:no"
	}
	if (sfeatures.search('help') == -1) {
		sfeatures += ";help:no"
	}  
		
	if (modal == 'no') {
		var val = window.showModelessDialog(url, DLDialog._arguments, sfeatures)
	} else {
		var val = window.showModalDialog(url, DLDialog._arguments, sfeatures)
	}

	if(action && val) {
		action(val);
	}
}

//Events
DLDialog._addEvent = function(el, evname, event) {
	if (Browser.is_ie) {
		el.attachEvent("on" + evname, event);
	} else {
		el.addEventListener(evname, event, true);
	}
};

DLDialog._removeEvent = function(el, evname, event) {
	if (Browser.is_ie) {
		el.detachEvent("on" + evname, event);
	} else {
		el.removeEventListener(evname, event, true);
	}
};

DLDialog._parentEvent = function(ev) {
	setTimeout( function() { if (DLDialog._modal && !DLDialog._modal.closed) { DLDialog._modal.focus() } }, 50);
	if (DLDialog._modal && !DLDialog._modal.closed) {
		DOCLink._stopEvent(ev);
	}
};