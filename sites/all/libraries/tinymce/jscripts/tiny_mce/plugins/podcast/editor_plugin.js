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
	tinymce.create('tinymce.plugins.Podcast', {
		init : function(ed, url) {
			var t = this;

			t.editor = ed;

			// Register buttons
			ed.addButton('podcastbt', 
                                    {title : 'Escolher onde o podcast irá aparecer no corpo da notícia', 
                                     cmd : 'mcePodcast',
                                     image : url + '/img/podcast.gif',
                                     onclick : function() {
                                       ed.execCommand('mceInsertContent', false, '[@#podcast#@]');
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
	tinymce.PluginManager.add('podcast', tinymce.plugins.Podcast);
})();