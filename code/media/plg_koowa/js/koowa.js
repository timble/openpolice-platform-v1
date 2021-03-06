/**
 * @version		$Id: koowa.js 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category    Koowa
 * @package     Koowa_Media
 * @subpackage  Javascript
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.koowa.org
 */

// needed for Table Column sorting
function KTableSorting( order, dir, task ) 
{
	var form = document.adminForm;

	form.filter_order.value 	= order;
	form.filter_direction.value	= dir;
	submitform( task );
}

function KGridOrder(row_id, change) 
{
	var form = document.adminForm;
	form.id.value= row_id;
	form.order_change.value	= change;
	form.task.value = 'order';
	form.submit();
}

function $get(key, defaultValue) {
	return location.search.get(key, defaultValue);
}	

String.extend({
 
	get : function(key, defaultValue)
	{
		if(key == "") return;
	
		var uri   = this.parseUri();
		if($defined(uri['query'])) 
		{
			var query = uri['query'].parseQueryString();
			if($defined(query[key])) {
				return query[key]
			}
		}
		
		return defaultValue;
	},
	
	parseQueryString: function() 
	{
		var vars = this.split(/[&;]/);
		var rs = {};
		if (vars.length) vars.each(function(val) {
			var keys = val.split('=');
			if (keys.length && keys.length == 2) rs[keys[0]] = encodeURIComponent(keys[1]);
		});
		
		return rs;
	},
 
	parseUri: function()
	{
		var bits = this.match(/^(?:([^:\/?#.]+):)?(?:\/\/)?(([^:\/?#]*)(?::(\d*))?)((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[\?#]|$)))*\/?)?([^?#\/]*))?(?:\?([^#]*))?(?:#(.*))?/);
		return (bits)
			? bits.associate(['uri', 'scheme', 'authority', 'domain', 'port', 'path', 'directory', 'file', 'query', 'fragment'])
			: null;
	}
});