/**
 * $Id: editor_plugin_src.js 677 2008-03-07 13:52:41Z marco.bagnaresi $
 *
 * @author Frostlab gate
 */

(function() {
    	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('fgfileselect');
    
	tinymce.create('tinymce.plugins.FGFileSelectPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('fgFileSelectShowWindow', function() {
				// Internal image object like a flash placeholder
				if (ed.dom.getAttrib(ed.selection.getNode(), 'class').indexOf('mceItem') != -1)
					return;

				ed.windowManager.open({
					file : url + '/fgfileselect.htm',
					width : 480 + parseInt(ed.getLang('fgfileselect.delta_width', 0)),
					height : 385 + parseInt(ed.getLang('fgfileselect.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('fgfileselect', {
				title : 'fgfileselect.desc',
				cmd : 'fgFileSelectShowWindow',
                                image : url + '/img/fgfileselect.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'Frostlab Gate File Selection Plugin',
				author : 'Frostlab gate',
				authorurl : 'http://www.frostlab.it',
				infourl : 'http://www.frostlab.it',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('fgfileselect', tinymce.plugins.FGFileSelectPlugin);
})();