/**
 * @version		$Id: editor.js 137 2009-06-26 10:22:17Z happynoodleboy $
 * @package      JCE
 * @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author		Ryan Demmer
 * @license      GNU/GPL
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

/**
 * JContentEditor Object
 */
var JContentEditor = {
	
	_bookmark : {},
	
	setBookmark : function(id) {
		var t = this, DOM = tinymce.DOM, Event = tinymce.dom.Event;
		// only for IE
		if (tinymce.isIE) {
			if (!Event.domLoaded) {
				Event.add(document, 'init', function() {
					t.setBookmark();
				});
				return;
			} else {
				tinyMCE.onAddEditor.add(function(mgr, ed) {
					Event.add(document, 'mousedown', function(e) {
						var el = e.target, ta = ed.getElement(), toggle = ta.previousSibling;
						
						// return if mousedown is somewhere on editor 
						if (el == ed.getContainer() || (el == ta && ta.className == 'advcode_toggle') || el == toggle || DOM.getParent(el, 'span.mceEditor'))
							return;
						
						if (ed.selection) {
							t._bookmark[ed.id] = ed.selection.getBookmark();
						}
					});
				});
			}
		}
	},
		
	/**
     * Set the editor content
     * @param {String} id The editor id
     * @param {String} html The html content to set
     */
    setContent: function(id, html) {
        if (tinyMCE.get(id)) {
            tinyMCE.activeEditor.setContent(html);
        } else {
            document.getElementById(id).value = html;
        }
    },
	
    /**
     * Get the editor content
     * @param {String} id The editor id
     */
    getContent: function(id) {
        if (tinyMCE.get(id)) {
            return tinyMCE.activeEditor.getContent();
        }
        return document.getElementById(id).value;
    },
	
    /**
     * Save the editor content
     * @param {String} id The editor id
     */
    save: function(id) {
        var ed = tinyMCE.get(id);
        if (ed && !ed.getContent()) {
            ed.setContent(ed.getElement().value);
        }
        tinyMCE.triggerSave();
    },
    
    /**
     * Insert content into the editor. This function is provided for editor-xtd buttons and includes methods for inserting into textareas
     * @param {String} el The editor id
     * @param {String} v The text to insert
     */
    insert: function(el, v) {
		if (typeof el == 'string') {
            el = document.getElementById(el);
        }
		
        if (/mceEditor/.test(el.className)) {
        	if (tinymce.isIE) {
        		if (window.parent.tinymce) {
        			var ed = window.parent.tinyMCE.get(el.id);
        			
        			if (ed) {
        				if (this._bookmark[ed.id]) {
            				ed.selection.moveToBookmark(this._bookmark[ed.id]);
            			}
        			}
        		}
        	}
        	tinyMCE.execInstanceCommand(el.id, 'mceInsertContent', false, v, true);
        } else {
            // IE
            if (document.selection) {
                el.focus();
                s = document.selection.createRange();
                s.text = v;
                // Mozilla / Netscape
            } else if (el.selectionStart || el.selectionStart == '0') {
                var startPos = el.selectionStart;
                var endPos = el.selectionEnd;
                el.value = el.value.substring(0, startPos) + v + el.value.substring(endPos, el.value.length);
            // Other
            } else {
                el.value += v;
            }
        }
    }
};