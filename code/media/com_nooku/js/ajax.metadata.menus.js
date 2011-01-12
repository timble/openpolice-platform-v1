/**
 * @version		$Id: ajax.metadata.menus.js 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Media
 * @subpackage  Javascript
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

var NookuMetadataMenus = new Class({

	initialize: function(options)
	{
		this.setOptions(options);
		
		this.id         = $get('cid[]', 0);
		this.table_name = 'menu'; 
		this.isEditing  = true;

		var form = $E('form[name=adminForm]');
		var link = $E('input[name=link]', form).getValue();
		
		var option = link.get('option');
		var view   = link.get('view');
		
		//If we are selecting an article use the article metadata instead
		if(option == 'com_content' && view == 'article') 
		{
			this.table_name = 'content';
			this.id         = link.get('id', 0);
			
			if(!this.id) {
				this.isEditing = false;
			}
			
			SqueezeBox.initialize({ onClose: function (e) 
			{ 
				if(!this.isEditing) {
					$E('input[name=name]', form).setProperty('value', $('id_name').getValue());
				}
				
				this.id = $('id_id').getValue();
				this.displayPanel();
			}.bind(this)});
		} 
		
		//Render the panel
		this.displayPanel();
		return this;
	},
	
	displayPanel: function() 
	{	
		var url =  window.location.pathname+'/index.php?option=com_nooku&view=metadata&layout=form&format=ajax&table_name='+this.table_name+'&row_id='+this.id;
		
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
 
 		// Check to see if a metadata-page already exists and replace it 
 		// otherwise inject the panel at the bottom;
 		var pane = $('metadata-page');
 		if(pane != undefined) {
   	 		pane.getParent().replaceWith(panel);
   	 	} else {
   			panel.injectInside($$('div.pane-sliders')[0]);
   		}
		
		// Insert the panel in the accordion
		var accordion = document.accordion;
		var toggler = panel.getElement('#metadata-page');
		var element = panel.getElement('div.jpane-slider');
		accordion.addSection(toggler, element, accordion.togglers.length);
		
		// refresh tooltips
		new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); 
	}
});

NookuMetadataMenus.implement(new Options);

document.metadata = null;
window.addEvent('domready', function(){
  	document.metadata = new NookuMetadataMenus();
});