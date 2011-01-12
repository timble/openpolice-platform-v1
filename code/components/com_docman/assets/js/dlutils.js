/**
 * @version		$Id: dlutils.js 953 2009-10-14 20:38:38Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license	    This file can not be redistributed without the written consent of the 
 				original copyright holder. This file is not licensed under the GPL. 
 * @link     	http://www.joomladocman.org
 */

//Browser information
Browser = new Object();
Browser.agt    = navigator.userAgent.toLowerCase();
Browser.is_ie	= ((Browser.agt.indexOf("msie") != -1) && (Browser.agt.indexOf("opera") == -1));

//Map collaction object
function Map() {
	
}

Map.prototype.toString = function() {
	str = ''; 
	for(var key in this) {
		if(typeof(this[key]) != 'function') {
			if(str) str += ','; 
			str += key+'='+this[key];		
		}
	}
	return str;	
}

String.prototype.toMap = function() {
	var map = new Map();
	var array = this.split(",");
	for (number in array) {
		result = array[number].split("=");
		var key   = result[0];
		var value = result[1];
		map[key] = value;
	}
	return map;
}

function parseBool(str) {
	switch(str) {
		case 'false' :	return new Boolean(false); break;
		case 'true'  : return new Boolean(true);  break;
		default : return; break;
	}
}

// -- Utility function --------------------------
document.getElementsByClassName = function ( class_name ) {
    var all_obj, ret_obj = new Array(), j = 0, strict = 0;
    if ( document.getElementsByClassName.arguments.length > 1 )
        strict = ( document.getElementsByClassName.arguments[1] ? 1 : 0 );
    if ( document.all )
        all_obj = document.all;
    else if ( document.getElementsByTagName && !document.all )
        all_obj = document.getElementsByTagName ( "*" );
    for ( i = 0; i < all_obj.length; i++ ) {
        if ( ( ' ' + all_obj[i].getAttribute("class") + ' ').toLowerCase().match(
            new RegExp ( ( strict ? '^ ' + class_name.trim() + ' $' : 
                '^.* ' + class_name.trim() + ' .*$' ).toLowerCase(),'g' ) ) ) {
            ret_obj[j++] = all_obj[i];
        }
    }
    return ret_obj;
}

String.prototype.trim = function() {
  return(this.replace(/^\s+/,'').replace(/\s+$/,''));
}


