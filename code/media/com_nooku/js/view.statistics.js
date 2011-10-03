/**
 * @version		$Id: view.statistics.js 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Media
 * @subpackage  Javascript
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */
 
window.addEvent('domready', function() {
    
    var sel = $('view');
    sel.addEvent('change', function() {
		switch(sel.value)
		{
			case 'statistics.translations':
				$('table_name').disabled = '';
				$('month').disabled = 'disabled';
				$('year').disabled = 'disabled';
				break;
			case 'statistics.translators':
				$('table_name').disabled = '';
				$('month').disabled = '';
				$('year').disabled = '';
				break;
		}
    });

    var sels = $$('.statistics_filter');
    sels.each(function(sel, index){
    	sel.addEvent('change', function() {
			$("graph_flash").reload($('reload-url').value + '/?' + sel.form.toQueryString());
		});
    });
});