Drupal.locale = { 'pluralFormula': function ($n) { return Number(($n!=1)); }, 'strings': {"":{"An AJAX HTTP error occurred.":"Ocorreu um erro HTTP no AJAX", "HTTP Result Code: !status":"Código do Resultado HTTP:  !status", "An AJAX HTTP request terminated abnormally.":"Uma requisição HTTP AJAX terminou de forma anormal.", "Debugging information follows.":"Estas são as informações de depuração.", "Path: !uri":"Caminho: !url", "StatusText: !statusText":"Texto de Status: !statusText", "ResponseText: !responseText":"Texto de Resposta: !responseText", "ReadyState: !readyState":"ReadyState: !readyState", "Loading":"Carregando", "(active tab)":"(aba ativa)", "Hide":"Ocultar", "Show":"Exibir", "Configure":"Configurar", "Show shortcuts":"Mostrar atalhos", "Hide shortcuts":"Esconder atalhos", "Title":"Legenda da foto", "Disabled":"Desativado", "Enabled":"Ativado", "Edit":"Editar", "none":"nenhum", "Done":"Concluído", "Logout":"Sair", "Select all rows in this table":"Selecionar todas as linhas da tabela", "Deselect all rows in this table":"Desmarcar todas as linhas da tabela", "Not published":"Não publicado", "Please wait...":"Por favor, espere um pouco...", "By @name on @date":"Por @name em @date", "By @name":"Por @name", "Not in menu":"Fora do menu", "Alias: @alias":"Endereço: @alias", "No alias":"Não há um endereço", "New revision":"Nova revisão", "Drag to re-order":"Arraste para reordenar", "Changes made in this table will not be saved until the form is submitted.":"As mudanças feitas nesta tabela não vão ser salvas antes do formulário ser enviado.", "The changes to these blocks will not be saved until the \u003Cem\u003ESave blocks\u003C\u002Fem\u003E button is clicked.":"As alterações nesses blocos não vão ser salvas enquanto o botão \u003Cem\u003ESalvar Blocos\u003C\u002Fem\u003E não for clicado.", "This permission is inherited from the authenticated user role.":"Essa permissão é herdada do papel de usuário autenticado.", "No revision":"Sem revisão", "@number comments per page":"@number comentários por página", "Requires a title":"Título requerido", "Not restricted":"Sem restrições", "Not customizable":"Não é personalizável", "Restricted to certain pages":"Restrito para certas páginas", "The block cannot be placed in this region.":"O bloco não pode ser colocado nessa região.", "Customize dashboard":"Personalizar painel", "Edit summary":"Editar resumo", "Don\u0027t display post information":"Não exibir informações de postagem", "The selected file %filename cannot be uploaded. Only files with the following extensions are allowed: %extensions.":"O arquivo %filename selecionado não pode ser carregado. Apenas arquivos com as seguintes extensões são permitidos: %extensions.", "Re-order rows by numerical weight instead of dragging.":"Re-ordernar as linhas por campos númericos de peso ao invés de arrastar-e-soltar.", "Show row weights":"Exibir pesos das linhas", "Hide row weights":"Ocultar pesos das linhas", "Autocomplete popup":"Popup de autocompletar", "Searching for matches...":"Procurando por dados correspondentes..."}} };;
// ColorBox v1.3.18 - a full featured, light-weight, customizable lightbox based on jQuery 1.3+
// Copyright (c) 2011 Jack Moore - jack@colorpowered.com
// Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
(function(a,b,c){function Y(c,d,e){var g=b.createElement(c);return d&&(g.id=f+d),e&&(g.style.cssText=e),a(g)}function Z(a){var b=y.length,c=(Q+a)%b;return c<0?b+c:c}function $(a,b){return Math.round((/%/.test(a)?(b==="x"?z.width():z.height())/100:1)*parseInt(a,10))}function _(a){return K.photo||/\.(gif|png|jpe?g|bmp|ico)((#|\?).*)?$/i.test(a)}function ab(){var b;K=a.extend({},a.data(P,e));for(b in K)a.isFunction(K[b])&&b.slice(0,2)!=="on"&&(K[b]=K[b].call(P));K.rel=K.rel||P.rel||"nofollow",K.href=K.href||a(P).attr("href"),K.title=K.title||P.title,typeof K.href=="string"&&(K.href=a.trim(K.href))}function bb(b,c){a.event.trigger(b),c&&c.call(P)}function cb(){var a,b=f+"Slideshow_",c="click."+f,d,e,g;K.slideshow&&y[1]?(d=function(){F.text(K.slideshowStop).unbind(c).bind(j,function(){if(Q<y.length-1||K.loop)a=setTimeout(W.next,K.slideshowSpeed)}).bind(i,function(){clearTimeout(a)}).one(c+" "+k,e),r.removeClass(b+"off").addClass(b+"on"),a=setTimeout(W.next,K.slideshowSpeed)},e=function(){clearTimeout(a),F.text(K.slideshowStart).unbind([j,i,k,c].join(" ")).one(c,function(){W.next(),d()}),r.removeClass(b+"on").addClass(b+"off")},K.slideshowAuto?d():e()):r.removeClass(b+"off "+b+"on")}function db(b){if(!U){P=b,ab(),y=a(P),Q=0,K.rel!=="nofollow"&&(y=a("."+g).filter(function(){var b=a.data(this,e).rel||this.rel;return b===K.rel}),Q=y.index(P),Q===-1&&(y=y.add(P),Q=y.length-1));if(!S){S=T=!0,r.show();if(K.returnFocus)try{P.blur(),a(P).one(l,function(){try{this.focus()}catch(a){}})}catch(c){}q.css({opacity:+K.opacity,cursor:K.overlayClose?"pointer":"auto"}).show(),K.w=$(K.initialWidth,"x"),K.h=$(K.initialHeight,"y"),W.position(),o&&z.bind("resize."+p+" scroll."+p,function(){q.css({width:z.width(),height:z.height(),top:z.scrollTop(),left:z.scrollLeft()})}).trigger("resize."+p),bb(h,K.onOpen),J.add(D).hide(),I.html(K.close).show()}W.load(!0)}}var d={transition:"elastic",speed:300,width:!1,initialWidth:"600",innerWidth:!1,maxWidth:!1,height:!1,initialHeight:"450",innerHeight:!1,maxHeight:!1,scalePhotos:!0,scrolling:!0,inline:!1,html:!1,iframe:!1,fastIframe:!0,photo:!1,href:!1,title:!1,rel:!1,opacity:.9,preloading:!0,current:"image {current} of {total}",previous:"previous",next:"next",close:"close",open:!1,returnFocus:!0,loop:!0,slideshow:!1,slideshowAuto:!0,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",onOpen:!1,onLoad:!1,onComplete:!1,onCleanup:!1,onClosed:!1,overlayClose:!0,escKey:!0,arrowKey:!0,top:!1,bottom:!1,left:!1,right:!1,fixed:!1,data:undefined},e="colorbox",f="cbox",g=f+"Element",h=f+"_open",i=f+"_load",j=f+"_complete",k=f+"_cleanup",l=f+"_closed",m=f+"_purge",n=a.browser.msie&&!a.support.opacity,o=n&&a.browser.version<7,p=f+"_IE6",q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X="div";W=a.fn[e]=a[e]=function(b,c){var f=this;b=b||{},W.init();if(!f[0]){if(f.selector)return f;f=a("<a/>"),b.open=!0}return c&&(b.onComplete=c),f.each(function(){a.data(this,e,a.extend({},a.data(this,e)||d,b)),a(this).addClass(g)}),(a.isFunction(b.open)&&b.open.call(f)||b.open)&&db(f[0]),f},W.init=function(){if(!r){if(!a("body")[0]){a(W.init);return}z=a(c),r=Y(X).attr({id:e,"class":n?f+(o?"IE6":"IE"):""}),q=Y(X,"Overlay",o?"position:absolute":"").hide(),s=Y(X,"Wrapper"),t=Y(X,"Content").append(A=Y(X,"LoadedContent","width:0; height:0; overflow:hidden"),C=Y(X,"LoadingOverlay").add(Y(X,"LoadingGraphic")),D=Y(X,"Title"),E=Y(X,"Current"),G=Y(X,"Next"),H=Y(X,"Previous"),F=Y(X,"Slideshow").bind(h,cb),I=Y(X,"Close")),s.append(Y(X).append(Y(X,"TopLeft"),u=Y(X,"TopCenter"),Y(X,"TopRight")),Y(X,!1,"clear:left").append(v=Y(X,"MiddleLeft"),t,w=Y(X,"MiddleRight")),Y(X,!1,"clear:left").append(Y(X,"BottomLeft"),x=Y(X,"BottomCenter"),Y(X,"BottomRight"))).find("div div").css({"float":"left"}),B=Y(X,!1,"position:absolute; width:9999px; visibility:hidden; display:none"),a("body").prepend(q,r.append(s,B)),L=u.height()+x.height()+t.outerHeight(!0)-t.height(),M=v.width()+w.width()+t.outerWidth(!0)-t.width(),N=A.outerHeight(!0),O=A.outerWidth(!0),r.css({"padding-bottom":L,"padding-right":M}).hide(),G.click(function(){W.next()}),H.click(function(){W.prev()}),I.click(function(){W.close()}),J=G.add(H).add(E).add(F),q.click(function(){K.overlayClose&&W.close()}),a(b).bind("keydown."+f,function(a){var b=a.keyCode;S&&K.escKey&&b===27&&(a.preventDefault(),W.close()),S&&K.arrowKey&&y[1]&&(b===37?(a.preventDefault(),H.click()):b===39&&(a.preventDefault(),G.click()))})}},W.remove=function(){r.add(q).remove(),r=null,a("."+g).removeData(e).removeClass(g)},W.position=function(a,b){function i(a){u[0].style.width=x[0].style.width=t[0].style.width=a.style.width,C[0].style.height=C[1].style.height=t[0].style.height=v[0].style.height=w[0].style.height=a.style.height}var c=0,d=0,e=r.offset(),g=z.scrollTop(),h=z.scrollLeft();z.unbind("resize."+f),r.css({top:-9e4,left:-9e4}),K.fixed&&!o?(e.top-=g,e.left-=h,r.css({position:"fixed"})):(c=g,d=h,r.css({position:"absolute"})),K.right!==!1?d+=Math.max(z.width()-K.w-O-M-$(K.right,"x"),0):K.left!==!1?d+=$(K.left,"x"):d+=Math.round(Math.max(z.width()-K.w-O-M,0)/2),K.bottom!==!1?c+=Math.max(z.height()-K.h-N-L-$(K.bottom,"y"),0):K.top!==!1?c+=$(K.top,"y"):c+=Math.round(Math.max(z.height()-K.h-N-L,0)/2),r.css({top:e.top,left:e.left}),a=r.width()===K.w+O&&r.height()===K.h+N?0:a||0,s[0].style.width=s[0].style.height="9999px",r.dequeue().animate({width:K.w+O,height:K.h+N,top:c,left:d},{duration:a,complete:function(){i(this),T=!1,s[0].style.width=K.w+O+M+"px",s[0].style.height=K.h+N+L+"px",b&&b(),setTimeout(function(){z.bind("resize."+f,W.position)},1)},step:function(){i(this)}})},W.resize=function(a){S&&(a=a||{},a.width&&(K.w=$(a.width,"x")-O-M),a.innerWidth&&(K.w=$(a.innerWidth,"x")),A.css({width:K.w}),a.height&&(K.h=$(a.height,"y")-N-L),a.innerHeight&&(K.h=$(a.innerHeight,"y")),!a.innerHeight&&!a.height&&(A.css({height:"auto"}),K.h=A.height()),A.css({height:K.h}),W.position(K.transition==="none"?0:K.speed))},W.prep=function(b){function g(){return K.w=K.w||A.width(),K.w=K.mw&&K.mw<K.w?K.mw:K.w,K.w}function h(){return K.h=K.h||A.height(),K.h=K.mh&&K.mh<K.h?K.mh:K.h,K.h}if(!S)return;var c,d=K.transition==="none"?0:K.speed;A.remove(),A=Y(X,"LoadedContent").append(b),A.hide().appendTo(B.show()).css({width:g(),overflow:K.scrolling?"auto":"hidden"}).css({height:h()}).prependTo(t),B.hide(),a(R).css({"float":"none"}),o&&a("select").not(r.find("select")).filter(function(){return this.style.visibility!=="hidden"}).css({visibility:"hidden"}).one(k,function(){this.style.visibility="inherit"}),c=function(){function q(){n&&r[0].style.removeAttribute("filter")}var b,c,g=y.length,h,i="frameBorder",k="allowTransparency",l,o,p;if(!S)return;l=function(){clearTimeout(V),C.hide(),bb(j,K.onComplete)},n&&R&&A.fadeIn(100),D.html(K.title).add(A).show();if(g>1){typeof K.current=="string"&&E.html(K.current.replace("{current}",Q+1).replace("{total}",g)).show(),G[K.loop||Q<g-1?"show":"hide"]().html(K.next),H[K.loop||Q?"show":"hide"]().html(K.previous),K.slideshow&&F.show();if(K.preloading){b=[Z(-1),Z(1)];while(c=y[b.pop()])o=a.data(c,e).href||c.href,a.isFunction(o)&&(o=o.call(c)),_(o)&&(p=new Image,p.src=o)}}else J.hide();K.iframe?(h=Y("iframe")[0],i in h&&(h[i]=0),k in h&&(h[k]="true"),h.name=f+ +(new Date),K.fastIframe?l():a(h).one("load",l),h.src=K.href,K.scrolling||(h.scrolling="no"),a(h).addClass(f+"Iframe").appendTo(A).one(m,function(){h.src="//about:blank"})):l(),K.transition==="fade"?r.fadeTo(d,1,q):q()},K.transition==="fade"?r.fadeTo(d,0,function(){W.position(0,c)}):W.position(d,c)},W.load=function(b){var c,d,e=W.prep;T=!0,R=!1,P=y[Q],b||ab(),bb(m),bb(i,K.onLoad),K.h=K.height?$(K.height,"y")-N-L:K.innerHeight&&$(K.innerHeight,"y"),K.w=K.width?$(K.width,"x")-O-M:K.innerWidth&&$(K.innerWidth,"x"),K.mw=K.w,K.mh=K.h,K.maxWidth&&(K.mw=$(K.maxWidth,"x")-O-M,K.mw=K.w&&K.w<K.mw?K.w:K.mw),K.maxHeight&&(K.mh=$(K.maxHeight,"y")-N-L,K.mh=K.h&&K.h<K.mh?K.h:K.mh),c=K.href,V=setTimeout(function(){C.show()},100),K.inline?(Y(X).hide().insertBefore(a(c)[0]).one(m,function(){a(this).replaceWith(A.children())}),e(a(c))):K.iframe?e(" "):K.html?e(K.html):_(c)?(a(R=new Image).addClass(f+"Photo").error(function(){K.title=!1,e(Y(X,"Error").text("This image could not be loaded"))}).load(function(){var a;R.onload=null,K.scalePhotos&&(d=function(){R.height-=R.height*a,R.width-=R.width*a},K.mw&&R.width>K.mw&&(a=(R.width-K.mw)/R.width,d()),K.mh&&R.height>K.mh&&(a=(R.height-K.mh)/R.height,d())),K.h&&(R.style.marginTop=Math.max(K.h-R.height,0)/2+"px"),y[1]&&(Q<y.length-1||K.loop)&&(R.style.cursor="pointer",R.onclick=function(){W.next()}),n&&(R.style.msInterpolationMode="bicubic"),setTimeout(function(){e(R)},1)}),setTimeout(function(){R.src=c},1)):c&&B.load(c,K.data,function(b,c,d){e(c==="error"?Y(X,"Error").text("Request unsuccessful: "+d.statusText):a(this).contents())})},W.next=function(){!T&&y[1]&&(Q<y.length-1||K.loop)&&(Q=Z(1),W.load())},W.prev=function(){!T&&y[1]&&(Q||K.loop)&&(Q=Z(-1),W.load())},W.close=function(){S&&!U&&(U=!0,S=!1,bb(k,K.onCleanup),z.unbind("."+f+" ."+p),q.fadeTo(200,0),r.stop().fadeTo(300,0,function(){r.add(q).css({opacity:1,cursor:"auto"}).hide(),bb(m),A.remove(),setTimeout(function(){U=!1,bb(l,K.onClosed)},1)}))},W.element=function(){return a(P)},W.settings=d,a("."+g,b).live("click",function(a){a.which>1||a.shiftKey||a.altKey||a.metaKey||(a.preventDefault(),db(this))}),W.init()})(jQuery,document,this);;
(function ($) {

Drupal.behaviors.initColorbox = {
  attach: function (context, settings) {
    if (!$.isFunction($.colorbox)) {
      return;
    }
    $('a, area, input', context)
      .filter('.colorbox')
      .once('init-colorbox-processed')
      .colorbox(settings.colorbox);
  }
};

{
  $(document).bind('cbox_complete', function () {
    Drupal.attachBehaviors('#cboxLoadedContent');
  });
}

})(jQuery);
;
(function ($) {

Drupal.behaviors.initColorboxDefaultStyle = {
  attach: function (context, settings) {
    $(document).bind('cbox_complete', function () {
      // Only run if there is a title.
      if ($('#cboxTitle:empty', context).length == false) {
        setTimeout(function () { $('#cboxTitle', context).slideUp() }, 1500);
        $('#cboxLoadedContent img', context).bind('mouseover', function () {
          $('#cboxTitle', context).slideDown();
        });
        $('#cboxOverlay', context).bind('mouseover', function () {
          $('#cboxTitle', context).slideUp();
        });
      }
      else {
        $('#cboxTitle', context).hide();
      }
    });
  }
};

})(jQuery);
;
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
