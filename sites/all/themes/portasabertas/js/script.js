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
}