/**
 * @version		$Id: ajax.metadata.content.js 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Media
 * @subpackage  Javascript
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

var NookuMetadataContent = new Class({

	initialize: function(options)
	{
		this.setOptions(options);
		
		//get the id from the request
		this.id  = $get('cid[]', 0);
		
		//Render the panel
		this.displayPanel();
	},
	
	displayPanel: function() 
	{
		var url = window.location.pathname+'/index.php?option=com_nooku&view=metadata&layout=form&format=ajax&table_name=content&row_id='+this.id;
		
		new Ajax(url, {
			method: 'get',
 			onSuccess: this.togglePanel
		}).request();
	},
	
	togglePanel: function(result) 
	{	
		// Create the panel
		var panel = new Element('div', {
        	'class': 'panel'
   	 	}).setHTML(result);
 
 		var pane = $$('#metadata-page');
   	 	pane.getParent().replaceWith(panel);
   	 	
		// Insert the panel in the accordion
		var accordion = document.accordion;
		var toggler = panel.getElement('#metadata-page');
		var element = panel.getElement('div.jpane-slider');
		accordion.addSection(toggler, element, accordion.togglers.length);
		
		// refresh tooltips
		new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); 
	}
});

NookuMetadataContent.implement(new Options);

document.metadata = null;
window.addEvent('domready', function(){
  	document.metadata = new NookuMetadataContent();
});