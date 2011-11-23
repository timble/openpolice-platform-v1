/**
 * @version		$Id: filemanager.js 221 2011-06-11 17:30:33Z happy_noodle_boy $
 * @copyright   Copyright (C) 2006 - 2011 Ryan Demmer. All rights reserved
 * @author		Ryan Demmer
 * @license     GNU/GPL Version 2 - http://www.gnu.org/licenses/gpl-2.0.html
 * JCE File Manager is free software. This version may have been modified
 * pursuant to the GNU General Public License, and as distributed it
 * includes or is derivative of works licensed under the GNU General
 * Public License or other free or open source software licenses.
 */
(function() {
    tinyMCEPopup.requireLangPack();

    var FileManager = {
        settings : {
        	text_alert : 1
        },

        init: function() {

            tinyMCEPopup.restoreSelection();

            var ed = tinyMCEPopup.editor, se = ed.selection, n = se.getNode(), el, self = this, href = '', alt, sortables = true;

            // add insert button action
            $('button#insert').click( function(e) {
                self.insert();
                e.preventDefault();
            });

            tinyMCEPopup.resizeToInnerSize();

            TinyMCE_Utils.fillClassList('date_class');
            TinyMCE_Utils.fillClassList('size_class');

            el = ed.dom.getParent(n, "A");

            // setup sortable options
            this._setupSortables();
            
            // Initialise Plugin
            $.Plugin.init();

            if (el != null && ed.dom.is(el, 'a.jce_file, a.wf_file')) {
                $('#insert').button('option', 'label', tinyMCEPopup.getLang('update', 'Update', true));
                
                // Get href and convert to relative
                href = ed.convertURL(ed.dom.getAttrib(el, 'href'));

                $('#href').val(href);

                // attributes
                $.each(['title', 'id', 'style', 'dir', 'lang', 'tabindex', 'accesskey', 'class', 'charset', 'hreflang', 'target', 'rev'], function(i, k) {
                    $('#' + k).val(ed.dom.getAttrib(n, k));
                });

                // select class from list
                $('#classlist').val(ed.dom.getAttrib(n, 'class'));

                $('#rel').val( function() {
                    var v = ed.dom.getAttrib(n, 'rel');

                    if ($('option[value="'+ v +'"]', this).length == 0) {
                        $(this).append(new Option(v, v));
                        $(this).val(v);
                    }
                });
                
                // get array of options elements
                var options = $('li', '#options_list').get();
                var ordered = [];

                $.each(el.childNodes, function(i, n) {
                    switch(n.nodeName) {
                    	case 'IMG':
                    		if (ed.dom.is(n, '.jce_icon, .wf_file_icon')) {
                    			$('#option_icon_check').prop('checked', true);
                    			ordered.push($('#option_icon').get(0));
                    		}
                    		break;
                    	case '#text':
                    		if (/[\w]+/i.test(n.data)) {
                    			$('#option_text_check').prop('checked', true);
                    			
                    			$('#text').val(n.data);
                        		ordered.push($('#option_text').get(0));
                    		}
                    		break;
                    	case 'SPAN':
                    		var v 	= tinymce.trim(n.innerHTML);
                    		var cls = n.className.replace(/jce_(file_)?(size|date)/i, ''); 
                    		
                    		// text
                    		if (ed.dom.is(n, '.wf_file_text')) {
                    			$('#option_text_check').prop('checked', true);
                    			
                    			$('#text').val(v);
                        		ordered.push($('#option_text').get(0));
                    		}
                    		
                    		if (ed.dom.is(n, '.jce_size, .jce_file_size, .wf_file_size')) {
                    			$('input[type="text"]', '#option_size').val(v);
                        		$('#option_size_check').prop('checked', true);
                        		$('#size_class').val(tinymce.trim(cls));
                        		ordered.push($('#option_size').get(0));
                    		}
                    		
                    		if (ed.dom.is(n, '.jce_date, .jce_file_date, .wf_file_date')) {
                    			$('input[type="text"]', '#option_date').val(v);
                        		$('#option_date_check').prop('checked', true);
                        		$('#date_class').val(tinymce.trim(cls));
                        		ordered.push($('#option_date').get(0));
                    		}
                    		
                    		break;
                    }
                    
                    // node selection is not a filemanager node
                    if (n.nodeType == 1 && !/(jce|wf)_(file_)?(icon|text|date|size)/.test(n.className)) {
                    	sortables = false;
                    }
                });
                
                // add original options to ordered array in their original positions
                if (ordered.length < options.length) {
                	$.each(options, function(i, n) {
                		if (ordered.indexOf(n) == -1) {
                			ordered.splice(i, 0, n);
                		}
                	});
                }
                
                $('#options_list').append(ordered);               
            } else {
                var content = se.getContent();
                if (/[<>]/.test(content)) {
                    sortables = false;
                } else {
                    $('#text').val(content);
                }
                
                // set defaults            
	            $.each(this.settings.defaults, function(k, v) {
	            	if ($('#' + k).is(':checkbox')) {
	                	$('#' + k).prop('checked', parseFloat(v));
	                } else {
	                	$('#' + k).val(v);
	                }
	            });
            }
            
            $('#options_enabled').toggle(sortables);
            $('#options_disabled').toggle(!sortables);

            // Setup Media Manager
            WFFileBrowser.init('#href', {
                onFileClick : function(e, file) {
                    self.selectFile(file);
                },

                onFileInsert : function(e, file) {
                    self.selectFile(file);
                }

            });
        },

        insert: function() {
            var ed = tinyMCEPopup.editor;

            AutoValidator.validate(document);

            if ($('#href').val() === '') {
                $.Dialog.alert(tinyMCEPopup.getLang('filemanager_dlg.no_src', 'Please select a file or enter a file URL'));

                return false;
            }
            if ($('#text').val() === '') {
                $.Dialog.alert(tinyMCEPopup.getLang('filemanager_dlg.no_text', 'Text for the file link is required'));

                return false;
            }

            this.insertAndClose();
        },

        insertAndClose: function() {
            tinyMCEPopup.restoreSelection();

            var ed = tinyMCEPopup.editor, se = ed.selection, n = se.getNode(), v, el, content, args = {}, html = [];

            // Fixes crash in Safari
            if (tinymce.isWebKit) {
                ed.getWin().focus();
            }

            content = se.getContent();

            var ext 		= $.String.getExt($('#href').val());
            
            var options 	= $('#options_list').sortable('toArray');
            var format		= this.settings.icon_format;

            var icon 		= format.replace('{$name}', this.settings.icon_map[ext] , 'i');
            icon 			= $.String.path(this.settings.icon_path, icon);

            if (icon.charAt(0) == '/') {
                icon = icon.substring(1);
            }

           	var data = {
                icon: '<img class="wf_file_icon" src="' + icon + '" style="border:0px;vertical-align:middle;" alt="'+ ext +'" />',
                date: '<span class="wf_file_date" style="margin-left:5px;">' + $('input:text', '#option_date').val() + '</span>',
                size: '<span class="wf_file_size" style="margin-left:5px;">' + $('input:text', '#option_size').val() + '</span>',
                text: '<span class="wf_file_text">' + $('#text').val() + '</span>'
            };

            var attribs = ['href', 'title', 'target', 'id', 'style', 'class', 'rel', 'rev', 'charset', 'hreflang', 'dir', 'lang', 'tabindex', 'accesskey', 'type'];

            tinymce.each(attribs, function(k) {
                var v = $('#' + k).val();

                if (k == 'href') {
                    v = $.String.encodeURI(v, true);
                }

                if (k == 'class') {
                    v = $('#classlist').val() || $(k).val() || '';
                }

                args[k] = v;
            });

            $.each(options, function(i, v) {
                if ($('input:checkbox', '#' + v).is(':checked')) {
                    html.push(data[v.replace('option_', '')]);
                }
            });

            // no selection
            if (se.isCollapsed()) {
                ed.execCommand('mceInsertContent', false, '<a href="javascript:mctmp(0);">' + html.join('') + '</a>', {
                    skip_undo : 1
                });
                el = ed.dom.select('a[href=javascript:mctmp(0);]')[0];

                // create link on selection or update existing link
            } else {
                if (el = ed.dom.getParent(se.getNode(), "A")) {
                    if (!args.href) {
                        ed.dom.remove(el, true);
                    }
                    
                    if (ed.dom.select('.wf_file_icon, .wf_file_date, .wf_file_size, .wf_file_text', el).length) {
						el.innerHTML = html.join('');
                	}
                    
                } else {
                    ed.execCommand('CreateLink', false, 'javascript:mctmp(0);');
                    el = ed.dom.select('a[href=javascript:mctmp(0);]')[0];
                    
                    if (!$('#text').is(':hidden')) {
                    	el.innerHTML = html.join('');
                    }
                }
            }

            if (el) {
                ed.dom.setAttribs(el, args);
                // add identifier class
                ed.dom.addClass(el, 'wf_file');
                
                // add other classes
                ed.dom.addClass(ed.dom.select('span.wf_file_size', el), $('#size_class').val());
                ed.dom.addClass(ed.dom.select('span.wf_file_date', el), $('#date_class').val());
            }

            tinyMCEPopup.close();
        },

        _setupSortables: function() {
            var enabled 	= this.sortables;
            var sortlist 	= this.sortlist || {};

            // add event
            $('li', '#options_list').click( function(e) {
                var el = e.target, p = this;
                
                // get MediaManager selection
                var items = WFFileBrowser.get('getSelectedItems');

                if (el.disabled)
                    return;

                if ($(el).is(':checkbox:checked, span.option_reload')) {
                    
                    if ($(el).is(':checkbox') && $(el).siblings('input:text').val()) {
                    	return;
                    }
                    
                    if ($(p).is('#option_size, #option_date') && items.length) {
                        $('#insert').prop('disabled', true);

                        $(p).addClass('loading');
                        
                        var type = $(p).data('type');

                        $.JSON.request('getFileDetails', $(items[0]).attr('id'), function(o) {

                            if (!o.error) {	
                                $('input:text', p).val(o[type]);
                            }

                            $('#insert').prop('disabled', false);

                            $(p).removeClass('loading');
                        });

                    }
                }
            });

            $('#options_list').sortable({
                axis : 'x',
                placeholder: "ui-state-highlight",
                start : function(event, ui) {
                	$(ui.placeholder).width($(ui.item).width());
                }
            });
        },

        /**
         * Select a file
         * @param file File element
         */
        selectFile : function(file) {
            var self 	= this;
            var dir		= WFFileBrowser.getCurrentDir();
            var name 	= $(file).attr('title');
            var src		= $.String.path(WFFileBrowser.getBaseDir(), $(file).attr('id'));

            src	= src.charAt(0) == '/' ? src.substring(1) : src;

            $('#href').val(src);

            // size
            $('input:text', '#option_size').val($.String.formatSize($(file).data('size')));
            // date
            $('input:text', '#option_date').val($.String.formatDate($(file).data('modified'), this.settings.date_format));

            if ($('#text').val() !== '' && this.settings.text_alert == 1) {
                $.Dialog.confirm(tinyMCEPopup.getLang('filemanager_dlg.replace_text', 'Replace file link text with file name?'), function(state) {
                    if (state) {
                        $('#text').val(name);
                    }
                });

            } else {
                $('#text').val(name);
            }
        }

    };
    window.FileManager = FileManager;

    tinyMCEPopup.onInit.add(FileManager.init, FileManager);
})();