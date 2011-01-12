/**
 * @version		$Id: theme.js 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */

function DMinitTheme()
{
	 DMaddPopupBehavior();
}

function DMaddPopupBehavior()
{
	var x = document.getElementsByTagName('a');
	for (var i=0;i<x.length;i++)
	{
		if (x[i].getAttribute('type') == 'popup')
		{
			x[i].onclick = function () {
				return DMpopupWindow(this.href)
			}
			x[i].title += ' (Popup)';
		}
	}
}

/* -- utility functions ----------------------- */

function DMpopupWindow(href)
{
	newwindow = window.open(href,'DOCman Popup','height=600,width=800');
	return false;
}

/* -- page loader ----------------------------- */

function DMaddLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}

DMaddLoadEvent(function() {
  DMinitTheme();
});
