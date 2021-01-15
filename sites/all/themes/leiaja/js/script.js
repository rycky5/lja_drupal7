(function ($) {
  $(document).ready(function () {

    var skyscraperCheck = function () {
      var winWid = $(window).width();
      if(winWid > 1130 && $('.bannerSkyscraper div.wsz').children().length > 1) {
        $('#divMenuTopo .divMenuContent, #divContainer .divContainerContent, .region-cobertura .divContainerContent, .divContentNoticiaDestaque, .divFooterContent, .divContainer.bgBranco .divContainerContent').attr('style','width:1125px');
        $('.colunaDireita, .divFooterContent p').attr('style','margin-right:175px');
        //$('.divMenuContent a.logolink').attr('style','margin-left:77px;float:left');
        $('ul.menu').attr('style','margin-top:9px !important;');
        $('#bannerSkyscraper').show();
      } else {
        $('#divMenuTopo .divMenuContent, #divContainer .divContainerContent, .divContainer.bgBranco .divContainerContent, .divMenuContent,  .colunaDireita, .divMeuLeiaJa, .divMenuContent a.logolink, .divFooterContent p, .divFooterContent').removeAttr('style');
        $('#bannerSkyscraper').hide();        
      }
    }
    skyscraperCheck();
    $(window).resize(function (){ skyscraperCheck() });

    // Fixar barra no topo.
    if ($('#divMenuTopo').length !== 0) {
      $(window).scroll(function () {
        if ($(this).scrollTop() > 40) {
          $("#divMenuTopo").addClass('menuCloud');
          $(".divBannerTop").addClass('divBannerTopFixed');
          $("#divContainer").addClass('divContainerCloud ');
        } else {
          $("#divMenuTopo").removeClass('menuCloud');
          $(".divBannerTop").removeClass('divBannerTopFixed');
          $("#divContainer").removeClass('divContainerCloud');
        }
      });
    }

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
      
      //Recuperando os dados do form
      dados = $('#user-login-ajax').serialize();
      
      $.post("/usuario/login", dados, function(arrRetorno){
        //alert(arrRetorno.strMensagem +"\n"+ arrRetorno.bolRetorno);
        
        if(arrRetorno.bolRetorno == false){
            
            alert(arrRetorno.strMensagem);
            javascript:Recaptcha.reload();      
            
            $('#buttonSubmit').fadeIn();
            $('#divActionlogando').hide();
            
        }else{          
            
            alert(arrRetorno.strMensagem);
            window.location.href = window.location.href + "meuleiaja" 
            
        }        
      },'json');
      
      return false;
    };

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