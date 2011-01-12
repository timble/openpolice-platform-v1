var ImageManagerDialog = {
	preInit : function() {
		tinyMCEPopup.requireLangPack();
	},
	init : function() {
		var ed 	= tinyMCEPopup.editor, n = ed.selection.getNode(), t = this, br, args, s, group;
		tinyMCEPopup.resizeToInnerSize();		
		// Get src an convert to relative
		var src = ed.documentBaseURI.toRelative(ed.dom.getAttrib(n, 'src'));
		
		// Setup Manager plugin
		this.imgmanager = initManager(src);
		
		TinyMCE_Utils.fillClassList('classlist');
		if (n.nodeName == 'IMG') {
			var p = ed.dom.getParent(n, "A");
			if(p){
				// JCE Utilities / Lightbox popup
				var p_src 	= ed.documentBaseURI.toRelative(ed.dom.getAttrib(p, 'href'));				
				var p_rel 	= ed.dom.getAttrib(p, 'rel');
				var p_class	= ed.dom.getAttrib(p, 'class');
								
				if(/(jcebox|jcepopup|jcelightbox|thickbox)/gi.test(p_class) || /(lightbox|rokzoom|rokbox)/gi.test(p_rel)){
					dom.check('popup_check', true);
					dom.value('popup_src', p_src);
					var title = ed.dom.getAttrib(p, 'title');
					if(/(jcebox|jcepopup|jcelightbox|thickbox)/gi.test(p_class)){
						if(/(jcebox|jcepopup|jcelightbox)/gi.test(p_class)){
							dom.setSelect('popup_type', 'jcepopup');
							dom.disable('popup_icon', false);
							// No icon
							s = /noicon/g.test(p_class);
							dom.check('popup_icon', !s);
							dom.disable('popup_icon_position', s);

							// Get position
							if(s = /icon-(top-right|top-left|bottom-right|bottom-left|left|right)/.exec(p_class)){
								dom.setSelect('popup_icon_position', s[0]);																			
							}
						}else{
							dom.setSelect('popup_type', 'lightbox');
						}
						// Get group
						var pl = {};
						if(/\[.*\]/.test(p_rel)){
							args = p_rel.split(';');
							tinymce.each(args, function(e){
								kv = e.match(/(.+)\[(.*?)\]/);
								pl[kv[1]] = kv[2];
							});
							title = pl.title || title || '';
							group = pl.group || '';
						}else{
							group = p_rel;
						}
						// Set group
						dom.value('popup_group', group);
					}
					// Set title
					dom.value('popup_title', title);
					// Other formats
					if(g = /(lightbox|lytebox|rokzoom|rokbox)\[(.*?)\]/i.exec(p_rel)){
						dom.setSelect('popup_type', g[1]);
						dom.value('popup_group', g[2] || '');	
					}
				// Window popup
				}else if(/task=popup/gi.test(p_src)){
					// Get onclick
					var p_click = ed.dom.getAttrib(p, 'onclick');
					
					var c_src 	= p_click.replace(/&amp;/g, '&').replace(/&#39;/g, "'").split("'");
					var params 	= string.query(c_src[1]);
					dom.check('popup_check', true);
					
					dom.value('popup_src', ed.documentBaseURI.toRelative(params['img']));
					dom.value('popup_title', params['title'].replace(/_/g, ' '));
					
					dom.value('popup_width', parseInt(params['w']) || parseInt(params['width']));
					dom.value('popup_height', parseInt(params['h']) || parseInt(params['height']));
					dom.value('tmp_popup_width', dom.value('popup_width'));
					dom.value('tmp_popup_height', dom.value('popup_height'));
					
					dom.check('popup_print', parseInt(params['print']));
					dom.check('popup_rightclick', parseInt(params['click']));
					dom.check('popup_scrollbars', /scrollbars=yes/i.test(c_src));
					dom.check('popup_resizable', /resizable=yes/i.test(c_src));
					dom.setSelect('popup_mode', params['mode']);
					dom.setSelect('popup_type', 'window');
					this.setPopupMode(params['mode']);
				}
				// Get Popup dimensions
				if(dom.value('popup_width') == '' || dom.value('popup_height') == ''){
					var file = dom.value('popup_src').replace(ed.getParam('document_base_url'), '', 'gi');
					this.imgmanager.getPopupDimensions(file);
				}
			}			
			dom.value('src', src);
			// Width & Height
			dom.value('width', this.getAttrib(n, 'width'));
			dom.value('height', this.getAttrib(n, 'height'));
			dom.value('tmp_width', dom.value('width'));
			dom.value('tmp_height', dom.value('height'));
			
			dom.value('alt', ed.dom.getAttrib(n, 'alt'));
			dom.value('title', ed.dom.getAttrib(n, 'title'));
			// Margin
			tinymce.each(['top', 'right', 'bottom', 'left'], function(o){
				dom.value('margin_' + o, ImageManagerDialog.getAttrib(n, 'margin-' + o));														  
			});													  
			// Border
			dom.setSelect('border_width', this.getAttrib(n, 'border-width'), true);
			dom.setSelect('border_style', this.getAttrib(n, 'border-style'));
			dom.value('border_color', this.getAttrib(n, 'border-color'));
			
			dom.setSelect('align', this.getAttrib(n, 'align'));
			
			dom.setSelect('classlist', ed.dom.getAttrib(n, 'class'));
			dom.value('style', ed.dom.getAttrib(n, 'style'));
			dom.value('id', ed.dom.getAttrib(n, 'id'));
			dom.value('dir', ed.dom.getAttrib(n, 'dir'));
			dom.value('lang', ed.dom.getAttrib(n, 'lang'));
			dom.value('usemap', ed.dom.getAttrib(n, 'usemap'));
			
			
			// Longdesc may contain absolute url too
			dom.value('longdesc', ed.documentBaseURI.toRelative(ed.dom.getAttrib(n, 'longdesc')));

			// onmouseover / onmouseout
			dom.value('onmouseoutsrc', src);
			tinymce.each(['onmouseover', 'onmouseout'], function(o){
				v = ed.dom.getAttrib(n, o);
				if(/^\s*this.src\s*=\s*\'([^\']+)\';?\s*$/.test(v)){
					v = v.replace(/^\s*this.src\s*=\s*\'([^\']+)\';?\s*$/, '$1');
					v = ed.documentBaseURI.toRelative(v);
					dom.value(o + 'src', v);
				}
				dom.check('onmousemovecheck', v !== '');
				dom.disable(o + 'src', v === '');
			});
			
			br = p == null ? n.nextSibling : p.nextSibling;
			if(br && br.nodeName == 'BR' && ed.dom.getStyle(br, 'clear')){
				dom.setSelect('clear', ed.dom.getStyle(br, 'clear'));
			}
			// Tooltip
			if(/(jcetooltip|jce_tooltip)/gi.test(ed.dom.getAttrib(n, 'class'))){
				dom.check('tooltip_check', true);
				var title = dom.value('title');
				if(/::/g.test(title)){
					dom.value('title', title.substring(0, title.lastIndexOf('::')));
					dom.value('tooltip_title', dom.value('title'));
					var text = title.substring(title.length, title.lastIndexOf('::')+2);
					text = text.replace(/<br \/>/gi, '\n').replace(/<br>/gi, '\n').replace(/&lt;br&gt;/gi, '\n');
					dom.value('tooltip_text', text);
				}else{
					dom.value('tooltip_title', '');
					dom.value('tooltip_text', title);
					dom.value('title', title);
				}
			}
			dom.value('insert', ed.getLang('update'));
		}else{
			// Setup default values
			this.setDefaults();	
		}
		dom.html('border_color_pickcontainer', TinyMCE_Utils.getColorPickerHTML('border_color'));
	
		// Setup browse button
		dom.html('longdesccontainer', TinyMCE_Utils.getBrowserHTML('longdescbrowser','longdesc','file','imgmanager'));
	
		// Check swap image if valid data
		if (dom.value('onmouseoversrc') && dom.value('onmouseoutsrc')){
			dom.check('onmousemovecheck', true);
		}else{
			dom.check('onmousemovecheck', false);
		}
		// Setup border
		this.setBorder();
		// Setup margins
		this.setMargins(true);
		// Setup Styles
		this.updateStyles();
		// Set popup tab
		this.setPopupType(dom.getSelect('popup_type'));
		TinyMCE_EditableSelects.init();
	},
	setDefaults : function(){
		var d = this.imgmanager.getParam('defaults');
		return Editor.utilities.setDefaults(d);
	},
	getPopupOnclick : function(src){
		var title 	= dom.value('popup_title');
		
		var pr		= dom.ischecked('popup_print') 		? '1' : '0';
		var cl  	= dom.ischecked('popup_rightclick') ? '1' : '0';
		var sb		= dom.ischecked('popup_scrollbars') ? 'yes' : 'no';
		var rs		= dom.ischecked('popup_resizable') 	? 'yes' : 'no';
		var mode 	= dom.getSelect('popup_mode');

		var props 		= 'height='+ dom.value('popup_height') +',width='+ dom.value('popup_width') +',top=10,left=10,scrollbars='+ sb +',resizable='+ rs;			
		var features 	= mode == 1 ? '&mode=' + mode + '&print=' + pr + '&click=' + cl + '' : '';
		var url 		= '&img=' + src + '&title=' + title.replace(' ', '_', 'gi') + '&w=' + dom.value('popup_width') + '&h=' + dom.value('popup_height') + '';
				
		return "window.open(this.href+'" + url + features + "','" + title.replace(' ', '_', 'gi') + "','" + props + "');return false;";
	},
	getPopupArgs : function(){
		var ed = tinyMCEPopup.editor, cls = '', oc = '', rl = '';
		// Popup attributes
		var args = {}, src = dom.value('popup_src');
			
		if(!ed.getParam('relative_urls')){
			src = new tinymce.util.URI(ed.getParam('document_base_url')).toAbsolute(src);	
		}
		var type 	= dom.getSelect('popup_type');
		var group 	= dom.getSelect('popup_group') || '';
		switch(type){
			case 'jcepopup':
			case 'thickbox':
				cls = type;
				rl	= group;
				
				if(type == 'jcepopup'){
					cls += dom.ischecked('popup_icon') ? '' : ' noicon';
					cls += dom.ischecked('popup_icon') ? ' ' + dom.value('popup_icon_position') : '';
				}
				break;
			case 'lightbox':
			case 'rokzoom':
			case 'lytebox':
				rl 	= type + '[' + group + ']';
				break;
			case 'rokbox':
				// Rokbox requires width and height!
				rl 	= type + '['+ dom.value('popup_width') +' '+ dom.value('popup_height') +']';
				if(group !== ''){
					rl += '(' + group + ')';	
				}
				break;
			case 'window':
				oc 	= this.getPopupOnclick(src);
				src = 'index.php?option=com_jce&tmpl=component&task=popup';
				break;
		}
		tinymce.extend(args, {
			href 	: src,
			title 	: dom.value('popup_title'),
			target	: '_blank',
			'class' : tinymce.trim(cls),
			onclick : oc,
			rel : rl
		});
		return args;
	},
	insert : function(){
		var ed = tinyMCEPopup.editor, t = this;
		AutoValidator.validate(document);
		if(dom.value('src') === ''){
			new Alert(tinyMCEPopup.getLang('imgmanager_ext_dlg.no_src', 'A URL is required. Please select an image or enter a URL'));
			return false;		
		}
		if(dom.value('alt') === ''){
			new Confirm(tinyMCEPopup.getLang('imgmanager_ext_dlg.missing_alt'), function(state){
					if(state){
						t.insertAndClose();	
					}
				}, {
					width: 300,
					height: 220
				}								 
			);
		}else{
			this.insertAndClose();
		}
	},
	insertAndClose : function() {
		var ed = tinyMCEPopup.editor, v, args = {}, pn, el, an, br = '';
		
		this.updateStyles();

		// Fixes crash in Safari
		if (tinymce.isWebKit)
			ed.getWin().focus();

		// Remove deprecated values
		args = {
			vspace : '',
			hspace : '',
			border : '',
			align : ''
		};
		var src		= dom.value('src');
		// Add http
		if(/^\s*www./i.test(src)){
			src = 'http://' + src;	
		}	
		tinymce.extend(args, {
			src : src,
			width : dom.value('width'),
			height : dom.value('height'),
			alt : dom.value('alt'),
			title : dom.value('title'),
			'class' : dom.value('classes'),
			style : dom.value('style'),
			id : dom.value('id'),
			dir : dom.getSelect('dir'),
			lang : dom.value('lang'),
			usemap : dom.value('usemap'),
			longdesc : dom.value('longdesc')
		});

		args.onmouseover = args.onmouseout = '';

		if (dom.ischecked('onmousemovecheck')){
			tinymce.each(['onmouseover', 'onmouseout'], function(o){
				v = dom.value(o + 'src');
					
				if(!ed.getParam('relative_urls')){
					v 	= new tinymce.util.URI(ed.getParam('document_base_url')).toAbsolute(v);
				}
				if(v){
					args[o] = "this.src='" + v + "';";
				}
			});
		}
		// Get the IMG node
		el = ed.selection.getNode();
		// Get A node
		an = ed.dom.getParent(el, "A");
		
		if (el && el.nodeName == 'IMG') {
			// If popup enabled
			if(dom.ischecked('popup_check')){
				// Get popup args
				pa = this.getPopupArgs();
				// If existing popup node
				if(an){
					// Update popup
					ed.dom.setAttribs(an, pa);	
				}else{
					// Create new popup
					tinyMCEPopup.execCommand("CreateLink", false, "#mce_temp_url#");
					elementArray = tinymce.grep(ed.dom.select("a"), function(n) {return ed.dom.getAttrib(n, 'href') == '#mce_temp_url#';});
					for (i=0; i<elementArray.length; i++) {
						an = elementArray[i];
						// Move cursor to end
						try {
							tinyMCEPopup.editor.selection.collapse(false);
						} catch (ex) {
							// Ignore
						}
						ed.dom.setAttribs(an, pa);
					}
				}
			}else{
				ed.dom.setAttrib(an, 'class', '');
				// Remove existing popup if feature unchecked
				tinyMCEPopup.execCommand("unlink", false);
			}
			ed.dom.setAttribs(el, args);
			// BR clear
			pn = an || el;
			br = pn.nextSibling;
			if(br && br.nodeName == 'BR'){
				if(dom.disabled('clear') || dom.getSelect('clear') === ''){
					ed.dom.remove(br);	
				}
				if(!dom.disabled('clear') && dom.getSelect('clear') !== ''){
					ed.dom.setStyle(br, 'clear', dom.getSelect('clear'));
				}
			}else{
				if(!dom.disabled('clear') && dom.getSelect('clear') !== ''){
					br = ed.dom.create('br');
					ed.dom.setStyle(br, 'clear', dom.getSelect('clear'));
					ed.dom.insertAfter(br, pn);
				}
			}
			// Create/Update tooltip
			if(dom.ischecked('tooltip_check')){
				ed.dom.addClass(el, 'jcetooltip');	
				var text = dom.value('tooltip_text').replace(/\r\n/gi, '<br />').replace(/\r/gi, '<br />').replace(/\n/gi, '<br />');
				ed.dom.setAttrib(el, 'title', dom.value('tooltip_title') + '::' + text);
			}else{
				tinymce.each(['jcetooltip', 'jce_tooltip'], function(c){
					ed.dom.removeClass(el, c);											 
				});	
			}
		}else{
			var img = '<img id="__mce_tmp" src="javascript:;" />';
			// Popup
			if(dom.ischecked('popup_check')){
				img = '<a id="__mce_popup_tmp" href="javascript:;">' + img + '</a>';
			}
			// Insert initial element(s)
			ed.execCommand('mceInsertContent', false, img, {skip_undo : 1});
			// Find img element
			pn = ed.dom.get('__mce_popup_tmp') || ed.dom.get('__mce_tmp');
			// Add br clear
			if(!dom.disabled('clear') && dom.getSelect('clear') !== ''){
				br = ed.dom.create('br');
				ed.dom.setStyle(br, 'clear', dom.getSelect('clear'));
				ed.dom.insertAfter(br, pn);
			}
			// Create tooltip
			if(dom.ischecked('tooltip_check')){
				if(!/jcetooltip/i.test(dom.value('classes'))){
					this.setTooltip();	
				}
				var text = dom.value('tooltip_text').replace(/\r\n/gi, '<br />').replace(/\r/gi, '<br />').replace(/\n/gi, '<br />');
				tinymce.extend(args, {
					title: dom.value('tooltip_title') + '::' + text,
					'class': dom.value('classes')
				});	
			}
			// Update img element args
			ed.dom.setAttribs('__mce_tmp', args);
			ed.dom.setAttrib('__mce_tmp', 'id', '');
			// Update popup args
			an = ed.dom.get('__mce_popup_tmp');
			if(an){
				ed.dom.setAttribs('__mce_popup_tmp', this.getPopupArgs());
				ed.dom.setAttrib('__mce_popup_tmp', 'id', '');	
			}
			ed.undoManager.add();
		}
		tinyMCEPopup.close();
	},
	getAttrib : function(e, at) {
		var ed = tinyMCEPopup.editor, v = '', v2;
		switch (at) {
			case 'width':
			case 'height':
				return ed.dom.getAttrib(e, at) || ed.dom.getStyle(e, at) || '';
				break;	
			case 'align':
				if(v = ed.dom.getAttrib(e, 'align')){
					return v;	
				}
				if(v = ed.dom.getStyle(e, 'float')){
					return v;
				}
				if(v = ed.dom.getStyle(e, 'vertical-align')){
					return v;
				}
				break;
			case 'margin-top':
			case 'margin-bottom':
				if(v = ed.dom.getStyle(e, at)){
					if (v == 'auto') {
						return v;
					}
					return parseInt(v.replace(/[^-0-9]/g, ''));
				}
				if(v = ed.dom.getAttrib(e, 'vspace')){
					return parseInt(v.replace(/[^0-9]/g, ''));
				}
				break;
			case 'margin-left':
			case 'margin-right':
				if(v = ed.dom.getStyle(e, at)){
					if (v == 'auto') {
						return v;
					}
					return parseInt(v.replace(/[^-0-9]/g, ''));
				}
				if(v = ed.dom.getAttrib(e, 'hspace')){
					return parseInt(v.replace(/[^0-9]/g, ''));
				}
				break;
			case 'border-width':
			case 'border-style':
			case 'border-color':
				v = '';
				tinymce.each(['top', 'right', 'bottom', 'left'], function(n) {
					s = at.replace(/-/, '-' + n + '-');
					sv = ed.dom.getStyle(e, s);
					// False or not the same as prev
					if(sv !== '' || (sv != v && v !== '')){
						v = '';
					}
					if (sv){
						v = sv;
					}
				});
				if(at == 'border-color'){
					v = string.toHex(v);	
				}
				if(at == 'border-width' && v !== ''){
					dom.check('border', true);
					return parseInt(v.replace(/[^0-9]/g, ''));
				}
				return v;
				break;
		}
		return v;
	},
	setMargins : function(init){
		var x = false;
		if(init){
			tinymce.each(['right', 'bottom', 'left'], function(e){
				x = (dom.value('margin_' + e) == dom.value('margin_top'));
				dom.disable('margin_' + e, x);
			});
			dom.check('margin_check', x);
		}else{
			x = dom.ischecked('margin_check');		
			tinymce.each(['right', 'bottom', 'left'], function(e){
				if(x){
					dom.value('margin_' + e, dom.value('margin_top'));
				}
				dom.disable('margin_' + e, x);
			});
			this.updateStyles();
		}
	},
	setBorder : function(){
		if(dom.ischecked('border')){
			dom.disable('border_width', false); 
			dom.disable('border_style', false);
			dom.disable('border_color', false);
		}else{
			dom.disable('border_width', true); 
			dom.disable('border_style', true);
			dom.disable('border_color', true);
		}
		this.updateStyles();
	},
	setClasses : function(v){
		return Editor.utilities.setClasses(v);
	},
	setDimensions : function(a, b){
		return Editor.utilities.setDimensions(a, b);
	},
	setPopupType : function(t){
		var r = 'window';
		dom.disable('popup_icon', true);
		dom.disable('popup_icon_position', true);
		dom.check('popup_icon', false);
		if(t == 'window'){
			tinymce.each(['dimensions', 'mode', 'features'], function(e){
				dom.get('popup_' + e + '_row').style.display = '';												 
			});
			dom.get('popup_group_row').style.display = 'none';
		}else{
			tinymce.each(['dimensions', 'mode', 'features'], function(e){
				dom.get('popup_' + e + '_row').style.display = 'none';												 
			});	
			dom.get('popup_group_row').style.display = '';
			r = 'script';
			if(t == 'jcepopup'){
				r = 'jcemediabox';
				dom.disable('popup_icon', false);
				dom.disable('popup_icon_position', false);
				dom.check('popup_icon', true);
			}		
		}
		dom.html('popup_required', '<span class="message info">' + tinyMCEPopup.getLang('imgmanager_ext_dlg.required_' + r) + '</span>');
	},
	setPopupIcon : function(){
		dom.disable('popup_icon_position', !dom.ischecked('popup_icon'));
	},
	setTooltip : function(){
		return Editor.utilities.setClasses('jcetooltip');
	},
	setPopupMode :function(m){
		m = parseInt(m);
		dom.disable('popup_print', !m);
		dom.disable('popup_rightclick', !m);
		dom.disable('popup_scrollbars', !m);
		dom.disable('popup_resizable', !m);
	},
	setStyles : function(){
		var ed = tinyMCEPopup, img = dom.get('sample');
		ed.dom.setAttrib(img, 'style', dom.value('style'));
		
		// Margin
		tinymce.each(['top', 'right', 'bottom', 'left'], function(o){
			dom.value('margin_' + o, ImageManagerDialog.getAttrib(img, 'margin-' + o));														  
		});													  
		// Border
		if(this.getAttrib(img, 'border-width') !== ''){
			dom.check('border', true);
			this.setBorder();
			dom.setSelect('border_width', this.getAttrib(img, 'border-width'));
			dom.setSelect('border_style', this.getAttrib(img, 'border-style'));
			dom.value('border_color', this.getAttrib(img, 'border-color'));
		}
		// Align
		dom.setSelect('align', this.getAttrib(img, 'align'));
	},
	updateStyles : function() {
		var ed = tinyMCEPopup, st, v, br, img = dom.get('sample');
		ed.dom.setAttrib(img, 'style', dom.value('style'));
		
		ed.dom.setAttrib(img, 'dir', dom.value('dir'));
		
		// Handle align
		ed.dom.setStyle(img, 'float', '');
		ed.dom.setStyle(img, 'vertical-align', '');

		v = dom.getSelect('align');
		if (v == 'left' || v == 'right'){
			dom.disable('clear', false);
			dom.removeClass('clearlabel', 'disabled');					
			ed.dom.setStyle(img, 'float', v);
		}else{
			img.style.verticalAlign = v;
			dom.disable('clear', true);
			dom.addClass('clearlabel', 'disabled');	
		}
		// Handle clear
		v = dom.getSelect('clear');
		if (v && !dom.disabled('clear')) {
			br = dom.get('sample-br');
			if(!br){
				br = ed.dom.create('br', {'id': 'sample-br'});
				ed.dom.insertAfter(br, img);
			}
			ed.dom.setStyle(br, 'clear', v);
		}else{
			if(dom.get('sample-br')){
				ed.dom.remove('sample-br');
			}
		}
		// Handle border	
		tinymce.each(['width', 'color', 'style'], function(o){
			if(dom.ischecked('border')){
				v = dom.value('border_' + o);
			}else{
				v = '';	
			}
			ed.dom.setStyle(img, 'border-' + o, v);
		});
		// Margin
		tinymce.each(['top', 'right', 'bottom', 'left'], function(o){
			v = dom.value('margin_' + o);
			ed.dom.setStyle(img, 'margin-' + o,  /[^a-z]/i.test(v) ? v + 'px' : v);
		});
		// Merge
		ed.dom.get('style').value = ed.dom.serializeStyle(ed.dom.parseStyle(img.style.cssText));
	}
}
var ImageManager = Manager.extend({
	sliders : [],
	otherOptions : function(){
		return {
			// default list-limit
			listlimit :	'all',
			mode : 'list',
			
			onFileClick : function(file){
				this.selectFile(file);
			},
			
			onFileInsert : function(file){
				this.selectFile(this.getSelectedItems(0));	
			}.bind(this),
			
			onListComplete : function(){
				this.setMessage(tinyMCEPopup.getLang('imgmanager_ext_dlg.message_' + this.mode, 'Click on an image name to insert.'));
			}.bind(this),
			
			onLoadList: function(o) {
				
				var si = this.getSelectedItems(), t = this;
				si.each(function(e){
					// Is a file
					if(/file/i.test(e.className)){
						this.addReturnedItem(string.basename(e.title));
					}
				}.bind(this))		
				// Clear selects
				this.selectNoItems();
				
				o.folders.each(function(e){
					$('folder-list').adopt(
						new Element('li').addClass('folder').addClass(e.classes).setProperties({'id': encodeURIComponent(e.id), 'title': e.name}).addEvent('click', function(event){
							this.setSelectedItems(event, false);
						}.bind(this)).adopt(
							new Element('a').setProperty('href', 'javascript:;').setHTML(e.name).addEvent('click', function(){
								this.changeDir(e.id);
							}.bind(this))
						)
					)
				}.bind(this));
				$('file-list').empty();
				if(o.files.length){
					o.files.each(function(e){
						if(this.mode == 'list'){
							$('file-list').adopt(
								new Element('li').addClass('file').addClass(string.getExt(e.name)).addClass(e.classes).setProperties({'title': e.name}).addEvent('click', function(event){
									this.setSelectedItems(event, true);
								}.bind(this)).adopt(
									new Element('a').setProperty('href', 'javascript:void(0);').setHTML(e.name).addEvent('click', function(event){
										this.fireEvent('onFileClick', [new Event(event).target.getParent()]);
									}.bind(this))
								)
							)
						}else{
							//$('file-list').adopt(
							var li = new Element('li', {
								'title': e.name,
								events: {
									click: function(event){
										this.setSelectedItems(event, true)	
									}.bind(this),
									dblclick: function(event){
										this.fireEvent('onFileClick', [new Event(event).target.getParent()]);
									}.bind(this)
								}			
							}).addClass('file').addClass(string.getExt(e.name)).addClass(e.classes).addClass('thumbnail-preview').addClass('thumbnail-load');
							//)
							if(e.preview){
								var src = string.path(this.getSite(), e.preview);
								var img = new Element('img');
								
								function _calc(w, h) {
									
									if (w > 60) {
				                        h = h * (60 / w);
				                        w = 60;
				                    }
									
									if (h > 60) {
			                            w = w * (60 / h);
			                            h = 60;
			                        }
									
									if (w < 50) {
										h = h * (50 / w);
										w = 50;
									}
									
									if (h < 50) {
			                            w = w * (50 / h);
			                            h = 50;
			                        }

									return {
										width : parseFloat(w),
										height: parseFloat(h)
									};
								}
								
				                img.onload = function() {
				                	var w = img.width, h = img.height;

				                	if (w && h) {
				                		if (w < 50 && h < 50) {
				                			var thumb = new Element('span', {
						                        styles : {
					                    			'background-image' : 'url(' + src + ')'
					                    		}
						                    }).addClass('thumbnail');
					                		li.removeClass('thumbnail-load').adopt(thumb);
					                	} else {										
											img.setProperties(_calc(w, h));
						                	
						                    li.removeClass('thumbnail-load').adopt(img);
					                	}
				                	} else {
				                		var url = string.path(t.getParam('base'), string.path(t.getDir(), e.name));
				                		img.src = string.path(t.getSite(), url);
				                	}
				                };
				                
								img.onerror = function(){
									li.removeClass('thumbnail-load').addClass('thumbnail-error');
								};
								
								img.src = src;

							}else{
								li.removeClass('thumbnail-load').addClass('thumbnail-error');	
							}
							$('file-list').adopt(li);
						}	
					}.bind(this));
				}else{
					$('file-list').adopt(
						new Element('li').addClass('nofile').setHTML(tinyMCEPopup.getLang('dlg.no_files', 'No files'))
					)	
				}
				// Restore folder selection after mode switch
				if(si.length){
					si.each(function(e){
						if(/folder/i.test(e.className)){
							this.selectItemsByName(e.title, 'folder')
						}
					}.bind(this))
				}
			}.bind(this)
		};
	},
	initialize : function(src, options){
		this.setOptions(this.otherOptions(), options);
		// Get the default or cookie stored mode (list|images)
		var mode = Cookie.get('jce_imgmanager_ext_mode') || this.getParam('mode');
		// Store as option 
		this.mode = mode;
		if(this.getParam('canEdit')){
			// Set extra upload options
			$extend(this.options.upload, {
				body: this.getUploadOptions(),
				onLoad: function(){
					var defaults = this.getParam('defaults');
					// Resize defaults
					var upload_resize = $('upload-resize').checked = $('upload-resize').value = parseInt(defaults['upload-resize']) || 0;
					if(parseInt(defaults['allow-resize']) == 0){
						$('upload-resize').checked 	= false;
						$('upload-resize').disabled = true;
					}
					if(parseInt(defaults['force-resize']) == 1){
						$('upload-resize').checked = $('upload-resize').disabled = $('upload-resize').value = 1;
						upload_resize = false;
					}
					['upload-resize-width', 'upload-resize-height', 'upload-resize-width-type', 'upload-resize-height-type', 'upload-resize-quality'].each(function(r){
						$(r).value 		= defaults[r.replace('upload-', '', 'gi')];
						$(r).disabled 	= !upload_resize;
					});
					$('upload-resize-width-tmp').value 	= $('upload-resize-width').value;
					$('upload-resize-height-tmp').value = $('upload-resize-height').value;
					
					// Rotate defaults
					var upload_rotate = $('upload-rotate').checked = $('upload-rotate').value = parseInt(defaults['upload-rotate']) || 0;
					if(parseInt(defaults['allow-rotate']) == 0){
						$('upload-rotate').checked 	= false;
						$('upload-rotate').disabled = true;
					}					
					if(parseInt(defaults['force-rotate']) == 1){
						$('upload-rotate').checked = $('upload-rotate').disabled = $('upload-rotate').value = 1;
						upload_rotate = false;
					}
					$('upload-rotate-angle').value 		= defaults['rotate-angle'];
					$('upload-rotate-angle').disabled 	= !upload_rotate;
					// Thumbnail defaults
					/*if(parseInt(defaults['force-thumbnail']) == 1){
						$('upload-thumbnail').checked = $('upload-thumbnail').disabled = true;
					}*/
					var upload_thumbnail = $('upload-thumbnail').checked = $('upload-thumbnail').value = parseInt(defaults['upload-thumbnail']) || 0;
					if(parseInt(defaults['allow-thumbnail']) == 0){
						$('upload-thumbnail').checked 	= false;
						$('upload-thumbnail').disabled 	= true;
					}
					if(parseInt(defaults['force-thumbnail']) == 1){
						$('upload-thumbnail').checked = $('upload-thumbnail').disabled = $('upload-thumbnail').value = 1;
						upload_thumbnail = false;
					}
					['upload-thumbnail-size', 'upload-thumbnail-size-type', 'upload-thumbnail-quality', 'upload-thumbnail-mode'].each(function(t){
						$(t).value 		= defaults[t.replace('upload-', '', 'gi')];
						$(t).disabled 	= !upload_thumbnail;
					});
					// Create sliders
					if(parseInt(defaults['force-resize']) == 0){
						this.createSlider('upload-resize-quality', 10, 10, 100, defaults['resize-quality']);												  
					}else{
						// Set the handle position
						$('upload-resize-quality-handle').setStyle('left', parseInt(defaults['resize-quality']) - 10);
					}
					if(parseInt(defaults['force-thumbnail']) == 0){
						this.createSlider('upload-thumbnail-quality', 10, 10, 100, defaults['thumbnail-quality']);
					}else{
						// Set the handle position	
						$('upload-thumbnail-quality-handle').setStyle('left', parseInt(defaults['thumbnail-quality']) - 10);
					}
				}.bind(this)	
			});
		}
		// Initialise parent
		this.parent('imgmanager_ext', src, mode, this.options);
		// Setup up Mode Switch action
		mode = (mode == 'list') ? 'images' : 'list';
		if(this.getParam('canEdit')){
			$('view-mode').addClass(mode);
			$('view-mode').setProperty('title', tinyMCEPopup.getLang('imgmanager_ext_dlg.view_' + mode, 'Switch Mode'));
		}
	},
	selectFile : function(file){	
		var title	= file.title;
		var cls		= file.className;
		var url		= string.path(this.getDir(), title);
		var src 	= string.path(this.getParam('base'), url);
		src			= src.charAt(0) == '/' ? src.substring(1) : src;
		
		if(dom.hasClass('swap_panel', 'current') && dom.ischecked('onmousemovecheck') ){
			if(dom.value('onmouseoutsrc') == ''){
				dom.value('onmouseoutsrc', src);
			}else{
				dom.value('onmouseoversrc', src);
			}
		}
		if(dom.hasClass('general_panel', 'current')){
			dom.disable('insert', true);
			dom.value('onmouseoutsrc', src);
			dom.value('src', src);
					
			$('dim_loader').addClass('loader');
			this.xhr('getDimensions', url, function(o){
				if(!o.error){
					dom.value('width', o.width);
					dom.value('tmp_width', o.width);
					dom.value('height', o.height);
					dom.value('tmp_height', o.height);
				}
				$('dim_loader').removeClass('loader');
				dom.disable('insert', false);
				ImageManagerDialog.updateStyles();										
			});
		}
		if(dom.hasClass('popup_panel', 'current') && dom.ischecked('popup_check')){
			dom.disable('insert', true);
			dom.value('popup_src', src);
			dom.value('popup_title', string.stripExt(title));
					
			this.xhr('getDimensions', url, function(o){
				if(!o.error){
					dom.value('popup_width', o.width);
					dom.value('tmp_popup_width', o.width);
					dom.value('popup_height', o.height);
					dom.value('tmp_popup_height', o.height);
				}								
			});
			if(cls.contains('thumbnail')){	
				new Confirm(tinyMCEPopup.getLang('imgmanager_ext_dlg.use_thumbnail', 'Use associated thumbnail?'), function(state){
						if(state){
							this.setLoader();
							this.xhr('getThumbnailDimensions', url, function(o){		  															  
								if(!o.error){
									dom.value('width', o.width);
									dom.value('tmp_width', o.width);
									dom.value('height', o.height);
									dom.value('tmp_height', o.height);
									
									title 	= string.path(this.getParam('thumbnail-folder'), this.getParam('thumbnail-prefix') + title);
									url		= string.path(this.getDir(), title);
									src 	= string.path(this.getParam('base'), url);
									src		= src.charAt(0) == '/' ? src.substring(1) : src;
									
									dom.value('onmouseoutsrc', src);
									dom.value('src', src);
								}
								this.resetStatus();
							}.bind(this));
						}
					}.bind(this)
				);
			}
			dom.disable('insert', false);
			ImageManagerDialog.updateStyles();
		}
		dom.value('alt', string.stripExt(title));
	},
	switchMode : function(){
		if(!this.getParam('canEdit')){
			return false;	
		}
		var mode = $('view-mode').hasClass('list') ? 'list' : 'images';
		
		$('view-mode').removeClass(mode).addClass(this.mode);
		$('view-mode').setProperty('title', tinyMCEPopup.getLang('imgmanager_ext_dlg.view' + this.mode, 'Switch Mode'));
		
		this.mode = mode;
		Cookie.set('jce_imgmanager_ext_mode', mode, 1);
		this.setVars(mode);
		this.getList();
	},
	// Create width / height html form
	dimensionForm : function(prefix, items){
		var elements = [], form = [], quality = [], dimensions = [], constrain = [];		
		if(!items) items = ['width', 'height'];
		// Width / Height form elements
		items.each(function(o){
			var id = prefix + '-' + o;
			form.include( 
				new Element('div', {'class': 'row'}).adopt(
					new Element('label', {'for': id}).setHTML(tinyMCEPopup.getLang('imgmanager_ext_dlg.' + o, o))							   
				).adopt(
					new Element('input', {
						'type':'text', 
						'id': id,
						'name': id,
						'size': '10',
						'class': 'dimension-value',
						events:{
							change: function(){
								if(items.length > 1 && !$('dimension-constrain').hasClass('off')){
									var ot 	= id + '-tmp';
									if($(ot).value == ''){
										$(ot).value = $(id).value;	
									}
									// set n as other value
									var n 	= ( o == items[0] ) ? items[1] : items[0];
									n = prefix + '-' + n;
									// set nt as other temp value
									var nt 	= n + '-tmp';
									// if no values, return
									if($(n).value == '' || $(id).value == ''){
										return;	
									}
									// If type values are % and are equal, value is original.
									if($(id + '-type').value == 'pct' && $(n + '-type').value == 'pct'){
										var temp = $(id).value;
									}else if($(id + '-type').value == 'pct'){
										var temp = Math.round($(n).value * $(id).value / 100);	
									}else{
										var temp = $(id).value / $(ot).value * $(nt).value;
										temp = temp.toFixed(0);
									}
									$(n).value = temp;
								}else{
									if($(id + '-type').value == 'px'){
										$(id + '-tmp').value = $(id).value;	
									}
								}
							}
						}
					})
				).adopt(
					new Element('input', {'type':'hidden', 'id': id + '-tmp'})
				).adopt(
					new Element('select', {
						'id': id + '-type',
						'name': id + '-type',
						'class': 'dimension-type',
						events: {
							'change': function(){
								var n = ( o == items[0] ) ? items[1] : items[0];
								$(prefix + '-' + n + '-type').value = $(id + '-type').value;
								if($(id).value !== ''){
									switch($(id + '-type').value){
										case 'px':
											$(id).value = Math.round($(id).value * $(id + '-tmp').value / 100);
											$(prefix + '-' + n).value = Math.round($(prefix + '-' + n).value * $(prefix + '-' + n + '-tmp').value / 100);
											break;
										case 'pct':
											$(id).value = Math.round($(id).value / $(id + '-tmp').value * 100);
											$(prefix + '-' + n).value = Math.round($(prefix + '-' + n).value / $(prefix + '-' + n + '-tmp').value * 100);
											break;
									}
								}
							}
						}
					}).adopt(
						new Element('option', {
							'value': 'px'			
						}).setHTML('px')
					).adopt(
						new Element('option', {
							'value': 'pct'			
						}).setHTML('%')
					)
				)			  
			)								  
		})
		if(items.length > 1){
			dimensions = new Element('div').adopt(form).adopt(
				new Element('div', {
					'id': 'dimension-constrain',
					events: {
						click: function(){
							this.toggleClass('off')
						}
					}
				})
			)
		}else{
			dimensions = new Element('div').adopt(form);	
		}
		elements.include(dimensions);
		elements.include(constrain);
		
		elements.include(this.sliderForm(prefix, 'quality', 10));
		return elements;
	},
	sliderForm : function(prefix, name, step){
		var el = prefix + '-' + name;
		return new Element('div', {'class': 'row'}).adopt(
			new Element('label', {'for': el}).setHTML(tinyMCEPopup.getLang('imgmanager_ext_dlg.' + name, name))
		).adopt(
			new Element('div', {'id': el + '-slider', 'class': 'slider-background', styles:{'position': 'absolute'}}).adopt(
				new Element('div', {'id': el + '-handle', 'class': 'slider-handle', events: {
					mouseover : function(){
						this.addClass('slider-handle-over');
					},
					mouseout : function(){
						this.removeClass('slider-handle-over');
					}
				}})
			)
		).adopt(
			new Element('div').setStyles({'position':'absolute', 'left': '165px'}).adopt(
				new Element('input', {
					'id': el, 
					'name': el,
					'size': '3', 
					'maxlength': '3',
					events: {
						change: function(){
							var value 	= Math.round(parseInt($(el).value) / step);
							this.sliders[el].set(value);
						}.bind(this)
					}
				})
			).adopt(
				new Element('label').setHTML('&nbsp;%')
			)
		)
	},
	resizeForm : function(prefix){
		return new Element('div', {id: 'resize-form'}).adopt(
			new Element('fieldset').adopt(
				new Element('legend').adopt(
					new Element('input', {
						'type': 'checkbox', 
						'id': prefix,
						'name': prefix,
						'class': 'checkbox',
						'value': 0,
						events: {
							click: function(){
								this.value = (this.checked) ? 1 : 0;
								[prefix + '-width', prefix + '-height', prefix + '-width-type', prefix + '-height-type', prefix + '-quality'].each(function(el){
									$(el).disabled = !this.checked;																																				
								}.bind(this));																															
							}
						}
					})						 
				).adopt(
					new Element('label', {'for': prefix}).setHTML(tinyMCEPopup.getLang('imgmanager_ext_dlg.resize', 'Resize'))
				)
			).adopt(this.dimensionForm(prefix))				
		)
	},
	rotateForm : function(prefix){
		var options = [];
		['-90', '90', '180', 'vertical', 'horizontal'].each(function(o){
			options.include(new Element('option', {'value': o}).setHTML(tinyMCEPopup.getLang('imgmanager_ext_dlg.'+o, o)));																						  
		});
		var selection = new Element('div', {'class': 'row'}).adopt(
			new Element('label', {
				'for': prefix + 'rotate-angle'			
			}).setHTML(tinyMCEPopup.getLang('dlg.angle', 'Angle'))									
		).adopt(
			new Element('select', {'id': prefix + '-angle', 'name': prefix + '-angle'}).adopt(options)
		)		
		return new Element('div', {id: 'rotate-form'}).adopt(
			new Element('fieldset').adopt(
				new Element('legend').adopt(
					new Element('input', {
						'type': 'checkbox', 
						'id': prefix,
						'name': prefix,
						'class': 'checkbox',
						'value': 0,
						events: {
							click: function(){
								this.value = (this.checked) ? 1 : 0;
								$(prefix + '-angle').disabled = !this.checked;																																
							}
						}
					})						 
				).adopt(
					new Element('label', {'for': prefix}).setHTML(tinyMCEPopup.getLang('imgmanager_ext_dlg.rotate', 'Rotate'))
				)
			).adopt(selection)				
		)
	},
	createSlider : function(prefix, step, min, max, set){
		this.sliders[prefix] = new Slider($(prefix + '-slider'), $(prefix + '-handle'), {
			offset: 6,
			steps: step,
			onChange: function(n){
				if(n * step < min) n = min / step;
				if(n * step > max) n = max / step;
				$(prefix).value = n * step;
			}	 
		}).set(parseInt(set / step));
	},
	createThumbnailForm : function(prefix){
		return new Element('div', {id: 'thumbnail-form'}).adopt(
			this.dimensionForm(prefix, ['size'])
		).adopt(
			new Element('div').addClass('row').adopt(
				new Element('label', {'for': prefix + '-mode'}).setHTML(tinyMCEPopup.getLang('imgmanager_ext_dlg.mode', 'Mode'))						 
			).adopt(
				new Element('select', {'id': prefix + '-mode', 'name': prefix + '-mode', 'class': 'dimension-mode'}).adopt(
					new Element('option', {'value': '0'}).setHTML(tinyMCEPopup.getLang('imgmanager_ext_dlg.proportional', 'Proportional'))													  
				).adopt(
					new Element('option', {'value': '1'}).setHTML(tinyMCEPopup.getLang('imgmanager_ext_dlg.cropped', 'Cropped'))													  
				)
			)		   
		)
	},
	getUploadOptions : function(){		
		var resize = this.resizeForm('upload-resize');
		var rotate = this.rotateForm('upload-rotate');
		var thumbnail = new Element('div', {id: 'thumbnail-form'}).adopt(
			new Element('fieldset').adopt(
				new Element('legend').adopt(
					new Element('input', {
						'type': 'checkbox', 
						'id': 'upload-thumbnail',
						'name': 'upload-thumbnail',
						'class': 'checkbox',
						events: {
							click: function(){
								this.value = (this.checked) ? 1 : 0;
								['upload-thumbnail-size', 'upload-thumbnail-size-type', 'upload-thumbnail-quality', 'upload-thumbnail-mode'].each(function(el){
									$(el).disabled = !this.checked;																																				
								}.bind(this));
							}
						}
					})						 
				).adopt(
					new Element('label', {'for': 'upload-thumbnail'}).setHTML(tinyMCEPopup.getLang('imgmanager_ext_dlg.thumbnail', 'Thumbnail'))
				)
			).adopt(
				this.createThumbnailForm('upload-thumbnail')
			)
		)
		return new Element('div').adopt(resize).adopt(rotate).adopt(thumbnail);
	},
	transformImage : function(){		
		var resize = this.resizeForm('resize');
		var rotate = this.rotateForm('rotate');
		var body = new Element('div', {'id': 'transform-body'}).adopt(resize).adopt(rotate);
		this.addDialog('transform', new basicDialog(tinyMCEPopup.getLang('imgmanager_ext_dlg.transform', 'Transform'), body, {
			width: 280,
			height: 250,
			buttons: [{
				'text': tinyMCEPopup.getLang('dlg.ok', 'OK'),
				'class': 'mceOk',
				'click': function(){
					if($('resize').checked || $('rotate').checked){
						var file = this.serializeSelectedItems();
						this.setLoader();
						this.xhr('transformImage', [
								file, 
								$('resize').value,
								$('resize-width').value, 
								$('resize-height').value, 
								$('resize-width-type').value, 
								$('resize-quality').value,
								$('rotate').value,
								$('rotate-angle').value
							], function(o) {		  															  
								if (o.error) {
									if (typeof o.error == 'boolean') {
										o.error = tinyMCEPopup.getLang('imgmanager_ext_dlg.transform_error', 'Transform Error')
									}
									this.raiseError(o.error);
								} else {
									this.resetManager();
									this.addReturnedItem(string.basename(file));
									this.getList();
									this.removeDialog('transform');
								}	
						}.bind(this))
					}
				}.bind(this)
			},{
				'text': tinyMCEPopup.getLang('dlg.cancel', 'Cancel'),
				'class': 'mceCancel',
				'click': function(){
					this.removeDialog('transform');
				}.bind(this)
			}],
			onOpen : function(){
				var defaults = this.getParam('defaults');				
				
				var dim = $('info-dimensions').getText().replace(/[^0-9x]/gi, '').split('x');
				$('resize-width').value 	= $('resize-width-tmp').value 	= dim[0].toInt();
				$('resize-height').value 	= $('resize-height-tmp').value 	= dim[1].toInt();

				// Resize defaults
				$('resize').checked 		= parseInt(defaults['resize']) || false;
				$('resize-quality').value 	= defaults['resize-quality'];
				['resize-width', 'resize-height', 'resize-quality'].each(function(r){
					$(r).disabled = !$('resize').checked;
				});
				$('resize-width-tmp').value 	= $('resize-width').value;
				$('resize-height-tmp').value 	= $('resize-height').value;
				// Rotate defaults
				$('rotate').checked 			= parseInt(defaults['rotate']) || false;
				$('rotate-angle').value 		= defaults['rotate-angle'];
				$('rotate-angle').disabled 		= !$('rotate').checked;
				// Access
				if(!parseInt(defaults['allow-resize'])){
					$('resize').disabled = true;
					$('resize').checked =false;
				}
				if(!parseInt(defaults['allow-rotate'])){
					$('rotate').disabled = true;
					$('rotate').checked =false;
				}
				// Create sliders
				this.createSlider('resize-quality', 10, 10, 100, defaults['resize-quality']);
			}.bind(this)
		}));
	},
	createThumbnail : function(){
		var body = new Element('div', {'id': 'thumbnail-body'}).adopt(
			new Element('fieldset').adopt(
				this.createThumbnailForm('thumbnail')
			)
		)
		this.addDialog('create-thumbnail', new basicDialog(tinyMCEPopup.getLang('imgmanager_ext_dlg.create_thumbnail', 'Create Thumbnail'), body, {
			width: 250,
			height: 160,
			buttons: [{
				'text': tinyMCEPopup.getLang('dlg.ok', 'OK'),
				'class': 'mceOk',
				'click': function(){
					this.setLoader();
					var file = this.serializeSelectedItems();
					this.xhr('createThumbnail', [file, $('thumbnail-size').value, $('thumbnail-size-type').value, $('thumbnail-quality').value, $('thumbnail-mode').value], function(o){		  															  
						if (o.error) {
							if (typeof o.error == 'boolean') {
								o.error = tinyMCEPopup.getLang('imgmanager_ext_dlg.create_thumbnail_error', 'Create Thumbnail Error')
							}
							this.raiseError(o.error);
						} else {
							this.resetManager();
							this.addReturnedItem(string.basename(file));
							this.getList();
							this.removeDialog('create-thumbnail');
						}
					})
				}.bind(this)
			},{
				'text': tinyMCEPopup.getLang('dlg.cancel', 'Cancel'),
				'class': 'mceCancel',
				'click': function(){
					this.removeDialog('create-thumbnail');
				}.bind(this)
			}],
			onOpen : function(){
				var defaults = this.getParam('defaults');
				$('thumbnail-size').value 		= defaults['thumbnail-size'];
				$('thumbnail-size-type').value 	= defaults['thumbnail-size-type'];
				$('thumbnail-mode').value 		= defaults['thumbnail-mode'];
				this.createSlider('thumbnail-quality', 10, 10, 100, defaults['thumbnail-quality']);
			}.bind(this)
		}));
	},
	deleteThumbnail : function(){
		var dir = string.path(this.getDir(), this.getParam('thumbnail-folder'));
		new Confirm(tinyMCEPopup.getLang('imgmanager_ext_dlg.delete_thumbnail', 'Delete Thumbnail?'), function(state){
				if(state){
					this.setLoader();
					var file = this.serializeSelectedItems();
					this.xhr('deleteThumbnail', file, function(o){		  															  
						if(!o.error){
							this.resetManager();
							this.addReturnedItem(string.basename(file));
							this.getList();
							if(o.text){
								this.fireEvent('onFolderDelete', [dir]);	
							}
						}else{
							this.raiseError(o.error);
						}
					}.bind(this));
				}
			}.bind(this)
		);
	},
	getPopupDimensions : function(file){
		$('popup_loader').addClass('loader');
		this.xhr('getDimensions', file, function(o){		  															  
			if(!o.error){
				$('popup_loader').removeClass('loader');
				$('popup_width').value 	= $('tmp_popup_width').value 	= o.width;
				$('popup_height').value = $('tmp_popup_height').value 	= o.height;
			}else{
				this.raiseError(o.error);
			}
		})
	},
	/**
	 * Get a files details / properties
	 */
	getFileDetails : function(){
		var t = this;
		var file 		= this._selectedItems[this._activeItem];
		var title 		= $(file).title;
			
		$(this.options.dialog.info).empty().addClass('loader');

		this.xhr('getFileDetails', string.path(this._dir, title), function(o){
			var name = string.stripExt(title);
			
			if (name.length > 25) {
				name = name.substr(0, 25) + '...';
			}
			
			// Info list
			var info = new Element('dl').adopt([
				new Element('dt').setHTML(name), 
				new Element('dd').setHTML(string.getExt(title).toUpperCase() + ' ' + tinyMCEPopup.getLang('dlg.file', 'File')), 
				new Element('dd').setProperty('id', 'info-properties'), 
				new Element('dd').setProperty('id', 'info-preview')
			]);
			
			$(this.options.dialog.info).removeClass('loader').empty().adopt(info);
			
			$each(o, function(v, k){
				// If a button trigger or triggers
				if (o.trigger) {
					o.trigger.each(function(t){
						if (t !== '') {
							var b = this.getButton('file', t);
							if (b) {
								this.showButton(b.element, b.multiple);
							}
						}
					}.bind(this));
				}
				if (!/(trigger|preview)/i.test(k)) {
					$('info-properties').adopt(new Element('dd').setProperty('id', 'info-' + k.toLowerCase()).setHTML(tinyMCEPopup.getLang('dlg.' + k, k) + ': ' + v));
				}
			}.bind(this));

			// Preview
			if (o.preview) {										
				$('info-preview').empty().adopt(new Element('dl').adopt([
					new Element('dt').setHTML(tinyMCEPopup.getLang('dlg.preview', 'Preview') + ': '), 
					new Element('dd').setStyle('height', 80).addClass('loader')
				]));
				
				var src = o.preview.src;
                var img = new Element('img');
                
                img.onload = function() {
                    var w = img.width;
                    var h = img.height;
					
					// set dimensions
					if (typeof o.dimensions != 'undefined' && o.dimensions == '') {
						if ($('info-dimensions')) {
							$('info-dimensions').setHTML(tinyMCEPopup.getLang('dlg.dimensions', 'Dimensions') + ': ' + w + ' x ' + h);
						}
					}
                    
                    if (w > 100) {
                        h = h * (100 / w);
                        w = 100;
                        if (h > 80) {
                            w = w * (80 / h);
                            h = 80;
                        }
                    } else if (h > 80) {
                        w = w * (80 / h);
                        h = 80;
                        if (w > 100) {
                            h = h * (100 / w);
                            w = 100;
                        }
                    }
                    if ($E('dd', $('info-preview'))) {
                    	img.setProperties({
                    		width : w,
                    		height: h
                    	});
                    	$E('dd', $('info-preview')).removeClass('loader').adopt(img);
                    }
                };
				img.onerror = function(){
					if ($E('dd', $('info-preview'))) {
						$E('dd', $('info-preview')).removeClass('loader').addClass('preview-error');
					}
				};
				img.src = src;
			}
			// Comments
			var comments = [];
			if (/not(writable|safe)/i.test($(file).className)) {
				comments.include(new Element('dt').setHTML(tinyMCEPopup.getLang('dlg.comments', 'Comments')));
				// not writable
				if ($(file).hasClass('notwritable')) {
					comments.include(new Element('dd').addClass('comments').addClass('file').addClass('notwritable').adopt(new Element('span').addClass('hastip').setProperty('title', tinyMCEPopup.getLang('dlg.notwritable_desc', 'Unwritable')).setHTML(tinyMCEPopup.getLang('dlg.notwritable', 'Unwritable'))));
				}
				// not safe
				if ($(file).hasClass('notsafe')) {
					comments.include(new Element('dd').addClass('comments').addClass('file').addClass('notsafe').adopt(new Element('span').addClass('hastip').setProperty('title', tinyMCEPopup.getLang('dlg.bad_name_desc', 'Bad file or folder name')).setHTML(tinyMCEPopup.getLang('dlg.bad_name', 'Bad file or folder name'))));
				}
			}
			if (comments.length) {
				$(this.options.dialog.comments).empty().adopt(new Element('dl').adopt(comments));
			}
			// Add tooltip
			this.addToolTip($ES('span.hastip', $ES('dd.comments')));
			// Fire event
			this.fireEvent('onFileDetails', [o]);
		}.bind(this));
	}
});
ImageManager.implement(new Events, new Options);
ImageManagerDialog.preInit();
tinyMCEPopup.onInit.add(ImageManagerDialog.init, ImageManagerDialog);