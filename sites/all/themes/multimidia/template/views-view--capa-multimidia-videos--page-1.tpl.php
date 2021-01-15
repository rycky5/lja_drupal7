<?php
//Template Principal da capa multimidia
?>
<?php

module_load_include('inc', 'capa', 'capa');
$pathTema = path_to_theme('multimidia');

//Chamada da view de videos
$nodesVideos = get_nodes_views('capa_multimidia_videos'); //resultado da views de videos-recentes em cache
$nodesVideosMv = get_nodes_views('capa_multimidia_videos','page_2');
/**
 * Blocos de VIDEOS da capa videos;
 * Todos os blocos deste template devem ter um video atribuído.
 */
//funcao retorna 2 imagens no template block-multi-imagens-dest-II
$video2Img = getTemaBloco($nodesVideos,'block-multi-imagens-dest-II',2);
$arrVideos = $video2Img['array'];

//funcao retorna 4 imagens no template block-multi-img-III
$video4Img = getTemaBloco($arrVideos,'block-multi-img-III',4);
$arrVideos = $video4Img['array'];

//funcao retorna 9 imagens no template block-multi-videos para compor o carrossel.
$carrossel3Videos = getTemaBloco($nodesVideosMv,'block-multi-videos',9);
//$arrVideos = $carrossel3Videos['array'];

//funcao retorna 6 imagens no template block-multi-6-img
$list6img = getTemaBloco($arrVideos,'block-multi-6-img',12);
$arrVideos = $list6img['array'];

?>
<script type="text/javascript" src="/sites/all/modules/leiaja/modules/capa/js/abas.js"></script>
<div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer">
    <!-- slide cromo -->
       <?php print $video2Img['html'];?>
    <!-- /slide cromo -->
    <!-- slide cromo -->
       <?php print $video4Img['html'];?>
    <!-- /slide cromo -->
     </div>
  </div>
</div>   
<div class="divContainerGrande">
  <div class="cnt12">
    <div class="centroContainer">
      <div class="abreBox divisorBoxTop">
      <!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">MAIS VISTOS</h1></div><!-- /abre o box -->
      </div>
        <?php print $carrossel3Videos['html'];?>
    </div>
  </div>
</div>
<div class="divContainerGrande">
  <div class="cnt12">
    <div class="centroContainer">
      <div class="abreBox divisorBoxTop">
        <!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">OUTROS VIDEOS</h1></div><!-- /abre o box -->
      </div>
        <?php print $list6img['html'];?>
      <div class="fechaBox divisorBoxBottom">
        <!-- fecha o box --><div class="wgd12 hgd1"><h1 class="vermelho">&nbsp;</h1></div><!-- /fecha o box -->
      </div>    
    </div>
  </div>
</div>
<!-- /containergrande-->