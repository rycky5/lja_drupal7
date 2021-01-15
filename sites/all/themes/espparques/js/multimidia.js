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
  $("#aTvAvanca").bind("click",function(){
   galeriaAvanca("Tv");
  });

  $("#aTvVolta").bind("click",function(){
	galeriaVoltar("Tv");
  });  

  // Podcast
  $("#aPodcastAvanca").bind("click",function(){
    galeriaAvanca("Podcast");
  });

  $("#aPodcastVolta").bind("click",function(){
    galeriaVoltar("Podcast");
  });

  // Funcao genérica para controle do botão Avançar.
  galeriaAvanca = function(pBloco){
    //$("#divCarregando").show();
	eval("vPosicao = vMM"+pBloco+".length+1;");
	eval("vArrTmp = vMM"+pBloco+".length-1;");
	//alert('Cursor:'+vMMCursor+' | Array:'+(vMMVideo.length-1));
	eval("vCursorTmp = vMMCursor"+pBloco+";"); 
	
	if(vCursorTmp < vArrTmp){
	  eval("vMMCursor"+pBloco+"++;");  
      moveGaleria(pBloco);
	}else{
		eval("$.getJSON('multimidia/ajax/?posicao='+vPosicao+'&tipo="+pBloco+"', function(pRetorno){ \
	    if(pRetorno){ \
	    	  vMM"+pBloco+".push(pRetorno); \
	    	  vMMCursor"+pBloco+"++; \
	    	  moveGaleria('"+pBloco+"'); \
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
	  

	  $("#divMnuBlk"+vId+" [rel='img4']").attr('src',vArrTemp[vCursorAtivo].thumbPeq);
	  $("#divMnuBlk"+vId+" [rel='a4']").attr('href',vArrTemp[vCursorAtivo].link);	  
	  $("#divMnuBlk"+vId+" [rel='aTitulo4']").text(vArrTemp[vCursorAtivo].titulo);	  
	  $("#divMnuBlk"+vId+" [rel='strongTag4']").text(vArrTemp[vCursorAtivo].tag);	  
	  $("#divMnuBlk"+vId+" [rel='spanCount4']").text("Views "+vArrTemp[vCursorAtivo].views);	  
	  //$("#divMnuBlkVideo [rel='img4']").onComplete = function(loaded){ alert('teste'); };
	  
	  $("#divMnuBlk"+vId+" [rel='img3']").attr('src',vArrTemp[vCursorAtivo-1].thumbPeq);
	  $("#divMnuBlk"+vId+" [rel='a3']").attr('href',vArrTemp[vCursorAtivo-1].link);
	  $("#divMnuBlk"+vId+" [rel='aTitulo3']").text(vArrTemp[vCursorAtivo-1].titulo);
	  $("#divMnuBlk"+vId+" [rel='strongTag3']").text(vArrTemp[vCursorAtivo-1].tag);	  
	  $("#divMnuBlk"+vId+" [rel='spanCount3']").text("Views "+vArrTemp[vCursorAtivo-1].views);	  

	  $("#divMnuBlk"+vId+" [rel='img2']").attr('src',vArrTemp[vCursorAtivo-2].thumbPeq);
	  $("#divMnuBlk"+vId+" [rel='a2']").attr('href',vArrTemp[vCursorAtivo-2].link);
	  $("#divMnuBlk"+vId+" [rel='aTitulo2']").text(vArrTemp[vCursorAtivo-2].titulo);
	  $("#divMnuBlk"+vId+" [rel='strongTag2']").text(vArrTemp[vCursorAtivo-2].tag);	  
	  $("#divMnuBlk"+vId+" [rel='spanCount2']").text("Views "+vArrTemp[vCursorAtivo-2].views);	  

	  $("#divMnuBlk"+vId+" [rel='img1']").attr('src',vArrTemp[vCursorAtivo-3].thumbGrd);
	  $("#divMnuBlk"+vId+" [rel='a1']").attr('href',vArrTemp[vCursorAtivo-3].link);
	  $("#divMnuBlk"+vId+" [rel='aTitulo1']").text(vArrTemp[vCursorAtivo-3].titulo);
	  $("#divMnuBlk"+vId+" [rel='strongTag1']").text(vArrTemp[vCursorAtivo-3].tag);	  
	  $("#divMnuBlk"+vId+" [rel='spanCount1']").text("Views "+vArrTemp[vCursorAtivo-3].views);	  
  };
})(jQuery);