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
  $(document).ready(function () {


    // Fixar barra no topo.
    if ($('#divMenuTopo').length !== 0) {
      $(window).scroll(function () {
        if ($(this).scrollTop() > 142) {
          $("#divMenuTopo").addClass('menuCloud');
          $("#divContainer").addClass('divContainerCloud ');
        } else {
          $("#divMenuTopo").removeClass('menuCloud');
          $("#divContainer").removeClass('divContainerCloud');
        }
      });
    }

    // LeiaJá controle janela Preview.
      var  vCarregandoPreview = false;

    previewNoticia = function (pUrl) {
      if (!vCarregandoPreview) {
        vCarregandoPreview = true;
        $(".telaEscura img, .telaEscura").show();

        $.get(pUrl + "?preview=true", function (pRetorno) {
          vZoomPosicao = 1;
          $("#divContainerPreview").css({
            'top': '',
            'bottom': '',
            'left': '',
            'right': ''
          }).show().draggable({
            handle: ".divPreviewTop"
          });
          $(".telaEscura img").hide();
          $("#divContentPreview").html(pRetorno);
          ajustaTamanho();
					$(window).bind('resize', function() { ajustaTamanho(); });
        });
      }

      return false;
    };

    ajustaTamanho = function () {
      if ($(window).height() < 700) {
        vNovoHeightContainer = $(window).height() - 100;
        vNovoHeightContent = $(window).height() - 136;
        vNovoHeightTexto = vNovoHeightContainer - 154;
        vMargin = -(vNovoHeightContainer / 2);

        $('#divContainerPreview').height(vNovoHeightContainer).css('margin-top', vMargin);
        $('#divContentPreview').height(vNovoHeightContent);
        $('#divPreviewNoticia').height(vNovoHeightTexto);
      };
    };

    previewNoticiaFechar = function () {
      $("#divContainerPreview").hide();
      $(".telaEscura").hide();
			$(window).unbind('resize');
      vCarregandoPreview = false;

      return false;
    };


    // Adicionar eventos para preview.
    var arrLeiamais = new Array();

    previewInit = function(){
      $('[class*="previewmodal"]').bind('mouseenter', function () {
        var vOrdem = $(this).attr('class').split('previewmodal'),
						vIdLeia;
	vOrdem = vOrdem[1].split(' ');
	vOrdem = vOrdem[0];
        
        vIdLeia = '#leiamais' + vOrdem;
        $(vIdLeia).css('display', 'block');
        clearInterval(arrLeiamais[vOrdem]);
      }).bind('mouseout', function () {
        var vOrdem = $(this).attr('class').split('previewmodal'),
						vIdLeia;
				vOrdem = vOrdem[1].split(' ');
				vOrdem = vOrdem[0];
        vIdLeia = '#leiamais' + vOrdem;
        arrLeiamais[vOrdem] = window.setTimeout('fecharLeiaMais(' + vOrdem + ')', 2000);

      });

      $(".lerJa").bind("click", function () {
        previewNoticia($(this).attr('lerja'));
      });

      $('.lerDepois').click(function () {
        favorito_leiaja($(this).attr('follow'));
      });
    }

    //Fecha a janela do preview.
    fecharLeiaMais = function (pId) {
      $('#leiamais' + pId).fadeOut();
      clearInterval(arrLeiamais[pId]);
    };

    // Adiciona evento para imprimir.
    $("#aImprimir,#aPrintTopo,#aPrintTopoBotao").bind("click", function () {
    	vLink = location.href.replace("#","");
    	vLink = (vLink.indexOf("?print=true") == -1) ? vLink+'?print=true' : vLink;
        abreJanela(vLink);
    });
    
    $("#aRecomendar").bind("click", function(){
        esconder();
        $(" #divRecomendar").fadeIn();
        $(".imgCaptcha").attr('src','formulario/captcha?'+Math.random());
        subir();
    })

    //Adiciona evento onlick para autoselecionar o conteúdo do imput.
    $(".bgInputLink input").bind('click', function () {
      this.focus();
      this.select();
    });


    //Favoritos - Meu LeiaJa
    favorito_leiaja = function (pFollow) {
      var gets = pFollow.split(';');
      if (gets[0] == 0) {
        modalLogin(pFollow);
      } else {
        //If existir o 3º parâmentro, será integrado no post
        if (typeof gets[2] != 'undefined') {
          var tipo = '&pType=' + gets[2];
        } else {
          var tipo = '';
        }
        $.ajax({
          type: "POST",
          url: PATHR + 'meusfavoritos?&pNid=' + gets[1] + tipo,
          success: function (data) {
            if (data == 1) {
              alert('Adicionado com Sucesso.');
            } else if (data == 0) {
              alert('Notícia já havia sido adicionada.');
            }
          }
        });
      }
    };


    //Fecha a tela modal de login.
    divFecharLogin = function () {
      $(".divContainerLogin, .telaEscura").hide();
      return false;
    };
    
    // Exibe a tela para realizar login vindo do ícone fixar no mural.
    modalLogin = function (follow) {
      if (typeof follow != 'undefined') {
        var gets = follow.split(';');
        if (gets[2]) {
          $('#user-login-ajax').append('<input type="hidden" value="' + gets[1] + ';' + gets[2] + '" name="nidFollow">');
        } else {
          $('#user-login-ajax').append('<input type="hidden" value="' + gets[1] + '" name="nidFollow">');
        }


      }

      $('.telaEscura').show();
      $('span.fb_button_text').text('Facebook');
      $('.divContainerLogin').fadeIn(300);
    };


    //Exibe a tela modal de Termo de Aceito. Registro via Facebook.
    modalContrato = function () {
      $('.telaEscura').show();
      $('.modalCadastroFacebook').fadeIn(300);
    };
    aceitarContrato = function (f) {
      if ($('#termoUso').attr('checked')) {
        $('.modalCadastroFacebook').fadeOut(300);
        $.get(PATHR + 'ajax/facebook/accept', function (rs) {
          if (rs) {
            $('.telaEscura').fadeOut(300);
          } else {
            $('.modalCadastroFacebook').fadeIn(300);
            alert('Favor tentar novamente');
          }
        }, 'json');
      } else {
        alert('O contrato deve ser aceito antes de continuar.');
      }
    }
    rejeitarContrato = function (f) {
      window.location = PATHR + 'user/logout';
    }

    // Exibe a tela de login do MeuLeiaja.
    efetuarLogin = function(){
      $('#buttonSubmit').hide();
      $('#divActionlogando').fadeIn();
      $.ajax({
        type: "POST",
        url: PATHR + 'ajax/userlogin',
        data: $('#user-login-ajax').serialize(),
        success: function (data) {
          if (isNaN(data)) {
            window.location.href = data;
          } else if (data == '1' || data == '11') {
            location.reload();
          }else if (data == '0'){
            $('#inpSenha').val('');
            alert('Login ou Senha invalidos.');
          }
        },
        complete: function(){
          $('#divActionlogando').hide();
          $('#buttonSubmit').fadeIn();
        }
      });
      return false;
    };
    //Init do preview
    previewInit();

    //Correcao sobreposicao iframes/embeds 
    $(".textoExibir iframe").each(function () { 
      var ifr_source = $(this).attr('src'), 
          wmode = "?&wmode=opaque"; 
      $(this).attr('src', ifr_source + wmode).attr('wmode', 'Opaque'); 
    }); 		

	
  });
})(jQuery);

function abreJanela(pUrl) {
	window.open(pUrl, "Impressao", "width=700, height=450, top=1, left=1, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no");
};
