Drupal.locale = { 'pluralFormula': function ($n) { return Number(($n!=1)); }, 'strings': {"":{"An AJAX HTTP error occurred.":"Ocorreu um erro HTTP no AJAX", "HTTP Result Code: !status":"Código do Resultado HTTP:  !status", "An AJAX HTTP request terminated abnormally.":"Uma requisição HTTP AJAX terminou de forma anormal.", "Debugging information follows.":"Estas são as informações de depuração.", "Path: !uri":"Caminho: !url", "StatusText: !statusText":"Texto de Status: !statusText", "ResponseText: !responseText":"Texto de Resposta: !responseText", "ReadyState: !readyState":"ReadyState: !readyState", "Loading":"Carregando", "(active tab)":"(aba ativa)", "Hide":"Ocultar", "Show":"Exibir", "Configure":"Configurar", "Show shortcuts":"Mostrar atalhos", "Hide shortcuts":"Esconder atalhos", "Title":"Legenda da foto", "Disabled":"Desativado", "Enabled":"Ativado", "Edit":"Editar", "none":"nenhum", "Done":"Concluído", "Logout":"Sair", "Select all rows in this table":"Selecionar todas as linhas da tabela", "Deselect all rows in this table":"Desmarcar todas as linhas da tabela", "Not published":"Não publicado", "Please wait...":"Por favor, espere um pouco...", "By @name on @date":"Por @name em @date", "By @name":"Por @name", "Not in menu":"Fora do menu", "Alias: @alias":"Endereço: @alias", "No alias":"Não há um endereço", "New revision":"Nova revisão", "Drag to re-order":"Arraste para reordenar", "Changes made in this table will not be saved until the form is submitted.":"As mudanças feitas nesta tabela não vão ser salvas antes do formulário ser enviado.", "The changes to these blocks will not be saved until the \u003Cem\u003ESave blocks\u003C\u002Fem\u003E button is clicked.":"As alterações nesses blocos não vão ser salvas enquanto o botão \u003Cem\u003ESalvar Blocos\u003C\u002Fem\u003E não for clicado.", "This permission is inherited from the authenticated user role.":"Essa permissão é herdada do papel de usuário autenticado.", "No revision":"Sem revisão", "@number comments per page":"@number comentários por página", "Requires a title":"Título requerido", "Not restricted":"Sem restrições", "Not customizable":"Não é personalizável", "Restricted to certain pages":"Restrito para certas páginas", "The block cannot be placed in this region.":"O bloco não pode ser colocado nessa região.", "Customize dashboard":"Personalizar painel", "Edit summary":"Editar resumo", "Don\u0027t display post information":"Não exibir informações de postagem", "The selected file %filename cannot be uploaded. Only files with the following extensions are allowed: %extensions.":"O arquivo %filename selecionado não pode ser carregado. Apenas arquivos com as seguintes extensões são permitidos: %extensions.", "Re-order rows by numerical weight instead of dragging.":"Re-ordernar as linhas por campos númericos de peso ao invés de arrastar-e-soltar.", "Show row weights":"Exibir pesos das linhas", "Hide row weights":"Ocultar pesos das linhas", "Autocomplete popup":"Popup de autocompletar", "Searching for matches...":"Procurando por dados correspondentes..."}} };;
(function($, Drupal, undefined){
  /**
   * When set to enable mediaelement for all audio/video files add it to the page.
   */
  Drupal.behaviors.mediaelement = {
    attach: function(context, settings) {
      if (settings.mediaelement !== undefined) {
        // @todo Remove anonymous function.
        $.each(settings.mediaelement, function(selector, options) {
          var opts;
          $(selector, context).once('mediaelement', function() {
            if (options.controls) {
              $(this).mediaelementplayer(options.opts);
            }
            else {
              $(this).mediaelement();
            }
          });
        });
      }
      // The global option is seperate from the other selectors as it should be
      // run after any other selectors.
      if (settings.mediaelementAll !== undefined) {
        $('video,audio', context).once('mediaelement', function() {
          $(this).mediaelementplayer();
        });
      }
    }
  };
})(jQuery, Drupal);;

/**
 * @file
 * Adds some show/hide to the admin form to make the UXP easier.
 *
 */
(function($){
  Drupal.behaviors.video = {
    attach: function (context, settings) {
      //lets see if we have any jmedia movies
      if($.fn.media) {
        $('.jmedia').media();
      }
	
      video_hide_all_options();
      $("input[name='video_convertor']").change(function() {
        video_hide_all_options();
      });

      // change metadata options
      video_hide_all__metadata_options();
      $("input[name='video_metadata']").change(function() {
        video_hide_all__metadata_options();
      });

      $('.video_select').each(function() {
        var ext = $(this).attr('rel');
        $('select', this).change(function() {
          if($(this).val() == 'video_play_flv') {
            $('#flv_player_'+ext).show();
          } else {
            $('#flv_player_'+ext).hide();
          }
          if($(this).val() == 'video_play_html5') {
            $('#html5_player_'+ext).show();
          } else {
            $('#html5_player_'+ext).hide();
          }
        });
        if($('select', this).val() == 'video_play_flv')
          $('#flv_player_'+ext).show();
        
        if($('select', this).val() == 'video_play_html5')
          $('#html5_player_'+ext).show();
        else
          $('#html5_player_'+ext).hide();
      });
	
      if(settings.video) {
        $.fn.media.defaults.flvPlayer = settings.video.flvplayer;

      }
	
      //lets setup our colorbox videos
      $('.video-box').each(function() {
        var url = $(this).attr('href');
        var data = $(this).metadata();
        var width = data.width;
        var height= data.height;
        var player = settings.video.player; //player can be either jwplayer or flowplayer.
        $(this).colorbox({
          html: '<a id="video-overlay" href="'+url+'" style="height:'+height+'; width:'+width+'; display: block;"></a>',
          onComplete:function() {
            if(player == 'flowplayer') {
              flowplayer("video-overlay", settings.video.flvplayer, {
                clip: {
                  autoPlay: settings.video.autoplay,
                  autoBuffering: settings.video.autobuffer
                }
              });
            } else {
              $('#video-overlay').media({
                flashvars: {
                  autostart: settings.video.autoplay
                },
                width:width,
                height:height
              });
            }
          }
        });
      });
    }
  };
  
  Drupal.behaviors.videoEdit = function(context){
    // on change of the thumbnails when edit
    $(".video-thumbnails input").each(function() {
      var path = $(this).val();
      if($(this).is(':checked')) {
        var holder = $(this).attr('rel');
        var id = $(this).attr('id');
        var src = $('label[for="'+id+'"]').find('img').attr('src');
        $('.'+holder+' img').attr('src', src);
      }
    });
  }


  function video_hide_all_options() {
    $("input[name='video_convertor']").each(function() {
      var id = $(this).val();
      $('#'+id).hide();
      if ($(this).is(':checked')) {
        $('#' + id).show();
      }
    });
  }
  
  function video_hide_all__metadata_options() {
    $("input[name='video_metadata']").each(function() {
      var id = $(this).val();
      $('#'+id).hide();
      if ($(this).is(':checked')) {
        $('#' + id).show();
      }
    });
  }
})(jQuery);;
(function ($) {

/**
 * Show/hide the 'Email site administrator when updates are available' checkbox
 * on the install page.
 */
Drupal.hideEmailAdministratorCheckbox = function () {
  // Make sure the secondary box is shown / hidden as necessary on page load.
  if ($('#edit-update-status-module-1').is(':checked')) {
    $('.form-item-update-status-module-2').show();
  }
  else {
    $('.form-item-update-status-module-2').hide();
  }

  // Toggle the display as necessary when the checkbox is clicked.
  $('#edit-update-status-module-1').change( function () {
    $('.form-item-update-status-module-2').toggle();
  });
};

/**
 * Internal function to check using Ajax if clean URLs can be enabled on the
 * settings page.
 *
 * This function is not used to verify whether or not clean URLs
 * are currently enabled.
 */
Drupal.behaviors.cleanURLsSettingsCheck = {
  attach: function (context, settings) {
    // This behavior attaches by ID, so is only valid once on a page.
    // Also skip if we are on an install page, as Drupal.cleanURLsInstallCheck will handle
    // the processing.
    if (!($('#edit-clean-url').length) || $('#edit-clean-url.install').once('clean-url').length) {
      return;
    }
    var url = settings.basePath + 'admin/config/search/clean-urls/check';
    $.ajax({
      url: location.protocol + '//' + location.host + url,
      dataType: 'json',
      success: function () {
        // Check was successful. Redirect using a "clean URL". This will force the form that allows enabling clean URLs.
        location = settings.basePath +"admin/config/search/clean-urls";
      }
    });
  }
};

/**
 * Internal function to check using Ajax if clean URLs can be enabled on the
 * install page.
 *
 * This function is not used to verify whether or not clean URLs
 * are currently enabled.
 */
Drupal.cleanURLsInstallCheck = function () {
  var url = location.protocol + '//' + location.host + Drupal.settings.basePath + 'admin/config/search/clean-urls/check';
  // Submit a synchronous request to avoid database errors associated with
  // concurrent requests during install.
  $.ajax({
    async: false,
    url: url,
    dataType: 'json',
    success: function () {
      // Check was successful.
      $('#edit-clean-url').attr('value', 1);
    }
  });
};

/**
 * When a field is filled out, apply its value to other fields that will likely
 * use the same value. In the installer this is used to populate the
 * administrator e-mail address with the same value as the site e-mail address.
 */
Drupal.behaviors.copyFieldValue = {
  attach: function (context, settings) {
    for (var sourceId in settings.copyFieldValue) {
      $('#' + sourceId, context).once('copy-field-values').bind('blur', function () {
        // Get the list of target fields.
        var targetIds = settings.copyFieldValue[sourceId];
        // Add the behavior to update target fields on blur of the primary field.
        for (var delta in targetIds) {
          var targetField = $('#' + targetIds[delta]);
          if (targetField.val() == '') {
            targetField.val(this.value);
          }
        }
      });
    }
  }
};

/**
 * Show/hide custom format sections on the regional settings page.
 */
Drupal.behaviors.dateTime = {
  attach: function (context, settings) {
    for (var fieldName in settings.dateTime) {
      if (settings.dateTime.hasOwnProperty(fieldName)) {
        (function (fieldSettings, fieldName) {
          var source = '#edit-' + fieldName;
          var suffix = source + '-suffix';

          // Attach keyup handler to custom format inputs.
          $('input' + source, context).once('date-time').keyup(function () {
            var input = $(this);
            var url = fieldSettings.lookup + (/\?q=/.test(fieldSettings.lookup) ? '&format=' : '?format=') + encodeURIComponent(input.val());
            $.getJSON(url, function (data) {
              $(suffix).empty().append(' ' + fieldSettings.text + ': <em>' + data + '</em>');
            });
          });
        })(settings.dateTime[fieldName], fieldName);
      }
    }
  }
};

 /**
 * Show/hide settings for page caching depending on whether page caching is
 * enabled or not.
 */
Drupal.behaviors.pageCache = {
  attach: function (context, settings) {
    $('#edit-cache-0', context).change(function () {
      $('#page-compression-wrapper').hide();
      $('#cache-error').hide();
    });
    $('#edit-cache-1', context).change(function () {
      $('#page-compression-wrapper').show();
      $('#cache-error').hide();
    });
    $('#edit-cache-2', context).change(function () {
      $('#page-compression-wrapper').show();
      $('#cache-error').show();
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
