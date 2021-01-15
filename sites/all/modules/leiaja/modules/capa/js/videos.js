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
    });     
})(jQuery);
