/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	tinymce.create('tinymce.plugins.Galeria', {
		init : function(ed, url) {
			var t = this;

			t.editor = ed;

			// Register buttons
			ed.addButton('galeriabt', 
                                    {title : 'Escolher onde a galeria de imagens ira aparecer no corpo da notícia', 
                                     cmd : 'mceGaleria',
                                     image : url + '/img/example.gif',
                                     onclick : function() {
                                       ed.windowManager.open({
                                            file : url + '/dialog.htm',
                                            width : 320 + parseInt(ed.getLang('galeria.delta_width', 0)),
                                            height : 120 + parseInt(ed.getLang('galeria.delta_height', 0)),
                                            inline : 1
                                      })
                                     }});

			ed.onBeforeGetContent.add(function(ed, o) {
				if (t.state && o.format != 'raw' && !o.draft) {
					t.state = true;
					t._toggleVisualChars(false);
				}
			});
		},
		getInfo : function() {
			return {
				longname  : 'Vídeo characters',
				author    : 'Alberto Medeiros',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl   : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/visualchars',
				version   : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}

	});

	// Register plugin
	tinymce.PluginManager.add('galeria', tinymce.plugins.Galeria);
})();
