(function() {
	tinymce.create('tinymce.plugins.ImageManagerExt', {
		init : function(ed, url) {
			function isMceItem(n) {
				return /mceItem/.test(n.className);
			};
			
			// Register commands
			ed.addCommand('mceImageManagerExt', function() {
				// Internal image object like a flash placeholder
				if (isMceItem(ed.selection.getNode()))
					return;

				ed.windowManager.open({
					file : ed.getParam('site_url') + '?option=com_jce&task=plugin&plugin=imgmanager_ext&file=imgmanager',
					width : 760 + ed.getLang('imgmanager_ext.delta_width', 0),
					height : 640 + ed.getLang('imgmanager_ext.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url
				});
			});
			// Register buttons
			ed.addButton('imgmanager_ext', {
				title : 'imgmanager_ext.desc',
				cmd : 'mceImageManagerExt',
				image : url + '/img/imgmanager_ext.gif'
			});
			
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('imgmanager_ext', n.nodeName == 'IMG' && !isMceItem(n));
			});
			
			ed.onInit.add(function() {
				if (ed && ed.plugins.contextmenu) {
					ed.plugins.contextmenu.onContextMenu.add(function(th, m, e) {
						m.add({title : 'imgmanager_ext.desc', icon_src : url + '/img/imgmanager_ext.gif', cmd : 'mceImageManagerExt'});
					});
				}
			});
		},
		getInfo : function() {
			return {
				longname : 'Image Manager Extended',
				author : 'Ryan Demmer',
				authorurl : 'http://www.joomlacontenteditor.net',
				infourl : 'http://www.joomlacontenteditor.net',
				version : '1.5.7.4'
			};
		}
	});
	// Register plugin
	tinymce.PluginManager.add('imgmanager_ext', tinymce.plugins.ImageManagerExt);
})();