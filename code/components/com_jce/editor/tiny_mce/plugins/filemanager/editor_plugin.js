(function() {
    tinymce.create('tinymce.plugins.FileManager', {

        init: function(ed, url) {
            // Register commands
            ed.addCommand('mceFileManager', function() {
                var e = ed.selection.getNode();
                
                ed.windowManager.open({
                    file	: ed.getParam('site_url') + 'index.php?option=com_jce&view=editor&layout=plugin&plugin=filemanager',
                    width	: 760 + ed.getLang('filemanager.delta_width', 0),
                    height	: 650 + ed.getLang('filemanager.delta_height', 0),
                    inline	: 1,
                    popup_css : false
                }, {
                    plugin_url: url
                });
            });
            
            function isFile(n) {
            	//return ed.dom.is(n, 'a.jce_file, a.wf_file');	
            	return n && n.nodeName == 'A' && /(jce|wf)_file/.test(n.className);
            }
            
            // Register buttons
            ed.addButton('filemanager', {
                title	: 'filemanager.desc',
                cmd		: 'mceFileManager',
                image 	: url + '/img/filemanager.png'
            });
            
            ed.onNodeChange.add(function(ed, cm, n, co) {
                if ((n && n.nodeName == 'IMG' || n.nodeName == 'SPAN') && /(jce|wf)_/i.test(ed.dom.getAttrib(n, 'class'))) {
                    n = ed.dom.getParent(n, 'A');
                }
                
                cm.setActive('filemanager', co && isFile(n));                
                
                // Select anchor node and set highlight icon
                if (n && isFile(n)) {
                    //ed.selection.select(n);
                    cm.setActive('filemanager', true);
                }
            });
            
            ed.onInit.add(function() {
                if (ed && ed.plugins.contextmenu) {
                    ed.plugins.contextmenu.onContextMenu.add(function(th, m, e) {
                        m.add({
                            title		: 'filemanager.desc',
                            icon_src 	: url + '/img/filemanager.png',
                            cmd			: 'mceFileManager'
                        });
                    });
                }
            });
        },
        getInfo: function() {
            return {
                longname: 'File Manager',
                author: 'Ryan Demmer',
                authorurl: 'http://www.joomlacontenteditor.net',
                infourl: 'http://www.joomlacontenteditor.net/index.php?option=com_content&amp;view=article&amp;task=findkey&amp;tmpl=component&amp;lang=en&amp;keyref=filemanager.about',
                version: '2.0.10'
            };
        }
    });
    // Register plugin
    tinymce.PluginManager.add('filemanager', tinymce.plugins.FileManager);
})();
