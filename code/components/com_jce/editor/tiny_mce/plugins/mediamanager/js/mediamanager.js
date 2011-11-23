/**
 * @version		$Id: mediamanager.js 221 2011-06-11 17:30:33Z happy_noodle_boy $
 * @copyright   @@copyright@@
 * @author		Ryan Demmer
 * @license     @@licence@@
 * JCE Media Manager is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

/**
 * MediaMangaerDialog Object
 */
var MediaManagerDialog = {

	settings 	: {},

	mimes 		: {},

	mediatypes 	: null,

	preInit : function() {
		tinyMCEPopup.requireLangPack();

		// Parses the default mime types string into a mimes lookup map
		(function(data) {
			var items = data.split(/,/), i, y, ext;

			for (i = 0; i < items.length; i += 2) {
				ext = items[i + 1].split(/ /);

				for (y = 0; y < ext.length; y++) {
					MediaManagerDialog.mimes[ext[y]] = items[i];
				}
			}
		})(

		"application/x-director,dcr" +
		"video/divx,divx" +
		"application/pdf,pdf," +
		"application/x-shockwave-flash,swf swfl," +
		"audio/mpeg,mpga mpega mp2 mp3," +
		"audio/ogg,ogg spx oga," +
		"audio/x-wav,wav," +
		"video/mpeg,mpeg mpg mpe," +
		"video/mp4,mp4 m4v," +
		"video/ogg,ogg ogv,"+
		"video/webm,webm,"+
		"video/quicktime,qt mov," +
		"video/x-flv,flv," +
		"video/vnd.rn-realvideo,rv" +
		"video/3gpp,3gp" +
		"video/x-matroska,mkv"
		);
	},

	ucfirst : function(s) {
		return s.charAt(0).toUpperCase() + s.substring(1);
	},

	getMimeType : function(s) {
		var ext = s.substring(s.length, s.lastIndexOf('.') + 1).toLowerCase();
		return this.mimes[ext];
	},

	getCodecs : function(s) {
		var codecs = {
			'video/mp4'			: ['avc1.42E01E, mp4a.40.2', 'avc1.58A01E, mp4a.40.2', 'avc1.4D401E, mp4a.40.2', 'avc1.64001E, mp4a.40.2', 'mp4v.20.8, mp4a.40.2', 'mp4v.20.240, mp4a.40.2'],
			'video/3gpp'		: ['mp4v.20.8, samr'],
			'video/ogg'			: ['theora, vorbis', 'theora, speex', 'dirac, vorbis'],
			'video/x-matroska' 	: ['theora, vorbis'],
			'audio/ogg'			: ['vorbis', 'speex', 'flac']
		};
	},

	/**
	 * Get the node type from element class
	 */
	getNodeName : function(s) {
		s = /(Audio|Embed|Object|Video|Iframe)/.exec(s);

		if (s) {
			return s[1].toLowerCase();
		}

		return 'object';
	},

	init : function() {
		tinyMCEPopup.restoreSelection();

		var self = this, ed = tinyMCEPopup.editor, s = ed.selection, n = s.getNode(), val, args, type = 'flash', i, mt, data;

		// add insert button action
		$('button#insert').click( function(e) {
			self.insert();
			e.preventDefault();
		});

		tinyMCEPopup.resizeToInnerSize();

		// store mediatypes
		this.mediatypes = this.mapTypes();

		TinyMCE_Utils.fillClassList('classlist');

		// Initialize Plugin (create tooltips, tabs etc.)
		$.Plugin.init({
			selectChange : function() {
				MediaManagerDialog.updateStyles();
			}

		});

		// set media node type eg: object
		var node = this.getNodeName(n.className);

		if (this.isMedia(n)) {
			data = ed.dom.getAttrib(n, 'data-mce-json');

			var cl = /mceItem(Flash|ShockWave|WindowsMedia|QuickTime|RealMedia|DivX|PDF|Silverlight|Audio|Video|Iframe)/.exec(n.className);

			if (cl) {
				type = cl[1].toLowerCase();
			}

			// convert to object
			data = $.parseJSON(data);

			$('#insert').button('option', 'label', tinyMCEPopup.getLang('update', 'Update', true));
			$('#popup_list').prop('disabled', true);
		} else {
			// Check for popups and return data
			if (popup = WFPopups.getPopup(n)) {

				var data = {
					'width' : popup.width 	|| '',
					'height': popup.height 	|| '',
					'popup' : {}
				};

				delete popup.width;
				delete popup.height;

				if (popup.type) {
					type = this.getMediaName(popup.type);
				}

				data.popup = popup;

				node = 'popup';
			}
		}

		// Setup form
		if (data) {
			tinymce.each(['width', 'height'], function(s) {
				var v = data[s] || parseFloat(ed.dom.getAttrib(n, s) || ed.dom.getStyle(n, s)) || '';

				$('#' + s).val(v);
				$('#tmp_' + s).val(v);
			});

			// collapse object to node level
			data = data[node];

			// Test for player file
			if (WFMediaPlayer.isSupported(data) && type == WFMediaPlayer.getType()) {

				data = WFMediaPlayer.setValues(data);
				type = 'mediaplayer';
			}

			// test for Aggregator file
			if (mt = WFAggregator.isSupported(data)) {
				data = WFAggregator.setValues(mt, data);
				type = mt;
			}

			var src = data.src || data.data || data.url;
			$('#src').val(ed.convertURL(src));

			$.each(data, function(k, v) {
				switch (k) {
					case 'flashvars':
						$('#' + type + '_' + k).val(decodeURIComponent(v));
						break;
					case 'param':
						$.each(v, function(at, val) {
							switch(at) {
								case 'movie':
								case 'src':
								case 'url':
								case 'source':
									if (!$('#src').val()) {
										$('#src').val(ed.convertURL(val));
									}
									break;
								case 'flashvars':
									$('#' + type + '_flashvars').val(decodeURIComponent(val));
									break;
								default:
									var $na = $('#' + type + '_' + k);

									if ($na.is(':checkbox')) {
										if (v == 'false' || v == '0') {
											v = false;
										}
										$na.prop('checked', !!v);
									} else {
										$na.val(v);
									}
									break;
							}
						});

						break;
					case 'source':
						$.each(v, function(i, at) {
							var src = ed.convertURL(at.src);

							if (i == 0) {
								$('#src').val(src);
							} else {
								var n = $('input[name="' + type + '_source[]"]', '#' + type + '_options').get(i - 1);
								if (n) {
									$(n).val(src);
								}
							}
						});

						break;
					case 'object':
						if ((v.src || v.data) && v.param) {
							var fv, p = v.param;
							
							if (p.flashvars) {
								fv = decodeURIComponent(p.flashvars);
								
								if (fv) {
									if (WFMediaPlayer.isSupported({src : (v.src || v.data), flashvars : fv})) {
										var at = WFMediaPlayer.parseValues(fv);
	
										$('#' + type + '_fallback').val(ed.convertURL(at.src));
									}
								}
							}
						}

						break;
					default:
						var $na = $('#' + type + '_' + k);

						if ($na.is(':checkbox')) {
							if (v == 'false' || v == '0') {
								v = false;
							}
							$na.prop('checked', !!v);
						} else {
							$na.val(v);
						}
						break;
				}
			});

			// Margin
			tinymce.each(['top', 'right', 'bottom', 'left'], function(o) {
				$('#margin_' + o).val(MediaManagerDialog.getAttrib(n, 'margin-' + o));
			});

			$('#border_width').val(this.getAttrib(n, 'border-width'));
			$('#border_style').val(this.getAttrib(n, 'border-style'));
			$('#border_color').val(this.getAttrib(n, 'border-color'));

			$('#style').val(ed.dom.getAttrib(n, 'style'));

			var id = ed.dom.getAttrib(n, 'id');

			if (/mceItem/.test(id)) {
				id = '';
			}

			$('#id').val(id);
			$('#align').val(this.getAttrib(n, 'align'));
		} else {
			$.Plugin.setDefaults(this.settings.defaults);
		}
		
		//setup Popups
		WFPopups.setup();
		// setup mediaplayer
		WFMediaPlayer.setup();
		// setup Aggregators
		WFAggregator.setup();

		// set media type vale and trigger change
		$('#media_type').val(type).change();

		// Setup border
		this.setBorder();
		// Setup margins
		this.setMargins(true);
		// Setup Styles
		this.updateStyles();

		// Setup Media Manager
		WFFileBrowser.init('#src', {
			onFileClick : function(e, file) {
				MediaManagerDialog.selectFile(file);
			},

			onFileInsert : function(e, file) {
				MediaManagerDialog.selectFile(file);
			},

			onFileDetails : function(e, file) {
				MediaManagerDialog.getFileDetails(file);
			}

		});

		// Add change event to src element
		$('#src').change( function() {
			if (this.value) {
				self.selectType(this.value);
			}
		});

	},

	/**
	 * Get Site root
	 */
	getSiteRoot : function() {
		var s = tinyMCEPopup.getParam('document_base_url');
		return s.match(/.*:\/\/([^\/]+)(.*)/)[2];
	},

	setControllerHeight : function(t) {
		var v = 0;

		switch (t) {
			case 'quicktime':
				v = 16;
				break;
			case 'windowsmedia':
				v = 16;
				break;
			case 'divx':
				switch($('#divx_mode').val()) {
					default:
						v = 0;
						break;
					case 'mini':
						v = 20;
						break;
					case 'large':
						v = 65;
						break;
					case 'full':
						v = 90;
						break;
				}
				break;
		}
		$('#controller_height').val(v);
	},

	isMedia : function(n) {
		if (n.nodeName == 'IMG') {
			return /mceItem(Flash|ShockWave|WindowsMedia|QuickTime|RealMedia|DivX|Video|Audio|Iframe)/.test(tinyMCEPopup.editor.dom.getAttrib(n, 'class'));
		}
		return false;
	},

	getMediaType : function(type) {
		var mt = {
			'flash'         : 'application/x-shockwave-flash',
			'director'      : 'application/x-director',
			'shockwave'     : 'application/x-director',
			'quicktime'     : 'video/quicktime',
			'mplayer'       : 'application/x-mplayer2',
			'windowsmedia'  : 'application/x-mplayer2',
			'realaudio'     : 'audio/x-pn-realaudio-plugin',
			'real'          : 'audio/x-pn-realaudio-plugin',
			'divx'          : 'video/divx',
			'silverlight'   : 'application/x-silverlight-2'
		};

		return mt[type] || null;
	},

	getMediaName : function(type) {
		var mt = {
			'application/x-shockwave-flash' : 'flash',
			'application/x-director'        : 'shockwave',
			'video/quicktime'               : 'quicktime',
			'application/x-mplayer2'        : 'windowsmedia',
			'audio/x-pn-realaudio-plugin'   : 'real',
			'video/divx'                    : 'divx',
			'video/mp4'                     : 'video',
			'application/x-silverlight-2'   : 'silverlight'
		};

		return mt[type];
	},

	insert : function() {
		var src = $('#src').val(), type = $('#media_type').val();

		AutoValidator.validate(document);

		if (src == '') {
			$.Dialog.alert(tinyMCEPopup.getLang('mediamanager_dlg.no_src', 'Please select a file or enter in a link to a file'));
			return false;
		}

		tinymce.each (['width', 'height'], function(k) {
			if ($('#' + k).val() == '') {
				if (type != 'audio' || !WFPopups.isEnabled()) {
					$.Dialog.alert(tinyMCEPopup.getLang('mediamanager_dlg.no_' + k, 'A '+ k +' value is required.'));
					return false;
				}
			}
		});

		if (/(windowsmedia|mplayer|quicktime|divx)$/.test(type) || WFMediaPlayer.isSupported(src)) {
			$.Dialog.confirm(tinyMCEPopup.getLang('mediamanager_dlg.add_controls_height', 'Add additional height for player controls?'), function(state) {
				if (state) {
					var h 	= $('#height').val();
					var ch 	= $('#controller_height').val();

					if (ch) {
						$('#height').val(parseInt(h) + parseInt(ch));
					}
				}
				MediaManagerDialog.insertAndClose();
			});

		} else {
			this.insertAndClose();
		}
	},

	insertAndClose : function() {
		tinyMCEPopup.restoreSelection();

		var n, s, params, cls, ed = tinyMCEPopup.editor;

		var type = $('#media_type').val();

		n 	= ed.selection.getNode();

		tinyMCEPopup.execCommand("mceBeginUndoLevel");

		// Get the true media type for the WFWFMediaPlayer
		if (type == 'mediaplayer') {
			type = WFMediaPlayer.getType();

			// trigger onInsert callback
			WFMediaPlayer.onInsert();
		}

		if (type == WFAggregator.isSupported($('#src').val())) {
			WFAggregator.onInsert(type);
			// get true type
			type = WFAggregator.getType(type);
		}

		var args = {
			width 	: $('#width').val(),
			height 	: $('#height').val(),
			title	: $('#title').val(),
			style 	: $('#style').val(),
			id 		: $('#id').val(),
			name 	: $('#name').val()
		};

		// set default node type
		var node = 'object';

		switch (type) {
			case "flash":
				cls = "mceItemObject mceItemFlash";
				break;
			case "director":
				cls = "mceItemObject mceItemShockWave";
				break;
			case "quicktime":
				cls = "mceItemObject mceItemQuickTime";
				break;
			case "mplayer":
			case "windowsmedia":
				cls = "mceItemObject mceItemWindowsMedia";
				break;
			case "realaudio":
			case "real":
				cls = "mceItemObject mceItemRealMedia";
				break;
			case "divx":
				cls = "mceItemObject mceItemDivX";
				break;
			case 'iframe':
				cls = 'mceItemIframe';
				node = 'iframe';

				break;
			case 'video':
				cls = 'mceItemVideo';
				node = 'video';
				break;
			case 'audio':
				delete args.width;
				delete args.height;

				cls = 'mceItemAudio';

				node = 'audio';

				var agent = navigator.userAgent.match(/(Opera|Chrome|Safari|Gecko)/);
				if (agent) {
					cls = 'mceItemAudio mceItemAgent' + this.ucfirst(agent[0]);
				}
				break;
		}

		// get data
		var data = this.serializeParameters();

		if (n && this.isMedia(n)) {
			ed.dom.setAttribs(n, $.extend(args, {
				'data-mce-json' : data
			}));
			n.className = cls;

		} else {
			if (WFPopups.isEnabled()) {

				data = $.parseJSON(data);

				// get node object data
				data = data[node];

				// set src
				src = data.src;
				// delete key
				delete data.src;

				// add src and type
				$.extend(args, {
					type  : this.getMediaType(type),
					src   : src,
					data  : {}
				});

				delete data.type;

				$.each(data, function(k, v) {
					if ($.type(v) === 'string') {
						args.data[k] = v;
					} else {
						if (k == 'param') {
							$.each(v, function(at, val) {
								args.data[at] = val;
							});

						}

						if (k == 'source') {
							$.each(v, function(i, p) {
								$.each(p, function(at, val) {
									args.data[at] = val;
								});

							});

						}
					}
				});

				WFPopups.createPopup(n, args);
			} else {
				$.extend(args, {
					src              : tinyMCEPopup.getWindowArg('plugin_url') + '/img/trans.gif',
					'data-mce-json'  : data
				});

				ed.execCommand('mceInsertContent', false, '<img id="__mce_tmp" src="javascript:;" class="'+ cls +'" />', {
					skip_undo : 1
				});

				ed.dom.setAttribs('__mce_tmp', args);
				ed.dom.setAttrib('__mce_tmp', 'id', '');
				ed.undoManager.add();
			}
		}

		tinyMCEPopup.execCommand("mceEndUndoLevel");
		tinyMCEPopup.close();
	},

	/**
	 * Map media extensions to type
	 */
	mapTypes : function() {
		var types = {}, mt = this.settings.media_types;

		tinymce.each(tinymce.explode(mt, ';'), function(v, k) {
			if (v) {
				v = v.replace(/([a-z0-9]+)=([a-z0-9,]+)/, function(a, b, c) {
					types[b] = c.split(',');
				});

			}
		});

		return types;
	},

	/**
	 * Check src against media type
	 */
	checkType : function(s) {
		var r = false;

		if (!this.mediatypes) {
			this.mediatypes = this.mapTypes();
		}

		tinymce.each(this.mediatypes, function(v, k) {
			if (tinymce.inArray(v, $.String.getExt(s)) != -1) {
				r = k;
			}
		});

		return r;
	},

	/**
	 * Get the media type from the media src
	 */
	getType : function(v) {
		var type, data = {
			width : '',
			height : ''
		};

		if (!v)
			return false;

		// check mimetypes
		if (/\.([a-z0-9]{3,4})/i.test(v)) {
			type = this.checkType(v);
		} else {
			var s = /(flash|real|divx|quicktime|director|mplayer|windowsmedia|video|audio)/i.exec(v);

			if (s) {
				type = s[0].toLowerCase();
			}
		}

		// check WFMediaPlayer
		if (!type) {
			if (WFMediaPlayer.isSupported({src : v})) {
				type = 'mediaplayer';
			}
		}

		if (!type) {
			var s;
			// check Aggregators
			if (s = WFAggregator.isSupported(v)) {
				data = WFAggregator.getAttributes(s, v);

				type = s;
			}
		}

		// set attributes
		for (n in data) {
			if (n == 'width' || n == 'height') {
				$('#' + n).val(data[n]);
				$('#tmp_' + n).val(data[n]);
			} else {
				var $el = $('#' + n), v = data[n];

				if ($el.is(':checkbox')) {
					$el.attr('checked', !!parseFloat(v));
				} else {
					$el.val(v);
				}
			}
		}

		return type;
	},

	/**
	 * Switch the media type
	 */
	selectType : function(v) {
		var type = this.getType(v);

		if (type) {
			$('#media_type').val(type).change();
		}
	},

	/**
	 * Show media options etc. after media type switch
	 */
	changeType : function() {
		var n, s, type = type || $('#media_type').val();

		this.setControllerHeight(type);

		// hide all options
		$('fieldset.media_option', '#media_tab').hide();

		$('#' + type + '_options').show();
	},

	/**
	 * Check the src prefix for external links
	 */
	checkPrefix : function(n) {
		if (/^\s*www./i.test(n.value) && confirm(tinyMCEPopup.getLang('mediamanager_dlg_is_external', false, 'The URL you entered seems to be an external link, do you want to add the required http:// prefix?')))
			n.value = 'http://' + n.value;
	},

	/**
	 * Serialize parameters into a JSON string
	 */
	serializeParameters : function() {
		var self = this, mp, ag, ed = tinyMCEPopup.editor, type = $('#media_type').val(), node = 'object';

		var media = {
			'flash' 		: ['play','loop','menu','swliveconnect','quality','scale','salign','wmode','base','flashvars','allowfullscreen'],
			'quicktime' 	: ['loop','autoplay','cache','controller','correction','enablejavascript','kioskmode','autohref','playeveryframe','targetcache','scale','starttime','endtime','target','qtsrcchokespeed','volume','qtsrc'],
			'director'		: ['sound','progress','autostart','swliveconnect','swvolume','swstretchstyle','swstretchhalign','swstretchvalign'],
			'windowsmedia'	: ['autostart','enabled','enablecontextmenu','fullscreen','invokeurls','mute','stretchtofit','windowlessvideo','balance','baseurl','captioningid','currentmarker','currentposition','defaultframe','playcount','rate','uimode','volume'],
			'real'			: ['autostart','loop','autogotourl','center','imagestatus','maintainaspect','nojava','prefetch','shuffle','console','controls','numloop','scriptcallbacks'],
			'divx'			: ['mode','minversion','bufferingmode','previewimage','previewmessage','previewmessagefontsize','movietitle','allowcontextmenu','autoplay','loop','bannerenabled'],
			'video'			: ['poster','autoplay','loop','preload','controls'],
			'audio'			: ['autoplay','loop','preload','controls'],
			'silverlight'	: [],
			'iframe'		: ['frameborder','marginwidth','marginheight','scrolling','longdesc','allowtransparency'],
			'global'		: ['id', 'name']
		};

		// Default states
		var states = {
			// QuickTime
			quicktime : {
				autoplay 	: true,
				controller 	: true
			},

			// Flash
			flash : {
				play : true,
				loop : true,
				menu : true
			},

			// WindowsMedia
			windowsmedia : {
				autostart : true,
				enablecontextmenu : true,
				invokeurls : true
			},

			// RealMedia
			real : {
				autogotourl : true,
				imagestatus : true
			}
		};

		// get src file
		var src = $('#src').val();

		// create data object
		var data = {}, params;

		// check for media player file
		if (type == 'mediaplayer' && WFMediaPlayer.isSupported({src : src})) {
			mp = true;
			// get true type of WFMediaPlayer
			type = WFMediaPlayer.getType();
		}

		if (type == WFAggregator.isSupported(src)) {
			ag 		= true;
			// get true type of Aggreagator
			type 	= WFAggregator.getType(type);
		}

		// global attributes
		$.each(media['global'], function(i, k) {
			v = $('#' + k).val();

			if (v) {
				data[k] = v;
			}
		});

		// set parameter
		function setParam(k, v) {
			if (!params) {
				params = {};
			}

			params[k] = v;
		}

		// type attribtues
		$.each(media[type], function(i, k) {
			var n = $('#' + type + '_' + k).get(0);

			if (!n)
				return;

			var v = $(n).val(), state;

			// get default state
			if (states[type]) {
				state = states[type][k];
			}

			// set checkbox values
			if (n && n.type == 'checkbox') {
				v = n.checked;

				// set value as attribute for audio/video
				if (type == 'audio' || type == 'video') {
					if (v) {
						data[k] = (k == 'audio') ? 'muted' : k;
					}
				} else {
					// is a default state set?
					if (typeof state == 'undefined') {
						if (v) {
							setParam(k, v);
						}
					} else {
						if (v != state) {
							setParam(k, !state);
						}
					}
				}
				// set all other values
			} else {
				if (v != '') {
					if (type == 'audio' || type == 'video' || type == 'iframe') {
						data[k] = v;
					} else {
						setParam(k, v);
					}
				}
			}
		});

		if (type == 'audio' || type == 'video') {
			var sources = [], v, mime;
			// add alternative sources
			$('input[name="'+ type +'_source[]"]', '#' + type + '_options').each(function() {
				v = $(this).val();

				if (v) {
					mime = self.getMimeType(v);
					mime = mime.replace(/(audio|video)/, type);

					var at = {
						src 	: v,
						type 	: mime
					};

					sources.push(at);
				}
			});

			mime = self.getMimeType(src);
			mime = mime.replace(/(audio|video)/, type);

			// add first source
			if (sources.length) {
				sources.unshift({
					src 	: src,
					type 	: mime
				});
			} else {
				sources.push({
					src 	: src,
					type 	: mime
				});
			}

			$.extend(data, {
				src		: src,
				source 	: sources
			});

			// add flv / mp4 fallback object
			if (fb = $('#' + type + '_fallback').val()) {				
				if (WFMediaPlayer.isSupported({src : fb})) {

					data.object = WFMediaPlayer.getValues(fb);
					
					$.extend(true, data.object, {
						data	: data.object.src,
						param 	: {
							movie : data.object.src
						}
					});
					
					// remove src
					delete data.object.src;

					if (type == 'audio') {
						var dimensions = WFMediaPlayer.getParam('dimensions');
						if (dimensions.audio) {
							$.extend(data.object, dimensions.audio);
						}
					}
				}
			}
			// set object data attribute and delete src key
		} else {
			// set src if not set
			if (!data.src) {
				data['src'] = src;
			}
			// pass parameters to object
			if (params) {
				data['param'] = params;
			}

			if (mp) {
				$.extend(true, data, WFMediaPlayer.getValues(src));
			}

			if (ag) {
				$.extend(true, data, WFAggregator.getValues($('#media_type').val(), src));
			}
		}

		// set node type
		if (type == 'audio' || type == 'video' || type == 'iframe') {
			node = type;
		}

		var o = {};
		o[node] = data;

		return $.JSON.serialize(o);
	},

	/**
	 * Retrieve a media object attribute with additional processing / cleanup
	 */
	getAttrib : function(e, at) {
		var ed = tinyMCEPopup.editor, v, v2;
		switch (at) {
			case 'width':
			case 'height':
				return ed.dom.getAttrib(e, at) || ed.dom.getStyle(n, at) || '';
				break;
			case 'align':
				if(v = ed.dom.getAttrib(e, 'align')) {
					return v;
				}
				if(v = ed.dom.getStyle(e, 'float')) {
					return v;
				}
				if(v = ed.dom.getStyle(e, 'vertical-align')) {
					return v;
				}
				break;
			case 'margin-top':
			case 'margin-bottom':
				if(v = ed.dom.getStyle(e, at)) {
					if (v == 'auto') {
						return v;
					}
					return parseInt(v.replace(/[^0-9-]/g, ''));
				}
				if(v = ed.dom.getAttrib(e, 'vspace')) {
					return parseInt(v.replace(/[^0-9]/g, ''));
				}
				break;
			case 'margin-left':
			case 'margin-right':
				if(v = ed.dom.getStyle(e, at)) {
					if (v == 'auto') {
						return v;
					}
					return parseInt(v.replace(/[^0-9-]/g, ''));
				}
				if(v = ed.dom.getAttrib(e, 'hspace')) {
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
					if(sv !== '' || (sv != v && v !== '')) {
						v = '';
					}
					if (sv) {
						v = sv;
					}
				});

				if (at == 'border-color') {
					v = $.String.toHex(v);
				}
				if(at == 'border-width' && v !== '') {
					$('#border').attr('checked', true);
					return parseInt(v.replace(/[^0-9]/g, ''));
				}
				return v;
				break;
		}
	},

	setBorder : function() {
		var s = $('#border').is(':checked');

		$('#border~:input, #border~span').attr('disabled', !s).toggleClass('disabled', !s);

		this.updateStyles();
	},

	setClasses : function(v) {
		$.Plugin.setClasses(v);
	},

	setDimensions : function(a, b) {
		$.Plugin.setDimensions(a, b);
	},

	setMargins : function(init) {
		var x = 0, s = false;

		var v 		= $('#margin_top').val();
		var $elms 	= $('#margin_right, #margin_bottom, #margin_left');

		if (init) {
			$elms.each( function() {
				if ($(this).val() === v) {
					x++;
				}
			});

			s = (x == $elms.length);

			$elms.prop('disabled', s).prev('label').toggleClass('disabled', s);

			$('#margin_check').prop('checked', s);
		} else {
			s = $('#margin_check').is(':checked');

			$elms.each( function() {
				if (s) {
					if (v === '') {
						$('#margin_right, #margin_bottom, #margin_left').each( function() {
							if (v === '' && $(this).val() !== '') {
								v = $(this).val();
							}
						});

					}

					$(this).val(v);
				}
				$(this).prop('disabled', s).prev('label').toggleClass('disabled', s);
			});

			// set margin top
			$('#margin_top').val(v);

			this.updateStyles();
		}
	},

	setStyles : function() {
		var ed = tinyMCEPopup, img = $('#sample').get(0);

		$(img).attr('style', $('#style').val());

		// Margin
		tinymce.each(['top', 'right', 'bottom', 'left'], function(o) {
			$('#margin_' + o).val(ImageManagerDialog.getAttrib(img, 'margin-' + o));
		});

		// Border
		if(this.getAttrib($(img).get(0), 'border-width') !== '') {
			$('#border').attr('checked', true);
			this.setBorder();
			$('#border_width').val(this.getAttrib(img, 'border-width'));
			$('#border_style').val(this.getAttrib(img, 'border-style'));
			$('#border_color').val(this.getAttrib(img, 'border-color'));
		}
		// Align
		$('#align').val(this.getAttrib(img, 'align'));
	},

	updateStyles : function() {
		var ed = tinyMCEPopup, st, v, br, img = $('#sample');

		$(img).attr('style', $('#style').val());
		$(img).attr('dir', $('#dir').val());

		// Handle align
		$(img).css('float', '');
		$(img).css('vertical-align', '');

		v = $('#align').val();

		if (v == 'left' || v == 'right') {
			if (ed.editor.settings.inline_styles) {
				$('#clear').attr('disabled', false);
			}
			$(img).css('float', v);
		} else {
			$(img).css('vertical-align', v);
			$('#clear').attr('disabled', true);
		}

		// Handle clear
		v = $('#clear').val();

		if (v && !$('#clear').is(':disabled')) {
			br = $('#sample-br');

			if (!$('#sample-br').is('br')) {
				$(img).append('<br id="sample-br" />');
			}
			$(br).css('clear', v);
		} else {
			$('#sample-br').remove();
		}
		// Handle border
		$.each(['width', 'color', 'style'], function() {
			if ($('#border').is(':checked')) {
				v = $('#border_' + this).val();
			} else {
				v = '';
			}
			// add pixel to width
			if (this == 'width' && /[^a-z]/i.test(v)) {
				v += 'px';
			}

			$(img).css('border-' + this, v);
		});

		// Margin
		$.each(['top', 'right', 'bottom', 'left'], function() {
			v = $('#margin_' + this).val();
			$(img).css('margin-' + this,  /[^a-z]/i.test(v) ? v + 'px' : v);
		});

		// Merge
		$('#style').val(ed.dom.serializeStyle(ed.dom.parseStyle($(img).attr('style'))));
	},

	/**
	 * Set focus on an audio/video source field
	 */
	setSourceFocus : function(n) {
		$('input.active').removeClass('active');
		$(n).addClass('active');
	},

	selectFile : function(file) {
		var self 	= this;
		var name 	= $(file).attr('title');
		var src		= $(file).data('url');

		src	= src.charAt(0) == '/' ? src.substring(1) : src;

		if (!$('#media_tab').hasClass('ui-tabs-hide')) {
			$('input.active', '#media_tab').val(src);
		} else {
			$('#src').val(src);

			MediaManagerDialog.selectType(name);

			$('#width, #tmp_width').val($(file).data('width'));
			$('#height, #tmp_height').val($(file).data('height'));

			var w = $(file).data('width'), h = $(file).data('height');

			if (w && h) {
				$('#width, #tmp_width').val(w);
				$('#height, #tmp_height').val(h);
			} else {
				$('#width').parent().append('<span class="loader"/>');

				$.JSON.request('getDimensions', $(file).attr('id'), function(o) {
					if (!o.error) {
						$('#width, #tmp_width').val(o.width);
						$('#height, #tmp_height').val(o.height);
					}
					$('#width~span.loader').remove();
				});

			}

			if (WFMediaPlayer.isSupported({src : name})) {
				WFMediaPlayer.onSelectFile();
			}

			if (WFAggregator.isSupported(src)) {
				WFAggregator.onSelectFile();
			}
		}
	},

	getFileDetails : function(file) {
		var w = $(file).data('width'), h = $(file).data('height'), time = $(file).data('duration');
		// if properties not yet set
		if (!w && !h && !time) {
			$('#info-properties dl').append('<dd class="loader"/>');

			$.JSON.request('getFileDetails', $(file).attr('id'), function(o) {
				if (!o.error) {
					if (o.width && o.height) {
						$(file).data('width', o.width).data('height', o.height);
						$('#info-properties dl').append('<dd id="info-dimensions">' + tinyMCEPopup.getLang('dlg.dimensions', 'Dimensions') + ': ' + o.width + ' x ' + o.height + '</dd>');
					}

					if (o.duration) {
						$(file).data('duration', o.duration);
						$('#info-properties dl').append('<dd id="info-duration">' + tinyMCEPopup.getLang('dlg.duration', 'Duration') + ': ' + o.duration + '</dd>');
					}
				}
				$('dd.loader').remove();
			});

		}
	}

};
MediaManagerDialog.preInit();
tinyMCEPopup.onInit.add(MediaManagerDialog.init, MediaManagerDialog);