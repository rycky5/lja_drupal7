(function($) {

/**
 * Initialize editor instances.
 *
 * @todo Is the following note still valid for 3.x?
 * This function needs to be called before the page is fully loaded, as
 * calling tinyMCE.init() after the page is loaded breaks IE6.
 *
 * @param editorSettings
 *   An object containing editor settings for each input format.
 */
Drupal.wysiwyg.editor.init.tinymce = function(settings) {
  // If JS compression is enabled, TinyMCE is unable to autodetect its global
  // settinge, hence we need to define them manually.
  // @todo Move global library settings somewhere else.
  tinyMCE.baseURL = settings.global.editorBasePath;
  tinyMCE.srcMode = (settings.global.execMode == 'src' ? '_src' : '');
  tinyMCE.gzipMode = (settings.global.execMode == 'gzip');

  // Initialize editor configurations.
  for (var format in settings) {
    if (format == 'global') {
      continue;
    };
    tinyMCE.init(settings[format]);
    if (Drupal.settings.wysiwyg.plugins[format]) {
      // Load native external plugins.
      // Array syntax required; 'native' is a predefined token in JavaScript.
      for (var plugin in Drupal.settings.wysiwyg.plugins[format]['native']) {
        tinymce.PluginManager.load(plugin, Drupal.settings.wysiwyg.plugins[format]['native'][plugin]);
      }
      // Load Drupal plugins.
      for (var plugin in Drupal.settings.wysiwyg.plugins[format].drupal) {
        Drupal.wysiwyg.editor.instance.tinymce.addPlugin(plugin, Drupal.settings.wysiwyg.plugins[format].drupal[plugin], Drupal.settings.wysiwyg.plugins.drupal[plugin]);
      }
    }
  }
};

/**
 * Attach this editor to a target element.
 *
 * See Drupal.wysiwyg.editor.attach.none() for a full desciption of this hook.
 */
Drupal.wysiwyg.editor.attach.tinymce = function(context, params, settings) {
  // Configure editor settings for this input format.
  var ed = new tinymce.Editor(params.field, settings);
  // Reset active instance id on any event.
  ed.onEvent.add(function(ed, e) {
    Drupal.wysiwyg.activeId = ed.id;
  });
  // Make toolbar buttons wrappable (required for IE).
  ed.onPostRender.add(function (ed) {
    var $toolbar = $('<div class="wysiwygToolbar"></div>');
    $('#' + ed.editorContainer + ' table.mceToolbar > tbody > tr > td').each(function () {
      $('<div></div>').addClass(this.className).append($(this).children()).appendTo($toolbar);
    });
    $('#' + ed.editorContainer + ' table.mceLayout td.mceToolbar').append($toolbar);
    $('#' + ed.editorContainer + ' table.mceToolbar').remove();
  });

  // Remove TinyMCE's internal mceItem class, which was incorrectly added to
  // submitted content by Wysiwyg <2.1. TinyMCE only temporarily adds the class
  // for placeholder elements. If preemptively set, the class prevents (native)
  // editor plugins from gaining an active state, so we have to manually remove
  // it prior to attaching the editor. This is done on the client-side instead
  // of the server-side, as Wysiwyg has no way to figure out where content is
  // stored, and the class only affects editing.
  $field = $('#' + params.field);
  $field.val($field.val().replace(/(<.+?\s+class=['"][\w\s]*?)\bmceItem\b([\w\s]*?['"].*?>)/ig, '$1$2'));

  // Attach editor.
  ed.render();
};

/**
 * Detach a single or all editors.
 *
 * See Drupal.wysiwyg.editor.detach.none() for a full desciption of this hook.
 */
Drupal.wysiwyg.editor.detach.tinymce = function(context, params) {
  if (typeof params != 'undefined') {
    var instance = tinyMCE.get(params.field);
    if (instance) {
      instance.save();
      instance.remove();
    }
  }
  else {
    // Save contents of all editors back into textareas.
    tinyMCE.triggerSave();
    // Remove all editor instances.
    for (var instance in tinyMCE.editors) {
      tinyMCE.editors[instance].remove();
    }
  }
};

Drupal.wysiwyg.editor.instance.tinymce = {
  addPlugin: function(plugin, settings, pluginSettings) {
    if (typeof Drupal.wysiwyg.plugins[plugin] != 'object') {
      return;
    }
    tinymce.create('tinymce.plugins.' + plugin, {
      /**
       * Initialize the plugin, executed after the plugin has been created.
       *
       * @param ed
       *   The tinymce.Editor instance the plugin is initialized in.
       * @param url
       *   The absolute URL of the plugin location.
       */
      init: function(ed, url) {
        // Register an editor command for this plugin, invoked by the plugin's button.
        ed.addCommand(plugin, function() {
          if (typeof Drupal.wysiwyg.plugins[plugin].invoke == 'function') {
            var data = { format: 'html', node: ed.selection.getNode(), content: ed.selection.getContent() };
            // TinyMCE creates a completely new instance for fullscreen mode.
            var instanceId = ed.id == 'mce_fullscreen' ? ed.getParam('fullscreen_editor_id') : ed.id;
            Drupal.wysiwyg.plugins[plugin].invoke(data, pluginSettings, instanceId);
          }
        });

        // Register the plugin button.
        ed.addButton(plugin, {
          title : settings.iconTitle,
          cmd : plugin,
          image : settings.icon
        });

        // Load custom CSS for editor contents on startup.
        ed.onInit.add(function() {
          if (settings.css) {
            ed.dom.loadCSS(settings.css);
          }
        });

        // Attach: Replace plain text with HTML representations.
        ed.onBeforeSetContent.add(function(ed, data) {
          if (typeof Drupal.wysiwyg.plugins[plugin].attach == 'function') {
            data.content = Drupal.wysiwyg.plugins[plugin].attach(data.content, pluginSettings, ed.id);
            data.content = Drupal.wysiwyg.editor.instance.tinymce.prepareContent(data.content);
          }
        });

        // Detach: Replace HTML representations with plain text.
        ed.onGetContent.add(function(ed, data) {
          if (typeof Drupal.wysiwyg.plugins[plugin].detach == 'function') {
            data.content = Drupal.wysiwyg.plugins[plugin].detach(data.content, pluginSettings, ed.id);
          }
        });

        // isNode: Return whether the plugin button should be enabled for the
        // current selection.
        ed.onNodeChange.add(function(ed, command, node) {
          if (typeof Drupal.wysiwyg.plugins[plugin].isNode == 'function') {
            command.setActive(plugin, Drupal.wysiwyg.plugins[plugin].isNode(node));
          }
        });
      },

      /**
       * Return information about the plugin as a name/value array.
       */
      getInfo: function() {
        return {
          longname: settings.title
        };
      }
    });

    // Register plugin.
    tinymce.PluginManager.add(plugin, tinymce.plugins[plugin]);
  },

  openDialog: function(dialog, params) {
    var instanceId = this.isFullscreen() ? 'mce_fullscreen' : this.field;
    var editor = tinyMCE.get(instanceId);
    editor.windowManager.open({
      file: dialog.url + '/' + instanceId,
      width: dialog.width,
      height: dialog.height,
      inline: 1
    }, params);
  },

  closeDialog: function(dialog) {
    var instanceId = this.isFullscreen() ? 'mce_fullscreen' : this.field;
    var editor = tinyMCE.get(instanceId);
    editor.windowManager.close(dialog);
  },

  prepareContent: function(content) {
    // Certain content elements need to have additional DOM properties applied
    // to prevent this editor from highlighting an internal button in addition
    // to the button of a Drupal plugin.
    var specialProperties = {
      img: { 'class': 'mceItem' }
    };
    var $content = $('<div>' + content + '</div>'); // No .outerHTML() in jQuery :(
    // Find all placeholder/replacement content of Drupal plugins.
    $content.find('.drupal-content').each(function() {
      // Recursively process DOM elements below this element to apply special
      // properties.
      var $drupalContent = $(this);
      $.each(specialProperties, function(element, properties) {
        $drupalContent.find(element).andSelf().each(function() {
          for (var property in properties) {
            if (property == 'class') {
              $(this).addClass(properties[property]);
            }
            else {
              $(this).attr(property, properties[property]);
            }
          }
        });
      });
    });
    return $content.html();
  },

  insert: function(content) {
    content = this.prepareContent(content);
    var instanceId = this.isFullscreen() ? 'mce_fullscreen' : this.field;
    tinyMCE.execInstanceCommand(instanceId, 'mceInsertContent', false, content);
  },

  isFullscreen: function() {
    // TinyMCE creates a completely new instance for fullscreen mode.
    return tinyMCE.activeEditor.id == 'mce_fullscreen' && tinyMCE.activeEditor.getParam('fullscreen_editor_id') == this.field;
  }
};
})(jQuery);

function filebrowser(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
	        title: "Visualizador de Imagens",
	        url: "http://sgc.leiaja.com/misc/pdw_file_browser/index.php?editor=tinymce&filter="+type,
	        width: 950,
	        height: 650,
	        inline: 0,
	        maximizable: 1,
	        close_previous: 0
	      },{window : win, input : field_name}
	    );
} ;
(function($) {

/**
 * Attach this editor to a target element.
 *
 * @param context
 *   A DOM element, supplied by Drupal.attachBehaviors().
 * @param params
 *   An object containing input format parameters. Default parameters are:
 *   - editor: The internal editor name.
 *   - theme: The name/key of the editor theme/profile to use.
 *   - field: The CSS id of the target element.
 * @param settings
 *   An object containing editor settings for all enabled editor themes.
 */
Drupal.wysiwyg.editor.attach.none = function(context, params, settings) {
  if (params.resizable) {
    var $wrapper = $('#' + params.field).parents('.form-textarea-wrapper:first');
    $wrapper.addClass('resizable');
    if (Drupal.behaviors.textarea.attach) {
      Drupal.behaviors.textarea.attach();
    }
  }
};

/**
 * Detach a single or all editors.
 *
 * @param context
 *   A DOM element, supplied by Drupal.attachBehaviors().
 * @param params
 *   (optional) An object containing input format parameters. If defined,
 *   only the editor instance in params.field should be detached. Otherwise,
 *   all editors should be detached and saved, so they can be submitted in
 *   AJAX/AHAH applications.
 */
Drupal.wysiwyg.editor.detach.none = function(context, params) {
  if (typeof params != 'undefined') {
    var $wrapper = $('#' + params.field).parents('.form-textarea-wrapper:first');
    $wrapper.removeOnce('textarea').removeClass('.resizable-textarea')
      .find('.grippie').remove();
  }
};

/**
 * Instance methods for plain text areas.
 */
Drupal.wysiwyg.editor.instance.none = {
  insert: function(content) {
    var editor = document.getElementById(this.field);

    // IE support.
    if (document.selection) {
      editor.focus();
      var sel = document.selection.createRange();
      sel.text = content;
    }
    // Mozilla/Firefox/Netscape 7+ support.
    else if (editor.selectionStart || editor.selectionStart == '0') {
      var startPos = editor.selectionStart;
      var endPos = editor.selectionEnd;
      editor.value = editor.value.substring(0, startPos) + content + editor.value.substring(endPos, editor.value.length);
    }
    // Fallback, just add to the end of the content.
    else {
      editor.value += content;
    }
  }
};

})(jQuery);
;
(function ($) {
  Drupal.behaviors.video_wysiwyg = {
    attach: function (context, settings) {
      $('#video-browser-page div.video-item a').click(function (){
        var nid = $(this).attr('ref');
        $('.video-item').css('background-color', 'white');
        $(this).parent().css('background-color', 'antiquewhite');
        Drupal.settings.wysiwyg.plugins.drupal.video.golbal.selectedId = nid;
        return false;
      });
      // dimensions
      $('.video-file-browser-dimensions').change(function (){
        Drupal.settings.wysiwyg.plugins.drupal.video.golbal.dimensions = $(this).val();
      });
    },
    videoBrowser: function (onSelect, data, settings, instanceId){
      // popup dialog
      var $dialog = $('<div></div>')
      .load(settings.golbal.url)
      .dialog({
        autoOpen: false,
        title: 'Video Browser',
        width: 640,
        height: 420
      });
      $dialog.dialog('open');
      // add button
      $dialog.dialog({
        buttons: [

        {
          text: "Ok",
          click: function() {
            $(this).dialog("close");
          }
        }
        ]
      });
      
      // close
      $dialog.dialog({
        close: function(event, ui) {
          var nid = Drupal.settings.wysiwyg.plugins.drupal.video.golbal.selectedId;
          if(nid.length)
            onSelect(nid, data, settings, instanceId);
        }
      });
    }
  };
})(jQuery);;
(function ($) {

  Drupal.wysiwyg.plugins['video'] = {

    /**
     * Return whether the passed node belongs to this plugin.
     */
    isNode: function(node) {
      return ($(node).is('img.wysiwyg-video'));
    },

    /**
     * Execute the button.
     */
    invoke: function(data, settings, instanceId) { 
      Drupal.behaviors.video_wysiwyg.videoBrowser(function(nid, data, settings, instanceId){
        if (data.format == 'html') {
          // Prevent duplicating
          if ($(data.node).is('img.wysiwyg-video')) {
            return;
          }
          var width = 176;
          var height = 144;
          var dimensions = Drupal.settings.wysiwyg.plugins.drupal.video.golbal.dimensions;
          if(dimensions){
            var wxh = dimensions.split('x');
            var width = parseInt(wxh[0]);
            var height = parseInt(wxh[1]);
          }
          var content = Drupal.wysiwyg.plugins['video']._getPlaceholder(settings, Drupal.settings.basePath +'video/embed/' +nid+'/'+width+'/'+height, width, height);
        }
        else {
          // Prevent duplicating.
          // @todo data.content is the selection only; needs access to complete content.
          if (data.content.match(/[content:video]/)) {
            return;
          }
          var content = nid;
        }
        if (typeof content != 'undefined') {
          Drupal.wysiwyg.instances[instanceId].insert(content);
        }
      }, data, settings, instanceId);
    },

    /**
     * Replace all [[content:video]] tags with images.
     */
    attach: function(content, settings, instanceId) {
      return content;
    },

    /**
     * Replace images with [[content:video]] tags in content upon detaching editor.
     */
    detach: function(content, settings, instanceId) {
      //      return $content.html();
      return content;
    },

    /**
     * Helper function to return a HTML placeholder.
     */
    _getPlaceholder: function (settings, src, width, height) {
      return '<iframe width="'+width+'" height="'+height+'" src="'+src+'" frameborder="0" allowfullscreen scrolling="no"></iframe>';
    }
  };

})(jQuery);
;
(function ($) {

Drupal.behaviors.textarea = {
  attach: function (context, settings) {
    $('.form-textarea-wrapper.resizable', context).once('textarea', function () {
      var staticOffset = null;
      var textarea = $(this).addClass('resizable-textarea').find('textarea');
      var grippie = $('<div class="grippie"></div>').mousedown(startDrag);

      grippie.insertAfter(textarea);

      function startDrag(e) {
        staticOffset = textarea.height() - e.pageY;
        textarea.css('opacity', 0.25);
        $(document).mousemove(performDrag).mouseup(endDrag);
        return false;
      }

      function performDrag(e) {
        textarea.height(Math.max(32, staticOffset + e.pageY) + 'px');
        return false;
      }

      function endDrag(e) {
        $(document).unbind('mousemove', performDrag).unbind('mouseup', endDrag);
        textarea.css('opacity', 1);
      }
    });
  }
};

})(jQuery);
;

(function ($) {

/**
 * Auto-hide summary textarea if empty and show hide and unhide links.
 */
Drupal.behaviors.textSummary = {
  attach: function (context, settings) {
    $('.text-summary', context).once('text-summary', function () {
      var $widget = $(this).closest('div.field-type-text-with-summary');
      var $summaries = $widget.find('div.text-summary-wrapper');

      $summaries.once('text-summary-wrapper').each(function(index) {
        var $summary = $(this);
        var $summaryLabel = $summary.find('label');
        var $full = $widget.find('.text-full').eq(index).closest('.form-item');
        var $fullLabel = $full.find('label');

        // Create a placeholder label when the field cardinality is
        // unlimited or greater than 1.
        if ($fullLabel.length == 0) {
          $fullLabel = $('<label></label>').prependTo($full);
        }

        // Setup the edit/hide summary link.
        var $link = $('<span class="field-edit-link">(<a class="link-edit-summary" href="#">' + Drupal.t('Hide summary') + '</a>)</span>').toggle(
          function () {
            $summary.hide();
            $(this).find('a').html(Drupal.t('Edit summary')).end().appendTo($fullLabel);
            return false;
          },
          function () {
            $summary.show();
            $(this).find('a').html(Drupal.t('Hide summary')).end().appendTo($summaryLabel);
            return false;
          }
        ).appendTo($summaryLabel);

        // If no summary is set, hide the summary field.
        if ($(this).find('.text-summary').val() == '') {
          $link.click();
        }
        return;
      });
    });
  }
};

})(jQuery);
;
(function ($) {

/**
 * Automatically display the guidelines of the selected text format.
 */
Drupal.behaviors.filterGuidelines = {
  attach: function (context) {
    $('.filter-guidelines', context).once('filter-guidelines')
      .find(':header').hide()
      .closest('.filter-wrapper').find('select.filter-list')
      .bind('change', function () {
        $(this).closest('.filter-wrapper')
          .find('.filter-guidelines-item').hide()
          .siblings('.filter-guidelines-' + this.value).show();
      })
      .change();
  }
};

})(jQuery);
;
(function ($) {

/**
 * A progressbar object. Initialized with the given id. Must be inserted into
 * the DOM afterwards through progressBar.element.
 *
 * method is the function which will perform the HTTP request to get the
 * progress bar state. Either "GET" or "POST".
 *
 * e.g. pb = new progressBar('myProgressBar');
 *      some_element.appendChild(pb.element);
 */
Drupal.progressBar = function (id, updateCallback, method, errorCallback) {
  var pb = this;
  this.id = id;
  this.method = method || 'GET';
  this.updateCallback = updateCallback;
  this.errorCallback = errorCallback;

  // The WAI-ARIA setting aria-live="polite" will announce changes after users
  // have completed their current activity and not interrupt the screen reader.
  this.element = $('<div class="progress" aria-live="polite"></div>').attr('id', id);
  this.element.html('<div class="bar"><div class="filled"></div></div>' +
                    '<div class="percentage"></div>' +
                    '<div class="message">&nbsp;</div>');
};

/**
 * Set the percentage and status message for the progressbar.
 */
Drupal.progressBar.prototype.setProgress = function (percentage, message) {
  if (percentage >= 0 && percentage <= 100) {
    $('div.filled', this.element).css('width', percentage + '%');
    $('div.percentage', this.element).html(percentage + '%');
  }
  $('div.message', this.element).html(message);
  if (this.updateCallback) {
    this.updateCallback(percentage, message, this);
  }
};

/**
 * Start monitoring progress via Ajax.
 */
Drupal.progressBar.prototype.startMonitoring = function (uri, delay) {
  this.delay = delay;
  this.uri = uri;
  this.sendPing();
};

/**
 * Stop monitoring progress via Ajax.
 */
Drupal.progressBar.prototype.stopMonitoring = function () {
  clearTimeout(this.timer);
  // This allows monitoring to be stopped from within the callback.
  this.uri = null;
};

/**
 * Request progress data from server.
 */
Drupal.progressBar.prototype.sendPing = function () {
  if (this.timer) {
    clearTimeout(this.timer);
  }
  if (this.uri) {
    var pb = this;
    // When doing a post request, you need non-null data. Otherwise a
    // HTTP 411 or HTTP 406 (with Apache mod_security) error may result.
    $.ajax({
      type: this.method,
      url: this.uri,
      data: '',
      dataType: 'json',
      success: function (progress) {
        // Display errors.
        if (progress.status == 0) {
          pb.displayError(progress.data);
          return;
        }
        // Update display.
        pb.setProgress(progress.percentage, progress.message);
        // Schedule next timer.
        pb.timer = setTimeout(function () { pb.sendPing(); }, pb.delay);
      },
      error: function (xmlhttp) {
        pb.displayError(Drupal.ajaxError(xmlhttp, pb.uri));
      }
    });
  }
};

/**
 * Display errors on the page.
 */
Drupal.progressBar.prototype.displayError = function (string) {
  var error = $('<div class="messages error"></div>').html(string);
  $(this.element).before(error).hide();

  if (this.errorCallback) {
    this.errorCallback(this);
  }
};

})(jQuery);
;
/**
 * @file
 * Provides JavaScript additions to the managed file field type.
 *
 * This file provides progress bar support (if available), popup windows for
 * file previews, and disabling of other file fields during Ajax uploads (which
 * prevents separate file fields from accidentally uploading files).
 */

(function ($) {

/**
 * Attach behaviors to managed file element upload fields.
 */
Drupal.behaviors.fileValidateAutoAttach = {
  attach: function (context, settings) {
    if (settings.file && settings.file.elements) {
      $.each(settings.file.elements, function(selector) {
        var extensions = settings.file.elements[selector];
        $(selector, context).bind('change', {extensions: extensions}, Drupal.file.validateExtension);
      });
    }
  },
  detach: function (context, settings) {
    if (settings.file && settings.file.elements) {
      $.each(settings.file.elements, function(selector) {
        $(selector, context).unbind('change', Drupal.file.validateExtension);
      });
    }
  }
};

/**
 * Attach behaviors to the file upload and remove buttons.
 */
Drupal.behaviors.fileButtons = {
  attach: function (context) {
    $('input.form-submit', context).bind('mousedown', Drupal.file.disableFields);
    $('div.form-managed-file input.form-submit', context).bind('mousedown', Drupal.file.progressBar);
  },
  detach: function (context) {
    $('input.form-submit', context).unbind('mousedown', Drupal.file.disableFields);
    $('div.form-managed-file input.form-submit', context).unbind('mousedown', Drupal.file.progressBar);
  }
};

/**
 * Attach behaviors to links within managed file elements.
 */
Drupal.behaviors.filePreviewLinks = {
  attach: function (context) {
    $('div.form-managed-file .file a, .file-widget .file a', context).bind('click',Drupal.file.openInNewWindow);
  },
  detach: function (context){
    $('div.form-managed-file .file a, .file-widget .file a', context).unbind('click', Drupal.file.openInNewWindow);
  }
};

/**
 * File upload utility functions.
 */
Drupal.file = Drupal.file || {
  /**
   * Client-side file input validation of file extensions.
   */
  validateExtension: function (event) {
    // Remove any previous errors.
    $('.file-upload-js-error').remove();

    // Add client side validation for the input[type=file].
    var extensionPattern = event.data.extensions.replace(/,\s*/g, '|');
    if (extensionPattern.length > 1 && this.value.length > 0) {
      var acceptableMatch = new RegExp('\\.(' + extensionPattern + ')$', 'gi');
      if (!acceptableMatch.test(this.value)) {
        var error = Drupal.t("The selected file %filename cannot be uploaded. Only files with the following extensions are allowed: %extensions.", {
          '%filename': this.value,
          '%extensions': extensionPattern.replace(/\|/g, ', ')
        });
        $(this).closest('div.form-managed-file').prepend('<div class="messages error file-upload-js-error">' + error + '</div>');
        this.value = '';
        return false;
      }
    }
  },
  /**
   * Prevent file uploads when using buttons not intended to upload.
   */
  disableFields: function (event){
    var clickedButton = this;

    // Only disable upload fields for Ajax buttons.
    if (!$(clickedButton).hasClass('ajax-processed')) {
      return;
    }

    // Check if we're working with an "Upload" button.
    var $enabledFields = [];
    if ($(this).closest('div.form-managed-file').length > 0) {
      $enabledFields = $(this).closest('div.form-managed-file').find('input.form-file');
    }

    // Temporarily disable upload fields other than the one we're currently
    // working with. Filter out fields that are already disabled so that they
    // do not get enabled when we re-enable these fields at the end of behavior
    // processing. Re-enable in a setTimeout set to a relatively short amount
    // of time (1 second). All the other mousedown handlers (like Drupal's Ajax
    // behaviors) are excuted before any timeout functions are called, so we
    // don't have to worry about the fields being re-enabled too soon.
    // @todo If the previous sentence is true, why not set the timeout to 0?
    var $fieldsToTemporarilyDisable = $('div.form-managed-file input.form-file').not($enabledFields).not(':disabled');
    $fieldsToTemporarilyDisable.attr('disabled', 'disabled');
    setTimeout(function (){
      $fieldsToTemporarilyDisable.attr('disabled', '');
    }, 1000);
  },
  /**
   * Add progress bar support if possible.
   */
  progressBar: function (event) {
    var clickedButton = this;
    var $progressId = $(clickedButton).closest('div.form-managed-file').find('input.file-progress');
    if ($progressId.length) {
      var originalName = $progressId.attr('name');

      // Replace the name with the required identifier.
      $progressId.attr('name', originalName.match(/APC_UPLOAD_PROGRESS|UPLOAD_IDENTIFIER/)[0]);

      // Restore the original name after the upload begins.
      setTimeout(function () {
        $progressId.attr('name', originalName);
      }, 1000);
    }
    // Show the progress bar if the upload takes longer than half a second.
    setTimeout(function () {
      $(clickedButton).closest('div.form-managed-file').find('div.ajax-progress-bar').slideDown();
    }, 500);
  },
  /**
   * Open links to files within forms in a new window.
   */
  openInNewWindow: function (event) {
    $(this).attr('target', '_blank');
    window.open(this.href, 'filePreview', 'toolbar=0,scrollbars=1,location=1,statusbar=1,menubar=0,resizable=1,width=500,height=550');
    return false;
  }
};

})(jQuery);
;
(function ($) {

/**
 * Toggle the visibility of a fieldset using smooth animations.
 */
Drupal.toggleFieldset = function (fieldset) {
  var $fieldset = $(fieldset);
  if ($fieldset.is('.collapsed')) {
    var $content = $('> .fieldset-wrapper', fieldset).hide();
    $fieldset
      .removeClass('collapsed')
      .trigger({ type: 'collapsed', value: false })
      .find('> legend span.fieldset-legend-prefix').html(Drupal.t('Hide'));
    $content.slideDown({
      duration: 'fast',
      easing: 'linear',
      complete: function () {
        Drupal.collapseScrollIntoView(fieldset);
        fieldset.animating = false;
      },
      step: function () {
        // Scroll the fieldset into view.
        Drupal.collapseScrollIntoView(fieldset);
      }
    });
  }
  else {
    $fieldset.trigger({ type: 'collapsed', value: true });
    $('> .fieldset-wrapper', fieldset).slideUp('fast', function () {
      $fieldset
        .addClass('collapsed')
        .find('> legend span.fieldset-legend-prefix').html(Drupal.t('Show'));
      fieldset.animating = false;
    });
  }
};

/**
 * Scroll a given fieldset into view as much as possible.
 */
Drupal.collapseScrollIntoView = function (node) {
  var h = document.documentElement.clientHeight || document.body.clientHeight || 0;
  var offset = document.documentElement.scrollTop || document.body.scrollTop || 0;
  var posY = $(node).offset().top;
  var fudge = 55;
  if (posY + node.offsetHeight + fudge > h + offset) {
    if (node.offsetHeight > h) {
      window.scrollTo(0, posY);
    }
    else {
      window.scrollTo(0, posY + node.offsetHeight - h + fudge);
    }
  }
};

Drupal.behaviors.collapse = {
  attach: function (context, settings) {
    $('fieldset.collapsible', context).once('collapse', function () {
      var $fieldset = $(this);
      // Expand fieldset if there are errors inside, or if it contains an
      // element that is targeted by the uri fragment identifier. 
      var anchor = location.hash && location.hash != '#' ? ', ' + location.hash : '';
      if ($('.error' + anchor, $fieldset).length) {
        $fieldset.removeClass('collapsed');
      }

      var summary = $('<span class="summary"></span>');
      $fieldset.
        bind('summaryUpdated', function () {
          var text = $.trim($fieldset.drupalGetSummary());
          summary.html(text ? ' (' + text + ')' : '');
        })
        .trigger('summaryUpdated');

      // Turn the legend into a clickable link, but retain span.fieldset-legend
      // for CSS positioning.
      var $legend = $('> legend .fieldset-legend', this);

      $('<span class="fieldset-legend-prefix element-invisible"></span>')
        .append($fieldset.hasClass('collapsed') ? Drupal.t('Show') : Drupal.t('Hide'))
        .prependTo($legend)
        .after(' ');

      // .wrapInner() does not retain bound events.
      var $link = $('<a class="fieldset-title" href="#"></a>')
        .prepend($legend.contents())
        .appendTo($legend)
        .click(function () {
          var fieldset = $fieldset.get(0);
          // Don't animate multiple times.
          if (!fieldset.animating) {
            fieldset.animating = true;
            Drupal.toggleFieldset(fieldset);
          }
          return false;
        });

      $legend.append(summary);
    });
  }
};

})(jQuery);
;
(function ($) {

Drupal.behaviors.pathFieldsetSummaries = {
  attach: function (context) {
    $('fieldset.path-form', context).drupalSetSummary(function (context) {
      var path = $('.form-item-path-alias input').val();
      var automatic = $('.form-item-path-pathauto input').attr('checked');

      if (automatic) {
        return Drupal.t('Automatic alias');
      }
      if (path) {
        return Drupal.t('Alias: @alias', { '@alias': path });
      }
      else {
        return Drupal.t('No alias');
      }
    });
  }
};

})(jQuery);
;

(function ($) {

Drupal.behaviors.commentFieldsetSummaries = {
  attach: function (context) {
    $('fieldset.comment-node-settings-form', context).drupalSetSummary(function (context) {
      return Drupal.checkPlain($('.form-item-comment input:checked', context).next('label').text());
    });

    // Provide the summary for the node type form.
    $('fieldset.comment-node-type-settings-form', context).drupalSetSummary(function(context) {
      var vals = [];

      // Default comment setting.
      vals.push($(".form-item-comment select option:selected", context).text());

      // Threading.
      var threading = $(".form-item-comment-default-mode input:checked", context).next('label').text();
      if (threading) {
        vals.push(threading);
      }

      // Comments per page.
      var number = $(".form-item-comment-default-per-page select option:selected", context).val();
      vals.push(Drupal.t('@number comments per page', {'@number': number}));

      return Drupal.checkPlain(vals.join(', '));
    });
  }
};

})(jQuery);
;

(function ($) {

/**
 * Provide summary information for vertical tabs.
 */
Drupal.behaviors.scheduler_settings = {
  attach: function (context) {
	// Provide summary when editting a node.
	$('fieldset#edit-scheduler-settings', context).drupalSetSummary(function(context) {
      var vals = [];
      if ($('#edit-publish-on').val() || $('#edit-publish-on-datepicker-popup-0').val()) {
        vals.push(Drupal.t('Scheduled for publishing'));
      }
      if ($('#edit-unpublish-on').val() || $('#edit-unpublish-on-datepicker-popup-0').val()) {
        vals.push(Drupal.t('Scheduled for unpublishing'));
      }
      if (!vals.length) {
        vals.push(Drupal.t('Not scheduled'));
      }
      return vals.join('<br/>');
    });

    // Provide summary during content type configuration.
    $('fieldset#edit-scheduler', context).drupalSetSummary(function(context) {
      var vals = [];
      if ($('#edit-scheduler-publish-enable', context).is(':checked')) {
        vals.push(Drupal.t('Publishing enabled'));
      }
      if ($('#edit-scheduler-unpublish-enable', context).is(':checked')) {
        vals.push(Drupal.t('Unpublishing enabled'));
      }
      return vals.join('<br/>');
    });

  }
};

})(jQuery);
;

(function ($) {

Drupal.behaviors.nodeFieldsetSummaries = {
  attach: function (context) {
    $('fieldset.node-form-revision-information', context).drupalSetSummary(function (context) {
      var revisionCheckbox = $('.form-item-revision input', context);

      // Return 'New revision' if the 'Create new revision' checkbox is checked,
      // or if the checkbox doesn't exist, but the revision log does. For users
      // without the "Administer content" permission the checkbox won't appear,
      // but the revision log will if the content type is set to auto-revision.
      if (revisionCheckbox.is(':checked') || (!revisionCheckbox.length && $('.form-item-log textarea', context).length)) {
        return Drupal.t('New revision');
      }

      return Drupal.t('No revision');
    });

    $('fieldset.node-form-author', context).drupalSetSummary(function (context) {
      var name = $('.form-item-name input', context).val() || Drupal.settings.anonymous,
        date = $('.form-item-date input', context).val();
      return date ?
        Drupal.t('By @name on @date', { '@name': name, '@date': date }) :
        Drupal.t('By @name', { '@name': name });
    });

    $('fieldset.node-form-options', context).drupalSetSummary(function (context) {
      var vals = [];

      $('input:checked', context).parent().each(function () {
        vals.push(Drupal.checkPlain($.trim($(this).text())));
      });

      if (!$('.form-item-status input', context).is(':checked')) {
        vals.unshift(Drupal.t('Not published'));
      }
      return vals.join(', ');
    });
  }
};

})(jQuery);
;
(function ($) {

Drupal.toolbar = Drupal.toolbar || {};

/**
 * Attach toggling behavior and notify the overlay of the toolbar.
 */
Drupal.behaviors.toolbar = {
  attach: function(context) {

    // Set the initial state of the toolbar.
    $('#toolbar', context).once('toolbar', Drupal.toolbar.init);

    // Toggling toolbar drawer.
    $('#toolbar a.toggle', context).once('toolbar-toggle').click(function(e) {
      Drupal.toolbar.toggle();
      // Allow resize event handlers to recalculate sizes/positions.
      $(window).triggerHandler('resize');
      return false;
    });
  }
};

/**
 * Retrieve last saved cookie settings and set up the initial toolbar state.
 */
Drupal.toolbar.init = function() {
  // Retrieve the collapsed status from a stored cookie.
  var collapsed = $.cookie('Drupal.toolbar.collapsed');

  // Expand or collapse the toolbar based on the cookie value.
  if (collapsed == 1) {
    Drupal.toolbar.collapse();
  }
  else {
    Drupal.toolbar.expand();
  }
};

/**
 * Collapse the toolbar.
 */
Drupal.toolbar.collapse = function() {
  var toggle_text = Drupal.t('Show shortcuts');
  $('#toolbar div.toolbar-drawer').addClass('collapsed');
  $('#toolbar a.toggle')
    .removeClass('toggle-active')
    .attr('title',  toggle_text)
    .html(toggle_text);
  $('body').removeClass('toolbar-drawer').css('paddingTop', Drupal.toolbar.height());
  $.cookie(
    'Drupal.toolbar.collapsed',
    1,
    {
      path: Drupal.settings.basePath,
      // The cookie should "never" expire.
      expires: 36500
    }
  );
};

/**
 * Expand the toolbar.
 */
Drupal.toolbar.expand = function() {
  var toggle_text = Drupal.t('Hide shortcuts');
  $('#toolbar div.toolbar-drawer').removeClass('collapsed');
  $('#toolbar a.toggle')
    .addClass('toggle-active')
    .attr('title',  toggle_text)
    .html(toggle_text);
  $('body').addClass('toolbar-drawer').css('paddingTop', Drupal.toolbar.height());
  $.cookie(
    'Drupal.toolbar.collapsed',
    0,
    {
      path: Drupal.settings.basePath,
      // The cookie should "never" expire.
      expires: 36500
    }
  );
};

/**
 * Toggle the toolbar.
 */
Drupal.toolbar.toggle = function() {
  if ($('#toolbar div.toolbar-drawer').hasClass('collapsed')) {
    Drupal.toolbar.expand();
  }
  else {
    Drupal.toolbar.collapse();
  }
};

Drupal.toolbar.height = function() {
  var $toolbar = $('#toolbar');
  var height = $toolbar.outerHeight();
  // In modern browsers (including IE9), when box-shadow is defined, use the
  // normal height.
  var cssBoxShadowValue = $toolbar.css('box-shadow');
  var boxShadow = (typeof cssBoxShadowValue !== 'undefined' && cssBoxShadowValue !== 'none');
  // In IE8 and below, we use the shadow filter to apply box-shadow styles to
  // the toolbar. It adds some extra height that we need to remove.
  if (!boxShadow && /DXImageTransform\.Microsoft\.Shadow/.test($toolbar.css('filter'))) {
    height -= $toolbar[0].filters.item("DXImageTransform.Microsoft.Shadow").strength;
  }
  return height;
};

})(jQuery);
;
