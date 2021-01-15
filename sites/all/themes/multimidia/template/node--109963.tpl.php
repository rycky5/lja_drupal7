<?php
//Template Principal da capa multimidia
//VERSAO
?>
<?php

drupal_add_js(drupal_get_path('module', 'capa') . '/js/abas.js');
module_load_include('inc', 'capa', 'capa');
$pathTema = path_to_theme('multimidia');

//Chamada das views
$nodesImagens = get_nodes_views('capa_multimidia_imagens'); //resultado da views de imagens em cache
$nodesVideos = get_nodes_views('capa_multimidia_videos'); //resultado da views de videos-recentes em cache
$nodesVideosMv = get_nodes_views('capa_multimidia_videos_mais_vistos'); //resultado da views de videos-mais_vistos em cache
$nodesVideosCmt = get_nodes_views('capa_multimidia_videos_mais_vistos'); //resultado da views de videos-mais-comentados em cache
$nodesPodcasts = get_nodes_views('capa_multimidia_podcasts'); //resultado da views de podcats em cache
// TV LEIA JA
$slideTvleiaja = get_nodes_views('multimidia_tv_leiaja');
$titulos = get_nodes_views('capa_multimidia_titulos'); //resultado da views de títulos em cache

$nodesTvAbas_default = get_nodes_views('capa_multi_tvleiaja_abas','page_11');
$nodesTvAbas_JogoRapido = get_nodes_views('capa_multi_tvleiaja_abas','page_1');
$nodesTvAbas_OpiniaoBrasil = get_nodes_views('capa_multi_tvleiaja_abas','page_2');
$nodesTvAbas_GourmetCasa= get_nodes_views('capa_multi_tvleiaja_abas','page_3');
$nodesTvAbas_ClassLivre= get_nodes_views('capa_multi_tvleiaja_abas','page_4');
$nodesTvAbas_NotaPe= get_nodes_views('capa_multi_tvleiaja_abas','page_5');
$nodesTvAbas_NaSocial= get_nodes_views('capa_multi_tvleiaja_abas','page_6');
$nodesTvAbas_Vencer= get_nodes_views('capa_multi_tvleiaja_abas','page_7');
//-------------------------------------------------------------------

    
/**
 * Blocos da TVLEIAJA da capa
 * A var $arrTvLeiaJa não está sendo utilizada, pois não outras chamadas para essas views nessa pagina
 */
$tvLeiaJaAbas_default = getTemaBloco($nodesTvAbas_default, 'block-multi-tv-bnIV', 4);

$tvLeiaJaAbas_JogoRapido = getTemaBloco($nodesTvAbas_JogoRapido, 'block-multi-tv-bnIV', 4);
//$arrTvLeiaJa = $tvLeiaJaAbas_JogoRapido['array'];

$tvLeiaJaAbas_OpiniaoBrasil = getTemaBloco($nodesTvAbas_OpiniaoBrasil, 'block-multi-tv-bnIV', 4);
//$arrTvLeiaJa = $tvLeiaJaAbas_OpiniaoBrasil['array'];

$tvLeiaJaAbas_GourmetCasa = getTemaBloco($nodesTvAbas_GourmetCasa, 'block-multi-tv-bnIV', 4);
//$arrTvLeiaJa = $nodesTvAbas_GourmetCasa['array'];

$tvLeiaJaAbas_ClassLivre = getTemaBloco($nodesTvAbas_ClassLivre, 'block-multi-tv-bnIV', 4);
//$arrTvLeiaJa = $nodesTvAbas_GourmetCasa['array'];

$tvLeiaJaAbas_NotaPe = getTemaBloco($nodesTvAbas_NotaPe, 'block-multi-tv-bnIV', 4);
//$arrTvLeiaJa = $nodesTvAbas_GourmetCasa['array'];

$tvLeiaJaAbas_NaSocial = getTemaBloco($nodesTvAbas_NaSocial, 'block-multi-tv-bnIV', 4);
//$arrTvLeiaJa = $nodesTvAbas_GourmetCasa['array'];

$tvLeiaJaAbas_Vencer= getTemaBloco($nodesTvAbas_Vencer, 'block-multi-tv-bnIV', 4);
//$arrTvLeiaJa = $nodesTvAbas_GourmetCasa['array'];

//slides tvleiaja
$blocoSlideBnI = getTemaBloco($slideTvleiaja,'block-multi-tv-bnI',4);
$arrSlideTvleiaja = $blocoSlideBnI['array'];

//slide 3D - videos mais vistos.
$slideshow3D = getTemaBloco($arrSlideTvleiaja,'block-multi-tv-bnV',6);
$arrSlideTvleiaja = $slideshow3D['array'];

//-------------------------------------------------------------------
/**
 * Blocos de IMAGENS da capa
 */
//função que retorna um array com o html do tpl do tema setado e o array de resultados da views em cahce restante
$slideshowTopo = getTemaBloco($nodesImagens,'block-multi-dest-slideshow',8); 
$arrImagens = $slideshowTopo['array']; //a partir daqui a variavel usada será a setada

//obsevar a ordem desse
$slideshowImgVertical = getTemaBloco($arrImagens,'block-multi-img-vertical',12);
$arrImagens = $slideshowImgVertical['array'];

//-------------------------------------------------------------------

/**
 * Blocos de VIDEOS da capa
 */
$videoVI_recente = getTemaBloco($nodesVideos,'block-multi-videos',9);
$arrVideos = $videoVI_recente['array'];

$videoVI_mais_visto = getTemaBloco($nodesVideosMv,'block-multi-videos',9);
$arrVideosMv = $videoVI_mais_visto['array'];

$videoVI_mais_comentados = getTemaBloco($nodesVideosCmt,'block-multi-videos',9);
$arrVideosCmt = $videoVI_mais_comentados['array'];

$videosIV = getTemaBloco($arrVideos,'block-multi-videos',6);
$arrVideos = $videosIV['array'];
//-------------------------------------------------------------------

/**
 * Blocos de PODCASTS da capa
 */
$podcast = getTemaBloco($nodesPodcasts,'block-multi-podcast-V',4);
$arrPods = $podcast['array'];
//-------------------------------------------------------------------

/**
 * Blocos de TITULOS da capa
 */
$titulos2 = getTemaBloco($titulos,'block-multi-titulos2',5);
//$arrTitulos = $titulos1['array'];


?>

    <!-- slide cromo -->
       <?php print $slideshowTopo['html'];?>
    <!-- /slide cromo -->
    
    <!-- Esse bloco nao pode ser modulado por causa das abas de videos-->
    <!-- containergrande containerLinha -- TV LEIAJA com abas -->
    <div class="divContainerGrande">
    <div class="cnt12">
        <div class="centroContainer">
             <div class="abreBox divisorBoxTop">
<!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">Programas da Tv LeiaJa</h1></div><!-- /abre o box -->
             </div>
     <!-- box -->
     <div class="boxMenu abas_tv">
        <ul>
            <li style="display:none"><a href="#">JOGO RÁPIDO</a></li>
            <li><a href="#">JOGO RÁPIDO</a></li>
            <li><a href="#">OPINIÃO BRASIL</a></li>
            <li><a href="#">GOUMERT EM CASA</a></li>
            <li><a href="#">CLASSIFICAÇÃO LIVRE</a></li>
            <li><a href="#">NOTA PE</a></li>
            <li><a href="#">NA SOCIAL</a></li>
            <li><a href="#">VENCER (NOVO)</a></li>
       </ul>
     </div>
     <!-- box -->
        <div class="jogo_rapido container_tv_abas"><?php print $tvLeiaJaAbas_default['html'];?> </div>
     <!-- box -->
     <!-- box -->
        <div class="jogo_rapido container_tv_abas"><?php print $tvLeiaJaAbas_JogoRapido['html'];?> </div>
     <!-- box -->
     <!-- box -->
        <div class="opniao_brasil container_tv_abas"><?php print $tvLeiaJaAbas_OpiniaoBrasil['html'];?> </div>
     <!-- box -->
     <!-- box -->
        <div class="gourmet_casa container_tv_abas"><?php print $tvLeiaJaAbas_GourmetCasa['html'];?> </div>
     <!-- box --> 
     <!-- box -->
        <div class="gourmet_casa container_tv_abas"><?php print $tvLeiaJaAbas_ClassLivre['html'];?> </div>
     <!-- box -->
     <!-- box -->
        <div class="gourmet_casa container_tv_abas"><?php print $tvLeiaJaAbas_NotaPe['html'];?> </div>
     <!-- box -->
     <!-- box -->
        <div class="gourmet_casa container_tv_abas"><?php print $tvLeiaJaAbas_NaSocial['html'];?> </div>
     <!-- box -->
     <!-- box -->
        <div class="gourmet_casa container_tv_abas"><?php print $tvLeiaJaAbas_Vencer['html'];?> </div>
     <!-- box -->
      <div class="fechaBox divisorBoxBottom">
        <!-- fecha o box --><div class="wgd12 hgd1"><h1 class="azul">&nbsp;</h1></div><!-- /fecha o box -->
      </div>    
    </div>
  </div>
</div>
    
    <!-- /containergrande containerLinha -->
    
    <!-- containergrande containerLinha -->
	<div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer">
          <div class="abreBox divisorBoxTop">
            <!-- abre o box --><div class="wgd4 hgd1"><h1 class="vermelho">Videos</h1></div><!-- /abre o box -->
            <!-- abre o box --><div class="wgd8 hgd1"><h1 class="vermelho">Podcasts</h1></div><!-- /abre o box -->
          </div>
             <!-- box -->
              <?php print $blocoSlideBnI['html'];?>
             <!-- box -->
             
             <!-- box -->
             <?php print $podcast['html'];?>
             <!-- box -->
             
             <!-- box -->
             <?php print $titulos2['html'];?>
             <!-- box -->      
              <div class="fechaBox divisorBoxBottom">
                <!-- fecha o box --><div class="wgd4 hgd1"><h1 class="azul">&nbsp;</h1></div><!-- /fecha o box -->
                <!-- fecha o box --><div class="wgd8 hgd1"><h1 class="vermelho">&nbsp;</h1></div><!-- /fecha o box -->
              </div>  
        </div>
      </div>
    </div>
    <!-- /containergrande containerLinha -->
    
    <!-- containergrande containerLinha -->
         <!-- slide img verticais -->
          <?php print $slideshowImgVertical['html'];?>
         <!-- /slide img verticais-->
    <!-- /containergrande containerLinha -->
    
    <!-- containergrande containerLinha-->
	<div class="divContainerGrande containerLinha">
      <div class="cnt12">
        <div class="centroContainer">
          <div class="abreBox divisorBoxTop">
            <!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">Mais um box</h1></div><!-- /abre o box -->
          </div>
            <!-- box -->
             <div class="wgd6 hgd8 boxListImg">
             
               <div class="wgd3  hgd4">
                 <a href="#"><img src="/sites/all/themes/multimidia/images/imgList1.png" /></a>
               </div>
               
               <div class="wgd3 hgd4">
                 <a href="#"><img src="/sites/all/themes/multimidia/images/imgList1.png" /></a>
               </div>
               
               <div class="wgd3 hgd4">
                 <a href="#"><img src="/sites/all/themes/multimidia/images/imgList1.png" /></a>
               </div>
               
               <div class="wgd3 hgd4">
                 <a href="#"><img src="/sites/all/themes/multimidia/images/imgList1.png" /></a>
               </div>
               
             </div>
             <!-- /box -->
            <!-- box -->
             <div class="wgd6 hgd8  boxListImg">
             
               <div class="wgd6  hgd4">
                 <a href="#"><img src="/sites/all/themes/multimidia/images/imgList2.png" /></a>
               </div>
               
               <div class="wgd6 hgd4">
                 <a href="#"><img src="/sites/all/themes/multimidia/images/imgList2.png" /></a>
               </div>
               
             </div>
             <!-- /box -->      
          <div class="fechaBox divisorBoxBottom">
            <!-- fecha o box --><div class="wgd12 hgd1"><h1 class="vermelho">&nbsp;</h1></div><!-- /fecha o box -->
          </div>    
        </div>
      </div>
    </div>
    <!-- /containergrande containerLinha-->
           <!-- BOX -->
           <!-- slide 3D -->
              <?php print $slideshow3D['html'];?>
             <!-- /slide 3D-->
           <!--/BOX-->
    <!-- Esse bloco nao pode ser modulado por causa das abas de videos-->
    <!-- containergrande-->
    <div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer">
          <div class="abreBox divisorBoxTop">
            <!-- abre o box --><div class="wgd12 hgd1"><h1 class="azul">Vídeos recentes, mais vistos e comentados</h1></div><!-- /abre o box -->
          </div>
           <!-- BOX - Bloco de Videos VI -->
           
           <div class="abas_videos boxMenu"><ul><li><a href="#">Recentes</a></li><li><a href="#">+Vistos</a></li><li><a href="#">+Comentados</a></li></ul></div>
            <div class="recentes containerVideos"><?php print $videoVI_recente['html'];?></div>
            <div class="mais_vistos containerVideos"><?php print $videoVI_mais_visto['html'];?></div>
            <div class="mais_comentados containerVideos"><?php print $videoVI_mais_comentados['html'];?></div>
           <!-- BOX -->   
          <div class="fechaBox divisorBoxBottom">
            <!-- fecha o box --><div class="wgd12 hgd1"><h1 class="azul">&nbsp;</h1></div><!-- /fecha o box -->
          </div>  
        </div>
      </div>
    </div>
    <!-- /containergrande-->