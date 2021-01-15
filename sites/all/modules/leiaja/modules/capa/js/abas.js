// Função para abas de videos
(function($){
    $(document).ready(function(){      
        $(".containerVideos").hide();
        $(".containerVideos").eq(0).show();
        //console.log('tah acessando o arq');
        $('.abas_videos a').click(function(){            
            indice = $('.abas_videos a').index($(this));
            if(!$(this).hasClass('ativo')){
                $(".containerVideos").hide();
                $(".containerVideos").eq(indice).fadeIn(1500);
                $('.abas_videos a').removeClass('ativo');
                $(this).addClass("ativo");  
            }            
            return false;
        });
        $('[data-passador]').click(function(){
          $self=$(this);
          direcao = $self.attr('data-passador');
          $boxslides  = $self.parent();
          $containerSlides  = $boxslides.find('ul');
//          console.log($containerSlides);
          //pegando o valor com base no $containerSlides - usado para dinamizar o passador e não afetar nos outros slides na pagina;
          valor = parseInt($containerSlides.css('marginLeft').replace('px',''));
          //pegando o tamanho do box para saber se tem 1, 2 ou 3 elementos visiveis;
          boxslidesWidth  = $boxslides.width();
          //qtdItensList no slide;
          qtdItensList = $containerSlides.find('li').length;
          //guardando a largura de cada item da lista <li>;
          larguraLi = $containerSlides.find('li').width();
          
          //largura da <ul> deve ser o tamanho das <li>*qtd de <li> na lista;
          larguraUl = qtdItensList*larguraLi;
          $containerSlides.width(larguraUl);
          
          //verifica o tamanho do box e seta o intervalo a ser passado por click com a qtd de box visiveis;
          if(boxslidesWidth <= 400){
            visivel=1;            
          }else if(boxslidesWidth > 700){
            visivel=3;
          }else{
            visivel=2;
          }
          //largura do passar
          passar=larguraLi*visivel;
          
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

          //desabilitando a seta ao chegar no final;
          if(-valor == limite){
            $self.addClass('disablePassador');
          }else{
            $boxslides.parent().find('[data-passador]').removeClass('disablePassador');
          }
          //return false - para cancelar o acionamento do link;
          return false;
        });
    }); //document(ready)
})(jQuery);


// Função para as abas de programas da TV LEIAJA
(function($){
    $(document).ready(function(){  
        $(".container_tv_abas").hide();
        $(".container_tv_abas").eq(0).show();
        //console.log('tah acessando o arq');
        $('.abas_tv a').click(function(){   
            indice = $('.abas_tv a').index($(this));
            if(!$(this).hasClass('ativo')){
                $(".container_tv_abas").hide();
                $(".container_tv_abas").eq(indice).fadeIn(1500,function(){
                  lazyloadUpdate();
                });
                $('.abas_tv a').removeClass('ativo');
                $(this).addClass("ativo");  
            }            
            return false;
        });
      }); //document(ready)
})(jQuery);  


