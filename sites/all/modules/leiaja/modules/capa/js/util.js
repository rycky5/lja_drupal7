(function ($) {
//slideshow:
  $(".paginacao a").click(function(e){    
    self=$(this);    
    parent=self.parents(".paginacao");
    slider =self.parents(".container-slideshow").find(".slider");
    console.log(slider);
    indice=parent.find("a")
           .removeClass("ativo")
           .index(self);
    //adicionando a class ativo ao elemento.
    $(this).addClass("ativo");
    
    //bloco para animar
    slider.animate({
    marginLeft:"-"+(indice*100)+"%"
  
    },500,function(){
      //lazyload atualizando img vistas.
      lazyloadUpdate();
    });
    return false;
  });
  $(".slide").hover(function(){    
    $(this).find(".lermais").hide();
    $(this).find("h1,p").fadeIn();
    $(this).find(".conteudo").stop().animate({
      marginTop:"0px"
    },500,function(){      
    });        
  },function(){
    $(this).find(".conteudo").stop().animate({
      marginTop:"-70px"
    },500,function(){
      $(this).find(".lermais").fadeIn();
      $(this).find("h1,p").hide();
    });
  });
  
    //bloco podcasts
    function mostraEmbed(strIdVideo){
        
        // cria tag para embed do samba player 
        var sambaPlayerScript = document.createElement('script'); 
        sambaPlayerScript.type = 'text/javascript'; 
        sambaPlayerScript.src = 'http://player.sambatech.com.br/current/samba-player.js?playerWidth=280&playerHeight=50&ph=5fbc59e8b8b00ec07528a1a61ea38524&m=' + strIdVideo + '&autoStart=true';
        
        
        // Recuperando o local do vídeo
        var div = document.getElementById('playerPodcast');
        // limpa conteudo anterior 
        div.innerHTML = '';
        // adiciona novo script do player 
        div.appendChild(sambaPlayerScript);
    }
    $('[data_id]').click(function(){
      id  = $(this).attr('data_id');
      mostraEmbed(id);
      elemClicado       = $(this).parents('li');
      elemClicado_clone = elemClicado.clone();
      
      //player em exibição:
      playerExibicao  = $(".playerExibicao");
      chapeu  =  playerExibicao.find('.chapeu a');
      titulo  =  playerExibicao.find('.titvideo a');
      
      //chapeu
      elemClicado_clone.find('.chapeu').html(chapeu).hide().fadeIn();
      //titulo
      elemClicado_clone.find('.titvideo').html(titulo).hide().fadeIn();
      
      //setando o elemento clicado ao player
      clicadoChapeu = elemClicado.find('.chapeu a');
      clicadoTitulo = elemClicado.find('.titvideo a');
      playerExibicao.find('.chapeu').html(clicadoChapeu).hide().fadeIn();
      playerExibicao.find('.titvideo').html(clicadoTitulo).hide().fadeIn();
      
      elemClicado.after(elemClicado_clone).remove();
      
    });
})(jQuery);
