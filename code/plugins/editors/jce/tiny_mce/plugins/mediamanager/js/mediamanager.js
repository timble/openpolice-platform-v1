var MediaManagerDialog = {
	params : {},
	settings : {},
	mediatypes : null,
	preInit : function() {
		tinyMCEPopup.requireLangPack();
	},
	init : function() {
		var t = this, ed = tinyMCEPopup.editor, s = ed.selection, n = s.getNode(), pl = "", val, args, type = 'flash', i;
		
		this.mediatypes = this.mapTypes();
		
		tinyMCEPopup.resizeToInnerSize();	
		
		TinyMCE_Utils.fillClassList('classlist');
		
		dom.html('bgcolor_pickcontainer', TinyMCE_Utils.getColorPickerHTML('bgcolor'));	
		dom.html('border_color_pickcontainer', TinyMCE_Utils.getColorPickerHTML('border_color'));
		TinyMCE_Utils.updateColor('bgcolor');
		TinyMCE_Utils.updateColor('border_color');
		// FLV
		dom.html('flv_frontcolor_pickcontainer', TinyMCE_Utils.getColorPickerHTML('flv_frontcolor'));
		dom.html('flv_lightcolor_pickcontainer', TinyMCE_Utils.getColorPickerHTML('flv_lightcolor'));
		dom.html('flv_screencolor_pickcontainer', TinyMCE_Utils.getColorPickerHTML('flv_screencolor'));
		dom.html('flv_backcolor_pickcontainer', TinyMCE_Utils.getColorPickerHTML('flv_backcolor'));
		TinyMCE_Utils.updateColor('flv_frontcolor');
		TinyMCE_Utils.updateColor('flv_lightcolor');
		TinyMCE_Utils.updateColor('flv_screencolor');
		TinyMCE_Utils.updateColor('flv_backcolor');
	
		dom.html('flv_image_browsercontainer', TinyMCE_Utils.getBrowserHTML('flv_image_browsercontainer','flv_image','image','browser'));
		dom.html('divx_previewimage_browsercontainer', TinyMCE_Utils.getBrowserHTML('divx_previewimage_browsercontainer','divx_previewimage','image','browser'));
		
		if(!s.getContent()){
			dom.disable('popup_check', true);	
		}
		if(this.isMedia(n)){
			pl = "x={" + n.title + "};";
			
			var cl = n.className.match(/mceItem(Flash|ShockWave|WindowsMedia|QuickTime|RealMedia|DivX|PDF|Silverlight)/);
			if (cl) {
				cl = cl[0];
			}

			switch (cl) {
				case 'mceItemFlash':
					type = 'flash';
					break;
	
				case 'mceItemShockWave':
					type = 'director';
					break;
	
				case 'mceItemWindowsMedia':
					type = 'windowsmedia';
					break;
	
				case 'mceItemQuickTime':
					type = 'quicktime';
					break;
	
				case 'mceItemRealMedia':
					type = 'real';
					break;
					
				case 'mceItemDivX':
					type = 'divx';
					break;
			}
			dom.value('insert', tinyMCEPopup.getLang('update', 'Update', true));
			dom.disable('popup_check', true);
		}else{
			// Is popup
			if((n.nodeName == 'A' || ed.dom.getParent(n, 'A') != null) && this.isPopup(n)){
				dom.check('popup_check', true);
				type = ed.dom.getAttrib(n, 'type').toLowerCase();
				type = /(flash|real|divx|quicktime|director|mplayer|windowsmedia)/i.exec(type)[0];
				
				pl = {
					src : ed.dom.getAttrib(n, 'href')	
				}
				// Legacy title attribute
				var title = ed.dom.getAttrib(n, 'title');
				dom.value('popup_link_title', title);
				if(/\[.*\]/.test(title)){
					args = title.split(';');
					tinymce.each(args, function(e){
						kv = e.match(/(.+)\[(.*?)\]/);
						pl[kv[1]] = kv[2];
					});
					title = pl.title || '';
				}
				var rel = ed.dom.getAttrib(n, 'rel');
				if(/\[.*\]/.test(rel)){
					args = rel.split(';');
					tinymce.each(args, function(e){
						kv = e.match(/(.+)\[(.*?)\]/);
						pl[kv[1]] = kv[2];
					});
					title = pl.title || '';
					group = pl.group || '';
				}else{
					group = rel;	
				}
				dom.value('popup_title', title);
				dom.value('popup_group', group);
				
				n.width 	= pl.width 	|| '';
				n.height 	= pl.height || '';
				
				dom.value('insert', tinyMCEPopup.getLang('update', 'Update', true));
			}
		}

		// Setup form
		if (pl !== '') {
			pl = eval(pl);
	
			if(typeof pl.url != 'undefined' && pl.url !== ''){
				pl.src = pl.url;	
			}
			
			pl.width 	= n.width || ed.dom.getStyle(n, 'width');
			pl.height 	= n.height || ed.dom.getStyle(n, 'height');
			
			switch (type) {
				case 'flash':
				default:
					this.setBool(pl, 'flash', 'play', true);
					this.setBool(pl, 'flash', 'loop', true);
					this.setBool(pl, 'flash', 'menu', true);
					this.setBool(pl, 'flash', 'swliveconnect', false);
					this.setBool(pl, 'flash', 'allowfullscreen', false);
					this.setStr(pl, 'flash', 'quality');
					this.setStr(pl, 'flash', 'scale');
					this.setStr(pl, 'flash', 'salign');
					this.setStr(pl, 'flash', 'wmode');
					this.setStr(pl, 'flash', 'base');
					this.setStr(pl, 'flash', 'flashvars');
				break;
				case 'quicktime':			
					this.setBool(pl, 'quicktime', 'loop', false);
					this.setBool(pl, 'quicktime', 'autoplay', false);
					this.setBool(pl, 'quicktime', 'cache', false);
					this.setBool(pl, 'quicktime', 'controller', true);
					this.setBool(pl, 'quicktime', 'correction', false);
					this.setBool(pl, 'quicktime', 'enablejavascript', false);
					this.setBool(pl, 'quicktime', 'kioskmode', false);
					this.setBool(pl, 'quicktime', 'autohref', false);
					this.setBool(pl, 'quicktime', 'playeveryframe', false);
					this.setBool(pl, 'quicktime', 'targetcache', false);
					this.setStr(pl, 'quicktime', 'scale');
					this.setStr(pl, 'quicktime', 'starttime');
					this.setStr(pl, 'quicktime', 'endtime');
					this.setStr(pl, 'quicktime', 'tarset');
					this.setStr(pl, 'quicktime', 'qtsrcchokespeed');
					this.setStr(pl, 'quicktime', 'volume');
					this.setStr(pl, 'quicktime', 'qtsrc');
				break;
				case "director":
					this.setBool(pl, 'director', 'sound');
					this.setBool(pl, 'director', 'progress');
					this.setBool(pl, 'director', 'autostart');
					this.setBool(pl, 'director', 'swliveconnect');
					this.setStr(pl, 'director', 'swvolume');
					this.setStr(pl, 'director', 'swstretchstyle');
					this.setStr(pl, 'director', 'swstretchhalign');
					this.setStr(pl, 'director', 'swstretchvalign');
				break;
				case 'windowsmedia':
				case 'mplayer':
					this.setBool(pl, 'windowsmedia', 'autostart', false);
					this.setBool(pl, 'windowsmedia', 'enabled', false);
					this.setBool(pl, 'windowsmedia', 'enablecontextmenu', true);
					this.setBool(pl, 'windowsmedia', 'fullscreen', false);
					this.setBool(pl, 'windowsmedia', 'invokeurls', true);
					this.setBool(pl, 'windowsmedia', 'mute', false);
					this.setBool(pl, 'windowsmedia', 'stretchtofit', false);
					this.setBool(pl, 'windowsmedia', 'windowlessvideo', false);
					this.setStr(pl, 'windowsmedia', 'balance');
					this.setStr(pl, 'windowsmedia', 'baseurl');
					this.setStr(pl, 'windowsmedia', 'captioningid');
					this.setStr(pl, 'windowsmedia', 'currentmarker');
					this.setStr(pl, 'windowsmedia', 'currentposition');
					this.setStr(pl, 'windowsmedia', 'defaultframe');
					this.setStr(pl, 'windowsmedia', 'playcount');
					this.setStr(pl, 'windowsmedia', 'rate');
					this.setStr(pl, 'windowsmedia', 'uimode');
					this.setStr(pl, 'windowsmedia', 'volume');
					type = 'windowsmedia';
				break;
				case 'real':			
					this.setBool(pl, 'real', 'autostart', false);
					this.setBool(pl, 'real', 'loop', false);
					this.setBool(pl, 'real', 'autogotourl', true);
					this.setBool(pl, 'real', 'center', false);
					this.setBool(pl, 'real', 'imagestatus', true);
					this.setBool(pl, 'real', 'maintainaspect', false);
					this.setBool(pl, 'real', 'nojava', false);
					this.setBool(pl, 'real', 'prefetch', false);
					this.setBool(pl, 'real', 'shuffle', false);
					this.setStr(pl, 'real', 'console');
					this.setStr(pl, 'real', 'controls');
					this.setStr(pl, 'real', 'numloop');
					this.setStr(pl, 'real', 'scriptcallbacks');
				break;
				case 'divx':
					this.setStr(pl, 'divx', 'mode');
					this.setStr(pl, 'divx', 'minversion');
					this.setStr(pl, 'divx', 'bufferingmode');
					this.setStr(pl, 'divx', 'previewimage');
					this.setStr(pl, 'divx', 'previewmessage');
					this.setStr(pl, 'divx', 'previewmessagefontsize');
					this.setStr(pl, 'divx', 'movietitle');
					this.setBool(pl, 'divx', 'allowcontextmenu', true);
					this.setBool(pl, 'divx', 'autoplay', true);
					this.setBool(pl, 'divx', 'loop', false);
					this.setBool(pl, 'divx', 'bannerenabled', true);
				break;
				case "video":
					this.setBool(pl, 'video', 'autoplay');
					this.setBool(pl, 'video', 'controls');
					this.setBool(pl, 'video', 'loop');
					this.setBool(pl, 'video', 'preload');
				break;
				case "audio":
					this.setBool(pl, 'audio', 'autoplay');
					this.setBool(pl, 'audio', 'controls');
					this.setBool(pl, 'audio', 'preload');
				break;
			}
			tinymce.each(['src', 'name', 'width', 'height'], function(k){
				t.setStr(pl, null, k);														  
			});			
			// TMP width/height
			dom.value('tmp_width', dom.value('width'));
			dom.value('tmp_height', dom.value('height'));			
			// Margin
			tinymce.each(['top', 'right', 'bottom', 'left'], function(o){
				dom.value('margin_' + o, MediaManagerDialog.getAttrib(n, 'margin-' + o));														  
			});
			dom.setSelect('border_width', this.getAttrib(n, 'border-width'), true);
			dom.value('border_style', this.getAttrib(n, 'border-style'));
			dom.value('border_color', this.getAttrib(n, 'border-color'));
			
			dom.value('style', ed.dom.getAttrib(n, 'style'));
			dom.value('id', ed.dom.getAttrib(n, 'id'));
			dom.value('align', this.getAttrib(n, 'align'));
			
			// Test for flv or xml files
			if(type == 'flash' && (this.isFlv(pl.src) || this.isFlv(dom.value('flash_flashvars')))){				
				var fv 		= dom.value('flash_flashvars');
				var params 	= string.query(decodeURIComponent(fv));
				this.getFlv(fv, params);
				
				dom.value('controller_height', 16);
								
				TinyMCE_Utils.updateColor('flv_frontcolor');
				TinyMCE_Utils.updateColor('flv_lightcolor');
				TinyMCE_Utils.updateColor('flv_screencolor');
				TinyMCE_Utils.updateColor('flv_backcolor');
				
				this.setFlvPreview();
			}
		}
		// Initialize manager
		var src = dom.value('src');
		this.mediamanager = new MediaManager(src, this.settings);
		
		dom.value('src', src);
		
		dom.setSelect('media_type', type);
		this.changedType();
		
		if(pl === ''){
			// Setup default values
			this.setDefaults();		
		}
		TinyMCE_Utils.updateColor('bgcolor');
		
		// Setup border
		this.setBorder();
		// Setup margins
		this.setMargins(true);
		// Setup Styles
		this.updateStyles();
		TinyMCE_EditableSelects.init();
	},
	setDefaults : function(){
		var d = this.mediamanager.getParam('defaults');		
		Editor.utilities.setDefaults(d);
	},
	getFlv : function(fv, p){
		tinymce.each(p, function(v, k){
			if(k == 'file'){
				if(v.indexOf(MediaManagerDialog.getSiteRoot()) != -1){
					dom.check('flv_absolute', true);	
				}
				dom.value('src', tinyMCEPopup.editor.documentBaseURI.toRelative(v));
			}else if(/^(autostart|repeat)$/.test(k)){
				dom.check('flv_' + k, eval(v));				
			}else if(/^(front|back|light|screen)color$/.test(k)){
				dom.value('flv_' + k, v.replace(/0x/, '#'));
				dom.check('flv_' + k + '_check', true);
			}else{
				dom.value('flv_' + k, v);	
			}
		});
		fv = fv.replace(/(&?)(file|autostart|repeat|image|bufferlength|frontcolor|backcolor|lightcolor|screencolor)=([^&]*)/gi, '');
		dom.value('flash_flashvars', fv);
	},
	getFlvPlayer : function(){
		return string.path(this.mediamanager.getParam('flv_player_path'), this.mediamanager.getParam('flv_player'));
	},
	getSiteRoot : function(){
		var s = tinyMCEPopup.getParam('document_base_url');
		return s.match(/.*:\/\/([^\/]+)(.*)/)[2];
	},
	setFlv : function(s){
		var fv = [];
		
		var ffv = dom.value('flash_flashvars');
		if(ffv !== ''){
			fv.push(ffv);
		}
		
		if(s){
			s = dom.ischecked('flv_absolute') ? string.path(this.getSiteRoot(), s) : s;
			// Add http
			if(/^\s*www./i.test(s)){
				s = 'http://' + s;	
			}
			
			fv.push('file=' + s);
		}
		
		tinymce.each(['autostart', 'repeat'], function(k){
			if(dom.ischecked('flv_' + k)){
				fv.push(k + '=true');
			}
		});
		tinymce.each(['frontcolor', 'lightcolor', 'screencolor', 'backcolor'], function(k){
			v = dom.value('flv_' + k);
			if(v && dom.ischecked('flv_' + k + '_check')){
				fv.push(k + '=' + v.replace(/#/, '0x'));
			}
		});
		tinymce.each(['bufferlength', 'image'], function(k){
			v = dom.value('flv_' + k);
			if(v){
				v = k == 'image' ? string.encode(v) : v;
				fv.push(k + '=' + v);
			}										   
		});
		return fv.join('&');
	},
	setControllerHeight : function(t){
		var v = 0;
		switch(t){
			case 'flash':
				if(this.isFlv()){
					v = 16;	
				}
				break;
			case 'quicktime':
				v = 16;
				break;
			case 'windowsmedia':
				v = 16;
				break;
			case 'divx':
				switch(dom.getSelect('divx_mode')){
					default:
						v = 0;
						break;
					case 'mini':
						v = 20;
						break;
					case 'large':
						v = 65
						break;
					case 'full':
						v = 90;
						break;
				}
				break;
		}
		dom.value('controller_height', v);
	},
	isPopup : function(n){
		if(n.nodeName == 'A' || tinyMCEPopup.editor.dom.getParent(n, 'A') != null){
			return /^(jcepopup)$/.test(n.className) && (/(flash|quicktime|director|shockwave|windowsmedia|mplayer|real|realaudio|divx|video|audio)/.test(n.type) || /(youtube|google|metacafe)/.test(n.href));
		}
		return false;
	},
	isMedia : function(n){
		if(n.nodeName == 'IMG' || n.nodeName == 'SPAN'){
			return /mceItem(Flash|ShockWave|WindowsMedia|QuickTime|RealMedia|DivX|Video|Audio)/.test(tinyMCEPopup.editor.dom.getAttrib(n, 'class'));
		}
		return false;
	},
	isFlv : function(s){
		if (!s) 
			s = dom.value('src');

		return this.checkType(s) == 'flash' && /\.(flv|xml|mp4|mp3)/i.test(s);
	},
	getMediaType : function(type){
		switch (type) {
			case 'flash':
				return 'application/x-shockwave-flash';
				break;
			case 'director':
				return 'application/x-director';
				break;
			case 'quicktime':
				return 'video/quicktime';
				break;
			case 'mplayer':
			case 'windowsmedia':
				return 'application/x-mplayer2';
				break;
			case 'realaudio':
			case 'real':
				return 'audio/x-pn-realaudio-plugin';
				break;
			case 'divx':
				return 'video/divx';
				break;
		}
	},
	insert : function(){
		var v = dom.value('src'), t = this.getType(v), w = dom.value('width'), h = dom.value('height'); 
		AutoValidator.validate(document);
		if(v === ''){
			new Alert(tinyMCEPopup.getLang('mediamanager_dlg.no_src', 'Please select a file or enter in a link to a file'));
			return false;		
		}
		if(w === '' && !dom.ischecked('popup_check')){
			new Alert(tinyMCEPopup.getLang('mediamanager_dlg.no_width', 'A width value is required.'));
			return false;		
		}
		if(h === '' && !dom.ischecked('popup_check')){
			new Alert(tinyMCEPopup.getLang('mediamanager_dlg.no_height', 'A height value is required.'));
			return false;		
		}
		if(/(windowsmedia|mplayer|quicktime|divx)$/.test(t) || /\.(flv|xml)$/.test(v)){
			new Confirm(tinyMCEPopup.getLang('mediamanager_dlg.add_controls_height', 'Add additional height for player controls?'), function(state){
					if(state){
						dom.value('height', parseInt(h) + parseInt(dom.value('controller_height')));	
					}
					MediaManagerDialog.insertAndClose();
				}
			);
		}else{
			this.insertAndClose();	
		}
	},
	insertAndClose : function() {
		var n, an, args = {}, params, cls, ed = tinyMCEPopup.editor;
		var v = dom.value('src'), t = this.getType(v), w = parseInt(dom.value('width')), h = parseInt(dom.value('height'));
		
		var type = dom.getSelect('media_type');
		
		n 	= ed.selection.getNode();
		an 	= ed.dom.getParent(n, 'A');
		
		// Add http
		if(/^\s*www./i.test(v)){
			v = 'http://' + v;	
		}
		// Serialize parameters
		params = this.serializeParameters();
		
		tinyMCEPopup.execCommand("mceBeginUndoLevel");
		
		if(n != null && this.isMedia(n)){
			switch (t) {
				case "flash":
					cls = "mceItemFlash";
					break;
				case "director":
					cls = "mceItemShockWave";
					break;
				case "quicktime":
					cls = "mceItemQuickTime";
					break;
				case "mplayer":
				case "windowsmedia":
					cls = "mceItemWindowsMedia";
					break;
				case "realaudio":
				case "real":
					cls = "mceItemRealMedia";
					break;
				case "divx":
					cls = "mceItemDivX";
					break;
				case 'video':
					cls = "mceItemVideo";
					break;
				case 'audio':
					cls = "mceItemAudio";
					break;
			}			
			tinymce.extend(args, {
				width 	: w,
				height 	: h,
				title 	: params,
				style 	: dom.value('style'),
				id 		: dom.value('id'),
				name 	: dom.value('name')
			});
			ed.dom.setAttribs(n, args);
			n.className = cls;
		}else{	
			// Remove popup
			if(an && this.isPopup(an)){
				if(!dom.ischecked('popup_check')){
					ed.dom.setAttrib(an, 'class', '');
					// Remove existing popup if feature unchecked
					tinyMCEPopup.execCommand("unlink", false);
				}
			}
			// Popup
			if(dom.ischecked('popup_check') && n != null){
				tinymce.extend(args, {
					href 	: this.isFlv(v) ? this.getFlvPlayer() : v,
					title 	: dom.value('popup_link_title'),
					'class' : 'jcepopup',
					rel		: this.getPopupParams() || dom.value('popup_group'),
					type	: this.getMediaType(t)
				});
				// Create new anchor elements
				if(an == null){
					tinyMCEPopup.execCommand("CreateLink", false, "#mce_temp_url#", {skip_undo : 1});
			
					elementArray = tinymce.grep(ed.dom.select("a"), function(n) {return ed.dom.getAttrib(n, 'href') == '#mce_temp_url#';});
					for (i=0; i<elementArray.length; i++){
						an = elementArray[i];
						
						if(an.childNodes.length != 1 || an.firstChild.nodeName != 'IMG') {
							ed.focus();
							ed.selection.select(an);
							ed.selection.collapse(0);
							tinyMCEPopup.storeSelection();
						}		
						ed.dom.setAttribs(an, args);
					}
				}else{
					ed.dom.setAttribs(an, args);
				}
			}else{
				switch (type) {
					case "flash":
						cls = "mceItemFlash";
					break;
					case "director":
						cls = "mceItemShockWave";
						break;
					case "quicktime":
						cls = "mceItemQuickTime";
						break;
					case "mplayer":
					case "windowsmedia":
						cls = "mceItemWindowsMedia";
						break;
					case "realaudio":
					case "real":
						cls = "mceItemRealMedia";
						break;
					case "divx":
						cls = "mceItemDivX";
						break;
					case 'video':
						cls = 'mceItemVideo';
						break;
					case 'audio':
						cls = 'mceItemAudio';
						break;
				}			
				tinymce.extend(args, {
					src : tinyMCEPopup.getWindowArg('plugin_url') + '/img/trans.gif',
					width : w,
					height : h,
					title : params,
					style : dom.value('style'),
					id : dom.value('id'),
					name : dom.value('name')
				});
				ed.execCommand('mceInsertContent', false, '<img id="__mce_tmp" src="javascript:;" class="'+ cls +'" />', {skip_undo : 1});		
				ed.dom.setAttribs('__mce_tmp', args);
				ed.dom.setAttrib('__mce_tmp', 'id', '');
				ed.undoManager.add();	
			}
		}
		tinyMCEPopup.execCommand("mceEndUndoLevel");
		this.tmp = 'tmp';
		tinyMCEPopup.close();
	},
	
	mapTypes : function() {
		var types = {}, fo = this.settings['params']['media_types'].split(';');
		
		tinymce.each(fo, function(n, i) {
            if (n) {
				n = n.replace(/([a-z0-9]+)=([a-z0-9,]+)/, function(a, b, c){
					types[b] = c.split(',');
				});
            }
        });
       return types;
	},
	
	checkType : function(s) {
		var r = false;
		if (this.mediatypes && tinymce.is(this.mediatypes, 'object')) {
			types = this.mediatypes;
		} else {
			this.mediatypes = this.mapTypes();
		}

		tinymce.each(this.mediatypes, function(v, k) {
			if (tinymce.inArray(v, string.getExt(s)) != -1) {
				r = k;
			}
		});
		
		return r;
	},
	
	getType : function(v) {
		var ed = tinyMCEPopup.editor;
		var type, w, h, src;
				
		// YouTube		
		if(/youtube(.+)\/(watch\?v=|v\/)(.+)/.test(v)){					
			dom.setSelect('flash_wmode', 'opaque');

			w = 425;
			h = 350;
			src = v.replace(/watch\?v=/g, 'v/');
			type = 'flash';
		}
		// Google video
		if(/google(.+)\/(videoplay|googleplayer\.swf)\?docid=(.+)/.test(v)){
			dom.value('id', 'VideoPlayback');
			dom.setSelect('flash_wmode', 'opaque');

			w = 425;
			h = 326;
			src = v.replace(/videoplay/g, 'googleplayer.swf');
			type = 'flash';
		}
		// Metacafe
		if(/metacafe(.+)\/(watch|fplayer)\/(.+)/.test(v)){
			s = tinymce.trim(v);
			if(!/\.swf/i.test(s)){						
				if(s.charAt(s.length-1) == '/'){
					s = s.substring(0, s.length-1);	
				}
				s = s + '.swf';		
			}

			dom.setSelect('flash_wmode', 'opaque');

			w = 400;
			h = 345;
			src = s.replace(/watch/i, 'fplayer');
			type = 'flash';
		}
		
		if (!type) {
			if (/\.([a-z0-9]{3,4})/i.test(v)) {			
				type = this.checkType(v);
			} else {
				var s = /(flash|real|divx|quicktime|director|mplayer|windowsmedia|video|audio)/i.exec(v);
				
				if (s) {
					type = s[0].toLowerCase();	
				}
			}
		}

		if (src) {
			dom.value('src', src);
		}
		
		if (!dom.value('width') && w) {
			dom.value('width', w);
			dom.value('tmp_width', w);
		}
		
		if (!dom.value('height') && h) {
			dom.value('height', h);
			dom.value('tmp_height', h);
		}
		
		return type;
	},
	checkPrefix : function(n) {
		if (/^\s*www./i.test(n.value) && confirm(tinyMCEPopup.getLang('mediamanager_dlg_is_external', false, 'The URL you entered seems to be an external link, do you want to add the required http:// prefix?')))
			n.value = 'http://' + n.value;
	},
	
	switchType : function(v) {
		var type = this.getType(v);
		
		if (type) {
			dom.setSelect('media_type', type);
		}
		this.changedType();
	},
	
	changedType : function() {	
		var type = dom.getSelect('media_type');
		
		this.setControllerHeight(type);
		
		tinymce.each(['flash', 'flv', 'quicktime', 'director', 'windowsmedia', 'real', 'divx', 'video', 'audio'], function(e){
			dom.hide(e + '_options');
		});
		dom.show(type + '_options');
		
		if(this.isFlv(dom.value('src'))){
			dom.show('flv_options');
		}
	},
	getPopupParams : function(){
		var a 	= [];
		var p 	= eval('x={' + this.serializeParameters() + '};');
		if(p.src && p.src == dom.value('src')) delete p.src;
		tinymce.each(p, function(v, k){
			a.push(k + '[' + v + ']');						 
		});
		if(dom.value('popup_title') !== ''){
			a.push('title[' + dom.value('popup_title') + ']');	
		}
		if(dom.value('popup_group') !== ''){
			a.push('group[' + dom.value('popup_group') + ']');	
		}
		return a.join(';');
	},
	serializeParameters : function() {
		var s = '', v = dom.value('src');	
		if(!dom.ischecked('popup_check')){
			if(this.isFlv(v)){
				s += "src:'" + this.jsEncode(this.getFlvPlayer()) + "',";
			}else{
				s += this.getStr(null, 'src');	
			}	
		}
		
		var type = dom.getSelect('media_type');
		
		switch (type) {
			case "flash":
				s += this.getBool('flash', 'play', true);
				s += this.getBool('flash', 'loop', true);
				s += this.getBool('flash', 'menu', true);
				s += this.getBool('flash', 'swliveconnect', false);
				s += this.getBool('flash', 'allowfullscreen', false);
				s += this.getStr('flash', 'quality');
				s += this.getStr('flash', 'scale');
				s += this.getStr('flash', 'salign');
				s += this.getStr('flash', 'wmode');
				s += this.getStr('flash', 'base');
				if(this.isFlv(v)){
					s += "flashvars:'" + this.setFlv(v) + "',";
				}else{
					s += this.getStr('flash', 'flashvars');	
				}	
			break;
	
			case "quicktime":
				s += this.getBool('quicktime', 'loop', false);
				s += this.getBool('quicktime', 'autoplay', false);
				s += this.getBool('quicktime', 'cache', false);
				s += this.getBool('quicktime', 'controller', true);
				s += this.getBool('quicktime', 'correction', false, 'none', 'full');
				s += this.getBool('quicktime', 'enablejavascript', false);
				s += this.getBool('quicktime', 'kioskmode', false);
				s += this.getBool('quicktime', 'autohref', false);
				s += this.getBool('quicktime', 'playeveryframe', false);
				s += this.getBool('quicktime', 'targetcache', false);
				s += this.getStr('quicktime', 'scale');
				s += this.getStr('quicktime', 'starttime');
				s += this.getStr('quicktime', 'endtime');
				s += this.getStr('quicktime', 'target');
				s += this.getStr('quicktime', 'qtsrcchokespeed');
				s += this.getStr('quicktime', 'volume');
				s += this.getStr('quicktime', 'qtsrc');
			break;
	
			case "director":
				s += this.getBool('director', 'sound');
				s += this.getBool('director', 'progress');
				s += this.getBool('director', 'autostart');
				s += this.getBool('director', 'swliveconnect');
				s += this.getStr('director', 'swvolume');
				s += this.getStr('director', 'swstretchstyle');
				s += this.getStr('director', 'swstretchhalign');
				s += this.getStr('director', 'swstretchvalign');
			break;
	
			case "windowsmedia":
				s += this.getBool('windowsmedia', 'autostart', false);
				s += this.getBool('windowsmedia', 'enabled', false);
				s += this.getBool('windowsmedia', 'enablecontextmenu', true);
				s += this.getBool('windowsmedia', 'fullscreen', false);
				s += this.getBool('windowsmedia', 'invokeurls', true);
				s += this.getBool('windowsmedia', 'mute', false);
				s += this.getBool('windowsmedia', 'stretchtofit', false);
				s += this.getBool('windowsmedia', 'windowlessvideo', false);
				s += this.getStr('windowsmedia', 'balance');
				s += this.getStr('windowsmedia', 'baseurl');
				s += this.getStr('windowsmedia', 'captioningid');
				s += this.getStr('windowsmedia', 'currentmarker');
				s += this.getStr('windowsmedia', 'currentposition');
				s += this.getStr('windowsmedia', 'defaultframe');
				s += this.getStr('windowsmedia', 'playcount');
				s += this.getStr('windowsmedia', 'rate');
				s += this.getStr('windowsmedia', 'uimode');
				s += this.getStr('windowsmedia', 'volume');
			break;
	
			case "real":
				s += this.getBool('real', 'autostart', false);
				s += this.getBool('real', 'loop', false);
				s += this.getBool('real', 'autogotourl', true);
				s += this.getBool('real', 'center', false);
				s += this.getBool('real', 'imagestatus', true);
				s += this.getBool('real', 'maintainaspect', false);
				s += this.getBool('real', 'nojava', false);
				s += this.getBool('real', 'prefetch', false);
				s += this.getBool('real', 'shuffle', false);
				s += this.getStr('real', 'console');
				s += this.getStr('real', 'controls');
				s += this.getStr('real', 'numloop');
				s += this.getStr('real', 'scriptcallbacks');
			break;
			
			case 'divx':
				s += this.getStr('divx', 'mode');
				s += this.getStr('divx', 'minversion');
				s += this.getStr('divx', 'bufferingmode');
				s += this.getStr('divx', 'previewimage');
				s += this.getStr('divx', 'previewmessage');
				s += this.getStr('divx', 'previewmessagefontsize');
				s += this.getStr('divx', 'movietitle');
				s += this.getBool('divx', 'allowcontextmenu', true);
				s += this.getBool('divx', 'autoplay', true);
				s += this.getBool('divx', 'loop', false);
				s += this.getBool('divx', 'bannerenabled', true);
			break;
			
			case "video":
				s += this.getBool('video', 'autoplay');
				s += this.getBool('video', 'controls');
				s += this.getBool('video', 'loop');
				s += this.getBool('video', 'preload');
			break;
			
			case "audio":
				s += this.getBool('audio', 'autoplay');
				s += this.getBool('audio', 'controls');
				s += this.getBool('audio', 'preload');
			break;
		}
		s += this.getStr(null, 'id');
		s += this.getStr(null, 'name');
		s += this.getStr(null, 'width');
		s += this.getStr(null, 'height');
	
		s = s.length > 0 ? s.substring(0, s.length - 1) : s;
	
		return s;
	},
	setBool : function(pl, p, n, d) {
		if (typeof(pl[n]) == "undefined"){
			dom.get(p + "_" + n).checked = d || false;
		}else{
			dom.get(p + "_" + n).checked = eval(pl[n]);
		}	
	},
	setStr : function(pl, p, n) {
		var ed = tinyMCEPopup.editor, e = dom.get((p != null ? p + "_" : '') + n);
	
		if (typeof(pl[n]) == "undefined")
			return;
			
		if(n == 'src'){
			pl[n] = tinyMCEPopup.editor.documentBaseURI.toRelative(pl[n]);
		}
		
		if(n == 'flashvars'){
			pl[n] = decodeURIComponent(pl[n]);
		}
		
		dom.value((p != null ? p + "_" : '') + n, pl[n]);
	},
	getBool : function(p, n, d, tv, fv) {
		var v = dom.ischecked(p + "_" + n);
	
		tv = typeof(tv) == 'undefined' ? 'true' : "'" + this.jsEncode(tv) + "'";
		fv = typeof(fv) == 'undefined' ? 'false' : "'" + this.jsEncode(fv) + "'";
		
		if(/auto(play|start)/i.test(n)){
			switch(p){
				case 'windowsmedia':
					return n + (v ? ':1,' : ':0,');
					break;
				case 'quicktime':
					return n + (v ? ':' + tv + ',' : ':' + fv + ',');
					break;
				default:
					return (v == d) ? '' : n + (v ? ':' + tv + ',' : ':' + fv + ',');
					break;
			}
		}
		return (v == d) ? '' : n + (v ? ':' + tv + ',' : ':' + fv + ',');
	},
	getStr : function(p, n, d) {
		var el = dom.get((p != null ? p + "_" : "") + n);
		var v = el.type == "text" ? el.value : el.options[el.selectedIndex].value;
		
		if(n == 'src'){
			// Add http
			if(/^\s*www./i.test(v)){
				v = 'http://' + v;	
			}
		}
		return ((n == d || v == '') ? '' : n + ":'" + this.jsEncode(v) + "',");
	},
	getInt : function(p, n, d) {
		var el = dom.get((p != null ? p + "_" : "") + n);
		var v = el.type == "text" ? el.value : el.options[el.selectedIndex].value;
	
		return ((n == d || v == '') ? '' : n + ":" + v.replace(/[^0-9]+/g, '') + ",");
	},
	getAttrib : function(e, at) {
		var ed = tinyMCEPopup.editor, v, v2;
		switch (at) {
			case 'width':
			case 'height':
				return ed.dom.getAttrib(e, at) || ed.dom.getStyle(n, at) || '';
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
					return parseInt(v.replace(/[^0-9-]/g, ''));
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
					return parseInt(v.replace(/[^0-9-]/g, ''));
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
	},
	jsEncode : function(s) {	
		s = s.replace(new RegExp('\\\\', 'g'), '\\\\');
		s = s.replace(new RegExp('"', 'g'), '\\"');
		s = s.replace(new RegExp("'", 'g'), "\\'");
	
		return s;
	},
	setFlvPreview : function(){
		var h = '';
				
		var ps = tinyMCEPopup.getWindowArg("plugin_url") + '/swf/flvpreview.swf?' + this.setFlv();
			
		h += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="160" height="136">';
		h += '<param name="movie" value="' + ps + '">';
		h += '<param name="wmode" value="opaque">';
		h += '<embed type="application/x-shockwave-flash" mode="opaque" src="' + ps + '" width="160" height="136"></embed></object>';
		
		dom.html('flv_preview_container', (h));
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
		Editor.utilities.setClasses(v);
	},
	setDimensions : function(a, b){
		Editor.utilities.setDimensions(a, b);
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

		// Handle align
		ed.dom.setStyle(img, 'float', '');
		ed.dom.setStyle(img, 'vertical-align', '');

		v = dom.getSelect('align');
		if (v == 'left' || v == 'right'){					
			ed.dom.setStyle(img, 'float', v);
		}else{
			img.style.verticalAlign = v;	
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
var MediaManager = Manager.extend({
	otherOptions : function(){
		return {
			onFileClick : function(file){
				this.selectFile(file);
			},
			onFileInsert : function(file){
				this.selectFile(file);	
			}.bind(this)
		};
	},
	initialize : function(src, options){
		this.setOptions(this.otherOptions(), options);
		this.parent('mediamanager', src, '', this.options);
	},
	viewMedia : function(){
		var items 	= this.getSelectedItems();
		var title 	= items[0].title;
		var url 	= string.path(string.path(this.getSite(), this.getParam('base')), title);			
		var file	= url;
		var v		= {};
		
		var dim = $('info-dimensions').getText().split('x');
		var w	= parseInt(dim[0].replace(/[^0-9]/g, '')) || 640;
		var h	= parseInt(dim[1].replace(/[^0-9]/g, '')) || 480;
		
		if(MediaManagerDialog.isFlv(title)){
			file = this.getUrl('plugins') + '/swf/flvplayer.swf';	
			h = h + 16;
			$extend(v, {
				'flashvars' : 'file=' + string.path(this.getParam('base'), title) + '&autostart=true'		
			})
		}
		if(/\.(mov|wmv|divx)/i.test(title)){
			h = h + 30	
		}
		new mediaPreview(title, file, {
			width: w,
			height: h,
			vars : v
		});
	},
	selectFile : function(title){
		var url	= string.path(this.getDir(), title);
		var src = string.path(this.getParam('base'), url);
		src		= src.charAt(0) == '/' ? src.substring(1) : src;
			
		dom.disable('insert', true);
		//dom.value('name', string.basename(title));
		dom.value('src', src);
		
		MediaManagerDialog.switchType(title);
	
		if (MediaManagerDialog.isFlv(title)){
			dom.show('flv_options');
			MediaManagerDialog.setFlvPreview();
			dom.setSelect('flash_wmode', 'opaque');
			dom.check('flash_allowfullscreen', true);
			dom.check('flash_menu', false);
		}
		
		var type = MediaManagerDialog.getType(title);
		
		var b = /:\/\//.test(src) ? '' : this.options.site;
		
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
		});
	}
});
MediaManager.implement(new Events, new Options);
MediaManagerDialog.preInit();
tinyMCEPopup.onInit.add(MediaManagerDialog.init, MediaManagerDialog);