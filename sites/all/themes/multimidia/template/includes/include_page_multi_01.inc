<?php

//Chamada das views
$nodesImagens = get_nodes_views('capa_multimidia_imagens'); //resultado da views de imagens em cache

// Vídeos
$nodesVideos = get_nodes_views('capa_multimidia_videos','page_1'); //resultado da views de videos-recentes em cache
$nodesVideosMv = get_nodes_views('capa_multimidia_videos','page_2'); //resultado da views de videos-mais_vistos em cache
$nodesVideosCmt = get_nodes_views('capa_multimidia_videos','page_3'); //resultado da views de videos-mais-comentados em cache
$nodesVideosShare = get_nodes_views('capa_multimidia_videos','page_4'); //resultado da views de videos-mais-comentados em cache

// PodCast
$nodesPodcasts = get_nodes_views('capa_multimidia_podcasts'); //resultado da views de podcats em cache

// TV LEIA JA
$titulos = get_nodes_views('capa_multimidia_titulos'); //resultado da views de títulos em cache
$maisCompartilhados = get_nodes_views('capa_multimidia_titulos','page_1'); //resultado da views de títulos em cache

$slideTvleiaja3D = get_nodes_views('multimidia_tv_leiaja','page_10');
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


//slide 3D - videos mais vistos.
$slideshow3D = getTemaBloco($slideTvleiaja3D,'block-multi-tv-bnV',6);
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
//slides tvleiaja
$blocoSlideBnI = getTemaBloco($nodesVideos,'block-multi-tv-bnI',4);
$arrVideos = $blocoSlideBnI['array'];

$strVideosMaisVisto = getTemaBloco($nodesVideosMv,'block-multi-videos',9);
$arrVideos = $videoVI_recente['array'];

$strVideosMaisComentados = getTemaBloco($nodesVideosCmt,'block-multi-videos',9);
$arrVideosMv = $videoVI_mais_visto['array'];

$strVideosMaisCompartilhados = getTemaBloco($nodesVideosShare,'block-multi-videos',9);

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
$titulos2 = getTemaBloco($maisCompartilhados,'block-multi-titulos2',5);
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
<!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">Tv LeiaJa</h1></div><!-- /abre o box -->
         </div>
 <!-- box -->
 <div class="boxMenu abas_tv">
    <ul>
        <li style="display:none"><a href="#">DEFAULT</a></li>
        <li><a href="#">JOGO RÁPIDO</a></li>
        <li><a href="#">OPINIÃO BRASIL</a></li>
        <li><a href="#">GOUMERT EM CASA</a></li>
        <li><a href="#">CLASSIFICAÇÃO LIVRE</a></li>
        <li><a href="#">NOTA PE</a></li>
        <li><a href="#">NA SOCIAL</a></li>
        <li><a href="#">VENCER</a></li>
   </ul>
 </div>
 <!-- box -->
        <div class="default container_tv_abas"><?php print $tvLeiaJaAbas_default['html'];?> </div>
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
    <div class="classLivre container_tv_abas"><?php print $tvLeiaJaAbas_ClassLivre['html'];?> </div>
 <!-- box -->
 <!-- box -->
    <div class="notaPe container_tv_abas"><?php print $tvLeiaJaAbas_NotaPe['html'];?> </div>
 <!-- box -->
 <!-- box -->
    <div class="naSocial container_tv_abas"><?php print $tvLeiaJaAbas_NaSocial['html'];?> </div>
 <!-- box -->
 <!-- box -->
    <div class="vencer container_tv_abas"><?php print $tvLeiaJaAbas_Vencer['html'];?> </div>
 <!-- box -->
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
        <!-- abre o box --><div class="wgd4 hgd1"><h1 class="vermelho">Podcasts</h1></div><!-- /abre o box -->
        <!-- abre o box --><div class="wgd4 hgd1"><h1 class="vermelho">MAIS ACESSADOS</h1></div><!-- /abre o box -->
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
    </div>
  </div>
</div>
<!-- /containergrande containerLinha -->

<!-- containergrande containerLinha -->
<div class="divContainerGrande containerLinha bbn">
    <div class="cnt12">
      <div class="centroContainer">
        <div class="abreBox divisorBoxTop">
          <!-- abre o box --><div class="wgd12 hgd1"><h1 class="azul">IMAGENS</h1></div><!-- /abre o box -->
        </div>
         <!-- box -->
     <!-- slide img verticais -->
      <?php print $slideshowImgVertical['html'];?>
     <!-- /slide img verticais-->
     <!-- /box -->
        </div>
      </div>
    </div>
<!-- /containergrande containerLinha -->

<!-- containergrande containerLinha-->
<div class="divContainerGrande">
  <div class="cnt12">
    <div class="centroContainer">
      <div class="abreBox divisorBoxTop">
        <!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">BLOGS</h1></div><!-- /abre o box -->
      </div>
        <!-- box -->
         <div class="wgd8 hgd4 boxListImg">

           <div class="wgd2  hgd4">
             <a href="http://hallsocial.leiaja.com"><img src="http://static1.leiaja.com/sites/all/themes/multimidia/images/blog_hallsocial.jpg" /></a>
           </div>

           <div class="wgd2 hgd4">
             <a href="/blogs/esportes"><img src="http://static1.leiaja.com/sites/all/themes/multimidia/images/blog_jogadarapida.jpg" /></a>
           </div>

           <div class="wgd2 hgd4">
             <a href="/blogs/carreiras"><img src="http://static1.leiaja.com/sites/all/themes/multimidia/images/blog_networking.jpg" /></a>
           </div>

           <div class="wgd2 hgd4">
             <a href="/blogs/cultura"><img src="http://static1.leiaja.com/sites/all/themes/multimidia/images/blog_nograu.jpg" /></a>
           </div>

         </div>
         <!-- /box -->
        <!-- box -->
         <div class="wgd4 hgd4 divBanner300x100">
           <div class="wgd4 hgd4" style="">
            <span>PUBLICIDADE</span>
             <?=render(getBlocos(array('34')));?>
           </div>
         </div>
         <!-- /box -->      
    </div>
  </div>
</div>

<!-- /containergrande containerLinha-->
<div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer containerBox3d">
          <div class="abreBox divisorBoxTop">
            <!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">DESTAQUES TV LEIAJA</h1></div><!-- /abre o box -->
          </div>
       <!-- BOX -->
       <!-- slide 3D -->
          <?php print $slideshow3D['html'];?>
         <!-- /slide 3D-->
       <!--/BOX-->
        </div>
    </div>
</div>
<!-- Esse bloco nao pode ser modulado por causa das abas de videos-->
<!-- containergrande-->
<div class="divContainerGrande">
  <div class="cnt12">
    <div class="centroContainer">
      <div class="abreBox divisorBoxTop">
        <!-- abre o box --><div class="wgd12 hgd1"><h1 class="azul">VIDEOS</h1></div><!-- /abre o box -->
      </div>
       <!-- BOX - Bloco de Videos VI -->

       <div class="abas_videos boxMenu">
         <ul>
           <li>
             <a href="#">+Vistos</a>
           </li>
           <li>
             <a href="#">+Comentados</a>
           </li>
           <li>
             <a href="#">+Compartilhadas</a>
           </li>
         </ul>
       </div>
      <div class="mais_vistos containerVideos"><?php print $strVideosMaisVisto['html'];?></div>
      <div class="recentes containerVideos"><?php print $strVideosMaisComentados['html'];?></div>
      <div class="mais_comentados containerVideos"><?php print $strVideosMaisCompartilhados['html'];?></div>
       <!-- BOX -->   
    </div>
  </div>
</div>
<!-- /containergrande-->