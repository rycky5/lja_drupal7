(function ($) {
	
	BlkMultimidiaLegendaHover = function(pId){
    $("[rel='mnuBlkMM']").hide();
    $("#"+pId).show();
  }
  
  BlkMultimidiaCategoriaHover = function(pObj, pId){
    $("#divMnuBlkVideo,#divMnuBlkTv,#divMnuBlkGaleria,#divMnuBlkPodcast,#divMnuBlkInfografico").hide();
    $(".UlMultimidia a").removeClass('active');
    $(pObj).addClass('active');
    $("#"+pId).show();
  }
	
  var vMMCursorVideo       = 3;
  var vMMCursorGaleria     = 3;
  var vMMCursorTv          = 3;
  var vMMCursorInfografico = 3;
  var vMMCursorPodcast     = 3;
  var vMMCursorCarnaval    = 3;

  // Controle Vídeos 
  $("#aVideoAvanca").bind("click",function(){
   galeriaAvanca("Video");
  });

  $("#aVideoVolta").bind("click",function(){
	galeriaVoltar("Video");
  });
    
  // Controle Galerias 
  $("#aGaleriaAvanca").bind("click",function(){
   galeriaAvanca("Galeria");
  });

  $("#aGaleriaVolta").bind("click",function(){
	galeriaVoltar("Galeria");
  });    
    
  // Controle Tv 
//  $("#aTvAvanca").bind("click",function(){
//   galeriaAvanca("Tv");
//  });
//
//  $("#aTvVolta").bind("click",function(){
//	galeriaVoltar("Tv");
//  });  
//  jQuery('[data-passador]').bind('click',function(e){
//    $self = jQuery(this);
//    trim($self.parents().find('.container-multimidia-block'));
//    acao = $self.attr('data-passador');
//    if(acao == "voltar"){
//      vMMTv = "";
//    }
//  });
  // Podcast
  $("#aPodcastAvanca").bind("click",function(){
    galeriaAvanca("Podcast");
  });

  $("#aPodcastVolta").bind("click",function(){
    galeriaVoltar("Podcast");
  });
  
  // Carnaval
  $("#aCarnavalAvanca").bind("click",function(){
    galeriaAvancaCarnaval("Carnaval");
  });

  $("#aCarnavalVolta").bind("click",function(){
    galeriaVoltar("Carnaval");
  });
  
  // Funcao genérica para controle do botão Avançar.
  galeriaAvanca = function(pBloco){    
    
    $("#divCarregando").show();
    eval("vPosicao = vMM"+pBloco+".length+1;");
    eval("vArrTmp = vMM"+pBloco+".length-1;");
    //alert('Cursor:'+vMMCursor+' | Array:'+(vMMVideo.length-1));
    eval("vCursorTmp = vMMCursor"+pBloco+";"); 
    
    
    if(vCursorTmp < vArrTmp){
        eval("vMMCursor"+pBloco+"++;");  
        moveGaleria(pBloco);
        $('#divCarregando').hide();
    }else{
            eval("$.getJSON('multimidia/ajax/?posicao='+vPosicao+'&tipo="+pBloco+"', function(pRetorno){ \
        if(pRetorno){ \
              vMM"+pBloco+".push(pRetorno); \
              vMMCursor"+pBloco+"++; \
              moveGaleria('"+pBloco+"'); \
              $('#divCarregando').hide(); \
        }else{ \
          $('#a"+pBloco+"Avanca').addClass('passaRightFim'); \
          $('#divCarregando').hide(); \
        } \
       });");
     }
     $('#a'+pBloco+'Volta').removeClass('passaLeftFim');
  }
  
  // Funcao genérica para controle do botão Avançar .
  galeriaAvancaCarnaval = function(pBloco){
        $("#divCarregando").show();
	eval("vPosicao = vMM"+pBloco+".length+1;");
	eval("vArrTmp = vMM"+pBloco+".length-1;");
	//alert('Cursor:'+vMMCursor+' | Array:'+(vMMVideo.length-1));
	eval("vCursorTmp = vMMCursor"+pBloco+";"); 
	
	if(vCursorTmp < vArrTmp){
	  eval("vMMCursor"+pBloco+"++;");  
          moveGaleria(pBloco);
	}else{
          eval("$.getJSON('/videosambatech/listartopvideos/?posicao='+vPosicao+'&categoria=carnaval_2012', function(pRetorno){ \
              if(pRetorno){ \
                    vMM"+pBloco+".push(pRetorno); \
                    vMMCursor"+pBloco+"++; \
                    moveGaleria('"+pBloco+"'); \
                    $('#divCarregando').hide(); \
               }else{ \
                $('#a"+pBloco+"Avanca').addClass('passaRightFim'); \
              } \
           });");
	 }
	 $('#a'+pBloco+'Volta').removeClass('passaLeftFim');
  }

  // Função genérica para controle do botão Voltar.
  galeriaVoltar = function(pBloco){
		var vId = (pBloco == undefined) ? 'Video' : pBloco;
		eval("vCursorTmp = vMMCursor"+vId+";");
	
			if(vCursorTmp == 3){
			$('#a'+pBloco+'Volta').addClass('passaLeftFim');
		}else{
			eval("vMMCursor"+pBloco+"--");
			moveGaleria(pBloco);
		}
		$('#a'+pBloco+'Avanca').removeClass('passaRightFim');	  
  }
  
  // Funcao Generica para atualizar itens galeria.
  moveGaleria = function(pBloco){
	  var vId = (pBloco == undefined) ? 'Video' : pBloco;
	  eval("vCursorAtivo = vMMCursor"+vId+";");
	  eval("vArrTemp = vMM"+vId+";");
	  
//          if(pBloco != 'Podcast'){
            $("#divMnuBlk"+vId+" [rel='img14']").attr('src',vArrTemp[vCursorAtivo].thumbPeq);
//          }
	  $("#divMnuBlk"+vId+" [rel='a4']").attr('href',vArrTemp[vCursorAtivo].link);	  
	  $("#divMnuBlk"+vId+" [rel='aTitulo4']").text(vArrTemp[vCursorAtivo].titulo);	  
          $("#divMnuBlk"+vId+" [rel='aTitulo4']").attr('href',vArrTemp[vCursorAtivo].link);
	  $("#divMnuBlk"+vId+" [rel='strongTag4']").text(vArrTemp[vCursorAtivo].tag);	  
	  $("#divMnuBlk"+vId+" [rel='spanCount4']").text("Views "+vArrTemp[vCursorAtivo].views)
	  
//          if(pBloco != 'Podcast'){
            $("#divMnuBlk"+vId+" [rel='img13']").attr('src',vArrTemp[vCursorAtivo-1].thumbPeq);
//          }	  
          $("#divMnuBlk"+vId+" [rel='a3']").attr('href',vArrTemp[vCursorAtivo-1].link);
	  $("#divMnuBlk"+vId+" [rel='aTitulo3']").text(vArrTemp[vCursorAtivo-1].titulo);
	  $("#divMnuBlk"+vId+" [rel='aTitulo3']").attr('href',vArrTemp[vCursorAtivo-1].link);
	  $("#divMnuBlk"+vId+" [rel='strongTag3']").text(vArrTemp[vCursorAtivo-1].tag);	  
	  $("#divMnuBlk"+vId+" [rel='spanCount3']").text("Views "+vArrTemp[vCursorAtivo-1].views);	  

//	  if(pBloco != 'Podcast'){
            $("#divMnuBlk"+vId+" [rel='img12']").attr('src',vArrTemp[vCursorAtivo-2].thumbPeq);
//          }
          $("#divMnuBlk"+vId+" [rel='a2']").attr('href',vArrTemp[vCursorAtivo-2].link);
	  $("#divMnuBlk"+vId+" [rel='aTitulo2']").text(vArrTemp[vCursorAtivo-2].titulo);
	  $("#divMnuBlk"+vId+" [rel='aTitulo2']").attr('href',vArrTemp[vCursorAtivo-2].link);
	  $("#divMnuBlk"+vId+" [rel='strongTag2']").text(vArrTemp[vCursorAtivo-2].tag);	  
	  $("#divMnuBlk"+vId+" [rel='spanCount2']").text("Views "+vArrTemp[vCursorAtivo-2].views);	  

//	  if(pBloco != 'Podcast'){
            $("#divMnuBlk"+vId+" [rel='img1']").attr('src',vArrTemp[vCursorAtivo-3].thumbGrd);
//          }
          $("#divMnuBlk"+vId+" [rel='a1']").attr('href',vArrTemp[vCursorAtivo-3].link);
	  $("#divMnuBlk"+vId+" [rel='aTitulo1']").text(vArrTemp[vCursorAtivo-3].titulo);
	  $("#divMnuBlk"+vId+" [rel='aTitulo1']").attr('href',vArrTemp[vCursorAtivo-3].link);
	  $("#divMnuBlk"+vId+" [rel='strongTag1']").text(vArrTemp[vCursorAtivo-3].tag);	  
	  $("#divMnuBlk"+vId+" [rel='spanCount1']").text("Views "+vArrTemp[vCursorAtivo-3].views);	  
  };
  
  /*
   *Nova função do bloco multimidia:
   *
   **/
    $('[data-passador]').click(function(){
      $self=$(this);
      //selecionando a direção que foi selecionada;
      direcao = $self.attr('data-passador');
      $boxslides  = $self.parents().find('.container-multimidia-block');
      //pegando a aba ativa para passar a ul correta;
      indice = $('.UlMultimidia li a').index($('.UlMultimidia li a.active'));
      //selecionando o ul relacionado;
      $containerSlides  = $boxslides.find('ul').eq(indice);
      //pegando o valor com base no $containerSlides - usado para dinamizar o passador e não afetar nos outros slides na pagina;
      valor = parseInt($containerSlides.css('marginLeft').replace('px',''));
      //pegando o tamanho do box para saber se tem 1, 2 ou 3 elementos visiveis;
      boxslidesWidth  = $boxslides.width();
      //qtdItensList no slide;
      qtdItensList = $containerSlides.find('li').length;
      //guardando a largura de cada item da lista <li>;
//      larguraLi = $containerSlides.find('li').width()+10;
      larguraLi = 150;
      //largura da <ul> deve ser o tamanho das <li>*qtd de <li> na lista;

      larguraUl = qtdItensList*(larguraLi);
      $containerSlides.width(larguraUl);

      //largura do passar
      passar=600;
      visivel = 4;
      //setando o limite do slide;
      limite = (qtdItensList-visivel)*larguraLi;

      //verificando a direção que está sendo clicada;
      if(direcao=='proximo'){
        valor -=passar;
        //trava o passador quando chegar no final
        if(-valor > limite){          
          valor=-limite;
        }
      }else{
        $boxslides.parent().find('[data-passador]').removeClass('disablePassador');
        valor +=passar;
        //trava o passador quando chegar no inicio
        if(valor>0){
          valor=0;
        }
      }

      //para evitar que seja clicado em qualquer momento quando o script for acionado;
      if(-valor % larguraLi == 0 && valor<=0 || valor==0){
        $containerSlides.stop().animate({
        marginLeft:valor+'px'
        },1000,function(){
            //callback
        });

      }
      //desabilitando a seta ao chegar no final e está no começo;
      if(-valor == limite || valor == 0){
        $self.addClass('disablePassador');
      }else{
        $boxslides.parent().find('[data-passador]').removeClass('disablePassador');
      }
//      lazyloadUpdate();
      //return false - para cancelar o acionamento do link;
      return false;
    });
  /*
   * fim Nova função do bloco multimidia:
   **/
  $(".UlMultimidia li").click(function(){
    $('[data-passador]').removeClass('disablePassador');
//      lazyloadUpdate();
  });
})(jQuery);
function trim(variavel){
  console.log(variavel);
}