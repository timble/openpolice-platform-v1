/**
 * @version		$Id: ajax.form.js 1121 2010-05-26 16:53:49Z johan $
 * @category    Nooku
 * @package     Nooku_Media
 * @subpackage  Javascript
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.nooku.org
 */

var NookuForm = new Class({

	initialize: function(options)
	{
		this.setOptions(options);
		
		this.form = $E('form[name=adminForm]');
		this.option = this.form.option.value;
		this.task   = this.form.task.value;
		
		$$('#toolbar-apply a', '#toolbar-save a').each(function(el) 
		{
			el.onclick = function() {
			 	this.validate(el.getParent().id.substring(8));
			}.bind(this)
		}.bind(this));
		
		var element = new Element('div', { 'id' : 'system-message-ajax' });	
		element.injectBefore('element-box');
	},
	
	validate: function( task )
	{
		this.form.option.value = 'com_nooku';
		this.form.task.value   = 'validate';
		
		var url =  window.location.pathname+'/index.php?option=com_nooku&controller=node&task=validate&format=json&component='+this.option;
		
		new Ajax(url, {
			method: 'post',
			onComplete: function(response) { this.complete(response, task) }.bind(this),
			data: this.form
		}).request();
	},
	
	complete : function(response, task)
	{
		this.form.option.value = this.option;
		this.form.task.value   = this.task;
		
		if(response != '') 
		{
			response = Json.evaluate(response);
			
			for (var item in response) 
			{
				this.form[item].addClass('invalid');
				this.form[item].value = response[item]['value'];
				$('system-message-ajax').setHTML(response[item]['message']);	
			}
		}
		else 
		{
			//Submit the actual form
			submitbutton(task);
		}
	}	
});

NookuForm.implement(new Options);

document.form = null;
window.addEvent('domready', function(){
  	document.form = new NookuForm();
});